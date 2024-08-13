<?php
/**
 * Color Magazine functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Color_Magazine
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! defined( 'COLOR_MAGAZINE_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	$color_magazine_theme_info = wp_get_theme();
	define( 'COLOR_MAGAZINE_VERSION', $color_magazine_theme_info->get( 'Version' ) );
}

if ( ! function_exists( 'color_magazine_setup' ) ) :

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, whic
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function color_magazine_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Color Magazine, use a find and replace
		 * to change 'color-magazine' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'color-magazine', get_template_directory() . '/languages' );

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

		set_post_thumbnail_size( 768, 432, true );
		add_image_size( 'color-magazine-full-width', 1160, 653, true );
		add_image_size( 'color-magazine-post', 600, 400, true );
		add_image_size( 'color-magazine-post-auto', 600, 9999, false );
		add_image_size( 'color-magazine-slider-post', 1200, 700, true );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'top_header_menu' 	=> esc_html__( 'Top Header', 'color-magazine' ),
			'primary_menu' 		=> esc_html__( 'Primary', 'color-magazine' ),
			'footer_menu'  		=> esc_html__( 'Footer', 'color-magazine' ),
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
		add_theme_support( 'custom-background', apply_filters( 'color_magazine_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );

		/**
		 * Registers an editor stylesheet for the theme.
		 */
		add_editor_style( 'assets/css/mt-editor-style.css' );
	}

endif;

add_action( 'after_setup_theme', 'color_magazine_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function color_magazine_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'color_magazine_content_width', 640 );
}
add_action( 'after_setup_theme', 'color_magazine_content_width', 0 );

if ( ! function_exists ( 'color_magazine_theme_version_info' ) ) :

	/**
	 * Set the theme version, based on theme stylesheet.
	 *
	 * @global string $color_magazine_theme_version
	 */
	function color_magazine_theme_version_info() {
		$color_magazine_theme_info = wp_get_theme();
		$GLOBALS['color_magazine_theme_version'] = $color_magazine_theme_info->get( 'Version' );
	}

endif;
add_action( 'after_setup_theme', 'color_magazine_theme_version_info', 0 );

if ( ! function_exists ( 'color_magazine_prefix_nav_description' ) ) :
	
	/**
	 * Function for displaying menu item description
	 * 
	 */
	function color_magazine_prefix_nav_description( $item_output, $item, $depth, $menu_args ) {
	    if ( !empty( $item->description ) ) {
	    	$item_output = str_replace( $menu_args->link_after . '</a>', '<span class="menu-item-description">' . $item->description . '</span>' . $menu_args->link_after . '</a>', $item_output );
		} 
	    return $item_output;
	}

endif;
add_filter( 'walker_nav_menu_start_el', 'color_magazine_prefix_nav_description', 10, 4 );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Load dynamic styles file
 */
require get_template_directory() . '/inc/mt-dynamic-styles.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/mt-customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load custom hook file
 */
require get_template_directory() . '/inc/mt-custom-hooks.php';

/**
 * Load widget functions file
 */
require get_template_directory() . '/inc/widgets/mt-widget-functions.php';

/**
 * Load metaboxes
 */
require get_template_directory() . '/inc/metaboxes/mt-post-sidebar-meta.php';

/**
 * Load breadcrumbs class
 */
if ( ! function_exists( 'breadcrumb_trail' ) ) {
	require get_template_directory() . '/inc/mt-class-breadcrumbs.php';
}

/**
* Load theme dashboard
*/
require get_template_directory() . '/inc/admin/class-color-magazine-admin.php';
require get_template_directory() . '/inc/admin/class-color-magazine-notice.php';
require get_template_directory() . '/inc/admin/class-color-magazine-dashboard.php';