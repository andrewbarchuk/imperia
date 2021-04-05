<?php
/**
 * Template part for displaying home instagram
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ieverly
 */

$home_instagram       = get_post_meta( $post->ID, 'home_instagram', true );
?>

<section class="home-instagram content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="home-insatgram__title">
                    <?php ieverly_the_theme_svg('crown', 'ui'); ?>
                    <h3 class="back-text"><?php esc_html_e( 'Instagram', 'ieverly' ); ?></h3>
                </div>
            </div>
        </div>

        <div class="home-instagram__box home-portfolio__list">
           <?php echo do_shortcode( $home_instagram ); ?>
        </div>
    </div>
</section>