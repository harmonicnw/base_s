<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Harmonic Northwest Underscores Base Theme
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function hnw_base_s_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'footer'    => 'page',
	) );
}
add_action( 'after_setup_theme', 'hnw_base_s_jetpack_setup' );
