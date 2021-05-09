<?php

/**
 * Template part for displaying blog item
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ieverly
 */

/* thumbnail */
if (has_post_thumbnail()) {
    $item__imgurl = get_the_post_thumbnail_url(get_the_ID(), 'large');
} else {
    $item__imgurl = get_template_directory_uri() . '/assets/dist/img/img-default.png';
}

$blog_tags = wp_get_post_terms($post->ID, 'blog_tag');
?>

<div class="col-lg-4">
    <article <?php post_class('blog__item'); ?> role="article">
        <div class="cover">
            <img loading="lazy" src="<?php echo esc_url($item__imgurl); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
        </div>
        <a rel="bookmark" arial-label="<?php echo esc_attr(get_the_title()); ?>" class="property__item-link" href="<?php echo esc_url(get_permalink($post->ID)); ?>"></a>
        <div class="blog__item-tags">
            <?php
            foreach ($blog_tags as $blog_tag) {
                echo '<span>' . $blog_tag->name . '</span>';
            }
            ?>
        </div>

        <h4><?php echo esc_attr(get_the_title()); ?></h4>

    </article>
</div>