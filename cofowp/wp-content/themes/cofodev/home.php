<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ndrscrs
 */

get_header(); 
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

<?php
		if ( have_posts() ) :
			global $first;
			$first = true;
			// $containerClass = "large-container";

			/* Start the Loop */
			while ( have_posts() ) : the_post();
?>
			<?php /* <div class="<?php echo $containerClass; ?>"> */ ?>
<?php
				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				//get_template_part( 'template-parts/content', 'get_post_format()' );

				get_template_part( 'template-parts/content', 'blog_index' );
?>
			<?php /* </div> */ ?>
<?php
			if($first) {
				// $containerClass = "medium-container";
				$first = false;
			}
			endwhile;

			// the_posts_navigation();
			// echo do_shortcode('[ajax_load_more id="6296152368" container_type="div" post_type="post" button_label="Load more"]');
			echo do_shortcode('[ajax_load_more container_type="div" post_type="post" posts_per_page="4" offset="4" pause="true" scroll="false" images_loaded="true" button_label="Load more"]');

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
// get_sidebar();

get_footer();
