<?php
/**
 * Partial template for search icons.
 *
 * @package Color_Magazine
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$color_magazine_enable_search_icon = get_theme_mod( 'color_magazine_enable_search_icon', true );
if ( false === $color_magazine_enable_search_icon ) {
	return;
}
$color_magazine_menu_search_icon_lable = apply_filters( 'color_magazine_menu_search_icon_lable', __( 'Search', 'color-magazine' ) );

?>
<div class="mt-menu-search">
	<div class="mt-search-icon"><a href="javascript:void(0)"><?php echo esc_html( $color_magazine_menu_search_icon_lable ); ?><i class='bx bx-search'></i></a></div>
	<div class="mt-form-wrap">
		<div class="mt-form-close"><a href="javascript:void(0)"><i class='bx bx-x'></i></a></div>
		<?php get_search_form(); ?>
	</div><!-- .mt-form-wrap -->
</div><!-- .mt-menu-search -->