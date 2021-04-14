<?php
/**
 * Ieverly Theme Property item
 *
 * @package ieverly
 */

$ref           = get_post_meta( $post->ID, 'ref', true );
$price         = get_post_meta( $post->ID, 'price', true );
$area          = get_post_meta( $post->ID, 'area', true );
$area_land     = get_post_meta( $post->ID, 'area_land', true );
$beds          = get_post_meta( $post->ID, 'beds', true );
$floors        = get_post_meta( $post->ID, 'floors', true );
$property_type = wp_get_post_terms( $post->ID, 'property-type' );

/* thumbnail */
if ( has_post_thumbnail() ) {
	$item__imgurl = get_the_post_thumbnail_url( get_the_ID(), 'medium' );
} else {
	$item__imgurl = get_template_directory_uri() . '/assets/dist/img/img-default.png';
}
?>

<div class="col-xl-3 col-lg-4 col-md-6">
	<article <?php post_class( 'property__item' ); ?>>
		<a rel="bookmark" arial-label="<?php echo esc_attr( get_the_title() ); ?>" class="property__item-link" href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>"></a>

		<header class="property__item-header">
			<?php if ( get_post_meta( $post->ID, 'reserved', true ) == 'on' || get_post_meta( $post->ID, 'sold_out', true ) == 'on' ) { ?>
				<div class="property__item-badge">
						<?php 
						if ( get_post_meta( $post->ID, 'reserved', true ) == 'on' ) {
							echo '<div class="badge badge__reserved">' . esc_html__( 'Reserved', 'ieverly' ) . '</div>';
						}
						if ( get_post_meta( $post->ID, 'sold_out', true ) == 'on' ) {
							echo '<div class="badge badge__sold-out">' . esc_html__( 'Sold out', 'ieverly' ) . '</div>';
						} 
						?>
				</div>
			<?php } ?>
			<img loading="lazy" src="<?php echo esc_url( $item__imgurl ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
		</header>

		<main>
			<?php if ( $ref ) { ?>
				<p class="ref"><b>REF:</b> <?php echo esc_attr( $ref ); ?></p>
			<?php }; ?>
			<h4>
				<?php
				foreach ( $property_type as $property_type_slug ) {
					echo esc_attr( $property_type_slug->name ) . ' ';
				}
					echo esc_attr( get_the_title() );
				?>
			</h4>
			<p class="property__item-price price-replace"><?php echo esc_attr( get_theme_mod( 'currency' ) ); ?><?php echo esc_attr( $price ); ?></p>
		</main>

		<footer>
			<div class="property__info-list">
				<?php if ( $floors ) { ?>
					<div class="property__info-box storeys">
						<?php ieverly_the_theme_svg( 'storeys', 'ui' ); ?>
						<span><?php echo esc_attr( $floors ); ?></span>
					</div>
				<?php }; ?>

				<?php if ( $beds ) { ?>
					<div class="property__info-box beds">
						<?php ieverly_the_theme_svg( 'beds', 'ui' ); ?>
						<span><?php echo esc_attr( $beds ); ?></span>
					</div>
				<?php }; ?>

				<?php if ( $area ) { ?>
					<div class="property__info-box area">
						<?php ieverly_the_theme_svg( 'area', 'ui' ); ?>
						<span><?php echo esc_attr( $area ); ?><?php echo esc_attr( get_theme_mod( 'area' ) ); ?></span>
					</div>
				<?php }; ?>

				<?php if ( $area_land ) { ?>
					<div class="property__info-box area-land">
						<?php ieverly_the_theme_svg( 'area-land', 'ui' ); ?>
						<span><?php echo esc_attr( $area_land ); ?><?php echo esc_attr( get_theme_mod( 'area' ) ); ?></span>
					</div>
				<?php }; ?>
			</div>
		</footer>
	</article>
</div>
