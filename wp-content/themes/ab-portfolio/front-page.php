<?php
/**
 * The template for displaying the homepage
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Portofio
 * @since Portfolio 1.0
 */

get_header(); ?>

	<div class="home-page hero-content">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php the_content(); ?>				
		<?php endwhile; // end of the loop. ?>
		<a href="#work">
			<div id="arrow-down">
				<i class="fas fa-angle-down"></i>
			</div>
		</a>
	</div>

<main id="primary" class="site-main">
	<section id="work" class="homepage-portfolio-projects">
		<div class="">			
			<ul class="portfolio-projects">
				<?php query_posts('posts_per_page=5&post_type=projects&orderby=date&order=asc'); ?>
				<?php while ( have_posts() ) : the_post(); 
					$image=get_field("image"); 
					$size="large";
					$solution=get_field("solution");
					$tags=get_field("tag");
					$site_link=get_field("site_link");
				?>
				
				<li class="individual-portfolio-projects">
					<figure>
						<a href="<?php the_permalink(); ?>"><?php echo wp_get_attachment_image($image, $size); ?></a>
					</figure>
					<div class="individual-project-description">
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
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

						<button><a href="<?php echo $site_link; ?>">View site</a></button>
					</div>
				</li>
					
				<?php endwhile; ?> 
				<?php wp_reset_query(); ?>
			</ul>
		</div>		
	</section>

	<section id="about" class="about-content">
		<div class="wrapper">
			<div class="about-image">
				<img src="<?php echo get_template_directory_uri(). '/img/profile-img.png'; ?>" alt="Profile photo">
			</div>
			<div class="about-text">
				<h2>Hi, I'm Anna</h2>
				<p>
				I’m a self-taught web developer from Denmark. Originally a communication and marketing graduate, I’ve always been drawn to websites and code. 
				I love creating simple, well-organized and aesthetic websites that help you win your customers' heart.
				</p>
				<p>
				When I am not tinkering with code, you can find me dancing kizomba, dancehall or afro house, 
				reading a good book or exploring new places and cultures.
				</p>
				<div id="contact" class="contact-me">
					<h3>Let's connect</h3>
					<a href="mailto:aborisova942@gmail.com">aborisova942@gmail.com</a>
					
					<nav class="social-media-navigation" role="navigation">
							<?php wp_nav_menu( array( 'theme_location' => 'social-media', 'menu_class' => 'social-media-menu' ) ); ?>
					</nav>
				</div>
			</div>
		</div>
	</section>

</main>

<?php get_footer(); ?>