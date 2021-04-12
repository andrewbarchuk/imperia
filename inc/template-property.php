<?php
/**
 * Ieverly Theme Property
 *
 * @package ieverly
 */

/*
	Sort by GET (url)
*/
if ( ! function_exists( 'property_get_search' ) ) {
	function property_get_search( $search_args ) {

		$tax_query  = array();   // taxonomy query array
		$meta_query = array();  // meta query qrray

		/* count */
		if ( ( ! empty( $_GET['property_number_of_results'] ) ) && ( $_GET['property_number_of_results'] != 'any' ) ) {
			$ordercountpage                = $_GET['property_number_of_results'];
			$search_args['posts_per_page'] = $ordercountpage;
		}

		/* order */
		if ( ( ! empty( $_GET['property_order_by'] ) ) && ( $_GET['property_order_by'] != 'any' ) ) {
			$order_get               = explode( '-', $_GET['property_order_by'] );
			$search_args['orderby']  = $order_get[0];
			$search_args['order']    = $order_get[1];
			$search_args['meta_key'] = $order_get[2];
		}

		/* Keyword Based Search */
		if ( isset( $_GET['keyword'] ) ) {
			$keyword = trim( $_GET['keyword'] );
			if ( ! empty( $keyword ) ) {
				// $search_args[ 's' ] = $keyword;
				$meta_query[] = array(
					'key'     => 'ref',
					'value'   => $keyword,
					'compare' => 'LIKE',
				);
			}
		}

		/* property city taxonomy query */
		if ( ( ! empty( $_GET['property-city'] ) ) && ( $_GET['property-city'] != 'any' ) ) {
			$tax_query[] = array(
				'taxonomy' => 'property-city',
				'field'    => 'slug',
				'terms'    => $_GET['property-city'],
			);
		}

		/* property status taxonomy query */
		if ( ( ! empty( $_GET['property-status'] ) ) && ( $_GET['property-status'] != 'any' ) ) {
			$tax_query[] = array(
				'taxonomy' => 'property-status',
				'field'    => 'slug',
				'terms'    => $_GET['property-status'],
			);
		}

		/* property type taxonomy query */
		if ( ( ! empty( $_GET['property-type'] ) ) && ( $_GET['property-type'] != 'any' ) ) {
			$tax_query[] = array(
				'taxonomy' => 'property-type',
				'field'    => 'slug',
				'terms'    => $_GET['property-type'],
			);
		}

		/* property state taxonomy query */
		if ( ( ! empty( $_GET['property-state'] ) ) && ( $_GET['property-state'] != 'any' ) ) {
			$tax_query[] = array(
				'taxonomy' => 'property-state',
				'field'    => 'slug',
				'terms'    => $_GET['property-state'],
			);
		}

		/* property kitchen taxonomy query */
		if ( ( ! empty( $_GET['property-kitchen'] ) ) && ( $_GET['property-kitchen'] != 'any' ) ) {
			$tax_query[] = array(
				'taxonomy' => 'property-kitchen',
				'field'    => 'slug',
				'terms'    => $_GET['property-kitchen'],
			);
		}

		/* Property Bedrooms Parameter */
		if ( ( ! empty( $_GET['bedrooms'] ) ) && ( $_GET['bedrooms'] != 'any' ) ) {
			$meta_query[] = array(
				'key'     => 'beds',
				'value'   => $_GET['bedrooms'],
				'compare' => '>=',
				'type'    => 'DECIMAL',
			);
		}

		/* Property Bathrooms Parameter */
		if ( ( ! empty( $_GET['bathrooms'] ) ) && ( $_GET['bathrooms'] != 'any' ) ) {
			$meta_query[] = array(
				'key'     => 'baths',
				'value'   => $_GET['bathrooms'],
				'compare' => '>=',
				'type'    => 'DECIMAL',
			);
		}

		/* Logic for Min and Max Price Parameters */
		if ( isset( $_GET['min-price'] ) && ( $_GET['min-price'] != 'any' ) && isset( $_GET['max-price'] ) && ( $_GET['max-price'] != 'any' ) ) {
			$min_price = doubleval( $_GET['min-price'] );
			$max_price = doubleval( $_GET['max-price'] );
			if ( $min_price >= 0 && $max_price > $min_price ) {
				$meta_query[] = array(
					'key'     => 'price',
					'value'   => array( $min_price, $max_price ),
					'type'    => 'NUMERIC',
					'compare' => 'BETWEEN',
				);
			}
		} elseif ( isset( $_GET['min-price'] ) && ( $_GET['min-price'] != 'any' ) ) {
			$min_price = doubleval( $_GET['min-price'] );
			if ( $min_price > 0 ) {
				$meta_query[] = array(
					'key'     => 'price',
					'value'   => $min_price,
					'type'    => 'NUMERIC',
					'compare' => '>=',
				);
			}
		} elseif ( isset( $_GET['max-price'] ) && ( $_GET['max-price'] != 'any' ) ) {
			$max_price = doubleval( $_GET['max-price'] );
			if ( $max_price > 0 ) {
				$meta_query[] = array(
					'key'     => 'price',
					'value'   => $max_price,
					'type'    => 'NUMERIC',
					'compare' => '<=',
				);
			}
		}

		/* Logic for Min and Max Area Parameters */
		if ( isset( $_GET['min-area'] ) && ( $_GET['min-area'] != 'any' ) && isset( $_GET['max-area'] ) && ( $_GET['max-area'] != 'any' ) ) {
			$min_price = doubleval( $_GET['min-area'] );
			$max_price = doubleval( $_GET['max-area'] );
			if ( $min_price >= 0 && $max_price > $min_price ) {
				$meta_query[] = array(
					'key'     => 'area',
					'value'   => array( $min_price, $max_price ),
					'type'    => 'NUMERIC',
					'compare' => 'BETWEEN',
				);
			}
		} elseif ( isset( $_GET['min-area'] ) && ( $_GET['min-area'] != 'any' ) ) {
			$min_price = doubleval( $_GET['min-area'] );
			if ( $min_price > 0 ) {
				$meta_query[] = array(
					'key'     => 'area',
					'value'   => $min_price,
					'type'    => 'NUMERIC',
					'compare' => '>=',
				);
			}
		} elseif ( isset( $_GET['max-area'] ) && ( $_GET['max-area'] != 'any' ) ) {
			$max_price = doubleval( $_GET['max-area'] );
			if ( $max_price > 0 ) {
				$meta_query[] = array(
					'key'     => 'area',
					'value'   => $max_price,
					'type'    => 'NUMERIC',
					'compare' => '<=',
				);
			}
		}

		// features
		if ( $features = get_terms( array( 'taxonomy' => 'property-feature' ) ) ) :
			$all_terms = array();

			foreach ( $features as $feature ) {
				if ( isset( $_GET[ 'feature-' . $feature->slug ] ) && $_GET[ 'feature-' . $feature->slug ] == 'on' ) {
					$all_terms[] = $feature->slug;
				}
			}

			if ( count( $all_terms ) > 0 ) {
				$tax_query[] = array(
					array(
						'taxonomy' => 'property-feature',
						'field'    => 'slug',
						'terms'    => $all_terms,
					),
				);
			}
		endif;

		/* if more than one taxonomies exist then specify the relation */
		$tax_count = count( $tax_query );
		if ( $tax_count > 1 ) {
			$tax_query['relation'] = 'AND';
		}

		/* if more than one meta query elements exist then specify the relation */
		$meta_count = count( $meta_query );
		if ( $meta_count > 1 ) {
			$meta_query['relation'] = 'AND';
		}

		if ( $tax_count > 0 ) {
			$search_args['tax_query'] = $tax_query;
		}

		/* if meta query has some values then add it to base home page query */
		if ( $meta_count > 0 ) {
			$search_args['meta_query'] = $meta_query;
		}

		return $search_args;
	}

	add_filter( 'property_get_search_parameters', 'property_get_search' );
}

/* 
	advance_search_options
*/
if ( ! function_exists( 'advance_search_options' ) ) {
	function advance_search_options( $taxonomy_name, $title ) {
		$taxonomy_terms = get_terms( $taxonomy_name );
		$searched_term  = '';

		if ( $taxonomy_name == 'property-city' ) {
			if ( ! empty( $_GET['property-city'] ) ) {
				$searched_term = $_GET['property-city'];
			}
		}

		if ( $taxonomy_name == 'property-type' ) {
			if ( ! empty( $_GET['property-type'] ) ) {
				$searched_term = $_GET['property-type'];
			}
		}

		if ( $taxonomy_name == 'property-state' ) {
			if ( ! empty( $_GET['property-state'] ) ) {
				$searched_term = $_GET['property-state'];
			}
		}

		if ( $taxonomy_name == 'property-kitchen' ) {
			if ( ! empty( $_GET['property-kitchen'] ) ) {
				$searched_term = $_GET['property-kitchen'];
			}
		}

		if ( $taxonomy_name == 'property-status' ) {
			if ( ! empty( $_GET['property-status'] ) ) {
				$searched_term = $_GET['property-status'];
			}
		}

		if ( ! empty( $title ) ) {

			if ( $searched_term == $title || empty( $searched_term ) ) {
				echo '<option value="any" selected="selected">' . $title . '</option>';
			} else {
				echo '<option value="any">' . $title . '</option>';
			}
		} else {

			if ( $searched_term == 'any' || empty( $searched_term ) ) {
				echo '<option value="any" selected="selected">' . esc_html__( 'Any', 'ieverly' ) . '</option>';
			} else {
				echo '<option value="any">' . esc_html__( 'Any', 'ieverly' ) . '</option>';
			}
		}

		if ( ! empty( $taxonomy_terms ) ) {
			foreach ( $taxonomy_terms as $term ) {
				if ( $searched_term == $term->slug ) {
					echo '<option value="' . $term->slug . '" selected="selected">' . $term->name . '</option>';
				} else {
					echo '<option value="' . $term->slug . '">' . $term->name . '</option>';
				}
			}
		}
	}
}

/*
	numbers_list
*/
if ( ! function_exists( 'numbers_list' ) ) {
	function numbers_list( $numbers_list_for, $title ) {
		$numbers_array  = array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12 );
		$searched_value = '';

		if ( $numbers_list_for == 'bedrooms' ) {
			if ( isset( $_GET['bedrooms'] ) ) {
				$searched_value = $_GET['bedrooms'];
			}
		}

		if ( $numbers_list_for == 'bathrooms' ) {
			if ( isset( $_GET['bathrooms'] ) ) {
				$searched_value = $_GET['bathrooms'];
			}
		}

		if ( ! empty( $title ) ) {

			if ( $searched_value == $title || empty( $searched_value ) ) {
				echo '<option value="any" selected="selected">' . $title . '</option>';
			} else {
				echo '<option value="any">' . $title . '</option>';
			}
		} else {

			if ( $searched_value == 'any' || empty( $searched_value ) ) {
				echo '<option value="any" selected="selected">' . esc_html__( 'Any', 'ieverly' ) . '</option>';
			} else {
				echo '<option value="any">' . esc_html__( 'Any', 'ieverly' ) . '</option>';
			}
		}

		if ( ! empty( $numbers_array ) ) {
			foreach ( $numbers_array as $number ) {
				if ( $searched_value == $number ) {
					echo '<option value="' . $number . '" selected="selected">' . $number . '</option>';
				} else {
					echo '<option value="' . $number . '">' . $number . '</option>';
				}
			}
		}
	}
}

/*
	count_list
*/
if ( ! function_exists( 'count_list' ) ) {
	function count_list( $count_list_for ) {
		$count_native        = get_option( 'posts_per_page' );
		$count_numbers_array = array( $count_native, $count_native * 2, $count_native * 3 );
		$searched_value      = '';

		if ( $count_list_for == 'property_number_of_results' ) {
			if ( isset( $_GET['property_number_of_results'] ) ) {
				$searched_value = $_GET['property_number_of_results'];
			}
		}

		if ( ! empty( $count_numbers_array ) ) {
			foreach ( $count_numbers_array as $number ) {
				if ( $searched_value == $number ) {
					echo '<option value="' . $number . '" selected="selected">' . $number . '</option>';
				} else {
					echo '<option value="' . $number . '">' . $number . '</option>';
				}
			}
		}
	}
}

/*
	order_list
*/
if ( ! function_exists( 'order_list' ) ) {
	function order_list( $order_list_for ) {
		$order_numbers_array = array( 'date-DESC', 'date-ASC', 'meta_value_num-DESC-price', 'meta_value_num-ASC-price', 'meta_value_num-DESC-area', 'meta_value_num-ASC-area' );
		$searched_value      = '';

		if ( $order_list_for == 'property_order_by' ) {
			if ( isset( $_GET['property_order_by'] ) ) {
				$searched_value = $_GET['property_order_by'];
			}
		}

		if ( ! empty( $order_numbers_array ) ) {
			foreach ( $order_numbers_array as $number ) {
				if ( $searched_value == $number ) {
					echo '<option value="' . $number . '" selected="selected">' . __( $number, 'ieverly' ) . '</option>';
				} else {
					echo '<option value="' . $number . '">' . __( $number, 'ieverly' ) . '</option>';
				}
			}
		}
	}
}

/*
	feature checkbox
*/
if ( ! function_exists( 'advance_features_options' ) ) {
	function advance_features_options( $features_name ) {
		$features_terms = get_terms( $features_name );
		if ( ! empty( $features_terms ) ) {
			foreach ( $features_terms as $features_term ) {
				if ( isset( $_GET[ 'feature-' . $features_term->slug ] ) && $_GET[ 'feature-' . $features_term->slug ] == 'on' ) {
					echo '<p class="features-checkbox"><input checked="checked" class="checkbox" type="checkbox" id="feature-' . $features_term->slug . '" name="feature-' . $features_term->slug . '" /><label for="feature-' . $features_term->slug . '">' . $features_term->name . '</label><span>' . $features_term->count . '</span></p>';
				} else {
					echo '<p class="features-checkbox"><input class="checkbox" type="checkbox" id="feature-' . $features_term->slug . '" name="feature-' . $features_term->slug . '" /><label for="feature-' . $features_term->slug . '">' . $features_term->name . '</label><span>' . $features_term->count . '</span></p>';
				}
			}
		}
	}
}

/*
	min-max price & area
*/
if ( ! function_exists( 'property_get_max_min_price' ) ) {
	function property_get_max_min_price() {
		$ft_property_price = array();
		$search_args       = array(
			'post_type'           => 'property',
			'posts_per_page'      => -1,
			'post_status'         => array( 'publish' ),
		);

		$properties_query = new WP_Query( $search_args );
		$total            = $properties_query->found_posts;

		if ( $properties_query->have_posts() ) :
			while ( $properties_query->have_posts() ) :
				$properties_query->the_post();
				$ft_property_price_f = get_post_meta( get_the_ID(), 'price', true );
				if ( ! empty( $ft_property_price_f ) ) {
					$ft_property_price[] = $ft_property_price_f;
				}
			endwhile;
		endif;
		wp_reset_postdata();
		return $ft_property_price;
	}
}
// area
if ( ! function_exists( 'property_get_max_min_area' ) ) {
	function property_get_max_min_area() {
		$ft_property_area = array();
		$search_args      = array(
			'post_type'           => 'property',
			'posts_per_page'      => -1,
			'post_status'         => array( 'publish' ),
		);

		$properties_query = new WP_Query( $search_args );
		$total            = $properties_query->found_posts;

		if ( $properties_query->have_posts() ) :
			while ( $properties_query->have_posts() ) :
				$properties_query->the_post();
				$ft_property_area_f = get_post_meta( get_the_ID(), 'area', true );
				if ( ! empty( $ft_property_area_f ) ) {
					$ft_property_area[] = $ft_property_area_f;
				}
			endwhile;
		endif;
		wp_reset_postdata();
		return $ft_property_area;
	}
}

/*
	loadmore ajax
*/
function property_loadmore_ajax_handler() {
	$params            = json_decode( stripslashes( $_POST['query'] ), true );
	$params['paged']   = $_POST['page'] + 1;
	$property_load     = new WP_Query( $params );
	$property_template = 'template-parts/' . $property_load->post->post_type . '/item';

	if ( $property_load->have_posts() ) {
		while ( $property_load->have_posts() ) :
			$property_load->the_post();
			get_template_part( $property_template );
		endwhile;
	} else {
		echo 'not found';
	};

	die();
}
add_action( 'wp_ajax_loadmorebutton', 'property_loadmore_ajax_handler' );
add_action( 'wp_ajax_nopriv_loadmorebutton', 'property_loadmore_ajax_handler' );

/*
	filter ajax
*/
function property_filter_function() { 
	$tax_query  = array();   // taxonomy query array
	$meta_query = array();  // meta query qrray

	/* Keyword Based Search */
	if ( isset( $_REQUEST['keyword'] ) ) {
		$keyword = trim( $_REQUEST['keyword'] );
		if ( ! empty( $keyword ) ) {
			// $search_args[ 's' ] = $keyword;
			$meta_query[] = array(
				'key'     => 'ref',
				'value'   => $keyword,
				'compare' => 'LIKE',
			);
		}
	}

	// property city
	if ( ( ! empty( $_REQUEST['property-city'] ) ) && ( $_REQUEST['property-city'] != 'any' ) ) {
		$tax_query[] = array(
			'taxonomy' => 'property-city',
			'field'    => 'slug',
			'terms'    => $_REQUEST['property-city'],
		);
	}

	// property status
	if ( ( ! empty( $_REQUEST['property-status'] ) ) && ( $_REQUEST['property-status'] != 'any' ) ) {
		$tax_query[] = array(
			'taxonomy' => 'property-status',
			'field'    => 'slug',
			'terms'    => $_REQUEST['property-status'],
		);
	}

	// property type
	if ( ( ! empty( $_REQUEST['property-type'] ) ) && ( $_REQUEST['property-type'] != 'any' ) ) {
		$tax_query[] = array(
			'taxonomy' => 'property-type',
			'field'    => 'slug',
			'terms'    => $_REQUEST['property-type'],
		);
	}

	// property state
	if ( ( ! empty( $_REQUEST['property-state'] ) ) && ( $_REQUEST['property-state'] != 'any' ) ) {
		$tax_query[] = array(
			'taxonomy' => 'property-state',
			'field'    => 'slug',
			'terms'    => $_REQUEST['property-state'],
		);
	}

	// property kitchen
	if ( ( ! empty( $_REQUEST['property-kitchen'] ) ) && ( $_REQUEST['property-kitchen'] != 'any' ) ) {
		$tax_query[] = array(
			'taxonomy' => 'property-kitchen',
			'field'    => 'slug',
			'terms'    => $_REQUEST['property-kitchen'],
		);
	}

	// features
	if ( $features = get_terms( array( 'taxonomy' => 'property-feature' ) ) ) :
		$all_terms = array();

		foreach ( $features as $feature ) {
			if ( isset( $_POST[ 'feature-' . $feature->slug ] ) && $_POST[ 'feature-' . $feature->slug ] == 'on' ) {
				$all_terms[] = $feature->slug;
			}
		}

		if ( count( $all_terms ) > 0 ) {
			$tax_query[] = array(
				array(
					'taxonomy' => 'property-feature',
					'field'    => 'slug',
					'terms'    => $all_terms,
				),
			);
		}
	endif;

	// beds
	if ( ( ! empty( $_REQUEST['bedrooms'] ) ) && ( $_REQUEST['bedrooms'] != 'any' ) ) {
		$meta_query[] = array(
			'key'     => 'beds',
			'value'   => $_REQUEST['bedrooms'],
			'compare' => '>=',
			'type'    => 'DECIMAL',
		);
	}

	// baths
	if ( ( ! empty( $_REQUEST['bathrooms'] ) ) && ( $_REQUEST['bathrooms'] != 'any' ) ) {
		$meta_query[] = array(
			'key'     => 'baths',
			'value'   => $_REQUEST['bathrooms'],
			'compare' => '>=',
			'type'    => 'DECIMAL',
		);
	}

	// min max price
	if ( isset( $_REQUEST['min-price'] ) && ( $_REQUEST['min-price'] != 'any' ) && isset( $_REQUEST['max-price'] ) && ( $_REQUEST['max-price'] != 'any' ) ) {
		$min_price = doubleval( $_REQUEST['min-price'] );
		$max_price = doubleval( $_REQUEST['max-price'] );
		if ( $min_price >= 0 && $max_price > $min_price ) {
			$meta_query[] = array(
				'key'     => 'price',
				'value'   => array( $min_price, $max_price ),
				'type'    => 'NUMERIC',
				'compare' => 'BETWEEN',
			);
		}
	} elseif ( isset( $_REQUEST['min-price'] ) && ( $_REQUEST['min-price'] != 'any' ) ) {
		$min_price = doubleval( $_REQUEST['min-price'] );
		if ( $min_price > 0 ) {
			$meta_query[] = array(
				'key'     => 'price',
				'value'   => $min_price,
				'type'    => 'NUMERIC',
				'compare' => '>=',
			);
		}
	} elseif ( isset( $_REQUEST['max-price'] ) && ( $_REQUEST['max-price'] != 'any' ) ) {
		$max_price = doubleval( $_REQUEST['max-price'] );
		if ( $max_price > 0 ) {
			$meta_query[] = array(
				'key'     => 'price',
				'value'   => $max_price,
				'type'    => 'NUMERIC',
				'compare' => '<=',
			);
		}
	}

	// min max area
	if ( isset( $_REQUEST['min-area'] ) && ( $_REQUEST['min-area'] != 'any' ) && isset( $_REQUEST['max-area'] ) && ( $_REQUEST['max-area'] != 'any' ) ) {
		$min_price = doubleval( $_REQUEST['min-area'] );
		$max_price = doubleval( $_REQUEST['max-area'] );
		if ( $min_price >= 0 && $max_price > $min_price ) {
			$meta_query[] = array(
				'key'     => 'area',
				'value'   => array( $min_price, $max_price ),
				'type'    => 'NUMERIC',
				'compare' => 'BETWEEN',
			);
		}
	} elseif ( isset( $_REQUEST['min-area'] ) && ( $_REQUEST['min-area'] != 'any' ) ) {
		$min_price = doubleval( $_REQUEST['min-area'] );
		if ( $min_price > 0 ) {
			$meta_query[] = array(
				'key'     => 'area',
				'value'   => $min_price,
				'type'    => 'NUMERIC',
				'compare' => '>=',
			);
		}
	} elseif ( isset( $_REQUEST['max-area'] ) && ( $_REQUEST['max-area'] != 'any' ) ) {
		$max_price = doubleval( $_REQUEST['max-area'] );
		if ( $max_price > 0 ) {
			$meta_query[] = array(
				'key'     => 'area',
				'value'   => $max_price,
				'type'    => 'NUMERIC',
				'compare' => '<=',
			);
		}
	}

	/* if more than one taxonomies exist then specify the relation */
	$tax_count = count( $tax_query );
	if ( $tax_count > 1 ) {
		$tax_query['relation'] = 'AND';
	}

	/* if more than one meta query elements exist then specify the relation */
	$meta_count = count( $meta_query );
	if ( $meta_count > 1 ) {
		$meta_query['relation'] = 'AND';
	}

	if ( $tax_count > 0 ) {
		$search_args['tax_query'] = $tax_query;
	}

	/* if meta query has some values then add it to base home page query */
	if ( $meta_count > 0 ) {
		$search_args['meta_query'] = $meta_query;
	}
	// #$

	// example: date-ASC 
	$order  = explode( '-', $_POST['property_order_by'] );
	$params = array(
		// 's' => $search_args[ 's' ],
		'taxonomy'       => '',
		'post_type'      => 'property',
		'posts_per_page' => $_POST['property_number_of_results'], // when set to -1, it shows all posts
		'orderby'        => $order[0], // example: date
		'order'          => $order[1],
		'meta_key'       => $order[2],
		'meta_query'     => $search_args['meta_query'],
		'tax_query'      => $search_args['tax_query'],
	);

	$property_filter = new WP_Query( $params );

	if ( $property_filter->have_posts() ) :
		ob_start(); // start buffering because we do not need to print the posts now

		while ( $property_filter->have_posts() ) :
			$property_filter->the_post();
			get_template_part( 'template-parts/property/item', get_post_format() );
		endwhile;

		$posts_html = ob_get_contents(); // we pass the posts to variable
		ob_end_clean(); // clear the buffer

	else :
		ob_start();
		get_template_part( 'template-parts/notfound', get_post_format() );
		$posts_html = ob_get_contents();
		ob_end_clean();
	endif;

	// no wp_reset_query() required

	echo wp_json_encode(
		array(
			'posts'       => wp_json_encode( $property_filter->query_vars ),
			'max_page'    => $property_filter->max_num_pages,
			'found_posts' => $property_filter->found_posts,
			'content'     => $posts_html,
		)
	);

	die();
}
add_action( 'wp_ajax_property__filter', 'property_filter_function' );
add_action( 'wp_ajax_nopriv_property__filter', 'property_filter_function' );
