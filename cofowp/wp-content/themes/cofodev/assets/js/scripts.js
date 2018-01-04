var cofo = {};
// var masonryInit = true; // set Masonry init flag

$(document).ready(function () {
  cofo.init();
});

cofo.init = function() {

	if($('.single-product').length){
		cofo.initProductDetails();
		cofo.initProductGallery();
	}

	if($('.page-about').length){
		cofo.fluidVids();
	}
};

//Initialize the Product Details container
cofo.initProductDetails = function() {

	var $details = $('.product-details-container');
	var heroOverlap = 155;
	var detailsHeight = $('#product-details').outerHeight();
	var scrollTop = ($details.offset().top) - heroOverlap;
	var offset, dimensionsTop, activeVariant;

	// Fix/unfix the container on scroll
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
		$('.image-gallery').fadeIn();
		var activeClass = $(this).attr('class');
		//Match images by class
		$('.thumbnail-img').each(function(){
			if($(this).hasClass(activeClass)){
				$(this).addClass('active');
				//Clone the active thumbnail and add to main gallery element
				// $(this).children('img').clone().appendTo('.image-gallery .main-img');
				$('.main-img')
					.addClass('hidden')
					.each(function(){
						if($(this).hasClass(activeClass)){
							$(this).removeClass('hidden');
						}
					});

			} else {
				$(this).removeClass('active');
			}
		});
	});

	$('.close').on('click', function(){
		$('.image-gallery').fadeOut('slow');
		// $('.thumbnail-img').removeClass('active').removeClass('prev').removeClass('next');
	});

	//When a thumnail is clicked, empty the main container, add the coresponding img
	$('.thumbnail-img').on('click', function(){
		$('.thumbnail-img').removeClass('active');
		var activeClass = $(this).removeClass('thumbnail-img togglable').attr('class');
		$(this).addClass('active thumbnail-img togglable');

		// $('.image-gallery .main-img').empty();
		//Clone the active thumbnail and add to main gallery element
		// $(this).clone().appendTo('.image-gallery .main-img');
		
		console.log(activeClass, 'poop');

		$('.main-img')
			.addClass('hidden')
			.each(function(){
				if($(this).hasClass(activeClass)){
					$(this).removeClass('hidden');
				}
			});
	});

	//Prev/next buttons
	// $('.btn-prev').on('click', function(){

	// });

	// $('.btn-next').on('click', function(){
	// 	//If there is a next sibling, make it active
	// 	if($('.thumbnails .active').next().hasClass('thumbnail-img')){
	// 		$('.thumbnails .active').next().addClass('next');
	// 		// $('.thumbnail-img').removeClass('active');
	// 		// $('.thumbnails .next').next().addClass('active');
	// 		// $('.thumbnails .next').removeClass('next');
	// 	} else {
	// 		console.log('no next!');
	// 	}
	// });

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
