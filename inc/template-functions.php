<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package ieverly
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function ieverly_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'ieverly_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function ieverly_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'ieverly_pingback_header' );

/**
 * Add Read More button
 */
function modify_read_more_link() {
	return '<a class="more-link" href="' . get_permalink() . '">' . __( 'Read post', 'ieverly' ) . '</a>';
}
add_filter( 'the_content_more_link', 'modify_read_more_link' );

/**
 * Add custom gallery support
 */
function meta_boxes() {
	wp_enqueue_script( 'jquery-ui-core' );
	wp_enqueue_script( 'jquery-ui-widget' );
	wp_enqueue_script( 'jquery-ui-sortable' );

	if ( ! did_action( 'wp_enqueue_media' ) ) {
		wp_enqueue_media();
	}

	wp_enqueue_script( 'myuploadscript', get_stylesheet_directory_uri() . '/js/meta-box.js', array( 'jquery' ), IEVERLY_VERSION );
}
add_action( 'admin_enqueue_scripts', 'meta_boxes' );

/**
 * Sidebars
 */
function position_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Language switcher', 'ieverly' ),
			'id'            => 'language',
			'before_widget' => '<nav id="%1$s" class="widget language__swithcer %2$s">',
			'after_widget'  => '</nav>',
			'before_title'  => '',
			'after_title'   => '',
		)
	);
}
add_action( 'widgets_init', 'position_widgets_init' );
