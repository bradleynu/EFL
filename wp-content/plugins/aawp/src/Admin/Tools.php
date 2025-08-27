<?php

namespace AAWP\Admin;

/** Logs is outside of the current namespace. So, import them.*/
use AAWP\ActivityLogs\ListTable as LogsTable;

/**
 * Tools of the plugin.
 *
 * @since 3.20.0
 */
class Tools {

	/**
	 * Initialize tools class.
	 *
	 * @since 3.20.0
	 */
	public function init() {
		add_action( 'aawp_admin_menu', array( $this, 'add_tools_submenu' ), 60 );
		add_action( 'admin_init', array( $this, 'load_as' ), 20 );
		add_action( 'admin_init', array( $this, 'process_callback' ) );
		add_action( 'admin_notices', array( $this, 'notice' ) );
	}

	/**
	 * Additionally required because AS logger, store etc. should be loaded in "admin_init".
	 *
	 * @since 3.20.0
	 */
	public function load_as() {

		if ( empty( $_GET['tab'] ) || empty( $_GET['page'] ) || 'aawp-tools' !== $_GET['page'] || 'scheduled-actions' !== $_GET['tab'] ) {
			return;
		}

		new Tools\ScheduledActions();
	}

	/**
	 * Add Tools Submenu in the AAWP Menu.
	 *
	 * @param string $menu_slug Menu slug: "aawp".
	 *
	 * @since 3.20.0
	 */
	public function add_tools_submenu( $menu_slug ) {
		add_submenu_page(
			$menu_slug,
			esc_html__( 'AAWP - Tools', 'aawp' ),
			esc_html__( 'Tools', 'aawp' ),
			'edit_pages',
			'aawp-tools',
			array( $this, 'render_tools_page' )
		);
	}

	/**
	 * Render tools page. Add logs, support, etc. pages.
	 *
	 * @since 3.20.0
	 */
	public function render_tools_page() { //phpcs:ignore Generic.Metrics.CyclomaticComplexity.TooHigh

		$pages = apply_filters(
			'aawp_tools_pages',
			array(
				'general'           => __( 'General', 'aawp' ),
				'migrations'        => __( 'Migrations', 'aawp' ),
				'logs'              => __( 'Logs', 'aawp' ),
				'scheduled-actions' => __( 'Scheduled Actions', 'aawp' ),
				'system_info'		=> __( 'System Info', 'aawp' )
			)
		);

		ob_start();
		?>
			<div class="wrap aawp-wrap">
				<h2>
					<?php esc_html_e( 'Tools', 'aawp' ); ?>
				</h2>
				<nav class="nav-tab-wrapper">
					<?php
					foreach ( $pages as $key => $page ) {

						if ( 'system_info' === $key ) {
							echo '<a href="' . esc_url( admin_url( 'site-health.php?tab=debug&aawp=filter' ) ) . ' " class="nav-tab" >' . esc_html( $page ) . '</a>';
						} else {

						echo '<a href="' . esc_url( admin_url( 'admin.php?page=aawp-tools&tab=' . $key ) ) . ( 'scheduled-actions' === $key ? '&s=aawp_' : '' ) . '"
										class="nav-tab ' . ( isset( $_GET['tab'] ) && $key === $_GET['tab'] || ( ! isset( $_GET['tab'] ) && 'general' === $key ) ? 'nav-tab-active' : '' ) . '"
									>'
								. esc_html( $page ) .
							'</a>';
						}
					}
					?>
				</nav>
			</div>
		<?php

		echo ob_get_clean(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		// The default page is General.
		if ( isset( $_GET['tab'] ) && 'general' !== wp_unslash( $_GET['tab'] ) ) { // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized

			switch ( wp_unslash( $_GET['tab'] ) ) { //phpcs:ignore
				case 'logs':    // Because logs is outside of the current namespace, other tabs should be within the "Tools" namespace.
						( new \AAWP\ActivityLogs\Settings() )->render_page();
						( new LogsTable( new \AAWP\ActivityLogs\DB() ) )->render_page();

					return;
					break;

				case 'scheduled-actions':
					( new Tools\ScheduledActions() )->render_page();
					return;
				break;

				case 'migrations':
					( new Tools\Migrations() )->render_page();
					return;
				break;
			}
		} else {

			// The default page is General.
			( new \AAWP\Admin\Tools\General() )->render_page();
		}//end if
	}

	/**
	 * Process Callback for tools actions, "General" & "Migrations".
	 *
	 * @since 3.32.0
	 */
	public function process_callback() {

		// Check if it's requests we're looking for.
		if ( ! isset( $_POST['aawp_tool'] ) || ! isset( $_POST['aawp_tools_nonce'] ) ) {
			return;
		}

		// Check nonce.
		if ( ! wp_verify_nonce( $_POST['aawp_tools_nonce'], 'aawp_tools_nonce' ) ) {
			return;
		}

		// Capabilitity check.
		if ( ! aawp_is_user_admin() ) {
			return;
		}

		$tool = wp_unslash( $_POST['aawp_tool'] );

		do_action( 'aawp_tools_process', $tool );

		$tools = get_option( 'aawp_tools', array() );

		switch ( $tool ) {
			case 'create_db_tables':
				aawp_reset_database();
				break;
			case 'remove_products':
				aawp_empty_database_tables();
				break;
			case 'reset_settings':
				aawp_reset();
				break;
			case 'sitestripe_migration':
				as_enqueue_async_action( 'aawp_process_site_stripe_migration', [], 'aawp' );
				break;
			case 'uninstall_aawp':
				$tools['uninstall_aawp'] = isset( $_POST['uninstall_aawp'] );
				break;
			case 'deactivate_as':
				$tools['deactivate_as'] = isset( $_POST['deactivate_as'] );
				break;
		}

		update_option( 'aawp_tools', $tools );

		$current_url = esc_url_raw( add_query_arg( 'action', $tool, $_SERVER['REQUEST_URI'] ) );
		wp_safe_redirect( $current_url );
		exit;
	}

	/**
	 * Admin notice to notify that the tool is processing.
	 *
	 * @since 3.32.0
	 */
	public function notice() {

		if ( empty( $_GET['page'] ) || 'aawp-tools' !== $_GET['page'] || empty( $_GET['action'] ) ) {
			return;
		}

		$action = sanitize_text_field( wp_unslash( $_GET['action'] ) );

		switch ( $action ) {
			case 'create_db_tables':
				$message = __( 'Database Tables Created.', 'aawp' );
				break;
			case 'remove_products':
				$message = __( 'All products and lists are removed from the database.', 'aawp' );
				break;
			case 'sitestripe_migration':
				$message = __( 'Site Stripe Migration is processing in the background. This might take some minutes.', 'aawp' );
				break;
			default:
				$message = esc_html__( 'Changes saved.', 'aawp' );
		}

		echo '<div class="notice notice-success is-dismissible"><p>' . esc_html( $message ) . '</p></div>';
	}
}
