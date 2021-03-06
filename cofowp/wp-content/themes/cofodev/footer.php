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
			<div class="medium-container anm-container">
				
				<div class="newsletter anm-item slideup-item">
					<p>Let's keep in touch</p>
					<a href="http://eepurl.com/dgO0jL" target="_blank" class="btn">Join our mailing list</a>
				</div>
				<div class="social-nav anm-item slideup-item">
					<?php wp_nav_menu( array(
					    'menu' => 'Social Media Footer Menu' // Do not fall back to first non-empty menu.
					) ); ?>
				</div>
				<div class="anm-item slideup-item">
				<?php wp_nav_menu( array(
				    'menu' => 'Footer Menu' // Do not fall back to first non-empty menu.
				) ); ?>
				</div>
			</div>
		</div>
		<div class="footer-nav medium-container">
			<p class="v-logo"><a href="http://www.visual-elements.ca/" target="_blank">
				<img src="/wp-content/themes/cofodev/assets/images/VisualElements.png" alt="">
			</a></p>
			<p class="logo"><a href="<?php echo get_home_url(); ?>">
				<img src="/wp-content/themes/cofodev/assets/images/logo-black-1.svg" alt="">
			</a></p>
			<p class="copyright">Copyright © COFO Design</p>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
