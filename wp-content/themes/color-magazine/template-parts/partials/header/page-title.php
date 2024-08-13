<?php
/**
 * Partial template for page title.
 *
 * @package Color_Magazine
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$enable_header_page_title = get_theme_mod( 'color_magazine_enable_header_page_title', true );

if ( is_front_page() || false === $enable_header_page_title ) {
    return;
}

/**
 * color_magazine_before_page_title hook
 * 
 * 
 * @since 1.0.0
 */
do_action( 'color_magazine_before_page_title' );

$heading_tag = apply_filters( 'color_magazine_page_title_heading_tag', 'h1' );
?>
    <div class="mt-custom-page-header">
        <div class="mt-container inner-page-header mt-clearfix">
            <<?php echo esc_attr( $heading_tag ); ?> class="page-title"><?php echo wp_kses_post( color_magazine_get_the_title() ); ?></<?php echo esc_attr( $heading_tag ); ?>>
            <?php
                /**
                 * color_magazine_inside_page_title hook
                 *
                 * @hooked - color_magazine_breadcrumb_content - 10
                 *
                 * @since 1.0.0
                 */
                do_action( 'color_magazine_inside_page_title' );
            ?>
        </div><!-- .mt-container -->
    </div><!-- .mt-custom-page-header -->
<?php
/**
 * color_magazine_after_page_title hook
 * 
 * 
 * @since 1.0.0
 */
do_action( 'color_magazine_after_page_title' );