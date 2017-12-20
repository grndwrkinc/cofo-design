import Client from 'shopify-buy';

const client = Client.buildClient({
	domain: 'cofodesign-com.myshopify.com',
	storefrontAccessToken: '8bc18701933e1f8b51aa4119d960e0ff'
});

// Create an empty checkout
client.checkout.create().then((checkout) => {


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
		  console.log(checkout); // Checkout with two additional line items
		  console.log(checkout.lineItems) // Line items on the checkout
		});
	});

});