<?php
/**
 * Color Magazine manage the Customizer panels
 *
 * @package Color_Magazine
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'customize_register', 'color_magazine_customize_panels_register' );

/**
 * Add panels in the theme customizer
 * 
 */
function color_magazine_customize_panels_register( $wp_customize ) {
	/**
	 * General Settings Panel
	 */
	$wp_customize->add_panel( 'color_magazine_general_panel',
		array(
			'priority'          => 5,
			'capability'        => 'edit_theme_options',
			'title'             => __( 'General Settings', 'color-magazine' ),
		)
	);

	/**
	 * Header Settings Panel
	 */
	$wp_customize->add_panel( 'color_magazine_header_panel',
		array(
			'priority'          => 10,
			'capability'        => 'edit_theme_options',
			'title'             => __( 'Header Settings', 'color-magazine' ),
		)
	);

	/**
	 * Front Settings Panel
	 */
	$wp_customize->add_panel( 'color_magazine_front_section_panel',
		array(
			'priority'          => 15,
			'capability'        => 'edit_theme_options',
			'title'             => __( 'Frontpage Slider Sections', 'color-magazine' ),
		)
	);

	/**
	 * Design Settings Panel
	 */
	$wp_customize->add_panel( 'color_magazine_blog_panel',
		array(
			'priority'          => 20,
			'capability'        => 'edit_theme_options',
			'title'             => __( 'Blog Settings', 'color-magazine' ),
		)
	);

	/**
	 * Footer Settings Panel
	 */
	$wp_customize->add_panel( 'color_magazine_footer_panel',
		array(
			'priority'          => 25,
			'capability'        => 'edit_theme_options',
			'title'             => __( 'Footer Settings', 'color-magazine' ),
		)
	);
}