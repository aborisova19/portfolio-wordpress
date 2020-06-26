<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package ab-portfolio
 */

get_header();
?>

	<main id="primary" class="site-main">

		<section class="error-404 not-found">
			<header class="page-header">
				
			</header><!-- .page-header -->

			<div class="page-content">
				<h1 class="page-title"><?php esc_html_e( '404', 'ab-portfolio' ); ?></h1>	
				
				<p><?php esc_html_e( 'Oh, noo! It looks like you&rsquo;re lost...', 'ab-portfolio' ); ?></p>
				<button><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">Go back home</a></button>
				
					<?php /*
					get_search_form(); */

					/*the_widget( 'WP_Widget_Recent_Posts' );*/
					?>
					
					<!-- <div class="widget widget_categories">
						<h2 class="widget-title"><?php /* esc_html_e( 'Most Used Categories', 'ab-portfolio' ); */ ?></h2>
						<ul>
							<?php
							/* wp_list_categories(
								array(
									'orderby'    => 'count',
									'order'      => 'DESC',
									'show_count' => 1,
									'title_li'   => '',
									'number'     => 10,
								)
							); */
							?>
						</ul>
					</div> --> <!-- .widget -->

					<?php
					/* translators: %1$s: smiley */
					/* $ab_portfolio_archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'ab-portfolio' ), convert_smilies( ':)' ) ) . '</p>';
					the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$ab_portfolio_archive_content" );

					the_widget( 'WP_Widget_Tag_Cloud' ); */ 
					?>

			</div> <!-- .page-content -->
		</section> <!-- .error-404 -->

	</main> <!-- #main -->

<?php
get_footer();
