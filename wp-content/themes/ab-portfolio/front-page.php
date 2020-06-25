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


	<?php $image = wp_get_attachment_url(get_post_thumbnail_id($post->ID)); ?>

	<section class="home-page custom hero-content" 
			style="background:url('<?php echo $image; ?>');
            background-position:center;
            background-size:cover;"> 

		<div class="hero-container">
        	<!-- ACF Text Field #1 -->
			<?php if( get_field('hero_greeting') ): ?>
			<p><?php the_field('hero_greeting'); ?></p>

			<!-- If no ACF Field use page title -->
			<?php else: ?>
			<h1><?php the_title(); ?></h1>
			<?php endif; ?>
        
			<!-- ACF Text Field #2 -->
			<?php if( get_field('hero_text') ): ?>
			<h2><?php the_field('hero_text'); ?></h2>
			<?php endif; ?>
    	</div>
		
		<a href="#work">
			<div id="arrow-down">
				<i class="fas fa-angle-down"></i>
			</div>
		</a>
	
	</section>
	

<main id="primary" class="site-main">
	<div class="page-content">		
		<section id="work" class="portfolio-projects-content">
			<h3>Selected projects</h3>

			<ul class="portfolio-projects">
				<?php query_posts('posts_per_page=5&post_type=projects&orderby=date&order=asc'); ?>
				<?php while ( have_posts() ) : the_post(); 
					$image=get_field("image"); 
					$size="large";
					$solution=get_field("solution");
					$tags=get_field("tag");
					$site_link=get_field("site_link");
					$code_link=get_field("code_link");
				?>
				
				<li class="individual-portfolio-projects">
					<figure>
						<a href="<?php echo $code_link ?>" target="blank"><?php echo wp_get_attachment_image($image, $size); ?></a>
					</figure>
					<div class="individual-project-description">
						<h2><a href="<?php echo $code_link ?>" target="blank"><?php the_title(); ?></a></h2>
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

						<?php if( $site_link ): ?>
							<button><a href="<?php echo $site_link; ?>" target="blank">View site</a></button>				
						<?php endif ?>

						<?php if( $code_link ): ?>			
							<button class="code-link"><a href="<?php echo $code_link; ?>" target="blank">View code</a></button>
						<?php endif ?>
					</div>
				</li>
					
				<?php endwhile; ?> 
				<?php wp_reset_query(); ?>
			</ul>	

			<p class="more-projects">See more projects and experiments on my <a href="<?php echo esc_url('https://github.com/aborisova19'); ?>" target="blank">GitHub page</a></p>
		</section>
	</div>	

	<section id="about" class="about-content">
			<div class="wrapper">	
				<div class="about-image">
					<img src="<?php the_field('about_image'); ?>" alt="Profile photo">
					<!--<img src="<?php /* echo get_template_directory_uri(). '/img/profile-img.png'; */ ?>" alt="Profile photo"> -->
				</div>
				<div class="about-text">
					<h2><?php the_field('about_title'); ?></h2>
					<p><?php the_field('about_text'); ?></p>

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