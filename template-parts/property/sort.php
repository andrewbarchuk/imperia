<?php 
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="property__sort-items">
	<!-- number of results -->
	<div class="property__number-results">
		<label for="property_number_of_results"><?php _e('Per page', 'ieverly'); ?></label>
		<select name="property_number_of_results" id="property_number_of_results">
			<?php count_list('property_number_of_results'); ?>
		</select>
	</div>
 
 	<!-- order by -->
 	<div class="property__order-by">
		<label for="property_order_by"><?php _e('Order', 'ieverly'); ?></label>
		<select name="property_order_by" id="property_order_by">
			<?php order_list('property_order_by'); ?>
		</select>
	</div>
</div>