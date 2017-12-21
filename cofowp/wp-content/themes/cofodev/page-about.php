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
			<div class="hero" style="background-image: url(<?php the_post_thumbnail_url(); ?>)">	
				<div class="hero-text">
					<h1 class="white"><span class="highlight"><?php the_title(); ?></span></h1>
					<p><?php the_field('subtitle'); ?></p>
				</div>
			</div>
			<div class="section-container text-section-offset">
				<?php
				while ( have_posts() ) : the_post();
					the_content(); 
				endwhile; // End of the loop.
				?>
			</div>
			<div class="section-container text-images-section">
				<h2><?php the_field('text_images_section_header') ?></h2>
	    		<?php if( have_rows('text_images_group') ): ?>
	    			<div class="inner">
	    			<?php while( have_rows('text_images_group') ): the_row(); 

	    			get_template_part( 'template-parts/content', 'imagetext' );

					endwhile; ?>
					</div>
	    		<?php endif; ?>
			</div>
			<div class="medium-container about-process">
				<h2><?php the_field('process_section_header'); ?></h2>
				<p><?php the_field('process_section_text'); ?></p>
				<?php if( have_rows('process_section_group') ): ?>
	    			<?php while( have_rows('process_section_group') ): the_row(); 
	    				
	    				$header = get_sub_field('header');
	    				$content = get_sub_field('text'); ?>

	    				<div class="bordered">
	    					<h3><?php if( $header ): ?>
	    						<?php echo $header; ?>
	    					<?php endif; ?></h3>
	    					<p><?php if( $content ): ?>
	    						<?php echo $content; ?>
	    					<?php endif; ?></p>
	    				</div>

	    			<?php endwhile; ?>
	    		<?php endif; ?>
			</div>
			<div class="section-container dark">
				<div class="medium-container">
					<h2><?php the_field('story_section_header'); ?></h2>
					<p><?php the_field('story_section_text'); ?></p>
				</div>
				<div class="fluid-vid">
					<?php the_field('story_section_video'); ?>
				</div>
			</div>
			<div class="medium-container about-founders">
				<h3>The Cofounders</h3>
				<?php if( have_rows('founders_group') ): ?>
	    			<?php while( have_rows('founders_group') ): the_row(); 

	    			$image = get_sub_field('image');
	    			$header = get_sub_field('title');
    				$content = get_sub_field('text'); ?>

    				<?php if( $image ): ?>
    					<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>" />
    				<?php endif; ?>
					<div class="details">
						<h4><?php if( $header ): ?>
    						<?php echo $header; ?>
    					<?php endif; ?></h4>
					</div>
    				<div class="bordered">
    					<p><?php if( $content ): ?>
    						<?php echo $content; ?>
    					<?php endif; ?></p>
    				</div>

					<?php endwhile; ?>
	    		<?php endif; ?>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
