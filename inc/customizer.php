<?php

/**
 * Bhari Theme Customizer.
 *
 * @package Bhari
 */

/**
 * Get option
 */
function bhari_get_option( $key = '', $defaults = '' ) {

	$options = 	apply_filters( 'bhari/theme_defaults/after_parse_args', wp_parse_args(
					get_option( 'bhari', true ),
					bhari_get_defaults()
				) );

	if( isset( $options[ $key ] ) ) {
		return $options[ $key ];
	} else {
		return $defaults;
	}
}

/**
 * Set default options
 */
function bhari_get_defaults() {

	$bhari_defaults = array(

		/**
		 * Colors
		 */
		'link-color'   => '#34495e',
		'link-h-color' => '#293b4c',
		'text-color'   => '#404040',

		/**
		 * Container
		 */
		'container-width-page'    => 1100,
		'container-width-single'  => 1100,
		'container-width-archive' => 1100,

		/**
		 * Sidebar
		 */
		'sidebar-page'    => 'layout-content-sidebar',
		'sidebar-single'  => 'layout-no-sidebar',
		'sidebar-archive' => 'layout-content-sidebar',
	);
	
	return apply_filters( 'bhari/theme_defaults', $bhari_defaults );
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function bhari_customize_register( $wp_customize ) {

	/**
	 * Override defaults
	 */
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	$wp_customize->get_control( 'header_textcolor' )->label     = __( 'Site Title & Tagline Color', 'bhari' );
	$wp_customize->get_control( 'background_color' )->label     = __( 'Body Background Color', 'bhari' );

	/**
	 * Get default's
	 */
	$defaults = bhari_get_defaults();

	/**
	 * Load customizer helper files
	 */
	require_once get_template_directory() . '/inc/customizer-sanitize.php';
	require_once get_template_directory() . '/inc/customizer-controls.php';

	// Add control types so controls can be built using JS
	if ( method_exists( $wp_customize, 'register_control_type' ) ) {
		$wp_customize->register_control_type( 'Bhari_Customize_Width_Slider_Control' );
	}


	if ( class_exists( 'WP_Customize_Panel' ) ) :
		if ( ! $wp_customize->get_panel( 'bhari_panel_layout' ) ) {
			$wp_customize->add_panel( 'bhari_panel_layout', array(
				'capability' => 'edit_theme_options',
				'title'      => __( 'Layout','bhari' ),
				'priority'   => 40,
			) );
		}
	endif;

	$wp_customize->add_section( 'bhari_sidebars', array(
		'title'      => __( 'Sidebars', 'bhari' ),
		'capability' => 'edit_theme_options',
		'panel'      => 'bhari_panel_layout'
	) );

	/**
	 * Register options
	 */
	$wp_customize->add_setting( 'bhari[sidebar-page]', array(
		'default'           => $defaults['sidebar-page'],
		'type'              => 'option',
		'sanitize_callback'    => array( 'Bhari_Customize_Sanitize', '_sanitize_hex_color' ),
		// 'transport'         => 'postMessage'
	) );

	// Add Layout control
	$wp_customize->add_control( 'bhari[sidebar-page]', array(
		'type'    => 'select',
		'label'   => __( 'Sidebar for Pages', 'bhari' ),
		'description'   => __( 'Add sidebar layout for pages only.', 'bhari' ),
		'section' => 'bhari_sidebars',
		'choices' => array(
			'layout-no-sidebar'              => __( 'Full Width ( No Sidebar )', 'bhari' ),
			'layout-sidebar-content'         => __( 'Sidebar / Content', 'bhari' ),
			'layout-content-sidebar'         => __( 'Content / Sidebar', 'bhari' ),
			'layout-content-sidebar-sidebar' => __( 'Content / Sidebar / Sidebar', 'bhari' ),
			'layout-sidebar-content-sidebar' => __( 'Sidebar / Content / Sidebar', 'bhari' ),
			'layout-sidebar-sidebar-content' => __( 'Sidebar / Sidebar / Content', 'bhari' ),
		),
		// 'settings' => 'bhari[sidebar]',
		// 'priority' => 30
	) );

	$wp_customize->add_setting( 'bhari[sidebar-single]', array(
		'default'           => $defaults['sidebar-single'],
		'type'              => 'option',
		'sanitize_callback' => array( 'Bhari_Customize_Sanitize', '_sanitize_choices' ),
		// 'transport'         => 'postMessage'
	) );

	// Add Layout control
	$wp_customize->add_control( 'bhari[sidebar-single]', array(
		'type'    => 'select',
		'label'   => __( 'Sidebar for Single Post', 'bhari' ),
		'description'   => __( 'Add sidebar layout for single post only.', 'bhari' ),
		'section' => 'bhari_sidebars',
		'choices' => array(
			'layout-no-sidebar'              => __( 'Full Width ( No Sidebar )', 'bhari' ),
			'layout-sidebar-content'         => __( 'Sidebar / Content', 'bhari' ),
			'layout-content-sidebar'         => __( 'Content / Sidebar', 'bhari' ),
			'layout-content-sidebar-sidebar' => __( 'Content / Sidebar / Sidebar', 'bhari' ),
			'layout-sidebar-content-sidebar' => __( 'Sidebar / Content / Sidebar', 'bhari' ),
			'layout-sidebar-sidebar-content' => __( 'Sidebar / Sidebar / Content', 'bhari' ),
		),
		// 'settings' => 'bhari[sidebar]',
		// 'priority' => 30
	) );

	$wp_customize->add_setting( 'bhari[sidebar-archive]', array(
		'default'           => $defaults['sidebar-archive'],
		'type'              => 'option',
		'sanitize_callback' => array( 'Bhari_Customize_Sanitize', '_sanitize_choices' ),
		// 'transport'         => 'postMessage'
	) );

	// Add Layout control
	$wp_customize->add_control( 'bhari[sidebar-archive]', array(
		'type'    => 'select',
		'label'   => __( 'Sidebar for Archive', 'bhari' ),
		'description'   => __( 'Add sidebar layout for blog, archive, category tag pages.', 'bhari' ),
		'section' => 'bhari_sidebars',
		'choices' => array(
			'layout-no-sidebar'              => __( 'Full Width ( No Sidebar )', 'bhari' ),
			'layout-sidebar-content'         => __( 'Sidebar / Content', 'bhari' ),
			'layout-content-sidebar'         => __( 'Content / Sidebar', 'bhari' ),
			'layout-content-sidebar-sidebar' => __( 'Content / Sidebar / Sidebar', 'bhari' ),
			'layout-sidebar-content-sidebar' => __( 'Sidebar / Content / Sidebar', 'bhari' ),
			'layout-sidebar-sidebar-content' => __( 'Sidebar / Sidebar / Content', 'bhari' ),
		),
		// 'settings' => 'bhari[sidebar]',
		// 'priority' => 30
	) );

	if ( class_exists( 'WP_Customize_Panel' ) ) :
		if ( ! $wp_customize->get_panel( 'bhari_panel_container' ) ) {
			$wp_customize->add_panel( 'bhari_panel_container', array(
				'capability' => 'edit_theme_options',
				'title'      => __( 'Container','bhari' ),
				'priority'   => 40,
			) );
		}
	endif;

	$wp_customize->add_section( 'bhari_section_container', array(
		'title'      => __( 'Container', 'bhari' ),
		'capability' => 'edit_theme_options',
		'panel'      => 'bhari_panel_container'
	) );

	// Container width
	$wp_customize->add_setting( 'bhari[container-width-archive]', array(
		'default' => $defaults['container-width-archive'],
		'type' => 'option',
		'sanitize_callback' => array( 'Bhari_Customize_Sanitize', '_sanitize_integer' ),
		'transport' => 'postMessage'
	) );

	$wp_customize->add_control( new Bhari_Customize_Width_Slider_Control( $wp_customize, 'bhari[container-width-archive]', array(
		'label'       => __('Archive','bhari'),
		'description' => __('Container width for archive pages.','bhari'),
		'tooltip'     => __('Container width is applied for the blog, category, tag and custom post type archive pages.','bhari'),
		'section'     => 'bhari_section_container',
		'priority'    => 0,
		'type'        => 'bhari-range-slider',
		'default'     => $defaults['container-width-archive'],
		'unit'        => 'px',
		'min'         => 700,
		'max'         => 2000,
		'step'        => 5,
		'settings'    => 'bhari[container-width-archive]',
	)));

	// Container width
	$wp_customize->add_setting( 'bhari[container-width-single]', array(
		'default' => $defaults['container-width-single'],
		'type' => 'option',
		'sanitize_callback' => array( 'Bhari_Customize_Sanitize', '_sanitize_integer' ),
		'transport' => 'postMessage'
	) );

	$wp_customize->add_control( new Bhari_Customize_Width_Slider_Control( $wp_customize, 'bhari[container-width-single]', array(
		'label'    => __('Container Width - Single','bhari'),
		'section'  => 'bhari_section_container',
		'priority' => 0,
		'type'     => 'bhari-range-slider',
		'default'  => $defaults['container-width-single'],
		'unit'     => 'px',
		'min'      => 700,
		'max'      => 2000,
		'step'     => 5,
		'settings' => 'bhari[container-width-single]',
	)));

	// Container width
	$wp_customize->add_setting( 'bhari[container-width-page]', array(
		'default' => $defaults['container-width-page'],
		'type' => 'option',
		'sanitize_callback' => array( 'Bhari_Customize_Sanitize', '_sanitize_integer' ),
		'transport' => 'postMessage'
	) );

	$wp_customize->add_control( new Bhari_Customize_Width_Slider_Control( $wp_customize, 'bhari[container-width-page]', array(
		'label'    => __('Container Width - Page','bhari'),
		'section'  => 'bhari_section_container',
		'priority' => 0,
		'type'     => 'bhari-range-slider',
		'default'  => $defaults['container-width-page'],
		'unit'     => 'px',
		'min'      => 700,
		'max'      => 2000,
		'step'     => 5,
		'settings' => 'bhari[container-width-page]',
	)));

	/**
	 * Section - Colors
	 */
	$wp_customize->add_setting( 'bhari[link-color]', array(
		'default'              => $defaults['link-color'],
		'sanitize_callback'    => array( 'Bhari_Customize_Sanitize', '_sanitize_hex_color' ),
		'sanitize_js_callback' => 'maybe_hash_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bhari[link-color]', array(
		'label'   => __( 'Link / Theme Color' ),
		'section'     => 'colors',
		// 'priority' => 40,
	) ) );

	$wp_customize->add_setting( 'bhari[link-h-color]', array(
		'default'              => $defaults['link-h-color'],
		'sanitize_callback'    => array( 'Bhari_Customize_Sanitize', '_sanitize_hex_color' ),
		'sanitize_js_callback' => 'maybe_hash_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bhari[link-h-color]', array(
		'label'   => __( 'Link Hover Color' ),
		'section'     => 'colors',
		// 'priority' => 40,
	) ) );

	$wp_customize->add_setting( 'bhari[text-color]', array(
		'default'              => $defaults['text-color'],
		'sanitize_callback'    => array( 'Bhari_Customize_Sanitize', '_sanitize_hex_color' ),
		'sanitize_js_callback' => 'maybe_hash_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'bhari[text-color]', array(
		'label'   => __( 'Text Color' ),
		'section'     => 'colors',
		// 'priority' => 40,
	) ) );
}
add_action( 'customize_register', 'bhari_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function bhari_customize_preview_js() {

	if( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
		wp_enqueue_script( 'bhari-customizer-js', get_template_directory_uri() . '/inc/assets/unminified/js/customizer.js', array( 'customize-preview' ), '20151215', true );
	} else {
		wp_enqueue_script( 'bhari-customizer-js', get_template_directory_uri() . '/inc/assets/minified/js/customizer.min.js', array( 'customize-preview' ), '20151215', true );
	}
}
add_action( 'customize_preview_init', 'bhari_customize_preview_js' );

if ( ! function_exists( 'bhari_customizer_controls_css' ) ) :
/**
 * Add CSS for our controls
 *
 * @since 1.0.0
 */
add_action( 'customize_controls_enqueue_scripts', 'bhari_customizer_controls_css' );
function bhari_customizer_controls_css()
{
	if( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
		wp_enqueue_style( 'bhari-customizer-controls-css', get_template_directory_uri().'/inc/assets/unminified/css/customizer.css', array() );
	} else {
		wp_enqueue_style( 'bhari-customizer-controls-css', get_template_directory_uri().'/inc/assets/minified/css/customizer.min.css', array() );
	}
}
endif;
