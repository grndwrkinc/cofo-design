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
			<section class="hero" style="background-image: url(<?php the_post_thumbnail_url(); ?>)">
				<?php
				while ( have_posts() ) : the_post(); ?>
				<div class="hero-text large-container">
					<h1><span class="highlight"><?php the_title(); ?></span></h1>
					<div class="bordered"> <?php
					the_content();
					$post_object = get_field('featured_product');

					if( $post_object ): 

						$post = $post_object;
						setup_postdata( $post ); ?>

						<a href="<?php the_permalink(); ?>" class="btn">View <?php the_title(); ?></a>

						<small>Now accepting pre-orders for April delivery</small>

						<?php wp_reset_postdata(); 
					 endif; ?>
					</div>
				</div>
				<?php endwhile; // End of the loop.
				?>
			</section>
			
			<section class="home-about">
				<div class="home-about-img">
					<?php $image = get_field('secondary_hero_image'); ?>
					<img class="fadein" src="<?php echo $image['url'] ?>" alt="<?php echo $image['alt']; ?>">
				</div>
				
				<div class="medium-container home-about-content anm-container">
					<h2 class="anm-item slideright-item"><span class="highlight"><?php the_field('secondary_header'); ?></span></h2>
					<div class="bordered anm-item slideright-item">
						<p><?php the_field('secondary_text'); ?></p>
						<a href="/about" class="btn">Learn more <?php the_field('secondary_header'); ?></a>
					</div>
				</div>
			</section>
			
			<section class="home-challenge">
				<div class="medium-container">
					<div class="text-section-offset fadein anm-container">
						<p class="pre-header anm-item slideright-item">Design Challenge</p>
						<h2 class="anm-item slideright-item"><span class="highlight"><?php the_field('design_challenge_header'); ?></span></h2>
						<p class="anm-item slideright-item"><?php the_field('design_challenge_text'); ?></p>
						<!-- <p class=" anm-item slideright-item"><a href="/design-challenge" class="btn">View challenge details</a></p> -->
						<p class=" anm-item slideright-item"><a href="/design-challenge" class="btn">Learn more</a></p>
					</div>
				</div>

				<div class="large-container">
					<div>
						<div class="slideup">
							<h3>Here's how it works</h3>
						</div>
						<?php if( have_rows('design_challenge_steps') ): ?>
							<ol class="text-steps anm-container">
								<?php $counter = 1; ?>
			    			<?php while( have_rows('design_challenge_steps') ): the_row(); 
			    				
			    				$content = get_sub_field('text'); ?>
			    				<li class="slideright-item anm-item"><span><?php echo '0' . $counter; ?></span><?php if( $content ): echo $content; endif; ?></li>
								<?php $counter++; ?>

			    			<?php endwhile; ?>
			    			</ol>
			    		<?php endif; ?>
			    	</div>
				</div>

				<div class="medium-container full-collection anm-container">
					<h2 class="anm-item slideright-item"><span class="highlight">Full <br/>Collection <br/>Coming</span></h2>
					<div class="bordered anm-item slideright-item">
						<h3>Fall 2018</h3>
					</div>
				</div>
			</section>


		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
