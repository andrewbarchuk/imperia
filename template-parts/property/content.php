<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

// search query
$search_args = array(
    'post_type' => 'property',
    //'orderby' => array('meta_value_num' => 'DESC', 'date' => 'DESC'),
);
$search_args = apply_filters('property_get_search_parameters', $search_args);
global $search_query;
$search_query = new WP_Query( $search_args );
?>


<section class="property content">
	<div class="container">
		<!-- start form -->
		<form id="property__filter" action="#">

			<!-- filter -->
			<?php include ('filter.php'); ?>

			<!-- sort -->
			<div class="property__sort">
				<div class="property__sort-info">
					<div id="property__found-posts"><?php echo $search_query->found_posts; ?></div><?php esc_html_e('listings found', 'ieverly'); ?>
				</div>
				<?php include ('sort.php'); ?>
			</div>

			<!-- required hidden field for admin-ajax.php -->
			<input type="hidden" name="action" value="property__filter" />
		</form>

		<!-- property items -->
		<div id="property__items" class="row">
			<?php
				if ( $search_query->have_posts() ) :
					while ( $search_query->have_posts() ) :
						$search_query->the_post();
						get_template_part('template-parts/property/item', get_post_format());
					endwhile;
				else:
					get_template_part('template-parts/notfound', get_post_format());
				endif;
			?>
		</div>

		<script>
			var ajaxurl = '<?php echo site_url() ?>/wp-admin/admin-ajax.php';
			var posts = '<?php echo addslashes(wp_json_encode($search_query->query_vars)); ?>';
			var current_page = "<?php echo $search_query->query_vars['paged'] ? $search_query->query_vars['paged'] : 1; ?>";
			var max_page = '<?php echo $search_query->max_num_pages; ?>';
		</script>

		<?php 
			if (  $search_query->max_num_pages > 1 ) :
				echo '<div id="property__loadmore" data-loading="'. __('Loading...', 'ieverly') .'" class="loadmore">'. __('Load more', 'ieverly') .'</div>';
			endif;
			wp_reset_postdata();
		?>
	</div>
</section>