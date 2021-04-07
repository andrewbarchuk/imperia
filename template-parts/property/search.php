<?php 
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<!-- search -->	
<div class="search-over hidden">					    
	<form class="search" action="<?php echo get_post_type_archive_link('property'); ?>" method="get">
		<div class="search-form">
			<!-- city -->
			<div class="filter-item city">
	            <label for="select-city"><?php esc_html_e('Location', 'restate'); ?></label>
	            <span class="selectwrap">
				<select name="property-city" id="select-city" class="search-select">
	                <?php advance_search_options('property-city', __('Select location', 'restate')); ?>
	            </select>
				</span>
			</div>

			<!-- status -->
			<div class="filter-item status">
	            <label for="select-status"><?php esc_html_e('Status', 'restate'); ?></label>
				<span class="selectwrap">
				<select name="property-status" id="select-status" class="search-select">
	                <?php advance_search_options('property-status', __('Select status', 'restate')); ?>
	            </select>
				</span>
			</div>

			<!-- type -->
			<div class="filter-item type">
	            <label for="select-type"><?php esc_html_e('Type', 'restate'); ?></label>
				<span class="selectwrap">
				<select name="property-type" id="select-type" class="search-select">
	                <?php advance_search_options('property-type', __('Select type', 'restate')); ?>
	            </select>
				</span>
			</div>

			<!-- search btn -->
			<div class="filter-item submit">
				<input class="inpbut btn" type="submit" value="<?php _e('Find properties', 'restate'); ?>">
			</div>
		</div>
	</form>
</div>