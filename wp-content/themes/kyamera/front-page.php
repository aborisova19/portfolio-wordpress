<?php
/**
 * The front page template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Moral
 */

get_header(); 


// Call home.php if Homepage setting is set to latest posts.
if ( kyamera_is_latest_posts() ) {

	require get_home_template();

} elseif ( kyamera_is_frontpage() ) {

	get_template_part( 'frontpage-parts/introduction' ); 

	get_template_part( 'frontpage-parts/products' );

	get_template_part( 'frontpage-parts/about' );
 
	get_template_part( 'frontpage-parts/features' ); 
}

get_footer();
