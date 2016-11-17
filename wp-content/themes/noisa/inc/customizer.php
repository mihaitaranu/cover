<?php
/**
 * Theme Name: 		NOISA - Music WordPress Theme
 * Theme Author: 	Mariusz Rek - Rascals Themes
 * Theme URI: 		http://rascals.eu/noisa
 * Author URI: 		http://rascals.eu
 * File:			customizer.php
 * =========================================================================================================================================
 *
 * @package noisa
 * @since 1.0.0
 */

global $noisa_opts;

function noisa_customize_register( $wp_customize ) {

	// Section
    $wp_customize->add_section(
        'theme_colors',
        array(
            'title' => __( 'Theme Colors', 'noisa' ),
            'description' => __( 'Change default theme colors. Please SAVE and REFRESH your browser to see the new styles.', 'noisa' ),
            'priority' => 35,
        )
    );

    // ACCENT COLOR
    $wp_customize->add_setting(
    	'accent_color',
	    array(
	        'default' => '#e82561',
        	'sanitize_callback' => 'sanitize_hex_color',
        	'transport'   => 'postMessage'
	    )
	);
	$wp_customize->add_control(
	    'accent_color',
	    array(
	        'label' => 'Accent Color',
	        'section' => 'theme_colors',
	        'type' => 'text'
	    )
	);
	$wp_customize->add_control(
    	new WP_Customize_Color_Control(
	        $wp_customize,
	        'accent_color',
	        array(
	            'label' => 'Accent Color',
	            'section' => 'theme_colors',
	            'settings' => 'accent_color',

	        )
	    )
	);

	 // HEADINGS COLORS
    $wp_customize->add_setting(
    	'headings_color',
	    array(
	        'default' => '#ffffff',
        	'sanitize_callback' => 'sanitize_hex_color',
        	'transport'   => 'postMessage'
	    )
	);
	$wp_customize->add_control(
	    'headings_color',
	    array(
	        'label' => 'Headings Colors',
	        'section' => 'theme_colors',
	        'type' => 'text'
	    )
	);
	$wp_customize->add_control(
    	new WP_Customize_Color_Control(
	        $wp_customize,
	        'headings_color',
	        array(
	            'label' => 'Haadings Colors',
	            'section' => 'theme_colors',
	            'settings' => 'headings_color',

	        )
	    )
	);

	// BODY BACKGROUND COLOR
    $wp_customize->add_setting(
    	'body_bg_color',
	    array(
	        'default' => '#0b0b0c',
        	'sanitize_callback' => 'sanitize_hex_color',
        	'transport'   => 'postMessage'
	    )
	);
	$wp_customize->add_control(
	    'body_bg_color',
	    array(
	        'label' => 'Body Background Color',
	        'section' => 'theme_colors',
	        'type' => 'text'
	    )
	);
	$wp_customize->add_control(
    	new WP_Customize_Color_Control(
	        $wp_customize,
	        'body_bg_color',
	        array(
	            'label' => 'Body Background Color',
	            'section' => 'theme_colors',
	            'settings' => 'body_bg_color',

	        )
	    )
	);

	// TEXT COLOR
    $wp_customize->add_setting(
    	'text_color',
	    array(
	        'default' => '#eeeeee',
        	'sanitize_callback' => 'sanitize_hex_color',
        	'transport'   => 'postMessage'
	    )
	);
	$wp_customize->add_control(
	    'text_color',
	    array(
	        'label' => 'Text Color',
	        'section' => 'theme_colors',
	        'type' => 'text'
	    )
	);
	$wp_customize->add_control(
    	new WP_Customize_Color_Control(
	        $wp_customize,
	        'text_color',
	        array(
	            'label' => 'Text Color',
	            'section' => 'theme_colors',
	            'settings' => 'text_color',

	        )
	    )
	);

}
add_action( 'customize_register', 'noisa_customize_register' );