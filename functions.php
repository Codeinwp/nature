<?php

function naturelle_enqueue_styles() {
    $parent_style = 'naturelle-parent-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'naturelle-fonts', naturelle_fonts_url(), array(), null );
}
add_action( 'wp_enqueue_scripts', 'naturelle_enqueue_styles' );


if ( get_stylesheet() !== get_template() ) {
    add_filter( 'pre_update_option_theme_mods_' . get_stylesheet(), function ( $value, $old_value ) {
         update_option( 'theme_mods_' . get_template(), $value );
         return $old_value; // prevent update to child theme mods
    }, 10, 2 );
    add_filter( 'pre_option_theme_mods_' . get_stylesheet(), function ( $default ) {
        return get_option( 'theme_mods_' . get_template(), $default );
    } );
}


function naturelle_image_sizes() {
	add_image_size( 'naturelle-post-thumbnail', 1366, 550, true ); // Custom image sizes
}
add_action( 'after_setup_theme', 'naturelle_image_sizes', 11 );

/**
 * Return the Google font stylesheet URL, if available.
 *
 * The use of Source Sans Pro and Bitter by default is localized. For languages
 * that use characters not supported by the font, the font can be disabled.
 *
 * @since InMotion 1.0
 *
 * @return string Font stylesheet or empty string if disabled.
 */
function naturelle_fonts_url() {
    $fonts_url = '';
    /* Translators: If there are characters in your language that are not
     * supported by Bitter, translate this to 'off'. Do not translate into your
     * own language.
     */
    $bitter = _x( 'on', 'Cabin font: on or off', 'zillah' );
    if ( 'off' !== $bitter ) {
        $font_families = array();
        if ( 'off' !== $bitter )
            $font_families[] = 'Bitter:400,400i';
        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );
        $fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
    }
    return $fonts_url;
}


function naturelle_filter_powered_by( $copyright ) {
	$copyright = "<a href=\"http://themeisle.com/themes/naturelle/\" target=\"_blank\" rel=\"nofollow\">Naturelle</a> ".esc_html__( 'powered by', 'naturelle' )." <a href=\"http://wordpress.org/\"  target=\"_blank\" rel=\"nofollow\">".esc_html__( 'WordPress', 'naturelle' )."</a>";
	return $copyright;
}
add_filter( 'llorix_one_lite_powered_by', 'naturelle_filter_powered_by' );


add_action('customize_register','naturelle_customize_register');
function naturelle_customize_register( $wp_customize ) {

	/* Logos section title */
	$wp_customize->add_setting( 'naturelle_logos_title', array(
		'default' => esc_html__('Notable partners','clarina'),
		'sanitize_callback' => 'llorix_one_lite_sanitize_text',
		'transport' => 'postMessage'
	));
	$wp_customize->add_control( 'naturelle_logos_title', array(
		'label'    => esc_html__( 'Main title', 'clarina' ),
		'section'  => 'llorix_one_lite_logos_settings_section',
		'priority'    => 10
	));

	/* Our story section button text */
	$wp_customize->add_setting( 'naturelle_our_story_button', array(
		'default' => esc_html__('Learn more','clarina'),
		'sanitize_callback' => 'llorix_one_lite_sanitize_text',
		'transport' => 'postMessage'
	));
	$wp_customize->add_control( 'naturelle_our_story_button', array(
		'label'    => esc_html__( 'Button text', 'clarina' ),
		'section'  => 'llorix_one_lite_about_section',
		'priority'    => 50
	));

	/* Our story section button link */
	$wp_customize->add_setting( 'naturelle_our_story_button_link', array(
		'default' => esc_html__('#','clarina'),
		'sanitize_callback' => 'llorix_one_lite_sanitize_text',
		'transport' => 'postMessage'
	));
	$wp_customize->add_control( 'naturelle_our_story_button_link', array(
		'label'    => esc_html__( 'Button link', 'clarina' ),
		'section'  => 'llorix_one_lite_about_section',
		'priority'    => 60
	));

}

/* Customizer js file */
function naturelle_customizer_live_preview() {
	wp_enqueue_script( 'naturelle_customizer_script', llorix_one_lite_get_file('/js/naturelle_customizer.js'), array( 'jquery','customize-preview' ), '1.0', true );
}
add_action( 'customize_preview_init', 'naturelle_customizer_live_preview' );


/**
 * Change the excerpt.
 * @param     string $more The excerpt.
 * @return string
 */
function child_theme_setup() {
	// override parent theme's 'more' text for excerpts
	remove_filter( 'excerpt_more', 'llorix_one_lite_excerpt_more' );
}
add_action( 'after_setup_theme', 'child_theme_setup' );

function naturelle_excerpt_more( $more ) {
	global $post;
	return '<span class="read-more-wrap"><a class="moretag" href="' . get_permalink( $post->ID ) . '">' . esc_html__( 'Continue Reading ', 'naturelle' ) . '<span class="screen-reader-text">' . get_the_title() . '</span></a></span>';
}
add_filter( 'excerpt_more', 'naturelle_excerpt_more' );