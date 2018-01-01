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
			<div class="home-hero" style="background-image: url(<?php the_post_thumbnail_url(); ?>)">
				<?php
				while ( have_posts() ) : the_post(); ?>
				<div class="hero-text large-container">
					<div class="text-lego">
						<?php the_title( '<h1><span class="highlight">', '</span></h1>' ); ?>
						<div class="bordered"> <?php
						the_content();
						$post_object = get_field('featured_product');

						if( $post_object ): 

							$post = $post_object;
							setup_postdata( $post ); ?>

							<a href="<?php the_permalink(); ?>" class="btn">View <?php the_title(); ?></a>

							<?php wp_reset_postdata(); 
						 endif; ?>
						</div>
					</div>
				</div>
				<?php endwhile; // End of the loop.
				?>
			</div>
			
			<div class="section-container home-about-img">
				<?php $image = get_field('secondary_hero_image'); ?>
				<img src="<?php echo $image['url'] ?>" alt="<?php echo $image['alt']; ?>">
			</div>
			
			<div class="medium-container home-about">
				<div class="text-lego">
					<h2><span class="highlight"><?php the_field('secondary_header'); ?></span></h2>
					<div class="bordered">
						<p><?php the_field('secondary_text'); ?></p>
						<a href="/about" class="btn">Learn more <?php the_field('secondary_header'); ?></a>
					</div>
				</div>
			</div>
			
			<div class="section-container home-challenge">
				<div class="medium-container">
					<div class="text-section-offset">
						<p class="pre-header">Design Challenge</p>
						<h2><span class="highlight"><?php the_field('design_challenge_header'); ?></span></h2>
						<p><?php the_field('design_challenge_text'); ?></p>
						<a href="/design-challenge" class="btn">View challenge details</a>
					</div>
				</div>

				<div class="large-container">
					<div>
						<h3>Here's how it works</h3>
						<?php if( have_rows('design_challenge_steps') ): ?>
							<ol class="text-steps">
								<?php $counter = 1; ?>
			    			<?php while( have_rows('design_challenge_steps') ): the_row(); 
			    				
			    				$content = get_sub_field('text'); ?>
			    				<li><span><?php echo '0' . $counter; ?></span><?php if( $content ): echo $content; endif; ?></li>
								<?php $counter++; ?>

			    			<?php endwhile; ?>
			    			</ol>
			    		<?php endif; ?>
			    	</div>
				</div>
			</div>


		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
