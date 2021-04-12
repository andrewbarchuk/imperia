<?php
/**
 * Ieverly Theme Property single
 *
 * @package ieverly
 */

$gallery_id = get_post_meta( $post->ID, 'property_url', true );
$price      = get_post_meta( $post->ID, 'price', true );
$condition  = get_post_meta( $post->ID, 'condition', true );
$area       = get_post_meta( $post->ID, 'area', true );
$area_land  = get_post_meta( $post->ID, 'area_land', true );
$floors     = get_post_meta( $post->ID, 'floors', true );
$garage     = get_post_meta( $post->ID, 'garage', true );
$baths      = get_post_meta( $post->ID, 'baths', true );
$beds       = get_post_meta( $post->ID, 'beds', true );
$map        = get_post_meta( $post->ID, 'map', true );
$ref        = get_post_meta( $post->ID, 'ref', true );

$property_status   = wp_get_post_terms( $post->ID, 'property-status' );
$property_city     = wp_get_post_terms( $post->ID, 'property-city' );
$property_type     = wp_get_post_terms( $post->ID, 'property-type' );
$property_features = wp_get_post_terms( $post->ID, 'property-feature' );
$property_states   = wp_get_post_terms( $post->ID, 'property-state' );
$property_kitchen  = wp_get_post_terms( $post->ID, 'property-kitchen' );

// thumbnail
if ( has_post_thumbnail() ) {
	$item__imgurl = get_the_post_thumbnail_url( get_the_ID(), 'full' );
} else {
	$item__imgurl = get_template_directory_uri() . '/assets/dist/img/img-default.png';
}

// gallery 
$gallery = get_posts(
	array(
		'post_type'      => 'attachment',
		'orderby'        => 'post__in', /* we have to save the order */
		'order'          => 'ASC',
		'post__in'       => explode( ',', $gallery_id ), /* $value is the image IDs comma separated */
		'numberposts'    => -1,
		'post_mime_type' => 'image',
	)
);
?>

<!-- cover -->
<section class="property__single-header">
	<div class="property__single-cover">
		<img loading="lazy" src="<?php echo wp_kses( $item__imgurl ); ?>" alt="<?php echo wp_kses( get_the_title() ); ?>">
	</div>

	<div class="property__single-header-description">
		<div class="container">
			<div class="property__single-title">
				<?php if ( get_post_meta( $post->ID, 'reserved', true ) == 'on' || get_post_meta( $post->ID, 'sold_out', true ) == 'on' ) { ?>
					<div class="property__single-badge">
						<?php 
						if ( get_post_meta( $post->ID, 'reserved', true ) == 'on' ) {
							echo '<div class="badge badge__reserved">' . __( 'Reserved', 'ieverly' ) . '</div>';
						}
						if ( get_post_meta( $post->ID, 'sold_out', true ) == 'on' ) {
							echo '<div class="badge badge__sold-out">' . __( 'Sold out', 'ieverly' ) . '</div>';
						} 
						?>
					</div>
				<?php } ?>

				<div class="price">
					<p class="price-replace"><?php echo wp_kses( get_theme_mod( 'currency' ) ); ?><?php echo wp_kses( $price ); ?></p>
				</div>

				<h1 class="info">
					<?php
					foreach ( $property_status as $property_status_slug ) {
						echo $property_status_slug->name . ' ';
					}
					foreach ( $property_type as $property_type_slug ) {
						echo $property_type_slug->name . ' ';
					}
					echo get_the_title() . ' ';
					foreach ( $property_city as $property_city_slug ) {
						esc_html_e( 'in', 'ieverly' );
						echo ' ' . $property_city_slug->name;
					}
					?>
				</h1>
			</div>

			<div class="property__single-info">
				<?php if ( $floors ) { ?>
					<div class="single-info__box storeys">
						<?php ieverly_the_theme_svg( 'storeys', 'ui' ); ?>
						<span><?php echo wp_kses( $floors ); ?></span>
						<p><?php esc_html_e( 'Storeys', 'ieverly' ); ?></p>
					</div>
				<?php }; ?>

				<?php if ( $beds ) { ?>
					<div class="single-info__box beds">
						<?php ieverly_the_theme_svg( 'beds', 'ui' ); ?>
						<span><?php echo wp_kses( $beds ); ?></span>
						<p><?php esc_html_e( 'Bedrooms', 'ieverly' ); ?></p>
					</div>
				<?php }; ?>

				<?php if ( $area ) { ?>
					<div class="single-info__box area">
						<?php ieverly_the_theme_svg( 'area', 'ui' ); ?>
						<span><?php echo wp_kses( $area ); ?><?php echo wp_kses( get_theme_mod( 'area' ) ); ?></span>
						<p><?php esc_html_e( 'Living area', 'ieverly' ); ?></p>
					</div>
				<?php }; ?>

				<?php if ( $area_land ) { ?>
					<div class="single-info__box area-land">
						<?php ieverly_the_theme_svg( 'area-land', 'ui' ); ?>
						<span><?php echo wp_kses( $area_land ); ?><?php echo wp_kses( get_theme_mod( 'area' ) ); ?></span>
						<p><?php esc_html_e( 'Land area', 'ieverly' ); ?></p>
					</div>
				<?php }; ?>

				<?php if ( $baths ) { ?>
					<div class="single-info__box baths">
						<?php ieverly_the_theme_svg( 'baths', 'ui' ); ?>
						<span><?php echo wp_kses( $baths ); ?></span>
						<p><?php esc_html_e( 'Baths', 'ieverly' ); ?></p>
					</div>
				<?php }; ?>

				<?php if ( $garage ) { ?>
					<div class="single-info__box garage">
						<?php ieverly_the_theme_svg( 'garage', 'ui' ); ?>
						<span><?php echo wp_kses( $garage ); ?></span>
						<p><?php esc_html_e( 'Parking place', 'ieverly' ); ?></p>
					</div>
				<?php }; ?>
			</div>
		</div>
	</div>
</section>

<section class="propery__single-content content">
	<div class="container">
		<div class="row">
			<div class="col-lg-8">

				<!-- gallery -->
				<div class="property__single-gallery">
					<div id="gallery__cover" class="splide">
						<?php
						if ( $gallery ) {
							echo '<div class="splide__track"><ul class="splide__list">';
							foreach ( $gallery as $image ) {
								$image_src         = wp_get_attachment_image_src( $image->ID, 'large' );
								$image_src_preview = wp_get_attachment_image_src( $image->ID, 'thumbnail' );
								echo '<li class="splide__slide"><img src="' . $image_src[0] . '" data-splide-lazy="' . $image_src_preview[0] . '"></li>';
							}
							echo '</ul></div>';
						}
						?>
					</div>
					<div id="gallery__dots" class="splide">
						<?php
						if ( $gallery ) {
							echo '<div class="splide__track"><ul class="splide__list">';
							foreach ( $gallery as $image ) {
								$image_src         = wp_get_attachment_image_src( $image->ID, 'large' );
								$image_src_preview = wp_get_attachment_image_src( $image->ID, 'thumbnail' );
								echo '<li class="splide__slide"><img src="' . $image_src_preview[0] . '" data-splide-lazy="' . $image_src_preview[0] . '"></li>';
							}
							echo '</ul></div>';
						}
						?>
					</div>
				</div>

				<!-- freatures -->
				<div class="propery__single-content-box property__single-features">
					<h3><?php esc_html_e( 'Features', 'ieverly' ); ?></h3>
					<?php if ( $property_features ) { ?>
						<div class="features">
							<?php
							foreach ( $property_features as $property_feature ) {
								echo '<a href="' . get_post_type_archive_link( 'property' ) . '?feature-' . $property_feature->slug . '=on">';
								ieverly_the_theme_svg( 'check', 'ux' );
								echo $property_feature->name . '</a>';
							}
							?>
						</div>
					<?php }; ?>
					<?php if ( $property_states ) { ?>
						<div class="condition">
							<?php
							echo __( 'General state', 'ieverly' ) . ': ';
							foreach ( $property_states as $property_state ) {
								echo '<a href="' . get_post_type_archive_link( 'property' ) . '?property-state=' . $property_state->slug . '"><b>' . $property_state->name . '</b></a> ';
							}
							?>
						</div>
					<?php }; ?>
					<?php if ( $property_kitchen ) { ?>
						<div class="kitchen">
							<?php
							echo __( 'Kitchen', 'ieverly' ) . ': ';
							foreach ( $property_kitchen as $property_kitchen_item ) {
								echo '<a href="' . get_post_type_archive_link( 'property' ) . '?property-kitchen=' . $property_kitchen_item->slug . '"><b>' . $property_kitchen_item->name . '</b></a> ';
							}
							?>
						</div>
					<?php }; ?>
				</div>

				<!-- description -->
				<div class="propery__single-content-box property__single-description">
					<h3><?php esc_html_e( 'Description', 'ieverly' ); ?></h3>
					<div class="entry-content">
						<?php the_content(); ?>
					</div>
				</div>

				<!-- location -->
				<?php if ( $map ) { ?>
					<div class="propery__single-content-box property__single-location">
						<h3><?php esc_html_e( 'Location', 'ieverly' ); ?></h3>
						<?php echo $map; ?>
					</div>
				<?php } ?>

			</div>
			<div class="col-lg-4">

				<!-- form -->
				<div class="property__single-form">
					this shortcode
				</div>

			</div>
		</div>
	</div>
</section>
