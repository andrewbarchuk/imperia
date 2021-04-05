<?php
/**
 * Template part for displaying home last portfolio
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ieverly
 */

$home_portfolio_title = get_post_meta( $post->ID, 'home_portfolio_title', true );
?>

<section class="home-portfolio content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="home-portfolio__title">
					<h3 class="back-text"><?php echo esc_html( $home_portfolio_title ); ?></h3>

					<nav class="home-portfolio__tags">
						<?php
						$portfolio_tags = get_terms( array( 'taxonomy' => 'portfolio-tag' ) );

						if ( $portfolio_tags ) {
							echo '<button class="active button" data-filter="*">' . esc_html__( 'All', 'ieverly' ) . '</button>';
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
			$portfolio_query = new WP_Query(
				array(
					'post_type'      => 'portfolio',
					'tax_query'      => array(
						'relation' => 'OR',
						array(
							'taxonomy' => 'portfolio-tag',
							'operator' => 'EXISTS',
						),
					),
					'meta_query'     => array(
						array(
							'key'   => 'portfolio_home_check',
							'value' => 'on',
						),
					),
					'orderby'        => 'menu_order',
					'order'          => 'ASC',
					'posts_per_page' => '-1',
				)
			);
			if ( $portfolio_query->have_posts() ) :
				while ( $portfolio_query->have_posts() ) :
					$portfolio_query->the_post();
					get_template_part( 'template-parts/home/home-portfolio-item', get_post_format() );
				endwhile;
			else :
				get_template_part( 'template-parts/not-found', get_post_format() );
			endif;

			wp_reset_postdata();
			?>

			<div class="portfolio__item portfolio__link">
				<a href="<?php echo esc_html( get_permalink( get_page_by_path( 'portfolio-page' ) ) ); ?>"><?php esc_html_e( 'View all cases', 'ieverly' ); ?><?php ieverly_the_theme_svg( 'arrow-right', 'ui' ); ?></a>
			</div>
		</div>

	</div>
</section>
