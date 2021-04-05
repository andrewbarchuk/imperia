<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package ieverly
 */

get_header();
?>

	<main id="primary" class="site-main content">

		<section class="error-404 not-found">
			<div class="container">
				<div class="row">
					<div class="col-lg-8 offset-lg-2">
						<header class="page-header">
							<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'ieverly' ); ?></h1>
						</header><!-- .page-header -->

						<div class="page-content">
							<p><?php esc_html_e( 'It looks like nothing was found at this location.', 'ieverly' ); ?></p>
						</div><!-- .page-content -->
					</div>
				</div>
			</div>
		</section><!-- .error-404 -->

	</main><!-- #main -->

<?php
get_footer();
