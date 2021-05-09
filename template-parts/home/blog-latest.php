<?php

/**
 * Template part for displaying blog section
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ieverly
 */

?>

<section class="blog content-bottom" id="blog">
    <div class="container">

        <div class="row">
            <?php
            $args = array('post_type' => 'blog', 'posts_per_page' => 3, 'order' => 'DESC', 'orderby' => 'date');
            $loop = new WP_Query($args);
            if ($loop->have_posts()) : ?>
                <?php
                while ($loop->have_posts()) : $loop->the_post();
                    include get_template_directory() . '/template-parts/blog/blog-item.php';
                endwhile;
                ?>
            <?php else : ?>
                <?php include get_template_directory() . '/template-parts/notfound.php'; ?>
            <?php endif;
            wp_reset_postdata(); ?>
        </div>

        <div class="row">
            <div class="col-12 end">
                <a class="blog__all" href="<?php echo get_post_type_archive_link('blog'); ?>"><?php esc_html_e( 'All posts', 'ieverly' ); ?><span><?php ieverly_the_theme_svg( 'chevron-right', 'ux' ); ?></span></a>
            </div>
        </div>
    </div>
</section>