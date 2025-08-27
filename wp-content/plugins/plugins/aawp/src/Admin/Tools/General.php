<?php

namespace AAWP\Admin\Tools;

/**
 * General Tools Page.
 *
 * @since 3.32.0
 */
class General {

	/**
	 * Init.
	 *
	 * @since 3.32.0
	 */
	public function render_page() {

		$uninstall = array(
			'heading'     => __( 'Complete Cleanup', 'aawp' ),
			'tagline'     => __( 'Ensure a clean slate by removing all plugin data during uninstallation.', 'aawp' ),
			'label'       => __( 'Uninstall AAWP', 'aawp' ),
			'value'       => 'uninstall_aawp',
			'description' => __( 'Check if you want to remove all plugin data when uninstalling the plugin.', 'aawp' ),
		);

		$reset_settings = array(
			'heading'       => __( 'Reset to Default', 'aawp' ),
			'tagline'       => __( 'Restore plugin settings to their default values.', 'aawp' ),
			'value'         => 'reset_settings',
			'submit_button' => __( 'Reset', 'aawp' ),
		);

		$create_db_tables = array(
			'heading'       => __( 'Database Repair Tool', 'aawp' ),
			'tagline'       => __( 'Create the database tables required by the plugin.', 'aawp' ),
			'value'         => 'create_db_tables',
			'submit_button' => __( 'Create', 'aawp' ),
		);

		$remove_products = array(
			'heading'       => __( 'Remove Products And Lists', 'aawp' ),
			'tagline'       => __( 'Remove all products and lists from the database tables of the plugin.', 'aawp' ),
			'value'         => 'remove_products',
			'submit_button' => __( 'Remove', 'aawp' ),
		);

		$cronjob_key = get_option( 'aawp_cronjob_key', null );

		if ( empty( $cronjob_key ) ) {
			$cronjob_key = md5( time() );
			update_option( 'aawp_cronjob_key', $cronjob_key );
		}

		$renewing_products = '<code style="font-size: 12px;">' . AAWP_PLUGIN_URL . 'public/jobs/update_cache.php?key=' . $cronjob_key . '</code>';
		$renewing_ratings  = '<code style="font-size: 12px;">' . AAWP_PLUGIN_URL . 'public/jobs/update_rating_cache.php?key=' . $cronjob_key . '</code>';

		$cronjobs = array(
			'heading'     => __( 'Cronjobs', 'aawp' ),
			'tagline'     => sprintf(
				/* translators: %s: Action Scheduler */
				__( 'AAWP uses %s to renew products & ratings in the background. In case you want to run cron jobs manually, use the following links:<br/><br/>', 'aawp' ),
				'<a href="' . admin_url( 'admin.php?page=aawp-tools&tab=scheduled-actions&s=aawp_' ) . '">Action Scheduler</a>'
			) .
							__( 'Renewing products and lists<br/>', 'aawp' ) . $renewing_products . '<br><br/>' .
							__( 'Renewing product ratings<br/>', 'aawp' ) . $renewing_ratings . '<br>',
			'label'       => __( 'Deactivate Action Scheduler', 'aawp' ),
			'value'       => 'deactivate_as',
			'description' => __( 'Check if you don\'t want to use the Action Scheduler for cache updates.', 'aawp' ),
		);

		$this->output_card( $cronjobs );
		$this->output_card( $create_db_tables );
		$this->output_card( $remove_products );
		$this->output_card( $reset_settings );
		$this->output_card( $uninstall );
	}

	/**
	 * Card with one heading, tagline, label and description.
	 *
	 * @param array $options Options of the card.
	 *
	 * @since 3.32.0
	 */
	public function output_card( $options ) {
		?>
			<div class="metabox-holder">
				<div class="postbox">
					<h3><span><?php echo esc_html( $options['heading'] ); ?></span></h3>
					<div class="inside">
					<p>
					<?php
					echo wp_kses(
						$options['tagline'],
						array(
							'br'   => array(),
							'code' => array(),
							'a'    => array( 'href' => array() ),
						)
					);
					?>
						</p>
							<form method="post" action="">
								<?php if ( ! empty( $options['label'] ) ) : ?> 
									<table class="form-table">
										<tbody>

												<tr>
												<?php $checked = ! empty( get_option( 'aawp_tools' )[ $options['value'] ] ); ?>
												<th scope="row"><?php echo esc_html( $options['label'] ); ?></th>
												<td>
													<input type="checkbox" name="<?php echo esc_attr( $options['value'] ); ?>"
															id="<?php echo esc_attr( $options['value'] ); ?>"<?php echo checked( $checked, true, false ); ?>
															value="1"/>
													<label for="<?php echo esc_attr( $options['value'] ); ?>">
														<?php
														echo esc_html( $options['description'] );
														?>
													</label>
												</td>
												</tr>

										</tbody>
									</table>
								<?php endif; ?>
								<input type="hidden" name="aawp_tool" value="<?php echo $options['value']; ?>"/>
								<?php wp_nonce_field( 'aawp_tools_nonce', 'aawp_tools_nonce' ); ?>
							<?php

								if ( ! empty( $options['submit_button'] ) ) {
									$confirm_text = esc_html__( 'Are you sure? This action is irreversible!', 'aawp' );
									$attribute = [
										'onclick' => 'return confirm("' . $confirm_text . '")'
									];
									submit_button( $options['submit_button'], 'secondary', 'submit', false, $attribute );
								} else {
									submit_button( __( 'Save', 'aawp' ), 'secondary', 'submit', false );
								}
							 ?>
							</form>
					</div>
				</div>
			</div>
		<?php
	}
}
