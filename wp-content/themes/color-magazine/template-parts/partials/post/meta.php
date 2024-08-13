<?php
/**
 * Partial template to display the post meta
 *
 * @package Color_Magazine
 *
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( 'post' !== get_post_type() ) {
    return;
}
?>

<div class="entry-meta"> 
    <?php 
        color_magazine_posted_on();
        color_magazine_posted_by();
    ?> 
</div>