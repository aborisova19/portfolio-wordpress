<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ab-portfolio
 */

?>
	<footer id="colophon" class="site-footer">
		<div class="site-info">
			<div class="copyright">
				<?php
				/* translators: 1: Theme name, 2: Theme author. */
				printf( '© 2020 ab-codes.com' );
				?>
			</div>
		</div><!-- .site-info -->

		<div class="back-top">
			<a href="<?php echo home_url(); ?>">
				<button>
					<i class="fas fa-angle-up"></i>
				
				</button> <!-- back to top button -->
			</a>
		</div>
		
	</footer><!-- #colophon -->

<?php wp_footer(); ?>

</body>
</html>
