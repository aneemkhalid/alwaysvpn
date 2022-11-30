<?php
/**
 * wp-alwaysvpn functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package wp-alwaysvpn
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.1' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function wp_alwaysvpn_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on wp-alwaysvpn, use a find and replace
		* to change 'wp-alwaysvpn' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'wp-alwaysvpn', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	add_theme_support('align-wide');

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'wp-alwaysvpn' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'wp_alwaysvpn_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 220,
			'width'       => 37,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'wp_alwaysvpn_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function wp_alwaysvpn_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'wp_alwaysvpn_content_width', 640 );
}
add_action( 'after_setup_theme', 'wp_alwaysvpn_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function wp_alwaysvpn_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'wp-alwaysvpn' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'wp-alwaysvpn' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'wp_alwaysvpn_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
/*function wp_alwaysvpn_scripts() {
	//wp_enqueue_style( 'wp-alwaysvpn-style', get_stylesheet_uri(), array(), _S_VERSION );
	//wp_style_add_data( 'wp-alwaysvpn-style', 'rtl', 'replace' );

	wp_enqueue_script( 'wp-alwaysvpn-navigation', get_template_directory_uri() . '/build/index.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wp_alwaysvpn_scripts' );

/**
 * Enqueue admin styles.
 */
function load_admin_styles() {
	wp_enqueue_style( 'admin_css', get_template_directory_uri() . '/admin-styles.css', false, '1.0.0' );
}
add_action( 'admin_enqueue_scripts', 'load_admin_styles' );


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


//custom code


// Add code to <head>
add_action( 'wp_head', 'add_header_scripts' );
function add_header_scripts() {
    echo '<link  href="'.get_stylesheet_directory_uri().'/fonts/raleway-v22-latin-regular.woff2"  as="font" type="font/woff2" crossorigin>
      <link  href="'.get_stylesheet_directory_uri().'/fonts/raleway-v22-latin-700.woff2"  as="font" type="font/woff2" crossorigin>

      ';


    if('https://www.alwaysvpn.com' === home_url() || 'https://stagealwaysvpn.wpengine.com' === home_url() || 'https://devalwaysvpn.wpengine.com' === home_url() ) {
        // Adds gtag snippet to head
        echo "
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-WZPXFQB');</script>
        <!-- End Google Tag Manager -->";

   }
    if('https://www.alwaysvpn.com' === home_url()  || 'https://stagealwaysvpn.wpengine.com' === home_url() ) {
        // Adds hotjar snippet to head on all pages but elementor built ones
         $post_id_elm = get_the_ID(); // Set post ID var.
    
        if ( !Elementor\Plugin::instance()->db->is_built_with_elementor( $post_id_elm ) ) {
            echo '<!-- Hotjar Tracking Code for https://www.alwaysvpn.com --><script>(function(h,o,t,j,a,r){h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};h._hjSettings={hjid:2130042,hjsv:6};a=o.getElementsByTagName("head")[0];r=o.createElement("script");r.async=1;r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;a.appendChild(r);})(window,document,"https://static.hotjar.com/c/hotjar-",".js?sv=");</script>';
 
        }
        
   }
}
// Add code just after opening <body> tag
add_action('wp_body_open', 'add_body_open_scripts');
function add_body_open_scripts() {
    if('https://www.alwaysvpn.com' === home_url() || 'https://stagealwaysvpn.wpengine.com' === home_url() || 'https://devalwaysvpn.wpengine.com' === home_url()) {
        echo '<!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WZPXFQB"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
        ';
    }
   //needs to be on all version of the site to stop the datalayer error when there is no GA

    echo '<script>
        window.dataLayer = window.dataLayer || [];
        </script>';
}


///BRAD START ADDING IN OLD THEME STUFF BELOW HERE

add_action( 'wp_enqueue_scripts', 'alwaysvpn_enqueue_scripts' );
function alwaysvpn_enqueue_scripts() {
   

    wp_enqueue_script( 'alwaysvpn-script', get_stylesheet_directory_uri() . '/build/index.js', array('jquery'), '1.0.2', true );
    
      if(is_page_template('page-lander-template.php')) {

        wp_enqueue_script( 'datatable-scritp', get_stylesheet_directory_uri() . '/build/datatable-bridge.js', array('jquery'), '1.0.0', true );

     } 
    
    
    //wp_enqueue_script( 'appzi', 'https://w.appzi.io/w.js?token=k3vQK', null, null, true );
}


// function sunset_load_admin_scripts(){
//     wp_register_script('sunset-admin-script',get_stylesheet_directory_uri() .'/js/alwaysvpn-script.js', array('jquery'), '1.0.0', true);
//     wp_enqueue_script('sunset-admin-script');
// }
// add_action( 'admin_enqueue_scripts', 'sunset_load_admin_scripts' );

/* ========= LOAD CUSTOM FUNCTIONS ===================================== */
require_once get_stylesheet_directory() . '/inc/functions/functions-custom.php';
require_once get_stylesheet_directory() . '/inc/functions/functions-post-type.php';
require_once get_stylesheet_directory() . '/inc/functions/functions-acfblocks.php';
require_once get_stylesheet_directory() . '/inc/functions/functions-cta.php';
require_once get_stylesheet_directory() . '/inc/functions/functions-site-setup.php';
require_once get_stylesheet_directory() . '/inc/functions/functions-datalayer.php';
require_once get_stylesheet_directory() . '/inc/functions/functions-remove-post-type-slug.php';
require_once get_stylesheet_directory() . '/inc/functions/functions-toast-loader.php'; /* toast */

