<?php

namespace AAWP\ClickTracking;

/**
 * The Export functionality of Click Tracking.
 *
 * @since 3.31.0
 */
class Export {

	/**
	 * Initialize the CSV export.
	 *
	 * @since 3.31.0
	 */
	public function init() {

		add_action( 'aawp_clicks_listtable_init', array( $this, 'process_export' ) );
	}

	/**
	 * Render the Export page.
	 *
	 * @since 3.31.0
	 */
	public function render_page() {

		global $listtable;

		if ( $listtable->get_total() === 0 ) {
			echo esc_html__( 'No clicks data to export.', 'aawp' );
			return;
		}

		?>
			<div class="aawp-setting-row tools">
			<h2><?php esc_html_e( 'Export Clicks Statistics', 'aawp' ); ?></h2>
			<p><?php esc_html_e( 'Select the data you would like to include in the CSV Export. You can also define tracking ID and date filters to further personalize the list of data you want to retrieve.', 'aawp' ); ?></p>

			<form method="post" action="<?php echo esc_url( admin_url( 'admin.php?page=aawp-clicks&section=export' ) ); ?>" id="aawp-tools-clicks-export">
				<input type="hidden" name="action" value="aawp_clicks_export">
				<?php
					wp_nonce_field( 'aawp-clicks-export-nonce', 'nonce' );
				?>
			<section class="wp-clearfix" id="aawp-clicks-export-options-data">
				<h3><?php esc_html_e( 'Tracking ID', 'aawp' ); ?></h3>

				<div id="aawp-clicks-export-tracking-id-checkboxes">
					<?php $this->render_tracking_ids(); ?>
				</div>
			</section>

			<section class="wp-clearfix" id="aawp-clicks-export-options-data">
				<h3><?php esc_html_e( 'Data', 'aawp' ); ?></h3>

				<div id="aawp-clicks-export-data-checkboxes">
					<?php $this->render_export_data(); ?>
				</div>
			</section>

			<section class="wp-clearfix" id="aawp-clicks-export-options-date">
				<h3><?php esc_html_e( 'Date Range', 'aawp' ); ?></h3>
				<p><?php esc_html_e( 'Leave date fields empty to export all dates.', 'aawp' ); ?></p>
				
				<div class="aawp-clicks-date-range-filter">
					<b><?php esc_html_e( 'Start date', 'aawp' ); ?></b>
						<input class="filter-dates" placeholder="<?php esc_attr_e( 'Start date', 'aawp' ); ?>" name="start_date" id="start-date" type="date" />
					<br/><br/>
					<b><?php esc_html_e( 'End date', 'aawp' ); ?></b>
					<input class="filter-dates" placeholder="<?php esc_attr_e( 'End date', 'aawp' ); ?>" name="end_date" id="end-date" type="date" />
				</div> 
			</section>
			<br/><br/>
			<section class="wp-clearfix">
				<button type="submit" name="submit-clicks-export" id="aawp-clicks-export-submit"
					class="button button-secondary">
					<?php esc_html_e( 'Download Export File', 'aawp' ); ?>
				</button>
			</section>
	</form>
	</div>
		<?php
	}

	/**
	 * Render Tracking IDs checkboxes.
	 *
	 * @since 3.31.0
	 */
	public function render_tracking_ids() {
		$class = new Init();
		// @todo::make this class global or something efficient.
		$tracking_ids = $class->get_filter_options();

		unset( $tracking_ids[0] );

		foreach ( $tracking_ids as $tracking_id ) {
			?>
				<label style="line-height:2">
					<input type="checkbox" id="tracking_id" name="tracking_id[]" value="<?php echo esc_html( $tracking_id ); ?>" checked />
					<?php echo esc_html( $tracking_id ); ?>
				</label><br>
			<?php
		}
	}

	/**
	 * Render export data.
	 *
	 * @since 3.31.0
	 */
	public function render_export_data() {
		global $listtable;

		$options = $listtable->get_columns();

		$options['is_widget'] = esc_html__( 'Is Widget?', 'aawp' );

		unset( $options['preview'] );

		$unchecked = array( 'browser', 'os', 'device', 'is_widget' );

		foreach ( $options as $key => $value ) {
			?>
			<label style="line-height:2">
					<input type="checkbox" id="tracking_id" name="data[]" value="<?php echo esc_html( $key ); ?>" <?php echo ! in_array( $key, $unchecked ) ? 'checked' : ''; //phpcs:ignore WordPress.PHP.StrictInArray.MissingTrueStrict ?> />
					<?php echo esc_html( $value ); ?>
			</label><br>
			<?php
		}
	}

	/**
	 * The export functionality.
	 *
	 * @param $listtable An instance of the The ListTable class.
	 *
	 * @since 3.31.0
	 */
	public function process_export( $listtable ) { //phpcs:ignore Generic.Arrays.DisallowLongArraySyntax.Found, Generic.Metrics.CyclomaticComplexity.MaxExceeded, Generic.Metrics.NestingLevel.MaxExceeded

		// Check current page.
		if ( empty( $_POST['action'] ) || 'aawp_clicks_export' !== $_POST['action'] ) {
			return;
		}

		// Capability check.
		if ( ! aawp_is_user_editor() ) {
			return;
		}

		// Nonce check.
		if ( empty( $_POST['data'] ) || empty( $_POST['tracking_id'] ) || empty( $_REQUEST['nonce'] ) || ! wp_verify_nonce( wp_unslash( $_REQUEST['nonce'] ), 'aawp-clicks-export-nonce' ) ) {
			return;
		}

		$data         = array_map( 'wp_unslash', $_POST['data'] );
		$data         = array_map( 'sanitize_text_field', $_POST['data'] );
		$tracking_ids = array_map( 'wp_unslash', $_POST['tracking_id'] );
		$tracking_ids = array_map( 'sanitize_text_field', $_POST['tracking_id'] );
		$start_date   = ! empty( $_POST['start_date'] ) ? sanitize_text_field( wp_unslash( $_POST['start_date'] ) ) : '';
		$end_date     = ! empty( $_POST['end_date'] ) ? sanitize_text_field( wp_unslash( $_POST['end_date'] ) ) : '';

		$db_results = $this->db_results( $tracking_ids, $start_date, $end_date );

		$columns              = $listtable->get_columns();
		$columns['is_widget'] = esc_html__( 'Is Widget?', 'aawp' );

		$csv_columns = array();

		foreach ( $columns as $key => $column ) {
			if ( in_array( $key, $data, true ) ) {
				$csv_columns[] = $column;
			}
		}

		/**
		 * Rows Format.
		 *
		 *   $rows = array(
		 *      array('John', 'Doe', 'john@example.com'),
		 *      array('Jane', 'Smith', 'jane@example.com'),
		 *      // More rows...
		 *   );
		 */

		ignore_user_abort( true );

		// Set time limit.
		if ( function_exists( 'set_time_limit' ) && false === strpos( ini_get( 'disable_functions' ), 'set_time_limit' ) && ! ini_get( 'safe_mode' ) ) { // phpcs:ignore PHPCompatibility.IniDirectives.RemovedIniDirectives.safe_modeDeprecatedRemoved
			@set_time_limit(0); // @codingStandardsIgnoreLine
		}

		if ( ob_get_contents() ) {
			ob_clean();
		}

		$filename = 'aawp-clicks-' . date( 'Y-m-d' ) . '.csv';

		// Force download.
		header( 'Content-Type: application/force-download' );
		header( 'Content-Type: application/octet-stream' );
		header( 'Content-Type: application/download' );

		// Disposition / Encoding on response body.
		header( "Content-Disposition: attachment;filename=\"{$filename}\";charset=utf-8" );
		header( 'Content-Transfer-Encoding: binary' );

		$output = fopen( 'php://output', 'w' );

		// Handle UTF-8 chars conversion for CSV.
		fprintf( $output, chr( 0xEF ) . chr( 0xBB ) . chr( 0xBF ) );

		fputcsv( $output, $csv_columns );

		foreach ( $db_results as $result ) {
			$product = aawp_get_product( $result->product_id );

			$row_data = array();

			foreach ( $data as $column ) {
				if ( property_exists( $result, $column ) ) {
					$row_data[] = $result->$column;
				} else {
					switch ( $column ) {
						case 'asin':
							$row_data[] = ! empty( $product['asin'] ) ? $product['asin'] : '-';
							break;
						case 'title':
							$row_data[] = ! empty( $product['title'] ) ? $product['title'] : '-';
							break;
						case 'link':
							$url        = ! empty( $product['url'] ) ? aawp_replace_url_tracking_id_placeholder( $product['url'], $result->tracking_id, false ) : '';
							$row_data[] = esc_url( $url );
							break;
						case 'source':
							$source     = $listtable->get_source( $result->source_type, absint( $result->source_id ) );
							$row_data[] = ! empty( $source['title'] ) ? $source['title'] : '';
							break;
						default:
							$row_data[] = '';
					}
				}
			}

			fputcsv( $output, $row_data );
		}

		fclose( $output );
		exit;
	}

	/**
	 * Get db results by tracking id and dates.
	 *
	 * @param array  $tracking_ids An array of tracking ids.
	 * @param string $start_date    Filter db results by startdate.
	 * @param string $end_date      Filter db results by enddate.
	 *
	 * @since 3.31.0
	 *
	 * @return array The db results
	 */
	public function db_results( $tracking_ids, $start_date, $end_date ) {

		global $wpdb;

		$tracking_ids = "'" . implode( "', '", $tracking_ids ) . "'";

		$where = '';

		if ( ! empty( $start_date ) ) {
			$where .= $wpdb->prepare( ' AND DATE( created_at ) >= %s', $start_date );
		}

		if ( ! empty( $end_date ) ) {
			$where .= $wpdb->prepare( ' AND DATE( created_at ) <= %s', $end_date );
		}

		$query_items = "SELECT * FROM {$wpdb->prefix}aawp_clicks WHERE tracking_id IN ($tracking_ids) $where"; //phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.DirectQuery

		return $wpdb->get_results( $query_items ); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.DirectQuery
	}
}