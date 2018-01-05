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
				<div class="large-container">
					<div class="hero-text">
						<h1><span class="highlight"><?php the_title(); ?></span></h1>
						<h4><?php the_field('subtitle'); ?></h4>
						<a href="/submit" class="btn animate">Submit your design</a>
						<p class="animate"><a href="/rules-and-regulations">View rules and regulations</a></p>
					</div>
				</div>
			</div>
			<div class="medium-container challenge-mood-board">
				<?php  $images = get_field('mood_board_gallery');
				if( $images ): ?>
			    <div class="masonry-gallery">
			    	<div class="grid-sizer"></div>
			    	<div class="grid-item">
			    		<p class="pre-header"><?php the_field('inspiration_header'); ?></p>
			    		<h2><span class="highlight"><?php the_field('inspiration_text'); ?></span></h2>
			    		<p><?php the_field('inspiration_text_cont'); ?></p>
			    	</div>
				    <?php foreach( $images as $image ): ?>
				        <img class="grid-item <?php echo $image['caption']; ?>" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
				    <?php endforeach; ?>
			    </div>
				<?php endif; ?>
			</div>
			<div class="challenge-categories anm-container">
				<h3 class="fadein">Categories</h3>
					<div class="categories-inner">
					<?php if( have_rows('categories') ): ?>
		    			<?php while( have_rows('categories') ): the_row(); 
		    				
		    				$header = get_sub_field('header');
		    				$icon = get_sub_field('icon'); ?>

						<ul class="anm-item slideright-item">
							<li class="icon"><?php if( $icon ): ?>
								<img src="<?php echo $icon['url']; ?>" alt="<?php echo $icon['alt']; ?>" />
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
					<div class="anm-item slideright-item"><?php the_content(); ?></div>
				<?php endwhile; // End of the loop.
				?>
			</div>
			<div class="medium-container">
				<div class="process-container">
				<?php if( have_rows('challenge_details') ): ?>
					<?php $counter = 1; ?>
	    			<?php while( have_rows('challenge_details') ): the_row(); 
	    				
	    				$header = get_sub_field('header');
	    				$icon = get_sub_field('icon'); 
	    				if($counter == 1 || $counter == 3):
	    					echo '<div class="process-half">';
	    				endif; ?>

					<div class="bordered">
						<h3><?php if( $header ): ?>
							<?php echo $header; ?>
						<?php endif; ?></h3>

	    				<?php if( have_rows('items') ): ?>
	    					<ul>
			    			<?php while( have_rows('items') ): the_row(); 
			    				
			    				$item = get_sub_field('item');

			    				if( $item ): ?>
		    						<li><?php echo $item; ?></li>
		    					<?php endif; ?>

			    			<?php endwhile; ?>
			    			</ul>
			    		<?php endif; ?>
	    			</div>
					<?php 
						if($counter == 2 || $counter == 3):
							echo '</div>';
						endif; 
						$counter++; ?>
	    			<?php endwhile; ?>
	    		<?php endif; ?>
	    		</div>
			</div>
			<div class="medium-container challenge-details">
	    		<a href="/submit" class="btn">Submit your design</a>
				<p><a href="/rules-and-regulations">View rules and regulations</a></p>
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
