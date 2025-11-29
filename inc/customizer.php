<?php
/**
 * Slightly Theme Customizer
 *
 * @package slightly
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function slightly_customize_register( $wp_customize ) {

    $wp_customize->add_section( 'slightly_slightly_settings_section' , array(
      'title'      => __( 'Slightly Settings', 'slightly' ),
      'priority'   => 1,
    ) );
  
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
    $wp_customize->get_section( 'header_image' )->panel         = 'slightly_header_panel';
    $wp_customize->get_section( 'title_tagline' )->priority     = '9';
    $wp_customize->get_section( 'title_tagline' )->title        = __('Site branding', 'slightly');
    
    $wp_customize->add_setting('bodytext_color', array(
     'default'        => '#404040',
        'type'        => 'theme_mod',
        'transport' => 'postMessage',
        'sanitize_callback' => 'sanitize_hex_color'
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bodytext_color', array(
        'label'   => __('Body Text Color', 'slightly'),
        'section' => 'colors',
        'settings'   => 'bodytext_color'
    )));
  
    $wp_customize->add_setting(
        'hide_category_prefix', array(
        'sanitize_callback' => 'slightly_sanitize_checkbox'
          )
    );
  
    $wp_customize->add_control('hide_category_prefix', array(
        'type' => 'checkbox',
        'label' => 'Hide "Category:" prefix on category archive pages',
        'section' => 'slightly_slightly_settings_section',
      )
    );
  
    $wp_customize->add_setting(
        'hide_main_sidebar', array(
        'sanitize_callback' => 'slightly_sanitize_checkbox'
          )
    );
  
    $wp_customize->add_control('hide_main_sidebar', array(
        'type' => 'checkbox',
        'label' => 'Hide sidebar on all pages (except pages using Sidebar Page template)',
        'section' => 'slightly_slightly_settings_section',
      )
    );

}
add_action( 'customize_register', 'slightly_customize_register' );

function slightly_customize_colors() {
    $bodytext_color = get_theme_mod( 'bodytext_color' );
    $background_color = '#'.get_theme_mod( 'background_color' );

    ?>
    <style>
        body, button, input, select, textarea, a { 
            color: <?php echo esc_html( $bodytext_color ); ?>;
        }
      
        .menu-toggle {
          color: var(--color-text-primary);
          background-color: var(--color-bg-primary);
        }
      
        #primary-menu {
          color: var(--color-text-primary);
          background-color: var(--color-bg-primary);
        }
    </style>

    <?php

}
add_action( 'wp_head', 'slightly_customize_colors' );

/**
 * Sanitize
 */
//Text
function slightly_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}

//Checkbox
function slightly_sanitize_checkbox( $input ){
  //returns 1 if checkbox is checked and empty string if not
  if ($input == 1) {
    return 1;
  } else {
    return '';
  }
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function slightly_customize_preview_js() {
	wp_enqueue_script( 'slightly_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'slightly_customize_preview_js' );