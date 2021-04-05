<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ieverly
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('item__short'); ?>>
    <header class="entry-header">
        <?php ieverly_post_thumbnail(); ?>
    </header><!-- .entry-header -->

    <div class="item__short-in">
        <?php
        if (is_singular()) :
            the_title('<h1 class="entry-title">', '</h1>');
        else :
            the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
        endif;
        ?>
        <div class="entry-content">
            <?php the_content(); ?>
        </div><!-- .entry-content -->
    </div>
</article><!-- #post-<?php the_ID(); ?> -->