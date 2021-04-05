<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ieverly
 */

?>

<footer id="colophon" class="site__footer content">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="site__footer-box">
					<div class="site__footer-branding">
						<?php the_custom_logo(); ?>
					</div>

					<nav class="site__footer-menu hero__social-menu">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'social',
							)
						);
						?>
					</nav>

					<div class="site__footer-copyright">
						<span class="name">© <b><?php echo get_bloginfo( 'name' ); ?></b>, <?php echo date( 'Y' ); ?></span>
						<span class="description"><?php esc_html_e( 'All rights reserved.', 'ieverly' ); ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
</div>

<?php wp_footer(); ?>

</body>
</html>
