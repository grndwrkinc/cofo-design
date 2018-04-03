var cofo = {};
// var masonryInit = true; // set Masonry init flag

$(document).ready(function () {
  cofo.init();
});

cofo.init = function() {
	cofo.animate_PageElements();
	cofo.animate_Hero();
	cofo.navigation_Fixed();
	cofo.navigation_Mobile();

	if($('.home').length) {
		cofo.homePage_Slider();
	}

	if($('.single-product').length){
		cofo.productPage_DetailsContainer();
		if($(window).width() > 600) {
			cofo.productPage_Gallery();
		}
	}

	if($('.page-about').length){
		cofo.fluidVids();
	}

	if($('.page-design-challenge').length || $('.page-about').length){
		cofo.designChallengePage_Masonry();
	}

	if($('.page-shop').length){
		cofo.shopPage_PositionFiltersMenu();
		cofo.shopPage_VariantSelectorEvents();
		cofo.shopPage_ProductImageTouchEvent();		
	}

	if($('.blog').length) {
		cofo.blogIndexPage_PositionContent();
		$(window).on('resize', cofo.blogIndexPage_PositionContent);

		 $.fn.almComplete = function(){
		    setTimeout(cofo.animate_PageElements, 100);
		  };
	}

	//Open FB share in modal 
	$('.social-share').click(function(e) {
        e.preventDefault();
        window.open($(this).attr('href'), 'fbShareWindow', 'height=450, width=550, top=' + ($(window).height() / 2 - 275) + ', left=' + ($(window).width() / 2 - 225) + ', toolbar=0, location=0, menubar=0, directories=0, scrollbars=0');
        return false;
    });
};

cofo.animate_Hero = function() {
	var herokids = $('.hero-text').children();
	var timer = 300;

	herokids.each(function(){
		var _this = this;

		setTimeout(function(){ 
			$(_this).addClass('animate-me');
		}, timer);
		timer = timer + 200;
	});
};

cofo.animate_One = function(elements){
	// add animate-me class when element is in view
	var scrolled = $(window).scrollTop() + $(window).height();
	elements.each(function(){
		var _this = this;
		var extraOffset = '';
		if($(window).width() <= 600) {
			extraOffset = 20;
		} else {
			extraOffset = 200;
		}
		// get top measurement
		if($(_this).is($("#product-details"))) {
			extraOffset = 0;
		}
		var offset = $(_this).offset().top + extraOffset;
		//add animation class if scrolled into view
		if(scrolled > offset){
			$(_this).addClass('animate-me');
		}
	});
};

cofo.animate_PageElements = function() {
	//find each animation element
	var fadein = $('.fadein');
	var slideright = $('.slideright');
	var slideleft = $('.slideleft');
	var slideup = $('.slideup');
	var slideupright = $('.slideupright');
	var slidedownright = $('.slidedownright');
	var slideupleft = $('.slideupleft');
	var animationSet = $('.anm-container');

	// add animate-me class when element is in view
	cofo.animate_One(fadein);
	cofo.animate_One(slideup);
	cofo.animate_One(slideright);
	cofo.animate_One(slideleft);
	cofo.animate_One(slideupright);
	cofo.animate_One(slidedownright);
	cofo.animate_One(slideupleft);
	cofo.animate_Set(animationSet);
	
	//do the same on scroll
	$(window).scroll(function() {
		cofo.animate_One(fadein);
		cofo.animate_One(slideup);
		cofo.animate_One(slideright);
		cofo.animate_One(slideleft);
		cofo.animate_One(slideupright);
		cofo.animate_One(slidedownright);
		cofo.animate_One(slideupleft);
		cofo.animate_Set(animationSet);
	});
};

cofo.animate_Set = function(elements){
	// add animate-me class when container element is in view
	var scrolled = $(window).scrollTop() + $(window).height();
	elements.each(function(){
		var _this = this;
		var extraOffset = '';
		if($(window).width() <= 600) {
			extraOffset = 20;
		} else {
			extraOffset = 200;
		}
		// get top measurement
		var offset = $(_this).offset().top + extraOffset;

		if(scrolled > offset){
			//find all children to be animated
			var children = $(_this).find('.anm-item');
			var timer = 300;

			children.each(function(){
				var _this = this;

				setTimeout(function(){ 
					$(_this).addClass('animate-me');
				}, timer);
				timer = timer + 150;
			});

		}
	});
};

cofo.blogIndexPage_PositionContent = function() {
	if($(window).width() > 768) {
		var imageHeight = $('#main .large-container .post-image').height();
		var padding = $('#main .large-container').outerHeight() - $('#main .large-container').height();

		var summaryBottomOffset = $('#main .large-container .post-summary').offset().top + parseInt($('#main .large-container .post-summary').css('margin-top')) + $('#main .large-container .post-summary').outerHeight();
		var imageBottomOffset = $('#main .large-container .post-image').offset().top + $('#main .large-container .post-image').height();
		var offset = 0;
		if(summaryBottomOffset > imageBottomOffset) {
			offset = summaryBottomOffset - imageBottomOffset;
		}

		$('#main .large-container .post-summary').css( {
			'transform' : 'translateY(calc(-'+imageHeight+'px + 5%))',
			'display' : 'block'
		});
		$('#main .large-container').css('height', imageHeight+padding+offset+'px');
	}
	else {
		$('#main .large-container .post-summary').css( {
			'transform' : 'none',
			'display' : 'block'
		});
		$('#main .large-container').attr('style','');
	}
};

cofo.designChallengePage_Masonry = function() {
	var $container = $('.masonry-gallery');

	$container.imagesLoaded(function() {
		$container.masonry({
			gutter: ".gutter-sizer",
			columnWidth: ".grid-sizer",
			itemSelector: '.grid-item',
			transitionDuration: 0,
			percentPosition: true,
			stamp: '.stamp'
		});
	});

	setTimeout(function() { $container.masonry('layout');}, 1000);
};

cofo.homePage_Slider = function() {
	$('.slider-top').slick({
  		asNavFor: '.slider-bottom',
		prevArrow: ".btn-prev",
		nextArrow: ".btn-next",
		appendArrows: ".slider",
		draggable: false,
		// autoplay: false,
		// autoplaySpeed: 7000,
  		fade: true,
  		speed: 1100
	});

	$('.slider-bottom').slick({
		asNavFor: '.slider-top',
		prevArrow: ".btn-prev",
		nextArrow: ".btn-next",
		draggable: false,
		autoplay: true,
		autoplaySpeed: 7000,
		speed: 1300
	})
	.init(function() {
		$('.slick-cloned .home-slider-content').removeClass('anm-container');
		$('.slick-cloned h2').removeClass('anm-item slideright-item');
		$('.slick-cloned .bordered').removeClass('anm-item slideright-item');
	});

	$('.slider-top').on('afterChange', function(event, slick, currentSlide) {
		$('.slide-count .current').html(currentSlide + 1);
	});
};

cofo.navigation_Fixed = function() {
	var $nav = $('header#masthead');
	var navHeight = $nav.outerHeight();
	var offset;
	var deviceNav;
	var fixedDeviceNav;
	var isSafari = !!navigator.userAgent.match(/safari/i) && !navigator.userAgent.match(/chrome/i) && typeof document.body.style.webkitFilter !== "undefined" && !window.chrome;
	var setNavVars = function() {
		deviceNav = '.main-navigation';
		fixedDeviceNav = '.main-navigation.fixed';
		if($(window).width() <= 1024) {
			deviceNav = '.mobile-nav';
			fixedDeviceNav = '.mobile-nav.fixed';
		}
	};

	// Fix/unfix the nav on scroll
	setNavVars(); $(window).on('resize', setNavVars);

	if(isSafari) {	
		$(deviceNav).addClass('fixed transition reset');
	}

	$(window).scroll(function() {
		offset = $(this).scrollTop();
		// Fix nav
		if(offset >= navHeight) {
			//Keep the header height consistent
			$('header#masthead').css('height', navHeight);
			//Fix the nav
			$(deviceNav).addClass('fixed');
			$(deviceNav).removeClass('reset');
			setTimeout(function(){ 
				$(deviceNav).addClass('transition');
			}, 400);
		}
		// Unfix and return to OG position
		if( offset < (navHeight - 68) && $(fixedDeviceNav).length) {
			$(deviceNav).addClass('reset');
		}

		if (offset === 0) {
			//Set timeout to wait for reset animation to end
			if(!isSafari) {
				setTimeout(function(){
					$('header#masthead').css('height', 'auto');
					$(deviceNav).removeClass('fixed transition reset');
				}, 400);
			}
		}
	});
};

//Open/close mobile menu
cofo.navigation_Mobile = function(){

	$('.hamburger').on('click', function(){
		$('.mobile-nav').toggleClass('opened');
	});
};

//Initialize the Product Details container
cofo.productPage_DetailsContainer = function() {
	var $details = $('.product-details-container');
	var $button = $('#product-details button');
	var heroOverlap = 273;
	var detailsHeight = $('#product-details').outerHeight();
	var scrollTop = ($details.offset().top) - heroOverlap;
	var offset, dimensionsTop, activeVariant;

	// Fix/unfix the container on scroll
	if($(window).width() > 600) {
		$(window).scroll(function() {
			offset = $(this).scrollTop();
			dimensionsTop = $('.product-dimensions').offset().top;
			
			//Fix product details
			if( offset >= scrollTop ) {
				$details.addClass('fixed');
			} 
			//Unfix and position product details
			if( (offset + detailsHeight + heroOverlap) >= dimensionsTop ) {
				$details.removeClass('fixed');
				$details.css({'position': 'absolute', 'top': dimensionsTop - detailsHeight});
			} 
			//Unfix and return to OG position
			if( offset < scrollTop ) {
				$details.removeClass('fixed');
				$details.css({'position': 'relative', 'top': 0 });
			}
		});
	}

	$('.swatch-toggle').on('mouseup', function() {
		activeVariant = $(this).attr('for');

		//Update the Product Details (i.e. Out of Stock, Add to cart, Notify Me, etc.)
		var inventoryMessage = "";
		var buttonLabel = "Add to cart";
		$('#product-details button').attr('id','add-to-cart');

		if($(this).data('pre-order')) {
			buttonLabel = "Pre-order";
		}

		if($(this).data('inventory-management')){
			if($(this).data('inventory-quantity') === 0 && $(this).data('inventory-policy') === "deny") {
				inventoryMessage = "Out of Stock";
				buttonLabel = "Notify Me";
				$('#product-details button').attr('id','');

			}
			//Limited stock
			else if($(this).data('inventory-quantity') < 5) {
				inventoryMessage = "Limited Quantity";
			}
		}

		$('.inventory-message').text(inventoryMessage);
		$button.text(buttonLabel);


		//Switch product images
		$('.togglable')
			.addClass('hidden')
			.each(function() {
				if($(this).data('id') === activeVariant) {
					$(this).removeClass('hidden');
				}
			});
		$(window).trigger('resize');
	});
};

cofo.productPage_Gallery = function() {
	//Determine which image has been clicked and open the gallery
	$('.product-explore img').on('click', function(){
		$('.image-gallery').fadeIn(100);
		var activeClass = $(this).attr('class').split(" ")[0];
		//Match images by class
		$('.thumbnail-img').each(function(){
			if($(this).hasClass(activeClass)){
				$(this).addClass('active').click();
			}
		});
	});

	$('.close').on('click', function(){
		$('.image-gallery').fadeOut(100);
	});

	// Keyboard events
	$(document).on('keyup', function(e) {
		switch(e.which) {
			//esc - close modal
			case 27 : e.preventDefault(); $('.close').trigger('click'); break;
			//left arrow - previous
			case 37 : e.preventDefault(); $('.btn-prev').trigger('click'); break;
			//right arrow - next
			case 39 : e.preventDefault(); $('.btn-next').trigger('click'); break;
		}
	});

	//When a thumbnail is clicked, empty the main container, add the coresponding img
	$('.thumbnail-img').on('click', function(){
		$('.thumbnail-img').removeClass('active');
		var activeClass = $(this).removeClass('thumbnail-img togglable').attr('class');
		$(this).addClass('active thumbnail-img togglable');

		$('.main-img')
			.addClass('hidden')
			.each(function(){
				if($(this).hasClass(activeClass)){
					$(this).removeClass('hidden');
				}
			});
	});

	//Prev/next buttons
	$('.btn-prev').on('click', function() {
		var $thumbs = $('.image-gallery .thumbnails .thumbnail-img').not('.hidden');
		var $active = $('.image-gallery .thumbnails .thumbnail-img.active').removeClass('active');
		if ($active.prev() && $active.prev().not('.hidden').length) {
			$active.prev().addClass('active');
		}
		else {
			$thumbs.last().addClass('active');
		}

		$('.image-gallery .thumbnails .thumbnail-img.active').click();
	});

	$('.btn-next').on('click', function() {
		var $thumbs = $('.image-gallery .thumbnails .thumbnail-img').not('.hidden');
		var $active = $('.image-gallery .thumbnails .thumbnail-img.active').removeClass('active');
		if ($active.next() && $active.next().not('.hidden').length) {
			$active.next().addClass('active');
		}
		else {
			$thumbs.first().addClass('active');
		}

		$('.image-gallery .thumbnails .thumbnail-img.active').click();
	});
};

//Initialize the Filter Menu on the Shop Page
cofo.shopPage_PositionFiltersMenu = function() {
	var $filters = $('#filters');
	var $listing = $('#listing');
	var filtersHeight = $filters.outerHeight();
	var scrollTop = $listing.offset().top;
	var offset, footerTop;

	// Fix/unfix the container on scroll
	if($(window).width() > 600) {
		$(window).scroll(function() {
			offset = $(this).scrollTop();
			footerTop = $('.site-footer').offset().top;

			//Fix product details
			if( offset >= scrollTop ) {
				$filters
					.addClass('fixed')
					.css({ 'top': $listing.css('padding-top') });
			} 
			//Unfix and position product details
			if( (offset + filtersHeight) >= footerTop ) {
				$filters
					.removeClass('fixed')
					.css({ 'position': 'absolute', 'top': footerTop - filtersHeight });
			} 
			//Unfix and return to OG position
			if( offset < scrollTop ) {
				$filters
					.removeClass('fixed')
					.css({ 'position': 'absolute', 'top': 'auto' });
			}
		});
	}

	$("#filters button").on('click', function() {
		if($(window).width() < 769) {
			$("#filters .inner").toggle();
			if($("#filters .inner:visible").length) {
				$("#filters button").html('&ndash; Filter');
			}
			else {
				$("#filters button").html('+ Filter');
			}
		}
	});
};

cofo.shopPage_VariantSelectorEvents = function() {
	var $items = ($('.collection .item').length) ? $('.collection .item') : $('.category .item');


	$items.each(function() {
		var $itemImages = $(this).find('.item-image img');
		var $variants = $(this).find('.variant-attribute-options li img');
		

		$variants
		.on('mouseover', function() {
			var $variant = $(this);

			$itemImages.hide();
			$variants.removeClass('active');

			$itemImages.each(function() {
				if($(this).data('alt') === $variant.data('alt')) {
					$(this).show();
					$variant.addClass('active');
				}
			});

			// $itemImages.find("[data-alt='" + $(this).data('alt') + "']").show();

		})
		.on('mouseout', function() {
			if($($variants[0]).hasClass('active')) {
				$itemImages.each(function() {
					$(this).attr('style','');
				});
			}
			// $variants.removeClass('active');
			// $($variants[0]).addClass('active');
		});
	});
};

cofo.shopPage_ProductImageTouchEvent = function() {
	$('.item-image').on('touchend', function() {
		window.location.url = $(this).find('a').attr('href');
	});
};

//*****************************************************************
//* FluidVids.js - Fluid and Responsive YouTube/Vimeo Videos v1.0.0 by 
//* Todd Motto: http://www.toddmotto.com
//* Latest version: https://github.com/toddmotto/fluidvids
//* 
//* Copyright 2013 Todd Motto
//* Licensed under the MIT license
//* http://www.opensource.org/licenses/mit-license.php
//* 
//* A raw JavaScript alternative to FitVids.js, fluid width video embeds
//* 
cofo.fluidVids = function() {
	var iframes = document.getElementsByTagName('iframe');

	for (var i = 0; i < iframes.length; i++) {
		var iframe = iframes[i];
		var players = /www.youtube.com|player.vimeo.com/;
		var iframeSrc = iframe.src;

		if(iframeSrc.search(players) !== -1) {
			iframe.src = "";
		
			var videoRatio = (iframe.height / iframe.width) * 100;

			iframe.style.position = 'absolute';
			iframe.style.top = '0';
			iframe.style.left = '0';
			iframe.width = '100%';
			iframe.height = '100%';
			iframe.webkitallowfullscreen = 'true';
			iframe.mozallowfullscreen = 'true';
			iframe.allowfullscreen = 'true';

			var div = document.createElement('div');
			div.className = 'video-wrap';
			div.style.width = '100%';
			div.style.position = 'relative';
			div.style.paddingTop = videoRatio + '%';

			var parentNode = iframe.parentNode;
			parentNode.insertBefore(div, iframe);
			div.appendChild(iframe);

			var extra;
			// Added the following code to add wmode=transparent to the 
			// end of youtube embeds to ensure they don't break 
			// z-indexing.
			if(iframeSrc.indexOf('youtube') !== -1  && $('.modal').length) {
				extra = "wmode=transparent&autoplay=1";
			}
			if(iframeSrc.indexOf('youtube') !== -1  && !$('.modal').length) {
				extra = "wmode=transparent";
			}

			//Add ability for vimeo videos to autoplay
			if(iframeSrc.indexOf('vimeo') !== -1 && $('.modal').length) {
				extra = "autoplay=1";
			}

			if(iframeSrc.indexOf('?') !== -1) {
				var getQString = iframeSrc.split('?');
				var oldString = getQString[1];
				var newString = getQString[0];
				
				iframeSrc = newString+'?'+extra+'&'+oldString;
			}
			else {
				iframeSrc = iframeSrc + '?' + extra;
			}

			iframe.src = iframeSrc;
		}
	}
};
