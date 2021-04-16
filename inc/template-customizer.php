<?php
/**
 * Ieverly customizer
 *
 * Accent colors and theme options
 * 
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ieverly
 */

/**
 * Define template file.
 * 
 * @param string $wp_customize Customizer for colors.
 */
function theme_customize_register( $wp_customize ) {
	/* Text color */
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
				'label'   => esc_html__( 'Text color', 'ieverly' ),
			)
		)
	);

	/* Title color */
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
				'label'   => esc_html__( 'Title color', 'ieverly' ),
			)
		)
	);

	/* Second color */
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
				'label'   => esc_html__( 'Second color', 'ieverly' ),
			)
		)
	);

	/* Accent color */
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
				'label'   => esc_html__( 'Accent color', 'ieverly' ),
			)
		)
	);

	/**
	 * Custom settings
	*/ 
	$wp_customize->add_section(
		'ieverly_options',
		array(
			'title'       => __( 'Custom settings', 'ieverly' ),
			'priority'    => 20,
			'capability'  => 'edit_theme_options',
			'description' => __( 'Theme settings', 'ieverly' ),
		)
	);

	/* currency */
	$wp_customize->add_setting(
		'currency',
		array(
			'default'    => '',
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'ieverly_theme_currency_title',
			array(
				'label'       => __( 'Currency', 'ieverly' ),
				'description' => __( 'Enter this currency', 'ieverly' ),
				'settings'    => 'currency',
				'priority'    => 10,
				'section'     => 'ieverly_options',
				'type'        => 'text',
			)
		)
	);

	/* area */
	$wp_customize->add_setting(
		'area',
		array(
			'default'    => '', 
			'type'       => 'theme_mod',
			'capability' => 'edit_theme_options',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'ieverly_theme_area_title',
			array(
				'label'       => __( 'Area', 'ieverly' ), 
				'description' => __( 'Enter this area type', 'ieverly' ),
				'settings'    => 'area', 
				'priority'    => 10, 
				'section'     => 'ieverly_options',
				'type'        => 'text',
			)
		)
	);
}
add_action( 'customize_register', 'theme_customize_register' );

/** Custom CSS */
function ieverly_theme_get_customizer_css() {
	ob_start();

	$text_color = get_theme_mod( 'text_color', '' );
	if ( ! empty( $text_color ) ) {
		?>
		:root {
			--c-text: <?php echo esc_attr( $text_color ); ?>;
		}
		<?php
	}

	$title_color = get_theme_mod( 'title_color', '' );
	if ( ! empty( $text_color ) ) {
		?>
		:root {
			--c-title: <?php echo esc_attr( $title_color ); ?>;
		}
		<?php
	}

	$second_color = get_theme_mod( 'second_color', '' );
	if ( ! empty( $text_color ) ) {
		?>
		:root {
			--c-second: <?php echo esc_attr( $second_color ); ?>;
		}
		<?php
	}

	$accent_color = get_theme_mod( 'accent_color', '' );
	if ( ! empty( $accent_color ) ) {
		?>
		:root {
			--c-accent: <?php echo esc_attr( $accent_color ); ?>;
		}

		a:hover {
			color: <?php echo esc_attr( $accent_color ); ?>;
			border-bottom-color: <?php echo esc_attr( $accent_color ); ?>;
		}

		button,
			input[type="submit"] {
			background-color: <?php echo esc_attr( $accent_color ); ?>;
		}
		<?php
	}

	$css = ob_get_clean();
	return $css;
}
