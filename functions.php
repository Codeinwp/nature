<?php
/**
 * Naturelle Main functions file
 *
 * @package naturelle
 */

/**
 * Enqueue styles and scripts
 */
function naturelle_enqueue_styles() {
	$parent_style = 'naturelle-parent-style';
	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'naturelle-fonts', naturelle_fonts_url(), array(), null );
	wp_enqueue_script( 'naturelle-cutom-script', llorix_one_lite_get_file( '/js/custom.js' ), array(), '1.0.1', true );
}
add_action( 'wp_enqueue_scripts', 'naturelle_enqueue_styles' );

/**
 * Add image size
 */
function naturelle_image_sizes() {
	add_image_size( 'naturelle-post-thumbnail', 1366, 550, true ); // Custom image sizes

	/**
	 * Setup Naturelle's textdomain.
	 *
	 * Translations can be filed in the /languages/ directory.
	 */
	load_child_theme_textdomain( 'naturelle', get_stylesheet_directory() . '/languages' );
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

	/*
	 Translators: If there are characters in your language that are not
     * supported by Bitter, translate this to 'off'. Do not translate into your
     * own language.
     */
	$bitter = _x( 'on', 'Bitter font: on or off', 'naturelle' );
	if ( 'off' !== $bitter ) {
		$font_families = array();
		if ( 'off' !== $bitter ) {
			$font_families[] = 'Bitter:400,400i';
		}
		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
	}
	return $fonts_url;
}

/**
 * Filter the copyright text in footer
 *
 * @param string $copyright The copyright to be filtered.
 *
 * @return string
 */
function naturelle_filter_powered_by( $copyright ) {

	$copyright = sprintf(
		__( '%1$s powered by %2$s', 'naturelle' ),
		sprintf( '<a href="https://themeisle.com/themes/naturelle/" rel="nofollow">%s</a>', esc_html__( 'Naturelle', 'naturelle' ) ),
		sprintf( '<a href="%1$s" rel="nofollow">%2$s</a>', esc_url( __( 'http://wordpress.org/','naturelle' ) ), esc_html__( 'WordPress', 'naturelle' ) )
	);
	return $copyright;
}
add_filter( 'llorix_one_lite_powered_by', 'naturelle_filter_powered_by' );


add_action( 'customize_register','naturelle_customize_register' );

/**
 * Register customize controls
 *
 * @param object $wp_customize Customize object.
 */
function naturelle_customize_register( $wp_customize ) {

	/* Logos section title */
	$wp_customize->add_setting( 'naturelle_logos_title', array(
		'default' => esc_html__( 'Notable partners','naturelle' ),
		'sanitize_callback' => 'llorix_one_lite_sanitize_text',
		'transport' => 'postMessage',
	));
	$wp_customize->add_control( 'naturelle_logos_title', array(
		'label'    => esc_html__( 'Main title', 'naturelle' ),
		'section'  => 'llorix_one_lite_logos_settings_section',
		'priority'    => 10,
	));

	/* Our story section button text */
	$wp_customize->add_setting( 'naturelle_our_story_button', array(
		'default' => esc_html__( 'Learn more','naturelle' ),
		'sanitize_callback' => 'llorix_one_lite_sanitize_text',
		'transport' => 'postMessage',
	));
	$wp_customize->add_control( 'naturelle_our_story_button', array(
		'label'    => esc_html__( 'Button text', 'naturelle' ),
		'section'  => 'llorix_one_lite_about_section',
		'priority'    => 50,
	));

	/* Our story section button link */
	$wp_customize->add_setting( 'naturelle_our_story_button_link', array(
		'default' => esc_html__( '#','naturelle' ),
		'sanitize_callback' => 'llorix_one_lite_sanitize_text',
		'transport' => 'postMessage',
	));
	$wp_customize->add_control( 'naturelle_our_story_button_link', array(
		'label'    => esc_html__( 'Button link', 'naturelle' ),
		'section'  => 'llorix_one_lite_about_section',
		'priority'    => 60,
	));

}

/**
 * Customizer js file
 */
function naturelle_customizer_live_preview() {
	wp_enqueue_script( 'naturelle_customizer_script', llorix_one_lite_get_file( '/js/naturelle_customizer.js' ), array( 'jquery', 'customize-preview' ), '1.0', true );
}
add_action( 'customize_preview_init', 'naturelle_customizer_live_preview' );


/**
 * Change the excerpt.
 */
function naturelle_theme_setup() {
	// override parent theme's 'more' text for excerpts
	remove_filter( 'excerpt_more', 'llorix_one_lite_excerpt_more' );
}
add_action( 'after_setup_theme', 'naturelle_theme_setup' );

/**
 * Customize the excerpt more message
 *
 * @param string $more The mode tag.
 *
 * @return string
 */
function naturelle_excerpt_more( $more ) {
	global $post;
	return '<span class="read-more-wrap"><a class="moretag" href="' . esc_url( get_permalink( $post->ID ) ) . '">' . esc_html__( 'Continue Reading ', 'naturelle' ) . '<span class="screen-reader-text">' . esc_html( get_the_title() ) . '</span></a></span>';
}
add_filter( 'excerpt_more', 'naturelle_excerpt_more' );

add_filter( 'comment_form_default_fields', 'naturelle_comment_placeholders' );

/**
 * Add Placehoder in comment Form Fields (Name, Email, Website)
 */
function naturelle_comment_placeholders( $fields ) {
	$fields['author'] = str_replace(
		'<input',
		'<input placeholder="' . esc_attr__( 'Name', 'naturelle' ) . '"',
		$fields['author']
	);
	$fields['email'] = str_replace(
		'<input',
		'<input placeholder="' . esc_attr__( 'Email', 'naturelle' ) . '"',
		$fields['email']
	);
	$fields['url'] = str_replace(
		'<input',
		'<input placeholder="' . esc_attr__( 'Website', 'naturelle' ) . '"',
		$fields['url']
	);
	return $fields;
}

add_filter( 'comment_form_defaults', 'naturelle_textarea_placeholder' );

/**
 * Add Placehoder in comment Form Field (Comment)
 */
function naturelle_textarea_placeholder( $fields ) {

	$fields['comment_field'] = str_replace(
		'<textarea',
		'<textarea placeholder="' . esc_html( 'Comment', 'naturelle' ) . '"',
		$fields['comment_field']
	);
	return $fields;
}

add_action( 'llorix_one_lite_header_top_right_close', 'naturelle_add_header_search', 1 );

/**
 * Search form in footer
 */
function naturelle_add_header_search() {

	echo '<div class="header-search">';
		echo '<div class="glyphicon glyphicon-search header-search-button"><i class="fa fa-search" aria-hidden="true"></i></div>';
		echo '<div class="header-search-input">';
			get_search_form();
		echo '</div>';
	echo '</div>';
}

add_action( 'llorix_one_lite_home_logos_section_open', 'naturelle_logos_title', 1 );

/**
 * Logos title
 */
function naturelle_logos_title() {
	$naturelle_title = get_theme_mod( 'naturelle_logos_title',esc_html__( 'Notable partners','naturelle' ) );
	if ( ! empty( $naturelle_title ) || is_customize_preview() ) {
		echo '<h2 class="text-left dark-text' . ( empty( $naturelle_title ) && is_customize_preview() ? ' llorix_one_lite_only_customizer' : '' ) . '">' . $naturelle_title . '</h2>';
	}
}

add_action( 'llorix_one_lite_home_about_section_content_one_after', 'naturelle_about_button', 1 );

/**
 * About button
 */
function naturelle_about_button() {
	$naturelle_our_story_button = get_theme_mod( 'naturelle_our_story_button', esc_html__( 'Learn more','naturelle' ) );
	$naturelle_our_story_button_link = get_theme_mod( 'naturelle_our_story_button_link', esc_html__( '#','naturelle' ) );
	if ( ! empty( $naturelle_our_story_button ) || is_customize_preview() ) {
		echo '<a id="inpage_scroll_btn" class="btn btn-primary standard-button inpage-scroll standard-button-story' . ( empty( $naturelle_our_story_button ) && is_customize_preview() ? ' llorix_one_lite_only_customizer' : '' ) . '" href="' . esc_attr( $naturelle_our_story_button_link ) . '"><span class="screen-reader-text">' . esc_html__( 'Header button label:','naturelle' ) . esc_html( $naturelle_our_story_button ) . '</span>' . esc_html( $naturelle_our_story_button ) . '</a>';
	}
}

/**
 * Homepage section order
 */
function naturelle_sections_order() {
	$naturelle_order = array(
		'our-services-section',
		'sections/llorix_one_lite_our_story_section',
		'our-team-section',
		'happy-customers-section',
		'sections/llorix_one_lite_content_section',
		'sections/llorix_one_lite_latest_news_section',
		'sections/llorix_one_lite_logos_section',
		'sections/llorix_one_lite_ribbon_section',
		'sections/llorix_one_lite_contact_info_section',
		'sections/llorix_one_lite_map_section',
	);
	return $naturelle_order;
}
add_filter( 'llorix_one_companion_sections_filter', 'naturelle_sections_order' );

/**
 * Disable by default the header logo from the parent theme
 *
 * @return bool
 */
add_filter( 'llorix_one_lite_header_logo_filter', '__return_false' );

/**
 * Disable by default the header subtitle from the parent theme
 *
 * @return string
 */
add_filter( 'llorix_one_lite_header_subtitle_filter', '__return_empty_string' );
