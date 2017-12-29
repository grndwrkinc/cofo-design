<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ndrscrs
 */

get_header(); 

?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="medium-container" style="background-image: url(<?php the_post_thumbnail_url(); ?>)">	
				<h1 class="white"><span class="highlight"><?php the_title(); ?></span></h1>
				<p><?php the_field('subtitle'); ?></p>
			</div>

			<div id="cart" class="medium-container">
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
