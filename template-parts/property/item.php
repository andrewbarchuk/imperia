<?php
/**
 * Ieverly Theme Property item
 *
 * @package ieverly
 */

$ref = get_post_meta($post->ID, 'ref', true);
$price = get_post_meta($post->ID, 'price', true);
$area = get_post_meta($post->ID, 'area', true);
$area_land = get_post_meta($post->ID, 'area_land', true);

$beds = get_post_meta($post->ID, 'beds', true);
$floors = get_post_meta($post->ID, 'floors', true);

$property_type = wp_get_post_terms($post->ID, 'property-type');

if (has_post_thumbnail()) {
	$item__imgurl = get_the_post_thumbnail_url(get_the_ID(), 'medium');
} else {
	$item__imgurl = get_template_directory_uri() . '/assets/dist/img/img-default.png';
}
?>

<div class="col-xl-3 col-lg-4 col-md-6">
	<article <?php post_class('property__item'); ?>>
		<a rel="bookmark" arial-label="<?php echo get_the_title(); ?>" class="property__item-link" href="<?php echo get_permalink($post->ID); ?>"></a>

		<header class="property__item-header">
			<div class="property__item-badge">
				<?php if (get_post_meta($post->ID, 'reserved', true) == 'on') {
					echo '<div class="badge badge__reserved">' . __("Reserved", "ieverly") . '</div>';
				} elseif (get_post_meta($post->ID, 'sold_out', true) == 'on') {
					echo '<div class="badge badge__sold-out">' . __("Sold out", "ieverly") . '</div>';
				} ?>
				<?php if (has_term(array(315, 316, 317), 'property-building')) {
					echo '<div class="badge badge__new-building">' . __("New building", "ieverly") . '</div>';
				} ?>
			</div>
			<img loading="lazy" src="<?php esc_html_e($item__imgurl); ?>" alt="<?php echo get_the_title(); ?>">
		</header>

		<main>
			<?php if ($ref) { ?>
				<p class="ref"><b>REF:</b> <?php esc_html_e($ref); ?></p>
			<?php }; ?>
			<h4>
				<?php
					foreach ($property_type as $property_type_slug) {
						echo $property_type_slug->name . ' ';
					}
					echo get_the_title();
				?>
			</h4>
			<p class="property__item-price price-replace"><?php esc_html_e(get_theme_mod('currency')); ?><?php esc_html_e($price); ?></p>
		</main>

		<footer>
			<div class="property__info-list">
				<?php if ($floors) { ?>
					<div class="property__info-box storeys">
						<?php ieverly_the_theme_svg('storeys', 'ui'); ?>
						<span><?php esc_html_e($floors); ?></span>
					</div>
				<?php }; ?>

				<?php if ($beds) { ?>
					<div class="property__info-box beds">
						<?php ieverly_the_theme_svg('beds', 'ui'); ?>
						<span><?php esc_html_e($beds); ?></span>
					</div>
				<?php }; ?>

				<?php if ($area) { ?>
					<div class="property__info-box area">
						<?php ieverly_the_theme_svg('area', 'ui'); ?>
						<span><?php esc_html_e($area); ?><?php esc_html_e(get_theme_mod('area')); ?></span>
					</div>
				<?php }; ?>

				<?php if ($area_land) { ?>
					<div class="property__info-box area-land">
						<?php ieverly_the_theme_svg('area-land', 'ui'); ?>
						<span><?php esc_html_e($area_land); ?><?php esc_html_e(get_theme_mod('area')); ?></span>
					</div>
				<?php }; ?>
			</div>
		</footer>
	</article>
</div>