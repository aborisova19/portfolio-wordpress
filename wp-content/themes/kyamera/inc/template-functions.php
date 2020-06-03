<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Moral
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function kyamera_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
	
	// When global archive layout is checked.
	if ( is_archive() || kyamera_is_latest_posts() || is_404() || is_search() ) {
		$archive_sidebar = get_theme_mod( 'kyamera_archive_sidebar', 'right' ); 
		$classes[] = esc_attr( $archive_sidebar ) . '-sidebar';
	} else if ( is_single() ) { // When global post sidebar is checked.
    	$kyamera_post_sidebar_meta = get_post_meta( get_the_ID(), 'kyamera-select-sidebar', true );
    	if ( ! empty( $kyamera_post_sidebar_meta ) ) {
			$classes[] = esc_attr( $kyamera_post_sidebar_meta ) . '-sidebar';
    	} else {
			$global_post_sidebar = get_theme_mod( 'kyamera_global_post_layout', 'right' ); 
			$classes[] = esc_attr( $global_post_sidebar ) . '-sidebar';
    	}
	} elseif ( kyamera_is_frontpage_blog() || is_page() ) {
		if ( kyamera_is_frontpage_blog() ) {
			$page_id = get_option( 'page_for_posts' );
		} else {
			$page_id = get_the_ID();
		}

    	$kyamera_page_sidebar_meta = get_post_meta( $page_id, 'kyamera-select-sidebar', true );
		if ( ! empty( $kyamera_page_sidebar_meta ) ) {
			$classes[] = esc_attr( $kyamera_page_sidebar_meta ) . '-sidebar';
		} else {
			$global_page_sidebar = get_theme_mod( 'kyamera_global_page_layout', 'right' ); 
			$classes[] = esc_attr( $global_page_sidebar ) . '-sidebar';
		}
	}

	// Site layout classes
	$site_layout = get_theme_mod( 'kyamera_site_layout', 'wide' );
	$classes[] = esc_attr( $site_layout ) . '-layout';

	return $classes;
}
add_filter( 'body_class', 'kyamera_body_classes' );

function kyamera_post_classes( $classes ) {
	if ( kyamera_is_page_displays_posts() ) {
		// Search 'has-post-thumbnail' returned by default and remove it.
		$key = array_search( 'has-post-thumbnail', $classes );
		unset( $classes[ $key ] );
		
		$archive_img_enable = get_theme_mod( 'kyamera_enable_archive_featured_img', true );

		if( has_post_thumbnail() && $archive_img_enable ) {
			$classes[] = 'has-post-thumbnail';
		} else {
			$classes[] = 'no-post-thumbnail';
		}
	}

  $classes[] = 'animated animatedFadeInUp';
  
	return $classes;
}
add_filter( 'post_class', 'kyamera_post_classes' );

/**
 * Excerpt length
 * 
 * @since Moral 1.0.0
 * @return Excerpt length
 */
function kyamera_excerpt_length( $length ){
	if ( is_admin() ) {
		return $length;
	}

	$length = get_theme_mod( 'kyamera_archive_excerpt_length', 60 );
	return $length;
}
add_filter( 'excerpt_length', 'kyamera_excerpt_length', 999 );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function kyamera_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'kyamera_pingback_header' );

/**
 * Get an array of post id and title.
 * 
 */
function kyamera_get_post_choices() {
	$choices = array( '' => esc_html__( '--Select--', 'kyamera' ) );
	$args = array( 'numberposts' => -1, );
	$posts = get_posts( $args );

	foreach ( $posts as $post ) {
		$id = $post->ID;
		$title = $post->post_title;
		$choices[ $id ] = $title;
	}

	return $choices;
}

/**
 * Get an array of cat id and title.
 * 
 */
function kyamera_get_post_cat_choices() {
  $choices = array( '' => esc_html__( '--Select--', 'kyamera' ) );
	$cats = get_categories();

	foreach ( $cats as $cat ) {
		$id = $cat->term_id;
		$title = $cat->name;
		$choices[ $id ] = $title;
	}

	return $choices;
}

/**
 * Checks to see if we're on the homepage or not.
 */
function kyamera_is_frontpage() {
	return ( is_front_page() && ! is_home() );
}

/**
 * Checks to see if Static Front Page is set to "Your latest posts".
 */
function kyamera_is_latest_posts() {
	return ( is_front_page() && is_home() );
}

/**
 * Checks to see if Static Front Page is set to "Posts page".
 */
function kyamera_is_frontpage_blog() {
	return ( is_home() && ! is_front_page() );
}

/**
 * Checks to see if the current page displays any kind of post listing.
 */
function kyamera_is_page_displays_posts() {
	return ( kyamera_is_frontpage_blog() || is_search() || is_archive() || kyamera_is_latest_posts() );
}

/**
 * Shows a breadcrumb for all types of pages.  This is a wrapper function for the Breadcrumb_Trail class,
 * which should be used in theme templates.
 *
 * @since  1.0.0
 * @access public
 * @param  array $args Arguments to pass to Breadcrumb_Trail.
 * @return void
 */
function kyamera_breadcrumb( $args = array() ) {
	$breadcrumb = apply_filters( 'breadcrumb_trail_object', null, $args );

	if ( ! is_object( $breadcrumb ) )
		$breadcrumb = new Breadcrumb_Trail( $args );

	return $breadcrumb->trail();
}

/**
 * Pagination in archive/blog/search pages.
 */
function kyamera_posts_pagination() { 
	$archive_pagination = get_theme_mod( 'kyamera_archive_pagination_type', 'numeric' );
	if ( 'disable' === $archive_pagination ) {
		return;
	}
	if ( 'numeric' === $archive_pagination ) {
		the_posts_pagination( array(
            'prev_text'          => kyamera_get_svg( array( 'icon' => 'left-arrow' ) ) . esc_html__( 'Previous', 'kyamera' ),
            'next_text'          => esc_html__( 'Next', 'kyamera' ) . kyamera_get_svg( array( 'icon' => 'left-arrow' ) ),
        ) );
	} elseif ( 'older_newer' === $archive_pagination ) {
        the_posts_navigation( array(
            'prev_text'          => kyamera_get_svg( array( 'icon' => 'left-arrow' ) ) . '<span>'. esc_html__( 'Older', 'kyamera' ) .'</span>',
            'next_text'          => '<span>'. esc_html__( 'Newer', 'kyamera' ) .'</span>' . kyamera_get_svg( array( 'icon' => 'left-arrow' ) ),
        )  );
	}
}

function kyamera_get_svg_by_url( $url = false ) {
	if ( ! $url ) {
		return false;
	}

	$social_icons = kyamera_social_links_icons();

	foreach ( $social_icons as $attr => $value ) {
		if ( false !== strpos( $url, $attr ) ) {
			return kyamera_get_svg( array( 'icon' => esc_attr( $value ) ) );
		}
	}
}


// Add auto p to the palces where get_the_excerpt is being called.
add_filter( 'get_the_excerpt', 'wpautop' );

if ( ! function_exists( 'kyamera_the_excerpt' ) ) :

  /**
   * Generate excerpt.
   *
   * @since 1.0.0
   *
   * @param int     $length Excerpt length in words.
   * @param WP_Post $post_obj WP_Post instance (Optional).
   * @return string Excerpt.
   */
  function kyamera_the_excerpt( $length = 0, $post_obj = null ) {

    global $post;

    if ( is_null( $post_obj ) ) {
      $post_obj = $post;
    }

    $length = absint( $length );

    if ( 0 === $length ) {
      return;
    }

    $source_content = $post_obj->post_content;

    if ( ! empty( $post_obj->post_excerpt ) ) {
      $source_content = $post_obj->post_excerpt;
    }

    $source_content = preg_replace( '`\[[^\]]*\]`', '', $source_content );
    $trimmed_content = wp_trim_words( $source_content, $length, '&hellip;' );
    return $trimmed_content;

  }

endif;