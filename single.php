<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package ieverly
 */

get_header();
?>

<main id="primary" class="site-main content">
	<div class="container">
		<div class="row">
			<div class="col-md-8 offset-md-2">
				<?php
				while (have_posts()) :
					the_post();

					get_template_part('template-parts/content', get_post_type());
					the_post_navigation(
						array(
							'prev_text' => '<i></i><p><span class="nav-subtitle">' . esc_html__('Preview Post', 'ieverly') . '</span> <span class="nav-title">%title</span></p>',
							'next_text' => '<i></i><p><span class="nav-subtitle">' . esc_html__('Next Post', 'ieverly') . '</span> <span class="nav-title">%title</span></p>',
						)
					);

				endwhile; // End of the loop.
				?>
			</div>
		</div>
	</div>
</main><!-- #main -->

<?php
get_footer();
