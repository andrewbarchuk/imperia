<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ieverly
 */

get_header();
?>

<section class="blog-archive content" id="blog">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="entry-title back-text"><?php wp_title('');?></h1>
            </div>
        </div>

        <div class="row">
            <?php
            if (have_posts()) : ?>
                <?php
                while (have_posts()) : the_post();
                    include get_template_directory() . '/template-parts/blog/blog-item.php';
                endwhile;
                ?>
            <?php else : ?>
                <?php include get_template_directory() . '/template-parts/notfound.php'; ?>
            <?php endif;
            wp_reset_postdata(); ?>
        </div>

        <div class="row">
            <div class="col-12">
                <?php the_posts_pagination(); ?>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();
