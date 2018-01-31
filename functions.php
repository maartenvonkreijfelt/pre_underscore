<?php
/**
 * Pre Underscores functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Pre_Underscores
 */

if ( ! function_exists( 'pre_underscores_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function pre_underscores_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Pre Underscores, use a find and replace
		 * to change 'pre_underscores' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'pre_underscores', get_template_directory() . '/languages' );

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
			'primary' => esc_html__( 'Primary', 'pre_underscores' ),
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
		add_theme_support( 'custom-background', apply_filters( 'pre_underscores_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'pre_underscores_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function pre_underscores_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'pre_underscores_content_width', 640 );
}
add_action( 'after_setup_theme', 'pre_underscores_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function pre_underscores_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'pre_underscores' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'pre_underscores' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'pre_underscores_widgets_init' );




/**
 * Register custom fonts.
 */
function pre_underscores_fonts_url() {
	$fonts_url = '';

	/**
	 * Translators: If there are characters in your language that are not
	 * supported by Open Sans and Ubuntu, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$open_sans = _x( 'on', 'Open Sans font: on or off', 'pre_underscores' );
	$ubuntu = _x( 'on', 'Ubuntu: on or off', 'pre_underscores' );

	$font_families = array();

	if ( 'off' !== $open_sans ) {
		$font_families[] = 'Open Sans:300';
	}

	if ( 'off' !== $ubuntu ) {
		$font_families[] = 'Ubuntu';
	}


	if ( in_array( 'on', array($open_sans, $ubuntu) ) ) {

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Add preconnect for Google Fonts.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function pre_underscore_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'pre-underscores-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'pre_underscore_resource_hints', 10, 2 );



/**
 * Enqueue scripts and styles.
 */
function pre_underscores_scripts() {
	//Enqueue Google fonts: Open+Sans and Ubuntu
	wp_enqueue_style('pre-underscores-fonts', pre_underscores_fonts_url() );
	//wp_enqueue_style('pre-underscore-fonts', 'https://fonts.googleapis.com/css?family=Open+Sans:300|Ubuntu');



	wp_enqueue_style( 'pre_underscores-style', get_stylesheet_uri() );

	wp_enqueue_script( 'pre_underscores-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );
	wp_enqueue_script( 'pre_underscores-functions', get_template_directory_uri() . '/js/functions.js', array('jquery'), '20181831', true );

	wp_localize_script( 'pre_underscores-navigation', 'pre_underscoresScreenReaderText', array(
		'expand' => __( 'Expand child menu', 'pre_underscores'),
		'collapse' => __( 'Collapse child menu', 'pre_underscores'),
	));


	wp_enqueue_script( 'pre_underscores-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'pre_underscores_scripts' );






/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

