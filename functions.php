<?php
/**
 * Slightly functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package slightly
 */

if ( ! function_exists( 'slightly_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function slightly_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Slightly, use a find and replace
	 * to change 'slightly' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'slightly', get_template_directory() . '/languages' );

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
		'menu-1' => esc_html__( 'Primary', 'slightly' ),
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
	add_theme_support( 'custom-background', apply_filters( 'slightly_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
    
    /**
     * Add theme support for custom logo in header
     */
    add_theme_support( 'custom-logo' );
  
    // Suport for wide alignment in Gutenberg
    add_theme_support( 'align-wide' );

    add_filter( 'query_loop_block_query_vars', function( $query, $block ) {
	    if ( empty($block->context['query']['taxQuery']['post_format'])) { 
		    $query['tax_query'] = array(
			    array(
				    'taxonomy' => 'post_format',
				    'operator' => 'NOT EXISTS',
			    ),
		    );
	    }
	    return $query;
    }, 10, 2);

}
endif;
add_action( 'after_setup_theme', 'slightly_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *:sp
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function slightly_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'slightly_content_width', 640 );
}
add_action( 'after_setup_theme', 'slightly_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function slightly_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'slightly' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'slightly' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'slightly_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function slightly_scripts() {
	wp_enqueue_style( 'slightly-flexboxgrid', get_template_directory_uri() . '/css/flexboxgrid.min.css' );
	wp_enqueue_style( 'slightly-style', get_stylesheet_uri() );

	wp_enqueue_script( 'slightly-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'slightly-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'slightly_scripts' );

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

/**
 * Remove the prefix from the category title if user has setting on.
 */
function slightly_prefix_category_title( $title ) {
    if ( is_category() ) {
      if( get_theme_mod( 'hide_category_prefix' ) == 1) {
        $title = single_cat_title( '', false );
      }
    }
    return $title;
}
add_filter( 'get_the_archive_title', 'slightly_prefix_category_title' );

function restrict_rest_builtin_endpoints_for_guests( $errors ) {
	if ( is_wp_error( $errors ) ) {
		return $errors;
	}
	if ( ! is_user_logged_in() ) {
		$restricted_endpoints = array(
			'/wp/v2/media',
			'/wp/v2/users',
		);

		$request_uri = $_SERVER['REQUEST_URI'];
		$prefix = '/' . rest_get_url_prefix();

		foreach ( $restricted_endpoints as $endpoint ) {
			if ( strpos( $request_uri, $prefix . $endpoint ) === 0 ) {
				return new WP_Error( 'rest_not_logged_in', 'You must be logged in to access this endpoint.', array( 'status' => 401 ) );
			}
		}
	}

	return $errors;
}

add_filter( 'rest_authentication_errors', 'restrict_rest_builtin_endpoints_for_guests' );

