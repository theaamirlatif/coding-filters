<?php
/**
 * Dynamic styles
 *
 * @package Color_Magazine
 *
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'wp_enqueue_scripts', 'color_magazine_dynamic_styles' );

if ( ! function_exists( 'color_magazine_dynamic_styles' ) ) :

    function color_magazine_dynamic_styles() {

        $color_magazine_primary_color = get_theme_mod( 'color_magazine_primary_color', '#0065C1' );
        $get_categories = get_categories( array( 'hide_empty' => 1 ) );

        $main_container_width   = get_theme_mod( 'color_magazine_main_container_width', 1300 );
        $boxed_container_width  = get_theme_mod( 'color_magazine_boxed_container_width', 1200 );
        $main_content_width     = get_theme_mod( 'color_magazine_main_content_width', 70 );
        $sidebar_width          = get_theme_mod( 'color_magazine_sidebar_width', 27 );

        $output_css = '';
    
        foreach ( $get_categories as $category ) {

            $cat_color = get_theme_mod( 'color_magazine_category_color_'.$category->slug, '#3b2d1b' );
            $cat_hover_color = color_magazine_hover_color( $cat_color, '-50' );
            $cat_id = $category->term_id;
            
            if ( !empty( $cat_color ) ) {
                $output_css .= ".category-button.cb-cat-". esc_attr( $cat_id ) ." a { background: ". esc_attr( $cat_color ) ."}\n";
                $output_css .= ".category-button.cb-cat-". esc_attr( $cat_id ) ." a:hover { background: ". esc_attr( $cat_hover_color ) ."}\n";
                $output_css .= "#site-navigation ul li.cb-cat-". esc_attr( $cat_id ) ." .menu-item-description { background: ". esc_attr( $cat_color ) ."}\n";
               $output_css .= "#site-navigation ul li.cb-cat-". esc_attr( $cat_id ) ." .menu-item-description:after { border-top-color: ". esc_attr( $cat_color ) ."}\n";
            }
        }
        
        $output_css .= "a,a:hover,a:focus,a:active,.entry-cat .cat-links a:hover,.entry-cat a:hover,.byline a:hover,.posted-on a:hover,.entry-footer a:hover,.comment-author .fn .url:hover,.commentmetadata .comment-edit-link,#cancel-comment-reply-link,#cancel-comment-reply-link:before,.logged-in-as a,.widget a:hover,.widget a:hover::before,.widget li:hover::before,#top-navigation ul li a:hover,.mt-social-icon-wrap li a:hover,.mt-search-icon:hover,.mt-form-close a:hover,.menu-toggle:hover,#site-navigation ul li:hover>a,#site-navigation ul li.current-menu-item>a,#site-navigation ul li.current_page_ancestor>a,#site-navigation ul li.current-menu-ancestor>a,#site-navigation ul li.current_page_item>a,#site-navigation ul li.focus>a,.entry-title a:hover,.cat-links a:hover,.entry-meta a:hover,.entry-footer .mt-readmore-btn:hover,.btn-wrapper a:hover,.mt-readmore-btn:hover,.navigation.pagination .nav-links .page-numbers.current,.navigation.pagination .nav-links a.page-numbers:hover,.breadcrumbs a:hover,#footer-menu li a:hover,#top-footer a:hover,.color_magazine_latest_posts .mt-post-title a:hover,#mt-scrollup:hover,.mt-site-mode-wrap .mt-mode-toggle:hover,.mt-site-mode-wrap .mt-mode-toggle:checked:hover,.has-thumbnail .post-info-wrap .entry-title a:hover,.front-slider-block .post-info-wrap .entry-title a:hover{ color: ". esc_attr( $color_magazine_primary_color ) ."}\n";

        $output_css .= ".widget_search .search-submit,.widget_search .search-submit:hover,.widget_tag_cloud .tagcloud a:hover,.widget.widget_tag_cloud a:hover,.navigation.pagination .nav-links .page-numbers.current,.navigation.pagination .nav-links a.page-numbers:hover,.error-404.not-found,.color-magazine_social_media a:hover{ border-color: ". esc_attr( $color_magazine_primary_color ) ."}\n";

        $output_css .= ".edit-link .post-edit-link,.reply .comment-reply-link,.widget_search .search-submit,.widget_search .search-submit:hover,.widget_tag_cloud .tagcloud a:hover,.widget.widget_tag_cloud a:hover,#top-header,.mt-menu-search .mt-form-wrap .search-form .search-submit,.mt-menu-search .mt-form-wrap .search-form .search-submit:hover,#site-navigation .menu-item-description,.mt-ticker-label,.post-cats-list a,.front-slider-block .lSAction>a:hover,.top-featured-post-wrap .post-thumbnail .post-number,article.sticky::before,#secondary .widget .widget-title::before,.mt-related-post-title:before,#colophon .widget .widget-title:before,.features-post-title:before,.cvmm-block-title.layout--default:before,.color-magazine_social_media a:hover { background: ". esc_attr( $color_magazine_primary_color ) ."}\n";

         $output_css .= ".mt-site-dark-mode .widget_archive a:hover,.mt-site-dark-mode .widget_categories a:hover,.mt-site-dark-mode .widget_recent_entries a:hover,.mt-site-dark-mode .widget_meta a,.mt-site-dark-mode .widget_recent_comments li:hover,.mt-site-dark-mode .widget_rss li,.mt-site-dark-mode .widget_pages li a:hover,.mt-site-dark-mode .widget_nav_menu li a:hover,.mt-site-dark-mode .wp-block-latest-posts li a:hover,.mt-site-dark-mode .wp-block-archives li a:hover,.mt-site-dark-mode .wp-block-categories li a:hover,.mt-site-dark-mode .wp-block-page-list li a:hover,.mt-site-dark-mode .wp-block-latest-comments li:hover,.mt-site-dark-mode #site-navigation ul li a:hover,.mt-site-dark-mode .site-title a:hover,.mt-site-dark-mode .entry-title a:hover,.mt-site-dark-mode .cvmm-post-title a:hover,.mt-site-dark-mode .mt-social-icon-wrap li a:hover,.mt-site-dark-mode .mt-search-icon a:hover,.mt-site-dark-mode .ticker-post-title a:hover,.single.mt-site-dark-mode .mt-author-box .mt-author-info .mt-author-name a:hover,.mt-site-dark-mode .mt-site-mode-wrap .mt-mode-toggle:hover,.mt-site-dark-mode .mt-site-mode-wrap .mt-mode-toggle:checked:hover{ color: ". esc_attr( $color_magazine_primary_color ) ." !important}\n";
        

        $output_css .= "#site-navigation .menu-item-description::after,.mt-custom-page-header{ border-top-color: ". esc_attr( $color_magazine_primary_color ) ."}\n";

        // container width (in px)
        if ( ! empty( $main_container_width ) ) {
            $output_css .= '.mt-container{width:'. absint( $main_container_width ) .'px}';
        }

        // boxed container width (in px)
        if ( ! empty( $boxed_container_width ) ) {
            $output_css .= '.site-layout--boxed #page{width:'. absint( $boxed_container_width ) .'px}';
        }
        
        // main content width (in %)
        if ( ! empty( $main_content_width ) ) {
            $output_css .= '#primary,.home.blog #primary{width:'. absint( $main_content_width ) .'%}';
        }

        // sidebar content width (in %)
        if ( ! empty( $sidebar_width ) ) {
            $output_css .= '#secondary,.home.blog #secondary{width:'. absint( $sidebar_width ) .'%}';
        }

        $refine_output_css = color_magazine_css_strip_whitespace( $output_css );
        wp_add_inline_style( 'color-magazine-style', $refine_output_css );
    }
    
endif;