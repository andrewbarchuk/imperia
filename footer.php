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

					<div class="site__footer-copyright">
						<span class="name">© <b><?php echo get_bloginfo( 'name' ); ?></b>, <?php echo date( 'Y' ); ?></span>
					</div>

					<nav class="site__footer-menu site__social-menu">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'social',
							)
						);
						?>
					</nav>
				</div>
			</div>
		</div>
	</div>
</footer>
</div>

<?php wp_footer(); ?>

</body>
</html>
