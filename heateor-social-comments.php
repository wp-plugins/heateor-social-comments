<?php
/*
Plugin Name: Heateor Social Comments
Plugin URI: http://www.heateor.com
Description: Enable Facebook Comments, Google Plus Comments, Disqus Comments along with default WordPress Comments.
Version: 1.1
Author: Team Heateor
Author URI: http://www.heateor.com
License: GPL2+
*/
defined( 'ABSPATH' ) or die( "Cheating........Uh!!" );
define( 'HEATEOR_SOCIAL_COMMENTS_VERSION', '1.1' );

$heateor_sc_options = get_option( 'heateor_sc' );

//include shortcode
require 'inc/shortcode.php';

/**
 * Hook the plugin function on 'init' event.
 */
function heateor_sc_init() {
	if( get_option( 'heateor_sc_version' ) != HEATEOR_SOCIAL_COMMENTS_VERSION ) {
		update_option( 'heateor_sc_version', HEATEOR_SOCIAL_COMMENTS_VERSION );
	}
	add_action( 'wp_enqueue_scripts', 'heateor_sc_frontend_styles' );
	add_action( 'wp_enqueue_scripts', 'heateor_sc_frontend_scripts' );
	global $heateor_sc_options;
	if( isset( $heateor_sc_options['enable_facebookcomments'] ) || isset( $heateor_sc_options['enable_googlepluscomments'] ) || isset( $heateor_sc_options['enable_disquscomments'] ) ) {
		add_filter( 'comments_template', 'heateor_sc_social_commenting' );
	}
}
add_action( 'init', 'heateor_sc_init' );

/**
 * Render Social Commenting
 */
function heateor_sc_social_commenting( $file ) {
	if ( ( is_single() || is_page() || is_singular() ) && comments_open() ) {
		// if password is required, return
		if ( post_password_required() ) {
			echo '<p>'.__( 'This is password protected.', 'heateor-sc-text' ).'</p>';
			return plugin_dir_path( __FILE__ ) . '/inc/comments.php';
		}

		// check if social comments are enabled at this post type
		global $post, $heateor_sc_options;
		
		$comments_meta = '';
		if ( ! is_front_page() || ( is_front_page() && 'page' == get_option( 'show_on_front' ) ) ) {
			$comments_meta = get_post_meta( $post->ID, '_heateor_sc_meta', true );
			if ( isset( $comments_meta['disable_comments'] ) ) {
				return $file;
			}
		}

		$post_types = get_post_types( array( 'public' => true ), 'names', 'and' );
		if ( count( $post_types ) > 0 && isset( $post->post_type ) && ! isset( $heateor_sc_options['enable_' . $post->post_type] ) ) {
			return $file;
		}

		global $heateor_sc_options;
		$commentsOrder = $heateor_sc_options['commenting_order'];
		$commentsOrder = explode( ',', $commentsOrder );
		
		$tabs = '';
		$divs = '';

		foreach( $commentsOrder as $order ) {
			$order = trim( $order );
			if ( ! isset( $heateor_sc_options['enable_' .$order. 'comments'] ) ) { continue; }
			
			$comment_div = '';
			if ( $order == 'wordpress' ) {
				if ( isset( $heateor_sc_options['counts'] ) ) {
					$comments_count = heateor_sc_get_wp_comments_count();
				}
				$comment_div = '<div style="clear:both"></div>' . heateor_sc_render_wp_comments( $file ) . '<div style="clear:both"></div>';
			} elseif ( $order == 'facebook' ) {
				if ( isset( $heateor_sc_options['counts'] ) ) {
					$comments_count = heateor_sc_get_fb_comments_count();
				}
				$comment_div = heateor_sc_render_fb_comments();
			} elseif ( $order == 'googleplus' ) {
				if ( isset( $heateor_sc_options['counts'] ) ) {
					$comments_count = heateor_sc_get_gp_comments_count();
				}
				$comment_div = '<div style="clear:both"></div>' . heateor_sc_render_gp_comments() . '<div style="clear:both"></div>';
			} else {
				if ( isset( $heateor_sc_options['counts'] ) ) {
					$comments_count = heateor_sc_get_dq_comments_count();
				}
				$comment_div = heateor_sc_render_dq_comments();
			}

			$divs .= '<div id="heateor_sc_' . $order . '_comments">' . ( isset( $heateor_sc_options['commenting_layout'] ) && $heateor_sc_options['commenting_layout'] == 'stacked' && isset( $heateor_sc_options['label_' . $order . '_comments'] ) ? '<h3 class="comment-reply-title">' . $heateor_sc_options['label_' . $order . '_comments'] . ( isset( $comments_count ) ? ' (' . $comments_count . ')' : '' ) . '</h3>' : '' );
			$divs .= $comment_div;
			$divs .= '</div>';

			if ( ! isset( $heateor_sc_options['commenting_layout'] ) || $heateor_sc_options['commenting_layout'] == 'tabbed' ) {
				$tabs .= '<li><a href="#heateor_sc_' . $order . '_comments">';
				// icon
				if ( isset( $heateor_sc_options['enable_' . $order . 'icon'] ) || ( ! isset( $heateor_sc_options['enable_' . $order . 'icon'] ) && ! isset( $heateor_sc_options['label_' . $order . '_comments'] ) ) ) {
					$alt = isset( $heateor_sc_options['label_' . $order . '_comments'] ) ? $heateor_sc_options['label_' . $order . '_comments'] : ucfirst( $order ) . ' Comments';
					$tabs .= '<ht title="'. $alt .'" alt="'. $alt .'" class="heateor_sc_' . $order . '_background"><hsc class="heateor_sc_' . $order . '_svg"></hsc></ht>';
				}
				// label
				if ( isset( $heateor_sc_options['label_' . $order . '_comments'] ) ) {
					$tabs .= '<span class="heateor_sc_comments_label">' . $heateor_sc_options['label_' . $order . '_comments'] . '</span>';
				}
				$tabs .= ( isset( $comments_count ) ? ' (' . $comments_count . ')' : '' ) . '</a></li>';
			}
		}
		$commentingHtml = '<div class="heateor_sc_social_comments">';
		if ( $tabs ) {
			$commentingHtml .= ( isset( $heateor_sc_options['commenting_label'] ) ? '<div style="clear:both"></div><h3 class="comment-reply-title">' . $heateor_sc_options['commenting_label'] . '</h3><div style="clear:both"></div>' : '' ) . '<ul class="heateor_sc_comments_tabs">' . $tabs . '</ul>';
		}
		$commentingHtml .= $divs;
		$commentingHtml .= '</div>';
		echo $commentingHtml;
		// hack to return empty string
		return plugin_dir_path( __FILE__ ) . '/inc/comments.php';
	}
	return $file;
}

/**
 * Get WordPress Comments count
 */
function heateor_sc_get_wp_comments_count() {
	global $post;
	$comments_count = wp_count_comments( $post->ID );
	return ( $comments_count && isset( $comments_count -> approved ) ? $comments_count -> approved : 0 );
}

/**
 * Get Facebook Comments count
 */
function heateor_sc_get_fb_comments_count() {
	global $heateor_sc_options;
	if ( isset( $heateor_sc_options['urlToComment'] ) && $heateor_sc_options['urlToComment'] != '' ) {
		$url = $heateor_sc_options['urlToComment'];
	} else {
		$url = heateor_sc_get_current_page_url();
	}
	return '<fb:comments-count href='. $url .'></fb:comments-count>';
}

/**
 * Get Google Plus Comments count
 */
function heateor_sc_get_gp_comments_count() {
	global $heateor_sc_options;
	$response = wp_remote_get( 'https://apis.google.com/_/widget/render/commentcount?bsv&usegapi=1&href=' . ( isset( $heateor_sc_options['gpcomments_url'] ) ? $heateor_sc_options['gpcomments_url'] : heateor_sc_get_current_page_url() ) );
	if ( is_wp_error( $response ) || $response['response']['code'] != 200 ) { 
		return '0';
	}
	$body = $response['body'];
	$count = explode( "<span>", $body );
	$count = $count[1];
	$count = explode( " ", trim( $count ) );
	return $count[0];
}

/**
 * Get Disqus Comments count
 */
function heateor_sc_get_dq_comments_count(){
	global $heateor_sc_options;
	if ( ! $heateor_sc_options['dq_key'] || ! $heateor_sc_options['dq_shortname'] ) {
		return 0;
	}
	$response = wp_remote_get( 'https://disqus.com/api/3.0/threads/set.json?api_key=' . $heateor_sc_options['dq_key'] . '&forum=' . $heateor_sc_options["dq_shortname"] . '&thread=link:' . urlencode( heateor_sc_get_current_page_url() ) );
	if ( is_wp_error( $response ) || $response['response']['code'] != 200 ) {
		return '0';
	}
	$json = json_decode( $response['body'] );
	return isset( $json->response[0] ) && isset( $json->response[0]->posts ) ? $json->response[0]->posts : 0;	
}

/**
 * Get current page url
 */
function heateor_sc_get_current_page_url() {
	global $post;
	if ( isset( $post -> ID ) && $post -> ID ) {
		return get_permalink( $post -> ID );
	} else {
		return html_entity_decode( esc_url( the_champ_get_http().$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ) );
	}
}

/**
 * Render Disqus Comments
 */
function heateor_sc_render_dq_comments() {
	global $heateor_sc_options;
	$shortname = isset( $heateor_sc_options['dq_shortname'] ) && $heateor_sc_options['dq_shortname'] != '' ? $heateor_sc_options['dq_shortname'] : '';
	return '<div class="embed-container clearfix" id="disqus_thread">' . ( $shortname != '' ? $shortname : '<div style="font-size: 14px;clear: both;">' . __( 'Specify a Disqus shortname in Super Socializer &gt; Social Commenting section in admin panel', 'heateor-sc-text' ) . '</div>' ) . '</div><script type="text/javascript">var disqus_shortname = "' . $shortname . '";(function(d) {var dsq = d.createElement("script"); dsq.type = "text/javascript"; dsq.async = true;dsq.src = "//" + disqus_shortname + ".disqus.com/embed.js"; (d.getElementsByTagName("head")[0] || d.getElementsByTagName("body")[0]).appendChild(dsq); })(document);</script>';
}

/**
 * Render Google Plus Comments
 */
function heateor_sc_render_gp_comments() {
	global $heateor_sc_options;
	if ( isset( $heateor_sc_options['gpcomments_url'] ) && $heateor_sc_options['gpcomments_url'] != '' ) {
		$url = $heateor_sc_options['gpcomments_url'];
	} else {
		$url = heateor_sc_get_current_page_url();
	}
	return '<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script><div id="heateor_sc_gpcomments"></div><script type="text/javascript">window.setTimeout(function(){var e="heateor_sc_gpcomments",r="",o="FILTERED_POSTMOD";gapi.comments.render(e,{href:"'. $url .'",first_party_property:"BLOGGER",legacy_comment_moderation_url:r,view_type:o})},10);</script>';
}

/**
 * Render Facebook Comments
 */
function heateor_sc_render_fb_comments() {
	global $heateor_sc_options;
	if ( isset( $heateor_sc_options['urlToComment'] ) && $heateor_sc_options['urlToComment'] != '' ) {
		$url = $heateor_sc_options['urlToComment'];
	} else {
		$url = heateor_sc_get_current_page_url();
	}
	$commentingHtml = '<style type="text/css">.fb-comments,.fb-comments span,.fb-comments span iframe[style]{min-width:100%!important;width:100%!important}</style><div id="fb-root"></div><script type="text/javascript">';
	global $heateor_fcn_options;
	if ( isset( $heateor_fcn_options ) ) {
		$commentingHtml .= 'window.fbAsyncInit=function(){FB.init({appId:"",channelUrl:"'. site_url() .'//channel.html",status:!0,cookie:!0,xfbml:!0,version:"v2.4"}),FB.Event.subscribe("comment.create",function(e){e.commentID&&jQuery.ajax({type:"POST",dataType:"json",url:"'. site_url() .'/index.php",data:{action:"the_champ_moderate_fb_comments",data:e},success:function(){}})})};';
	}
	$commentingHtml .= '!function(e,n,t){var o,c=e.getElementsByTagName(n)[0];e.getElementById(t)||(o=e.createElement(n),o.id=t,o.src="//connect.facebook.net/' . ( isset($heateor_sc_options['comment_lang']) && $heateor_sc_options['comment_lang'] != '' ? $heateor_sc_options["comment_lang"] : 'en_US' ) . '/sdk.js#xfbml=1&version=v2.4",c.parentNode.insertBefore(o,c))}(document,"script","facebook-jssdk");</script><div class="fb-comments" data-href="' . $url . '" data-colorscheme="' . ( isset($heateor_sc_options['comment_color']) && $heateor_sc_options['comment_color'] != '' ? $heateor_sc_options["comment_color"] : '' ) . '" data-numposts="' . ( isset($heateor_sc_options['comment_numposts']) && $heateor_sc_options['comment_numposts'] != '' ? $heateor_sc_options["comment_numposts"] : '' ) . '" data-width="' . ( isset( $heateor_sc_options['comment_width'] ) && $heateor_sc_options['comment_width'] != '' ? $heateor_sc_options["comment_width"] : '100%' ) . '" data-order-by="' . ( isset($heateor_sc_options['comment_orderby']) && $heateor_sc_options['comment_orderby'] != '' ? $heateor_sc_options["comment_orderby"] : '' ) . '" ></div>';
	return $commentingHtml;
}

/**
 * Render WordPress Comments
 */
function heateor_sc_render_wp_comments( $file ) {
	ob_start();
	if ( file_exists( $file ) ) {
		require $file;
	} elseif ( file_exists( TEMPLATEPATH . $file ) ) {
		require( TEMPLATEPATH . $file );
	}
	return ob_get_clean();
}

/**
 * Stylesheets to load at front end.
 */
function heateor_sc_frontend_styles() {
	wp_enqueue_style( 'heateor-sc-frontend-css', plugins_url( 'css/front.css', __FILE__ ), false, HEATEOR_SOCIAL_COMMENTS_VERSION );
}

/**
 * Stylesheets to load at front end.
 */
function heateor_sc_frontend_scripts() {
	global $heateor_sc_options;
	if ( ! isset( $heateor_sc_options['commenting_layout'] ) || $heateor_sc_options['commenting_layout'] == 'tabbed' ) {
		$in_footer = isset( $heateor_sc_options['footer_script'] ) ? true : false;
		wp_enqueue_script( 'heateor-sc-frontend-scripts', plugins_url( 'js/front/front.js', __FILE__ ), array( 'jquery', 'jquery-ui-tabs' ), HEATEOR_SOCIAL_COMMENTS_VERSION, $in_footer );
	}
}

/**
 * Create plugin menu in admin.
 */	
function heateor_sc_create_admin_menu() {
	$options_page = add_menu_page( 'Heateor - Social Comments', '<b>Social Comments</b>', 'manage_options', 'heateor-sc', 'heateor_sc_option_page', plugins_url( 'images/logo.png', __FILE__ ) );
	add_action( 'admin_print_scripts-' . $options_page, 'heateor_sc_admin_scripts' );
	add_action( 'admin_print_scripts-' . $options_page, 'heateor_sc_admin_style' );
	add_action( 'admin_print_scripts-' . $options_page, 'heateor_sc_fb_sdk_script' );
}
add_action( 'admin_menu', 'heateor_sc_create_admin_menu' );

/**
 * Include javascript files in admin.
 */	
function heateor_sc_admin_scripts(){
	?>
	<script>var heateorScWebsiteUrl = '<?php echo site_url() ?>', heateorScHelpBubbleTitle = "<?php echo __( 'Click to show help', 'heateor-sc-text' ) ?>", heateorScHelpBubbleCollapseTitle = "<?php echo __( 'Click to hide help', 'heateor-sc-text' ) ?>"; </script>
	<?php
	wp_enqueue_script( 'heateor_sc_admin_scripts', plugins_url( 'js/admin/admin.js', __FILE__ ), array( 'jquery', 'jquery-ui-tabs', 'jquery-ui-sortable' ) );
}

/**
 * Include CSS files in admin.
 */	
function heateor_sc_admin_style(){
	wp_enqueue_style( 'heateor_sc_admin_style', plugins_url( 'css/admin.css', __FILE__ ), false, HEATEOR_SOCIAL_COMMENTS_VERSION );
}

/**
 * Include Javascript SDK in admin.
 */	
function heateor_sc_fb_sdk_script(){
	wp_enqueue_script( 'heateor_sc_fb_sdk_script', plugins_url( 'js/admin/fb_sdk.js', __FILE__ ), false, HEATEOR_SOCIAL_COMMENTS_VERSION );
}

function heateor_sc_plugin_settings_fields() {
	register_setting( 'heateor_sc_options', 'heateor_sc', 'heateor_sc_validate_options' );
	// show option to disable sharing on particular page/post
	$post_types = get_post_types( array( 'public' => true ), 'names', 'and' );
	if ( count( $post_types ) ) {
		foreach( $post_types as $type ) {
			add_meta_box( 'heateor_sc_meta', 'Heateor Social Comments', 'heateor_sc_comments_meta_setup', $type );
		}
		// save sharing meta on post/page save
		add_action( 'save_post', 'heateor_sc_save_comments_meta' );
	}
}
add_action( 'admin_init', 'heateor_sc_plugin_settings_fields' );

/**
 * Show social comments meta options
 */
function heateor_sc_comments_meta_setup(){
	global $post;
	$post_type = $post->post_type;
	$comments_meta = get_post_meta( $post->ID, '_heateor_sc_meta', true );
	?>
	<p>
		<label for="heateor_sc_comments">
			<input type="checkbox" name="_heateor_sc_meta[disable_comments]" id="heateor_sc_comments" value="1" <?php @checked( '1', $comments_meta['disable_comments'] ); ?> />
			<?php _e( 'Disable Social Comments on this '.$post_type, 'heateor-sc-text' ) ?>
		</label>
	</p>
	<?php
    echo '<input type="hidden" name="heateor_sc_meta_nonce" value="' . wp_create_nonce( __FILE__ ) . '" />';
}

/**
 * Save social comments meta fields.
 */
function heateor_sc_save_comments_meta( $post_id ) {
    // make sure data came from our meta box
    if ( ! isset( $_POST['heateor_sc_meta_nonce'] ) || ! wp_verify_nonce( $_POST['heateor_sc_meta_nonce'], __FILE__ ) ) {
		return $post_id;
 	}
    // Bail if we're doing an auto save
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	// Return if it's a post revision
	if ( false !== wp_is_post_revision( $post_id ) ) return;
    
    // check user permissions
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}

    if ( isset( $_POST['_heateor_sc_meta'] ) ) {
		$options = $_POST['_heateor_sc_meta'];
	} else {
		$options = array();
	}
	update_post_meta( $post_id, '_heateor_sc_meta', $options );

    return $post_id;
}

/**
 * Display notification message when plugin options are saved
 */
function heateor_sc_settings_saved_notification(){
	if( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] == 'true' ) {
		return '<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible below-h2"> 
<p><strong>' . __('Settings saved', 'heateor-sc-text') . '</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">' . __('Dismiss this notice', 'heateor-sc-text') . '</span></button></div>';
	}
}

/**
 * Plugin options page.
 */	
function heateor_sc_option_page() {
	global $heateor_sc_options;
	echo heateor_sc_settings_saved_notification();
	require 'admin/plugin-options.php';
}

/** 
 * Validate plugin options
 */ 
function heateor_sc_validate_options( $options ) {
	foreach( $options as $k => $v ) {
		if( is_array($v) ) {
			$options[$k] = $options[$k];
		} elseif( trim( $v ) == '' ) {
			unset( $options[$k] );
		} else {
			$options[$k] = trim( esc_attr( $v ) );
		}
	}
	return $options;
}

/**
 * When plugin is activated
 */
function heateor_sc_default_options() {
	// plugin version
	update_option( 'heateor_sc_version', HEATEOR_SOCIAL_COMMENTS_VERSION );
			
	// counter options
	add_option( 'heateor_sc', array(
	   'commenting_layout' => 'tabbed',
	   'commenting_label' => 'Leave a Reply',
	   'commenting_order' => 'wordpress,facebook,googleplus,disqus',
	   'footer_script' => '1',
	   'enable_post' => '1',
	   'enable_page' => '1',
	   'enable_wordpresscomments' => '1',
	   'label_wordpress_comments' => 'Default Comments',
	   'enable_wordpressicon' => '1',
	   'enable_facebookcomments' => '1',
	   'label_facebook_comments' => 'Facebook Comments',
	   'enable_facebookicon' => '1',
	   'comment_lang' => get_locale(),
	   'label_googleplus_comments' => 'G+ Comments',
	   'enable_googleplusicon' => '1',
	   'label_disqus_comments' => 'Disqus Comments',
	   'enable_disqusicon' => '1',
	) );
}
register_activation_hook( __FILE__, 'heateor_sc_default_options' );