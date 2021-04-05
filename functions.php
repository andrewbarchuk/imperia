<?php
/**
 * Ieverly functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ieverly
 */

if (!defined('IEVERLY_VERSION')) {
	// Replace the version number of the theme on each release.
	define('IEVERLY_VERSION', '1.0.8');
}

if (!function_exists('ieverly_setup')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function ieverly_setup()
	{
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on ieverly, use a find and replace
		 * to change 'ieverly' to the name of your theme in all the template files.
		 */
		load_theme_textdomain('ieverly', get_template_directory() . '/languages');

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'header' => esc_html__('Header menu', 'ieverly'),
				'social' => esc_html__('Social networks', 'ieverly'),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'ieverly_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support('customize-selective-refresh-widgets');

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action('after_setup_theme', 'ieverly_setup');

/**
 * Clean header
 */
function ieverly_wphead_cleanup()
{
	// remove the generator meta tag
	remove_action('wp_head', 'wp_generator');
	// remove wlwmanifest link
	remove_action('wp_head', 'wlwmanifest_link');
	// remove RSD API connection
	remove_action('wp_head', 'rsd_link');
	// remove wp shortlink support
	remove_action('wp_head', 'wp_shortlink_wp_head');
	// remove next/previous links (this is not affecting blog-posts)
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
	// remove generator name from RSS
	add_filter('the_generator', '__return_false');
	// disable emoji support
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('wp_print_styles', 'print_emoji_styles');
	// disable automatic feeds
	remove_action('wp_head', 'feed_links_extra', 3);
	remove_action('wp_head', 'feed_links', 2);
	// remove rest API link
	remove_action('wp_head', 'rest_output_link_wp_head', 10);
	// remove oEmbed link
	remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
	remove_action('wp_head', 'wp_oembed_add_host_js');
}
add_action('after_setup_theme', 'ieverly_wphead_cleanup');


/**
 * Remove comments
 */
add_action('admin_init', function () {
	global $pagenow;
	if ($pagenow === 'edit-comments.php') {
		wp_redirect(admin_url());
		exit;
	}
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
	foreach (get_post_types() as $post_type) {
		if (post_type_supports($post_type, 'comments')) {
			remove_post_type_support($post_type, 'comments');
			remove_post_type_support($post_type, 'trackbacks');
		}
	}
});
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);
add_filter('comments_array', '__return_empty_array', 10, 2);
add_action('admin_menu', function () {
	remove_menu_page('edit-comments.php');
});
add_action('init', function () {
	if (is_admin_bar_showing()) {
		remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
	}
});

/**
 * Content width
 */
function ieverly_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'ieverly_content_width', 1005 );
}
add_action( 'after_setup_theme', 'ieverly_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function ieverly_scripts()
{
	wp_enqueue_style('ieverly-style', get_stylesheet_uri(), array(), IEVERLY_VERSION);
	wp_style_add_data('ieverly-style', 'rtl', 'replace');

	wp_enqueue_script('ieverly-navigation', get_template_directory_uri() . '/dist/functions.js', array(), IEVERLY_VERSION, true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'ieverly_scripts');

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Add svg support.
 */
require get_template_directory() . '/inc/svg.php';

/**
 * Add meta boxes support.
 */
// home meta
require get_template_directory() . '/inc/meta-box/home.php';

// portfolio
require get_template_directory() . '/inc/post-type/portfolio.php';
require get_template_directory() . '/inc/meta-box/portfolio.php';
