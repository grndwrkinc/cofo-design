<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ndrscrs
 */

global $first;

$imageAnm = 'slideup-item';
$summaryAnm = 'slideup-item';
$containerClass = "medium-container";
$imageSize = "medium_large";

if($first) { 
	$imageAnm = 'slideright-item';
	$summaryAnm = 'slideleft-item';
	$containerClass = "large-container";
	$imageSize = "large";
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('anm-container ' . $containerClass); ?>>
<?php
	if(has_post_thumbnail()) {
?>
	<div class="post-image anm-item <?php echo $imageAnm; ?>">
		<a href="<?php echo esc_url( get_permalink() ); ?>">
			<img src="<?php the_post_thumbnail_url($imageSize); ?>" />
		</a>
	</div>
<?php
	}
?>
	<div class="post-summary anm-item slideleft-item <?php echo $summaryAnm; ?><?php if($first) { ?> bordered<?php } ?>">
		<header class="entry-header">
			<h2 class="entry-title">
				<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h2>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_excerpt(); ?>
		</div>
		
		<a href="<?php echo esc_url( get_permalink() ); ?>" class="btn inverted<?php if(!$first) { ?> basic<?php } ?>">Read Story</a>
	</div>


</article><!-- #post-## -->
