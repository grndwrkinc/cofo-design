<?php
/**
 * Description: Default page template for Design Challenge Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
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
						<!-- <p class="animate"><a href="http://eepurl.com/dgO0jL" target="_blank" class="btn">Sign up to get notified</a></p> -->
						<!-- <p class="animate"><a href="/submit" class="btn">Submit your design</a></p> -->
						<p class="animate"><a href="<?php the_field('link_to'); ?>" <?php if(get_field('new_tab')) { ?>target="_blank"<?php } ?> class="btn"><?php the_field('button_label'); ?></a></p>
						<p class="animate"><a class="link" href="/rules-and-regulations">View rules and regulations</a></p>
					</div>
				</div>
			</div>
			<div class="medium-container challenge-mood-board">
				<div class="mood-board-description-mobile anm-container">
					<p class="pre-header anm-item slideright-item"><?php the_field('inspiration_header'); ?></p>
					<h2 class="anm-item slideright-item"><span class="highlight"><?php the_field('inspiration_text'); ?></span></h2>
					<p class="anm-item slideright-item"><?php the_field('inspiration_text_cont'); ?></p>
				</div>
				<?php  $images = get_field('mood_board_gallery');
				if( $images ): ?>
			    <div class="masonry-gallery">
			    	<div class="grid-sizer"></div>
			    	<div class="gutter-sizer"></div>
			    	<div class="mood-board-description stamp anm-container">
			    		<p class="pre-header anm-item slideright-item"><?php the_field('inspiration_header'); ?></p>
			    		<h2 class="anm-item slideright-item"><span class="highlight"><?php the_field('inspiration_text'); ?></span></h2>
			    		<p class="anm-item slideright-item"><?php the_field('inspiration_text_cont'); ?></p>
			    	</div>
				    <?php $cnt = 0; foreach( $images as $image ): ?>
				        <img class="grid-item slideup img<?php echo $cnt; ?> <?php echo $image['caption']; ?>" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
				    <?php $cnt++; endforeach; ?>
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

		    	<div class="anm-item slideright-item"><p><?php the_field('categories_blurb'); ?></p></div>

			</div>
			<div class="medium-container challenge-boxes">
				<div class="process-container anm-container">
<?php 
				if( have_rows('challenge_details') ):
					$counter = 1; 

					while( have_rows('challenge_details') ): the_row(); 

	    				switch($counter) {
							case 1: $animation = "slidedownright-2"; break;
							case 2: $animation = "slideupright"; break;
							case 3: $animation = "slideleft"; break;
						}
	    				
	    				$header = get_sub_field('header');
	    				$icon = get_sub_field('icon'); 

	    				if($counter == 1 || $counter == 3):
?>
    				<div class="process-half">
<?php
	    				endif; 
?>

						<div class="bordered anm-item <?php echo $animation; ?>">
							<h3><?php if( $header ) { echo $header; } ?></h3>
    					
    						<ul>
<?php 
	    				if( have_rows('items') ): 
							while( have_rows('items') ): the_row(); 
			    				
			    				$item = get_sub_field('item');

			    				if( $item ): 
?>
	    						<li><?php echo $item; ?></li>
<?php 
								endif; 
							endwhile; 
						endif; 
?>
							</ul>
	    				</div>
<?php 
						if($counter == 2 || $counter == 3):
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

			<!-- <div class="medium-container challenge-details">
	    		<a href="/submit" class="btn">Submit your design</a>
				<p><a class="link" href="/rules-and-regulations">View rules and regulations</a></p>
			</div>
			<div class="challenge-share anm-container fadein">
				<h4 class="anm-item slideright-item">Share the challenge</h4>
				<div class="social-nav anm-item slideright-item">
					<ul>
						<li>
							<?php global $wp;
							$url = home_url( $wp->request ); ?>
							<a class="social-share" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
						<li><a class="social-share" href="https://twitter.com/intent/tweet?text=<?php echo get_post_meta(get_the_ID(), '_yoast_wpseo_metadesc', true); ?> <?php echo $url ?>" data-size="large" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
					</ul>
				</div>
			</div> -->
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
