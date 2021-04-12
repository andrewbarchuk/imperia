<?php
/**
 * Ieverly Theme Property meta-box
 *
 * @package ieverly
 */

function ieverly_property_info() {
	global $post;
	add_meta_box(
		'ieverly_property_info',
		__( 'Settings', 'ieverly' ),
		'show_ieverly_property_info',
		'property',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'ieverly_property_info' );

$meta_ieverly_property = array(
	array(
		'label'    => __( 'REF', 'ieverly' ),
		'desc'     => __( 'Enter this ref code', 'ieverly' ),
		'id'       => 'ref',
		'required' => 'required',
		'type'     => 'text',
	),
	array(
		'label' => __( 'Reserved', 'ieverly' ),
		'desc'  => __( 'Check if reserved', 'ieverly' ),
		'id'    => 'reserved',
		'type'  => 'checkbox',
	),
	array(
		'label' => __( 'Sold out', 'ieverly' ),
		'desc'  => __( 'Check if sold out', 'ieverly' ),
		'id'    => 'sold_out',
		'type'  => 'checkbox',
	),
	array(
		'label' => __( 'Show on home', 'ieverly' ),
		'desc'  => __( 'Check if show home page', 'ieverly' ),
		'id'    => 'show_on_home',
		'type'  => 'checkbox',
	),
	array(
		'label'    => __( 'Price', 'ieverly' ),
		'desc'     => __( 'Only digits', 'ieverly' ),
		'id'       => 'price',
		'required' => 'required',
		'type'     => 'text',
	),
	array(
		'label'    => __( 'Area house', 'ieverly' ),
		'desc'     => __( 'Only digits', 'ieverly' ),
		'id'       => 'area',
		'required' => 'required',
		'type'     => 'text',
	),
	array(
		'label' => __( 'Land area', 'ieverly' ),
		'desc'  => __( 'Only digits', 'ieverly' ),
		'id'    => 'area_land',
		'type'  => 'text',
	),
	array(
		'label' => __( 'Number of floors', 'ieverly' ),
		'desc'  => __( 'Only digits', 'ieverly' ),
		'id'    => 'floors',
		'type'  => 'text',
	),
	array(
		'label' => __( 'Beds', 'ieverly' ),
		'desc'  => __( 'Only digits', 'ieverly' ),
		'id'    => 'beds',
		'type'  => 'text',
	),
	array(
		'label' => __( 'Baths', 'ieverly' ),
		'desc'  => __( 'Only digits', 'ieverly' ),
		'id'    => 'baths',
		'type'  => 'text',
	),
	array(
		'label' => __( 'Garage', 'ieverly' ),
		'desc'  => __( 'Only digits', 'ieverly' ),
		'id'    => 'garage',
		'type'  => 'text',
	),
	array(
		'label' => __( 'Map iframe', 'ieverly' ),
		'desc'  => __( 'Enter this map iframe', 'ieverly' ),
		'id'    => 'map',
		'type'  => 'textarea',
	),
	array(
		'label' => __( 'Gallery', 'ieverly' ),
		'desc'  => __( '', 'ieverly' ),
		'id'    => 'property_url',
		'type'  => 'gallery',
	),
);

function show_ieverly_property_info() {
	 global $meta_ieverly_property;
	global $post;

	echo '<input type="hidden" name="custom_meta_box_nonce" value="' . wp_create_nonce( basename( __FILE__ ) ) . '" />';

	echo '<table class="form-table">';
	foreach ( $meta_ieverly_property as $field ) {
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

function save_ieverly_property_info( $post_id ) {
	global $meta_ieverly_property;

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

	foreach ( $meta_ieverly_property as $field ) {
		$old = get_post_meta( $post_id, $field['id'], true );
		$new = $_POST[ $field['id'] ];
		if ( $new && $new != $old ) {
			update_post_meta( $post_id, $field['id'], $new );
		} elseif ( '' == $new && $old ) {
			delete_post_meta( $post_id, $field['id'], $old );
		}
	} // end foreach  
}
add_action( 'save_post', 'save_ieverly_property_info' );
