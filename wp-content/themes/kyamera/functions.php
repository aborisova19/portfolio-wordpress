<?php
/**
 * Moral functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Moral
 */

if ( ! function_exists( 'kyamera_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function kyamera_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Moral, use a find and replace
		 * to change 'kyamera' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'kyamera' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		
		add_image_size( 'kyamera-home-blog', 400, 300, true );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary', 'kyamera' ),
			'social' => esc_html__( 'Social', 'kyamera' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'kyamera_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		add_theme_support( 'custom-header', array(
		        'default-image'      => '',
		        'default-text-color' => '000',
		        'width'              => 1920,
		        'height'             => 1080,
		        'flex-width'         => true,
		        'flex-height'        => true,
		    ) );
		 // Register default headers.
		register_default_headers( array(
			'default-banner' => array(
				'url'           => '%s/assets/img/header-image.jpg',
				'thumbnail_url' => '%s/assets/img/header-image.jpg',
				'description'   => esc_html_x( 'Default Banner', 'Header image description', 'kyamera' ),
			),

		) );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );

    	/*
    	 * This theme styles the visual editor to resemble the theme style,
    	 * specifically font, colors, and column width.
     	 */
    	add_editor_style( array( 'assets/css/editor-style.css', kyamera_fonts_url() ) );

    	// Gutenberg support
		add_theme_support( 'editor-color-palette', array(
	       	array(
				'name' => esc_html__( 'Blue', 'kyamera' ),
				'slug' => 'blue',
				'color' => '#2c7dfa',
	       	),
	       	array(
	           	'name' => esc_html__( 'Green', 'kyamera' ),
	           	'slug' => 'green',
	           	'color' => '#07d79c',
	       	),
	       	array(
	           	'name' => esc_html__( 'Orange', 'kyamera' ),
	           	'slug' => 'orange',
	           	'color' => '#ff8737',
	       	),
	       	array(
	           	'name' => esc_html__( 'Black', 'kyamera' ),
	           	'slug' => 'black',
	           	'color' => '#2f3633',
	       	),
	       	array(
	           	'name' => esc_html__( 'Grey', 'kyamera' ),
	           	'slug' => 'grey',
	           	'color' => '#82868b',
	       	),
	   	));

		add_theme_support( 'align-wide' );
		add_theme_support( 'editor-font-sizes', array(
		   	array(
		       	'name' => esc_html__( 'small', 'kyamera' ),
		       	'shortName' => esc_html__( 'S', 'kyamera' ),
		       	'size' => 12,
		       	'slug' => 'small'
		   	),
		   	array(
		       	'name' => esc_html__( 'regular', 'kyamera' ),
		       	'shortName' => esc_html__( 'M', 'kyamera' ),
		       	'size' => 16,
		       	'slug' => 'regular'
		   	),
		   	array(
		       	'name' => esc_html__( 'larger', 'kyamera' ),
		       	'shortName' => esc_html__( 'L', 'kyamera' ),
		       	'size' => 36,
		       	'slug' => 'larger'
		   	),
		   	array(
		       	'name' => esc_html__( 'huge', 'kyamera' ),
		       	'shortName' => esc_html__( 'XL', 'kyamera' ),
		       	'size' => 48,
		       	'slug' => 'huge'
		   	)
		));
		add_theme_support('editor-styles');
		add_theme_support( 'wp-block-styles' );
	}
endif;
add_action( 'after_setup_theme', 'kyamera_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function kyamera_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'kyamera_content_width', 900 );
}
add_action( 'after_setup_theme', 'kyamera_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function kyamera_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Primary Sidebar', 'kyamera' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'kyamera' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s animated animatedFadeInUp">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	for ( $i=1; $i <= 4; $i++ ) { 
		register_sidebar( array(
			'name'          => esc_html__( 'Footer Widget Area ', 'kyamera' )  . $i,
			'id'            => 'footer-' . $i,
			'description'   => esc_html__( 'Add widgets here.', 'kyamera' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s animated animatedFadeInUp">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );
	}
}
add_action( 'widgets_init', 'kyamera_widgets_init' );

/**
 * Register custom fonts.
 */
function kyamera_fonts_url() {
	$fonts_url = '';

	$font_families = array();
	
	/*
	 * Translators: If there are characters in your language that are not
	 * supported by Montserrat, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$lora = _x( 'on', 'Lora font: on or off', 'kyamera' );

	if ( 'off' !== $lora ) {
		$font_families[] = 'Lora:400,400i';
	}

	$open_sans = _x( 'on', 'Open Sans font: on or off', 'kyamera' );

	if ( 'off' !== $open_sans ) {
		$font_families[] = 'Open Sans:400,600,700';
	}

	$oxygen = _x( 'on', 'Oxygen font: on or off', 'kyamera' );

	if ( 'off' !== $oxygen ) {
		$font_families[] = 'Oxygen:400,700';
	}

	$query_args = array(
		'family' => urlencode( implode( '|', $font_families ) ),
		'subset' => urlencode( 'latin,latin-ext' ),
	);

	$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );

	return esc_url_raw( $fonts_url );
}

/**
 * Enqueue scripts and styles.
 */
function kyamera_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'kyamera-fonts', kyamera_fonts_url(), array(), null );
	
	wp_enqueue_style( 'font-awesome', get_theme_file_uri() . '/assets/css/font-awesome.css', '', '4.7.0' );

	wp_enqueue_style( 'slick', get_theme_file_uri() . '/assets/css/slick.css', '', '1.8.0' );

	wp_enqueue_style( 'slick-theme', get_theme_file_uri() . '/assets/css/slick-theme.css', '', '1.8.0' );

	// blocks
	wp_enqueue_style( 'kyamera-blocks', get_template_directory_uri() . '/assets/css/blocks.css' );

	wp_enqueue_style( 'kyamera-style', get_stylesheet_uri() );

	wp_enqueue_script( 'jquery-matchHeight', get_theme_file_uri( '/assets/js/jquery.matchHeight.js' ), array( 'jquery' ), '20151215', true );

	wp_enqueue_script( 'slick-jquery', get_theme_file_uri( '/assets/js/slick.js' ), array( 'jquery' ), '20151215', true );

	wp_enqueue_script( 'kyamera-navigation', get_theme_file_uri( '/assets/js/navigation.js' ), array(), '20151215', true );

	wp_enqueue_script( 'kyamera-skip-link-focus-fix', get_theme_file_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20151215', true );

	wp_enqueue_script( 'kyamera-custom', get_theme_file_uri( '/assets/js/custom.js' ), array( 'jquery' ), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'kyamera_scripts' );

/**
 * Enqueue editor styles for Gutenberg
 *
 * @since Kyamera 1.0.0
 */
function kyamera_block_editor_styles() {
	// Block styles.
	wp_enqueue_style( 'kyamera-block-editor-style', get_theme_file_uri( '/assets/css/editor-blocks.css' ) );
	// Add custom fonts.
	wp_enqueue_style( 'kyamera-fonts', kyamera_fonts_url(), array(), null );
}
add_action( 'enqueue_block_editor_assets', 'kyamera_block_editor_styles' );

/**
 * Custom template tags for this theme.
 */
require get_parent_theme_file_path( '/inc/template-tags.php' );

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_parent_theme_file_path( '/inc/template-functions.php' );

/**
 * Customizer additions.
 */
require get_parent_theme_file_path( '/inc/customizer.php' );

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_parent_theme_file_path() . '/inc/jetpack.php';
}

/**
 * SVG icons functions and filters.
 */
require get_parent_theme_file_path( '/inc/icon-functions.php' );

/**
 * Breadcrumb trail class.
 */
require get_parent_theme_file_path( '/inc/class-breadcrumb-trail.php' );

/**
 * Metabox
 */
require get_parent_theme_file_path( '/inc/metabox.php' );

/**
 * TGMPA call
 */
require get_parent_theme_file_path( '/inc/tgmpa/call.php' );

/**
 * OCDI compatibility.
 */
if ( class_exists( 'OCDI_Plugin' ) ) {
	require get_parent_theme_file_path( '/inc/ocdi.php' );
} 


/**
 * Styles the header image and text displayed on the blog.
 *
 * @see kyamera_custom_header_setup().
 */
function kyamera_header_text_style() {
	// If we get this far, we have custom styles. Let's do this.
	$header_text_display = get_theme_mod( 'kyamera_header_text_display', true );
	?>
	<style type="text/css">
	<?php if ( ! $header_text_display ) : ?>
		#site-identity {
			display: none;
		}
	<?php endif; ?>

	.site-title a{
		color: <?php echo esc_attr( get_theme_mod( 'kyamera_header_title_color', '#cf3140' ) ); ?>;
	}
	.site-description {
		color: <?php echo esc_attr( get_theme_mod( 'kyamera_header_tagline', '#2e2e2e' ) ); ?>;
	}
	</style>
	<?php
}
add_action( 'wp_head', 'kyamera_header_text_style' );

/**
 *
 * Reset all setting to default.
 *
 */
function kyamera_reset_settings() {
    $reset_settings = get_theme_mod( 'kyamera_reset_settings', false );
    if ( $reset_settings ) {
        remove_theme_mods();
    }
}
add_action( 'customize_save_after', 'kyamera_reset_settings' );


if ( ! function_exists( 'kyamera_exclude_sticky_posts' ) ) {
    function kyamera_exclude_sticky_posts( $query ) {
        if ( ! is_admin() && $query->is_main_query() && $query->is_home() ) {
            $sticky_posts = get_option( 'sticky_posts' );  
            if ( ! empty( $sticky_posts ) ) {
            	$query->set('post__not_in', $sticky_posts );
            }
            $query->set('ignore_sticky_posts', true );
        }
    }
}
add_action( 'pre_get_posts', 'kyamera_exclude_sticky_posts' );