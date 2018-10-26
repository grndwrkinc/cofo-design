<?php
/**
 * Description: Default page template for Home Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package ndrscrs
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<!-- HERO -->
			<section class="hero" style="background-image: url(<?php the_post_thumbnail_url(); ?>)">
<?php
				while ( have_posts() ) : the_post(); 
?>
				<div class="hero-text large-container">
					<h1><span class="highlight"><?php the_field('title'); ?></span></h1>
					<div class="bordered">
						<p><?php the_field('sub-title'); ?></p>

<?php 
					$link_to = get_field('link_to');
					
					if( $link_to ): 
						$link_to_post = $link_to[0]; 
?>
						<a href="<?php echo get_permalink($link_to_post); ?>" class="btn"><?php the_field('button_label'); //echo get_the_title($link_to_post); ?></a>
						<small><?php the_field('sub-text'); ?></small>
<?php
					 endif; 
?>
					</div>
				</div>
<?php 
				endwhile; // End of the loop.
?>
			</section>
			
			<!-- SLIDER -->
			<section class="home-slider">
<?php 
			$total = sizeof(get_field('slider'));
			if( have_rows('slider') ):
				$cnt = 0;
?>
				<div class="slider-nav">
					<div class="btn-prev"></div>
					<div class="btn-next"></div>
					<div class="slide-count">
						<span class="current">1</span> / <?php echo $total; ?>
					</div>
				</div>
				<div class="slider-top">
<?php
				while( have_rows('slider') ): the_row();
					$cnt++;
?>
					<div class="slide">
						<div class="home-slider-img">
							<img <?php if($cnt==1) { ?>class="fadein"<?php } ?> src="<?php the_sub_field('image'); ?>" alt="alt">
						</div>
					</div>
<?php
				endwhile;
?>
				</div>
<?php
			endif;

			if( have_rows('slider') ):
				$cnt = 0;
?>
				<div class="slider-bottom">
<?php
				while( have_rows('slider') ): the_row();
					$cnt++;
?>
					<div class="slide">
						<div class="home-slider-content <?php if($cnt==1) { ?>anm-container<?php } ?>">
							<h2 <?php if($cnt==1) { ?>class="anm-item slideright-item"<?php } ?>><span class="highlight"><?php the_sub_field('title'); ?></span></h2>
							<div class="bordered <?php if($cnt==1) { ?>anm-item slideright-item<?php } ?>">
								<p><?php the_sub_field('sub-title'); ?></p>
<?php
					$slider_link_to = get_sub_field('slider_link_to');
					$slider_link_to_post = $slider_link_to[0]; 
?>
								<a href="<?php echo get_permalink($slider_link_to_post); ?>" class="btn"><?php the_sub_field('button_label'); ?></a>
							</div>
						</div>
					</div>
<?php
				endwhile;
?>
				</div>
<?php
			endif;
?>
			</section>
			
			<!-- DESIGN CHALLENGE -->
			<section class="home-challenge">
				<div class="medium-container">
					<div class="text-section-offset fadein anm-container">
						<p class="pre-header anm-item slideright-item"><?php the_field('design_challenge_section_title'); ?></p>
						<h2 class="anm-item slideright-item"><span class="highlight"><?php the_field('design_challenge_header'); ?></span></h2>
						<p class="anm-item slideright-item"><?php the_field('design_challenge_text'); ?></p>
						<p class=" anm-item slideright-item"><a href="/design-challenge" class="btn"><?php the_field('design_challenge_button_label'); ?></a></p>
					</div>
				</div>

				<div class="large-container">
					<div>
						<div class="slideup">
							<h3><?php the_field('process_title'); ?></h3>
						</div>
<?php 
						if( have_rows('design_challenge_steps') ):
							$counter = 1;
?>
						<ol class="text-steps anm-container">
<?php 
			    			while( have_rows('design_challenge_steps') ): the_row(); 
			    				$content = get_sub_field('text'); 
?>
			    				<li class="slideright-item anm-item"><span><?php echo '0' . $counter; ?></span><?php if( $content ): echo $content; endif; ?></li>
<?php 
								$counter++;
							endwhile; 
?>
		    			</ol>
<?php 
						endif;
?>
			    	</div>
				</div>
				
				<!-- <div class="medium-container full-collection anm-container">
					<h2 class="anm-item slideright-item"><span class="highlight">Full <br/>Collection <br/>Coming</span></h2>
					<div class="bordered anm-item slideright-item">
						<h3>Fall 2018</h3>
					</div>
				</div> -->
			</section>

			<!-- BLOG -->
			<section class="home-blog">
				<div class="large-container anm-container">			
					<?php if(get_field('log_section_header')) { ?><h2 class="anm-item slideright-item"><span class="highlight"><?php the_field('blog_section_header'); ?></span></h2><?php } ?>
					<div class="offset">
						<div class="home-blog-right slideright">

							<?php if(get_field('blog_section_blurb')) { ?><p class="anm-item slideright-item"><?php the_field('blog_section_blurb'); ?></p><?php } ?>
							<?php if(get_field('blog_section_button_label')) { ?><p class="anm-item slideright-item"><a href="/blog" class="btn"><?php the_field('blog_section_button_label'); ?></a></p><?php } ?>
						</div>

						<?php if(get_field('blog_section_image')) { ?>
						<div class="home-blog-left fadein">
							<img src="<?php the_field('blog_section_image'); ?>" />
						</div>
						<?php } ?>

					</div>
				</div>
			</section>

			<!-- ABOUT -->
			<section class="home-about fadein">
				<div class="large-container home-about-content anm-container">
					<h3 class="anm-item slideright-item"><?php the_field('about_section_header'); ?></h2>
					<p class="anm-item slideright-item"><?php the_field('about_section_blurb'); ?></p>
					<p class="anm-item slideright-item"><a class="btn" href="/about"><?php the_field('about_section_button_label'); ?></a></p>
				</div>
			</section>


		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
