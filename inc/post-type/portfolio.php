<?php
/**
 * Ieverly portfolio post-type
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ieverly
 */

function portfolio() {
	$labels = array(
		'name'               => esc_html__( 'Portfolio', 'ieverly' ),
		'singular_name'      => esc_html__( 'Portfolio', 'ieverly' ),
		'add_new'            => esc_html__( 'Add New', 'ieverly' ),
		'add_new_item'       => esc_html__( 'Add New case', 'ieverly' ),
		'edit_item'          => esc_html__( 'Edit case', 'ieverly' ),
		'new_item'           => esc_html__( 'New case', 'ieverly' ),
		'view_item'          => esc_html__( 'View case', 'ieverly' ),
		'search_items'       => esc_html__( 'Search case', 'ieverly' ),
		'not_found'          => esc_html__( 'No case found', 'ieverly' ),
		'not_found_in_trash' => esc_html__( 'No case found in Trash', 'ieverly' ),
		'parent_item_colon'  => '',
	);
	
	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'query_var'          => true,
		'show_in_menu'       => true,
		'has_archive'        => true,
		'show_in_nav_menus'  => false,
		'capability_type'    => 'post',
		'hierarchical'       => true,
		'menu_icon'          => 'dashicons-portfolio',
		'menu_position'      => 20,
		'supports'           => array( 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes' ),
		'taxonomies'         => array( 'portfolio-tag' ),
	);

	$tag_labels = array(
		'name'                       => esc_html__( 'Portfolio tag', 'ieverly' ),
		'singular_name'              => esc_html__( 'portfolio tag', 'ieverly' ),
		'search_items'               => esc_html__( 'Search portfolio tags', 'ieverly' ),
		'popular_items'              => esc_html__( 'Popular portfolio tags', 'ieverly' ),
		'all_items'                  => esc_html__( 'All portfolio tags', 'ieverly' ),
		'parent_item'                => esc_html__( 'Parent portfolio tag', 'ieverly' ),
		'parent_item_colon'          => esc_html__( 'Parent portfolio tag:', 'ieverly' ),
		'edit_item'                  => esc_html__( 'Edit portfolio tag', 'ieverly' ),
		'update_item'                => esc_html__( 'Update portfolio tag', 'ieverly' ),
		'add_new_item'               => esc_html__( 'Add New portfolio tag', 'ieverly' ),
		'new_item_name'              => esc_html__( 'New portfolio tag Name', 'ieverly' ),
		'separate_items_with_commas' => esc_html__( 'Separate portfolio tags with commas', 'ieverly' ),
		'add_or_remove_items'        => esc_html__( 'Add or remove portfolio tags', 'ieverly' ),
		'choose_from_most_used'      => esc_html__( 'Choose from the most used portfolio tags', 'ieverly' ),
		'menu_name'                  => esc_html__( 'Portfolio tags', 'ieverly' ),
	);
  
	register_taxonomy(
		'portfolio-tag', 
		'portfolio',
		array(
			'hierarchical'          => true,
			'labels'                => $tag_labels,
			'show_ui'               => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var'             => true,
			'show_in_rest'          => true,
			'publicly_queryable'    => false,
			'show_in_nav_menus'     => false,
		)
	);
	
	register_post_type( 'portfolio', $args );
}
add_action( 'init', 'portfolio' );


// $MY_POST_TYPE = "portfolio"; // just for a showcase

// // the basic support (menu_order is included in the page-attributes)
// add_post_type_support($MY_POST_TYPE, 'page-attributes');

// // add a column to the post type's admin
// // basically registers the column and sets it's title
// add_filter('manage_' . $MY_POST_TYPE . '_posts_columns', function ($columns) {
// $columns['menu_order'] = "Order"; //column key => title
// return $columns;
// });

// // display the column value
// add_action( 'manage_' . $MY_POST_TYPE . '_posts_custom_column', function ($column_name, $post_id){
// if ($column_name == 'menu_order') {
// echo get_post($post_id)->menu_order;
// }
// }, 10, 2); // priority, number of args - MANDATORY HERE! 

// // make it sortable
// $menu_order_sortable_on_screen = 'edit-' . $MY_POST_TYPE; // screen name of LIST page of posts
// add_filter('manage_' . $menu_order_sortable_on_screen . '_sortable_columns', function ($columns){
// column key => Query variable
// menu_order is in Query by default so we can just set it
// $columns['menu_order'] = 'menu_order';
// return $columns;
// });
