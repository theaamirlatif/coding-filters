<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Pag
 *
 * @package Color_Magazine
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
$color_magazine_pnf_latest_posts = get_theme_mod( 'color_magazine_enable_pnf_latest_posts', true );
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main">

		<section class="error-404 not-found">
			<div class="error-num"><?php esc_html_e( '404', 'color-magazine' ); ?><span><?php esc_html_e( 'error', 'color-magazine' );?></span></div>
			<header class="page-header">
				<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'color-magazine' ); ?></h1>
			</header><!-- .page-header -->
			<div class="page-content">
				<p><?php esc_html_e( 'It looks like nothing was found at this location.', 'color-magazine' ); ?></p>
		</section><!-- .error-404 -->

		<?php if ( true ===  $color_magazine_pnf_latest_posts ) { ?>

			<div class="page-extra-content mt-404-latest-posts-wrapper">
				<?php
					$color_magazine_pnf_latest_post_count = get_theme_mod( 'color_magazine_pnf_latest_post_count', 3 );
					$color_magazine_pnf_args = array(
						'post_type' 			=> 'post',
						'posts_per_page' 		=> absint( $color_magazine_pnf_latest_post_count ),
						'ignore_sticky_posts' 	=> 1,
					);
					$color_magazine_pnf_query = new WP_Query( $color_magazine_pnf_args );
					if ( $color_magazine_pnf_query->have_posts() ) {
						echo '<div class="mt-pnf-latest-posts-wrapper mt-related-posts-wrapper">';
						$color_magazine_404_latest_title = get_theme_mod( 'color_magazine_pnf_latest_title', __( 'You May Like' ,'color-magazine' ) );
						echo '<h2 class="section-title mt-related-post-title">'. esc_html( $color_magazine_404_latest_title ) .'</h2>';
						while ( $color_magazine_pnf_query->have_posts() ) {
							$color_magazine_pnf_query->the_post();

							/*
							 * Include the Post-Type-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
							 */
							get_template_part( 'template-parts/content', get_post_type() );
							
						}
						echo '</div><!-- .mt-pnf-latest-posts-wrapper -->';
					}
					wp_reset_postdata();
				?>
			</div><!-- .page-extra-content -->

	<?php } ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();