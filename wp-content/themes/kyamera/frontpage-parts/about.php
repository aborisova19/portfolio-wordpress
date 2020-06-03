<?php
/**
 * Template part for displaying front page imtroduction.
 *
 * @package Moral
 */
// Get default  mods value.
$default = kyamera_get_default_mods();

// Get the content type.
$about = get_theme_mod( 'kyamera_about', 'page' );

// Bail if the section is disabled.
if ( 'disable' === $about ) {
	return;
}

// Query if the content type is either post or page.
	$about_id = get_theme_mod( 'kyamera_about_page' );
	$query = new WP_Query( array( 'post_type' => 'page', 'p' => absint( $about_id ) ) );

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$img_url     = get_the_post_thumbnail_url( $about_id, 'large' );
            $about_title   = get_the_title();
            $about_content = get_the_content();
            $btn_url     = get_permalink();
		}
		wp_reset_postdata();
	}
$btn_txt = get_theme_mod( 'kyamera_about_btn_txt', $default['kyamera_about_btn_txt'] );
$about_background = get_theme_mod( 'kyamera_about_background' );
?>
<div id="about-us" class="relative page-section" style="background-image: url('<?php echo esc_url($about_background); ?>');">
    <div class="overlay"></div>
    <div class="wrapper">
        <article class="has-post-thumbnail">
            <div class="featured-image">
                <a href="<?php echo esc_url($btn_url); ?>"><img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr( $about_title ); ?>"></a>
            </div><!-- .featured-image -->

            <div class="entry-container">
                <header class="section-header">
                    <h2 class="section-title"><a href="<?php echo esc_url($btn_url); ?>"><?php echo esc_html($about_title); ?></a></h2>
                </header>
                <?php if (!empty($about_content) ): ?>  
                
                    <div class="section-content">
                        <?php echo wp_trim_words( $about_content, 70); ?>
                    </div><!-- .section-content -->
                    
                <?php endif ?>
                <?php if ( ( !empty( $btn_txt ) ) && ( !empty( $btn_url ) ) ) :  ?>
	                <div class="read-more">
	                    <a href="<?php echo esc_url($btn_url); ?>" class="btn"><?php echo esc_html($btn_txt); ?></a>
	                </div><!-- .read-more -->
            	<?php endif; ?>
            </div><!-- .entry-container -->
        </article>
    </div><!-- .wrapper -->
</div><!-- #about-us -->