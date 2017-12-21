import Client from 'shopify-buy';

const ls = window.localStorage;
const checkoutID = ls.getItem("checkoutID");
const client = Client.buildClient({
	domain: 'cofodesign-com.myshopify.com',
	storefrontAccessToken: '8bc18701933e1f8b51aa4119d960e0ff'
});

//Append a container for the cart counter to the DOM in the header
$('.nav-cart a').append("<span class='nav-cart-counter'></span>");

//Check if a checkout exists
if(checkoutID) {
	//If yes, use it.
	client.checkout.fetch(checkoutID).then((checkout) => {
		addCartEventListeners(checkout);
	});
}
else {
	//Otherwise, create a new empty checkout
	client.checkout.create().then((checkout) => {
		//Save the checkout ID to local storage
		ls.setItem('checkoutID', checkout.id);
		addCartEventListeners(checkout);
	});
}

const addCartEventListeners = function(checkout) {
	//Set the Cart link in the nav to point to the current shopping cart
	$('.nav-cart a').attr('href',"http://shop.cofo-dev.grndwrk.ca/");

	//Set the cart counter
	updateCartCounter(checkout);

	// When the variant is changed, change the images
	$('#variant-attribute-options li :radio').on('click', function(event) {

	});

	$('#add-to-cart').on('click', function(event) {
		const checkoutId = checkout.id;
		const lineItems = [{
			variantId : btoa("gid://shopify/ProductVariant/" + $('input[name=variant]:checked').val()), // https://github.com/Shopify/js-buy-sdk/issues/105#issuecomment-313111323
			quantity : 1
		}];
		
		client.checkout.addLineItems(checkoutId, lineItems).then((checkout) => {
		  //Update the cart counter
		  updateCartCounter(checkout);
		});
	});
}

const updateCartCounter = function(checkout) {
	console.log(checkout);
	// Set the cart count
	const cartCount = (checkout.lineItems.length) ? checkout.lineItems.map(lineItem => lineItem.quantity).reduce((count,quantity) => count + quantity) : 0;
	$('.nav-cart-counter').text(cartCount);
}

