<?php
/**
 * Template part for displaying home history box
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ieverly
 */

$history_title          = get_post_meta( $post->ID, 'history_title', true );
$history_image_id       = get_post_meta( $post->ID, 'history_image', true );
$history_image          = wp_get_attachment_url( $history_image_id );
$history_portfolio_desc = get_post_meta( $post->ID, 'history_portfolio_desc', true );
?>

<section id="history" class="history home-history">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-7 col-md-7">
				<div class="history__description">
					<div class="history__description-in">
						<?php ieverly_the_theme_svg( 'crown', 'ui' ); ?>
						<h3 class="back-text"><?php echo esc_html( $history_title ); ?></h3>
						<div class="entry-content">
							<?php the_content(); ?>
						</div>
					</div>
				</div>
			</div>

			<div class="col-lg-5 col-md-5 no-padding">
				<div class="history__portfolio">
					<div class="history__portfolio-box" data-to="50%">
						<span><?php echo esc_html( $history_portfolio_desc ); ?></span>
						<a href="<?php echo esc_html( get_permalink( get_page_by_path( 'portfolio-page' ) ) ); ?>"><?php esc_html_e( 'Portfolio', 'ieverly' ); ?><?php ieverly_the_theme_svg( 'arrow-right', 'ui' ); ?></a>
					</div>
					<div class="history__background">
						<img at="My history" loading="lazy" src="<?php echo esc_html( $history_image ); ?>">
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
