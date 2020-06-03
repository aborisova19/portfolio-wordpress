<?php
/**
 * Template part for displaying front page products.
 *
 * @package Moral
 */

// Get default  mods value.
$products = get_theme_mod( 'kyamera_products', 'page' );

if ( 'disable' === $products ) {
	return;
}

$default = kyamera_get_default_mods();
$section_title = get_theme_mod( 'kyamera_products_title', $default['kyamera_products_title'] );

?>
<div id="popular-products" class="relative page-section same-background">
    <div class="wrapper">
    	<?php if( !empty($section_title)):?>
	        <div class="section-header">
	            <h2 class="section-title"><?php echo esc_html( $section_title); ?></h2>
	        </div><!-- .section-header -->
    	<?php endif; ?>

        <div class="product-slider" data-slick='{"slidesToShow": 3, "slidesToScroll": 1, "infinite": false, "speed": 1000, "dots": false, "arrows":true, "autoplay": false, "draggable": true, "fade": false }'>
				<?php
						$id_arr = array();
						for ( $i=1; $i <= 4; $i++ ) { 
							$product_id = get_theme_mod( "kyamera_products_page_" . $i );
							if ( $product_id ) {
								$id_arr[] = $product_id;
							}
						}
						$args = array(
							'post_type' => 'page',
							'post__in' => (array)$id_arr,	
							'posts_per_page' => 4,
                            'orderby'   => 'post__in',
							'ignore_sticky_posts' => true,
						);

					$query = new WP_Query( $args );

					if ( $query->have_posts() ) {
						while ( $query->have_posts() ) {
							$query->the_post();
							?>
		                        <article>
		                            <a href="<?php the_permalink(); ?>"><img src=" <?php the_post_thumbnail_url(); ?>" alt="<?php echo esc_attr(the_title() ) ?>"></a>
		                        </article>

						<?php	
						}
						wp_reset_postdata();
					}?>
            </div><!-- .product-slider -->
        </div><!-- .wrapper -->
    </div><!-- #popular-products -->