<?php
/**
 * Partial template for trending tags.
 *
 * @package Color_Magazine
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$color_magazine_enable_trending = get_theme_mod( 'color_magazine_enable_trending', true );

if ( false === $color_magazine_enable_trending ) {
    return;
}

$color_magazine_trending_label = get_theme_mod( 'color_magazine_trending_label', __( 'Trending Now', 'color-magazine' ) );

?>
<div class="trending-wrapper tag-before-icon">
    <span class="wrap-label"><i class="bx bxs-bolt" aria-hidden="true"></i><?php echo esc_html( $color_magazine_trending_label ); ?></span>
    <div class="tags-wrapper">
        <?php
            $color_magazine_trending_tags_count = apply_filters( 'color_magazine_trending_tags_count', 5 );
            $get_tags_lists = get_tags(
                array(
                    'order'     => 'DESC',
                    'number'    => absint( $color_magazine_trending_tags_count ),
                )
            );
            if ( ! empty( $get_tags_lists ) ) {
                echo '<span class="head-tags-links">';
                foreach( $get_tags_lists as $tag ) {
                    echo '<a href="'.esc_html( get_tag_link( $tag->term_id ) ).'" rel="tag">'. esc_html( $tag->name ) .'</a>';
                }
                echo '</span>';
            }
        ?>
    </div><!-- .tags-wrapper -->
</div><!-- .trending-wrapper -->