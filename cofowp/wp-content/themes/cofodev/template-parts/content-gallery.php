<?php
/**
 * Template part for displaying the image gallery
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package cofo
 */

?>

<div class="image-gallery">
	<div class="close"></div>
	<div class="main-container">
<?php 
	if( have_rows('product_shots') ): 

		$cnt = 0;
		
		while( have_rows('product_shots') ): the_row();
			$variant = get_sub_field('variant');
			
			if( have_rows('images') ) : 
				while( have_rows('images') ) : the_row();
					$image = get_sub_field('image');
					$description = get_sub_field('description');
?>
		<div class="main-img togglable no<?php echo $cnt; ?> <?php if($selected != $variant) echo "hidden"; ?>" data-id="<?php echo $variant; ?>">
			<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>" />
		</div>

<?php
					$cnt++;
				endwhile;
			endif;

		endwhile; 
	endif; 
?>
		<div class="btn-prev"></div>
		<div class="btn-next"></div>
	</div>
	<div class="thumbnails">
<?php 
	if( have_rows('product_shots') ): 

		$cnt = 0;
		
		while( have_rows('product_shots') ): the_row();
			$variant = get_sub_field('variant');
			
			if( have_rows('images') ) : 
				while( have_rows('images') ) : the_row();
					$image = get_sub_field('image');
					$description = get_sub_field('description');
?>
		<div class="thumbnail-img togglable no<?php echo $cnt; ?> <?php if($selected != $variant) echo "hidden"; ?>" data-id="<?php echo $variant; ?>">
			<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>" />
		</div>

<?php
					$cnt++;
				endwhile;
			endif;

		endwhile; 
	endif; 
?>

	</div>
	<div class="variant-attribute"></div>
</div>
