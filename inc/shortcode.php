<?php
defined('ABSPATH') or die("Cheating........Uh!!");
/** 
 * Shortcode for Social Commenting.
 */ 
function heateor_sc_commenting_shortcode($params){
	global $heateor_sc_options;
	extract(shortcode_atts(array(
		'style' => ''
	), $params));
	$commentsOrder = $heateor_sc_options['commenting_order'];
	$commentsOrder = explode( ',', $commentsOrder );
	
	$tabs = '';
	$divs = '';

	foreach( $commentsOrder as $order ) {
		$order = trim( $order );
		if ( ! isset( $heateor_sc_options['enable_' .$order. 'comments'] ) || $order == 'wordpress' ) { continue; }
		
		$comment_div = '';
		if ( $order == 'facebook' ) {
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
	$commentingHtml = '<div class="heateor_sc_social_comments" ' . ( $style != '' ? 'style="' . $style . '"' : '' ) . '>';
	if ( $tabs ) {
		$commentingHtml .= ( isset( $heateor_sc_options['commenting_label'] ) ? '<div style="clear:both"></div><h3 class="comment-reply-title">' . $heateor_sc_options['commenting_label'] . '</h3><div style="clear:both"></div>' : '' ) . '<ul>' . $tabs . '</ul>';
	}
	$commentingHtml .= $divs;
	$commentingHtml .= '</div>';
	return $commentingHtml;
}
add_shortcode('Heateor-SC', 'heateor_sc_commenting_shortcode');