<?php
/**
 * Description: Page template for Product Taxonomies (Collection, Category, Sale)
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package ndrscrs
 */

get_header(); 

$term = get_queried_object();

?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<section id="listing" class="product-group">
<?php 
			// Load sidebar menu
			get_template_part( 'template-parts/shop', 'filters' );

			//Retrieve the associated Products ($posts)
			if($term->taxonomy == "sale") {
				$args = setQueryArgs();
			}
			else {
				$args = setQueryArgs($term->taxonomy, $term->term_id);
			}
			//$args = setQueryArgs('collection', $term->term_id);
			$posts = new WP_Query( $args );

			//The Loop
			if ( $posts->have_posts() ) {
				$collection_image = (get_field('image', $term)) ? get_field('image', $term) : "http://via.placeholder.com/1160x500";

				//Add 20% margin to the bottom of <div id="listing"> if
				// the last collection has an even number of products.
				if(sizeof($posts->posts) % 2 == 0) {
?>
				<style>#listing {margin-bottom: 10%;}</style>
<?php
				}

				include(locate_template('template-parts/shop-'.$term->taxonomy.'.php'));

				/* Restore original Post Data */
				wp_reset_postdata();
			} else {
				// no posts found
				echo "No posts found.<br>";
			}
?>
			</section>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
