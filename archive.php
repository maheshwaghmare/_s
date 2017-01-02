<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Awesome_Blog
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
					if( is_tag() ) {
						the_archive_title( '<h1 class="page-title"> <i class="fa fa-tag"></i> ', '</h1>' );
					} else if( is_category() ) {
						the_archive_title( '<h1 class="page-title"> <i class="fa fa-folder"></i> ', '</h1>' );
					} else if( is_date() ) {
						the_archive_title( '<h1 class="page-title"> <i class="fa fa-calendar"></i> ', '</h1>' );
					} else if( is_author() ) {
						the_archive_title( '<h1 class="page-title"> ' . get_avatar( esc_url( get_the_author_meta( 'ID' ) ), 50 ), '</h1>' );
					} else {
						the_archive_title( '<h1 class="page-title">', '</h1>' );
					}
					the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );

			endwhile;

			the_posts_pagination( array(
				'mid_size'  => 4,
				'prev_text' => __( '<i class="fa fa-angle-left"></i> Previous', 'awesome-blog' ),
				'next_text' => __( 'Next <i class="fa fa-angle-right"></i>', 'awesome-blog' ),
			) );

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
