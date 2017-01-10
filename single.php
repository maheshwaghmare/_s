<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Awesome_Blog
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) : the_post();

	        do_action( 'awesome-blog/single-post-content/before' );

			get_template_part( 'template-parts/content', get_post_format() );

	        do_action( 'awesome-blog/single-post-content/after' );

	        do_action( 'awesome-blog/single-post-navigation/before' );

			the_post_navigation( array(
	            'prev_text' => __( '<span class="link-caption">Previous Article</span><span class="link-title">%title</span>' ),
	            'next_text' => __( '<span class="link-caption">Next Article</span><span class="link-title">%title</span>' ),
	        ) );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
		        do_action( 'awesome-blog/single-post-comments/before' );
				comments_template();
		        do_action( 'awesome-blog/single-post-comments/after' );
			endif;


		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php

if ( 'post' !== get_post_type() ) : 
	get_sidebar( 'right' );
endif;

get_footer();
