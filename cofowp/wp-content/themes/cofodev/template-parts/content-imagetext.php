<?php
/**
 * Template part for displaying an image and text loop
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ndrscrs
 */

?>

<?php 
	$image = get_sub_field('image');
	$content = get_sub_field('text');
	$title = get_sub_field('title'); ?>

<div class="container grid-item">
	<?php if( $image ): ?>
		<img class="slideup" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>" />
	<?php endif; ?>

	<?php if($content) : ?>
	<div class="details">
		<h3><?php if( $title ): ?>
			<?php echo $title; ?>
		<?php endif; ?></h3>
		<p><?php if( $content ): ?>
			<?php echo $content; ?>
		<?php endif; ?></p>
	</div>
	<?php endif; ?>
</div>