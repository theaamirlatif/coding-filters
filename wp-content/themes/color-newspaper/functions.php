<?php
/**
 * Color Magazine functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Color_Magazine
 * @subpackage color_newspaper
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/*-------------------------------------------------------------------------------------------------------------------------------*/
/**
 * Set the theme version, based on theme stylesheet.
 *
 * @global string color_newspaper_version
 */
function color_newspaper_theme_version_info() {
    $color_newspaper_theme_info = wp_get_theme();
    $GLOBALS['color_newspaper_version'] = $color_newspaper_theme_info->get( 'Version' );
}

add_action( 'after_setup_theme', 'color_newspaper_theme_version_info' );

//google fonts
function color_newspaper_fonts_url(){
    $fonts_url = '';

    $color_newspaper_archivo = _x( 'on', 'Archivo: on or off', 'color-newspaper' );


    if ( 'off' !== $color_newspaper_archivo ) {

        $font_families = array();

        if ( 'off' !== $color_newspaper_archivo ) {
                $font_families[] = 'Archivo:400,400i,,500,600,700';
        }

        $query_args = array(
            'family' => rawurlencode( implode( '|', $font_families ) ),
            'subset' => rawurlencode( 'latin,latin-ext' ),
        );

        $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
    }

    return esc_url_raw( $fonts_url );

}


/**
 * Managed the theme default color
 */
function color_newspaper_customize_register( $wp_customize ) {
    global $wp_customize;

    $wp_customize->get_setting( 'color_magazine_primary_color' )->default = '#1B5E20';

    /**
     * color picker field for top header background color.
     */ 
    $wp_customize->add_setting( 'color_newspaper_top_header_bg_color',
        array(
            'capability'        => 'edit_theme_options',
            'default'           => '#1B5E20',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );
    $wp_customize->add_control( new WP_Customize_Color_Control(
        $wp_customize, 'color_newspaper_top_header_bg_color',
            array(
                'label'             => __( 'Background Color', 'color-newspaper' ),
                'section'           => 'color_magazine_section_top_header',
                'settings'          => 'color_newspaper_top_header_bg_color',
                'priority'          => 15,
                'active_callback'   => 'color_newspaper_has_enable_top_header_callback'
            )
        )
    );

    /**
     * Toggle option for sidebar sticky
     */
    $wp_customize->add_setting( 'color_newspaper_sidebar_sticky_enable',
        array(
            'default'           => false,
            'sanitize_callback' => 'color_magazine_sanitize_checkbox'
        )
    );
    $wp_customize->add_control( new Color_Magazine_Control_Toggle(
        $wp_customize, 'color_newspaper_sidebar_sticky_enable',
            array(
                'priority'      => 5,
                'section'       => 'color_magazine_section_sidebar_layout',
                'settings'      => 'color_newspaper_sidebar_sticky_enable',
                'label'         => __( 'Enable Sidebar Sticky', 'color-newspaper' )
            )
        )
    );

}

add_action( 'customize_register', 'color_newspaper_customize_register', 20 );

if ( ! function_exists( 'color_newspaper_has_enable_top_header_callback' ) ):

    /**
     * Check if top header option is enabled.
     *
     * @since 1.0.0
     *
     * @param WP_Customize_Control $control WP_Customize_Control instance.
     *
     * @return bool Whether the control is active to the current preview.
     */
    function color_newspaper_has_enable_top_header_callback( $control ) {
        if ( false !== $control->manager->get_setting( 'color_magazine_enable_top_header' )->value() ) {
            return true;
        } else {
            return false;
        }
    }
    
endif;


/*------------------------------------------------------------------------------------------------*/
/**
 * Enqueue scripts and styles.
 */

add_action( 'wp_enqueue_scripts', 'color_newspaper_scripts', 99 );

function color_newspaper_scripts() {

    global $color_newspaper_version;

    //google fonts
    wp_enqueue_style( 'color-newspaper-fonts', color_newspaper_fonts_url(), array(), null );

    wp_dequeue_style( 'color-magazine-style' );

    wp_dequeue_style( 'color-magazine-responsive-style' );

    wp_enqueue_style( 'color-newspaper-parent-style', get_template_directory_uri() . '/style.css', array(), esc_attr( $color_newspaper_version ) );

    wp_enqueue_style( 'color-newspaper-parent-responsive-style', get_template_directory_uri() . '/assets/css/mt-responsive.css', array(), esc_attr( $color_newspaper_version ) );

    wp_enqueue_style( 'color-newspaper-style', get_stylesheet_uri(), array(), esc_attr( $color_newspaper_version ) );

    wp_enqueue_script( 'theia-sticky-sidebar', get_stylesheet_directory_uri() . '/assets/library/sticky-sidebar/theia-sticky-sidebar.min.js', array( 'jquery' ), '1.7.0', true );

    wp_register_script( 'color-newspaper-custom-script', get_stylesheet_directory_uri().'/assets/js/custom-scripts.js', array( 'jquery' ), esc_attr( $color_newspaper_version ), true );

    $sidebar_sticky_enable = get_theme_mod( 'color_newspaper_sidebar_sticky_enable', false );
    if ( true === $sidebar_sticky_enable ) {
        $sidebar_sticky_value = 'on';
    } else {
        $sidebar_sticky_value = 'off';
    }

    wp_localize_script( 'color-newspaper-custom-script', 'color_newspaperObject ', array(
        'inner_sticky'  => $sidebar_sticky_value
    ) );

    wp_enqueue_script( 'color-newspaper-custom-script' );

    $color_newspaper_primary_color = get_theme_mod( 'color_magazine_primary_color', '#1A5E20' );

    $color_newspaper_primary_dark_color = color_magazine_hover_color( $color_newspaper_primary_color, '-50' );
    
    $color_newspaper_top_header_bg_color = get_theme_mod( 'color_newspaper_top_header_bg_color', '#B71C1C' );

    $custom_css = '';

    $custom_css .= "a,a:hover,a:focus,a:active,.entry-cat .cat-links a:hover,.entry-cat a:hover,.byline a:hover,.posted-on a:hover,.entry-footer a:hover,.comment-author .fn .url:hover,.commentmetadata .comment-edit-link,#cancel-comment-reply-link,#cancel-comment-reply-link:before,.logged-in-as a,.widget a:hover,.widget a:hover::before,.widget li:hover::before,#top-navigation ul li a:hover,.mt-social-icon-wrap li a:hover,.mt-search-icon:hover,.mt-form-close a:hover,.menu-toggle:hover,#site-navigation ul li:hover>a,#site-navigation ul li.current-menu-item>a,#site-navigation ul li.current_page_ancestor>a,#site-navigation ul li.current-menu-ancestor>a,#site-navigation ul li.current_page_item>a,#site-navigation ul li.focus>a,.entry-title a:hover,.cat-links a:hover,.entry-meta a:hover,.entry-footer .mt-readmore-btn:hover,.btn-wrapper a:hover,.mt-readmore-btn:hover,.navigation.pagination .nav-links .page-numbers.current,.navigation.pagination .nav-links a.page-numbers:hover,.breadcrumbs a:hover,#footer-menu li a:hover,#top-footer a:hover,.color_magazine_latest_posts .mt-post-title a:hover,#mt-scrollup:hover,.mt-site-mode-wrap .mt-mode-toggle:hover,.mt-site-mode-wrap .mt-mode-toggle:checked:hover,.has-thumbnail .post-info-wrap .entry-title a:hover,.front-slider-block .post-info-wrap .entry-title a:hover{ color: ". esc_attr( $color_newspaper_primary_color ) ."}\n";
    
    $custom_css .= ".widget_search .search-submit,.widget_search .search-submit:hover,.widget_tag_cloud .tagcloud a:hover,.widget.widget_tag_cloud a:hover,.navigation.pagination .nav-links .page-numbers.current,.navigation.pagination .nav-links a.page-numbers:hover,.error-404.not-found,.color-magazine_social_media a:hover{ border-color: ". esc_attr( $color_newspaper_primary_color ) ."}\n";
    
    $custom_css .= ".edit-link .post-edit-link,.reply .comment-reply-link,.widget_search .search-submit,.widget_search .search-submit:hover,.widget_tag_cloud .tagcloud a:hover,.widget.widget_tag_cloud a:hover,#top-header,.mt-menu-search .mt-form-wrap .search-form .search-submit,.mt-menu-search .mt-form-wrap .search-form .search-submit:hover,#site-navigation .menu-item-description,.mt-ticker-label,.post-cats-list a,.front-slider-block .lSAction>a:hover,.top-featured-post-wrap .post-thumbnail .post-number,article.sticky::before,#secondary .widget .widget-title::before,.mt-related-post-title:before,#colophon .widget .widget-title:before,.features-post-title:before,.cvmm-block-title.layout--default:before,.color-magazine_social_media a:hover{ background: ". esc_attr( $color_newspaper_primary_color ) ."}\n";
    
    $custom_css .= ".mt-site-dark-mode .widget_archive a:hover,.mt-site-dark-mode .widget_categories a:hover,.mt-site-dark-mode .widget_recent_entries a:hover,.mt-site-dark-mode .widget_meta a,.mt-site-dark-mode .widget_recent_comments li:hover,.mt-site-dark-mode .widget_rss li,.mt-site-dark-mode .widget_pages li a:hover,.mt-site-dark-mode .widget_nav_menu li a:hover,.mt-site-dark-mode .wp-block-latest-posts li a:hover,.mt-site-dark-mode .wp-block-archives li a:hover,.mt-site-dark-mode .wp-block-categories li a:hover,.mt-site-dark-mode .wp-block-page-list li a:hover,.mt-site-dark-mode .wp-block-latest-comments li:hover,.mt-site-dark-mode #site-navigation ul li a:hover,.mt-site-dark-mode .site-title a:hover,.mt-site-dark-mode .entry-title a:hover,.mt-site-dark-mode .cvmm-post-title a:hover,.mt-site-dark-mode .mt-social-icon-wrap li a:hover,.mt-site-dark-mode .mt-search-icon a:hover,.mt-site-dark-mode .ticker-post-title a:hover,.single.mt-site-dark-mode .mt-author-box .mt-author-info .mt-author-name a:hover,.mt-site-dark-mode .mt-site-mode-wrap .mt-mode-toggle:hover,.mt-site-dark-mode .mt-site-mode-wrap .mt-mode-toggle:checked:hover{ color: ". esc_attr( $color_newspaper_primary_color ) ." !important}\n";
        
    $custom_css .= "#site-navigation .menu-item-description::after,.mt-custom-page-header{ border-top-color: ". esc_attr( $color_newspaper_primary_color ) ."}\n";
    
    $custom_css .= "#top-header{ background-color: ". esc_attr( $color_newspaper_top_header_bg_color ) ."}\n";
    
    $custom_css .= "#site-navigation .menu-item-description{ background-color: ". esc_attr( $color_newspaper_primary_dark_color ) ."}\n";
    
    $custom_css .= "#site-navigation .menu-item-description:after{ border-top-color: ". esc_attr( $color_newspaper_primary_dark_color ) ."}\n";    

    $output_css = color_magazine_css_strip_whitespace( $custom_css );

    wp_add_inline_style( 'color-newspaper-style', $output_css );

}

/*
 *  Overwrite some elementor settings for better demo
 */
if ( ! function_exists( 'color_newspaper_overwrite_elementor_settings' ) ) :

    function color_newspaper_overwrite_elementor_settings() {
        // Check if Elementor installed and activated
        if ( !did_action( 'elementor/loaded' ) ) {
            return;
        }

        $options = get_option( 'color_newspaper_elementor_overwrite' );

        if (!$options) {
            if ( 'yes' !== get_option( 'elementor_disable_color_schemes' ) ) {
                update_option( 'elementor_disable_color_schemes', 'yes' );
            }

            if ( 'yes' !== get_option( 'elementor_disable_typography_schemes' ) ) {
                update_option( 'elementor_disable_typography_schemes', 'yes' );
            }
        }

        update_option( 'color_newspaper_elementor_overwrite', 'yes' );
    }

endif;

add_action( 'init', 'color_newspaper_overwrite_elementor_settings' );