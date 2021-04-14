<?php
/**
 * Ieverly Theme Property search
 *
 * @package ieverly
 */

// price
$prices        = property_get_max_min_price();
$min_price_new = 0;
$max_price_new = 10;
if (!empty($prices)) {
	$min_price_new = min($prices);
	if (isset($_GET['min-price'])) {
		$min_price_new = $_GET['min-price'];
	}
	$max_price_new = max($prices);
	if (isset($_GET['max-price'])) {
		$max_price_new = $_GET['max-price'];
	}
}

// area
$areas        = property_get_max_min_area();
$min_area_new = 0;
$max_area_new = 10;
if (!empty($areas)) {
	$min_area_new = min($areas);
	if (isset($_GET['min-area'])) {
		$min_area_new = $_GET['min-area'];
	}
	$max_area_new = max($areas);
	if (isset($_GET['max-area'])) {
		$max_area_new = $_GET['max-area'];
	}
}
?>
<!-- search -->
<div class="property__search-box">
	<form class="search" action="<?php echo get_post_type_archive_link('property'); ?>" method="get">
		<div class="property__search-form">
			<!-- ref -->
			<div class="filter__item ref">
				<label><?php esc_html_e('REF', 'ieverly'); ?></label>
				<input type="text" name="keyword" class="inp inp-keyword" id="keyword-txt" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>" placeholder="<?php esc_attr_e('id', 'ieverly'); ?>" />
			</div>

			<!-- price -->
			<div class="filter__item price">
				<label><?php esc_html_e('Price', 'ieverly'); ?> (<?php echo get_theme_mod('currency'); ?>)</label>
				<div class="filter-fx">
					<div class="double-init-box">
						<input type="number" placeholder="<?php echo esc_attr(min($prices)); ?>" min="<?php echo esc_attr(min($prices)); ?>" value="<?php echo isset($_GET['min-price']) ? $_GET['min-price'] : ''; ?>" max="<?php echo esc_attr(max($prices)); ?>" class="inprange inprange-min range-price" name="min-price" id="min-price" />
					</div>
					<span>-</span>
					<div class="double-init__box">
						<input type="number" placeholder="<?php echo esc_attr(max($prices)); ?>" min="<?php echo esc_attr(min($prices)); ?>" value="<?php echo isset($_GET['max-price']) ? $_GET['max-price'] : ''; ?>" max="<?php echo esc_attr(max($prices)); ?>" class="inprange inprange-max range-price" name="max-price" id="max-price" />
					</div>
				</div>
			</div>

			<!-- area range -->
			<div class="filter__item area">
				<label><?php esc_html_e('Area', 'ieverly'); ?> (<?php echo get_theme_mod('area'); ?>)</label>
				<div class="filter-fx">
					<div class="double-init-box">
						<input type="number" placeholder="<?php echo esc_attr(min($areas)); ?>" min="<?php echo esc_attr(min($areas)); ?>" value="<?php echo isset($_GET['max-area']) ? $_GET['max-area'] : ''; ?>" max="<?php echo esc_attr(max($areas)); ?>" class="inprange inprange-min range-area" name="min-area" id="min-area" />
					</div>
					<span>-</span>
					<div class="double-init-box">
						<input type="number" placeholder="<?php echo esc_attr(max($areas)); ?>" min="<?php echo esc_attr(min($areas)); ?>" value="<?php echo isset($_GET['max-area']) ? $_GET['max-area'] : ''; ?>" max="<?php echo esc_attr(max($areas)); ?>" class="inprange inprange-max range-area" name="max-area" id="max-area" />
					</div>
				</div>
			</div>

			<!-- city -->
			<div class="filter__item city">
				<label for="select-city"><?php esc_html_e('Location', 'ieverly'); ?></label>
				<select name="property-city" id="select-city" class="search-select">
					<?php advance_search_options('property-city', __('Select location', 'ieverly')); ?>
				</select>
			</div>

			<!-- beds -->
			<div class="filter__item beds">
				<label for="select-bedrooms"><?php esc_html_e('Min beds', 'ieverly'); ?></label>
				<select name="bedrooms" id="select-bedrooms" class="search-select">
					<?php numbers_list('bedrooms', ''); ?>
				</select>
			</div>

			<!-- search btn -->
			<div class="filter__item submit">
				<input class="button__search button__accent" type="submit" value="<?php _e('Find properties', 'ieverly'); ?>">
			</div>
		</div>
	</form>
</div>