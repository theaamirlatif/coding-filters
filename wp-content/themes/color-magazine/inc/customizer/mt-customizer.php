<?php
/**
 * Color Magazine Theme Customizer
 *
 * @package Color_Magazine
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function color_magazine_customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	$wp_customize->get_section( 'title_tagline' )->panel        = 'color_magazine_general_panel';
    $wp_customize->get_section( 'title_tagline' )->priority     = '5';

    $wp_customize->get_section( 'header_image' )->panel        = 'color_magazine_header_panel';
    $wp_customize->get_section( 'header_image' )->priority     = '5';

    $wp_customize->get_section( 'colors' )->panel        = 'color_magazine_general_panel';
    $wp_customize->get_section( 'colors' )->priority     = '55';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'color_magazine_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'color_magazine_customize_partial_blogdescription',
		) );
	}

	/**
	 * Load customizer custom classes.
	 */
	$wp_customize->register_control_type( 'Color_Magazine_Control_Toggle' );
    $wp_customize->register_control_type( 'Color_Magazine_Control_Range' );
	$wp_customize->register_control_type( 'Color_Magazine_Control_Radio_Image' );
    $wp_customize->register_control_type( 'Color_Magazine_Control_Upgrade' );

    /**
     * Register custom section types.
     *
     * @since 1.0.0
     */
    $wp_customize->register_section_type( 'color_magazine_Section_Upsell' );

    /**
     * Register theme upsell sections.
     *
     * @since 1.0.0
     */
    $wp_customize->add_section( new Color_Magazine_Section_Upsell(
        $wp_customize,
            'theme_upsell',
            array(
                'title'     => __( 'Color Magazine Pro', 'color-magazine' ),
                'pro_text'  => __( 'Buy Now', 'color-magazine' ),
                'pro_url'   => 'https://mysterythemes.com/wp-themes/color-magazine-pro/',
                'priority'  => 1,
            )
        )
    );

}
add_action( 'customize_register', 'color_magazine_customize_register' );

/*------------------------------------- selective refresh --------------------------------------------------------*/

    /**
     * Render the site title for the selective refresh partial.
     *
     * @return void
     */
    function color_magazine_customize_partial_blogname() {
    	bloginfo( 'name' );
    }

    /**
     * Render the site tagline for the selective refresh partial.
     *
     * @return void
     */
    function color_magazine_customize_partial_blogdescription() {
    	bloginfo( 'description' );
    }

    /**
     * Render the site tagline for the selective refresh partial.
     *
     * @return void
     */
    function color_magazine_customize_partial_ticker_label() {
        return get_theme_mod( 'color_magazine_ticker_label' );
    }

    /**
     * Render the site tagline for the selective refresh partial.
     *
     * @return void
     */
    function color_magazine_customize_partial_trending_label() {
        return get_theme_mod( 'color_magazine_trending_label' );
    }

    /**
     * Render the site tagline for the selective refresh partial.
     *
     * @return void
     */
    function color_magazine_customize_partial_scroll_top_label() {
        return get_theme_mod( 'color_magazine_scroll_top_label' );
    }

    /**
     * Render the site tagline for the selective refresh partial.
     *
     * @return void
     */
    function color_magazine_customize_partial_featured_posts_title() {
        return get_theme_mod( 'color_magazine_top_featured_posts_title' );
    }

    /**
     * Render the site tagline for the selective refresh partial.
     *
     * @return void
     */
    function color_magazine_customize_partial_archive_read_more() {
        return get_theme_mod( 'color_magazine_archive_read_more' );
    }

/*------------------------------------- enqueue customizer scripts ------------------------------------------------*/
    
    if ( ! function_exists( 'color_magazine_customize_backend_scripts' ) ) :

        /**
         * Enqueue required scripts/styles for customizer panel
         *
         * @since 1.0.0
         */
        function color_magazine_customize_backend_scripts() {
            global $color_magazine_theme_version;

            wp_enqueue_style( 'color-magazine--admin-customizer-style', get_template_directory_uri() . '/assets/css/min/mt-customizer-styles.min.css', array(), esc_attr( esc_attr( $color_magazine_theme_version ) ) );
            wp_enqueue_style( 'jquery-ui', esc_url( get_template_directory_uri() . '/assets/css/jquery-ui.css' ) );
            wp_enqueue_style( 'box-icons', get_template_directory_uri() . '/assets/library/box-icons/css/boxicons.min.css', array(), '2.1.4' );
            wp_enqueue_script( 'color-magazine--admin-customizer-script', get_template_directory_uri() . '/assets/js/min/mt-customizer-controls.min.js', array( 'jquery', 'customize-controls' ), esc_attr( $color_magazine_theme_version ), true );
        }

    endif;

    add_action( 'customize_controls_enqueue_scripts', 'color_magazine_customize_backend_scripts', 10 );

    /**
     * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
     */
    function color_magazine_customize_preview_js() {
        wp_enqueue_script( 'color-magazine-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
    }
    add_action( 'customize_preview_init', 'color_magazine_customize_preview_js' );

/**
 * Add Kirki required file for custom fields
 */
require get_template_directory() . '/inc/customizer/mt-customizer-custom-classes.php';
require get_template_directory() . '/inc/customizer/mt-customizer-panels.php';
require get_template_directory() . '/inc/customizer/mt-sanitize.php';
require get_template_directory() . '/inc/customizer/mt-callback.php';

require get_template_directory() . '/inc/customizer/mt-customizer-general-panel-options.php';
require get_template_directory() . '/inc/customizer/mt-customizer-header-panel-options.php';
require get_template_directory() . '/inc/customizer/mt-customizer-front-panel-options.php';
require get_template_directory() . '/inc/customizer/mt-customizer-blog-panel-options.php';
require get_template_directory() . '/inc/customizer/mt-customizer-footer-panel-options.php';