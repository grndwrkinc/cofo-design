//Polyfill for Object.assign
if (typeof Object.assign != 'function') {
  // Must be writable: true, enumerable: false, configurable: true
  Object.defineProperty(Object, "assign", {
    value: function assign(target, varArgs) { // .length of function is 2
      'use strict';
      if (target == null) { // TypeError if undefined or null
        throw new TypeError('Cannot convert undefined or null to object');
      }

      var to = Object(target);

      for (var index = 1; index < arguments.length; index++) {
        var nextSource = arguments[index];

        if (nextSource != null) { // Skip over if undefined or null
          for (var nextKey in nextSource) {
            // Avoid bugs when hasOwnProperty is shadowed
            if (Object.prototype.hasOwnProperty.call(nextSource, nextKey)) {
              to[nextKey] = nextSource[nextKey];
            }
          }
        }
      }
      return to;
    },
    writable: true,
    configurable: true
  });
}

//Polyfill for endsWith()
if (!String.prototype.endsWith) {
	String.prototype.endsWith = function(search, this_len) {
		if (this_len === undefined || this_len > this.length) {
			this_len = this.length;
		}
        return this.substring(this_len - search.length, this_len) === search;
	};
}

import Client from 'shopify-buy';

require('es6-promise').polyfill();
require('isomorphic-fetch');


const ls = window.sessionStorage;
const checkoutID = ls.getItem("checkoutID");
const client = Client.buildClient({
	domain: 'shop.cofodesign.com',
	storefrontAccessToken: '8bc18701933e1f8b51aa4119d960e0ff'
});

//Append a container for the cart counter to the DOM in the header
$('.nav-cart a').append("<span class='nav-cart-counter'></span>");
$('a.nav-cart').append("<span class='nav-cart-counter'></span>");


/**
 * Get the Checkout Object and hook up the cart event listeners
 */

if(checkoutID) {

	//Use the checkoutID that already exists in local storage
	client.checkout.fetch(checkoutID).then((checkout) => {
		initCart(checkout);
	}, (err) => {
		//Possibly a stale checkoutID, create a new empty Checkout
		client.checkout.create().then((checkout) => {
			//Save the checkout ID to local storage
			ls.setItem('checkoutID', checkout.id);
			initCart(checkout);
		}, (err) => console.log('Rejected: ', err));
	});
}
else {

	//This is a new session, create a new empty Checkout
	client.checkout.create().then((checkout) => {
		//Save the checkout ID to local storage
		ls.setItem('checkoutID', checkout.id);
		initCart(checkout);
	}, (err) => console.log('Rejected: ', err));
}




const initCart = function(checkout) {

	// console.log(checkout);

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

		if($(this).text() === "Notify Me") {
			window.location.href = "mailto:info@cofodesign.com?subject=Out of stock: " + $('#product-details h3').text() + "&body=Please notify me when " + $('#product-details h3').text() + " is available for purchase.";
		}
		else {
			client.checkout.addLineItems(checkoutId, lineItems).then((checkout) => {
			  //Update the cart counter
			  updateCartCounter(checkout);
			  window.location.href= '/cart/';
			});
		}

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
	let hasPreOrderProduct = false;

	//Haz items
	 if (lineItems.length && $(window).width() > 600) {
		cartContent = lineItems.reduce(function (markup, lineItem) {
			var lineItemID = lineItem[0];
			var variantID = lineItem[1];
			var productTitle = lineItem[2];
			var variantTitle = lineItem[3];
			var variantQuantity = lineItem[4];
			var variantPrice = lineItem[5];
			var variantImg = lineItem[6];

			markup += '<tr class="cart-item">';
			markup += '<td><a href="#" class="remove-line-item" data-product-id="' + lineItemID + '" data-variant-id="' + variantID + '"> </a></td>';
			markup += '<td class="product-img"><img src="' + variantImg + '" alt=""></td>';
			markup += '<td class="product">';
			markup += '<span class="product-title">' + productTitle;
			if(products.indexOf(productTitle) != -1) {
				markup += ' (Pre-order<sup>1</sup>)';
				hasPreOrderProduct = true;
			}
			markup += '</span><br>';
			markup += '<span class="variant-title">Style: ' + variantTitle + '</span>';
			markup += '</td>';
			markup += '<td class="variant-quantity">';
			markup += '<input data-product-id="' + lineItemID + '" data-variant-id="' + variantID + '" type="number" min="0" pattern="[0-9]*" value="' + variantQuantity + '">';
			markup += '</td>';
			markup += '<td class="variant-price right">$';
			markup += parseFloat(variantPrice).formatMoney(2);
			markup += '</td>';
			markup += '</tr>';
			return markup;
		}, "<tr><th></th><th colspan='2'>Description</th><th>Qty</th><th class='right'>Price</th></tr>");

		cartContent = '<table>' + cartContent + '</table>';
		cartContent += '<div class="cart-footer">';
		cartContent += '	<div class="cart-subtotal">';
		cartContent += '		<h4><span class="cart-subtotal-title">Subtotal</span><span class="cart-subtotal-amount">$' + parseFloat(checkout.totalPrice).formatMoney(2) + '</span></h4>';
		cartContent += '		<p>Shipping & taxes calculated at checkout</p>';
		if(hasPreOrderProduct) {
			cartContent += '		<p class="preorder-disclaimer"><sup>1</sup><small>Your credit card will be charged immediately upon completing the purchase of a pre-ordered item. You will be notified when your order has shipped at a later date.</small></p>';
		}
		cartContent += '	</div>';
		cartContent += '	<div><a href="#" class="btn btn-update-cart">Update</a> <a href="#" class="btn btn-checkout">Checkout</a></div>';
		cartContent += '</div>';
	}

	  else if (lineItems.length && $(window).width() <= 600) {
	    cartContent = lineItems.reduce(function (markup, lineItem) {
	      var lineItemID = lineItem[0];
	      var variantID = lineItem[1];
	      var productTitle = lineItem[2];
	      var variantTitle = lineItem[3];
	      var variantQuantity = lineItem[4];
	      var variantPrice = lineItem[5];
	      var variantImg = lineItem[6];

	      markup += '<div class="cart-item"><div class="cart-row"><a href="#" class="remove-line-item" data-product-id="' + lineItemID + '" data-variant-id="' + variantID + '"> </a>';
	      markup += '<div class="product-img"><img src="' + variantImg + '" alt=""></div>';
	      markup += '<div class="product-title">' + productTitle + ' (Pre-order<sup>1</sup>)<br><span class="variant-title">Style: ' + variantTitle + '</span></div>';
	      markup += '<div class="variant-price right">$';
	      markup += parseFloat(variantPrice).formatMoney(2);
	      markup += '</div></div>';
	      markup += '<div class="cart-row"><div class="placeholder"></div><div class="variant-quantity"><p>Qty</p>';
	      markup += '<input data-product-id="' + lineItemID + '" data-variant-id="' + variantID + '" type="number" min="0" pattern="[0-9]*" value="' + variantQuantity + '">';
	      markup += '</div><div class="update"><a href="#" class="btn-update-cart">Update</a></div></div></div>';
	      return markup;
	    }, "<div></div>");

	    cartContent = '<div>' + cartContent + '</div>';
	    cartContent += '<div class="cart-footer">';
	    cartContent += '  <div class="cart-subtotal">';
	    cartContent += '    <h4><span class="cart-subtotal-title">Subtotal</span><span class="cart-subtotal-amount">$' + parseFloat(checkout.totalPrice).formatMoney(2) + '</span></h4>';
	    cartContent += '    <p>Shipping & taxes calculated at checkout</p>';
	    if(hasPreOrderProduct) {
	    	cartContent += '    <p class="preorder-disclaimer"><sup>1</sup><small>Your credit card will be charged immediately upon completing the purchase of a pre-ordered item. You will be notified when your order has shipped at a later date.</small></p>';
	    }
	    cartContent += '  </div>';
	    cartContent += '  <div><a href="#" class="btn btn-update-cart">Update</a> <a href="#" class="btn btn-checkout">Checkout</a></div>';
	    cartContent += '</div>';
	  }

	//Cart is empty
	else {
		cartContent = "<p class='pre-header'>Your shopping cart is empty.<p>";

		// if(hasShop) {
		cartContent += "<p><a class='link' href='/shop/'>&laquo; Continue shopping</a><p>";
		// }
		// else {
		// 	cartContent += "<p><a class='link' href='/product/the-roque/'>&laquo; Shop The Roque Chair</a><p>";
		// }
	}

	$cart.html(cartContent);
	$('a.remove-line-item').on('click', removeLineItem);

	var checkoutURL = checkout.webUrl.replace("cofodesign-com.myshopify.com","shop.cofodesign.com")
	$('.btn-checkout').attr('href',checkoutURL);
	
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
	if ($(window).width() > 600) {
		$($(this).parent().siblings('.variant-quantity').find('input')).val(0);
	} else {
		$($(this).parents('.cart-item').find('.variant-quantity').find('input')).val(0);
	}
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
