<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

$gallery_id = get_post_meta($post->ID, 'property_url', true);

$price = get_post_meta($post->ID, 'price', true);
$condition = get_post_meta($post->ID, 'condition', true);

$area = get_post_meta($post->ID, 'area', true);
$area_land = get_post_meta($post->ID, 'area_land', true);

$floors = get_post_meta($post->ID, 'floors', true);

$garage = get_post_meta($post->ID, 'garage', true);
$baths = get_post_meta($post->ID, 'baths', true);
$beds = get_post_meta($post->ID, 'beds', true);
$map = get_post_meta($post->ID, 'map', true);

$ref = get_post_meta($post->ID, 'ref', true);

$prop_status = wp_get_post_terms($post->ID, 'property-status');
$prop_city = wp_get_post_terms($post->ID, 'property-city');
$prop_type = wp_get_post_terms($post->ID, 'property-type');
$prop_features = wp_get_post_terms($post->ID, 'property-feature');
$prop_states = wp_get_post_terms($post->ID, 'property-state');
$prop_kitchen = wp_get_post_terms($post->ID, 'property-kitchen');
?>
<!-- single property -->
<section class="single-prop">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-7">
				<?php 
				if( $images = get_posts( array(
					'post_type' => 'attachment',
					'orderby' => 'post__in', /* we have to save the order */
					'order' => 'ASC',
					'post__in' => explode(',', $gallery_id), /* $value is the image IDs comma separated */
					'numberposts' => -1,
					'post_mime_type' => 'image'
				) ) ) {

					echo '<div class="prop-gallery">';
					foreach( $images as $image ) {
						$image_src = wp_get_attachment_image_src( $image->ID, 'medium' );
						$image_src_preview = wp_get_attachment_image_src( $image->ID, 'gallery-thumbnail' );
						echo '<div class="photo-item"><img src="'. $image_src_preview[0] .'" data-lazy="'. $image_src[0] .'"></div>';
					}
					echo '</div>';
				}
				?>
				<div class="prop-gallery-arrows">
					<div class="prop-gallery-prev">
						<svg width="30" height="30" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M29.251 40C29.6645 40 30.0262 39.845 30.3362 39.5349C30.9564 38.9147 30.9564 37.9328 30.3362 37.3643L12.9202 19.9999L30.3362 2.63565C30.9564 2.01553 30.9564 1.03357 30.3362 0.465088C29.7161 -0.155029 28.7342 -0.155029 28.1657 0.465088L9.66433 18.9147C9.35422 19.2248 9.19922 19.5865 9.19922 19.9999C9.19922 20.4134 9.35422 20.8268 9.66433 21.0852L28.1657 39.5349C28.4758 39.845 28.8375 40 29.251 40Z" fill="white"/>
						</svg>
					</div>
					<div class="prop-gallery-next">
						<svg width="30" height="30" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M10.7495 40C10.3361 40 9.97432 39.845 9.66431 39.5349C9.04419 38.9147 9.04419 37.9328 9.66431 37.3643L27.0803 19.9999L9.66431 2.63565C9.04419 2.01553 9.04419 1.03357 9.66431 0.465088C10.2844 -0.155029 11.2664 -0.155029 11.8349 0.465088L30.3362 18.9147C30.6463 19.2248 30.8013 19.5865 30.8013 19.9999C30.8013 20.4134 30.6463 20.8268 30.3362 21.0852L11.8349 39.5349C11.5248 39.845 11.163 40 10.7495 40Z" fill="white"/>
						</svg>
					</div>
				</div>
				<div class="prop-slider-count"></div>
			</div>
			<div class="col-md-5">
				<div class="single-prop-list">
					<div class="prop-item-top-badge">
						<?php if(get_post_meta($post->ID, 'reserved', true) == 'on') { 
							echo '<div class="badge badge-reserve">'. __("Reserved", "restate") .'</div>';
						} elseif (get_post_meta($post->ID, 'sold_out', true) == 'on') {
							echo '<div class="badge badge-sold_out">'. __("Sold out", "restate") .'</div>';
						} ?>
						<?php if(has_term( array(315, 316, 317), 'property-building')) {
							echo '<div class="badge badge-new_building">'. __("New building", "restate") .'</div>';
						} ?>
					</div>

					<div class="single-prop-list-status">
						<?php 
						foreach( $prop_type as $prop_type_slug ) {
							echo '<a href="'. get_post_type_archive_link('property') .'?property-type='. $prop_type_slug->slug .'">'. $prop_type_slug->name .'</a> ';
						}
						foreach( $prop_status as $prop_status_slug ) {
							echo '<a href="'. get_post_type_archive_link('property') .'?property-status='. $prop_status_slug->slug .'">'. $prop_status_slug->name .'</a> ';
						}
						?>
					</div>

					<?php if($built) { ?>
						<div class="single-prop-list-built">
							<span><?php _e('Year built', 'restate'); ?></span>, <?php echo $built; ?>
						</div>
					<?php };?>

					<div class="single-prop-list-title">
						<h1>
							<?php 
								foreach( $prop_type as $prop_type_slug ) {
									echo $prop_type_slug->name . ' ';
								}
								echo get_the_title(); 
							?>
						</h1>
						<span class="date"><?php echo get_the_date('M d, Y'); ?></span>
						<?php if($ref) { ?>
							<span><b><?php _e('REF:', 'restate'); ?></b> <?php echo $ref; ?></span>
						<?php };?>
					</div>
					<div class="single-prop-list-city">
						<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M13.7238 0.0528522C13.5829 -0.0177802 13.4168 -0.0177802 13.2759 0.0528522L0.276323 6.55264C0.0293882 6.67624 -0.0705986 6.97658 0.0529714 7.22352C0.123311 7.36408 0.25567 7.46339 0.410293 7.4916L5.56962 8.43007L6.50808 13.5894C6.54649 13.8009 6.71582 13.9642 6.92857 13.9949C6.95209 13.9983 6.97582 13.9999 6.99955 13.9999C7.18906 14 7.36232 13.8929 7.44704 13.7234L13.9469 0.723816C14.0705 0.476939 13.9707 0.176539 13.7238 0.0528522Z" fill="#F1BF3D"/>
						</svg>
						<?php 
						foreach( $prop_city as $prop_city_slug ) {
							echo '<a href="'. get_post_type_archive_link('property') .'?property-city='. $prop_city_slug->slug .'">'. $prop_city_slug->name .'</a>';
						}
						?>
					</div>

					<?php if($price) { ?>
						<div class="single-prop-list-price">
							<?php esc_html_e(get_theme_mod('currency')); ?><?php echo $price; ?>
						</div>
					<?php };?>

					<div class="single-prop-list-info">
						<?php if($area) { ?>
							<div class="property-meta-item area">
								<svg width="217" height="222" viewBox="0 0 217 222" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M214.876 195.159L200.414 180.686C197.589 177.858 193.011 177.858 190.186 180.686C187.36 183.511 187.36 188.097 190.186 190.922L192.305 193.044H53.6287L55.7481 190.922C58.5733 188.097 58.5733 183.511 55.7481 180.686C52.9229 177.858 48.3452 177.858 45.5196 180.686L31.0579 195.159C29.639 196.576 28.9337 198.511 28.9337 200.282C28.9337 202.092 29.6762 204.026 31.0579 205.406L45.5196 219.879C48.3452 222.707 52.922 222.707 55.7481 219.879C58.5733 217.054 58.5733 212.468 55.7481 209.642L53.6287 207.521H192.305L190.186 209.642C187.36 212.468 187.36 217.053 190.186 219.879C193.011 222.707 197.588 222.707 200.414 219.879L214.876 205.406C216.293 203.991 217 202.058 217 200.282C217 198.425 216.258 196.539 214.876 195.159Z" fill="black"/>
									<path d="M31.0531 151.729L28.9337 153.85V24.7148L31.0531 26.836C33.8787 29.6639 38.4555 29.6639 41.2816 26.836C44.1072 24.0081 44.1072 19.4276 41.2816 16.5993L26.8147 2.12114C23.9895 -0.706323 19.4118 -0.706323 16.5862 2.12114L2.11965 16.5993C-0.705974 19.4271 -0.705974 24.0076 2.11965 26.836C4.94485 29.6634 9.52252 29.6634 12.3482 26.836L14.4672 24.7148V153.85L12.3477 151.729C9.52253 148.902 4.94485 148.902 2.11922 151.729C-0.706407 154.557 -0.706407 159.137 2.11922 161.966L16.5857 176.444C19.4114 179.272 23.9882 179.272 26.8142 176.444L41.2807 161.966C44.1064 159.138 44.1064 154.557 41.2812 151.729C38.456 148.902 33.8783 148.902 31.0531 151.729Z" fill="black"/>
									<path d="M180.834 57.9129H217V7.23927C217 3.24024 213.76 0 209.767 0H110.911V57.9129H147.078C151.071 57.9129 154.311 61.1531 154.311 65.1522C154.311 69.1512 151.071 72.3914 147.078 72.3914H110.911V94.1088C110.911 98.1079 107.671 101.348 103.678 101.348C99.6844 101.348 96.4442 98.1079 96.4442 94.1088V0H65.0997C61.1065 0 57.8662 3.24024 57.8662 7.23927V156.848C57.8662 160.847 61.1065 164.087 65.0997 164.087H96.4442V127.891C96.4442 123.892 99.6844 120.652 103.678 120.652C107.671 120.652 110.911 123.892 110.911 127.891V164.087H209.767C213.76 164.087 217 160.847 217 156.848V72.3914H180.834C176.84 72.3914 173.6 69.1512 173.6 65.1522C173.6 61.1531 176.84 57.9129 180.834 57.9129Z" fill="black"/>
								</svg>
								<div class="property-meta-item-txt">
									<span><?php _e('Area', 'restate'); ?>: <b><?php echo $area; ?></b> <?php esc_html_e(get_theme_mod('area')); ?></span>
									<?php if($area_land) { ?>
										<span><?php _e('Land area', 'restate'); ?>: <b><?php echo $area_land; ?></b> <?php esc_html_e(get_theme_mod('area')); ?></span>
									<?php };?>
								</div>
							</div>
						<?php };?>

						<?php if($floors) { ?>
							<div class="property-meta-item beds">
								<svg width="220" height="170" viewBox="0 0 220 170" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M193.8 96.378H161.151C156.405 96.378 152.557 100.232 152.557 104.986C152.557 109.741 156.405 113.595 161.151 113.595H173.06L131.835 154.888C128.479 158.25 128.479 163.7 131.835 167.062C135.191 170.423 140.632 170.424 143.989 167.062L185.213 125.768V137.697C185.213 142.452 189.061 146.306 193.807 146.306C198.553 146.306 202.401 142.452 202.401 137.697V104.986C202.401 104.985 202.401 104.984 202.401 104.982C202.398 100.305 198.603 96.3746 193.8 96.378Z" fill="black"/>
									<path d="M211.407 0H160.704C155.957 0 152.11 3.85393 152.11 8.60829V50.7889H110C105.255 50.7889 101.407 54.6429 101.407 59.3972V101.578H59.2973C54.551 101.578 50.7036 105.432 50.7036 110.186V152.367H8.59375C3.84742 152.367 0 156.221 0 160.975C0 165.729 3.84742 169.583 8.59375 169.583H59.2973C61.5764 169.583 63.7626 168.676 65.3739 167.062C66.9857 165.448 67.8911 163.258 67.8911 160.975L67.8906 118.794H110C112.279 118.794 114.466 117.888 116.077 116.273C117.689 114.659 118.594 112.469 118.594 110.186L118.594 68.0055H160.703C162.983 68.0055 165.168 67.0986 166.78 65.4841C168.392 63.8701 169.297 61.6801 169.297 59.3972L169.296 17.2166H211.406C216.153 17.2166 220 13.3627 220 8.60829C220 3.85393 216.153 0 211.407 0Z" fill="black"/>
								</svg>
								<div class="property-meta-item-txt">
									<b><?php echo $floors; ?></b>
									<span><?php _e('Floors', 'restate'); ?></span>
								</div>
							</div>
						<?php };?>

						<?php if($beds) { ?>
							<div class="property-meta-item beds">
								<svg width="170" height="130" viewBox="0 0 210 129" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M202.846 63.1308V44.4615C202.846 40.5846 199.685 37.4231 195.808 37.4231H78.9462C79.3156 38.1846 79.6618 38.9462 80.0079 39.7308C82.3618 45.3154 83.5615 51.2462 83.5615 57.3615C83.5615 59.2998 83.4462 61.2385 83.1923 63.1308H202.846Z" fill="black"/>
									<path d="M38.2846 20.1615C37.5 20.1615 36.7385 20.1846 35.9769 20.2308V63.1077H75.0231C75.3233 61.2154 75.4615 59.3 75.4615 57.3385C75.4615 50 73.3385 43.1695 69.6692 37.4231C63.0923 27.0385 51.4846 20.1615 38.2846 20.1615Z" fill="black"/>
									<path d="M6.92308 128.115H20.9769C24.8077 128.115 27.9 125.023 27.9 121.192V99.1077H182.1V121.192C182.1 125.023 185.192 128.115 189.023 128.115H203.077C206.908 128.115 210 125.023 210 121.192V78.1308C210 74.2998 206.908 71.2077 203.077 71.2077H27.9V7.42308C27.9 3.59231 24.8077 0.5 20.9769 0.5H6.92308C3.09231 0.5 0 3.59231 0 7.42308V121.192C0 125 3.09231 128.115 6.92308 128.115Z" fill="black"/>
								</svg>
								<div class="property-meta-item-txt">
									<b><?php echo $beds; ?></b>
									<span><?php _e('Beds', 'restate'); ?></span>
								</div>
							</div>
						<?php };?>

						<?php if($baths) { ?>
							<div class="property-meta-item baths">
								<svg width="401" height="390" viewBox="0 0 401 390" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M379.587 355.515L373.275 340.639C359.789 352.434 343.44 361.04 325.415 365.262L336.997 380.309C341.668 386.377 349.035 390 356.704 390C365.062 390 372.807 385.847 377.423 378.892C382.038 371.935 382.848 363.197 379.587 355.515Z" fill="black"/>
									<path d="M27.7262 340.639L21.4136 355.515C18.1539 363.197 18.9629 371.936 23.5783 378.891C28.1937 385.846 35.9396 389.999 44.298 389.999C51.9655 389.999 59.3316 386.376 64.0057 380.307L75.5862 365.262C57.5607 361.04 41.2106 352.434 27.7262 340.639Z" fill="black"/>
									<path d="M143.412 41.9676H142.128C138.957 18.3103 118.62 0 94.0674 0H83.2482C56.5034 0 34.7437 21.7207 34.7437 48.4192V149.835H58.2969V48.4184C58.2969 34.6849 69.4905 23.511 83.2482 23.511H94.0674C105.591 23.511 115.309 31.3512 118.165 41.9668H116.263C97.5268 41.9668 82.2841 57.1827 82.2841 75.8855V95.7172C82.2841 102.005 87.2332 107.124 93.4526 107.442C93.6554 107.452 93.8551 107.473 94.0603 107.473H165.613C172.117 107.473 177.389 102.21 177.389 95.7172V75.8863C177.39 57.1835 162.147 41.9676 143.412 41.9676Z" fill="black"/>
									<path d="M13.2213 242.108V257.026C13.2213 305.36 52.6117 344.682 101.03 344.682H299.971C348.388 344.682 387.78 305.36 387.78 257.026V242.108H13.2213Z" fill="black"/>
									<path d="M384.059 184.599H16.9407C7.59942 184.6 0 192.187 0 201.511C0 210.836 7.59942 218.422 16.9407 218.422H384.059C393.401 218.422 401 210.836 401 201.511C401 192.187 393.401 184.599 384.059 184.599Z" fill="black"/>
								</svg>
								<div class="property-meta-item-txt">
									<b><?php echo $baths; ?></b>
									<span><?php _e('Baths', 'restate'); ?></span>
								</div>
							</div>
						<?php };?>

						<?php if($prop_kitchen) { ?>
							<div class="property-meta-item baths">
								<svg width="220" height="220" viewBox="0 0 220 220" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M213.555 35.2344H127.617C124.058 35.2344 121.172 38.1202 121.172 41.6797V103.984H6.44531C2.88578 103.984 0 106.87 0 110.43V213.555C0 217.114 2.88578 220 6.44531 220H213.555C217.114 220 220 217.114 220 213.555V41.6797C220 38.1202 217.114 35.2344 213.555 35.2344ZM134.062 48.125H207.109V103.984H134.062V48.125ZM12.8906 116.875H121.172V129.766H12.8906V116.875ZM12.8906 142.656H86.7969V207.109H12.8906V142.656ZM99.6875 142.656H121.172V207.109H99.6875V142.656ZM134.062 207.109V116.875H207.109V207.109H134.062Z" fill="black"/>
									<path d="M6.44531 85.9375H100.977C104.536 85.9375 107.422 83.0517 107.422 79.4922V62.3047C107.422 60.4231 106.599 58.6356 105.171 57.411L77.3438 33.559V6.44531C77.3438 2.88578 74.458 0 70.8984 0H36.5234C32.9639 0 30.0781 2.88578 30.0781 6.44531V33.559L2.2507 57.411C0.822422 58.6356 0 60.4231 0 62.3047V79.4922C0 83.0517 2.88578 85.9375 6.44531 85.9375ZM42.9688 12.8906H64.4531V30.0781H42.9688V12.8906ZM12.8906 65.2691L38.9078 42.9688H68.5141L94.5312 65.2691V73.0469H12.8906V65.2691Z" fill="black"/>
									<path d="M153.398 65.3125C149.839 65.3125 146.953 68.1983 146.953 71.7578V84.6484C146.953 88.208 149.839 91.0938 153.398 91.0938C156.958 91.0938 159.844 88.208 159.844 84.6484V71.7578C159.844 68.1983 156.958 65.3125 153.398 65.3125Z" fill="black"/>
									<path d="M153.398 129.766C149.839 129.766 146.953 132.651 146.953 136.211V149.102C146.953 152.661 149.839 155.547 153.398 155.547C156.958 155.547 159.844 152.661 159.844 149.102V136.211C159.844 132.651 156.958 129.766 153.398 129.766Z" fill="black"/>
									<path d="M67.4609 161.992C63.9014 161.992 61.0156 164.878 61.0156 168.438V181.328C61.0156 184.888 63.9014 187.773 67.4609 187.773C71.0205 187.773 73.9062 184.888 73.9062 181.328V168.438C73.9062 164.878 71.0205 161.992 67.4609 161.992Z" fill="black"/>
								</svg>
								<div class="property-meta-item-txt">
									<b>
										<?php
											foreach( $prop_kitchen as $prop_kitchen_item ) {
												echo $prop_kitchen_item->name;
											} 
										?>
									</b>
									<span><?php _e('Type of cuisine', 'restate'); ?></span>
								</div>
							</div>
						<?php };?>

						<?php if($garage) { ?>
							<div class="property-meta-item garage">
								<svg width="45" height="46" viewBox="0 0 45 46" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M43.5184 12.709L25.1784 0.727995C23.6674 -0.250005 21.7204 -0.240005 20.2184 0.748995L1.85935 12.719C0.719353 13.47 0.404353 15.003 1.15435 16.143C1.90535 17.283 3.43735 17.599 4.57835 16.847L22.7154 5.02099L40.8304 16.857C41.2464 17.126 41.7114 17.253 42.1714 17.253C42.9834 17.253 43.7754 16.856 44.2484 16.126C44.9904 14.98 44.6624 13.452 43.5184 12.709Z" fill="black"/>
									<path d="M38.8794 27.616C38.7284 26.751 37.9763 26.111 37.0993 26.111H36.0914L35.7084 22.124C35.2994 17.86 31.7604 14.634 27.4764 14.634H17.9204C13.6354 14.634 10.0974 17.861 9.68735 22.124L9.30535 26.111H8.29635C7.41835 26.111 6.66735 26.751 6.51435 27.616L5.01435 36.12C4.82835 37.174 5.12635 38.259 5.81435 39.077C6.47635 39.865 7.45135 40.335 8.47135 40.37V41.782C8.47135 43.781 10.0734 45.392 12.0744 45.392H13.2124C15.2114 45.392 16.8374 43.781 16.8374 41.782V40.393H28.5694V41.779C28.5694 43.779 30.1824 45.392 32.1814 45.392H33.3204C35.3194 45.392 36.9344 43.779 36.9344 41.779V40.37C37.9544 40.335 38.9234 39.869 39.5834 39.082C40.2714 38.262 40.5654 37.183 40.3814 36.127L38.8794 27.616ZM11.6424 37.113C9.95535 37.113 8.58735 35.746 8.58735 34.057C8.58735 32.368 9.95535 31 11.6424 31C13.3304 31 14.6994 32.367 14.6994 34.057C14.6994 35.746 13.3304 37.113 11.6424 37.113ZM12.4044 26.111L12.7574 22.433C13.0144 19.759 15.2334 17.745 17.9204 17.745H18.4714V18.901C18.4714 19.904 19.2684 20.703 20.2704 20.703H25.1264C26.1284 20.703 26.9394 19.904 26.9394 18.901V17.746H27.4764C30.1634 17.746 32.3824 19.76 32.6384 22.434L32.9924 26.112L12.4044 26.111ZM33.7504 37.113C32.0634 37.113 30.6954 35.746 30.6954 34.057C30.6954 32.368 32.0634 31 33.7504 31C35.4384 31 36.8074 32.367 36.8074 34.057C36.8074 35.746 35.4384 37.113 33.7504 37.113Z" fill="black"/>
								</svg>
								<div class="property-meta-item-txt">
									<b><?php echo $garage; ?></b>
									<span><?php _e('Garages', 'restate'); ?></span>
								</div>
							</div>
						<?php };?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- description -->
<article id="post-<?php the_ID(); ?>" <?php post_class('single-prop-txt content'); ?> role="article" >
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="single-prop-features">
					<?php if($prop_states) { ?>
						<div class="property-meta-condition">
							<?php
								echo __('General state', 'restate') . ': ';
								foreach( $prop_states as $prop_state ) {
									echo '<a href="'. get_post_type_archive_link('property') .'?property-state='. $prop_state->slug .'"><b>'. $prop_state->name .'</b></a> ';
								}
							?>
						</div>
					<?php };?>
					<?php if($prop_features) { ?>
						<div class="property-meta-features">
							<?php 
								foreach( $prop_features as $prop_feature ) {
									echo '<a href="'. get_post_type_archive_link('property') .'?feature-'. $prop_feature->slug .'=on"><svg width="100" height="100" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M50 0C22.4311 0 0 22.4311 0 50C0 77.5689 22.4311 100 50 100C77.5689 100 100 77.5689 100 50C100 22.4311 77.5689 0 50 0ZM77.9449 36.8421L45.99 68.5464C44.1103 70.4261 41.1028 70.5514 39.0977 68.6717L22.1805 53.2581C20.1754 51.3784 20.0501 48.2456 21.8045 46.2406C23.6842 44.2356 26.817 44.1103 28.8221 45.99L42.2306 58.2707L70.802 29.6992C72.807 27.6942 75.9398 27.6942 77.9449 29.6992C79.9499 31.7043 79.9499 34.8371 77.9449 36.8421Z" fill="black"/></svg>'. $prop_feature->name .'</a>';
								}
							?>
						</div>
					<?php };?>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="single-prop-txt-box">
					<h4><?php _e('Description', 'restate'); ?></h4>
					<div class="entry-content">
						<?php the_content(); ?>
					</div>
				</div>
				<?php if($map) { ?>
					<div class="single-prop-map">
						<?php echo $map; ?>
					</div>
				<?php };?>
			</div>
			<div class="col-md-6">
				<div class="single-prop-txt-box">
					<h4><?php _e('Request a showing', 'restate'); ?></h4>

					<?php 
						if(ICL_LANGUAGE_CODE=='en'):
						 	echo do_shortcode('[wpforms id="494"]');
						elseif(ICL_LANGUAGE_CODE=='es'):
							echo do_shortcode('[wpforms id="495"]');
						elseif(ICL_LANGUAGE_CODE=='ru'):
							echo do_shortcode('[wpforms id="134"]');
						endif; 
					?>
				</div>
			</div>
		</div>
	</div>
</article>