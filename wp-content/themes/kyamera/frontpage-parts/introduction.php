<?php
/**
 * Template part for displaying front page imtroduction.
 *
 * @package Moral
 */
// Get default  mods value.
$default = kyamera_get_default_mods();

// Get the content type.
$introduction = get_theme_mod( 'kyamera_introduction');

// Bail if the section is disabled.
if ( 'disable' === $introduction ) {
	return;
}

// Query if the content type is either post or page.

	$introduction_id = get_theme_mod( 'kyamera_introduction_page' );

	$query = new WP_Query( array( 'post_type' => 'page', 'p' => absint( $introduction_id ) ) );

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$img_url     = get_the_post_thumbnail_url( $introduction_id, 'large' );
			$intro_title   = get_the_title();
			$content = get_the_content();
			$btn_url     = get_permalink();
		}
		wp_reset_postdata();
	}

$btn_txt = get_theme_mod( 'kyamera_introduction_btn_txt', $default['kyamera_introduction_btn_txt'] );
?>
<div id="introduction-section" class="relative page-section same-background">
        <div class="wrapper">
            <article>
                <div class="entry-container">
                    <div class="entry-header">
                        <h2 class="entry-title"><?php echo esc_html($intro_title); ?></h2>
                    </div><!-- .entry-header -->

                    <div class="entry-content">
                        <?php echo wp_trim_words( $content, 10);?>
                    </div><!-- .entry-content -->
                    <?php if ( (!empty($btn_txt) ) && (!empty($btn_url)) ) : ?>
                        <div class="buy-now">
                            <a href="<?php echo esc_url($btn_url); ?>" class="btn"><?php echo esc_html($btn_txt); ?></a>
                        </div><!-- .read-more -->
                	<?php endif; ?>
                </div><!-- .entry-container -->

                <div class="featured-image">
                    <a href="<?php echo esc_url($btn_url); ?>"><img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($intro_title); ?>"></a>
                </div><!-- .featured-image -->
            </article>
        </div><!-- .wrapper -->
</div><!-- #introduction-section -->