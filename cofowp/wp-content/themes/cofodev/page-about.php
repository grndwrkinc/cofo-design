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

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<section class="hero" style="background-image: url(<?php the_post_thumbnail_url(); ?>)">
				<div class="large-container">
					<div class="hero-text">
						<h1><span class="highlight"><?php the_title(); ?></span></h1>
						<div class="bordered">	
							<p><?php the_field('subtitle'); ?></p>
						</div>
					</div>
				</div>
			</section>

			<section class="about-cofounders-video">
				<div class="text-section-offset"></div>
				<div class="about-video-container">
					<?php the_field('story_section_video'); ?>
				</div>
			</section>

			<section class="about-what-we-do text-section-offset anm-container">
				<div class="small-container">
					<?php
					while ( have_posts() ) : the_post();
						the_content(); 
					endwhile; // End of the loop.
					?>
				</div>
			</section>

			<section class="about-differentiators">
<?php 
    		if( have_rows('text_images_group') ): ?>
    			<div class="inner masonry-gallery">
					<h2 class="slideright"><span class="highlight"><?php the_field('text_images_section_header') ?><span></h2>
<?php 
    			while( have_rows('text_images_group') ): the_row(); 
	    			get_template_part( 'template-parts/content', 'imagetext' );
				endwhile; 
?>
    				<div class="grid-sizer"></div>
    				<div class="gutter-sizer"></div>
				</div>
<?php 
			endif;
?>
			</section>

			<section class="about-process dark">
				<div class="medium-container">
					<h2 class="slideright"><span class="lowlight"><?php the_field('process_section_header'); ?></span></h2>
					<p><?php the_field('process_section_text'); ?></p>
					
					<div class="process-container anm-container">
<?php 
					if( have_rows('process_section_group') ):
						$counter = 1;

						while( have_rows('process_section_group') ): the_row(); 
		    				
							switch($counter) {
								case 1: $animation = "slidedownright"; break;
								case 2: $animation = "slideright"; break;
								case 3: $animation = "slideupright"; break;
								case 4: $animation = "slideleft"; break;
								case 5: $animation = "slideupleft"; break;
							}

		    				$header = get_sub_field('header');
		    				$content = get_sub_field('text'); 
		    				if($counter == 1 || $counter == 4) :
?>
	    					<div class="process-half">
<?php
		    				endif;
?>

			    				<div class="bordered anm-item <?php echo $animation; ?>">
			    					<h3><?php if( $header ): ?>
			    						<?php echo $header; ?>
			    					<?php endif; ?></h3>
			    					<p><?php if( $content ): ?>
			    						<?php echo $content; ?>
			    					<?php endif; ?></p>
			    				</div>
<?php 
							if($counter == 3 || $counter == 5):
?>
							</div>
<?php
							endif; 

							$counter++; 
		    			endwhile;
					endif;
?>
	    			</div>
	    		</div>
			</section>

			<section class="about-cofounders">
				<div class="about-cofounders-lead">
					<div class="medium-container">
						<h2 class="slideright"><span class="highlight"><?php the_field('story_section_header'); ?></span></h2>
						<p><?php the_field('story_section_text'); ?></p>
					</div>
				</div>

				<div class="about-cofounders-founders large-container anm-container">
					<h3 class="fadein">The Cofounders</h3>
					<?php if( have_rows('founders_group') ): ?>
		    			<?php while( have_rows('founders_group') ): the_row(); 

		    			$image = get_sub_field('image');
		    			$header = get_sub_field('title');
	    				$content = get_sub_field('text'); ?>

						<div class="founder slideright">
							<div class="details-container">
		    				<?php if( $image ): ?>
		    					<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>" />
		    				<?php endif; ?>
		    					<div class="details slideright">
									<h4><?php if( $header ): ?>
			    						<?php echo $header; ?>
			    					<?php endif; ?></h4>
								</div>
							</div>
		    				<div class="bordered">
		    					<p><?php if( $content ): ?>
		    						<?php echo $content; ?>
		    					<?php endif; ?></p>
		    				</div>
						</div>
						<?php endwhile; ?>
		    		<?php endif; ?>
				</div>
			</section>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
