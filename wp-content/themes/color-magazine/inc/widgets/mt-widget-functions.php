<?php
/**
 * custom function and work related to widgets.
 *
 * @package Color_Magazine
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function color_magazine_widgets_init() {
	/**
	 * Register default sidebar
	 *
	 * @since 1.0.0
	 */
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'color-magazine' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here.', 'color-magazine' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	/**
	 * Register Header Ads Section
	 *
	 * @since 1.0.0
	 */
	register_sidebar( array(
		'name'          => __( 'Header Ads Section', 'color-magazine' ),
		'id'            => 'header-ads-section',
		'description'   => __( 'Add MT: Ads Banner widgets here.', 'color-magazine' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	/**
	 * Register 4 different footer area 
	 *
	 * @since 1.0.0
	 */

	register_sidebars( 4 , array(
		'name'          => __( 'Footer %d', 'color-magazine' ),
		'id'            => 'footer-sidebar',
		'description'   => __( 'Added widgets are display at Footer Widget Area.', 'color-magazine' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	// Author Info
	register_widget( 'Color_Magazine_Author_Info' );

	// Latest Posts
	register_widget( 'Color_Magazine_Latest_Posts' );

	//Social Media
	register_widget( 'Color_Magazine_Social_Media' );
}

add_action( 'widgets_init', 'color_magazine_widgets_init' );

/*-----------------------------------------------------------------------------------------------------------------------*/
/**
 * Load widget required files
 *
 * @since 1.0.0
 */
require get_template_directory() . '/inc/widgets/mt-widget-fields.php';   // Widget fields
require get_template_directory() . '/inc/widgets/mt-author-info.php';     // Author Info
require get_template_directory() . '/inc/widgets/mt-latest-posts.php';    // Latest Posts
require get_template_directory() . '/inc/widgets/mt-social-media.php';    // Social Media