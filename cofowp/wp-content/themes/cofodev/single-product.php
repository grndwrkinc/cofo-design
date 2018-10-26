<?php
/**
 * The template for displaying all single Product posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package ndrscrs
 */

wp_enqueue_style('threesixty_style', '//' . $_SERVER['HTTP_HOST'] . '/wp-content/themes/cofodev/assets/js/threesixty-slider/styles/threesixty.css');
wp_enqueue_script( 'threesixty_script', '//' . $_SERVER['HTTP_HOST'] . '/wp-content/themes/cofodev/assets/js/threesixty-slider/threesixty-min.js', array('jquery'), '2.0.4', true);
wp_enqueue_script( 'threesixty_plugin', '//' . $_SERVER['HTTP_HOST'] . '/wp-content/themes/cofodev/assets/js/threesixty-slider/plugins/threesixty.fullscreen-min.js', array('threesixty_script'), '1.0.0', true);
get_header();

?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

<?php
		while ( have_posts() ) : the_post();
			$productVariants = get_post_meta($post->ID, "gwsh_product_variants", true);
			$productID = get_post_meta($post->ID, "gwsh_product_id", true);
			$product = gwsh_getProduct($productID);
			$selected = $product->variants[0]->product_id . "_" . $product->variants[0]->id;

			// Load the product variants into the page as a JS variable
			// that can be referenced later in scripts.js
			wp_add_inline_script('cofo-scripts', 'var variants = ' . $productVariants, 'before'); 

			//Make an array of all the product images to grab variant swatches
			$productImages = array();
			foreach($product->images as $image) {
				array_push($productImages, $image->src);
			};

?>
			<!-- Add fallback for no product available -->
			<!-- ########## HERO IMAGE ########## -->
<?php
			if( have_rows('hero_images') ):
				while ( have_rows('hero_images') ): the_row();
					$variant = get_sub_field('variant');
    				$image = get_sub_field('image'); 
?>
			<div class="togglable hero <?php if($selected != $variant) echo "hidden"; ?>" style="background-image: url(<?php echo $image; ?>)" data-id="<?php echo $variant; ?>">

				<div class="large-container">
					<div class="hero-text">
						<h1><span class="highlight"><?php (get_field('title')) ? the_field('title') : the_title(); ?></span></h1>
<?php
						if(the_field('subtitle')) :					
?>
						<div class="bordered">	
							<p><?php the_field('subtitle'); ?></p>
						</div>
<?php
						endif;
?>
					</div>
				</div>

			</div>
<?php
				endwhile;
			endif;

			$designer = get_field('designer');
			$preOrder = get_field('pre-order'); if($preOrder) $preOrder = true;
			
			if( $designer ) {
				$designerName = get_the_title($designer);
			}
?>

			<!-- ########## PRODUCT DETAILS (NAME, PRICE, VARIANTS, ADD TO CART) ########## -->
			<div class="product-details-container medium-container">
				<div id="product-details" class="bordered slideup">
					<h3><?php the_title(); ?></h3>
<?php
			if($designer) {
?>
					<div class="designer"><em>designed by <?php echo $designerName; ?></em></div>
<?php
			}
?>
					<div class="pricing">
<?php
				for ($i = 0; $i < sizeof($product->variants); $i++) {
					$variant = $product->variants[$i];
					$id = $variant->product_id . "_" . $variant->id;
					$compareAtPrice = $variant->compare_at_price;
?>
						<div class="price togglable <?php if($selected != $id) echo "hidden"; ?>" data-id="<?php echo $id; ?>">$<?php echo number_format(floatval($variant->price),2); ?><br></div>
<?php
					if($compareAtPrice) {
?>
						<div class="sale">Sale</div>
<?php
					}
				}
?>
					</div>
<?php
			foreach ($product->options as $option) :
?>
					<div class="variant-attribute">
						<h4><?php echo $option->name; ?></h4>
						<ul id="variant-attribute-options">
<?php 
				$cnt = 0;

				foreach($product->variants as $variant) : // This inner loop will need to change when there are more than one $production->options

					$id = $variant->product_id . "_" . $variant->id;

					//Remove special characters and whitespace from variant title to match variant swatch image name
					$scrubTitle = preg_replace("/[^a-zA-Z]/", "", strtolower($variant->title));
					foreach($productImages as $src){
						if(strpos($src, $scrubTitle)){
							$imgSrc = $src;
						}
					}
?>
							<li>
								<label class="swatch-toggle" for="<?php echo $variant->product_id . "_" . $variant->id; ?>" data-inventory-quantity="<?php echo $variant->inventory_quantity; ?>" data-inventory-management="<?php echo $variant->inventory_management; ?>" data-inventory-policy="<?php echo $variant->inventory_policy; ?>"  data-pre-order="<?php echo $preOrder; ?>">
									<input type="radio" name="variant" value="<?php echo $variant->id; ?>" id="<?php echo $id; ?>" <?php if(!$cnt) { ?>checked<?php } ?>>
									<img src="<?php echo $imgSrc; ?>" alt="">
								</label>
							</li>
<?php
					$cnt++;
				endforeach;
?>
						</ul>
						<p><small>
<?php
				for ($i = 0; $i < sizeof($product->variants); $i++) {
					$variant = $product->variants[$i];
					$id = $variant->product_id . "_" . $variant->id;
?>
						<span class="colour-variant togglable <?php if($selected != $id) echo "hidden"; ?>" data-id="<?php echo $id; ?>"><?php echo $variant->title; ?></span>
<?php
				}
?>
						</small></p>
					</div>

<?php
			endforeach;

			//Check for product inventory and quantity and show appropriate messaging
			$inventoryMessage = "";
			$buttonLabel = "Add to cart";

			if($preOrder) {
				$buttonLabel = "Pre-order";
			}
			else {
				if(isset($product->variants[0]->inventory_management)) {
					//Out of inventory
					if($product->variants[0]->inventory_quantity == "0" && $product->variants[0]->inventory_policy == "deny") {
						$inventoryMessage = "Out of Stock";
						$buttonLabel = "Notify Me";
					}
					//Limited stock
					else if($product->variants[0]->inventory_quantity < 5) {
						$inventoryMessage = "Limited Quantity";
					}
				}
			}
?>
					<div class="inventory-message center"><?php echo $inventoryMessage; ?></div>
<?php
			/* if($buttonLabel == "Notify Me") {
?>
					<a href="mailto:info@cofodesign.com?subject=Out of stock: <?php the_title(); ?>&amp;body=Please notify me when <?php the_title(); ?> is available for purchase.">
<?php
			} */
?>
					<?php /* <button <?php if($buttonLabel != "Notify Me") { ?>id="add-to-cart"<?php } ?>><?php echo $buttonLabel; ?></button> */ ?>
					<button id="add-to-cart"><?php echo $buttonLabel; ?></button>
<?php
			/* if($buttonLabel == "Notify Me") {
?>
					</a>
<?php
			} */
?>
				</div>
			</div>

			<div class="product-container medium-container">

				<!-- ########## PRODUCT DESCRIPTION ########## -->
				<div class="product-text offset">
					<?php the_content(); ?>
					<div class="social anm-container">
						<p class="anm-item slideright-item">Share</p>
						<div class="social-nav">
							<ul>
<?php 
								global $wp;
								$url = home_url( $wp->request );
?>
								<li class="anm-item slideright-item"><a class="social-share" href="http://pinterest.com/pin/create/button/?url=<?php echo $url ?>&description=<?php echo urlencode(strip_tags(get_the_content())); ?>&media=<?php echo get_the_post_thumbnail_url(); ?>"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
								<li class="anm-item slideright-item"><a class="social-share" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
								<li class="anm-item slideright-item"><a class="social-share" href="https://twitter.com/intent/tweet?text=<?php echo urlencode(strip_tags(get_the_content())); ?> <?php echo $url ?>" data-size="large" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
							</ul>
						</div>
					</div>
				</div>

				<!-- ########## 360 IMAGE VIEWER ########## -->
				<div class="product-360 offset">
<?php 
				if( have_rows('360_image_viewer') ): 
    				$variantCnt = 0;
    				$viewerScript = "";
	    			
	    			while( have_rows('360_image_viewer') ): the_row(); 
		    			$variant = get_sub_field('variant');
	    				$images = get_sub_field('images');

	    				if(sizeof($images) > 1) {

		    				// Extract the image paths from the $images array, then 
		    				// join them into a string representing an array like:
		    				// ['url1', 'url2', 'url3',...]
		    				$imageArrayString = "['" . join("','", array_column($images, 'url'))  . "']"; 
?>
					<div id="viewer_<?php echo $variant; ?>" class="threesixty togglable <?php if($selected != $variant) echo "hidden"; ?>" data-id="<?php echo $variant; ?>">
						<div class="spinner"><span>0%</span></div>
						<div class="instructions"><img src="/wp-content/themes/cofodev/assets/images/drag-to-rotate.png" width=132 height=60 /></div>
						<ol class="threesixty_images"></ol>
					</div>
<?php

							$viewerScript .= "$(document).ready(function() {\n";
							$viewerScript .= "	initViewer_" . $variant . "();\n";
							$viewerScript .= "	var viewer_" . $variant . ";\n";
							$viewerScript .= "	function initViewer_" . $variant . "() {\n";
							$viewerScript .= "		viewer_" . $variant . " = $('#viewer_" . $variant . "').ThreeSixty({\n";
							$viewerScript .= "			totalFrames: " . sizeof($images) . ",\n"; // Total no. of image you have for 360 slider"
							$viewerScript .= "			endFrame: " . sizeof($images) . ",\n"; // end frame for the auto spin animation
							$viewerScript .= "			currentFrame: 1,\n"; // This the start frame for auto spin
							$viewerScript .= "			imgList: '.threesixty_images',\n"; // selector for image list
							$viewerScript .= "			progress: '#viewer_" . $variant . " .spinner',\n"; // selector to show the loading progress
							$viewerScript .= "			imgArray: " . $imageArrayString . ",\n"; // path of the image assets
							$viewerScript .= "			height: 384,\n";
							$viewerScript .= "			width: 576,\n";
							$viewerScript .= "			responsive: true,\n";
							$viewerScript .= "			showCursor: true,\n";
							$viewerScript .= "			plugins: ['ThreeSixtyFullscreen']\n";
							$viewerScript .= "		});\n";
							$viewerScript .= "	}\n";
							$viewerScript .= "});\n";
						}
						else {
?>
					<div id="viewer_<?php echo $variant; ?>" class="threesixty togglable <?php if($selected != $variant) echo "hidden"; ?>" data-id="<?php echo $variant; ?>">
						<img src="<?php echo $images[0]['url']; ?>">
					</div>

<?php
						}

					endwhile;

					wp_add_inline_script('threesixty_script', $viewerScript, 'after'); 

				endif; 
?>
					<p><?php the_field('360_text'); ?></p>
				</div>
			</div>

			<div class="product-container large-container">

				<!-- ########## PRODUCT DETAIL IMAGES ########## -->
<?php 
				if( have_rows('product_detail_images') ): 
					
					$cnt = 0;
?>
				<div class="product-explore offset">
<?php
					while( have_rows('product_detail_images') ): the_row();
	    				$variant = get_sub_field('variant');
?>
					<div class="product_image_set">
<?php
						if( have_rows('images') ) : 
							while( have_rows('images') ) : the_row();
								$image = get_sub_field('image');
								$description = get_sub_field('description');
?>
						<div class="togglable img-container <?php if($selected != $variant) echo "hidden"; ?>" data-id="<?php echo $variant; ?>" >
							<img class="no<?php echo $cnt; ?> slideup" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>" />
	    					<p><?php if( $description ) echo $description; ?></p>
						</div>
<?php
								$cnt++;
							endwhile;
						endif;
?>
					</div>
<?php
					endwhile; 
?>
				</div>
<?php
				endif; 
?>
			</div>

			<!-- ########## GALLERY ########## -->
<?php 
			set_query_var( 'selected', $selected );
			get_template_part( 'template-parts/content', 'gallery' );
?>

			<!-- ########## DIMENSIONS ########## -->
<?php
				if( have_rows('product_dimensions_images') ) :
?>
			<div class="product-dimensions large-container">
				<div class="small-container anm-container">
					<p class="pre-header slideright-item anm-item">Dimensions</p>
					<h2 class="slideright-item anm-item"><span class="highlight"><?php the_field('product_dimensions_title'); ?></span></h2>
				</div>
<?php
					while( have_rows('product_dimensions_images')) : the_row();
						$variant = get_sub_field('variant');
						$image = get_sub_field('image');
?>
				<div class="togglable img-container <?php if($selected != $variant) echo "hidden"; ?>" data-id="<?php echo $variant; ?>">
					<img class="slideup" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
				</div>
<?php 
					endwhile;
?>
			</div>
<?php
				endif; 
?>

			<!-- ########## CRAFTSMANSHIP ########## -->
			<!-- <div class="product-craftsmanship">
				<div class="medium-container anm-container">
					<p class="pre-header anm-item slideright-item">Craftsmanship</p>
					<h2 class="anm-item slideright-item"><span class="highlight" data-title="<?php the_field('craftsmanship_title'); ?>"><?php the_field('craftsmanship_title'); ?></span></h2>
				</div>
			</div> -->

			<!-- ########## DIFFERENTIATORS ########## -->
<?php
				if(have_rows('differentiators', 'option')) :
?>
			<div class="product-differentiators medium-container">
				<div class="anm-container">
					<p class="pre-header anm-item slideright-item">The Difference</p>
					<h2 class="anm-item slideright-item"><span class="highlight" data-title="<?php the_field('differentiator_title', 'option'); ?>"><?php the_field('differentiator_title', 'option'); ?></span></h2>
					<ul class="anm-container">
<?php
					while(have_rows('differentiators', 'option')): the_row();
?>
						<li class="anm-item slideup-item">
							<h4><?php echo the_sub_field('title'); ?></h4>
							<p><?php echo the_sub_field('description'); ?></p>
						</li>
<?php
					endwhile;
?>
					</ul>
				</div>
			</div>
<?php
				endif;
?>

			<!-- ########## PRODUCT DESIGNER ########## -->
<?php 
			$designer = get_field('designer');

			if( $designer ): 
				// $post = $post_object;
				// setup_postdata( $post ); 
				$designerImage = get_the_post_thumbnail_url($designer);
				$designerName  = str_replace(" ", "<br>", get_the_title($designer));
				$designerBio   = $designer->post_content;
				// wp_reset_postdata(); 

?>
		   <div class="product-designer">
		   		<div class="designer-details anm-container">
		   			<img class="anm-item slideup-item" src="<?php echo $designerImage; ?>" alt="Photo of designer <?php echo $designerName; ?>">
		   			<div class="details">
		   				<div class="for-fixin">
		   					<p class="pre-header anm-item slideright-item">Designed by</p>
				    		<h2 class=" anm-item slideright-item"><span class="highlight"><?php echo $designerName; ?></span></h2>
		   				</div>
			    		<div class=""><p><?php echo $designerBio; ?></p></div>
		   			</div>
		   		</div>

<?php
				if(get_field('project_details_text')) {
					$img = get_field('project_details_image');
?>
    			<div class="designer-extras anm-container">
    				<div class="copy">
						<h3 class="anm-item slideright-item">Project Highlight</h3>
						<p><?php the_field('project_details_text'); ?></p>
					</div>
					<div class="image">
						<img class="anm-item slideup-item" src="<?php echo $img['url']; ?>" alt="<?php echo $img['alt']; ?>" />
					</div>
				</div>
<?php
				}
?>	    		
		    </div>
		    <?php //wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
		<?php endif; ?>

<?php 

		endwhile; // End of the loop.
?>
		<div class="challenge-cta bordered slideup">
			<h4>Design Challenge</h4>
			<p>If you are a student or recent graduate and want to see your ideas in the real world, enter now. </p>
			<a href="/design-challenge" class="btn">View Challenge Details</a>
		</div>	
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
