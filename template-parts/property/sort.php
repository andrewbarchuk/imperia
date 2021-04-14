<?php
/**
 * Ieverly Theme Property sort
 *
 * @package ieverly
 */

?>
<div class="property__sort-items">
	<!-- number of results -->
	<div class="property__number-results property__sort-item">
		<label for="property_number_of_results"><?php esc_html_e( 'Per page', 'ieverly' ); ?></label>
		<select name="property_number_of_results" id="property_number_of_results">
			<?php count_list( 'property_number_of_results' ); ?>
		</select>
	</div>

	<!-- order by -->
	<div class="property__order-by property__sort-item">
		<label for="property_order_by"><?php esc_html_e( 'Order', 'ieverly' ); ?></label>
		<select name="property_order_by" id="property_order_by">
			<?php order_list( 'property_order_by' ); ?>
		</select>
	</div>
</div>

<div class="sort-hidden">
	<?php
	esc_html_e( 'date-DESC', 'ieverly' );
	esc_html_e( 'date-ASC', 'ieverly' );
	esc_html_e( 'meta_value_num-DESC-price', 'ieverly' );
	esc_html_e( 'meta_value_num-ASC-price', 'ieverly' );
	esc_html_e( 'meta_value_num-DESC-area', 'ieverly' );
	esc_html_e( 'meta_value_num-ASC-area', 'ieverly' );
	?>
</div>
