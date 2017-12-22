import Client from 'shopify-buy';

const ls = window.localStorage;
const checkoutID = ls.getItem("checkoutID");
const client = Client.buildClient({
	domain: 'cofodesign-com.myshopify.com',
	storefrontAccessToken: '8bc18701933e1f8b51aa4119d960e0ff'
});

//Append a container for the cart counter to the DOM in the header
$('.nav-cart a').append("<span class='nav-cart-counter'></span>");

/**
 * Get the Checkout Object and hook up the cart event listeners
 */

if(checkoutID) {
	//Use the checkoutID that already exists in local storage
	client.checkout.fetch(checkoutID).then((checkout) => {
		addCartEventListeners(checkout);
	});
}
else {
	//This is a new session, create a new empty Checkout
	client.checkout.create().then((checkout) => {
		//Save the checkout ID to local storage
		ls.setItem('checkoutID', checkout.id);
		addCartEventListeners(checkout);
	});
}




const addCartEventListeners = function(checkout) {
	//Set the Cart link in the nav to point to the current shopping cart
	// $('.nav-cart a').attr('href',"http://shop.cofo-dev.grndwrk.ca/cart/");

	// Initialize the cart counter
	updateCartCounter(checkout);

	//Initialize the cart
	updateCartContents(checkout);

	// Add to cart
	addToCartListener(checkout);

	// Swap the product images when variant is changed
	swapProductImagesListener(checkout);

	// Toggle cart visiblity
	toggleCartListener();
}



/**
 * addToCartListener()
 */
const addToCartListener = function(checkout) {
	$('#add-to-cart').on('click', function() { 
		const checkoutId = checkout.id;
		const variantId = $('input[name=variant]:checked').val();
		const lineItems = [{
			variantId : btoa("gid://shopify/ProductVariant/" + variantId), // https://github.com/Shopify/js-buy-sdk/issues/105#issuecomment-313111323
			quantity : 1
		}];
		
		client.checkout.addLineItems(checkoutId, lineItems).then((checkout) => {
		  //Update the cart counter
		  updateCartCounter(checkout);

		  //Add line items to the #cart div
		  updateCartContents(checkout);
		});
	});
}



/**
 * swapProductImagesListener()
 */
const swapProductImagesListener = function(checkout) {
	$('#variant-attribute-options li :radio').on('click', function() { 
		/** do something **/
	});
}



/**
 * toggleCartListener()
 */
 const toggleCartListener = function() {
 	$('.nav-cart a').on('click', function(event) {
		if($('#cart').css('z-index') == "-1") {
			$('#cart').css('z-index', "1");			
		}
		else {
			$('#cart').css('z-index', "-1");
		}
	});
 }



/**
 * updateCartContents()
 * Updates the visible cart contents on the front end
 */

const updateCartContents = function(checkout) {
	const $cart = $('#cart');
	const lineItems = checkout.lineItems.map(lineItem => {
		return [lineItem.title,lineItem.variant.title,lineItem.quantity,lineItem.variant.price]
	});

	let cartContent;

	//Haz items
	if(lineItems.length) {
		cartContent = lineItems.reduce((markup,lineItem) => {
			return markup + '<div class="cart-item"><div class="product-title">' + lineItem[0] + '</div><div class="variant-title">' + lineItem[1] + '</div><div class="variant-quantity">' + lineItem[2] + '</div><div class="variant-price">' + lineItem[3] + '</div></div>';
		}, "");
	}

	//Cart is empty
	else {
		cartContent = "Empty cart";
	}

	console.log(cartContent);

	$cart.html(cartContent);
}



/**
 * updateCartCounter()
 * Updates the quantity indicator on the cart link in the main nav
 */

const updateCartCounter = function(checkout) {
	console.log(checkout);
	// Set the cart count
	const cartCount = (checkout.lineItems.length) ? checkout.lineItems.map(lineItem => lineItem.quantity).reduce((count,quantity) => count + quantity) : 0;
	$('.nav-cart-counter').text(cartCount);
}

