<?php



// Remove dashicons in frontend for unauthenticated users
add_action( 'wp_enqueue_scripts', 'bs_dequeue_dashicons' );
function bs_dequeue_dashicons() {
    if ( ! is_user_logged_in() ) {
        wp_deregister_style( 'dashicons' );
    }
}


function remove_jquery_migrate( $scripts ) {
   if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
        $script = $scripts->registered['jquery'];
   if ( $script->deps ) {
// Check whether the script has any dependencies

        $script->deps = array_diff( $script->deps, array( 'jquery-migrate' ) );
 }
 }
 }
add_action( 'wp_default_scripts', 'remove_jquery_migrate' );


/**
 * Removes the preconnect to fonts.gstatic.com
 */
add_filter('autoptimize_html_after_minify', function($content) {

    $content = str_replace("<link rel='preconnect' href='https://fonts.gstatic.com' crossorigin />", ' ', $content);

    return $content;
}, 10, 1);



//elementor page speed fixes
add_action( 'elementor/frontend/after_register_styles',function() {
  foreach( [ 'solid', 'regular', 'brands' ] as $style ) {
    wp_deregister_style( 'elementor-icons-fa-' . $style );
  }
}, 20 );

add_action( 'wp_enqueue_scripts', 'remove_default_stylesheet', 20 );
function remove_default_stylesheet() {
	wp_deregister_style( 'elementor-icons' );
}



add_filter( 'elementor/frontend/print_google_fonts', '__return_false' );




function mytheme_template_redirect() {
    if(is_singular('authors')) {
        global $wp_query;
        $page = (int)$wp_query->get('page');
        if($page > 1) {
            $query->set('page', 1);
            $query->set('paged', $page);
        }
        remove_action('template_redirect', 'redirect_canonical');
    }
}

add_action('template_redirect', 'mytheme_template_redirect', 0);








//bring in min stylesheet through plugin inline option
//need to add fake css to input box in settings of inline css to bring this in
add_filter('autoptimize_filter_css_defer_inline','my_ao_css_defer_inline',10,1);
function my_ao_css_defer_inline($inlined) {
    
    //automatic file versioning base on save info
    $style_saved_css_version = filemtime( get_stylesheet_directory().'/style.min.css' );
    
	return $inlined.'</style><link rel="stylesheet" href="'.get_stylesheet_directory_uri().'/style.min.css?v='.$style_saved_css_version.'" media="all"><style>';
}

//for some reason preview broke with plugin update
add_filter('autoptimize_filter_noptimize','turn_on_for_preview',10,0);
function turn_on_for_preview() {
	 if ( is_preview() ) {
		return false;
	} 
}

         


//to fix cls issue with the defere css for elementor pages i need to turn off inline css on there pages in cms and add in my stylesheet this way.
function my_plugin_frontend_stylesheets() {
    
     //automatic file versioning base on save info
    $style_saved_css_version = filemtime( get_stylesheet_directory().'/style.min.css' );
    
    wp_enqueue_style( 'our-styles-min', get_stylesheet_directory_uri() . '/style.min.css', false, ''.$style_saved_css_version.'', 'all' );
    
    add_filter('autoptimize_filter_css_defer','turn_it_off_elm',10,0);
    
    function turn_it_off_elm() {
            return false;
    }
    
}
add_action( 'elementor/frontend/after_enqueue_styles', 'my_plugin_frontend_stylesheets' );


