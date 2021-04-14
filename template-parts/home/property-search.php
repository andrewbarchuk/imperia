<?php
/**
 * The template for displaying search on home
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ieverly
 */

/* thumbnail */
if ( has_post_thumbnail() ) {
	$item__imgurl = get_the_post_thumbnail_url( get_the_ID(), 'full' );
} else {
	$item__imgurl = get_template_directory_uri() . '/assets/dist/img/img-default.png';
}
?>

<section class="property__search content">
    <div class="cover">
        <img loading="lazy" src="<?php echo $item__imgurl; ?>" alt="<?php echo get_bloginfo( 'name' ); ?>">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <h1><?php echo get_the_title(); ?></h1>
                <?php get_template_part( '/template-parts/property/search' ); ?>
            </div>
        </div>
    </div>
</section>