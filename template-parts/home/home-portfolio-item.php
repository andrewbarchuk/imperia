<?php
/**
 * Template part for displaying portfolio item
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ieverly
 */

$portfolio_gallery_id = get_post_meta( $post->ID, 'portfolio_gallery', true );

$portfolio_tags = wp_get_post_terms( $post->ID, 'portfolio-tag' );
foreach ( $portfolio_tags as $tag ) {
	$active_class = $tag->slug;
}

if ( has_post_thumbnail() ) {
	$gallery_cover = get_the_post_thumbnail_url( get_the_ID(), 'full' );
} else {
	$gallery_cover = get_template_directory_uri() . '/dist/images/img-default.png';
}
?>

<article id="post-<?php the_ID(); ?>" data-category="<?php echo $active_class; ?>" class="portfolio__item <?php echo $active_class; ?>">
	<a rel="post-<?php the_ID(); ?>" href="<?php echo $gallery_cover; ?>" data-gallery="portfolio-<?php the_ID(); ?>" data-glightbox="title: <?php echo get_the_title(); ?>; description: .gallery-description-<?php the_ID(); ?>" <?php post_class( 'glightbox' ); ?>>
		<header>
			<h4><?php echo get_the_title(); ?></h4>
			<span class="date"><?php echo get_the_date( 'M d, Y' ); ?></span>
		</header>

		<figure>
			<img src="<?php echo $gallery_cover; ?>" alt="<?php echo get_the_title(); ?>">
		</figure>
	</a>

	<div class="glightbox-desc gallery-description-<?php the_ID(); ?>">
		<?php the_content(); ?>
	</div>

	<?php
	$images = get_posts(
		array(
			'post_type'      => 'attachment',
			'orderby'        => 'post__in', /* we have to save the order */
			'order'          => 'ASC',
			'post__in'       => explode( ',', $portfolio_gallery_id ), /* $value is the image IDs comma separated */
			'numberposts'    => -1,
			'post_mime_type' => 'image',
		)
	);

	if ( $images ) {
		echo '<div class="portfolio__item-cases">';
		foreach ( $images as $image ) {
			$image_src  = wp_get_attachment_image_src( $image->ID, 'large' );
			$gallery_id = $post->ID;
			echo '<a rel="nofollow" class="glightbox" href="' . esc_html( $image_src[0] ) . '" data-gallery="portfolio-' . $gallery_id . '"></a>';
		}
		echo '</div>';
	}
	?>
</article>
<!-- post-<?php the_ID(); ?> -->
