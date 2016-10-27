<?php

function naturelle_enqueue_styles() {
    $parent_style = 'naturelle-parent-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'naturelle-fonts', naturelle_fonts_url(), array(), null );
	wp_enqueue_script( 'naturelle-cutom-script', llorix_one_lite_get_file( '/js/custom.js' ), array(), '1.0.0', true );
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
		'default' => esc_html__('Notable partners','naturelle'),
		'sanitize_callback' => 'llorix_one_lite_sanitize_text',
		'transport' => 'postMessage'
	));
	$wp_customize->add_control( 'naturelle_logos_title', array(
		'label'    => esc_html__( 'Main title', 'naturelle' ),
		'section'  => 'llorix_one_lite_logos_settings_section',
		'priority'    => 10
	));

	/* Our story section button text */
	$wp_customize->add_setting( 'naturelle_our_story_button', array(
		'default' => esc_html__('Learn more','naturelle'),
		'sanitize_callback' => 'llorix_one_lite_sanitize_text',
		'transport' => 'postMessage'
	));
	$wp_customize->add_control( 'naturelle_our_story_button', array(
		'label'    => esc_html__( 'Button text', 'naturelle' ),
		'section'  => 'llorix_one_lite_about_section',
		'priority'    => 50
	));

	/* Our story section button link */
	$wp_customize->add_setting( 'naturelle_our_story_button_link', array(
		'default' => esc_html__('#','naturelle'),
		'sanitize_callback' => 'llorix_one_lite_sanitize_text',
		'transport' => 'postMessage'
	));
	$wp_customize->add_control( 'naturelle_our_story_button_link', array(
		'label'    => esc_html__( 'Button link', 'naturelle' ),
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
function naturelle_theme_setup() {
	// override parent theme's 'more' text for excerpts
	remove_filter( 'excerpt_more', 'llorix_one_lite_excerpt_more' );
}
add_action( 'after_setup_theme', 'naturelle_theme_setup' );

function naturelle_excerpt_more( $more ) {
	global $post;
	return '<span class="read-more-wrap"><a class="moretag" href="' . get_permalink( $post->ID ) . '">' . esc_html__( 'Continue Reading ', 'naturelle' ) . '<span class="screen-reader-text">' . get_the_title() . '</span></a></span>';
}
add_filter( 'excerpt_more', 'naturelle_excerpt_more' );


/* Add Placehoder in comment Form Fields (Name, Email, Website) */
add_filter( 'comment_form_default_fields', 'naturelle_comment_placeholders' );
function naturelle_comment_placeholders( $fields ) {
	$fields['author'] = str_replace(
		'<input',
		'<input placeholder="'.esc_html( 'Name', 'naturelle' ).'"',
		$fields['author']
	);
	$fields['email'] = str_replace(
		'<input',
		'<input placeholder="'.esc_html( 'Email', 'naturelle' ).'"',
		$fields['email']
	);
	$fields['url'] = str_replace(
		'<input',
		'<input placeholder="'.esc_html( 'Website', 'naturelle' ).'"',
		$fields['url']
	);
	return $fields;
}

/* Add Placehoder in comment Form Field (Comment) */
add_filter( 'comment_form_defaults', 'naturelle_textarea_placeholder' );
function naturelle_textarea_placeholder( $fields ) {

	$fields['comment_field'] = str_replace(
		'<textarea',
		'<textarea placeholder="'.esc_html( 'Comment', 'naturelle' ).'"',
		$fields['comment_field']
	);
	return $fields;
}

/* Search form in footer */
add_action('llorix_one_lite_header_top_right_close', 'naturelle_add_header_search', 1);
function naturelle_add_header_search() {

	echo '<div class="header-search">';
		echo '<div class="glyphicon glyphicon-search header-search-button"><i class="fa fa-search" aria-hidden="true"></i></div>';
		echo '<div class="header-search-input">';
			get_search_form();
		echo '</div>';
	echo '</div>';
}

/* Logos title */
add_action('llorix_one_lite_home_logos_section_open', 'naturelle_logos_title', 1);
function naturelle_logos_title() {
	$naturelle_title = get_theme_mod('naturelle_logos_title',esc_html__('Notable partners','naturelle'));
	if ( ! empty( $naturelle_title ) || is_customize_preview() ) {
		echo '<h2 class="text-left dark-text' . ( empty( $naturelle_title ) && is_customize_preview() ? ' llorix_one_lite_only_customizer' : '' ) . '">' . $naturelle_title . '</h2>';
	}
}

/* About button */
add_action('llorix_one_lite_home_about_section_content_one_after', 'naturelle_about_button', 1);
function naturelle_about_button() {
	$naturelle_our_story_button = get_theme_mod( 'naturelle_our_story_button', esc_html__( 'Learn more','naturelle' ) );
	$naturelle_our_story_button_link = get_theme_mod( 'naturelle_our_story_button_link', esc_html__( '#','naturelle' ) );
	if( !empty($naturelle_our_story_button) || is_customize_preview() ) {
		echo '<button id="inpage_scroll_btn" class="btn btn-primary standard-button inpage-scroll standard-button-story'. ( empty($naturelle_our_story_button) && is_customize_preview() ? ' llorix_one_lite_only_customizer' : '' ) .'" data-anchor="' . $naturelle_our_story_button_link . '"><span class="screen-reader-text">' . esc_html__( 'Header button label:','llorix-one-lite' ) . $naturelle_our_story_button . '</span>' . $naturelle_our_story_button . '</button>';
	}
}

/* Homepage section order */
function naturelle_sections_order() {
	$naturelle_order = array(
		'llorix_one_lite_our_services_section',
		'sections/llorix_one_lite_our_story_section',
		'llorix_one_lite_our_team_section',
		'llorix_one_lite_happy_customers_section',
		'sections/llorix_one_lite_latest_news_section',
		'sections/llorix_one_lite_logos_section',
		'sections/llorix_one_lite_ribbon_section',
		'sections/llorix_one_lite_contact_info_section',
		'sections/llorix_one_lite_map_section'
	);
	return $naturelle_order;
}
add_filter( 'llorix_one_companion_sections_filter', 'naturelle_sections_order');


