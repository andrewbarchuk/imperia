<?php
/**
 * Ieverly Theme property post-type
 *
 * @package ieverly
 */

if ( ! function_exists( 'ieverly_property' ) ) {
	function ieverly_property() {
		$labels = array(
			'name'               => esc_html__( 'Properties', 'ieverly' ),
			'singular_name'      => esc_html__( 'Property', 'ieverly' ),
			'add_new'            => esc_html__( 'Add New', 'ieverly' ),
			'add_new_item'       => esc_html__( 'Add New Property', 'ieverly' ),
			'edit_item'          => esc_html__( 'Edit Property', 'ieverly' ),
			'new_item'           => esc_html__( 'New Property', 'ieverly' ),
			'view_item'          => esc_html__( 'View Property', 'ieverly' ),
			'search_items'       => esc_html__( 'Search Property', 'ieverly' ),
			'not_found'          => esc_html__( 'No Property found', 'ieverly' ),
			'not_found_in_trash' => esc_html__( 'No Property found in Trash', 'ieverly' ),
			'parent_item_colon'  => '',
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'query_var'          => true,
			'show_in_menu'       => true,
			'has_archive'        => true,
			'show_in_nav_menus'  => true,
			'capability_type'    => 'post',
			'hierarchical'       => true,
			'menu_icon'          => 'dashicons-building',
			'menu_position'      => 20,
			'supports'           => array( 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes' ),
		);

		register_post_type( 'property', $args );
	}
	add_action( 'init', 'ieverly_property' );
}

/**
 * Create Property Taxonomies 
 */
if ( ! function_exists( 'ieverly_build_taxonomies' ) ) {
	function ieverly_build_taxonomies() {
		$labels = array(
			'name'                       => esc_html__( 'Property Features', 'ieverly' ),
			'singular_name'              => esc_html__( 'Property Features', 'ieverly' ),
			'search_items'               => esc_html__( 'Search Property Features', 'ieverly' ),
			'popular_items'              => esc_html__( 'Popular Property Features', 'ieverly' ),
			'all_items'                  => esc_html__( 'All Property Features', 'ieverly' ),
			'parent_item'                => esc_html__( 'Parent Property Feature', 'ieverly' ),
			'parent_item_colon'          => esc_html__( 'Parent Property Feature:', 'ieverly' ),
			'edit_item'                  => esc_html__( 'Edit Property Feature', 'ieverly' ),
			'update_item'                => esc_html__( 'Update Property Feature', 'ieverly' ),
			'add_new_item'               => esc_html__( 'Add New Property Feature', 'ieverly' ),
			'new_item_name'              => esc_html__( 'New Property Feature Name', 'ieverly' ),
			'separate_items_with_commas' => esc_html__( 'Separate Property Features with commas', 'ieverly' ),
			'add_or_remove_items'        => esc_html__( 'Add or remove Property Features', 'ieverly' ),
			'choose_from_most_used'      => esc_html__( 'Choose from the most used Property Features', 'ieverly' ),
			'menu_name'                  => esc_html__( 'Property Features', 'ieverly' ),
		);

		register_taxonomy(
			'property-feature',
			'property',
			array(
				'hierarchical'       => true,
				'labels'             => $labels,
				'show_ui'            => true,
				'query_var'          => true,
				'publicly_queryable' => false,
				'rewrite'            => array( 'slug' => 'property-feature' ),
			)
		);

		$type_labels = array(
			'name'                       => esc_html__( 'Property Type', 'ieverly' ),
			'singular_name'              => esc_html__( 'Property Type', 'ieverly' ),
			'search_items'               => esc_html__( 'Search Property Types', 'ieverly' ),
			'popular_items'              => esc_html__( 'Popular Property Types', 'ieverly' ),
			'all_items'                  => esc_html__( 'All Property Types', 'ieverly' ),
			'parent_item'                => esc_html__( 'Parent Property Type', 'ieverly' ),
			'parent_item_colon'          => esc_html__( 'Parent Property Type:', 'ieverly' ),
			'edit_item'                  => esc_html__( 'Edit Property Type', 'ieverly' ),
			'update_item'                => esc_html__( 'Update Property Type', 'ieverly' ),
			'add_new_item'               => esc_html__( 'Add New Property Type', 'ieverly' ),
			'new_item_name'              => esc_html__( 'New Property Type Name', 'ieverly' ),
			'separate_items_with_commas' => esc_html__( 'Separate Property Types with commas', 'ieverly' ),
			'add_or_remove_items'        => esc_html__( 'Add or remove Property Types', 'ieverly' ),
			'choose_from_most_used'      => esc_html__( 'Choose from the most used Property Types', 'ieverly' ),
			'menu_name'                  => esc_html__( 'Property Types', 'ieverly' ),
		);

		register_taxonomy(
			'property-type',
			'property',
			array(
				'hierarchical'       => true,
				'labels'             => $type_labels,
				'show_ui'            => true,
				'query_var'          => true,
				'publicly_queryable' => false,
				'rewrite'            => array(
					'slug'       => 'property-type',
					'with_front' => false,
				),
			)
		);

		// City
		$city_labels = array(
			'name'                       => esc_html__( 'Property City', 'ieverly' ),
			'singular_name'              => esc_html__( 'Property City', 'ieverly' ),
			'search_items'               => esc_html__( 'Search Property Cities', 'ieverly' ),
			'popular_items'              => esc_html__( 'Popular Property Cities', 'ieverly' ),
			'all_items'                  => esc_html__( 'All Property Cities', 'ieverly' ),
			'parent_item'                => esc_html__( 'Parent Property City', 'ieverly' ),
			'parent_item_colon'          => esc_html__( 'Parent Property City:', 'ieverly' ),
			'edit_item'                  => esc_html__( 'Edit Property City', 'ieverly' ),
			'update_item'                => esc_html__( 'Update Property City', 'ieverly' ),
			'add_new_item'               => esc_html__( 'Add New Property City', 'ieverly' ),
			'new_item_name'              => esc_html__( 'New Property City Name', 'ieverly' ),
			'separate_items_with_commas' => esc_html__( 'Separate Property Cities with commas', 'ieverly' ),
			'add_or_remove_items'        => esc_html__( 'Add or remove Property Cities', 'ieverly' ),
			'choose_from_most_used'      => esc_html__( 'Choose from the most used Property Cities', 'ieverly' ),
			'menu_name'                  => esc_html__( 'Property Cities', 'ieverly' ),
		);

		$city_args = array(
			'hierarchical'       => true,
			'labels'             => $city_labels,
			'show_ui'            => true,
			'show_admin_column'  => true,
			'query_var'          => true,
			'publicly_queryable' => false,
			'rewrite'            => array(
				'slug'       => 'property-city',
				'with_front' => false,
			),
		);
		register_taxonomy( 'property-city', array( 'property' ), $city_args );

		// State
		$state_labels = array(
			'name'                       => esc_html__( 'Property State', 'ieverly' ),
			'singular_name'              => esc_html__( 'Property State', 'ieverly' ),
			'search_items'               => esc_html__( 'Search Property State', 'ieverly' ),
			'popular_items'              => esc_html__( 'Popular Property State', 'ieverly' ),
			'all_items'                  => esc_html__( 'All Property State', 'ieverly' ),
			'parent_item'                => esc_html__( 'Parent Property State', 'ieverly' ),
			'parent_item_colon'          => esc_html__( 'Parent Property State:', 'ieverly' ),
			'edit_item'                  => esc_html__( 'Edit Property State', 'ieverly' ),
			'update_item'                => esc_html__( 'Update Property State', 'ieverly' ),
			'add_new_item'               => esc_html__( 'Add New Property State', 'ieverly' ),
			'new_item_name'              => esc_html__( 'New Property State Name', 'ieverly' ),
			'separate_items_with_commas' => esc_html__( 'Separate Property State with commas', 'ieverly' ),
			'add_or_remove_items'        => esc_html__( 'Add or remove Property State', 'ieverly' ),
			'choose_from_most_used'      => esc_html__( 'Choose from the most used Property State', 'ieverly' ),
			'menu_name'                  => esc_html__( 'Property State', 'ieverly' ),
		);

		$state_args = array(
			'hierarchical'       => true,
			'labels'             => $state_labels,
			'show_ui'            => true,
			'query_var'          => true,
			'publicly_queryable' => false,
			'rewrite'            => array(
				'slug'       => 'property-state',
				'with_front' => false,
			),
		);
		register_taxonomy( 'property-state', array( 'property' ), $state_args );

		// Kitchen
		$kitchen_labels = array(
			'name'                       => esc_html__( 'Property Kitchen', 'ieverly' ),
			'singular_name'              => esc_html__( 'Property Kitchen', 'ieverly' ),
			'search_items'               => esc_html__( 'Search Property Kitchen', 'ieverly' ),
			'popular_items'              => esc_html__( 'Popular Property Kitchen', 'ieverly' ),
			'all_items'                  => esc_html__( 'All Property Kitchen', 'ieverly' ),
			'parent_item'                => esc_html__( 'Parent Property Kitchen', 'ieverly' ),
			'parent_item_colon'          => esc_html__( 'Parent Property Kitchen:', 'ieverly' ),
			'edit_item'                  => esc_html__( 'Edit Property Kitchen', 'ieverly' ),
			'update_item'                => esc_html__( 'Update Property Kitchen', 'ieverly' ),
			'add_new_item'               => esc_html__( 'Add New Property Kitchen', 'ieverly' ),
			'new_item_name'              => esc_html__( 'New Property Kitchen Name', 'ieverly' ),
			'separate_items_with_commas' => esc_html__( 'Separate Property Kitchen with commas', 'ieverly' ),
			'add_or_remove_items'        => esc_html__( 'Add or remove Property Kitchen', 'ieverly' ),
			'choose_from_most_used'      => esc_html__( 'Choose from the most used Property Kitchen', 'ieverly' ),
			'menu_name'                  => esc_html__( 'Property Kitchen', 'ieverly' ),
		);

		$kitchen_args = array(
			'hierarchical'       => true,
			'labels'             => $kitchen_labels,
			'show_ui'            => true,
			'query_var'          => true,
			'publicly_queryable' => false,
			'rewrite'            => array(
				'slug'       => 'property-kitchen',
				'with_front' => false,
			),
		);
		register_taxonomy( 'property-kitchen', array( 'property' ), $kitchen_args );

		// Status
		$status_labels = array(
			'name'                       => esc_html__( 'Property Status', 'ieverly' ),
			'singular_name'              => esc_html__( 'Property Status', 'ieverly' ),
			'search_items'               => esc_html__( 'Search Property Status', 'ieverly' ),
			'popular_items'              => esc_html__( 'Popular Property Status', 'ieverly' ),
			'all_items'                  => esc_html__( 'All Property Status', 'ieverly' ),
			'parent_item'                => esc_html__( 'Parent Property Status', 'ieverly' ),
			'parent_item_colon'          => esc_html__( 'Parent Property Status:', 'ieverly' ),
			'edit_item'                  => esc_html__( 'Edit Property Status', 'ieverly' ),
			'update_item'                => esc_html__( 'Update Property Status', 'ieverly' ),
			'add_new_item'               => esc_html__( 'Add New Property Status', 'ieverly' ),
			'new_item_name'              => esc_html__( 'New Property Status Name', 'ieverly' ),
			'separate_items_with_commas' => esc_html__( 'Separate Property Status with commas', 'ieverly' ),
			'add_or_remove_items'        => esc_html__( 'Add or remove Property Status', 'ieverly' ),
			'choose_from_most_used'      => esc_html__( 'Choose from the most used Property Status', 'ieverly' ),
			'menu_name'                  => esc_html__( 'Property Status', 'ieverly' ),
		);

		register_taxonomy(
			'property-status',
			'property',
			array(
				'hierarchical'       => true,
				'labels'             => $status_labels,
				'show_ui'            => true,
				'query_var'          => true,
				'publicly_queryable' => false,
				'rewrite'            => array( 'slug' => 'property-status' ),
			)
		);
	}
}
add_action( 'init', 'ieverly_build_taxonomies', 0 );
