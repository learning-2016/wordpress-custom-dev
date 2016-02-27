<?php
/**
 * Theme Functions
 *
 * Various functions to use through out site such as breadcrumb, pagination, etc
 *
 * @package ABARIS
 *
 * @since 1.0
 *
 */

	// cleaning up excerpt
	add_filter('excerpt_more', 'abaris_excerpt_more');

	// This removes the annoying […] to a Read More link

if( ! function_exists( 'abaris_excerpt_more' )) {

	function abaris_excerpt_more($excerpt) {
		global $post;
		// edit here if you like
		return '<p class="readmore"><a href="'. get_permalink($post->ID) . '" title="Read '.get_the_title($post->ID).'">Read more &raquo;</a></p>';
	}
}

if( ! function_exists( 'abaris_excerpt_length' )) {

	function abaris_excerpt_length( $length ) {
		return 20;
	}
}

	add_filter( 'excerpt_length', 'abaris_excerpt_length', 999 );
	add_action( 'wp_head', 'abaris_custom_css' );

	function abaris_custom_css() {
		global $abaris;
		if( isset( $abaris['custom-css'] ) ) {
			$custom_css = '<style type="text/css">' . $abaris['custom-css'] . '</style>';
			echo $custom_css;
		}
	}

	add_action( 'wp_footer', 'abaris_custom_js', 99 );
	
	function abaris_custom_js() {
		global $abaris;
		if( isset( $abaris['custom-js'] ) ) {
			$custom_js = '<script type="text/javascript"><!--';
	 		$custom_js .= $abaris['custom-js'];
	 		$custom_js .= '//--><!]]></script>';
	 		echo $custom_js;
		}
	}