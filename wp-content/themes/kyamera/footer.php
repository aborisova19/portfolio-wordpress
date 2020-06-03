<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Moral
 */

$default = kyamera_get_default_mods();
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<!-- supports col-1, col-2, col-3 and col-4 -->
		<!-- supports unequal-width and equal-width -->
		<?php  
		$count = 0;
		for ( $i=1; $i <=4 ; $i++ ) { 
			if ( is_active_sidebar( 'footer-' . $i ) ) {
				$count++;
			}
		}
		
		if ( 0 !== $count ) : ?>
			<div class="footer-widgets-area page-section col-<?php echo esc_attr( $count );?>">
			    <div class="wrapper">
					<?php 
					for ( $j=1; $j <=4; $j++ ) { 
						if ( is_active_sidebar( 'footer-' . $j ) ) {
			    			echo '<div class="hentry">';
							dynamic_sidebar( 'footer-' . $j ); 
			    			echo '</div>';
						}
					}
					?>
				</div><!-- .wrapper -->
			</div><!-- .footer-widget-area -->

		<?php endif;
		 
		$footer_menu = get_theme_mod( 'kyamera_enable_footer_social_menu', true );

			$footer_class = ( $footer_menu ) ? 'col-2' : 'col-1' ;
			?>
			<div class="site-info <?php echo esc_attr( $footer_class ); ?>">
				<!-- supports col-1 and col-2 -->
				<?php 

				?>
				<div class="wrapper">

					    <span class="footer-copyright">
					        <?php esc_html_e( 'Theme: Kyamera by ', 'kyamera' );?><a href="<?php echo esc_url( 'http://moralthemes.com/' );?>"><?php esc_html_e( 'Moral Themes', 'kyamera' );?></a>.
					    </span><!-- .footer-copyright -->
				    <?php if ( $footer_menu && has_nav_menu( 'social' ) ) : ?>
					    <span class="social-menu">
						    <?php
								wp_nav_menu( array(
									'theme_location' => 'social',
									'menu_class'	 => 'social-icons',
									'container_class' => 'social-menu',
									'depth'          => 1,
									'link_before'    => '<span class="screen-reader-text">',
									'link_after'     => '</span>' . kyamera_get_svg( array( 'icon' => 'chain' ) ),
								) );
						    ?>
					    </span>
					<?php endif; ?>
				</div><!-- .wrapper -->    
				
			</div><!-- .site-info -->
	</footer><!-- #colophon -->
	
	<?php  
	$backtop = get_theme_mod( 'kyamera_back_to_top_enable', true );
	if ( $backtop ) { ?>
		<div class="backtotop"><?php echo kyamera_get_svg( array( 'icon' => 'up-arrow' ) ); ?></div>
	<?php }	?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
