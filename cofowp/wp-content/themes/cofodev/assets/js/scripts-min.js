var cofo={};
// var masonryInit = true; // set Masonry init flag
$(document).ready(function(){cofo.init()}),cofo.init=function(){cofo.animate_PageElements(),cofo.animate_Hero(),cofo.navigation_Fixed(),cofo.navigation_Mobile(),$(".home").length&&cofo.homePage_Slider(),$(".single-product").length&&(cofo.productPage_DetailsContainer(),600<$(window).width()&&cofo.productPage_Gallery()),$(".page-about").length&&cofo.fluidVids(),($(".page-design-challenge").length||$(".page-about").length)&&cofo.designChallengePage_Masonry(),$(".page-shop").length&&(cofo.shopPage_PositionFiltersMenu(),cofo.shopPage_VariantSelectorEvents(),cofo.shopPage_ProductImageTouchEvent()),$(".blog").length&&(cofo.blogIndexPage_PositionContent(),$(window).on("resize",cofo.blogIndexPage_PositionContent),$.fn.almComplete=function(){setTimeout(cofo.animate_PageElements,100)}),
//Open FB share in modal 
$(".social-share").click(function(e){return e.preventDefault(),window.open($(this).attr("href"),"fbShareWindow","height=450, width=550, top="+($(window).height()/2-275)+", left="+($(window).width()/2-225)+", toolbar=0, location=0, menubar=0, directories=0, scrollbars=0"),!1})},cofo.animate_Hero=function(){var e=$(".hero-text").children(),t=300;e.each(function(){var e=this;setTimeout(function(){$(e).addClass("animate-me")},t),t+=200})},cofo.animate_One=function(e){
// add animate-me class when element is in view
var o=$(window).scrollTop()+$(window).height();e.each(function(){var e=this,t="",i;t=$(window).width()<=600?20:200,
// get top measurement
$(e).is($("#product-details"))&&(t=0),
//add animation class if scrolled into view
$(e).offset().top+t<o&&$(e).addClass("animate-me")})},cofo.animate_PageElements=function(){
//find each animation element
var e=$(".fadein"),t=$(".slideright"),i=$(".slideleft"),o=$(".slideup"),a=$(".slideupright"),n=$(".slidedownright"),s=$(".slideupleft"),l=$(".anm-container");
// add animate-me class when element is in view
cofo.animate_One(e),cofo.animate_One(o),cofo.animate_One(t),cofo.animate_One(i),cofo.animate_One(a),cofo.animate_One(n),cofo.animate_One(s),cofo.animate_Set(l),
//do the same on scroll
$(window).scroll(function(){cofo.animate_One(e),cofo.animate_One(o),cofo.animate_One(t),cofo.animate_One(i),cofo.animate_One(a),cofo.animate_One(n),cofo.animate_One(s),cofo.animate_Set(l)})},cofo.animate_Set=function(e){
// add animate-me class when container element is in view
var n=$(window).scrollTop()+$(window).height();e.each(function(){var e=this,t="",i;if(t=$(window).width()<=600?20:200,$(e).offset().top+t<n){
//find all children to be animated
var o=$(e).find(".anm-item"),a=300;o.each(function(){var e=this;setTimeout(function(){$(e).addClass("animate-me")},a),a+=150})}})},cofo.blogIndexPage_PositionContent=function(){if(768<$(window).width()){var e=Math.round($("#main .large-container .post-image").height()),t=$("#main .large-container").outerHeight()-$("#main .large-container").height(),i=$("#main .large-container .post-summary").offset().top+parseInt($("#main .large-container .post-summary").css("margin-top"))+$("#main .large-container .post-summary").outerHeight(),o=$("#main .large-container .post-image").offset().top+$("#main .large-container .post-image").height(),a=0;o<i&&(a=i-o);var n=.05*$("#main .large-container .post-summary").outerHeight();$("#main .large-container .post-summary").css({transform:"translateY(-"+Math.round(e-n)+"px)",display:"block"}),$("#main .large-container").css("height",e+t+a+"px")}else $("#main .large-container .post-summary").css({transform:"none",display:"block"}),$("#main .large-container").attr("style","")},cofo.designChallengePage_Masonry=function(){var e=$(".masonry-gallery");e.imagesLoaded(function(){e.masonry({gutter:".gutter-sizer",columnWidth:".grid-sizer",itemSelector:".grid-item",transitionDuration:0,percentPosition:!0,stamp:".stamp"})}),setTimeout(function(){e.masonry("layout")},1e3)},cofo.homePage_Slider=function(){$(".slider-top").slick({asNavFor:".slider-bottom",prevArrow:".btn-prev",nextArrow:".btn-next",appendArrows:".slider",draggable:!1,
// autoplay: false,
// autoplaySpeed: 7000,
fade:!0,speed:1100}),$(".slider-bottom").slick({asNavFor:".slider-top",prevArrow:".btn-prev",nextArrow:".btn-next",draggable:!1,autoplay:!0,autoplaySpeed:7e3,speed:1300}).init(function(){$(".slick-cloned .home-slider-content").removeClass("anm-container"),$(".slick-cloned h2").removeClass("anm-item slideright-item"),$(".slick-cloned .bordered").removeClass("anm-item slideright-item")}),$(".slider-top").on("afterChange",function(e,t,i){$(".slide-count .current").html(i+1)})},cofo.navigation_Fixed=function(){var e,t=$("header#masthead").outerHeight(),i,o,a,n=function(){o=".main-navigation",a=".main-navigation.fixed",$(window).width()<=1024&&(o=".mobile-nav",a=".mobile-nav.fixed")};
// Fix/unfix the nav on scroll
n(),$(window).on("resize",n),
// if(isSafari && $(window).width() > 1024) {	
// 	$(deviceNav).addClass('fixed transition reset');
// }
$(window).scroll(function(){i=$(this).scrollTop(),
// Fix nav
t<=i&&(
//Keep the header height consistent
$("header#masthead").css("height",t),
//Fix the nav
$(o).addClass("fixed"),$(o).removeClass("reset"),setTimeout(function(){$(o).addClass("transition")},400)),
// Unfix and return to OG position
i<t-68&&$(a).length&&$(o).addClass("reset")})},
//Open/close mobile menu
cofo.navigation_Mobile=function(){$(".hamburger").on("click",function(){$(".mobile-nav").toggleClass("opened")})},
//Initialize the Product Details container
cofo.productPage_DetailsContainer=function(){var e=$(".product-details-container"),i=$("#product-details button"),t=78,o=$("#product-details").outerHeight(),a=e.offset().top-t,n,s,l;
// Fix/unfix the container on scroll
600<$(window).width()&&$(window).scroll(function(){n=$(this).scrollTop(),s=$(".product-dimensions").offset().top,
//Fix product details
a<=n&&e.addClass("fixed"),
//Unfix and position product details
s<=n+o+t&&(e.removeClass("fixed"),e.css({position:"absolute",top:s-o})),
//Unfix and return to OG position
n<a&&(e.removeClass("fixed"),e.css({position:"relative",top:0}))}),$(".swatch-toggle").on("mouseup",function(){l=$(this).attr("for");
//Update the Product Details (i.e. Out of Stock, Add to cart, Notify Me, etc.)
var e="",t="Add to cart";$("#product-details button").attr("id","add-to-cart"),$(this).data("pre-order")&&(t="Pre-order"),$(this).data("inventory-management")&&(0===$(this).data("inventory-quantity")&&"deny"===$(this).data("inventory-policy")?(e="Out of Stock",t="Notify Me",$("#product-details button").attr("id","")):$(this).data("inventory-quantity")<5&&(e="Limited Quantity")),$(".inventory-message").text(e),i.text(t),
//Switch product images
$(".togglable").addClass("hidden").each(function(){$(this).data("id")===l&&$(this).removeClass("hidden")}),$(window).trigger("resize")})},cofo.productPage_Gallery=function(){
//Determine which image has been clicked and open the gallery
$(".product-explore img").on("click",function(){$(".image-gallery").fadeIn(100);var e=$(this).attr("class").split(" ")[0];
//Match images by class
$(".thumbnail-img").each(function(){$(this).hasClass(e)&&$(this).addClass("active").click()})}),$(".close").on("click",function(){$(".image-gallery").fadeOut(100)}),
// Keyboard events
$(document).on("keyup",function(e){switch(e.which){
//esc - close modal
case 27:e.preventDefault(),$(".close").trigger("click");break;
//left arrow - previous
case 37:e.preventDefault(),$(".btn-prev").trigger("click");break;
//right arrow - next
case 39:e.preventDefault(),$(".btn-next").trigger("click");break}}),
//When a thumbnail is clicked, empty the main container, add the coresponding img
$(".thumbnail-img").on("click",function(){$(".thumbnail-img").removeClass("active");var e=$(this).removeClass("thumbnail-img togglable").attr("class");$(this).addClass("active thumbnail-img togglable"),$(".main-img").addClass("hidden").each(function(){$(this).hasClass(e)&&$(this).removeClass("hidden")})}),
//Prev/next buttons
$(".btn-prev").on("click",function(){var e=$(".image-gallery .thumbnails .thumbnail-img").not(".hidden"),t=$(".image-gallery .thumbnails .thumbnail-img.active").removeClass("active");t.prev()&&t.prev().not(".hidden").length?t.prev().addClass("active"):e.last().addClass("active"),$(".image-gallery .thumbnails .thumbnail-img.active").click()}),$(".btn-next").on("click",function(){var e=$(".image-gallery .thumbnails .thumbnail-img").not(".hidden"),t=$(".image-gallery .thumbnails .thumbnail-img.active").removeClass("active");t.next()&&t.next().not(".hidden").length?t.next().addClass("active"):e.first().addClass("active"),$(".image-gallery .thumbnails .thumbnail-img.active").click()})},
//Initialize the Filter Menu on the Shop Page
cofo.shopPage_PositionFiltersMenu=function(){var e=$("#filters"),t=$("#listing"),i=e.outerHeight(),o=t.offset().top,a,n;
// Fix/unfix the container on scroll
600<$(window).width()&&$(window).scroll(function(){a=$(this).scrollTop(),n=$(".site-footer").offset().top,
//Fix product details
o<=a&&e.addClass("fixed").css({top:t.css("padding-top")}),
//Unfix and position product details
n<=a+i&&e.removeClass("fixed").css({position:"absolute",top:n-i}),
//Unfix and return to OG position
a<o&&e.removeClass("fixed").css({position:"absolute",top:"auto"})}),$("#filters button").on("click",function(){$(window).width()<769&&($("#filters .inner").toggle(),$("#filters .inner:visible").length?$("#filters button").html("&ndash; Filter"):$("#filters button").html("+ Filter"))})},cofo.shopPage_VariantSelectorEvents=function(){var e;($(".collection .item").length?$(".collection .item"):$(".category .item")).each(function(){var t=$(this).find(".item-image img"),i=$(this).find(".variant-attribute-options li img");i.on("mouseover",function(){var e=$(this);t.hide(),i.removeClass("active"),t.each(function(){$(this).data("alt")===e.data("alt")&&($(this).show(),e.addClass("active"))})}).on("mouseout",function(){$(i[0]).hasClass("active")&&t.each(function(){$(this).attr("style","")});
// $variants.removeClass('active');
// $($variants[0]).addClass('active');
})})},cofo.shopPage_ProductImageTouchEvent=function(){$(".item-image").on("touchend",function(){window.location.url=$(this).find("a").attr("href")})},
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
cofo.fluidVids=function(){for(var e=document.getElementsByTagName("iframe"),t=0;t<e.length;t++){var i=e[t],o=/www.youtube.com|player.vimeo.com/,a=i.src;if(-1!==a.search(o)){i.src="";var n=i.height/i.width*100;i.style.position="absolute",i.style.top="0",i.style.left="0",i.width="100%",i.height="100%",i.webkitallowfullscreen="true",i.mozallowfullscreen="true",i.allowfullscreen="true";var s=document.createElement("div"),l,r;if(s.className="video-wrap",s.style.width="100%",s.style.position="relative",s.style.paddingTop=n+"%",i.parentNode.insertBefore(s,i),s.appendChild(i),
// Added the following code to add wmode=transparent to the 
// end of youtube embeds to ensure they don't break 
// z-indexing.
-1!==a.indexOf("youtube")&&$(".modal").length&&(r="wmode=transparent&autoplay=1"),-1===a.indexOf("youtube")||$(".modal").length||(r="wmode=transparent"),
//Add ability for vimeo videos to autoplay
-1!==a.indexOf("vimeo")&&$(".modal").length&&(r="autoplay=1"),-1!==a.indexOf("?")){var c=a.split("?"),d=c[1],m;a=c[0]+"?"+r+"&"+d}else a=a+"?"+r;i.src=a}}};