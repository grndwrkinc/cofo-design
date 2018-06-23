<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package ndrscrs
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
<?php
	if(has_post_thumbnail()) {
?>
			<div class="hero" style="background-image: url(<?php the_post_thumbnail_url(); ?>)"></div>

<?php
	}

		while ( have_posts() ) : the_post();
?>
			<div class="post-wrapper medium-container <?php if(!has_post_thumbnail()) {?>post-no-hero<?php } ?>">
				<div class="post-content slideup small-container">
					<h1><?php echo the_title(); ?></h1>
<?php
					the_content();
?>
				</div>

				<div class="post-sidebar anm-container"> 
					<ul class="post-meta anm-container anm-item slideright-item">
						<li class="anm-item slideright-item"><?php the_author(); ?></li>
						<li class="anm-item slideright-item"><?php the_date(); ?></li>
					</ul>

					<div class="social anm-item slideright-item">
						<div class="social-nav">
							<h4 class="slideright">Share</h4>
							<ul class="anm-container">
								<li class="anm-item slideright-item"><a class="social-share" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
								<li class="anm-item slideright-item"><a class="social-share" href="https://twitter.com/intent/tweet?text=<?php echo urlencode(strip_tags(get_the_title())); ?> <?php the_permalink() ?>" data-size="large" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<div class="post-navigation-container large-container">
				<div class="bordered slideup">
<?php
				the_post_navigation(array(
					'prev_text' => '<p class="pre-header">Previous</p><h4>%title</h4>',
					'next_text' => '<p class="pre-header">Next</p><h4>%title</h4>',
				));
?>
				</div>
<?php
		endwhile; // End of the loop.
?>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
