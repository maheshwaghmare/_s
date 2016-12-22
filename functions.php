<?php
/**
 * Awesome Blog functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Awesome_Blog
 */

if ( ! function_exists( 'awesome_blog_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function awesome_blog_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Awesome Blog, use a find and replace
	 * to change 'awesome-blog' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'awesome-blog', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'awesome-blog' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'awesome_blog_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'awesome_blog_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function awesome_blog_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'awesome_blog_content_width', 640 );
}
add_action( 'after_setup_theme', 'awesome_blog_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function awesome_blog_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'awesome-blog' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'awesome-blog' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'awesome_blog_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function awesome_blog_scripts() {
	wp_enqueue_style( 'awesome-blog-style', get_stylesheet_uri() );

	wp_enqueue_script( 'awesome-blog-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'awesome-blog-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'awesome_blog_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

add_action( 'wp_footer', function() {
	?>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800" rel="stylesheet">
	<style type="text/css">
		.site-content {
		    max-width: 1000px;
		    margin: 0 auto;
		}
		body {
		    background: #eaeaea;
		    font-family: font-family: 'Open Sans', sans-serif;
		}
		.site-content article {
		    background: #fff;
		    padding: 0.1em 1.5rem;
		}
		.entry-title a {
		    font-size: 1.2em;
		    text-transform: none;
		    text-decoration: none;
		    color: #32373c;
		}
		#primary {
		    float: left;
		    width: 70%;
		}
		#secondary {
		    float: right;
		    width: 30%;
		    padding: 0 20px;
		}
		.widget {
		    background: #fff;
		    padding: 1rem;
		}
		ul {
		    margin: 0;
		}
		/**
		 * Meta
		 */
		.entry-meta {
    		font-size: 0.8rem;
		}
		.entry-content p {
		    margin: 0 0 0.5rem 0;
		}
		.entry-meta a {
		    text-decoration: none;
		}
		.entry-title {
		    margin-bottom: 0.5em;
		}

		button,
		input[type="button"],
		input[type="reset"],
		input[type="submit"] {
		    border: none;
		    border-radius: 0;
		    box-shadow: none;
		    background: #5a4ef8;
		    text-shadow: none;
		    color: #fff;
		    padding: 1em 2em;
		}
		input[type="text"],
		input[type="email"],
		input[type="url"],
		input[type="password"],
		input[type="search"],
		input[type="number"],
		input[type="tel"],
		input[type="range"],
		input[type="date"],
		input[type="month"],
		input[type="week"],
		input[type="time"],
		input[type="datetime"],
		input[type="datetime-local"],
		input[type="color"],
		textarea {
		    border-radius: 0;
		    padding: 0.5em 1em;
		}
		body,
		button,
		input,
		select,
		textarea {
		    font-size: 1rem;
		}
		/**
		 * Colors
		 */
		a,
		a:visited {
			color: #5a4ef8;
		}
	</style>

	<?php
});
