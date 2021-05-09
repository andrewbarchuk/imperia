<?php
/**
 * Ieverly Theme blog post-type
 *
 * @package ieverly
 */

if (!function_exists('ieverly_blog')) {
	function ieverly_blog()
	{
		$labels = array(
			'name' => __('Blog', 'ieverly'),
			'singular_name' => __('Blog item', 'ieverly'),
			'add_new' => __('Add item', 'ieverly'),
			'add_new_item' => __('Add new item', 'ieverly'),
			'edit_item' => __('Edit item', 'ieverly'),
			'new_item' => __('New item', 'ieverly'),
			'all_items' => __('All items', 'ieverly'),
			'view_item' => __('View front', 'ieverly'),
			'search_items' => __('Search item', 'ieverly'),
			'not_found' =>  __('Not found item', 'ieverly'),
			'not_found_in_trash' => __('In trash not found item', 'ieverly'),
			'menu_name' => __('Blog', 'ieverly')
		);
		$args = array(
			'labels' => $labels,
			'public' => true,
			'show_ui' => true,
			'has_archive' => true,
			'menu_icon'   => 'dashicons-text-page',
			'show_in_nav_menus'   => true,
			'hierarchical' => true,
			'show_in_rest' => true,
			'menu_position' => 20,
			'supports' => array('title', 'editor', 'thumbnail', 'page-attributes'),
			'taxonomies' => array('blog_tag')
		);

		register_taxonomy(
			'blog_tag',
			'tags',
			array(
				'hierarchical' => false,
				'show_ui' => true,
				'update_count_callback' => '_update_post_term_count',
				'query_var' => true,
				'show_in_rest' => true,
				'show_in_nav_menus'   => true,
				'rewrite' => array('slug' => 'blog-tag')
			)
		);

		register_post_type('blog', $args);
	}
}
add_action('init', 'ieverly_blog');
