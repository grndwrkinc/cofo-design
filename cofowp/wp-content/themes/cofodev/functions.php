<?php
/**
 * ndrscrs functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ndrscrs
 */

if ( ! function_exists( 'ndrscrs_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function ndrscrs_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on ndrscrs, use a find and replace
	 * to change 'ndrscrs' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'ndrscrs', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'ndrscrs' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'ndrscrs_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'ndrscrs_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ndrscrs_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'ndrscrs_content_width', 640 );
}
add_action( 'after_setup_theme', 'ndrscrs_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ndrscrs_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'ndrscrs' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'ndrscrs' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'ndrscrs_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function ndrscrs_scripts() {
	//Screen stylesheet
	wp_enqueue_style( 'ndrscrs-style', '//' . $_SERVER['HTTP_HOST'] . '/wp-content/themes/cofodev/assets/css/style.css', array(), '1.1' );

	//Print stylesheet
	wp_enqueue_style( 'ndrscrs-print-style', '//' . $_SERVER['HTTP_HOST'] . '/wp-content/themes/cofodev/assets/css/print.css', null, null, 'print' );

	wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css');

	//Deregister Wordpress baked-in JQuery and load from CDN
	wp_deregister_script('jquery');
   	wp_register_script('jquery', "//cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js", false, null);
   	wp_enqueue_script('jquery');

	wp_enqueue_script( 'ndrscrs-navigation', '//' . $_SERVER['HTTP_HOST'] . '/wp-content/themes/cofodev/assets/js/navigation.js', array(), '20151215', true  );

	//Scrollmagic required JS
	wp_register_script('greenSock', '//' . $_SERVER['HTTP_HOST'] . '/wp-content/themes/cofodev/assets/js/greensock/TweenMax.min.js', array(), '1.14.1', false);
	wp_enqueue_script('ScrollMagic', "//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/ScrollMagic.min.js", false, null);
	wp_enqueue_script('ScrollMagicDebug', "//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/plugins/debug.addIndicators.min.js", false, null);

	wp_enqueue_script( 'fluidvids', '//' . $_SERVER['HTTP_HOST'] . '/wp-content/themes/cofodev/assets/js/fluidvids/dist/fluidvids.min.js', array(), '2.4.1', true);

	wp_enqueue_script( '_s-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	//Theme scripts
	wp_enqueue_script( 'shopify-scripts', '//' . $_SERVER['HTTP_HOST'] . '/wp-content/themes/cofodev/assets/js/shopify/dist/shopify.js', array(), '2.4.1', true);
	wp_enqueue_script( 'cofo-scripts', '//' . $_SERVER['HTTP_HOST'] . '/wp-content/themes/cofodev/assets/js/scripts-min.js', array(), '2.4.1', true);
}
add_action( 'wp_enqueue_scripts', 'ndrscrs_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

//Page Slug Body Class
function add_slug_body_class( $classes ) {
	global $post;
	if ( isset( $post ) ) {
		$classes[] = $post->post_type . '-' . $post->post_name;
	} return $classes; }
add_filter( 'body_class', 'add_slug_body_class' );

/* Allow SVG file upload */
function cc_mime_types( $mimes ){
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );

