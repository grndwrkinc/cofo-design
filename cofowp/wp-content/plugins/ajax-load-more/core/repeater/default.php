<article id="post-<?php the_ID(); ?>" <?php post_class('anm-container medium-container'); ?>>
<?php
	if(has_post_thumbnail()) {
?>
	<div class="post-image anm-item slideup-item">
		<a href="<?php echo esc_url( get_permalink() ); ?>">
			<img src="<?php the_post_thumbnail_url(); ?>" />
		</a>
	</div>
<?php
	}
?>
	<div class="post-summary anm-item slideleft-item slideup-item">
		<header class="entry-header">
			<h2 class="entry-title">
				<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h2>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_excerpt(); ?>
		</div>
		
		<a href="<?php echo esc_url( get_permalink() ); ?>"><button class="inverted basic">Read Story</button></a>
	</div>


</article><!-- #post-## -->