<?php
/**
 * Template part for displaying page layout in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package     Bloghash
 * @author      Peregrine Themes
 * @since       1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?><?php bloghash_schema_markup( 'article' ); ?>>

<?php
if ( bloghash_show_post_thumbnail() ) {
	get_template_part( 'template-parts/entry/format/media', 'page' );
}
?>

<div class="entry-content bloghash-entry">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <div class="entry-meta">
                        <span class="post-views">
                            <i class="fa fa-eye" aria-hidden="true"></i> <!-- Font Awesome Eye Icon -->
                            <?php echo get_post_views(get_the_ID()); ?>
                        </span>
                    </div>
                </header>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
<?php
        endwhile;
    endif;
?>

	<?php
	do_action( 'bloghash_before_page_content' );

	the_content();

	do_action( 'bloghash_after_page_content' );
	?>
</div><!-- END .entry-content -->

<?php bloghash_link_pages(); ?>

</article><!-- #post-<?php the_ID(); ?> -->
