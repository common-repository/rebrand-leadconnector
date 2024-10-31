<?php
wp_enqueue_script('jquery');
// This will enqueue the Media Uploader script
wp_enqueue_media();
?>
<div class="llc-wl-settings-header">
	<h3><?php _e('Rebrand leadconnector', 'bzlc'); ?></h3>
</div>
<div class="llc-wl-settings-wlc">

	<div class="llc-wl-settings">
		<form method="post" id="form" enctype="multipart/form-data">

			<?php wp_nonce_field( 'llc_wl_nonce', 'llc_wl_nonce' ); ?>

			<div class="llc-wl-setting-tabs-content">

				<div id="llc-wl-branding" class="llc-wl-setting-tab-content active">
					<h3 class="bzlc-section-title"><?php esc_html_e('Branding', 'bzlc'); ?></h3>
					<p><?php esc_html_e('You can white label the plugin as per your requirement.', 'bzlc'); ?></p>
					<table class="form-table llc-wl-fields">
						<tbody>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="llc_wl_plugin_name"><?php esc_html_e('Plugin Name', 'bzlc'); ?></label>
								</th>
								<td>
									<input id="llc_wl_plugin_name" name="llc_wl_plugin_name" type="text" class="regular-text" value="<?php echo esc_attr($branding['plugin_name']); ?>" placeholder="" />
								</td>
							</tr>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="llc_wl_plugin_desc"><?php esc_html_e('Plugin Description', 'bzlc'); ?></label>
								</th>
								<td>
									<input id="llc_wl_plugin_desc" name="llc_wl_plugin_desc" type="text" class="regular-text" value="<?php echo esc_attr($branding['plugin_desc']); ?>"/>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="llc_wl_plugin_author"><?php esc_html_e('Developer / Agency', 'bzlc'); ?></label>
								</th>
								<td>
									<input id="llc_wl_plugin_author" name="llc_wl_plugin_author" type="text" class="regular-text" value="<?php echo esc_attr($branding['plugin_author']); ?>"/>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="llc_wl_plugin_uri"><?php esc_html_e('Website URL', 'bzlc'); ?></label>
								</th>
								<td>
									<input id="llc_wl_plugin_uri" name="llc_wl_plugin_uri" type="text" class="regular-text" value="<?php echo esc_attr($branding['plugin_uri']); ?>"/>
								</td>
							</tr>

							<tr valign="top">
								<th scope="row" valign="top">
									<label for="llc_wl_primary_color"><?php esc_html_e('Primary Color', 'bzlc'); ?></label>
								</th>
								<td>
									<input id="llc_wl_primary_color" name="llc_wl_primary_color" type="text" class="llc-wl-color-picker" value="" disabled />
									<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
								</td>
							</tr>
							
														
							<tr valign="top">
								<th scope="row" valign="top">
									<label for="llc_menu_icon"><?php esc_html_e('Menu Icon', 'bzlc'); ?></label>
								</th>
								<td>
									<input class="regular-text" name="llc_menu_icon" id="llc_menu_icon" type="text" value="" disabled />
									<input type="button" name="upload-btn" id="upload-btn" class="button-secondary" value="Choose Icon">
									<p><a href="https://rebrandpress.com/pricing" target="_blank">Get Pro</a> to use this feature.</p>
								</td>
							</tr>
							
							

							
						</tbody>
					</table>
				</div>
				
				<div class="llc-wl-setting-footer">
					<p class="submit">
						<input type="submit" name="llc_submit" id="llc_save_branding" class="button button-primary bzlc-save-button" value="<?php esc_html_e('Save Settings', 'bzlc'); ?>" />
					</p>
				</div>
			</div>
		</form>
	</div>
</div>
