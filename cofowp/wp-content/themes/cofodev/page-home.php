<?php
/**
 * Template Name: Home Page
 * Description: Only for use on home page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package ndrscrs
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) : the_post();

			the_title( '<h1>', '</h1>' ); 
			the_content();

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
