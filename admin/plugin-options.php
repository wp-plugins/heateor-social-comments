<?php defined('ABSPATH') or die("Cheating........Uh!!"); ?>
<h2>Social Comments</h2>
<div class="metabox-holder columns-2" id="post-body">
<div class="menu_div" id="tabs">
<form action="options.php" method="post">
<?php settings_fields('heateor_sc_options'); ?>
	<h2 class="nav-tab-wrapper" style="height:36px">
		<ul>
			<li><a style="margin:0; height: 23px" class="nav-tab" href="#tabs-1"><?php _e('Configuration', 'heateor-sc-text') ?></a></li>
			<li style="margin-left:9px"><a style="margin:0; height:23px" class="nav-tab" href="#tabs-2"><?php _e('Shortcode', 'heateor-sc-text') ?></a></li>
			<li style="margin-left:9px"><a style="margin:0; height:23px" class="nav-tab" href="#tabs-3"><?php _e('FAQ', 'heateor-sc-text') ?></a></li>
		</ul>
	</h2>					
	

	<div class="menu_containt_div" id="tabs-1">
		<div class="heateor_left_column">
		<div class="stuffbox">
			<h3><label><?php _e('General Options', 'heateor-sc-text');?></label></h3>
			<div class="inside">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
				<tr>
					<th>
					<img id="heateor_sc_commenting_layout_help" class="heateor_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
					<label for="heateor_sc_commenting_layout"><?php _e("Commenting layout", 'heateor-sc-text'); ?></label>
					</th>
					<td>
					<input id="heateor_sc_commenting_layout_tabbed" name="heateor_sc[commenting_layout]" type="radio" value="tabbed" <?php echo ! isset($heateor_sc_options['commenting_layout']) || $heateor_sc_options['commenting_layout'] == 'tabbed' ? 'checked' : '';?> />
					<label for="heateor_sc_commenting_layout_tabbed">Tabbed</label>
					<br/>
					<input id="heateor_sc_commenting_layout_stacked" name="heateor_sc[commenting_layout]" type="radio" value="stacked" <?php echo isset($heateor_sc_options['commenting_layout']) && $heateor_sc_options['commenting_layout'] == 'stacked' ? 'checked' : '';?> />
					<label for="heateor_sc_commenting_layout_stacked">Stacked</label>
					</td>
				</tr>
				
				<tr class="heateor_help_content" id="heateor_sc_commenting_layout_help_cont">
					<td colspan="2">
					<div>
					<?php _e('Use Tabbed layout to arrange comments under tabs', 'heateor-sc-text') ?><br/>
					<?php _e('Use Stacked layout to arrange comments below/top of each-other', 'heateor-sc-text') ?>
					</div>
					</td>
				</tr>

				<tr>
					<th>
					<img id="heateor_sc_commenting_tab_order_help" class="heateor_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
					<label for="heateor_sc_commenting_tab_order"><?php _e("Order of Comments", 'heateor-sc-text'); ?></label>
					</th>
					<td>
					<input id="heateor_sc_commenting_tab_order" name="heateor_sc[commenting_order]" type="hidden" value="<?php echo isset($heateor_sc_options['commenting_order']) ? $heateor_sc_options['commenting_order'] : '';?>" />
					<?php
					$commentsOrder = array(
						'wordpress' => 'Default',
						'facebook' => 'Facebook',
						'googleplus' => 'Google+',
						'disqus' => 'Disqus',
					);
					if( !isset( $heateor_sc_options['commenting_layout'] ) || $heateor_sc_options['commenting_layout'] == 'tabbed' ) {
						?>
						<style type="text/css">
							ul#heateor_sc_comments_order li{
								float: left;
								margin-left: 3px
							}
						</style>
						<?php
					}
					?>
					<ul style="margin: 0" id="heateor_sc_comments_order">
						<?php
						$savedOrder = isset( $heateor_sc_options['commenting_order'] ) ? $heateor_sc_options['commenting_order'] : 'wordpress,facebook,googleplus,disqus';
						$savedOrderArray = explode( ',', $savedOrder );
						foreach( $savedOrderArray as $order ) {
							$order = trim( $order );
							?>
							<li id="<?php echo $order ?>"><?php echo $commentsOrder[$order] ?></li>
							<?php
						}
						?> 
					</ul>
					
					</td>
				</tr>
				
				<tr class="heateor_help_content" id="heateor_sc_commenting_tab_order_help_cont">
					<td colspan="2">
					<div>
					<?php _e('Drag and drop to set the order of comments in social commenting interface', 'heateor-sc-text') ?>
					</div>
					</td>
				</tr>

				<tr>
					<th>
					<img id="heateor_sc_commenting_title_help" class="heateor_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
					<label for="heateor_sc_commenting_title"><?php _e("Comment area label", 'heateor-sc-text'); ?></label>
					</th>
					<td>
					<input id="heateor_sc_commenting_title" name="heateor_sc[commenting_label]" type="text" value="<?php echo isset($heateor_sc_options['commenting_label']) ? $heateor_sc_options['commenting_label'] : '';?>" />
					</td>
				</tr>

				<tr class="heateor_help_content" id="heateor_sc_commenting_title_help_cont">
					<td colspan="2">
					<div>
					<?php _e('Works, if tabbed layout is selected. Label for comment area', 'heateor-sc-text') ?>
					<img width="550" src="<?php echo plugins_url('../images/snaps/heateor_sc_commenting_label.png', __FILE__); ?>" />
					</div>
					</td>
				</tr>

				<tr>
					<th>
					<img id="heateor_sc_comment_count_help" class="heateor_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
					<label for="heateor_sc_comment_count"><?php _e("Show Counts", 'heateor-sc-text'); ?></label>
					</th>
					<td>
					<input id="heateor_sc_comment_count" name="heateor_sc[counts]" type="checkbox" <?php echo isset($heateor_sc_options['counts']) ? 'checked = "checked"' : '';?> value="1" />
					</td>
				</tr>
				
				<tr class="heateor_help_content" id="heateor_sc_comment_count_help_cont">
					<td colspan="2">
					<div>
					<?php _e('Show comments count for each comment system', 'heateor-sc-text') ?>
					</div>
					</td>
				</tr>

				<tr>
					<th>
					<img id="heateor_sc_footer_script_help" class="heateor_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
					<label for="heateor_sc_footer_script"><?php _e("Include Javascript in website footer", 'heateor-sc-text'); ?></label>
					</th>
					<td>
					<input id="heateor_sc_footer_script" name="heateor_sc[footer_script]" type="checkbox" <?php echo isset($heateor_sc_options['footer_script']) ? 'checked = "checked"' : '';?> value="1" />
					</td>
				</tr>
				
				<tr class="heateor_help_content" id="heateor_sc_footer_script_help_cont">
					<td colspan="2">
					<div>
					<?php _e('If enabled (recommended), Javascript files will be included in the footer of your website', 'heateor-sc-text') ?>
					</div>
					</td>
				</tr>
				<?php
				$post_types = get_post_types( array( 'public' => true ), 'names', 'and' );
				if ( count( $post_types ) > 0 ) {
					?>
					<tr>
						<th>
						<img id="heateor_sc_comments_location_help" class="heateor_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
						<label><?php _e("Enable Social Comments at", 'heateor-sc-text'); ?></label>
						</th>
						<td>
						<?php
						foreach ( $post_types as $post_type ) {
							if ( post_type_supports( $post_type, 'comments' ) ) {
								?>
								<input id="heateor_sc_comments_<?php echo $post_type ?>" name="heateor_sc[enable_<?php echo $post_type ?>]" type="checkbox" <?php echo isset($heateor_sc_options['enable_' . $post_type]) ? 'checked = "checked"' : '';?> value="1" />
								<label for="heateor_sc_comments_<?php echo $post_type ?>"><?php echo ucfirst( $post_type ) . '(s)'; ?></label><br/>
								<?php
							}
						}
						?>
						</td>
					</tr>

					<tr class="heateor_help_content" id="heateor_sc_comments_location_help_cont">
						<td colspan="2">
						<div>
						<?php _e('Specify the page/post groups where you want to enable Social Comments', 'heateor-sc-text') ?>
						</div>
						</td>
					</tr>
					<?php
				}
				?>

				<tr>
					<th>
					<img id="heateor_sc_delete_options_help" class="heateor_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
					<label for="heateor_sc_delete_options"><?php _e("Delete options on plugin deletion", 'heateor-sc-text'); ?></label>
					</th>
					<td>
						<input id="heateor_sc_delete_options" name="heateor_sc[delete_options]" type="checkbox" <?php echo isset($heateor_sc_options['delete_options']) ? 'checked = "checked"' : '';?> value="1" />
					</td>
				</tr>

				<tr class="heateor_help_content" id="heateor_sc_delete_options_help_cont">
					<td colspan="2">
					<div>
					<?php _e('If enabled, all plugin options will be deleted from database when you delete the plugin', 'heateor-sc-text') ?>
					</div>
					</td>
				</tr>

			</table>
			</div>
		</div>

		
		<div class="stuffbox">
			<h3><label><?php _e('WordPress Comments Options', 'heateor-sc-text');?></label></h3>
			<div class="inside">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
				<tr>
					<th>
					<img id="heateor_sc_enable_wp_comments_help" class="heateor_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
					<label for="heateor_sc_enable_wp_comments"><?php _e("Enable default WordPress comments", 'heateor-sc-text'); ?></label>
					</th>
					<td>
					<input id="heateor_sc_enable_wp_comments" name="heateor_sc[enable_wordpresscomments]" type="checkbox" <?php echo isset($heateor_sc_options['enable_wordpresscomments']) ? 'checked = "checked"' : '';?> value="1" />
					</td>
				</tr>
				
				<tr class="heateor_help_content" id="heateor_sc_enable_wp_comments_help_cont">
					<td colspan="2">
					<div>
					<?php _e('Uncheck to disable default WordPress comments', 'heateor-sc-text') ?>
					</div>
					</td>
				</tr>

				<tr>
					<th>
					<img id="heateor_sc_wp_comment_label_help" class="heateor_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
					<label for="heateor_sc_wp_comment_label"><?php _e("WordPress Comments label", 'heateor-sc-text'); ?></label>
					</th>
					<td>
					<input id="heateor_sc_wp_comment_label" name="heateor_sc[label_wordpress_comments]" type="text" value="<?php echo isset($heateor_sc_options['label_wordpress_comments']) ? $heateor_sc_options['label_wordpress_comments'] : '';?>" />
					</td>
				</tr>

				<tr class="heateor_help_content" id="heateor_sc_wp_comment_label_help_cont">
					<td colspan="2">
					<div>
					<?php _e('Leave empty to display only WordPress icon', 'heateor-sc-text') ?>
					</div>
					</td>
				</tr>

				<tr class="heateor_sc_tabbed_option">
					<th>
					<img id="heateor_sc_wp_comment_icon_help" class="heateor_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
					<label for="heateor_sc_wp_comment_icon"><?php _e("Show WordPress icon in its tab", 'heateor-sc-text'); ?></label>
					</th>
					<td>
					<input id="heateor_sc_wp_comment_icon" name="heateor_sc[enable_wordpressicon]" type="checkbox" <?php echo isset($heateor_sc_options['enable_wordpressicon']) ? 'checked = "checked"' : '';?> value="1" />
					</td>
				</tr>

				<tr class="heateor_help_content" id="heateor_sc_wp_comment_icon_help_cont">
					<td colspan="2">
					<div>
					<?php _e('Enable to display WordPress icon in its tab', 'heateor-sc-text') ?>
					</div>
					</td>
				</tr>

			</table>
			</div>
		</div>

		<div class="stuffbox">
			<h3><label><?php _e('Facebook Comments Options', 'heateor-sc-text');?></label></h3>
			<div class="inside">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
				<tr>
					<td colspan="2">
					<div>
					<a href="https://www.heateor.com/add-ons" target="_blank"><input type="button" value="<?php _e('Enable Facebook Comments notification and moderation', 'heateor-sc-text') ?>" class="ss_demo" /></a>
					</div>
					</td>
				</tr>

				<tr>
					<th>
					<img id="heateor_sc_enable_fbcomments_help" class="heateor_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
					<label for="heateor_sc_enable_fbcomments"><?php _e("Enable Facebook Comments", 'heateor-sc-text'); ?></label>
					</th>
					<td>
					<input id="heateor_sc_enable_fbcomments" name="heateor_sc[enable_facebookcomments]" type="checkbox" <?php echo isset($heateor_sc_options['enable_facebookcomments']) ? 'checked = "checked"' : '';?> value="1" />
					</td>
				</tr>
				
				<tr class="heateor_help_content" id="heateor_sc_enable_fbcomments_help_cont">
					<td colspan="2">
					<div>
					<?php _e('Enable Facebook Comments', 'heateor-sc-text') ?>
					</div>
					</td>
				</tr>

				<tr>
					<th>
					<img id="heateor_sc_fb_comment_label_help" class="heateor_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
					<label for="heateor_sc_fb_comment_label"><?php _e("Facebook Comments label", 'heateor-sc-text'); ?></label>
					</th>
					<td>
					<input id="heateor_sc_fb_comment_label" name="heateor_sc[label_facebook_comments]" type="text" value="<?php echo isset($heateor_sc_options['label_facebook_comments']) ? $heateor_sc_options['label_facebook_comments'] : '';?>" />
					</td>
				</tr>

				<tr class="heateor_help_content" id="heateor_sc_fb_comment_label_help_cont">
					<td colspan="2">
					<div>
					<?php _e('Leave empty to display only Facebook icon in its tab', 'heateor-sc-text') ?>
					</div>
					</td>
				</tr>

				<tr class="heateor_sc_tabbed_option">
					<th>
					<img id="heateor_sc_fb_comment_icon_help" class="heateor_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
					<label for="heateor_sc_fb_comment_icon"><?php _e("Show Facebook icon in its tab", 'heateor-sc-text'); ?></label>
					</th>
					<td>
					<input id="heateor_sc_fb_comment_icon" name="heateor_sc[enable_facebookicon]" type="checkbox" <?php echo isset($heateor_sc_options['enable_facebookicon']) ? 'checked = "checked"' : '';?> value="1" />
					</td>
				</tr>

				<tr class="heateor_help_content" id="heateor_sc_fb_comment_icon_help_cont">
					<td colspan="2">
					<div>
					<?php _e('Enable to display Facebook icon in its tab', 'heateor-sc-text') ?>
					</div>
					</td>
				</tr>

				<tr>
					<th>
					<img id="heateor_sc_fb_comment_url_help" class="heateor_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
					<label for="heateor_sc_comment_url"><?php _e('Url to comment on', 'heateor-sc-text'); ?></label>
					</th>
					<td>
					<input id="heateor_sc_comment_url" name="heateor_sc[urlToComment]" type="text" value="<?php echo isset($heateor_sc_options['urlToComment']) ? $heateor_sc_options['urlToComment'] : '' ?>" />
					</td>
				</tr>
				
				<tr class="heateor_help_content" id="heateor_sc_fb_comment_url_help_cont">
					<td colspan="2">
					<div>
					<?php _e('The absolute URL that comments posted will be permanently associated with. Stories on Facebook about comments posted, will link to this URL.<br/>If left empty <strong>(Recommended)</strong>, url of the webpage will be used at which commenting is enabled.', 'heateor-sc-text') ?>
					</div>
					</td>
				</tr>
				
				<tr>
					<th>
					<img id="heateor_sc_fb_comment_width_help" class="heateor_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
					<label for="heateor_sc_fbcomment_width"><?php _e('Width', 'heateor-sc-text'); ?></label>
					</th>
					<td>
					<input id="heateor_sc_fbcomment_width" name="heateor_sc[comment_width]" type="text" value="<?php echo isset($heateor_sc_options['comment_width']) ? $heateor_sc_options['comment_width'] : '' ?>" />px
					</td>
				</tr>
				
				<tr class="heateor_help_content" id="heateor_sc_fb_comment_width_help_cont">
					<td colspan="2">
					<div>
					<?php _e('Leave empty to auto-adjust the width. The width (in pixels) of the Comments block.', 'heateor-sc-text') ?>
					</div>
					</td>
				</tr>
				
				<tr>
					<th>
					<img id="heateor_sc_fb_comment_color_help" class="heateor_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
					<label for="heateor_sc_fbcomment_color"><?php _e('Color Scheme', 'heateor-sc-text'); ?></label>
					</th>
					<td>
					<select id="heateor_sc_fbcomment_color" name="heateor_sc[comment_color]">
						<option value="light" <?php echo isset($heateor_sc_options['comment_color']) && $heateor_sc_options['comment_color'] == 'light' ? 'selected="selected"' : '' ?>><?php _e('Light', 'heateor-sc-text') ?></option>
						<option value="dark" <?php echo isset($heateor_sc_options['comment_color']) && $heateor_sc_options['comment_color'] == 'dark' ? 'selected="selected"' : '' ?>><?php _e('Dark', 'heateor-sc-text') ?></option>
					</select>
					</td>
				</tr>
				
				<tr class="heateor_help_content" id="heateor_sc_fb_comment_color_help_cont">
					<td colspan="2">
					<div>
					<?php _e('The color scheme used by the plugin. Can be "light" or "dark".', 'heateor-sc-text') ?>
					</div>
					</td>
				</tr>
				
				<tr>
					<th>
					<img id="heateor_sc_fb_comment_numposts_help" class="heateor_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
					<label for="heateor_sc_fbcomment_numposts"><?php _e('Number of comments', 'heateor-sc-text'); ?></label>
					</th>
					<td>
					<input id="heateor_sc_fbcomment_numposts" name="heateor_sc[comment_numposts]" type="text" value="<?php echo isset($heateor_sc_options['comment_numposts']) ? $heateor_sc_options['comment_numposts'] : '' ?>" />
					</td>
				</tr>
				
				<tr class="heateor_help_content" id="heateor_sc_fb_comment_numposts_help_cont">
					<td colspan="2">
					<div>
					<?php _e('The number of comments to show by default. The minimum value is 1. Defaults to 10', 'heateor-sc-text') ?>
					</div>
					</td>
				</tr>
				
				<tr>
					<th>
					<img id="heateor_sc_fb_comment_orderby_help" class="heateor_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
					<label for="heateor_sc_fbcomment_orderby"><?php _e('Order by', 'heateor-sc-text'); ?></label>
					</th>
					<td>
					<select id="heateor_sc_fbcomment_orderby" name="heateor_sc[comment_orderby]">
						<option value="social" <?php echo isset($heateor_sc_options['comment_orderby']) && $heateor_sc_options['comment_orderby'] == 'social' ? 'selected="selected"' : '' ?>><?php _e('Social', 'heateor-sc-text') ?></option>
						<option value="reverse_time" <?php echo isset($heateor_sc_options['comment_orderby']) && $heateor_sc_options['comment_orderby'] == 'reverse_time' ? 'selected="selected"' : '' ?>><?php _e('Reverse Time', 'heateor-sc-text') ?></option>
						<option value="time" <?php echo isset($heateor_sc_options['comment_orderby']) && $heateor_sc_options['comment_orderby'] == 'time' ? 'selected="selected"' : '' ?>><?php _e('Time', 'heateor-sc-text') ?></option>
					</select>
					</td>
				</tr>
				
				<tr class="heateor_help_content" id="heateor_sc_fb_comment_orderby_help_cont">
					<td colspan="2">
					<div>
					<?php _e('The order to use when displaying comments.', 'heateor-sc-text') ?>
					</div>
					</td>
				</tr>
				
				<tr>
					<th>
					<img id="heateor_sc_fb_comment_lang_help" class="heateor_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
					<label for="heateor_sc_fbcomment_lang"><?php _e('Language', 'heateor-sc-text'); ?></label>
					</th>
					<td>
					<input id="heateor_sc_fbcomment_lang" name="heateor_sc[comment_lang]" type="text" value="<?php echo isset($heateor_sc_options['comment_lang']) ? $heateor_sc_options['comment_lang'] : '' ?>" />
					</td>
				</tr>
				
				<tr class="heateor_help_content" id="heateor_sc_fb_comment_lang_help_cont">
					<td colspan="2">
					<div>
					<?php echo sprintf(__('Enter the code of the language you want to use to display commenting. You can find the language codes at <a href="%s" target="_blank">this link</a>. Leave it empty for default language(English)', 'heateor-sc-text'), '//www.facebook.com/translations/FacebookLocales.xml') ?>
					</div>
					</td>
				</tr>
			</table>
			</div>
		</div>

		<div class="stuffbox">
			<h3><label><?php _e('Google Plus Comments Options', 'heateor-sc-text');?></label></h3>
			<div class="inside">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
				<tr>
					<th>
					<img id="heateor_sc_enable_gpcomments_help" class="heateor_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
					<label for="heateor_sc_enable_gpcomments"><?php _e("Enable Google Plus Comments", 'heateor-sc-text'); ?></label>
					</th>
					<td>
					<input id="heateor_sc_enable_gpcomments" name="heateor_sc[enable_googlepluscomments]" type="checkbox" <?php echo isset($heateor_sc_options['enable_googlepluscomments']) ? 'checked = "checked"' : '';?> value="1" />
					</td>
				</tr>
				
				<tr class="heateor_help_content" id="heateor_sc_enable_gpcomments_help_cont">
					<td colspan="2">
					<div>
					<?php _e('Enable Google Plus Commenting', 'heateor-sc-text') ?>
					</div>
					</td>
				</tr>

				<tr>
					<th>
					<img id="heateor_sc_gp_comment_label_help" class="heateor_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
					<label for="heateor_sc_gp_comment_label"><?php _e("Google Plus Comments label", 'heateor-sc-text'); ?></label>
					</th>
					<td>
					<input id="heateor_sc_gp_comment_label" name="heateor_sc[label_googleplus_comments]" type="text" value="<?php echo isset($heateor_sc_options['label_googleplus_comments']) ? $heateor_sc_options['label_googleplus_comments'] : '';?>" />
					</td>
				</tr>

				<tr class="heateor_help_content" id="heateor_sc_gp_comment_label_help_cont">
					<td colspan="2">
					<div>
					<?php _e('Leave empty to display only Google Plus icon in its tab', 'heateor-sc-text') ?>
					</div>
					</td>
				</tr>

				<tr class="heateor_sc_tabbed_option">
					<th>
					<img id="heateor_sc_gp_comment_icon_help" class="heateor_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
					<label for="heateor_sc_gp_comment_icon"><?php _e("Show Google Plus icon in its tab", 'heateor-sc-text'); ?></label>
					</th>
					<td>
					<input id="heateor_sc_gp_comment_icon" name="heateor_sc[enable_googleplusicon]" type="checkbox" <?php echo isset($heateor_sc_options['enable_googleplusicon']) ? 'checked = "checked"' : '';?> value="1" />
					</td>
				</tr>

				<tr class="heateor_help_content" id="heateor_sc_gp_comment_icon_help_cont">
					<td colspan="2">
					<div>
					<?php _e('Enable to display Google Plus icon in its tab', 'heateor-sc-text') ?>
					</div>
					</td>
				</tr>

				<tr>
					<th>
					<img id="heateor_sc_gpcomments_width_help" class="heateor_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
					<label for="heateor_sc_gpcomments_width"><?php _e("Width", 'heateor-sc-text'); ?></label>
					</th>
					<td>
					<input id="heateor_sc_gpcomments_width" name="heateor_sc[gpcomments_width]" type="text" value="<?php echo isset($heateor_sc_options['gpcomments_width']) ? $heateor_sc_options['gpcomments_width'] : ''; ?>" />
					</td>
				</tr>
				
				<tr class="heateor_help_content" id="heateor_sc_gpcomments_width_help_cont">
					<td colspan="2">
					<div>
					<?php _e('Width of GooglePlus Commenting interface. Leave empty for auto adjust', 'heateor-sc-text') ?>
					</div>
					</td>
				</tr>

				<tr>
					<th>
					<img id="heateor_sc_gpcomments_url_help" class="heateor_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
					<label for="heateor_sc_gpcomments_url"><?php _e("Url to comment on", 'heateor-sc-text'); ?></label>
					</th>
					<td>
					<input id="heateor_sc_gpcomments_url" name="heateor_sc[gpcomments_url]" type="text" value="<?php echo isset($heateor_sc_options['gpcomments_url']) ? $heateor_sc_options['gpcomments_url'] : ''; ?>" />
					</td>
				</tr>
				
				<tr class="heateor_help_content" id="heateor_sc_gpcomments_url_help_cont">
					<td colspan="2">
					<div>
					<?php _e('The absolute URL that comments posted will be permanently associated with. Stories on Google Plus about comments posted, will link to this URL.<br/>If left empty <strong>(Recommended)</strong>, url of the webpage will be used at which commenting is enabled.', 'heateor-sc-text') ?>
					</div>
					</td>
				</tr>
			</table>
			</div>
		</div>

		<div class="stuffbox">
			<h3><label><?php _e('Disqus comments Options', 'heateor-sc-text');?></label></h3>
			<div class="inside">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
				<tr>
					<th>
					<img id="heateor_sc_enable_dqcomments_help" class="heateor_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
					<label for="heateor_sc_enable_dqcomments"><?php _e("Enable Disqus comments", 'heateor-sc-text'); ?></label>
					</th>
					<td>
					<input id="heateor_sc_enable_dqcomments" name="heateor_sc[enable_disquscomments]" type="checkbox" <?php echo isset($heateor_sc_options['enable_disquscomments']) ? 'checked = "checked"' : '';?> value="1" />
					</td>
				</tr>
				
				<tr class="heateor_help_content" id="heateor_sc_enable_dqcomments_help_cont">
					<td colspan="2">
					<div>
					<?php _e('Enable Disqus comments', 'heateor-sc-text') ?>
					</div>
					</td>
				</tr>

				<tr>
					<th>
					<img id="heateor_sc_dq_comment_label_help" class="heateor_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
					<label for="heateor_sc_dq_comment_label"><?php _e("Disqus Comments label", 'heateor-sc-text'); ?></label>
					</th>
					<td>
					<input id="heateor_sc_dq_comment_label" name="heateor_sc[label_disqus_comments]" type="text" value="<?php echo isset($heateor_sc_options['label_disqus_comments']) ? $heateor_sc_options['label_disqus_comments'] : '';?>" />
					</td>
				</tr>

				<tr class="heateor_help_content" id="heateor_sc_dq_comment_label_help_cont">
					<td colspan="2">
					<div>
					<?php _e('Leave empty to display only Disqus icon in its tab', 'heateor-sc-text') ?>
					</div>
					</td>
				</tr>

				<tr class="heateor_sc_tabbed_option">
					<th>
					<img id="heateor_sc_dq_comment_icon_help" class="heateor_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
					<label for="heateor_sc_dq_comment_icon"><?php _e("Show Disqus icon in its tab", 'heateor-sc-text'); ?></label>
					</th>
					<td>
					<input id="heateor_sc_dq_comment_icon" name="heateor_sc[enable_disqusicon]" type="checkbox" <?php echo isset($heateor_sc_options['enable_disqusicon']) ? 'checked = "checked"' : '';?> value="1" />
					</td>
				</tr>

				<tr class="heateor_help_content" id="heateor_sc_dq_comment_icon_help_cont">
					<td colspan="2">
					<div>
					<?php _e('Enable to display Disqus icon in its tab', 'heateor-sc-text') ?>
					</div>
					</td>
				</tr>

				<tr>
					<th>
					<img id="heateor_sc_commenting_dq_shortname_help" class="heateor_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
					<label for="heateor_sc_commenting_dq_shortname"><?php _e("Disqus Shortname", 'heateor-sc-text'); ?></label>
					</th>
					<td>
					<input id="heateor_sc_commenting_dq_shortname" name="heateor_sc[dq_shortname]" type="text" value="<?php echo isset($heateor_sc_options['dq_shortname']) ? $heateor_sc_options['dq_shortname'] : ''; ?>" />
					</td>
				</tr>
				
				<tr class="heateor_help_content" id="heateor_sc_commenting_dq_shortname_help_cont">
					<td colspan="2">
					<div>
					<?php _e('<strong>Required to use Disqus comments.</strong> For more info on shortname, visit following link.', 'heateor-sc-text') ?> <a href="https://help.disqus.com/customer/portal/articles/466208" target="_blank">https://help.disqus.com/customer/portal/articles/466208</a>
					</div>
					</td>
				</tr>

				<tr>
					<th>
					<img id="heateor_sc_commenting_dq_key_help" class="heateor_help_bubble" src="<?php echo plugins_url('../images/info.png', __FILE__) ?>" />
					<label for="heateor_sc_commenting_dq_key"><?php _e("Disqus API Key", 'heateor-sc-text'); ?></label>
					</th>
					<td>
					<input id="heateor_sc_commenting_dq_key" name="heateor_sc[dq_key]" type="text" value="<?php echo isset($heateor_sc_options['dq_key']) ? $heateor_sc_options['dq_key'] : ''; ?>" />
					</td>
				</tr>
				
				<tr class="heateor_help_content" id="heateor_sc_commenting_dq_key_help_cont">
					<td colspan="2">
					<div>
					<?php _e('Used to show Disqus Comments count, get one for free at <a href="http://disqus.com/api/applications/register/" target="_blank">this link</a>', 'heateor-sc-text') ?> 
					</div>
					</td>
				</tr>
			</table>
			</div>
		</div>

		</div>
		<?php include 'help.php'; ?>
	</div>


	<div class="menu_containt_div" id="tabs-2">
		<div class="heateor_left_column">
		<div class="stuffbox">
			<h3><label><?php _e('Shortcode', 'heateor-sc-text');?></label></h3>
			<div class="inside">
				<p><a href="http://support.heateor.com/social-comments-shortcode/" target="_blank"><?php _e('Social Comments Shortcode', 'heateor-sc-text') ?></a></p>
			</div>
		</div>
		</div>
		<?php include 'help.php'; ?>
	</div>
	
	<div class="menu_containt_div" id="tabs-3">
		<div class="heateor_left_column">
		<div class="stuffbox">
			<h3><label><?php _e('FAQ', 'heateor-sc-text') ?></label></h3>
			<div class="inside">
				<p><a href="http://support.heateor.com/how-can-i-disable-social-comments-at-individual-pagepost" target="_blank"><?php _e('How can I disable Social Comments at individual page/post?', 'heateor-sc-text') ?></a></p>
			</div>
		</div>
		</div>
		<?php include 'help.php'; ?>
	</div>
	<div class="clr"></div>
	<p class="submit">
		<input style="margin-left:8px" type="submit" name="save" class="button button-primary" value="<?php _e("Save Changes", 'heateor-sc-text'); ?>" />
	</p>
</form>
</div>
</div>