<?php
/**
 * Ieverly Theme home meta-box
 *
 * @package ieverly
 */

function home_info() {
	global $post;
	if ( $post->ID == get_option( 'page_on_front' ) ) {
		add_meta_box(
			'home_info',
			__( 'Home settings', 'ieverly' ),
			'show_home_info',
			'page',
			'normal',
			'high'
		);
	}
}
add_action( 'add_meta_boxes', 'home_info' );

$meta_home = array(
	array(
		'label' => __( 'Name', 'ieverly' ),
		'desc'  => __( 'Enter name', 'ieverly' ),
		'id'    => 'author_name',
		'type'  => 'text',
	),
	array(
		'label' => __( 'Slogan', 'ieverly' ),
		'desc'  => __( 'Enter slogan', 'ieverly' ),
		'id'    => 'author_slogan',
		'type'  => 'text',
	),
	array(
		'label' => __( 'Slogan description', 'ieverly' ),
		'desc'  => __( 'Enter description', 'ieverly' ),
		'id'    => 'author_slogan_description',
		'type'  => 'textarea',
	),
	array(
		'label' => __( 'Hero slider', 'ieverly' ),
		'desc'  => __( 'Check photos for slider', 'ieverly' ),
		'id'    => 'home_slider',
		'type'  => 'gallery',
	),
	array(
		'label' => __( 'History title', 'ieverly' ),
		'desc'  => __( 'Enter title', 'ieverly' ),
		'id'    => 'history_title',
		'type'  => 'text',
	),
	array(
		'label' => __( 'History image', 'ieverly' ),
		'desc'  => __( 'Select image', 'ieverly' ),
		'id'    => 'history_image',
		'type'  => 'image',
	),
	array(
		'label' => __( 'History portfolio description', 'ieverly' ),
		'desc'  => __( 'Enter text', 'ieverly' ),
		'id'    => 'history_portfolio_desc',
		'type'  => 'textarea',
	),
	array(
		'label' => __( 'Portfolio title', 'ieverly' ),
		'desc'  => __( 'Enter text', 'ieverly' ),
		'id'    => 'home_portfolio_title',
		'type'  => 'text',
	),
	array(
		'label' => __( 'Instagram', 'ieverly' ),
		'desc'  => __( 'Enter text', 'ieverly' ),
		'id'    => 'home_instagram',
		'type'  => 'textarea',
	),
);

function show_home_info() {
	 global $meta_home;
	global $post;

	echo '<input type="hidden" name="custom_meta_box_nonce" value="' . wp_create_nonce( basename( __FILE__ ) ) . '" />';

	echo '<table class="form-table">';
	foreach ( $meta_home as $field ) {
		$meta = get_post_meta( $post->ID, $field['id'], true );
		echo '<tr>
                <th><label for="' . $field['id'] . '">' . $field['label'] . '</label></th>
                <td>';
		switch ( $field['type'] ) {
			case 'text':
				echo '<input type="text" name="' . $field['id'] . '" id="' . $field['id'] . '" value="' . $meta . '" size="30" />
                        <br /><span class="description">' . $field['desc'] . '</span>';
				break;
			case 'checkbox':
				echo '<input type="checkbox" name="' . $field['id'] . '" id="' . $field['id'] . '" ', $meta ? ' checked="checked"' : '', '/>
                            <label for="' . $field['id'] . '">' . $field['desc'] . '</label>';
				break;
			case 'textarea':
				echo '<textarea name="' . $field['id'] . '" id="' . $field['id'] . '" cols="60" rows="4">' . $meta . '</textarea>
                            <br /><span class="description">' . $field['desc'] . '</span>';
				break;
			case 'image':
				if ( $image = wp_get_attachment_image_src( $meta ) ) {
					echo '<a href="#" class="up-upl"><img src="' . $image[0] . '" /></a>
                                  <input type="hidden" name="' . $field['id'] . '" value="' . $meta . '">
                                  <a href="#" class="up-rmv">Remove image</a>
                                  ';
				} else {
					echo '<a href="#" class="up-upl">Upload image</a>
                                  <input type="hidden" name="' . $field['id'] . '" value="">
                                  <a href="#" class="up-rmv" style="display:none">Remove image</a>
                                  ';
				}
				break;
			case 'gallery':
				echo '<div><ul class="gallery_mtb">';
				/* array with image IDs for hidden field */
				$hidden = array();

				if ( $images = get_posts(
					array(
						'post_type'      => 'attachment',
						'orderby'        => 'post__in', /* we have to save the order */
						'order'          => 'ASC',
						'post__in'       => explode( ',', $meta ), /* $value is the image IDs comma separated */
						'numberposts'    => -1,
						'post_mime_type' => 'image',
					)
				) ) {

					foreach ( $images as $image ) {
						$hidden[]  = $image->ID;
						$image_src = wp_get_attachment_image_src( $image->ID, 'medium' );
						echo '<li data-id="' . $image->ID . '"><img src="' . $image_src[0] . '"><a href="#" class="gallery_remove">×</a></li>';
					}
				}

				echo '</ul><div style="clear:both"></div></div>';
				echo '<input type="hidden" name="' . $field['id'] . '" id="' . $field['id'] . '" value="' . join( ',', $hidden ) . '" /><a href="#" class="button upload_gallery_button">Add Images</a>';
				break;
		}
		echo '</td></tr>';
	}
	echo '</table>';
}

function save_home_info( $post_id ) {
	global $meta_home;

	if ( ! wp_verify_nonce( $_POST['custom_meta_box_nonce'], basename( __FILE__ ) ) ) {
		return $post_id;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}
	if ( 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return $post_id;
		}
	} elseif ( ! current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}

	foreach ( $meta_home as $field ) {
		$old = get_post_meta( $post_id, $field['id'], true );
		$new = $_POST[ $field['id'] ];
		if ( $new && $new != $old ) {
			update_post_meta( $post_id, $field['id'], $new );
		} elseif ( '' == $new && $old ) {
			delete_post_meta( $post_id, $field['id'], $old );
		}
	} // end foreach  
}
add_action( 'save_post', 'save_home_info' );


// gallery
function meta_boxes() {
	 wp_enqueue_script( 'jquery-ui-core' );
	wp_enqueue_script( 'jquery-ui-widget' );
	wp_enqueue_script( 'jquery-ui-sortable' );

	if ( ! did_action( 'wp_enqueue_media' ) ) {
		wp_enqueue_media();
	}

	wp_enqueue_script( 'myuploadscript', get_stylesheet_directory_uri() . '/js/meta-box.js', array( 'jquery' ) );
}
add_action( 'admin_enqueue_scripts', 'meta_boxes' );
