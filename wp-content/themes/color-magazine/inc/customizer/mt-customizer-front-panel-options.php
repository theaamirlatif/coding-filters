<?php
/**
 * Customizer fields for  front slider section
 *
 * @package Color_Magazine
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'customize_register', 'color_magazine_customize_slider_panels_sections_register' );

/**
 * Add panels in the theme customizer
 * 
 */
function color_magazine_customize_slider_panels_sections_register( $wp_customize ) {

/*------------------------------------- Frontpage: Slider Content ------------------------------------------------ */
	/**
	 * Slider Content
	 */
	$wp_customize->add_section( 'color_magazine_section_slider',
		array(
			'priority'       => 10,
			'panel'          => 'color_magazine_front_section_panel',
			'capability'     => 'edit_theme_options',
			'title'          => __( 'Slider Content', 'color-magazine' )
		)
	);

	/**
	 * Toggle field for slider option
	 * 
	 */
	$wp_customize->add_setting( 'color_magazine_section_slider_option',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => false,
			'sanitize_callback' => 'color_magazine_sanitize_checkbox'
		)
	);
	$wp_customize->add_control( new Color_Magazine_Control_Toggle(
		$wp_customize, 'color_magazine_section_slider_option',
			array(
				'label'         => __( 'Enable Slider Section', 'color-magazine' ),
				'section'       => 'color_magazine_section_slider',
				'settings'      => 'color_magazine_section_slider_option',
				'priority'      => 5,
			)
		)
	);

	/**
	 * Select field for slider cat select
	 * 
	 */
	$wp_customize->add_setting( 'color_magazine_section_slider_cat',
		array(
			'capability' 		=> 'edit_theme_options',
			'default' 			=> '',
			'sanitize_callback' => 'color_magazine_sanitize_select',
		)
	);
	$wp_customize->add_control( 'color_magazine_section_slider_cat',
		array(
			'type'     			=> 'select',
			'label'    			=> __( 'Slider category', 'color-magazine' ),
			'description' 		=> __( 'Choose default post category', 'color-magazine' ),
			'section'  			=> 'color_magazine_section_slider',
			'settings'			=> 'color_magazine_section_slider_cat',
			'priority' 			=> 30,
			'choices'  			=> color_magazine_select_categories_list(),
			'active_callback' 	=> 'color_magazine_has_enable_slider_callback',
		)
	);

	/**
	 * Upgrade field
	 *  
	 */ 
	$wp_customize->add_setting( 'color_magazine_upgrade_slider_content',
		array(
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control( new Color_Magazine_Control_Upgrade(
		$wp_customize, 'color_magazine_upgrade_slider_content',
			array(
				'label'         => __( 'More Features', 'color-magazine' ),
				'description'   => __( 'Upgrade to pro for extra features about slider content.', 'color-magazine' ),
				'section'       => 'color_magazine_section_slider',
				'settings'      => 'color_magazine_upgrade_slider_content',
				'url'			=> esc_url( 'https://mysterythemes.com/pricing/?product_id=11920' ),
				'priority'      => 50,
			)
		)
	);

/*------------------------------------- Frontpage: Featured Posts Content ---------------------------------------- */
	/**
	 * Featured Posts
	 */
	$wp_customize->add_section( 'color_magazine_section_top_featured_post',
		array(
			'priority'       	=> 20,
			'panel'          	=> 'color_magazine_front_section_panel',
			'capability'     	=> 'edit_theme_options',
			'title'    			=> __( 'Featured Posts Content', 'color-magazine' )
		)
	);

	/**
	 * Toggle field for featured posts option
	 * 
	 */
	$wp_customize->add_setting( 'color_magazine_section_top_featured_posts_option',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => false,
			'sanitize_callback' => 'color_magazine_sanitize_checkbox'
		)
	);
	$wp_customize->add_control( new Color_Magazine_Control_Toggle(
		$wp_customize, 'color_magazine_section_top_featured_posts_option',
			array(
				'label'    		=> __( 'Enable Featured Posts Section', 'color-magazine' ),
				'description' 	=> 'This section is displayed after the slider content at the right side minimizing the slider width.',
				'section'       => 'color_magazine_section_top_featured_post',
				'settings'      => 'color_magazine_section_top_featured_posts_option',
				'priority'      => 5,
			)
		)
	);

	/**
	 * Text field for Featured Posts Title 
	 */
	$wp_customize->add_setting( 'color_magazine_top_featured_posts_title',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => __( 'Featured News', 'color-magazine' ),
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control( 'color_magazine_top_featured_posts_title',
		array(
			'type'				=> 'text',
			'label'    			=> __( 'Featured News', 'color-magazine' ),
			'section'       	=> 'color_magazine_section_top_featured_post',
			'settings'			=> 'color_magazine_top_featured_posts_title',
			'priority'      	=> 10,
			'active_callback' 	=> 'color_magazine_section_top_featured_posts_option_active_callback',
		)
	);
	$wp_customize->selective_refresh->add_partial( 'color_magazine_top_featured_posts_title',
        array(
            'selector'        => 'div.features-post-title',
            'render_callback' => 'color_magazine_customize_partial_featured_posts_title',
        )
    );

	/**
	 * Select field for featured posts type.
	 */
	$wp_customize->add_setting( 'color_magazine_top_featured_post_order',
		array(
			'capability' 		=> 'edit_theme_options',
			'default' 			=> 'default',
			'sanitize_callback' => 'color_magazine_sanitize_select',
		)
	);
	$wp_customize->add_control( 'color_magazine_top_featured_post_order',
		array(
			'type'     			=> 'select',
			'label'    			=> __( 'Featured Post Order', 'color-magazine' ),
			'section'  			=> 'color_magazine_section_top_featured_post',
			'settings'			=> 'color_magazine_top_featured_post_order',
			'priority' 			=> 15,
			'choices'  			=> array(
				'default'   => __( 'Latest Posts', 'color-magazine' ),
	            'random'    => __( 'Random Posts', 'color-magazine' ),
			),
			'active_callback' 	=> 'color_magazine_section_top_featured_posts_option_active_callback',
		)
	);

	/**
	 * Upgrade field
	 *  
	 */ 
	$wp_customize->add_setting( 'color_magazine_upgrade_featured_posts_content',
		array(
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control( new Color_Magazine_Control_Upgrade(
		$wp_customize, 'color_magazine_upgrade_featured_posts_content',
			array(
				'label'         => __( 'More Features', 'color-magazine' ),
				'description'   => __( 'Upgrade to pro for featured posts content advance settings.', 'color-magazine' ),
				'section'       => 'color_magazine_section_top_featured_post',
				'settings'      => 'color_magazine_upgrade_featured_posts_content',
				'url'			=> esc_url( 'https://mysterythemes.com/pricing/?product_id=11920' ),
				'priority'      => 50,
			)
		)
	);

}