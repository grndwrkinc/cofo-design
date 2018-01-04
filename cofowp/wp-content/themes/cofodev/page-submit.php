<?php
/**
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ndrscrs
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<section class="hero" style="background-image: url(<?php the_post_thumbnail_url(); ?>)">
				<div class="large-container">
					<div class="hero-text">
						<h1><span class="lowlight"><?php the_title(); ?></span></h1>
					<?php while ( have_posts() ) : the_post();
						the_content(); 
					endwhile; ?>
					</div>
				</div>
			</section>
			<div class="medium-container">
				<?php 
				$formcode = get_field('submission_form_shortcode');
				echo do_shortcode($formcode); ?>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
