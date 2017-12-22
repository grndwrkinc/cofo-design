<?php
/**
 * Template Name: Home Page
 * Description: Only for use on home page
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
			<div class="medium-container challenge-mood-board"></div>
			<div class="challenge-categories">
				<h3>Categories</h3>
					<div class="categories-inner">
					<?php if( have_rows('categories') ): ?>
		    			<?php while( have_rows('categories') ): the_row(); 
		    				
		    				$header = get_sub_field('header');
		    				$icon = get_sub_field('icon'); ?>

						<ul>
							<li><?php if( $icon ): ?>
								<?php echo $icon; ?>
							<?php endif; ?></li>

		    				<?php if( $header ): ?>
	    						<li class="header"><?php echo $header; ?></li>
	    					<?php endif; ?>

		    				<?php if( have_rows('items') ): ?>
				    			<?php while( have_rows('items') ): the_row(); 
				    				
				    				$item = get_sub_field('item');

				    				if( $item ): ?>
			    						<li><?php echo $item; ?></li>
			    					<?php endif; ?>

				    			<?php endwhile; ?>
				    		<?php endif; ?>
		    			</ul>

		    			<?php endwhile; ?>
		    		<?php endif; ?>
		    	</div>
		    	<?php while ( have_posts() ) : the_post(); ?>
					<p><?php the_content(); ?></p>
				<?php endwhile; // End of the loop.
				?>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
