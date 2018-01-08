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
		initCart(checkout);
	});
}
else {
	//This is a new session, create a new empty Checkout
	client.checkout.create().then((checkout) => {
		//Save the checkout ID to local storage
		ls.setItem('checkoutID', checkout.id);
		initCart(checkout);
	});
}




const initCart = function(checkout) {
	//Set the Cart link in the nav to point to the current shopping cart
	// $('.nav-cart a').attr('href',"http://shop.cofo-dev.grndwrk.ca/cart/");

	// Initialize the cart counter
	updateCartCounter(checkout);

	// Add to cart
	addToCartListener(checkout);

	// Swap the product images when variant is changed
	swapProductImagesListener(checkout);

	if($('body').hasClass('page-cart')) {
		getCartContents(checkout);
	}
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
		  window.location.href= '/cart/';
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
 * getCartContents()
 * 
 */

const getCartContents = function(checkout) {
	const $cart = $('#cart');
	const lineItems = checkout.lineItems.map(lineItem => {
		return [lineItem.id,lineItem.variant.id,lineItem.title,lineItem.variant.title,lineItem.quantity,lineItem.variant.price,lineItem.variant.image.src]
	});

	let cartContent;

	//Haz items
	if(lineItems.length) {
		cartContent = lineItems.reduce((markup,lineItem) => {
			const lineItemID = lineItem[0];
			const variantID = lineItem[1];
			const productTitle = lineItem[2];
			const variantTitle = lineItem[3];
			const variantQuantity = lineItem[4];
			const variantPrice = lineItem[5];
			const variantImg = lineItem[6];

			markup += '<tr class="cart-item">';
			markup += 	'<td><a href="#" class="remove-line-item" data-product-id="' + lineItemID + '" data-variant-id="' + variantID + '"> </a></td>';
			markup += 	'<td class="product-img"><img src="' + variantImg + '" alt=""></td>';
			markup +=	'<td class="product">';
			markup +=		'<span class="product-title">' + productTitle + ' (Pre-order<sup>1</sup>)</span><br>';
			markup +=		'<span class="variant-title">Style: ' + variantTitle + '</span>';
			markup +=	'</td>';
			markup +=	'<td class="variant-quantity">';
			markup +=		'<input data-product-id="' + lineItemID + '" data-variant-id="' + variantID + '" type="number" min="0" pattern="[0-9]*" value="' + variantQuantity + '">';
			markup +=	'</td>';
			markup +=	'<td class="variant-price right">$';
			markup +=		parseFloat(variantPrice).formatMoney(2);
			markup +=	'</td>';
			markup +='</tr>';
			return markup;
		}, "<tr><th></th><th colspan='2'>Description</th><th>Qty</th><th class='right'>Price</th></tr>");

		cartContent = '<table>' + cartContent + '</table>';
		cartContent += '<div class="cart-footer">';
		cartContent += '	<div class="cart-subtotal">';
		cartContent += '		<h4><span class="cart-subtotal-title">Subtotal</span><span class="cart-subtotal-amount">$' + parseFloat(checkout.totalPrice).formatMoney(2) + '</span></h4>';
		cartContent += '		<p>Shipping & taxes calculated at checkout</p>';
		cartContent += '		<p class="preorder-disclaimer"><sup>1</sup><small>Your credit card will be charged immediately upon completing the purchase of a pre-ordered item. You will be notified when your order has shipped at a later date.</small></p>';
		cartContent += '	</div>';
		cartContent += '	<div><a href="#" class="btn btn-update-cart">Update</a> <a href="#" class="btn btn-checkout">Checkout</a></div>';
		cartContent += '</div>';
	}

	//Cart is empty
	else {
		cartContent = "Empty cart";
	}

	$cart.html(cartContent);
	$('a.remove-line-item').on('click', removeLineItem);
	$('.btn-checkout').attr('href',checkout.webUrl);
	$('.btn-update-cart').on('click', function(event) {
		event.preventDefault();
		updateCart();
	})
}



/**
 * removeLineItem()
 * Updates the quantity indicator on the cart link in the main nav
 */

const removeLineItem = function(event) {
	event.preventDefault();
	$($(this).parent().siblings('.variant-quantity').find('input')).val(0);
	updateCart();
}

const updateCart = function() {
	const lineItems = $('.cart-item').toArray().map(cartItem => {
		const id = $(cartItem).find('.variant-quantity input').data('product-id');
		const quantity = $(cartItem).find('.variant-quantity input').val();
		const variantId = $(cartItem).find('.variant-quantity input').data('variant-id');
		return {
			id : id,
			quantity: parseInt(quantity),
			variantId: variantId
		};
	});

	client.checkout.updateLineItems(checkoutID, lineItems).then(checkout => {
		//Update the cart counter
		updateCartCounter(checkout);

		//Add line items to the #cart div
		getCartContents(checkout);
	});
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



Number.prototype.formatMoney = function(c, d, t){
var n = this, 
    c = isNaN(c = Math.abs(c)) ? 2 : c, 
    d = d == undefined ? "." : d, 
    t = t == undefined ? "," : t, 
    s = n < 0 ? "-" : "", 
    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))), 
    j = (j = i.length) > 3 ? j % 3 : 0;
   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
 };
