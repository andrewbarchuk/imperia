<?php

/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ieverly
 */

get_header();
include ('template-parts/property/content.php');
?>

<main id="primary" class="site-main content property-list">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 offset-lg-2">
				<?php if (have_posts()) : ?>

					<header class="page-header">
						<?php
						the_archive_title('<h1 class="page-title">', '</h1>');
						the_archive_description('<div class="archive-description">', '</div>');
						?>
					</header><!-- .page-header -->

                    <?php

				endif;
				?>
			</div>
		</div>
	</div>
</main><!-- #main -->

<?php
get_footer();
