<?php
/**
 * Ieverly customizer
 * Accent colors
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ieverly
 */

function theme_customize_register($wp_customize)
{
    // Text color
    $wp_customize->add_setting('text_color', array(
        'default'   => '',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'text_color', array(
        'section' => 'colors',
        'label'   => esc_html__('Text color', 'theme'),
    )));

    // Title color
    $wp_customize->add_setting('title_color', array(
        'default'   => '',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'title_color', array(
        'section' => 'colors',
        'label'   => esc_html__('Title color', 'theme'),
    )));

    // Second color
    $wp_customize->add_setting('second_color', array(
        'default'   => '',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'second_color', array(
        'section' => 'colors',
        'label'   => esc_html__('Second color', 'theme'),
    )));
    
    // Accent color
    $wp_customize->add_setting('accent_color', array(
        'default'   => '',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'accent_color', array(
        'section' => 'colors',
        'label'   => esc_html__('Accent color', 'theme'),
    )));
}
add_action('customize_register', 'theme_customize_register');


// custom css
function ieverly_theme_get_customizer_css()
{
    ob_start();

    $text_color = get_theme_mod('text_color', '');
    if (!empty($text_color)) {
?>
        :root {
            --c-text: <?php echo $text_color; ?>;
        }
    <?php
    }

    $title_color = get_theme_mod('title_color', '');
    if (!empty($text_color)) {
?>
        :root {
            --c-title: <?php echo $title_color; ?>;
        }
    <?php
    }

    $second_color = get_theme_mod('second_color', '');
    if (!empty($text_color)) {
?>
        :root {
            --c-second: <?php echo $second_color; ?>;
        }
    <?php
    }

    $accent_color = get_theme_mod('accent_color', '');
    if (!empty($accent_color)) {
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
function ieverly_enqueue_styles()
{
    wp_enqueue_style('theme-styles', get_stylesheet_uri()); // This is where you enqueue your theme's main stylesheet
    $custom_css = ieverly_theme_get_customizer_css();
    wp_add_inline_style('theme-styles', $custom_css);
}
add_action('wp_enqueue_scripts', 'ieverly_enqueue_styles');
