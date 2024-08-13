<?php
/**
 * Color Magazine manage the Customizer options of general panel.
 *
 * @package Color_Magazine
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'customize_register', 'color_magazine_customize_general_panels_sections_register' );

/**
 * Add panels in the theme customizer
 * 
 */
function color_magazine_customize_general_panels_sections_register( $wp_customize ) {

/*-------------------------------------- General: Site Layout ----------------------------------------------------*/
	/**
	 * Site Layout Section
	 */
	$wp_customize->add_section( 'color_magazine_section_site',
		array(
			'priority'       => 10,
			'panel'          => 'color_magazine_general_panel',
			'capability'     => 'edit_theme_options',
			'title'          => __( 'Site Layout', 'color-magazine' )
		)
	);

	/**
	 * Radio image field for site layout
	 *
	 * @since 1.0.0
	 */
	$wp_customize->add_setting( 'color_magazine_site_layout',
		array(
			'capability'     	=> 'edit_theme_options',
			'default'           => 'site-layout--wide',
			'sanitize_callback' => 'sanitize_key',
		)
	);
	$wp_customize->add_control( new Color_Magazine_Control_Radio_Image(
		$wp_customize, 'color_magazine_site_layout',
			array(
				'label'         => __( 'Site Layout', 'color-magazine' ),
				'description'   => __( 'Choose site layout from available layouts', 'color-magazine' ),
				'section'       => 'color_magazine_section_site',
				'settings'      => 'color_magazine_site_layout',
				'priority'      => 5,
				'choices'  		=> array(
					'site-layout--wide'   => get_template_directory_uri() . '/assets/images/full-width.png',
					'site-layout--boxed'  => get_template_directory_uri() . '/assets/images/boxed-layout.png'
				),
				'input_attrs'	=> array(
                    'column'	=> 3,
                ),
			)
		)
	);

	/**
     * Range field for main container width
     */
    $wp_customize->add_setting( 'color_magazine_main_container_width',
        array(
            'capability'        => 'edit_theme_options',
            'default'           => 1300,
            'sanitize_callback' => 'absint'
        )
    );
    $wp_customize->add_control( new Color_Magazine_Control_Range(
        $wp_customize, 'color_magazine_main_container_width',
            array(
                'priority'          => 10,
                'section'           => 'color_magazine_section_site',
                'settings'          => 'color_magazine_main_container_width',
                'label'             => __( 'Main Container Width (px)', 'color-magazine' ),
                'input_attrs'       => array(
                    'min'   => 0,
                    'max'   => 2000,
                    'step'  => 1,
                ),
                'active_callback'   => 'color_magazine_hasnt_boxed_layout_callback',
            )
        )
    );

    /**
     * Range field for boxed container width
     */
    $wp_customize->add_setting( 'color_magazine_boxed_container_width',
        array(
            'capability'        => 'edit_theme_options',
            'default'           => 1200,
            'sanitize_callback' => 'absint'
        )
    );
    $wp_customize->add_control( new Color_Magazine_Control_Range(
        $wp_customize, 'color_magazine_boxed_container_width',
            array(
                'priority'          => 15,
                'section'           => 'color_magazine_section_site',
                'settings'          => 'color_magazine_boxed_container_width',
                'label'             => __( 'Boxed Container Width (px)', 'color-magazine' ),
                'input_attrs'       => array(
                    'min'   => 0,
                    'max'   => 2000,
                    'step'  => 1,
                ),
                'active_callback'   => 'color_magazine_has_boxed_layout_callback',
            )
        )
    );

    /**
     * Range field for main content width
     */
    $wp_customize->add_setting( 'color_magazine_main_content_width',
        array(
            'capability'        => 'edit_theme_options',
            'default'           => 70,
            'sanitize_callback' => 'absint'
        )
    );
    $wp_customize->add_control( new Color_Magazine_Control_Range(
        $wp_customize, 'color_magazine_main_content_width',
            array(
                'priority'          => 20,
                'section'           => 'color_magazine_section_site',
                'settings'          => 'color_magazine_main_content_width',
                'label'             => __( 'Main Content Width (%)', 'color-magazine' ),
                'input_attrs'       => array(
                    'min'   => 0,
                    'max'   => 100,
                    'step'  => 1,
                )
            )
        )
    );

    /**
     * Range field for Sidebar width
     */
    $wp_customize->add_setting( 'color_magazine_sidebar_width',
        array(
            'capability'        => 'edit_theme_options',
            'default'           => 27,
            'sanitize_callback' => 'absint'
        )
    );
    $wp_customize->add_control( new Color_Magazine_Control_Range(
        $wp_customize, 'color_magazine_sidebar_width',
            array(
                'priority'          => 25,
                'section'           => 'color_magazine_section_site',
                'settings'          => 'color_magazine_sidebar_width',
                'label'             => __( 'Sidebar Width (%)', 'color-magazine' ),
                'input_attrs'       => array(
                    'min'   => 0,
                    'max'   => 100,
                    'step'  => 1,
                )
            )
        )
    );
		
	/**
	 * Toggle field for Enable/Disable dark mode. 
	 *  
	 */
	$wp_customize->add_setting( 'color_magazine_enable_dark_mode',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => false,
			'sanitize_callback' => 'color_magazine_sanitize_checkbox'
		)
	);
	$wp_customize->add_control( new Color_Magazine_Control_Toggle(
		$wp_customize, 'color_magazine_enable_dark_mode',
			array(
				'label'         => __( 'Enable Dark Mode', 'color-magazine' ),
				'section'       => 'color_magazine_section_site',
				'settings'      => 'color_magazine_enable_dark_mode',
				'priority'      => 30,
			)
		)
	);

/*-------------------------------------- General: Preloader ------------------------------------------------------*/
	/**
	 * Preloader Section
	 */
	$wp_customize->add_section( 'color_magazine_section_preloader',
		array(
			'capability'     => 'edit_theme_options',
			'priority'       => 20,
			'panel'          => 'color_magazine_general_panel',
			'title'          => __( 'Preloader', 'color-magazine' )

		)
	);

	/**
	 * Toggle field for Enable/Disable preloader.
	 *  
	 */ 
	$wp_customize->add_setting( 'color_magazine_enable_preloader',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => true,
			'sanitize_callback' => 'color_magazine_sanitize_checkbox'
		)
	);
	$wp_customize->add_control( new Color_Magazine_Control_Toggle(
		$wp_customize, 'color_magazine_enable_preloader',
			array(
				'label'         => __( 'Enable Preloader', 'color-magazine' ),
				'section'       => 'color_magazine_section_preloader',
				'settings'      => 'color_magazine_enable_preloader',
				'priority'      => 5,
			)
		)
	);

    /**
	 * Radio image field for preloader styles
	 *
	 * @since 1.0.0
	 */
	$wp_customize->add_setting( 'color_magazine_preloader_style',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => 'wave',
			'sanitize_callback' => 'sanitize_key',
		)
	);
	$wp_customize->add_control( new Color_Magazine_Control_Radio_Image(
		$wp_customize, 'color_magazine_preloader_style',
			array(
				'label'         	=> __( 'Preloader Style', 'color-magazine' ),
				'description'   	=> __( 'Choose site layout from available layouts', 'color-magazine' ),
				'section'       	=> 'color_magazine_section_preloader',
				'settings'      	=> 'color_magazine_preloader_style',
				'priority'      	=> 10,
				'choices'  			=> array(
					'three_bounce'   	=> get_template_directory_uri() . '/assets/images/three-bounce-preloader.gif',
					'wave'   			=> get_template_directory_uri() . '/assets/images/wave-preloader.gif',
					'folding_cube'   	=> get_template_directory_uri() . '/assets/images/folding-cube-preloader.gif',
				),
				'input_attrs'		=> array(
                    'column'	=> 4,
                ),
                'active_callback'	=> 'color_magazine_has_enable_preloader_callback'
			)
		)
	);

    /**
	 * Upgrade field
	 *  
	 */ 
	$wp_customize->add_setting( 'color_magazine_upgrade_preloader',
		array(
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control( new Color_Magazine_Control_Upgrade(
		$wp_customize, 'color_magazine_upgrade_preloader',
			array(
				'label'         => __( 'More Features', 'color-magazine' ),
				'description'   => __( 'Upgrade to pro for 15+ preloader styles.', 'color-magazine' ),
				'section'       => 'color_magazine_section_preloader',
				'settings'      => 'color_magazine_upgrade_preloader',
				'url'			=> esc_url( 'https://mysterythemes.com/pricing/?product_id=11920' ),
				'priority'      => 50,
			)
		)
	);

/*-------------------------------------- General: Social Icons ---------------------------------------------------*/
	/**
	 * Social Icons
	 */
	$wp_customize->add_section( 'color_magazine_section_social_icons',
		array(
			'title'    			=> __( 'Social Icons', 'color-magazine' ),
			'panel'          	=> 'color_magazine_general_panel',
			'capability'     	=> 'edit_theme_options',
			'priority'       	=> 25,
		)
	);

	/**
	 * Repeater field for social icons
	 */
	$wp_customize->add_setting(
		'color_magazine_social_icons', 
		array(
			'capability'       => 'edit_theme_options',
			'default'          => json_encode( array(
					array(
						'social_icon' => 'bx bxl-twitter',
						'social_url'  => '#',
					),
					array(
						'social_icon' => 'bx bxl-pinterest',
						'social_url'  => '#',
					)
				)
			),
			'sanitize_callback' => 'wp_kses_post'
		)
	);
	$wp_customize->add_control( new Color_Magazine_Control_Repeater(
		$wp_customize, 
			'color_magazine_social_icons',
			array(
				'label'           => __( 'Social Media', 'color-magazine' ),
				'section'         => 'color_magazine_section_social_icons',
				'settings'        => 'color_magazine_social_icons',
				'priority'        => 5,
				'color_magazine_box_label_text'       => __( 'Social Media Icons','color-magazine' ),
				'color_magazine_box_add_control_text' => __( 'Add Icon','color-magazine' )
			),
			array(
				'social_icon' 	=> array(
					'type'	  		=> 'social_icon',	
					'label'   		=> __( 'Social Icon', 'color-magazine' ),
					'description' 	=> __( 'Choose social media icon.', 'color-magazine' )
				),
				'social_url'  	=> array(
					'type'    		=> 'url',
					'label'   		=> __( 'Social Link URL', 'color-magazine' ),
					'description' 	=> __( 'Enter social media url.', 'color-magazine' )
				),
			)
		) 
	);

	/**
	 * Upgrade field
	 *  
	 */ 
	$wp_customize->add_setting( 'color_magazine_upgrade_social_icons',
		array(
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control( new Color_Magazine_Control_Upgrade(
		$wp_customize, 'color_magazine_upgrade_social_icons',
			array(
				'label'         => __( 'More Features', 'color-magazine' ),
				'description'   => __( 'Upgrade to pro for social icon advanced settings.', 'color-magazine' ),
				'section'       => 'color_magazine_section_social_icons',
				'settings'      => 'color_magazine_upgrade_social_icons',
				'url'			=> esc_url( 'https://mysterythemes.com/pricing/?product_id=11920' ),
				'priority'      => 50,
			)
		)
	);

/*-------------------------------------- General: Categories Color -----------------------------------------------*/
	/**
	 * Categories Color
	 */
	$wp_customize->add_section( 'color_magazine_categories_color_section',
		array(
			'title'    			=> __( 'Categories Color', 'color-magazine' ),
			'panel'          	=> 'color_magazine_general_panel',
			'capability'     	=> 'edit_theme_options',
			'priority'       	=> 35,
		)
	);

	/**
	 * Setting for categories color 
	 *  
	 */
	$priority = 5;
	$categories = get_categories( array( 'hide_empty' => 1 ) );

	foreach ( $categories as $category_list ) {
		$wp_customize->add_setting( 'color_magazine_category_color_'.esc_attr( $category_list->slug ),
			array(
				'capability'        => 'edit_theme_options',
				'default'           => '#3b2d1b',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'color_magazine_category_color_'.esc_attr( $category_list->slug ),
				array(
					'label'      => esc_attr( $category_list->name ).' Color',
					'section'    => 'color_magazine_categories_color_section',
					'settings'   => 'color_magazine_category_color_'.esc_attr( $category_list->slug ),
					'priority'   => absint( $priority )
				)
			)
		);
		$priority += 5;
	}

/*-------------------------------------- General: Scroll Top -----------------------------------------------------*/
	/**
	 * Scroll Top Section
	 */

	$wp_customize->add_section( 'color_magazine_section_scroll_top',
		array(
			'priority'       => 45,
			'panel'          => 'color_magazine_general_panel',
			'capability'     => 'edit_theme_options',
			'title'          => __( 'Scroll Top', 'color-magazine' )
		)
	);

	/**
	 * Toggle field for Enable/Disable scroll top icon.
	 *  
	 */ 
	$wp_customize->add_setting( 'color_magazine_enable_scroll_top',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => true,
			'sanitize_callback' => 'color_magazine_sanitize_checkbox'
		)
	);
	$wp_customize->add_control( new Color_Magazine_Control_Toggle(
		$wp_customize, 'color_magazine_enable_scroll_top',
			array(
				'label'         => __( 'Enable Scroll Top', 'color-magazine' ),
				'section'       => 'color_magazine_section_scroll_top',
				'settings'      => 'color_magazine_enable_scroll_top',
				'priority'      => 5,
			)
		)
	);

	/**
	 * Text field for Scroll Top Label
	 */
	$wp_customize->add_setting( 'color_magazine_scroll_top_label',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => __( 'Back To Top', 'color-magazine' ),
			'transport'			=> 'postMessage',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control( 'color_magazine_scroll_top_label',
		array(
			'type'				=> 'text',
			'label'    			=> __( 'Scroll Top Label', 'color-magazine' ),
			'section'       	=> 'color_magazine_section_scroll_top',
			'settings'			=> 'color_magazine_scroll_top_label',
			'priority'      	=> 15,
			'active_callback' 	=> 'color_magazine_has_enable_scroll_top_callback',
		)
	);
	$wp_customize->selective_refresh->add_partial( 'color_magazine_scroll_top_label',
        array(
            'selector'        => '#mt-scrollup',
            'render_callback' => 'color_magazine_customize_partial_scroll_top_label',
        )
    );

    /**
	 * Upgrade field
	 *  
	 */ 
	$wp_customize->add_setting( 'color_magazine_upgrade_scroll_top',
		array(
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);
	$wp_customize->add_control( new Color_Magazine_Control_Upgrade(
		$wp_customize, 'color_magazine_upgrade_scroll_top',
			array(
				'label'         => __( 'More Features', 'color-magazine' ),
				'description'   => __( 'Upgrade to pro for scroll top advanced settings.', 'color-magazine' ),
				'section'       => 'color_magazine_section_scroll_top',
				'settings'      => 'color_magazine_upgrade_scroll_top',
				'url'			=> esc_url( 'https://mysterythemes.com/pricing/?product_id=11920' ),
				'priority'      => 50,
			)
		)
	);

/*-------------------------------------- General: Sidebar Layout -------------------------------------------------*/
	/**
	 * Sidebar Layout Section
	 */

	$wp_customize->add_section( 'color_magazine_section_sidebar_layout',
		array(
			'priority'       => 50,
			'panel'          => 'color_magazine_general_panel',
			'capability'     => 'edit_theme_options',
			'title'          => __( 'Sidebar Layout', 'color-magazine' )
		)
	);

	/**
	 * Radio Image field for archive/blog sidebar layout.
	 */
	$wp_customize->add_setting( 'color_magazine_archive_sidebar_layout',
		array(
			'capability'     	=> 'edit_theme_options',
			'default'           => 'no-sidebar',
			'sanitize_callback' => 'sanitize_key',
		)
	);
	$wp_customize->add_control( new Color_Magazine_Control_Radio_Image(
		$wp_customize, 'color_magazine_archive_sidebar_layout',
			array(
				'label'    		=> esc_html__( 'Archive/Blog Sidebar Layout', 'color-magazine' ),
				'section'       => 'color_magazine_section_sidebar_layout',
				'settings'      => 'color_magazine_archive_sidebar_layout',
				'priority'      => 10,
				'choices'  		=> array(
					'left-sidebar'  	 => get_template_directory_uri() . '/assets/images/left-sidebar.png',
					'right-sidebar' 	 => get_template_directory_uri() . '/assets/images/right-sidebar.png',
					'no-sidebar'         => get_template_directory_uri() . '/assets/images/no-sidebar.png',
					'no-sidebar-center'  => get_template_directory_uri() . '/assets/images/no-sidebar-center.png'
				),
				'input_attrs'	=> array(
                    'column'	=> 3,
                ),
			)
		)
	);

	/**
	 * Radio Image field for single posts sidebar layout.
	 */
	$wp_customize->add_setting( 'color_magazine_posts_sidebar_layout',
		array(
			'capability'     	=> 'edit_theme_options',
			'default'           => 'right-sidebar',
			'sanitize_callback' => 'sanitize_key',
		)
	);
	$wp_customize->add_control( new Color_Magazine_Control_Radio_Image(
		$wp_customize, 'color_magazine_posts_sidebar_layout',
			array(
				'label'    		=> __( 'Posts Sidebar Layout', 'color-magazine' ),
				'section'       => 'color_magazine_section_sidebar_layout',
				'settings'      => 'color_magazine_posts_sidebar_layout',
				'priority'      => 15,
				'choices'  		=> array(
					'left-sidebar'  	 => get_template_directory_uri() . '/assets/images/left-sidebar.png',
					'right-sidebar' 	 => get_template_directory_uri() . '/assets/images/right-sidebar.png',
					'no-sidebar'         => get_template_directory_uri() . '/assets/images/no-sidebar.png',
					'no-sidebar-center'  => get_template_directory_uri() . '/assets/images/no-sidebar-center.png'
				),
				'input_attrs'	=> array(
                    'column'	=> 3,
                ),
			)
		)
	);

	/*
	* Radio Image field for single page sidebar layout.
	*/
	$wp_customize->add_setting( 'color_magazine_pages_sidebar_layout',
		array(
			'capability'     	=> 'edit_theme_options',
			'default'           => 'right-sidebar',
			'sanitize_callback' => 'sanitize_key',
		)
	);
	$wp_customize->add_control( new Color_Magazine_Control_Radio_Image(
		$wp_customize, 'color_magazine_pages_sidebar_layout',
			array(
				'label'    		=> __( 'Pages Sidebar Layout', 'color-magazine' ),
				'section'       => 'color_magazine_section_sidebar_layout',
				'settings'      => 'color_magazine_pages_sidebar_layout',
				'priority'      => 20,
				'choices'  		=> array(
					'left-sidebar'  	 => get_template_directory_uri() . '/assets/images/left-sidebar.png',
					'right-sidebar' 	 => get_template_directory_uri() . '/assets/images/right-sidebar.png',
					'no-sidebar'         => get_template_directory_uri() . '/assets/images/no-sidebar.png',
					'no-sidebar-center'  => get_template_directory_uri() . '/assets/images/no-sidebar-center.png'
				),
				'input_attrs'	=> array(
                    'column'	=> 3,
                ),
			)
		)
	);

/*-------------------------------------- General: Color ----------------------------------------------------------*/
	
	/**
     * Color Picker field for Primary Color
     */
    $wp_customize->add_setting( 'color_magazine_primary_color',
        array(
            'capability'        => 'edit_theme_options',
            'default'           => '#0065C1',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control( new WP_Customize_Color_Control(
        $wp_customize, 'color_magazine_primary_color',
            array(
                'label'      => __( 'Primary Color', 'color-magazine' ),
                'section'    => 'colors',
                'settings'   => 'color_magazine_primary_color',
                'priority'   => 5
            )
        )
    );
}