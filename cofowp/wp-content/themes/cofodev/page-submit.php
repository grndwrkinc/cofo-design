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
			<section class="hero">
				<div class="large-container">
					<div class="hero-text">
						<h1><span class="lowlight"><?php the_title(); ?></span></h1>
					<?php while ( have_posts() ) : the_post();
						the_content(); 
					endwhile; ?>
					</div>
				</div>
			</section>
			<div class="medium-container form-container">
				
				<?php 
				$formcode = get_field('submission_form_shortcode');
				echo do_shortcode($formcode); 
				?>
				                              
			</div>
			<div class="challenge-share anm-container fadein">
				<h4 class="anm-item slideright-item">Share the challenge</h4>
				<div class="social-nav anm-item slideright-item">
					<ul>
						<li>
							<?php global $wp;
							$url = home_url( $wp->request ); ?>
							<a class="social-share" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
						<li><a class="social-share" href="https://twitter.com/intent/tweet?text=Hello%20world" data-size="large" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
					</ul>
				</div>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
