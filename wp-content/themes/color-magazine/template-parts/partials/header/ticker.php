<?php
/**
 * Partial template for ticker section.
 *
 * @package Color_Magazine
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$color_magazine_enable_ticker = get_theme_mod( 'color_magazine_enable_ticker', true );
$ticker_count = apply_filters( 'color_magazine_ticker_posts_count', 9 );

$ticker_args = array(
    'post_type'         => 'post',
    'posts_per_page'    => absint( $ticker_count )
);
$ticker_query = new WP_Query( $ticker_args );

if ( false === $color_magazine_enable_ticker || !( $ticker_query->have_posts() ) ) {
    return;
}

$color_magazine_ticker_label = get_theme_mod( 'color_magazine_ticker_label', __( 'Headline', 'color-magazine' ) );
$title_attr = '';
if ( empty ( $color_magazine_ticker_label ) ) {
    $title_attr = 'no-title';
}

/**
 * color_magazine_before_ticker hook
 * 
 * @since 1.0.0
 */
do_action( 'color_magazine_before_ticker' );

?>

<div class="mt-header-ticker-wrapper <?php echo esc_attr( $title_attr ); ?>">
    <div class="mt-container">
        <?php
            if ( ! empty( $color_magazine_ticker_label ) ) {
                echo '<div class="mt-ticker-label"><div class="ticker-spinner"><div class="ticker-bounce1"></div><div class="ticker-bounce2"></div></div>'.esc_html( $color_magazine_ticker_label ).'</div>';
            }
        ?>
        <div class="ticker-posts-wrap">
            <?php
                while ( $ticker_query->have_posts() ) {
                    $ticker_query->the_post();
            ?>
                    <div class="ticker-post-thumb-wrap">
                        <div class="ticker-post-thumb">
                            <?php the_post_thumbnail( 'thumbnail' ); ?>
                        </div>
                        <div class="ticker-post-title-wrap">
                            <div class="ticker-post-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </div>
                        </div><!-- ticker-post-title-wrap -->
                    </div><!-- .ticker-post-thumb-wrap -->
            <?php
                }
            ?>
        </div><!-- .ticker-posts-wrap -->
     </div>
</div><!-- .mt-header-ticker-wrapper -->

<?php

/**
 * color_magazine_after_ticker hook
 * 
 * @since 1.0.0
 */
do_action( 'color_magazine_after_ticker' );
