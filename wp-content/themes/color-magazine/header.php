<?php
/**
 * The header for theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Color_Magazine
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} else {
		/**
		 * Hook: wp_body_open
		 *
		 * @since 1.1.0
		 */
		do_action( 'wp_body_open' );
	}

	/**
	 * hook - color_magazine_before_page
	 * 
	 * @hooked - color_magazine_preloader -5
	 * 
	 * @since 1.0.0
	 */
	do_action( 'color_magazine_before_page' );
?>

<div id="page" class="site">
<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip To Content', 'color-magazine' ) ?></a>
	<?php
		/**
		 * hook - color_magazine_before_header
		 * 
		 * @since 1.0.0
		 */
		do_action( 'color_magazine_before_header' );

		/**
		 * color_magazine_header_section hook
		 *
		 * @hooked - color_magazine_top_header - 10
		 * @hooked - color_magazine_main_header - 20
		 * @hooked - color_magazine_ticker_section - 30
		 * @hooked - color_magazine_innerpage_page_title - 40
		 *
		 * @since 1.0.0
		 */
		do_action( 'color_magazine_header_section' );

		if ( is_front_page() ) {
			/**
			 * hook - color_magazine_after_header
			 * displays front top section before archive blogs.
			 *
    		 * @hooked - color_magazine_front_page_slider_section - 10
    		 * 
    		 * @since 1.0.0
			 */
			do_action( 'color_magazine_after_header' );
		}
	?>

	<div id="content" class="site-content">
		<div class="mt-container">
