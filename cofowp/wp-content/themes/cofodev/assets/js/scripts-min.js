var cofo={};$(document).ready(function(){cofo.init()}),cofo.init=function(){cofo.animate_PageElements(),cofo.animate_Hero(),cofo.navigation_Fixed(),cofo.navigation_Mobile(),$(".home").length&&cofo.homePage_Slider(),$(".single-product").length&&(cofo.productPage_DetailsContainer(),$(window).width()>600&&cofo.productPage_Gallery()),$(".page-about").length&&cofo.fluidVids(),($(".page-design-challenge").length||$(".page-about").length)&&cofo.designChallengePage_Masonry(),$(".page-shop").length&&(cofo.shopPage_FiltersMenu(),cofo.shopPage_VariantSelectors(),cofo.shopPage_TouchEvent()),$(".blog").length&&(cofo.blogIndexPage_PositionContent(),$(window).on("resize",cofo.blogIndexPage_PositionContent),$.fn.almComplete=function(){setTimeout(cofo.animate_PageElements,100)}),$(".social-share").click(function(e){return e.preventDefault(),window.open($(this).attr("href"),"fbShareWindow","height=450, width=550, top="+($(window).height()/2-275)+", left="+($(window).width()/2-225)+", toolbar=0, location=0, menubar=0, directories=0, scrollbars=0"),!1})},cofo.animate_Hero=function(){var e=$(".hero-text").children(),t=300;e.each(function(){var e=this;setTimeout(function(){$(e).addClass("animate-me")},t),t+=200})},cofo.animate_One=function(e){var t=$(window).scrollTop()+$(window).height();e.each(function(){var e=this,i="";i=$(window).width()<=600?20:200,$(e).is($("#product-details"))&&(i=0);var o=$(e).offset().top+i;t>o&&$(e).addClass("animate-me")})},cofo.animate_PageElements=function(){var e=$(".fadein"),t=$(".slideright"),i=$(".slideleft"),o=$(".slideup"),a=$(".slideupright"),n=$(".slidedownright"),s=$(".slideupleft"),l=$(".anm-container");cofo.animate_One(e),cofo.animate_One(o),cofo.animate_One(t),cofo.animate_One(i),cofo.animate_One(a),cofo.animate_One(n),cofo.animate_One(s),cofo.animate_Set(l),$(window).scroll(function(){cofo.animate_One(e),cofo.animate_One(o),cofo.animate_One(t),cofo.animate_One(i),cofo.animate_One(a),cofo.animate_One(n),cofo.animate_One(s),cofo.animate_Set(l)})},cofo.animate_Set=function(e){var t=$(window).scrollTop()+$(window).height();e.each(function(){var e=this,i="";i=$(window).width()<=600?20:200;var o=$(e).offset().top+i;if(t>o){var a=$(e).find(".anm-item"),n=300;a.each(function(){var e=this;setTimeout(function(){$(e).addClass("animate-me")},n),n+=150})}})},cofo.blogIndexPage_PositionContent=function(){if($(window).width()>768){var e=$("#main .large-container .post-image").height(),t=$("#main .large-container").outerHeight()-$("#main .large-container").height(),i=$("#main .large-container .post-summary").offset().top+parseInt($("#main .large-container .post-summary").css("margin-top"))+$("#main .large-container .post-summary").outerHeight(),o=$("#main .large-container .post-image").offset().top+$("#main .large-container .post-image").height(),a=0;i>o&&(a=i-o),$("#main .large-container .post-summary").css({transform:"translateY(calc(-"+e+"px + 5%))",display:"block"}),$("#main .large-container").css("height",e+t+a+"px")}else $("#main .large-container .post-summary").css({transform:"none",display:"block"}),$("#main .large-container").attr("style","")},cofo.designChallengePage_Masonry=function(){var e=$(".masonry-gallery");e.imagesLoaded(function(){e.masonry({gutter:".gutter-sizer",columnWidth:".grid-sizer",itemSelector:".grid-item",transitionDuration:0,percentPosition:!0,stamp:".stamp"})}),setTimeout(function(){e.masonry("layout")},1e3)},cofo.homePage_Slider=function(){$(".slider-top").slick({asNavFor:".slider-bottom",prevArrow:".btn-prev",nextArrow:".btn-next",appendArrows:".slider",draggable:!1,autoplay:!0,autoplaySpeed:7e3,fade:!0,speed:1100}),$(".slider-bottom").slick({asNavFor:".slider-top",prevArrow:".btn-prev",nextArrow:".btn-next",draggable:!1,speed:1300}).init(function(){$(".slick-cloned .home-slider-content").removeClass("anm-container"),$(".slick-cloned h2").removeClass("anm-item slideright-item"),$(".slick-cloned .bordered").removeClass("anm-item slideright-item")}),$(".slider-top").on("afterChange",function(e,t,i){$(".slide-count .current").html(i+1)})},cofo.navigation_Fixed=function(){var e=$("header#masthead"),t=e.outerHeight(),i,o,a,n=function(){o=".main-navigation",a=".main-navigation.fixed",$(window).width()<=1024&&(o=".mobile-nav",a=".mobile-nav.fixed")};n(),$(window).on("resize",n),$(window).scroll(function(){i=$(this).scrollTop(),i>=t&&($("header#masthead").css("height",t),$(o).addClass("fixed"),$(o).removeClass("reset"),setTimeout(function(){$(o).addClass("transition")},400)),i<t-68&&$(a).length&&$(o).addClass("reset"),0===i&&setTimeout(function(){$("header#masthead").css("height","auto"),$(o).removeClass("fixed transition reset")},400)})},cofo.navigation_Mobile=function(){$(".hamburger").on("click",function(){$(".mobile-nav").toggleClass("opened")})},cofo.productPage_DetailsContainer=function(){var e=$(".product-details-container"),t=223,i=$("#product-details").outerHeight(),o=e.offset().top-t,a,n,s;$(window).width()>600&&$(window).scroll(function(){a=$(this).scrollTop(),n=$(".product-dimensions").offset().top,a>=o&&e.addClass("fixed"),a+i+t>=n&&(e.removeClass("fixed"),e.css({position:"absolute",top:n-i})),a<o&&(e.removeClass("fixed"),e.css({position:"relative",top:0}))}),$(".swatch-toggle").on("mouseup",function(){s=$(this).attr("for"),$(".togglable").addClass("hidden").each(function(){$(this).data("id")===s&&$(this).removeClass("hidden")}),$(window).trigger("resize")})},cofo.productPage_Gallery=function(){$(".product-explore img").on("click",function(){$(".image-gallery").fadeIn(100);var e=$(this).attr("class").split(" ")[0];$(".thumbnail-img").each(function(){$(this).hasClass(e)&&$(this).addClass("active").click()})}),$(".close").on("click",function(){$(".image-gallery").fadeOut(100)}),$(document).on("keyup",function(e){switch(e.which){case 27:e.preventDefault(),$(".close").trigger("click");break;case 37:e.preventDefault(),$(".btn-prev").trigger("click");break;case 39:e.preventDefault(),$(".btn-next").trigger("click")}}),$(".thumbnail-img").on("click",function(){$(".thumbnail-img").removeClass("active");var e=$(this).removeClass("thumbnail-img togglable").attr("class");$(this).addClass("active thumbnail-img togglable"),$(".main-img").addClass("hidden").each(function(){$(this).hasClass(e)&&$(this).removeClass("hidden")})}),$(".btn-prev").on("click",function(){var e=$(".image-gallery .thumbnails .thumbnail-img").not(".hidden"),t=$(".image-gallery .thumbnails .thumbnail-img.active").removeClass("active");t.prev()&&t.prev().not(".hidden").length?t.prev().addClass("active"):e.last().addClass("active"),$(".image-gallery .thumbnails .thumbnail-img.active").click()}),$(".btn-next").on("click",function(){var e=$(".image-gallery .thumbnails .thumbnail-img").not(".hidden"),t=$(".image-gallery .thumbnails .thumbnail-img.active").removeClass("active");t.next()&&t.next().not(".hidden").length?t.next().addClass("active"):e.first().addClass("active"),$(".image-gallery .thumbnails .thumbnail-img.active").click()})},cofo.shopPage_FiltersMenu=function(){var e=$("#filters"),t=$("#listing"),i=e.outerHeight(),o=t.offset().top,a,n;$(window).width()>600&&$(window).scroll(function(){a=$(this).scrollTop(),n=$(".site-footer").offset().top,a>=o&&e.addClass("fixed").css({top:t.css("padding-top")}),a+i>=n&&e.removeClass("fixed").css({position:"absolute",top:n-i}),a<o&&e.removeClass("fixed").css({position:"absolute",top:"auto"})}),$("#filters button").on("click",function(){$(window).width()<769&&($("#filters .inner").toggle(),$("#filters .inner:visible").length?$("#filters button").html("&ndash; Collections"):$("#filters button").html("+ Collections"))})},cofo.shopPage_VariantSelectors=function(){var e=$(".collection .item").length?$(".collection .item"):$(".category .item");e.each(function(){var e=$(this).find(".item-image img"),t=$(this).find(".variant-attribute-options li img");t.on("mouseover",function(){var i=$(this);e.hide(),t.removeClass("active"),e.each(function(){$(this).data("alt")===i.data("alt")&&($(this).show(),i.addClass("active"))})}).on("mouseout",function(){$(t[0]).hasClass("active")&&e.each(function(){$(this).attr("style","")})})})},cofo.shopPage_TouchEvent=function(){$(".item-image").on("touchend",function(){window.location.url=$(this).find("a").attr("href")})},cofo.fluidVids=function(){for(var e=document.getElementsByTagName("iframe"),t=0;t<e.length;t++){var i=e[t],o=/www.youtube.com|player.vimeo.com/,a=i.src;if(a.search(o)!==-1){i.src="";var n=i.height/i.width*100;i.style.position="absolute",i.style.top="0",i.style.left="0",i.width="100%",i.height="100%",i.webkitallowfullscreen="true",i.mozallowfullscreen="true",i.allowfullscreen="true";var s=document.createElement("div");s.className="video-wrap",s.style.width="100%",s.style.position="relative",s.style.paddingTop=n+"%";var l=i.parentNode;l.insertBefore(s,i),s.appendChild(i);var r;if(a.indexOf("youtube")!==-1&&$(".modal").length&&(r="wmode=transparent&autoplay=1"),a.indexOf("youtube")===-1||$(".modal").length||(r="wmode=transparent"),a.indexOf("vimeo")!==-1&&$(".modal").length&&(r="autoplay=1"),a.indexOf("?")!==-1){var c=a.split("?"),d=c[1],m=c[0];a=m+"?"+r+"&"+d}else a=a+"?"+r;i.src=a}}};