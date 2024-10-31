<?php
/*
Plugin Name: Noindex Duplicate Posts
Plugin URI: http://wordpress.org/extend/noindex-duplicate-posts/
Description: This plugin will automatically add a 'Noindex' meta tag to posts that are a duplicate determined by the slug and preexisting post names. The original post will not include the 'Noindex' tag.
Version: 1.0
Author: Kane Andrews
Author URI: http://kaneandre.ws
*/

function noindex_duplicate_posts() {
	if ( is_single() ) {
		global $wpdb;
		global $post;
		$name = $post->post_name;
		$name_split = explode( "-", $name );
		$end = end( $name_split );
		$og_name = str_replace( "-".$end, "", $name );
		if ( is_numeric( $end )) {	
			$post_exists = $wpdb->get_row( "SELECT * FROM $wpdb->posts WHERE post_name = '" . $og_name . "'", 'ARRAY_A' );
			if( $post_exists ){
				echo "<meta name=\"robots\" content=\"noindex, follow\" />\n";
			}
		}
	}
}
add_action( 'wp_head', 'noindex_duplicate_posts', 2 );
?>