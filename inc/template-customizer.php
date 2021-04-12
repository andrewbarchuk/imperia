<?php
/**
 * Ieverly customizer
 * Accent colors
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ieverly
 */

function theme_customize_register( $wp_customize ) {
	// Text color
	$wp_customize->add_setting(
		'text_color',
		array(
			'default'   => '',
			'transport' => 'refresh',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'text_color',
			array(
				'section' => 'colors',
				'label'   => esc_html__( 'Text color', 'theme' ),
			)
		)
	);

	// Title color
	$wp_customize->add_setting(
		'title_color',
		array(
			'default'   => '',
			'transport' => 'refresh',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'title_color',
			array(
				'section' => 'colors',
				'label'   => esc_html__( 'Title color', 'theme' ),
			)
		)
	);

	// Second color
	$wp_customize->add_setting(
		'second_color',
		array(
			'default'   => '',
			'transport' => 'refresh',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'second_color',
			array(
				'section' => 'colors',
				'label'   => esc_html__( 'Second color', 'theme' ),
			)
		)
	);

	// Accent color
	$wp_customize->add_setting(
		'accent_color',
		array(
			'default'           => '',
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'accent_color',
			array(
				'section' => 'colors',
				'label'   => esc_html__( 'Accent color', 'theme' ),
			)
		)
	);
}
add_action( 'customize_register', 'theme_customize_register' );


// custom css
function ieverly_theme_get_customizer_css() {
	ob_start();

	$text_color = get_theme_mod( 'text_color', '' );
	if ( ! empty( $text_color ) ) {
		?>
		:root {
		--c-text: <?php echo $text_color; ?>;
		}
		<?php
	}

	$title_color = get_theme_mod( 'title_color', '' );
	if ( ! empty( $text_color ) ) {
		?>
		:root {
		--c-title: <?php echo $title_color; ?>;
		}
		<?php
	}

	$second_color = get_theme_mod( 'second_color', '' );
	if ( ! empty( $text_color ) ) {
		?>
		:root {
		--c-second: <?php echo $second_color; ?>;
		}
		<?php
	}

	$accent_color = get_theme_mod( 'accent_color', '' );
	if ( ! empty( $accent_color ) ) {
		?>
		:root {
		--c-accent: <?php echo $accent_color; ?>;
		}

		a:hover {
		color: <?php echo $accent_color; ?>;
		border-bottom-color: <?php echo $accent_color; ?>;
		}

		button,
		input[type="submit"] {
		background-color: <?php echo $accent_color; ?>;
		}
		<?php
	}

	$css = ob_get_clean();
	return $css;
}

// Modify our styles registration like so:
function ieverly_enqueue_styles() {
	 wp_enqueue_style( 'ieverly-style', get_stylesheet_uri() ); // This is where you enqueue your theme's main stylesheet
	$custom_css = ieverly_theme_get_customizer_css();
	wp_add_inline_style( 'ieverly-style', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'ieverly_enqueue_styles' );



// theme options
function ieverly_settings( $wp_customize ) {
	$wp_customize->add_section(
		'ieverly_options',
		array(
			'title'       => __( 'Custom settings', 'ieverly' ), // Visible title of section
			'priority'    => 20, // Determines what order this appears in
			'capability'  => 'edit_theme_options', // Capability needed to tweak
			'description' => __( 'Theme settings', 'ieverly' ), // Descriptive tooltip
		)
	);

	// phone 1
	$wp_customize->add_setting(
		'phone_1', // No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
		array(
			'default'    => '', // Default setting/value to save
			'type'       => 'theme_mod', // Is this an 'option' or a 'theme_mod'?
			'capability' => 'edit_theme_options', // Optional. Special permissions for accessing this setting.
			// 'transport'  => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize, // Pass the $wp_customize object (required)
			'ieverly_theme_phone_1_title', // Set a unique ID for the control
			array(
				'label'       => __( 'Phone number', 'ieverly' ), // Admin-visible name of the control
				'description' => __( 'Enter this text', 'ieverly' ),
				'settings'    => 'phone_1', // Which setting to load and manipulate (serialized is okay)
				'priority'    => 10, // Determines the order this control appears in for the specified section
				'section'     => 'ieverly_options', // ID of the section this control should render in (can be one of yours, or a WordPress default section)
				'type'        => 'text',
			)
		)
	);

	// email
	$wp_customize->add_setting(
		'email', // No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
		array(
			'default'    => '', // Default setting/value to save
			'type'       => 'theme_mod', // Is this an 'option' or a 'theme_mod'?
			'capability' => 'edit_theme_options', // Optional. Special permissions for accessing this setting.
			// 'transport'  => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize, // Pass the $wp_customize object (required)
			'ieverly_theme_email_title', // Set a unique ID for the control
			array(
				'label'       => __( 'E-mail', 'ieverly' ), // Admin-visible name of the control
				'description' => __( 'Enter this e-mail', 'ieverly' ),
				'settings'    => 'email', // Which setting to load and manipulate (serialized is okay)
				'priority'    => 10, // Determines the order this control appears in for the specified section
				'section'     => 'ieverly_options', // ID of the section this control should render in (can be one of yours, or a WordPress default section)
				'type'        => 'text',
			)
		)
	);

	// currency
	$wp_customize->add_setting(
		'currency', // No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
		array(
			'default'    => '', // Default setting/value to save
			'type'       => 'theme_mod', // Is this an 'option' or a 'theme_mod'?
			'capability' => 'edit_theme_options', // Optional. Special permissions for accessing this setting.
			// 'transport'  => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize, // Pass the $wp_customize object (required)
			'ieverly_theme_currency_title', // Set a unique ID for the control
			array(
				'label'       => __( 'Currency', 'ieverly' ), // Admin-visible name of the control
				'description' => __( 'Enter this currency', 'ieverly' ),
				'settings'    => 'currency', // Which setting to load and manipulate (serialized is okay)
				'priority'    => 10, // Determines the order this control appears in for the specified section
				'section'     => 'ieverly_options', // ID of the section this control should render in (can be one of yours, or a WordPress default section)
				'type'        => 'text',
			)
		)
	);

	// area
	$wp_customize->add_setting(
		'area', // No need to use a SERIALIZED name, as `theme_mod` settings already live under one db record
		array(
			'default'    => '', // Default setting/value to save
			'type'       => 'theme_mod', // Is this an 'option' or a 'theme_mod'?
			'capability' => 'edit_theme_options', // Optional. Special permissions for accessing this setting.
			// 'transport'  => 'postMessage', //What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize, // Pass the $wp_customize object (required)
			'ieverly_theme_area_title', // Set a unique ID for the control
			array(
				'label'       => __( 'Area', 'ieverly' ), // Admin-visible name of the control
				'description' => __( 'Enter this area type', 'ieverly' ),
				'settings'    => 'area', // Which setting to load and manipulate (serialized is okay)
				'priority'    => 10, // Determines the order this control appears in for the specified section
				'section'     => 'ieverly_options', // ID of the section this control should render in (can be one of yours, or a WordPress default section)
				'type'        => 'text',
			)
		)
	);
}
add_action( 'customize_register', 'ieverly_settings' );
