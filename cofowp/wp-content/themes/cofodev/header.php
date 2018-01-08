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
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link href="https://fonts.googleapis.com/css?family=Montserrat:300,500,600,700" rel="stylesheet">
<script src="https://use.fontawesome.com/e5f296b829.js"></script>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'ndrscrs' ); ?></a>

	<header id="masthead" class="site-header dark" role="banner">
		<nav id="site-navigation" class="main-navigation" role="navigation">
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
		</nav><!-- #site-navigation -->
		<div class="mobile-nav">
			<div class="hamburger">
				<div class="patty"></div>
			</div>
			<div class="mobile-menu">
				<?php wp_nav_menu( array( 'menu' => 'Mobile Menu' ) ); ?>
			</div>
			<a class="logo" href="<?php get_home_url(); ?>">
				<img class="logo" src="/wp-content/themes/cofodev/assets/images/logo-white.svg" alt="">
			</a>
			<a class="nav-cart" href="/cart">Cart</a>
		</div>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
