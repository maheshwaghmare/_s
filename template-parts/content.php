<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Awesome_Blog
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">

		<?php
		if ( is_single() ) :

			if( has_post_thumbnail( get_the_ID() ) ) : ?>
				<div class="entry-thumbnail">
					<?php the_post_thumbnail(); ?>
				</div><!-- .entry-thumbnail -->	
			<?php
			endif;

			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			if( has_post_thumbnail( get_the_ID() ) ) : ?>
				<div class="entry-thumbnail">
					<?php the_post_thumbnail(); ?>
				</div><!-- .entry-thumbnail -->	
			<?php
			endif;
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php awesome_blog_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php
		endif; ?>

	</header><!-- .entry-header -->

	<div class="entry-content">

		<?php
			if ( is_single() ) :
				the_content( sprintf(
					/* translators: %s: Name of current post. */
					wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'awesome-blog' ), array( 'span' => array( 'class' => array() ) ) ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				) );
			else :
				the_excerpt();
			endif;

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'awesome-blog' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php awesome_blog_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
