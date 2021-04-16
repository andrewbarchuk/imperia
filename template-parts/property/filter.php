<?php

/**
 * Ieverly Theme Property filter
 *
 * @package ieverly
 */

/* price */
$prices        = property_get_max_min_price();
$min_price_new = 0;
$max_price_new = 10;
if ( ! empty( $prices ) ) {
	$min_price_new = min( $prices );
	if ( isset( $_GET['min-price'] ) ) {
		$min_price_new = $_GET['min-price'];
	}
	$max_price_new = max( $prices );
	if ( isset( $_GET['max-price'] ) ) {
		$max_price_new = $_GET['max-price'];
	}
}

/* area */
$areas        = property_get_max_min_area();
$min_area_new = 0;
$max_area_new = 10;
if ( ! empty( $areas ) ) {
	$min_area_new = min( $areas );
	if ( isset( $_GET['min-area'] ) ) {
		$min_area_new = $_GET['min-area'];
	}
	$max_area_new = max( $areas );
	if ( isset( $_GET['max-area'] ) ) {
		$max_area_new = $_GET['max-area'];
	}
}
?>
<div class="filter__box">
	<!-- show/hide button -->
	<button type="button" class="button__show-filter button__accent" aria-controls="filter-menu" aria-expanded="false" data-text="<?php esc_html_e( 'Show filter', 'ieverly' ); ?>" data-hide="✕">
		<?php esc_html_e( 'Show filter', 'ieverly' ); ?>
	</button>

	<div class="filter__list">
		<!-- ref -->
		<div class="filter__item ref">
			<label><?php esc_html_e( 'REF', 'ieverly' ); ?></label>
			<input type="text" name="keyword" class="inp-keyword" id="keyword-txt" value="<?php echo isset( $_GET['keyword'] ) ? $_GET['keyword'] : ''; ?>" placeholder="<?php esc_attr_e( 'id', 'ieverly' ); ?>" />
		</div>

		<!-- price -->
		<div class="filter__item price">
			<label><?php esc_html_e( 'Price', 'ieverly' ); ?> (<?php echo get_theme_mod( 'currency' ); ?>)</label>
			<div class="filter-fx">
				<div class="double-init-box">
					<input type="number" placeholder="<?php echo esc_attr( min( $prices ) ); ?>" min="<?php echo esc_attr( min( $prices ) ); ?>" value="<?php echo isset( $_GET['min-price'] ) ? $_GET['min-price'] : ''; ?>" max="<?php echo esc_attr( max( $prices ) ); ?>" class="inprange inprange-min range-price" name="min-price" id="min-price" />
				</div>
				<span>-</span>
				<div class="double-init__box">
					<input type="number" placeholder="<?php echo esc_attr( max( $prices ) ); ?>" min="<?php echo esc_attr( min( $prices ) ); ?>" value="<?php echo isset( $_GET['max-price'] ) ? $_GET['max-price'] : ''; ?>" max="<?php echo esc_attr( max( $prices ) ); ?>" class="inprange inprange-max range-price" name="max-price" id="max-price" />
				</div>
			</div>
		</div>

		<!-- area range -->
		<div class="filter__item area">
			<label><?php esc_html_e( 'Area', 'ieverly' ); ?> (<?php echo get_theme_mod( 'area' ); ?>)</label>
			<div class="filter-fx">
				<div class="double-init-box">
					<input type="number" placeholder="<?php echo esc_attr( min( $areas ) ); ?>" min="<?php echo esc_attr( min( $areas ) ); ?>" value="<?php echo isset( $_GET['max-area'] ) ? $_GET['max-area'] : ''; ?>" max="<?php echo esc_attr( max( $areas ) ); ?>" class="inprange inprange-min range-area" name="min-area" id="min-area" />
				</div>
				<span>-</span>
				<div class="double-init-box">
					<input type="number" placeholder="<?php echo esc_attr( max( $areas ) ); ?>" min="<?php echo esc_attr( min( $areas ) ); ?>" value="<?php echo isset( $_GET['max-area'] ) ? $_GET['max-area'] : ''; ?>" max="<?php echo esc_attr( max( $areas ) ); ?>" class="inprange inprange-max range-area" name="max-area" id="max-area" />
				</div>
			</div>
		</div>

		<!-- status -->
		<div class="filter__item status">
			<label for="select-status"><?php esc_html_e( 'Status', 'ieverly' ); ?></label>
			<select name="property-status" id="select-status" class="search-select">
				<?php advance_search_options( 'property-status', __( 'Select status', 'ieverly' ) ); ?>
			</select>
		</div>

		<!-- type -->
		<div class="filter__item type">
			<label for="select-type"><?php esc_html_e( 'Type', 'ieverly' ); ?></label>
			<select name="property-type" id="select-type" class="search-select">
				<?php advance_search_options( 'property-type', __( 'Select type', 'ieverly' ) ); ?>
			</select>
		</div>

		<!-- city -->
		<div class="filter__item city">
			<label for="select-city"><?php esc_html_e( 'Location', 'ieverly' ); ?></label>
			<select name="property-city" id="select-city" class="search-select">
				<?php advance_search_options( 'property-city', __( 'Select location', 'ieverly' ) ); ?>
			</select>
		</div>

		<!-- state -->
		<div class="filter__item state">
			<label for="select-state"><?php esc_html_e( 'State', 'ieverly' ); ?></label>
			<select name="property-state" id="select-state" class="search-select">
				<?php advance_search_options( 'property-state', __( 'Select state', 'ieverly' ) ); ?>
			</select>
		</div>

		<!-- kitchen -->
		<div class="filter__item kitchen">
			<label for="select-kitchen"><?php esc_html_e( 'Kitchen', 'ieverly' ); ?></label>
			<select name="property-kitchen" id="select-kitchen" class="search-select">
				<?php advance_search_options( 'property-kitchen', __( 'Select kitchen', 'ieverly' ) ); ?>
			</select>
		</div>

		<!-- beds -->
		<div class="filter__item beds">
			<label for="select-bedrooms"><?php esc_html_e( 'Min beds', 'ieverly' ); ?></label>
			<select name="bedrooms" id="select-bedrooms" class="search-select">
				<?php numbers_list( 'bedrooms', '' ); ?>
			</select>
		</div>

		<!-- baths -->
		<div class="filter__item baths">
			<label for="select-bathrooms"><?php esc_html_e( 'Min baths', 'ieverly' ); ?></label>
			<select name="bathrooms" id="select-bathrooms" class="search-select">
				<?php numbers_list( 'bathrooms', '' ); ?>
			</select>
		</div>

		<!-- features -->
		<div class="filter__item features">
			<label><?php esc_html_e( 'Features', 'ieverly' ); ?></label>
			<div class="features__list">
				<?php advance_features_options( 'property-feature' ); ?>
			</div>
		</div>

		<!-- search -->
		<div class="filter__item search">
			<button type="button" class="button__search button__accent"><?php esc_html_e( 'Search', 'ieverly' ); ?></button>
			<button class="button__reset button__accent" type="button"><?php esc_html_e( 'Reset', 'ieverly' ); ?></button>
		</div>
	</div>
</div>
