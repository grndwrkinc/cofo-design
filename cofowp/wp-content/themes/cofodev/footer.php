<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ndrscrs
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="footer-cta dark slideup">
			<div class="medium-container">
				
				<div class="newsletter">
					<p>Let's keep in touch!</p>
					<a href="http://www.google.ca" class="btn">Join our mailing list</a>
				</div>
				<div class="social-nav">
					<?php wp_nav_menu( array(
					    'menu' => 'Social Media Footer Menu' // Do not fall back to first non-empty menu.
					) ); ?>
				</div>
				<?php wp_nav_menu( array(
				    'menu' => 'Footer Menu' // Do not fall back to first non-empty menu.
				) ); ?>
			</div>
		</div>
		<div class="footer-nav medium-container">
			<p><a href="<?php get_home_url(); ?>">
				<img class="v-logo" src="/wp-content/themes/cofodev/assets/images/VisualElements.png" alt="">
			</a></p>
			<p><a href="<?php get_home_url(); ?>">
				<img class="logo" src="/wp-content/themes/cofodev/assets/images/logo-black.svg" alt="">
			</a></p>
			<p>Copyright © COFO Design</p>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
