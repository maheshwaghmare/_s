<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Bhari
 */

/**
 * Content Width
 *
 * 'container-width-archive'		Applied for archive pages (Front page as a Blog page)
 * 'container-width-page'			Applied for Only pages. (Front page as a Static page)
 * 'container-width-single'			Applied for Only single post.
 */
function bhari_wp_head( $classes ) {

	if( is_home() || is_archive() ) {
		$page = 'Blog as Home / Archive';
		$content_width = bhari_get_option( 'container-width-archive' );
	} else if( is_page() || is_404() ) {
		$page = 'Static page as Home / Page';
		$content_width = bhari_get_option( 'container-width-page' );
	} else if( is_single() ) {
		$page = 'Post';
		$content_width = bhari_get_option( 'container-width-single' );
	} else {
		$page = 'Not found';
		$content_width = 1100;
	}
	// vl( $page . ' ' . $content_width );

	?>
	<style type="text/css">
		.site-content {
			max-width: <?php esc_attr_e( $content_width ); ?>px;
		}
	</style>
	<?php

	return $classes;
}

add_filter( 'wp_head', 'bhari_wp_head' );

function bhari_body_class( $classes ) {

	if( is_home() || is_archive() ) {
		$layout = bhari_get_option( 'sidebar-archive' );
	} else if( is_page() || is_404() ) {
		$layout = bhari_get_option( 'sidebar-page' );
	} else if( is_single() ) {
		$layout = bhari_get_option( 'sidebar-single' );
	}

	switch ( $layout ) {

		/**
		 * Sidebar at Left
		 * or
		 * Sidebar at Right
		 */
		case 'layout-sidebar-content' :
		case 'layout-content-sidebar' :
				
				if ( is_active_sidebar( 'sidebar-1' ) ) {
					$classes[] = 'layout-content-sidebar';
				} else if ( is_active_sidebar( 'sidebar-2' ) ) {
					$classes[] = 'layout-sidebar-content';
				}

			break;

		/**
		 * Content | Sidebar | Sidebar
		 *
		 * Both sidebar's are active?
		 */
		case 'layout-content-sidebar-sidebar' :

				if ( is_active_sidebar( 'sidebar-1' ) && is_active_sidebar( 'sidebar-2' ) ) {
					$classes[] = 'layout-content-sidebar-sidebar';
				} else {
					$classes[] = 'layout-content-sidebar';
				}

			break;

		/**
		 * Sidebar | Content | Sidebar
		 *
		 * Both sidebar's are active?
		 */
		case 'layout-sidebar-content-sidebar' :
				if ( is_active_sidebar( 'sidebar-1' ) && is_active_sidebar( 'sidebar-2' ) ) {
					$classes[] = 'layout-sidebar-content-sidebar';
				} else {
					$classes[] = 'layout-sidebar-content';
				}
			break;

		/**
		 * Sidebar | Sidebar | Content
		 *
		 * Both sidebar's are active?
		 */
		case 'layout-sidebar-sidebar-content' :
				if ( is_active_sidebar( 'sidebar-1' ) && is_active_sidebar( 'sidebar-2' ) ) {
					$classes[] = 'layout-sidebar-sidebar-content';
				} else {
					$classes[] = 'layout-sidebar-content';
				}
			break;

		/**
		 * Not any sidebar active?
		 */
		case 'layout-no-sidebar' :
		default:
				$classes[] = 'layout-no-sidebar';
			break;
	}

	return $classes;
}

add_filter( 'body_class', 'bhari_body_class' );

function bhari_get_sidebar_layout( $layout ) {

	switch ( $layout ) {

		/**
		 * Add Only One sidebar
		 * 
		 * Either left / right sidebar
		 */
		case 'layout-sidebar-content' :
		case 'layout-content-sidebar' :
				if ( is_active_sidebar( 'sidebar-1' ) ) {
					get_sidebar( 'right' );
				} else if ( is_active_sidebar( 'sidebar-2' ) ) {
					get_sidebar( 'left' );
				}
			break;

		/**
		 * Add left and right sidebar
		 */
		case 'layout-content-sidebar-sidebar' :
		case 'layout-sidebar-content-sidebar' :
		case 'layout-sidebar-sidebar-content' :
				if ( is_active_sidebar( 'sidebar-1' ) ) {
					get_sidebar( 'right' );
				}
				if ( is_active_sidebar( 'sidebar-2' ) ) {
					get_sidebar( 'left' );
				}
			break;

		case 'layout-no-sidebar' :
		default:
			break;
	}
}

function bhari_get_sidebar_page() {
	$layout = bhari_get_option( 'sidebar-page' );
	bhari_get_sidebar_layout( $layout );
}

function bhari_get_sidebar_single() {
	$layout = bhari_get_option( 'sidebar-single' );
	bhari_get_sidebar_layout( $layout );
}

function bhari_get_sidebar_archive() {
	$layout = bhari_get_option( 'sidebar-archive' );
	bhari_get_sidebar_layout( $layout );
}

add_action( 'wp_head', function() {
	$sidebar_single  = bhari_get_option( 'bhari[sidebar-single]');
	$sidebar_archive = bhari_get_option( 'bhari[sidebar-archive]');
} );


if ( ! function_exists( 'bhari_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function bhari_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( '%s', 'post date', 'bhari' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( '%s', 'post author', 'bhari' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="byline"> ' . get_avatar( esc_url( get_the_author_meta( 'ID' ) ), 20 );
	echo $byline . '</span>';
	echo '<span class="posted-on"><i class="fa fa-calendar"></i> ' . $posted_on . '</span>'; // WPCS: XSS OK.

	/* translators: used between list items, there is a space after the comma */
	$categories_list = get_the_category_list( esc_html__( ', ', 'bhari' ) );
	if ( $categories_list && bhari_categorized_blog() ) {
		printf( '<span class="cat-links"> <i class="fa fa-folder"></i>' . esc_html__( '%1$s', 'bhari' ) . '</span>', $categories_list ); // WPCS: XSS OK.
	}

	/* translators: used between list items, there is a space after the comma */
	$tags_list = get_the_tag_list( '', esc_html__( ', ', 'bhari' ) );
	if ( $tags_list ) {
		printf( '<span class="tags-links"> <i class="fa fa-tags"></i>' . esc_html__( '%1$s', 'bhari' ) . '</span>', $tags_list ); // WPCS: XSS OK.
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'bhari' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link"> <i class="fa fa-edit"></i> ',
		'</span>'
	);

}
endif;

if ( ! function_exists( 'bhari_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function bhari_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() && is_single() ) {

		// $byline = sprintf(
		// 	esc_html_x( '%s', 'post author', 'bhari' ),
		// 	'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		// );

		// echo '<span class="byline"> ' . get_avatar( esc_url( get_the_author_meta( 'ID' ) ), 100 );
		// echo $byline . '</span>';
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link"> <i class="fa fa-comments"></i> ';
		/* translators: %s: post title */
		comments_popup_link( sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'bhari' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() ) );
		echo '</span>';
	}
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function bhari_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'bhari_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'bhari_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so bhari_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so bhari_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in bhari_categorized_blog.
 */
function bhari_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'bhari_categories' );
}
add_action( 'edit_category', 'bhari_category_transient_flusher' );
add_action( 'save_post',     'bhari_category_transient_flusher' );
