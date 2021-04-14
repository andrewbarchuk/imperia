<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ieverly
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'item__full-clean content' ); ?>>
	<div class="container">
		<div class="row">
			<div class="col-md-10 offset-md-1">
				<div class="entry-content">
					<?php the_content(); ?>
				</div><!-- .entry-content -->
			</div>
		</div>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
