<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Moral
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php do_action( 'wp_body_open' ); ?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'kyamera' ); ?></a>
    
    <div class="menu-overlay"></div>

    <header id="masthead" class="site-header" role="banner">
        <div class="wrapper">
            <div class="site-branding">
                <?php if ( has_custom_logo() ) : ?>
                    <div class="site-logo">
    					<?php the_custom_logo(); ?>
                    </div><!-- .site-logo -->
                <?php endif; ?>

                <div id="site-identity">
                    <?php
					if ( is_front_page() ) : ?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php else : ?>
						<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php
					endif;

					$description = get_bloginfo( 'description', 'display' );
					if ( $description || is_customize_preview() ) : ?>
						<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
					<?php
					endif; ?>
                </div><!-- .site-branding-text -->
            </div><!-- .site-branding -->

            <?php if ( has_nav_menu( 'primary' ) ) : ?>
            <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_html_e( 'Primary Menu', 'kyamera' );?>">
                    <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                        <span class="menu-label"><?php esc_html_e( 'Menu', 'kyamera' );?></span>
                        <svg viewBox="0 0 40 40" class="icon-menu">
                            <g>
                                <rect y="7" width="40" height="2"/>
                                <rect y="19" width="40" height="2"/>
                                <rect y="31" width="40" height="2"/>
                            </g>
                        </svg>
                        <svg viewBox="0 0 612 612" class="icon-close">
                            <polygon points="612,36.004 576.521,0.603 306,270.608 35.478,0.603 0,36.004 270.522,306.011 0,575.997 35.478,611.397 
                            306,341.411 576.521,611.397 612,575.997 341.459,306.011"/>
                        </svg>
                    </button>
                    <?php

					wp_nav_menu( array(
						'theme_location' => 'primary',
						'menu_id'        => 'primary-menu',
						'menu_class'	 => 'menu nav-menu',
						'container'		 => '',
						'container_class' => '',
						'container_id' => 'site-navigation',

                    ) );
                elseif( current_user_can( 'edit_theme_options' ) ): ?>
                    <nav class="main-navigation" id="site-navigation">
                        <ul id="primary-menu" class="menu nav-menu">
                            <li><a href="<?php echo esc_url( admin_url( 'nav-menus.php' ) ); ?>"><?php echo esc_html__( 'Add a menu', 'kyamera' );?></a></li>
                        </ul>
                    </nav>
                <?php endif; ?> 
            </nav><!-- #site-navigation -->
        </div><!-- .wrapper --> 
    </header><!-- #masthead -->

	<div id="content" class="site-content">
