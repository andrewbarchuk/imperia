<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- content -->
<section <?php post_class( 'property prop-with-filter archive content' ); ?>>
	<div class="container">
		<form id="prop_filters" action="#">
			<div class="row">
				<div class="col-lg-4">
					<?php require 'filter.php'; ?>
				</div>
				<div class="col-lg-8 on-over on-result">
					<div class="prop-sort">
						<div class="prop-sort-info">
							<div id="prop-found-posts"><?php echo $wp_query->found_posts; ?></div><?php _e( 'listings found', 'restate' ); ?>
						</div>
						<?php require 'sort.php'; ?>
					</div>

					<!-- render -->
					<div id="prop_posts_wrap" class="row">
						<?php
						if ( $wp_query->have_posts() ) :
							while ( $wp_query->have_posts() ) :
								$wp_query->the_post();
								get_template_part( 'template-parts/property/item', get_post_format() );
								endwhile;
							else :
								get_template_part( 'template-parts/notfound', get_post_format() );
							endif;
							?>
					</div>

					<script>
						var ajaxurl = '<?php echo site_url(); ?>/wp-admin/admin-ajax.php';
						var posts = '<?php echo addslashes( wp_json_encode( $wp_query->query_vars ) ); ?>';
						var current_page = "<?php echo $wp_query->query_vars['paged'] ? $wp_query->query_vars['paged'] : 1; ?>";
						var max_page = '<?php echo $wp_query->max_num_pages; ?>';
					   </script>

					<?php 
					if ( $wp_query->max_num_pages > 1 ) :
						echo '<div id="prop_loadmore" data-loading="' . __( 'Loading...', 'restate' ) . '" class="loadmore">' . __( 'Load more', 'restate' ) . '</div>';
						endif;
						wp_reset_postdata();
					?>
				</div>
			</div>

			<!-- required hidden field for admin-ajax.php -->
			<input type="hidden" name="action" value="propfilter" />
		</form>
	</div>
</section>
