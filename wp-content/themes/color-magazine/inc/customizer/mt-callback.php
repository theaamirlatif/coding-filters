<?php
/**
 * Define callback functions for active_callback.
 * 
 * @package Color_Magazine
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/*-------------------------------------- General panel callback --------------------------------------------------*/

	if ( ! function_exists( 'color_magazine_hasnt_boxed_layout_callback' ) ) :

	    /**
		 * Check if site layout has boxed layout or not.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
	    function color_magazine_hasnt_boxed_layout_callback( $control ) {
	        if ( 'site-layout--boxed' !== $control->manager->get_setting( 'color_magazine_site_layout' )->value() ) {
	            return true;
	        } else {
	            return false;
	        }
	    }
	    
	endif;

	if ( ! function_exists( 'color_magazine_has_boxed_layout_callback' ) ) :

	    /**
		 * Check if site layout has boxed layout or not.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
	    function color_magazine_has_boxed_layout_callback( $control ) {
	        if ( 'site-layout--wide' !== $control->manager->get_setting( 'color_magazine_site_layout' )->value() ) {
	            return true;
	        } else {
	            return false;
	        }
	    }
	    
	endif;

	if ( ! function_exists( 'color_magazine_has_enable_preloader_callback' ) ) :

	    /**
		 * Check if preloader toggle was enable or not.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
	    function color_magazine_has_enable_preloader_callback( $control ) {
	        if ( false !== $control->manager->get_setting( 'color_magazine_enable_preloader' )->value() ) {
	            return true;
	        } else {
	            return false;
	        }
	    }
	    
	endif;

	if ( ! function_exists( 'color_magazine_has_enable_scroll_top_callback' ) ) :

	    /**
		 * Check if scroll top toggle was enable or not.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
	    function color_magazine_has_enable_scroll_top_callback( $control ) {
	        if ( false !== $control->manager->get_setting( 'color_magazine_enable_scroll_top' )->value() ) {
	            return true;
	        } else {
	            return false;
	        }
	    }
	    
	endif;

/*-------------------------------------- Header panel callback ---------------------------------------------------*/

	if ( ! function_exists( 'color_magazine_enable_top_header_active_callback' ) ) :

	    /**
		 * Check if top header option is enabled.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
	    function color_magazine_enable_top_header_active_callback( $control ) {
	        if ( false !== $control->manager->get_setting( 'color_magazine_enable_top_header' )->value() ) {
	            return true;
	        } else {
	            return false;
	        }
	    }
	    
	endif;

	if ( ! function_exists( 'color_magazine_enable_top_header_trending_active_callback' ) ) :

	    /**
		 * Check if top header option and trending section option is enabled.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
	    function color_magazine_enable_top_header_trending_active_callback( $control ) {
	        if ( false !== $control->manager->get_setting( 'color_magazine_enable_top_header' )->value() && false !== $control->manager->get_setting( 'color_magazine_enable_trending' )->value() ) {
	            return true;
	        } else {
	            return false;
	        }
	    }
	    
	endif;

	if ( ! function_exists( 'color_magazine_enable_ticker_active_callback' ) ) :

	    /**
		 * Check if ticker section option is enabled.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
	    function color_magazine_enable_ticker_active_callback( $control ) {
	        if ( false !== $control->manager->get_setting( 'color_magazine_enable_ticker' )->value() ) {
	            return true;
	        } else {
	            return false;
	        }
	    }
	    
	endif;

/*-------------------------------------- Frontpage panel callback ------------------------------------------------*/

	if ( ! function_exists( 'color_magazine_has_enable_slider_callback' ) ) :

	    /**
		 * Check if slider option is enabled.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
	    function color_magazine_has_enable_slider_callback( $control ) {
	        if ( false !== $control->manager->get_setting( 'color_magazine_section_slider_option' )->value() ) {
	            return true;
	        } else {
	            return false;
	        }
	    }
	    
	endif;

	if ( ! function_exists( 'color_magazine_section_top_featured_posts_option_active_callback' ) ) :

	    /**
		 * Check if top featured posts option is enabled.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
	    function color_magazine_section_top_featured_posts_option_active_callback( $control ) {
	        if ( false !== $control->manager->get_setting( 'color_magazine_section_top_featured_posts_option' )->value() ) {
	            return true;
	        } else {
	            return false;
	        }
	    }
	    
	endif;

/*-------------------------------------- Blog panel callback ------------------------------------------------------*/

	if ( ! function_exists( 'color_magazine_enable_pnf_latest_posts_active_callback' ) ) :

	    /**
		 * Check if pnf latest posts option is enabled.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
	    function color_magazine_enable_pnf_latest_posts_active_callback( $control ) {
	        if ( false !== $control->manager->get_setting( 'color_magazine_enable_pnf_latest_posts' )->value() ) {
	            return true;
	        } else {
	            return false;
	        }
	    }
	    
	endif;

/*-------------------------------------- Footer panel callback ----------------------------------------------------*/

	if ( ! function_exists( 'color_magazine_enable_footer_widget_area_active_callback' ) ) :

	    /**
		 * Check if foooter menu option is enabled.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
	    function color_magazine_enable_footer_widget_area_active_callback( $control ) {
	        if ( false !== $control->manager->get_setting( 'color_magazine_enable_footer_widget_area' )->value() ) {
	            return true;
	        } else {
	            return false;
	        }
	    }
	    
	endif;

	if ( ! function_exists( 'color_magazine_enable_footer_menu_active_callback' ) ) :

	    /**
		 * Check if foooter menu option is enabled.
		 *
		 * @since 1.0.0
		 *
		 * @param WP_Customize_Control $control WP_Customize_Control instance.
		 *
		 * @return bool Whether the control is active to the current preview.
		 */
	    function color_magazine_enable_footer_menu_active_callback( $control ) {
	        if ( false !== $control->manager->get_setting( 'color_magazine_enable_footer_menu' )->value() ) {
	            return true;
	        } else {
	            return false;
	        }
	    }
	    
	endif;