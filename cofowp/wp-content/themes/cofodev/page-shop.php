<?php
/**
 * Description: Default page template for Shop Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package ndrscrs
 */

get_header(); 

//Get all Collection taxonomy terms
$collections = get_terms('collection');

//Filter the results to get only the Collection term_ids
$terms = array_map(function($collection) {return $collection->term_id;}, $collections);

//Sort the Collections (term_ids) from high to low (newest to oldest)
rsort($terms);

?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<section id="listing" class="product-group">
<?php 
			// Load sidebar menu
			get_template_part( 'template-parts/shop', 'filters' );

			//Loop through each Collection (term_id) and retrieve the associated Products ($posts)
			for($termsCnt=0; $termsCnt<sizeof($terms); $termsCnt++) {
				
				$term_id = $terms[$termsCnt];
				$args = setQueryArgs('collection', $term_id);
				$posts = new WP_Query( $args );

				//The Loop
				if ( $posts->have_posts() ) {
					$term = get_term($term_id);
					$collection_image = (get_field('image', $term)) ? get_field('image', $term) : get_template_directory_uri() . "/assets/images/1160x500.png";

					//This is the last collection
					if($termsCnt+1 == sizeof($terms)) {
						//Add 20% margin to the bottom of <div id="listing"> if
						// the last collection has an even number of products.
						if(sizeof($posts->posts) % 2 == 0) {
?>
				<style>#listing {margin-bottom: 10%;}</style>
<?php
						}
					}

					include(locate_template('template-parts/shop-collection.php'));

					/* Restore original Post Data */
					wp_reset_postdata();
				} else {
					// no posts found
					echo "No posts found.<br>";
				}
			}
?>
			</section>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
