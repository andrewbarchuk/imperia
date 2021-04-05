<?php
/*
Template Name: Portfolio
*/

/**
 * 
 * The template for displaying portfolio
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ieverly
 */

get_header();
?>

<section class="home-portfolio content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="home-portfolio__title">
					<h3 class="back-text"><?php single_post_title(); ?></h3>

					<nav class="home-portfolio__tags">
						<?php
						$portfolio_tags = get_terms( array( 'taxonomy' => 'portfolio-tag' ) );

						if ( $portfolio_tags ) {
							echo '<button class="active button" data-filter="*">' . __( 'All', 'ieverly' ) . '</button>';
							foreach ( $portfolio_tags as $tag ) {
								echo '<button class="button" data-filter=".' . $tag->slug . '">' . $tag->name . '</button>';
							}
						}
						?>
					</nav>
				</div>
			</div>
		</div>

		<div class="home-portfolio__list">
			<div class="grid-sizer"></div>
			<?php
			global $wp_query;
			$wp_query = new WP_Query(
				array(
					'post_type'      => 'portfolio',
					'tax_query'      => array(
						'relation' => 'OR',
						array(
							'taxonomy' => 'portfolio-tag',
							'operator' => 'EXISTS',
						),
					),
					'orderby'        => 'menu_order',
					'order'          => 'ASC',
					'posts_per_page' => '-1',
				)
			);
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/home/home-portfolio-item', get_post_format() );
				endwhile;
			else :
				get_template_part( 'template-parts/not-found', get_post_format() );
			endif;
			?>
		</div>

	</div>
</section>

<?php
get_footer();
