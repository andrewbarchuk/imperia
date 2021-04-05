<?php
/**
 * Template part for displaying home hero box
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ieverly
 */

$gallery_id = get_post_meta( $post->ID, 'home_slider', true );

$author_slogan             = get_post_meta( $post->ID, 'author_slogan', true );
$author_slogan_description = get_post_meta( $post->ID, 'author_slogan_description', true );

if ( get_post_meta( $post->ID, 'author_name', true ) ) {
	$author_name = get_post_meta( $post->ID, 'author_name', true );
} else {
	$author_name = get_bloginfo( 'name' ); 
}
?>

<section class="hero home-hero">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-6 col-md-6">
				<div class="hero__description">
					<div class="hero__description-heading">
						<h4><?php echo esc_html( $author_name ); ?></h4>
						<h1 class="back-text"><?php echo esc_html( $author_slogan ); ?></h1>
						<h2><?php echo esc_html( $author_slogan_description ); ?></h2>
					</div>

					<nav class="hero__social-menu">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'social',
							)
						);
						?>
					</nav>
				</div>
			</div>

			<div class="col-lg-6 col-md-6 no-padding">
				<?php
				$images = get_posts(
					array(
						'post_type'      => 'attachment',
						'orderby'        => 'post__in', /* we have to save the order */
						'order'          => 'ASC',
						'post__in'       => explode( ',', $gallery_id ), /* $value is the image IDs comma separated */
						'numberposts'    => -1,
						'post_mime_type' => 'image',
					)
				);

				if ( $images ) {
					?>
					<div class="glide hero__slider">
						<div class="glide__track" data-glide-el="track">
							<ul class="glide__slides">

							<?php
							foreach ( $images as $image ) {
								$image_src         = wp_get_attachment_image_src( $image->ID, 'medium' );
								$image_src_preview = wp_get_attachment_image_src( $image->ID, 'gallery-thumbnail' );
								echo '<li class="glide__slide"><figure class="hero__slider-img"><img src="' . esc_html( $image_src_preview[0] ) . '" loading="lazy"></figure></li>';
							}
				} 
				?>

							</ul>
						</div>

						<div class="glide__arrows hero__slider-arrows" data-glide-el="controls">
							<button data-glide-dir="<"><?php ieverly_the_theme_svg( 'chevron-left', 'ui' ); ?></button>
							<div class="hero__slider-num"><span id="glide-current">1</span>/<span id="glide-total">4</span></div>
							<button data-glide-dir=">"><?php ieverly_the_theme_svg( 'chevron-right', 'ui' ); ?></button>
						</div>

					</div>
			</div>
		</div>

		<div class="row">
			<div class="col-12">
				<div class="hero__anchor">
					<a href="#history"><?php ieverly_the_theme_svg( 'scroll-down', 'ui' ); ?></a>
				</div>
			</div>
		</div>
	</div>
</section>
