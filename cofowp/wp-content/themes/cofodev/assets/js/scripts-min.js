var cofo={};$(document).ready(function(){cofo.init()}),cofo.init=function(){cofo.animatePageElements(),cofo.animateHero(),cofo.fixNav(),$(".single-product").length&&(cofo.initProductDetails(),$(window).width()>600&&cofo.initProductGallery()),$(".page-about").length&&cofo.fluidVids(),($(".page-design-challenge").length||$(".page-about").length)&&cofo.initMasonry(),cofo.mobileNav(),$(".social-share").click(function(e){return e.preventDefault(),window.open($(this).attr("href"),"fbShareWindow","height=450, width=550, top="+($(window).height()/2-275)+", left="+($(window).width()/2-225)+", toolbar=0, location=0, menubar=0, directories=0, scrollbars=0"),!1})},cofo.initProductDetails=function(){var e=$(".product-details-container"),t=223,i=$("#product-details").outerHeight(),a=e.offset().top-t,o,n,l;$(window).width()>600&&$(window).scroll(function(){o=$(this).scrollTop(),n=$(".product-dimensions").offset().top,o>=a&&e.addClass("fixed"),o+i+t>=n&&(e.removeClass("fixed"),e.css({position:"absolute",top:n-i})),o<a&&(e.removeClass("fixed"),e.css({position:"relative",top:0}))}),$(".swatch-toggle").on("mouseup",function(){l=$(this).attr("for"),$(".togglable").addClass("hidden").each(function(){$(this).data("id")===l&&$(this).removeClass("hidden")}),$(window).trigger("resize")})},cofo.initProductGallery=function(){$(".product-explore img").on("click",function(){$(".image-gallery").fadeIn(100);var e=$(this).attr("class").split(" ")[0];$(".thumbnail-img").each(function(){$(this).hasClass(e)&&$(this).addClass("active").click()})}),$(".close").on("click",function(){$(".image-gallery").fadeOut(100)}),$(document).on("keyup",function(e){switch(e.which){case 27:e.preventDefault(),$(".close").trigger("click");break;case 37:e.preventDefault(),$(".btn-prev").trigger("click");break;case 39:e.preventDefault(),$(".btn-next").trigger("click")}}),$(".thumbnail-img").on("click",function(){$(".thumbnail-img").removeClass("active");var e=$(this).removeClass("thumbnail-img togglable").attr("class");$(this).addClass("active thumbnail-img togglable"),$(".main-img").addClass("hidden").each(function(){$(this).hasClass(e)&&$(this).removeClass("hidden")})}),$(".btn-prev").on("click",function(){var e=$(".image-gallery .thumbnails .thumbnail-img").not(".hidden"),t=$(".image-gallery .thumbnails .thumbnail-img.active").removeClass("active");t.prev()&&t.prev().not(".hidden").length?t.prev().addClass("active"):e.last().addClass("active"),$(".image-gallery .thumbnails .thumbnail-img.active").click()}),$(".btn-next").on("click",function(){var e=$(".image-gallery .thumbnails .thumbnail-img").not(".hidden"),t=$(".image-gallery .thumbnails .thumbnail-img.active").removeClass("active");t.next()&&t.next().not(".hidden").length?t.next().addClass("active"):e.first().addClass("active"),$(".image-gallery .thumbnails .thumbnail-img.active").click()})},cofo.initMasonry=function(){var e=$(".masonry-gallery");e.imagesLoaded(function(){e.masonry({gutter:".gutter-sizer",columnWidth:".grid-sizer",itemSelector:".grid-item",transitionDuration:0,percentPosition:!0,stamp:".stamp"})}),setTimeout(function(){e.masonry("layout")},1e3)},cofo.fixNav=function(){var e=$("header"),t=e.outerHeight(),i,a,o;$(window).width()>1024?(a=".main-navigation",o=".main-navigation.fixed"):(a=".mobile-nav",o=".mobile-nav.fixed"),$(window).scroll(function(){i=$(this).scrollTop(),i>=t&&($(a).addClass("fixed"),$(a).removeClass("reset"),setTimeout(function(){$(a).addClass("transition")},400)),i<t-68&&$(o).length&&$(a).addClass("reset"),0===i&&setTimeout(function(){$(a).removeClass("fixed transition reset")},400)})},cofo.animateHero=function(){var e=$(".hero-text").children(),t=300;e.each(function(){var e=this;setTimeout(function(){$(e).addClass("animate-me")},t),t+=200})},cofo.animatePageElements=function(){var e=$(".fadein"),t=$(".slideright"),i=$(".slideleft"),a=$(".slideup"),o=$(".slideupright"),n=$(".slidedownright"),l=$(".slideupleft"),s=$(".anm-container");cofo.animateOne(e),cofo.animateOne(a),cofo.animateOne(t),cofo.animateOne(i),cofo.animateOne(o),cofo.animateOne(n),cofo.animateOne(l),cofo.animateSet(s),$(window).scroll(function(){cofo.animateOne(e),cofo.animateOne(a),cofo.animateOne(t),cofo.animateOne(i),cofo.animateOne(o),cofo.animateOne(n),cofo.animateOne(l),cofo.animateSet(s)})},cofo.animateOne=function(e){var t=$(window).scrollTop()+$(window).height();e.each(function(){var e=this,i="";i=$(window).width()<=600?20:200,$(e).is($("#product-details"))&&(i=0);var a=$(e).offset().top+i;t>a&&$(e).addClass("animate-me")})},cofo.animateSet=function(e){var t=$(window).scrollTop()+$(window).height();e.each(function(){var e=this,i="";i=$(window).width()<=600?20:200;var a=$(e).offset().top+i;if(t>a){var o=$(e).find(".anm-item"),n=300;o.each(function(){var e=this;setTimeout(function(){$(e).addClass("animate-me")},n),n+=150})}})},cofo.mobileNav=function(){$(".hamburger").on("click",function(){$(".mobile-nav").toggleClass("opened")})},cofo.fluidVids=function(){for(var e=document.getElementsByTagName("iframe"),t=0;t<e.length;t++){var i=e[t],a=/www.youtube.com|player.vimeo.com/,o=i.src;if(o.search(a)!==-1){i.src="";var n=i.height/i.width*100;i.style.position="absolute",i.style.top="0",i.style.left="0",i.width="100%",i.height="100%",i.webkitallowfullscreen="true",i.mozallowfullscreen="true",i.allowfullscreen="true";var l=document.createElement("div");l.className="video-wrap",l.style.width="100%",l.style.position="relative",l.style.paddingTop=n+"%";var s=i.parentNode;s.insertBefore(l,i),l.appendChild(i);var c;if(o.indexOf("youtube")!==-1&&$(".modal").length&&(c="wmode=transparent&autoplay=1"),o.indexOf("youtube")===-1||$(".modal").length||(c="wmode=transparent"),o.indexOf("vimeo")!==-1&&$(".modal").length&&(c="autoplay=1"),o.indexOf("?")!==-1){var r=o.split("?"),d=r[1],m=r[0];o=m+"?"+c+"&"+d}else o=o+"?"+c;i.src=o}}};