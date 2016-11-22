/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

    /* About us button */
    wp.customize( 'naturelle_our_story_button', function(value) {
        value.bind(function( to ) {

            if( to !== '' ) {
                $( '.standard-button-story' ).removeClass( 'llorix_one_lite_only_customizer' );
            } else {
                $( '.standard-button-story' ).addClass( 'llorix_one_lite_only_customizer' );
            }
            $( '.standard-button-story' ).text( to );

        } );
    });

    /* Logis title */
    wp.customize( 'naturelle_logos_title', function(value) {
        value.bind(function( to ) {

            if( to !== '' ) {
                $( '.clients h2' ).removeClass( 'llorix_one_lite_only_customizer' );
            } else {
                $( '.clients h2' ).addClass( 'llorix_one_lite_only_customizer' );
            }
            $( '.clients h2' ).text( to );

        } );
    });


} )( jQuery );