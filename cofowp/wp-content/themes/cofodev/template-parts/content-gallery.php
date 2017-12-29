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
		<div class="main-img"></div>
		<div class="btn-prev"></div>
		<div class="btn-next"></div>
	</div>
	<div class="thumbnails">
	<?php if( have_rows('product_shots') ): 
		$cnt = 0; ?>
		<?php while( have_rows('product_shots') ): the_row(); 
			
			$image = get_sub_field('image'); ?>

			<?php if( $image ): ?>
			<div class="thumbnail-img no<?php echo $cnt; ?>">
				<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>" />
			</div>
			<?php endif; ?>

		<?php $cnt++;
			endwhile; ?>
	<?php endif; ?>
	</div>
	<div class="variant-attribute"></div>
</div>
