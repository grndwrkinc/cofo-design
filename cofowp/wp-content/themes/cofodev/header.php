<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ndrscrs
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-112393713-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-112393713-1');
</script>

<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link href="https://fonts.googleapis.com/css?family=Montserrat:300,500,600,700" rel="stylesheet">
<script src="https://use.fontawesome.com/e5f296b829.js"></script>

<?php wp_head(); ?>
<!-- icons & favicons -->
<link rel="apple-touch-icon-precomposed" sizes="57x57" href="/wp-content/themes/cofodev/assets/images/icons/apple-touch-icon-57x57.png" />
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/wp-content/themes/cofodev/assets/images/icons/apple-touch-icon-114x114.png" />
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/wp-content/themes/cofodev/assets/images/icons/apple-touch-icon-72x72.png" />
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/wp-content/themes/cofodev/assets/images/icons/apple-touch-icon-144x144.png" />
<link rel="apple-touch-icon-precomposed" sizes="60x60" href="/wp-content/themes/cofodev/assets/images/icons/apple-touch-icon-60x60.png" />
<link rel="apple-touch-icon-precomposed" sizes="120x120" href="/wp-content/themes/cofodev/assets/images/icons/apple-touch-icon-120x120.png" />
<link rel="apple-touch-icon-precomposed" sizes="76x76" href="/wp-content/themes/cofodev/assets/images/icons/apple-touch-icon-76x76.png" />
<link rel="apple-touch-icon-precomposed" sizes="152x152" href="/wp-content/themes/cofodev/assets/images/icons/apple-touch-icon-152x152.png" />
<link rel="icon" type="image/png" href="/wp-content/themes/cofodev/assets/images/icons/favicon-196x196.png" sizes="196x196" />
<link rel="icon" type="image/png" href="/wp-content/themes/cofodev/assets/images/icons/favicon-96x96.png" sizes="96x96" />
<link rel="icon" type="image/png" href="/wp-content/themes/cofodev/assets/images/icons/favicon-32x32.png" sizes="32x32" />
<link rel="icon" type="image/png" href="/wp-content/themes/cofodev/assets/images/icons/favicon-16x16.png" sizes="16x16" />
<link rel="icon" type="image/png" href="/wp-content/themes/cofodev/assets/images/icons/favicon-128.png" sizes="128x128" />
<meta name="application-name" content="&nbsp;"/>
<meta name="msapplication-TileColor" content="#FFFFFF" />
<meta name="msapplication-TileImage" content="/wp-content/themes/cofodev/assets/images/icons/mstile-144x144.png" />
<meta name="msapplication-square70x70logo" content="/wp-content/themes/cofodev/assets/images/icons/mstile-70x70.png" />
<meta name="msapplication-square150x150logo" content="/wp-content/themes/cofodev/assets/images/icons/mstile-150x150.png" />
<meta name="msapplication-wide310x150logo" content="/wp-content/themes/cofodev/assets/images/icons/mstile-310x150.png" />
<meta name="msapplication-square310x310logo" content="/wp-content/themes/cofodev/assets/images/icons/mstile-310x310.png" />

</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'ndrscrs' ); ?></a>

	<header id="masthead" class="site-header dark" role="banner">
			<nav id="site-navigation" class="main-navigation" role="navigation">
				<div class="inner">
					<a class="logo" href="/"><img src="/wp-content/themes/cofodev/assets/images/logo-white.svg" alt="Home"></a>
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
				<div>
			</nav><!-- #site-navigation -->

			<div class="mobile-nav">
				<div class="hamburger">
					<div class="patty"></div>
				</div>
				<div class="mobile-menu">
					<?php wp_nav_menu( array( 'menu' => 'Mobile Menu' ) ); ?>
				</div>
				<a class="logo" href="/">
					<img class="logo" src="/wp-content/themes/cofodev/assets/images/logo-white.svg" alt="">
				</a>
				<a class="nav-cart" href="/cart">Cart</a>
			</div>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
