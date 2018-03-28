<?php
/**
 * Description: Default page template for Cart Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package ndrscrs
 */

get_header(); ?>

<script>
	var products = [];
<?php
	if(get_page_by_title( 'Shop' )) {
?>
	var hasShop = true;
<?php
	} else {
?>
	var hasShop = false;
	
<?php
	}

	$args = setQueryArgs();
	$posts = new WP_Query( $args );

	while($posts->have_posts()): $posts->the_post();
		$preOrder = get_field("pre-order");

		if($preOrder) {
?>
	products.push("<?php the_title(); ?>");
<?php
		}
		wp_reset_postdata();
	endwhile;
?>
</script>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="medium-container" style="background-image: url(<?php the_post_thumbnail_url(); ?>)">	
				<h1 class="white"><span class="highlight"><?php the_title(); ?></span></h1>
				<p><?php the_field('subtitle'); ?></p>
			</div>

			<div id="cart" class="medium-container">
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
