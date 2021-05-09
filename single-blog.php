<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package ieverly
 */

/* thumbnail */
if (has_post_thumbnail()) {
    $item__imgurl = get_the_post_thumbnail_url(get_the_ID(), 'full');
} else {
    $item__imgurl = get_template_directory_uri() . '/assets/dist/img/img-default.png';
}

$blog_tags = wp_get_post_terms($post->ID, 'blog_tag');

get_header('absolute');
?>

<article <?php post_class('blog__single'); ?> role="article">
    <header>
        <div class="cover">
            <img loading="lazy" src="<?php echo esc_url($item__imgurl); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
        </div>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="blog__single-title">
                        <div class="blog__item-tags">
                            <?php
                            foreach ($blog_tags as $blog_tag) {
                                echo '<span>' . $blog_tag->name . '</span>';
                            }
                            ?>
                        </div>
                        <h4><?php echo esc_attr(get_the_title()); ?></h4>
                    </div>
                </div>
            </div>

        </div>

    </header>

    <main class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>

                    <span class="entry-date"><?php echo get_the_date(); ?></span>
                </div>
            </div>
        </div>
    </main>

</article>

<?php
get_footer();
