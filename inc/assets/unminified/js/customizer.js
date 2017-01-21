/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

function bhari_colors_live_update( id, selector, property, default_value ) {
	default_value = typeof default_value !== 'undefined' ? default_value : 'initial';
	wp.customize( 'generate_settings[' + id + ']', function( value ) {
		value.bind( function( newval ) {
			newval = ( '' !== newval ) ? newval : default_value;
			if ( jQuery( 'style#' + id ).length ) {
				jQuery( 'style#' + id ).html( selector + '{' + property + ':' + newval + ';}' );
			} else {
				jQuery( 'head' ).append( '<style id="' + id + '">' + selector + '{' + property + ':' + newval + '}</style>' );
				setTimeout(function() {
					jQuery( 'style#' + id ).not( ':last' ).remove();
				}, 1000);
			}
		} );
	} );
}

function bhari_classes_live_update( id, classes, selector, prefix ) {
	classes = typeof classes !== 'undefined' ? classes : '';
	prefix = typeof prefix !== 'undefined' ? prefix : '';
	wp.customize( 'generate_settings[' + id + ']', function( value ) {
		value.bind( function( newval ) {
			jQuery.each( classes, function( i, v ) {
				jQuery( selector ).removeClass( v );
			});
			jQuery( selector ).addClass( prefix + newval );
		} );
	} );
}

( function( $ ) {

	
	/** 
	 * Link color hover
	 * Empty:  initial
	 */
	bhari_colors_live_update( 'link_color_hover', 'a:hover', 'color', 'initial' );

	/** 
	 * Content layout
	 */
	bhari_classes_live_update( 'content_layout_setting', [ 'one-container', 'separate-containers' ], 'body' );


	/** 
	 * Container width for Page
	 *
	 * Applied for:
	 * 
	 * .error404,
	 * .page
	 * 
	 */
	wp.customize( 'bhari[container-width-page]', function( value ) {
		value.bind( function( newval ) {
			var selector  = '.error404 .site-content,';
				selector += '.page .site-content';

			if ( jQuery( 'style#container_width_page' ).length ) {
				jQuery( 'style#container_width_page' ).html( selector + ' { max-width:' + newval + 'px;}' );
			} else {
				jQuery( 'head' ).append( '<style id="container_width_page"> ' + selector + ' { max-width:' + newval + 'px;}</style>' );
				setTimeout(function() {
					jQuery( 'style#container_width_page' ).not( ':last' ).remove();
				}, 100);
			}
		} );
	} );

	/** 
	 * Container width for Archive
	 * 
	 * Applied for:
	 * 
	 * .archive
	 * .blog
	 */
	wp.customize( 'bhari[container-width-archive]', function( value ) {
		value.bind( function( newval ) {
			var selector  = '.archive .site-content,';
				selector += '.blog .site-content';

			if ( jQuery( 'style#container_width_archive' ).length ) {
				jQuery( 'style#container_width_archive' ).html( selector + ' { max-width:' + newval + 'px;}' );
			} else {
				jQuery( 'head' ).append( '<style id="container_width_archive"> ' + selector + ' { max-width:' + newval + 'px;}</style>' );
				setTimeout(function() {
					jQuery( 'style#container_width_archive' ).not( ':last' ).remove();
				}, 100);
			}
		} );
	} );

	/** 
	 * Container width for Single
	 * 
	 * Applied for:
	 * 
	 * .single
	 */
	wp.customize( 'bhari[container-width-single]', function( value ) {
		value.bind( function( newval ) {
			var selector  = '.single .site-content';

			if ( jQuery( 'style#container_width_single' ).length ) {
				jQuery( 'style#container_width_single' ).html( selector + ' { max-width:' + newval + 'px;}' );
			} else {
				jQuery( 'head' ).append( '<style id="container_width_single"> ' + selector + ' { max-width:' + newval + 'px;}</style>' );
				setTimeout(function() {
					jQuery( 'style#container_width_single' ).not( ':last' ).remove();
				}, 100);
			}
		} );
	} );

	/** 
	 * Site Title
	 */
	wp.customize( 'blogname', function( value ) {
		value.bind( function( newval ) {
			$( '.main-title a' ).html( newval );
		} );
	} );
	
	/** 
	 * Site Description
	 */
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( newval ) {
			$( '.site-description' ).html( newval );
		} );
	} );


	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title a, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title a, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				$( '.site-title a, .site-description' ).css( {
					'color': to
				} );
			}
		} );
	} );
} )( jQuery );
