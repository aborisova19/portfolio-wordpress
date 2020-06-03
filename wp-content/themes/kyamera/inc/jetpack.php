<?php
/**
 * Jetpack Compatibility File
 *
 * @link https://jetpack.com/
 *
 * @package Moral
 */

/**
 * Jetpack setup function.
 *
 * See: https://jetpack.com/support/infinite-scroll/
 * See: https://jetpack.com/support/responsive-videos/
 * See: https://jetpack.com/support/content-options/
 */

function kyamera_jetpack_setup() {
	$pagination_type = get_theme_mod( 'kyamera_archive_pagination_type', 'numeric' );

	if ( 'infinite_scroll' === $pagination_type ) {
		// Add theme support for Infinite Scroll.
		add_theme_support( 'infinite-scroll', array(
			'container' => '#kyamera-infinite-scroll',
			'render'    => 'kyamera_infinite_scroll_render',
			'footer'    => 'page',
			'wrapper'	=> false,
			'footer_widgets' => false,
			'posts_per_page' => get_option('posts_per_page'),
		) );
	}

	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );
}
add_action( 'after_setup_theme', 'kyamera_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function kyamera_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		if ( is_search() ) :
			get_template_part( 'template-parts/content', 'search' );
		else :
			get_template_part( 'template-parts/content', get_post_format() );
		endif;
	}
}

/**
 * Sort all Infinite Scroll results alphabetically by post name
 *
 * @param array $args
 * @filter infinite_scroll_query_args
 * @return array
 */
function kyamera_infinite_scroll_query_args( $args ) {
    $args['ignore_sticky_posts']   = true;
    return $args;
}
add_filter( 'infinite_scroll_query_args', 'kyamera_infinite_scroll_query_args' );