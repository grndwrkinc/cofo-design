var cofo = {};
// var masonryInit = true; // set Masonry init flag

$(document).ready(function () {
  cofo.init();
});

cofo.init = function() {

	cofo.animatePageElements();
	cofo.animateHero();

	if($('.single-product').length){
		cofo.initProductDetails();
		cofo.initProductGallery();
	}

	if($('.page-about').length){
		cofo.fluidVids();
	}

	if($('.page-design-challenge').length || $('.page-about').length){
		cofo.initMasonry();
	}

	//Open/close mobile menu
	cofo.mobileNav();

	//Open FB share in modal 
	$('.social-share').click(function(e) {
        e.preventDefault();
        window.open($(this).attr('href'), 'fbShareWindow', 'height=450, width=550, top=' + ($(window).height() / 2 - 275) + ', left=' + ($(window).width() / 2 - 225) + ', toolbar=0, location=0, menubar=0, directories=0, scrollbars=0');
        return false;
    });
};

//Initialize the Product Details container
cofo.initProductDetails = function() {
	var $details = $('.product-details-container');
	var heroOverlap = 155;
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
	};

	$('.swatch-toggle').on('mouseup', function() {
		activeVariant = $(this).attr('for');
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

cofo.initProductGallery = function() {
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

cofo.initMasonry = function() {
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
};

cofo.animateHero = function() {
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

cofo.animatePageElements = function() {
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
	cofo.animateOne(fadein);
	cofo.animateOne(slideup);
	cofo.animateOne(slideright);
	cofo.animateOne(slideleft);
	cofo.animateOne(slideupright);
	cofo.animateOne(slidedownright);
	cofo.animateOne(slideupleft);
	cofo.animateSet(animationSet);
	
	//do the same on scroll
	$(window).scroll(function() {
		cofo.animateOne(fadein);
		cofo.animateOne(slideup);
		cofo.animateOne(slideright);
		cofo.animateOne(slideleft);
		cofo.animateOne(slideupright);
		cofo.animateOne(slidedownright);
		cofo.animateOne(slideupleft);
		cofo.animateSet(animationSet);
	});
};

cofo.animateOne = function(elements){
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

cofo.animateSet = function(elements){
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

cofo.mobileNav = function(){

	$('.hamburger').on('click', function(){
		$('.mobile-nav').toggleClass('opened');
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
