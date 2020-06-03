<?php
/**
 * The template for displaying case study pages
 *
 *
 * @package WordPress
 * @subpackage Portfolio
 * @since Portfolio 1.0
 */


get_header(); ?>

	<div id="primary" class="site-main sidebar">
		<div class="main-content" role="main">
			<?php while ( have_posts() ) : the_post(); 
                $image=get_field("image"); 
                $size = "full";
				$solution=get_field("solution");
				$tags=get_field("tag");
				$site_link=get_field("site_link"); ?>
				
				<article class="portfolio-project">
					<aside class="portfolio-project-sidebar">		
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<h4><?php echo $solution; ?></h4>
						<?php the_content(); ?>
						
						<ul class="portfolio-tags">
							<li>
								<?php if( $tags ): ?>
									<?php foreach( $tags as $tag ): ?>
										<i class="fas fa-tag"></i>
										<?php echo esc_html( $tag->name ); ?>
									<?php endforeach; ?>
								<?php endif; ?>
							</li>
						</ul>

						<a href="<?php echo $site_link; ?>"><strong>View site</strong></a>
					</aside>
			
					<div class="portfolio-project-images">
                        <figure>
                            <a href="<?php the_permalink(); ?>"><?php echo wp_get_attachment_image($image, $size); ?></a>
                        </figure>
					</div>
				
				</article>
				
			<?php endwhile; // end of the loop. ?>
			

		
		</div><!-- .main-content -->

	</div><!-- #primary -->

	<div>
		<nav id="navigation" class="container">
			<div class="left"><a href="<?php echo site_url('/projects/') ?>">&larr; <span>Back to work</span></a></div>
		</nav>
	</div>	

<?php get_footer(); ?>