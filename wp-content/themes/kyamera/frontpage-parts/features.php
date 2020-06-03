<?php
/**
 * Template part for displaying front page features.
 *
 * @package Moral
 */

// Get default  mods value.
$features = get_theme_mod( 'kyamera_features', 'cat' );

if ( 'disable' === $features ) {
    return;
}

$default = kyamera_get_default_mods();

$features_num = get_theme_mod( 'kyamera_features_num', 3 );

$col_class = '';
if ( $features_num > 4 ) {
    if ( $features_num % 3 === 0 ) {
        $col_class = 3;
    } else {
        $col_class = 4;
    }
} else {
    $col_class = $features_num;
}
$section_title = get_theme_mod( 'kyamera_features_section_title', $default['kyamera_features_section_title'] );

?>
<div id="our-features" class="relative page-section same-background">
    <div class="wrapper">
        <?php if (!empty($section_title)) : ?>
            <div class="section-header">
                <h2 class="section-title"><?php echo esc_html( $section_title ); ?></h2>
            </div><!-- .section-header -->
        <?php endif; ?>
        <div class=" col-<?php echo esc_attr( $col_class ); ?> clear ">
                <?php
                        $features_cat_id = get_theme_mod( 'kyamera_features_cat' );
                        $args = array(
                            'cat' => $features_cat_id,   
                            'posts_per_page' =>  absint( $features_num ),
                        );
                    $query = new WP_Query( $args );

                    $i = 1;
                    if ( $query->have_posts() ) :
                        while ( $query->have_posts() ) :
                            $query->the_post();
                            $features_icon = get_theme_mod( 'kyamera_features_icons_'. $i);
                            
                            ?>

                            <article>
                                <div class="featured-item-wrapper">
                                    <?php if (!empty($features_icon)) : ?>
                                        <div class="feature-icon">
                                            <a href="<?php the_permalink(); ?>"><i class="fa <?php echo esc_attr($features_icon); ?>"></i></a>
                                        </div><!-- .feature-icon -->
                                    <?php endif; ?>

                                    <header class="entry-header">
                                        <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                    </header>

                                    <div class="entry-content">
                                        <?php
                                            $content = get_the_content();
                                             echo wp_trim_words( $content, 20);
                                         ?>
                                    </div><!-- .entry-content -->
                                </div><!-- .featured-item-wrapper -->
                            </article>
                        <?php 
                        $i++;
                        endwhile;
                        wp_reset_postdata();
                    endif;  ?>
                
        </div><!-- .features-items-wrapper -->
    </div><!-- .wrapper -->
</div><!-- #features-section -->
