<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

$ref = get_post_meta($post->ID, 'ref', true);

$price = get_post_meta($post->ID, 'price', true);
$area = get_post_meta($post->ID, 'area', true);
$garage = get_post_meta($post->ID, 'garage', true);
$baths = get_post_meta($post->ID, 'baths', true);
$beds = get_post_meta($post->ID, 'beds', true);
$floors = get_post_meta($post->ID, 'floors', true);

$property_status = wp_get_post_terms($post->ID, 'property-status');
$property_city = wp_get_post_terms($post->ID, 'property-city');
$property_type = wp_get_post_terms($post->ID, 'property-type');


$property_settings_options = get_option( 'property_settings_option_name' );// Array of All Options

if ( has_post_thumbnail() ) {
	$item__imgurl = get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' );
} else {
	$item__imgurl = get_template_directory_uri() . '/dist/images/img-default.png';
}
?>

<div class="col-md-4">
	<article <?php post_class('property__item'); ?>>
		<a rel="bookmark" arial-label="<?php echo get_the_title(); ?>" class="property__item-link" href="<?php echo get_permalink($post->ID); ?>"></a>

		<header class="property__item-header">
			<div class="property__item-badge">
				<?php if(get_post_meta($post->ID, 'reserved', true) == 'on') { 
					echo '<div class="badge badge__reserved">'. __("Reserved", "restate") .'</div>';
				} elseif (get_post_meta($post->ID, 'sold_out', true) == 'on') {
					echo '<div class="badge badge__sold-out">'. __("Sold out", "restate") .'</div>';
				} ?>
				<?php if(has_term( array(315, 316, 317), 'property-building')) {
					echo '<div class="badge badge__new-building">'. __("New building", "restate") .'</div>';
				} ?>
			</div>
			<img loading="lazy" src="<?php esc_html_e($item__imgurl); ?>" alt="<?php echo get_the_title(); ?>">
		</header>

		<main>
			<p class="ref"><b>REF:</b> <?php esc_html_e($ref); ?></p>
			<h4>
				<?php
					foreach( $property_type as $property_type_slug ) {
						echo $property_type_slug->name . ' ';
					}
					echo get_the_title(); 
				?>
			</h4>
			<p class="price-replace"><?php esc_html_e($price); ?></p>
		</main>

		<footer>
			this benefits
		</footer>
	</article>
</div>


<div class="col-md-4">
	<div <?php post_class('prop-item'); ?>>
		<div class="prop-item-top">
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
			<a class="prop-item-bg o-abs" href="<?php echo get_permalink($post->ID); ?>">
				<img class="o-fit" src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'thumbnail') ?>" alt="<?php echo get_the_title(); ?>">
			</a>
			<div class="prop-item-top-inner">
				<div class="prop-item-top-status">
					<?php 
						foreach( $property_status as $property_status_slug ) {
							echo '<a href="'. get_post_type_archive_link('property') .'?property-status='. $property_status_slug->slug .'">'. $property_status_slug->name .'</a>';
						}
					?>
				</div>
				<div class="prop-item-top-other">
					<div class="prop-item-price"><?php echo $urrency_type_1; ?><?php echo $price; ?></div>
					<div class="prop-item-wishlist"><!-- this btn wishlist --></div>
				</div>
			</div>
		</div>
		<div class="prop-item-bottom">
			<div class="prop-item-location">
				<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M13.7238 0.0528522C13.5829 -0.0177802 13.4168 -0.0177802 13.2759 0.0528522L0.276323 6.55264C0.0293882 6.67624 -0.0705986 6.97658 0.0529714 7.22352C0.123311 7.36408 0.25567 7.46339 0.410293 7.4916L5.56962 8.43007L6.50808 13.5894C6.54649 13.8009 6.71582 13.9642 6.92857 13.9949C6.95209 13.9983 6.97582 13.9999 6.99955 13.9999C7.18906 14 7.36232 13.8929 7.44704 13.7234L13.9469 0.723816C14.0705 0.476939 13.9707 0.176539 13.7238 0.0528522Z" fill="#F1BF3D"/>
				</svg>
				<?php 
				foreach( $property_city as $property_city_slug ) {
					echo '<a href="'. get_post_type_archive_link('property') .'?property-city='. $property_city_slug->slug .'">'. $property_city_slug->name .'</a>';
				}
				?>
			</div>
			<a class="prop-item-title" href="<?php echo get_permalink($post->ID); ?>">
				<h3>
					<?php 
						foreach( $property_type as $property_type_slug ) {
							echo $property_type_slug->name . ' ';
						}
						echo get_the_title(); 
					?>
				</h3>
			</a>

			<div class="prop-item-date">
				<span class="date"><?php echo get_the_date('M d, Y'); ?></span>
				<?php if($ref) { ?>
				<span class="ref"><b><?php _e('REF:', 'restate'); ?></b> <?php echo $ref; ?></span>
				<?php };?>
			</div>

			<div class="prop-item-info">
				<div class="pii pii-left">
					<?php if($area) { ?>
						<div class="pii-item area">
							<svg width="217" height="222" viewBox="0 0 217 222" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M214.876 195.159L200.414 180.686C197.589 177.858 193.011 177.858 190.186 180.686C187.36 183.511 187.36 188.097 190.186 190.922L192.305 193.044H53.6287L55.7481 190.922C58.5733 188.097 58.5733 183.511 55.7481 180.686C52.9229 177.858 48.3452 177.858 45.5196 180.686L31.0579 195.159C29.639 196.576 28.9337 198.511 28.9337 200.282C28.9337 202.092 29.6762 204.026 31.0579 205.406L45.5196 219.879C48.3452 222.707 52.922 222.707 55.7481 219.879C58.5733 217.054 58.5733 212.468 55.7481 209.642L53.6287 207.521H192.305L190.186 209.642C187.36 212.468 187.36 217.053 190.186 219.879C193.011 222.707 197.588 222.707 200.414 219.879L214.876 205.406C216.293 203.991 217 202.058 217 200.282C217 198.425 216.258 196.539 214.876 195.159Z" fill="black"/>
								<path d="M31.0531 151.729L28.9337 153.85V24.7148L31.0531 26.836C33.8787 29.6639 38.4555 29.6639 41.2816 26.836C44.1072 24.0081 44.1072 19.4276 41.2816 16.5993L26.8147 2.12114C23.9895 -0.706323 19.4118 -0.706323 16.5862 2.12114L2.11965 16.5993C-0.705974 19.4271 -0.705974 24.0076 2.11965 26.836C4.94485 29.6634 9.52252 29.6634 12.3482 26.836L14.4672 24.7148V153.85L12.3477 151.729C9.52253 148.902 4.94485 148.902 2.11922 151.729C-0.706407 154.557 -0.706407 159.137 2.11922 161.966L16.5857 176.444C19.4114 179.272 23.9882 179.272 26.8142 176.444L41.2807 161.966C44.1064 159.138 44.1064 154.557 41.2812 151.729C38.456 148.902 33.8783 148.902 31.0531 151.729Z" fill="black"/>
								<path d="M180.834 57.9129H217V7.23927C217 3.24024 213.76 0 209.767 0H110.911V57.9129H147.078C151.071 57.9129 154.311 61.1531 154.311 65.1522C154.311 69.1512 151.071 72.3914 147.078 72.3914H110.911V94.1088C110.911 98.1079 107.671 101.348 103.678 101.348C99.6844 101.348 96.4442 98.1079 96.4442 94.1088V0H65.0997C61.1065 0 57.8662 3.24024 57.8662 7.23927V156.848C57.8662 160.847 61.1065 164.087 65.0997 164.087H96.4442V127.891C96.4442 123.892 99.6844 120.652 103.678 120.652C107.671 120.652 110.911 123.892 110.911 127.891V164.087H209.767C213.76 164.087 217 160.847 217 156.848V72.3914H180.834C176.84 72.3914 173.6 69.1512 173.6 65.1522C173.6 61.1531 176.84 57.9129 180.834 57.9129Z" fill="black"/>
							</svg>
							<b><?php echo $area; ?></b> <span><?php echo $area_type_0; ?></span>
						</div>
					<?php };?>
				</div>
				<div class="pii pii-right">
					<?php if($beds) { ?>
						<div class="pii-item beds">
							<svg width="910" height="554" viewBox="0 0 910 554" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M879 271.9V191C879 174.2 865.3 160.5 848.5 160.5H342.1C343.701 163.8 345.201 167.1 346.701 170.5C356.901 194.7 362.1 220.4 362.1 246.9C362.1 255.299 361.6 263.7 360.5 271.9H879Z" fill="black"/>
								<path d="M165.9 85.7C162.5 85.7 159.2 85.8 155.9 86V271.8H325.1C326.401 263.6 327 255.3 327 246.8C327 215 317.8 185.401 301.9 160.5C273.4 115.5 223.1 85.7 165.9 85.7Z" fill="black"/>
								<path d="M30 553.5H90.9C107.5 553.5 120.9 540.1 120.9 523.5V427.8H789.1V523.5C789.1 540.1 802.5 553.5 819.1 553.5H880C896.6 553.5 910 540.1 910 523.5V336.9C910 320.299 896.6 306.9 880 306.9H120.9V30.5C120.9 13.9 107.5 0.5 90.9 0.5H30C13.4 0.5 0 13.9 0 30.5V523.5C0 540 13.4 553.5 30 553.5Z" fill="black"/>
							</svg>
							<b><?php echo $beds; ?></b>
						</div>
					<?php };?>

					<?php if($baths) { ?>
						<div class="pii-item baths">
							<svg width="401" height="390" viewBox="0 0 401 390" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M379.587 355.515L373.275 340.639C359.789 352.434 343.44 361.04 325.415 365.262L336.997 380.309C341.668 386.377 349.035 390 356.704 390C365.062 390 372.807 385.847 377.423 378.892C382.038 371.935 382.848 363.197 379.587 355.515Z" fill="black"/>
								<path d="M27.7262 340.639L21.4136 355.515C18.1539 363.197 18.9629 371.936 23.5783 378.891C28.1937 385.846 35.9396 389.999 44.298 389.999C51.9655 389.999 59.3316 386.376 64.0057 380.307L75.5862 365.262C57.5607 361.04 41.2106 352.434 27.7262 340.639Z" fill="black"/>
								<path d="M143.412 41.9676H142.128C138.957 18.3103 118.62 0 94.0674 0H83.2482C56.5034 0 34.7437 21.7207 34.7437 48.4192V149.835H58.2969V48.4184C58.2969 34.6849 69.4905 23.511 83.2482 23.511H94.0674C105.591 23.511 115.309 31.3512 118.165 41.9668H116.263C97.5268 41.9668 82.2841 57.1827 82.2841 75.8855V95.7172C82.2841 102.005 87.2332 107.124 93.4526 107.442C93.6554 107.452 93.8551 107.473 94.0603 107.473H165.613C172.117 107.473 177.389 102.21 177.389 95.7172V75.8863C177.39 57.1835 162.147 41.9676 143.412 41.9676Z" fill="black"/>
								<path d="M13.2213 242.108V257.026C13.2213 305.36 52.6117 344.682 101.03 344.682H299.971C348.388 344.682 387.78 305.36 387.78 257.026V242.108H13.2213Z" fill="black"/>
								<path d="M384.059 184.599H16.9407C7.59942 184.6 0 192.187 0 201.511C0 210.836 7.59942 218.422 16.9407 218.422H384.059C393.401 218.422 401 210.836 401 201.511C401 192.187 393.401 184.599 384.059 184.599Z" fill="black"/>
							</svg>
							<b><?php echo $baths; ?></b>
						</div>
					<?php };?>

					<?php if($floors) { ?>
						<div class="pii-item floors">
							<svg width="220" height="170" viewBox="0 0 220 170" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M193.8 96.378H161.151C156.405 96.378 152.557 100.232 152.557 104.986C152.557 109.741 156.405 113.595 161.151 113.595H173.06L131.835 154.888C128.479 158.25 128.479 163.7 131.835 167.062C135.191 170.423 140.632 170.424 143.989 167.062L185.213 125.768V137.697C185.213 142.452 189.061 146.306 193.807 146.306C198.553 146.306 202.401 142.452 202.401 137.697V104.986C202.401 104.985 202.401 104.984 202.401 104.982C202.398 100.305 198.603 96.3746 193.8 96.378Z" fill="black"></path>
								<path d="M211.407 0H160.704C155.957 0 152.11 3.85393 152.11 8.60829V50.7889H110C105.255 50.7889 101.407 54.6429 101.407 59.3972V101.578H59.2973C54.551 101.578 50.7036 105.432 50.7036 110.186V152.367H8.59375C3.84742 152.367 0 156.221 0 160.975C0 165.729 3.84742 169.583 8.59375 169.583H59.2973C61.5764 169.583 63.7626 168.676 65.3739 167.062C66.9857 165.448 67.8911 163.258 67.8911 160.975L67.8906 118.794H110C112.279 118.794 114.466 117.888 116.077 116.273C117.689 114.659 118.594 112.469 118.594 110.186L118.594 68.0055H160.703C162.983 68.0055 165.168 67.0986 166.78 65.4841C168.392 63.8701 169.297 61.6801 169.297 59.3972L169.296 17.2166H211.406C216.153 17.2166 220 13.3627 220 8.60829C220 3.85393 216.153 0 211.407 0Z" fill="black"></path>
							</svg>
							<b><?php echo $floors; ?></b>
						</div>
					<?php };?>

					<?php if($garage) { ?>
						<div class="pii-item garage">
							<svg width="45" height="46" viewBox="0 0 45 46" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M43.5184 12.709L25.1784 0.727995C23.6674 -0.250005 21.7204 -0.240005 20.2184 0.748995L1.85935 12.719C0.719353 13.47 0.404353 15.003 1.15435 16.143C1.90535 17.283 3.43735 17.599 4.57835 16.847L22.7154 5.02099L40.8304 16.857C41.2464 17.126 41.7114 17.253 42.1714 17.253C42.9834 17.253 43.7754 16.856 44.2484 16.126C44.9904 14.98 44.6624 13.452 43.5184 12.709Z" fill="black"/>
								<path d="M38.8794 27.616C38.7284 26.751 37.9763 26.111 37.0993 26.111H36.0914L35.7084 22.124C35.2994 17.86 31.7604 14.634 27.4764 14.634H17.9204C13.6354 14.634 10.0974 17.861 9.68735 22.124L9.30535 26.111H8.29635C7.41835 26.111 6.66735 26.751 6.51435 27.616L5.01435 36.12C4.82835 37.174 5.12635 38.259 5.81435 39.077C6.47635 39.865 7.45135 40.335 8.47135 40.37V41.782C8.47135 43.781 10.0734 45.392 12.0744 45.392H13.2124C15.2114 45.392 16.8374 43.781 16.8374 41.782V40.393H28.5694V41.779C28.5694 43.779 30.1824 45.392 32.1814 45.392H33.3204C35.3194 45.392 36.9344 43.779 36.9344 41.779V40.37C37.9544 40.335 38.9234 39.869 39.5834 39.082C40.2714 38.262 40.5654 37.183 40.3814 36.127L38.8794 27.616ZM11.6424 37.113C9.95535 37.113 8.58735 35.746 8.58735 34.057C8.58735 32.368 9.95535 31 11.6424 31C13.3304 31 14.6994 32.367 14.6994 34.057C14.6994 35.746 13.3304 37.113 11.6424 37.113ZM12.4044 26.111L12.7574 22.433C13.0144 19.759 15.2334 17.745 17.9204 17.745H18.4714V18.901C18.4714 19.904 19.2684 20.703 20.2704 20.703H25.1264C26.1284 20.703 26.9394 19.904 26.9394 18.901V17.746H27.4764C30.1634 17.746 32.3824 19.76 32.6384 22.434L32.9924 26.112L12.4044 26.111ZM33.7504 37.113C32.0634 37.113 30.6954 35.746 30.6954 34.057C30.6954 32.368 32.0634 31 33.7504 31C35.4384 31 36.8074 32.367 36.8074 34.057C36.8074 35.746 35.4384 37.113 33.7504 37.113Z" fill="black"/>
							</svg>
							<b><?php echo $garage; ?></b>
						</div>
					<?php };?>
				</div>
			</div>
		</div>
	</div>
</div>