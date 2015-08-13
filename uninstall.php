<?php
//if uninstall not called from WordPress, exit
if( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}
$heateor_sc_options = get_option( 'heateor_sc' );
if( isset( $heateor_sc_options['delete_options'] ) ) {
	global $wpdb;
	// For Single site
	if( ! is_multisite() ) {
		delete_option( 'heateor_sc' );
		$wpdb->query( "DELETE FROM $wpdb->postmeta WHERE meta_key LIKE '_heateor_sc%'" );
	} else {
		// For Multisite
		$heateor_sc_blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
		$heateor_sc_original_blog_id = get_current_blog_id();
		foreach ( $heateor_sc_blog_ids as $blog_id ) {
			switch_to_blog( $blog_id );
			delete_site_option( 'heateor_sc' );
		}
		switch_to_blog( $heateor_sc_original_blog_id );
	}
}