<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package ndrscrs
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) : the_post();

			$ch = curl_init();

			$productID = get_field('product_id');
			$apiKey = '0804f07642e66e6ea0f18eb356b3079c';
			$pwd = '10873519cffcddb7f84951a786c6eb5c';
			//#{apikey}:#{password}@#{shop-name}.myshopify.com/admin/#{resource}.json

			$baseUrl = "https://" . $apiKey . ":" . $pwd . "@cofodesign-com.myshopify.com/admin/products/" . $productID . ".json";

			curl_setopt($ch, CURLOPT_URL, $baseUrl);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$product = json_decode(curl_exec($ch));
			curl_close($ch);

			$product = $product->product;

			var_dump($product); 

			?>
			<!-- Add fallback for no product available -->

			<div class="product-hero">
				<div class="hero" style="background-image: url(<?php the_post_thumbnail_url(); ?>)"></div>
				<div class="description">
					<?php the_content(); ?>
					<div class="social">
						<p>Share <i class="fa fa-pinterest-p" aria-hidden="true"></i><i class="fa fa-facebook" aria-hidden="true"></i><i class="fa fa-instagram" aria-hidden="true"></i></p>
					</div>
				</div>
			</div>
			<div class="product-details">
				<h4><?php echo $product->variants[0]->price; ?></h4>
				<h3><?php echo $product->title; ?></h3>
				<div class="variant">
					<p>Colour</p>
					<ul>
						<?php foreach($product->variants as $variant){
							echo '<li class="' . $variant->title . '">';
							echo $variant->title;
							echo '</li>';
						} ?>
					</ul>
				</div>
				<div class="variant">
					<p></p>
				</div>
			</div>
			<div class="product-nav"></div>
			<div class="product-explore"></div>
			<div class="product-dimensions"></div>
			<div class="product-craftsmanship"></div>
			<?php $post_object = get_field('designer');

			if( $post_object ): 

				$post = $post_object;
				setup_postdata( $post ); 

				?>
			   <div class="product-designer">
			    	<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			    	<span>Post Object Custom Field: <?php the_field('field_name'); ?></span>
			    </div>
			    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
			<?php endif; ?>
			</div>

		<?php endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
