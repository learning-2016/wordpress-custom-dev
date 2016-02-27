<?php
/**
 * ABARIS functions and definitions
 *
 * @package ABARIS
 * @subpackage abaris
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 870; /* pixels */
}

if ( ! function_exists( 'abaris_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function abaris_setup() {

	// Makes theme translation ready
	load_theme_textdomain( 'abaris', ABARIS_LANGUAGES_DIR );
	
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 250, 200, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'abaris' ),
	) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'abaris_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for Semantic Markup
	$markup = array( 'search-form', 'comment-form', 'comment-list', );
	add_theme_support( 'html5', $markup );

	// Add theme support for title tag
	add_theme_support( 'title-tag' );

	add_editor_style( 'css/editor-style.css' );
}
endif; // abaris_setup
add_action( 'after_setup_theme', 'abaris_setup' );

/**
 * Register widgetized area and update sidebar with default widgets.
 */
function abaris_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'abaris' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title"><i class="el el-tags"></i>',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'abaris' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title"><i class="el el-tags"></i>',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 1', 'abaris' ),
		'id'            => 'footer-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 2', 'abaris' ),
		'id'            => 'footer-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 3', 'abaris' ),
		'id'            => 'footer-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 4', 'abaris' ),
		'id'            => 'footer-4',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'abaris_widgets_init' );

/**
 * Defining constants to use through out theme code
 */
	require_once get_template_directory() . '/includes/constants.php';

/**
 * Enqueue Scripts and Styles
 */
	require_once ABARIS_INCLUDES_DIR . '/enqueue.php';

/**
 * Implement the Custom Header feature.
 */
require ABARIS_INCLUDES_DIR . '/custom-header.php';


// Enable support for Post Formats.
add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );
	
/**
 * Custom functions for this theme.
 */
require ABARIS_INCLUDES_DIR . '/theme-functions.php';

/**
 * Custom template tags for this theme.
 */
require ABARIS_INCLUDES_DIR . '/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require ABARIS_INCLUDES_DIR . '/extras.php';

/**
 * Load Theme Options Page
 * This uses Redux Framework Plugin
 */
require_once( ABARIS_INCLUDES_DIR . '/load-plugins.php' );
require_once( ABARIS_INCLUDES_DIR . '/home-info.php' );

if( class_exists('ReduxFrameworkPlugin')) {
	require_once( ABARIS_INCLUDES_DIR . '/theme-options-config.php' );
}

/* JigoShop Support */
require_once( ABARIS_INCLUDES_DIR . '/jigoshop.php' );

// Hooks and Filters
require_once ( ABARIS_INCLUDES_DIR . '/hooks-filters.php' );