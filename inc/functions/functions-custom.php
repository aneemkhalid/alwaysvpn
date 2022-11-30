<?php

function sh_remove_wp_version() {
    return '';
}
add_filter('the_generator', 'sh_remove_wp_version');

//GET HEADER TITLE/BREADCRUMBS AREA
if (!function_exists('coinflip_header_title_breadcrumbs')) {
    function coinflip_header_title_breadcrumbs($args = []){
        global $post;

        if (array_key_exists('disclosure', $args)){
            $disclosure_link_on_off = $args['disclosure'];
        } else {
            $disclosure_link_on_off = get_post_meta( get_the_ID(), 'disclosure_link_on_off', true );
        }

        $is_cpt = isset($post) && !is_search() ? !in_array($post->post_type, array('post', 'page')) : false;
        $disclosure_link = '';
        $cpt_breadcrumbs_container = '';
        $search_padding = '';
        if((isset($disclosure_link_on_off) && $disclosure_link_on_off == 'yes') || is_search() || $is_cpt) {
            $disclosure_link = '<a class="breadcrumb disclosure-link" href="/disclosure">Advertiser Disclosure</a>';
        }
        if($is_cpt) $cpt_breadcrumbs_container = ' cpt-breadcrumbs-container';
        if(is_search()) $search_padding = ' search-breadcrumbs-padding';

        $html = '<div class="breadcrumbs-container-row'.$cpt_breadcrumbs_container.'">
                    <div class="breadcrumbs-container'.$search_padding.'">
                        <ol class="breadcrumb">'.coinflip_breadcrumb().'</ol>
                        <span>'.$disclosure_link.'</span>
                    </div>
                </div>
                <div class="clearfix"></div>';
        return $html;
    }
}


if (!function_exists('coinflip_breadcrumb')) {
    function coinflip_breadcrumb() {

        $delimiter = '';
        $html =  '';
        $name = esc_html__("Home", "coinflip");
        $currentBefore = '<li class="active">';
        $currentAfter = '</li>';
        $classes = get_body_class();
        if (!is_home() && !is_front_page() || is_paged()) {
                global  $post;
                $home = esc_url(home_url('/'));
                $html .= '<li><a href="' . esc_url($home) . '">' . esc_html($name) . '</a></li> ' . esc_html($delimiter) . '';

            if( get_post_type($post->ID) == 'watch' ){
                $html .= '<li class="no-link ml-0">Streaming</li>';
                $html .= '<li class="no-link">Watch</li>';
                $html .= '<li class="active">' . get_the_title() . '</li>';
                return $html;
            }

            if (is_category()) {
                global  $wp_query;
                $cat_obj = $wp_query->get_queried_object();
                $thisCat = $cat_obj->term_id;
                $thisCat = get_category($thisCat);
                $parentCat = get_category($thisCat->parent);
                    if ($thisCat->parent != 0)
                $html .= (get_category_parents($parentCat, true, '' . esc_html($delimiter) . ''));
                $html .= $currentBefore . single_cat_title('', false) . $currentAfter ;
            }elseif (in_array('forum-archive',$classes)) {
                $html .= $currentBefore;
                $html .= get_the_title();
                $html .= $currentAfter;
            }elseif (in_array('bbp-user-page',$classes)) {
                $html .= '<li><a href="' . esc_url(get_post_type_archive_link('forum')) . '">' . esc_html__("Forum", "coinflip") . '</a></li> ' . esc_html($delimiter) . '';
                $html .= $currentBefore;
                $html .= get_the_title();
                $html .= $currentAfter;
            }elseif (in_array('forum',$classes)) {
                $html .= '<li><a href="' . esc_url(get_post_type_archive_link('forum')) . '">' . esc_html__("Forum", "coinflip") . '</a></li> ' . esc_html($delimiter) . '';
                $html .= $currentBefore;
                $html .= get_the_title();
                $html .= $currentAfter;
            }elseif (in_array('topic',$classes)) {
                $html .= '<li><a href="' . esc_url(get_post_type_archive_link('forum')) . '">' . esc_html__("Forum", "coinflip") . '</a></li> ' . esc_html($delimiter) . '';
                $html .= $currentBefore;
                $html .= get_the_title();
                $html .= $currentAfter;
            }elseif (is_tax()) {
                global  $wp_query;
                $html .= $currentBefore . single_cat_title('', false) . $currentAfter;
            } elseif (is_day()) {
                $html .= '<li><a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . get_the_time('Y') . '</a></li> ' . esc_html($delimiter) . '';
                $html .= '<li><a href="' . esc_url(get_month_link(get_the_time('Y')), get_the_time('m')) . '">' . get_the_time('F') . '</a></li> ' . esc_html($delimiter) . ' ';
                $html .= $currentBefore . get_the_time('d') . $currentAfter;
            } elseif (is_month()) {
                $html .= '<li><a href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . get_the_time('Y') . '</a></li> ' . esc_html($delimiter) . '';
                $html .= $currentBefore . get_the_time('F') . $currentAfter;
            } elseif (is_year()) {
                $html .= $currentBefore . get_the_time('Y') . $currentAfter;
            } elseif (is_attachment()) {
                $html .= $currentBefore;
                $html .= get_the_title();
                $html .= $currentAfter;
            } elseif (class_exists( 'WooCommerce' ) && is_shop()) {
                $html .= $currentBefore;
                $html .= esc_html__('Lottery','coinflip');
                $html .= $currentAfter;
            } elseif (is_single() && 'authors' != get_post_type()) {    
                if (get_the_category()) {
                    $cat = get_the_category();
                    $cat = $cat[0];
                    if ($cat->cat_ID == 173 ) {
                        //insights
                        $html .= '<li><a href="/insights">Insights</a></li>';
                    } else if ($cat->cat_ID == 172){
                       //guides
                       $html .= '<li><a href="/guides">Guides</a></li>';
                    } else {
                        //other cat
                          $html .= '<li>' . get_category_parents($cat, true, ' ' . esc_html($delimiter) . '') . '</li>';
                    }
                  
                }
                if ($post->post_type == 'deals-pages') {

                     $post_obj = get_post_type_object(get_post_type($post)); 
                      if ( !($post->ID == 53641) ) {
                       $html .= '<li class="tester"><a href="/deals">'.$post_obj->labels->name. '</a></li>' ;
                        }
                  
                } else  if ($post->post_type !== 'post') {
                    $post_obj = get_post_type_object(get_post_type($post));
                    $html .= '<li><a href="/'.$post->post_type.'">'.$post_obj->labels->name. '</a></li>' ;
                }
                $html .= $currentBefore;
                $html .= get_the_title();
                $html .= $currentAfter;
            } elseif (is_singular('authors')){
                if (get_the_category()) {
                    $cat = get_the_category();
                    $cat = $cat[0];
                    $html .= '<li>' . get_category_parents($cat, true, ' ' . esc_html($delimiter) . '') . '</li>';
                }
                if ($post->post_type !== 'post') {
                    $post_obj = get_post_type_object(get_post_type($post));

                    $html .= '<li><a href="/about">'.$post_obj->labels->name. '</a></li>';
                }
                $html .= $currentBefore;
                $html .= get_the_title();
                $html .= $currentAfter;
            } elseif (is_page() && !$post->post_parent) {
                $html .= $currentBefore;
                $html .= get_the_title();
                $html .= $currentAfter;
            } elseif (is_page() && $post->post_parent) {
                $parent_id = $post->post_parent;
                $breadcrumbs = array();
                while ($parent_id) {
                    $page = get_page($parent_id);
                    $breadcrumbs[] = '<li><a href="' . esc_url(get_permalink($page->ID)) . '">' . get_the_title($page->ID) . '</a></li>';
                    $parent_id = $page->post_parent;
                }
                $breadcrumbs = array_reverse($breadcrumbs);
                foreach ($breadcrumbs as $crumb)
                    $html .= $crumb . ' ' . esc_html($delimiter) . ' ';
                $html .= $currentBefore;
                $html .= get_the_title();
                $html .= $currentAfter;
            } elseif (is_search()) {
                $html .= $currentBefore . 'Search Results' . $currentAfter;
            } elseif (is_tag()) {
                $html .= $currentBefore . single_tag_title( '', false ) . $currentAfter;
            } elseif (is_author()) {
                global  $author;
                $userdata = get_userdata($author);
                $html .= $currentBefore . $userdata->display_name . $currentAfter;
            } elseif (is_404()) {
                $html .= $currentBefore . esc_html__('404 Not Found','coinflip') . $currentAfter;
            }
            if (get_query_var('paged')) {
                if (is_home() || is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
                    $html .= $currentBefore;
                if (is_home() || is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
                    $html .= $currentAfter;
            }
        }
        return $html;
    }
}



function set_rating_css_background($rating) {
    if($rating >= 4.5) {
        $class = 'dark-green-rating';
    } elseif($rating >= 3.5) {
        $class = 'green-rating';
    } elseif($rating >= 2.5) {
        $class = 'orange-rating';
    } else {
        $class = 'red-rating';
    }
    return $class;
}

function prepare_menu_items() {
    // Obtain array of menu objects from the primary menu
    $locations = get_nav_menu_locations();
    $menu = wp_get_nav_menu_object( $locations[ 'primary' ] );
    $menu_items = wp_get_nav_menu_items( $menu->term_id, array( 'order' => 'DESC' ) );

    $prepared_menu_items = [];

    foreach($menu_items as $item) {
        // Values with no parent are highest level menu items
        if( !$item->menu_item_parent ) {
            $parent_obj = array();
            $parent_obj['id'] = $item->ID;
            $parent_obj['title'] = $item->title;
            $parent_obj['url'] = $item->url;

            $prepared_menu_items[$item->ID] = $parent_obj;
        } else {
            $child_obj = array();
            $child_obj['title'] = $item->title;
            $child_obj['url'] = $item->url;
            $child_obj['desc'] = $item->description;

            // If attr_title is set, this will create a subcategory
            if( $item->attr_title ) {
                $prepared_menu_items[$item->menu_item_parent]['has_subcats'] = true;
                $prepared_menu_items[$item->menu_item_parent]['submenu_items'][$item->attr_title][] = $child_obj;
            } else {
                $prepared_menu_items[$item->menu_item_parent]['has_subcats'] = false;
                $prepared_menu_items[$item->menu_item_parent]['submenu_items'][] = $child_obj;
            }
        }
    }

    return $prepared_menu_items;
}

// Add custom columns to cpt admins
function set_menu_order_column_name($columns){
    $columns['menu_order'] = 'Order';
    return $columns;
}

function set_menu_order_column_value($column_name, $post_id){
    echo get_post($post_id)->menu_order;
}

function set_menu_order_sortable_column($columns){
    $columns['menu_order'] = 'menu_order';
    return $columns;
}

function set_coupon_columns_name($columns){
    $columns['featured_coupon'] = 'Featured Coupon';
    $columns['status'] = 'Status';
    return $columns;
}

function set_coupon_columns_value($column_name, $post_id){

    $coupon_post_fields = get_fields( $post_id )['coupon_promotion'];
    $is_expired = is_utc_date_expired( $coupon_post_fields['expiration_date'], '-4 hours');

    switch ( $column_name ) {

        case 'featured_coupon' :
            // check if any coupons have been selected to be featured
            $featured_coupon_id = get_option('is_featured_coupon');
            if( $featured_coupon_id ) {
                $is_post_featured_coupon = is_coupon_featured( $post_id );
                $featured_coupon_message = '';

                // check if the current row is the featured coupon
                if( $is_post_featured_coupon ) {
                    $featured_coupon_message = 'Selected';

                    // check if the featured coupon is currently expired
                    if( $is_expired ) $featured_coupon_message .= ' <span style="color: red;">(Expired)</span>';
                }
            } else {
                $featured_coupon_message = 'None Selected';
            }

            echo $featured_coupon_message;
            break;

        case 'status' :
            if ($is_expired){
                $status_coupon_message = '<span style="color: red;">Expired</span>';
            } else {
                $status_coupon_message = '<span>Active</span>';
            }
            echo $status_coupon_message;
            break;

    }
}

function set_featured_coupon_sortable_column($columns){
    $columns['featured_coupon'] = 'featured_coupon';
    return $columns;
}

add_filter('manage_reviews_posts_columns', 'set_menu_order_column_name' );

add_action( 'manage_reviews_posts_custom_column', 'set_menu_order_column_value', 10, 2);

add_filter('manage_edit-reviews_sortable_columns', 'set_menu_order_sortable_column');

add_filter('manage_comparisons_posts_columns', 'set_menu_order_column_name');

add_action( 'manage_comparisons_posts_custom_column', 'set_menu_order_column_value', 10, 2);

add_filter('manage_edit-comparisons_sortable_columns', 'set_menu_order_sortable_column');

add_filter('manage_best-vpn_posts_columns', 'set_menu_order_column_name');

add_action( 'manage_best-vpn_posts_custom_column', 'set_menu_order_column_value', 10, 2);

add_filter('manage_edit-best-vpn_sortable_columns', 'set_menu_order_sortable_column');

add_filter('manage_coupon_promotions_posts_columns', 'set_coupon_columns_name');

add_action( 'manage_coupon_promotions_posts_custom_column', 'set_coupon_columns_value', 10, 2);

add_filter('manage_edit-coupon_promotions_sortable_columns', 'set_featured_coupon_sortable_column');

// Creates list items that include urls and titles
function create_nav_list_items($data, $title = 'title', $url = 'url') {
    $list = '';
    foreach($data as $item) {
        $item_title = $item[$title];
        $item_url = $item[$url];

        $list .= '<li><a href="'.$item_url.'">'.$item_title.'</a></li>';
    }

    return $list;
}

function create_custom_excerpt($content, $limit = 100, $clipped_text_indicator = '...') {
    $trimmed_content = wp_trim_words($content);
    $excerpt = substr(trim($trimmed_content), 0, $limit);
    $truncated_excerpt = substr($excerpt, 0, strrpos($excerpt, ' '));
    if(strlen($content) > 125) $truncated_excerpt .= ' '.$clipped_text_indicator;

    return $truncated_excerpt;
}

function create_breadcrumbs_html($args = []) {
    $breadcrumbs_on_off = get_post_meta( get_the_ID(), 'breadcrumbs_on_off', true );
    $breadcrumbs = wp_kses_post(coinflip_header_title_breadcrumbs($args));

    return $breadcrumbs;
}

function prepare_outbound_id($post_id) {
    $slug = get_post_field('post_name', $post_id);
    return 'outbound_'.str_replace('-', '_', $slug);
}
function prepare_click_id_vpn_name($vpn_name) {
    //for the outbound ids that have more complex id names besides outbound_
    $new_vpn_name = get_post_field('post_name', $vpn_name);
    $new_vpn_name = str_replace('-', '_', $new_vpn_name);
    
    return strtolower($new_vpn_name);
}

function convert_string_to_anchor_link($str) {
    $anchor_link = strtolower( $str );
    //Make alphanumeric (removes all other characters)
    $anchor_link = preg_replace("/[^a-z0-9_\s-]/", "", $anchor_link);
    //Clean up multiple dashes or whitespaces
    $anchor_link = preg_replace("/[\s-]+/", " ", $anchor_link);
    //Convert whitespaces and underscore to dash
    $anchor_link = preg_replace("/[\s_]/", "-", $anchor_link);

    return $anchor_link;
}


function get_block_data( $post, $block_name = '' ){
	$content = '';
	if ( has_blocks( $post->post_content )) {
        $blocks = parse_blocks( $post->post_content );
	    foreach( $blocks as $block ){
		    if ( $block['blockName'] === $block_name ) $content = $block['attrs']['data'];
	    }  
	}
	return $content;
}

// Removes Yoast json-ld output only
// Based on https://gist.github.com/amboutwe/ededa6e74b099060f0080251721a1824
add_filter( 'wpseo_json_ld_output', 'remove_yoast_json_ld_output' );

function remove_yoast_json_ld_output() {
    if ( is_page ( array( 'faqs', 'faq' ) ) ) return false;
}

//add_action( 'wp_enqueue_scripts', 'enqueue_external_stylesheets' );
function enqueue_external_stylesheets() {
    if( is_page_template('page-vpn-comparisons.php')) {
        wp_enqueue_style( 'flickity', get_stylesheet_directory_uri() . '/css/flickity.css' );
    }
}

// add_action( 'wp_enqueue_scripts', 'enqueue_page_stylesheets' );
function enqueue_page_stylesheets() {
    global $post;
    $is_cpt = array( 'best-vpn', 'comparisons', 'reviews' );
    $blocks = parse_blocks( $post->post_content );
    $post_type = get_post_type();
    
    if( is_front_page() ) {
        wp_enqueue_style( 'homepage', get_stylesheet_directory_uri() . '/css/homepage.css' );
    }  else if( is_search() ) {
        wp_enqueue_style( 'search-results', get_stylesheet_directory_uri() . '/css/search-results.css' );
    } else if( is_404() ) {
        wp_enqueue_style( '404', get_stylesheet_directory_uri() . '/css/404.css' );
    } else if( is_page( $is_cpt ) ) {
        wp_enqueue_style( 'aggregate', get_stylesheet_directory_uri() . '/css/aggregate.css' );
    } else if( $post->post_name === 'about' ) {
        wp_enqueue_style( 'about-us', get_stylesheet_directory_uri() . '/css/about-us.css' );
    } else if( is_page( array( 'faq', 'faqs' ) ) ) {
        wp_enqueue_style( 'faqs', get_stylesheet_directory_uri() . '/css/faqs.css' );
    } else if( $post_type === 'best-vpn' ) {
        wp_enqueue_style( 'single-best-vpn', get_stylesheet_directory_uri() . '/css/single-best-vpn.css' );
    } else if( $post_type === 'reviews' ) {
        wp_enqueue_style( 'single-reviews', get_stylesheet_directory_uri() . '/css/single-reviews.css' );
    }

    if( in_array( $post_type, $is_cpt ) ) wp_enqueue_style( 'single', get_stylesheet_directory_uri() . '/css/single.css' );
    
    if( count( $blocks ) ) {
        $block_names = array();
        foreach( $blocks as $block ) {
            if( array_key_exists( 'blockName', $block ) && $block['blockName'] ) $block_names[] = $block['blockName'];
        }
        if( in_array( 'acf/comp-box', $block_names ) || $post_type === 'best-vpn' || $post_type === 'comparisons' ) wp_enqueue_style( 'comp-box', get_stylesheet_directory_uri() . '/css/comp-box.css' );
        if( in_array( 'acf/pros-cons', $block_names ) || $post_type === 'best-vpn' ) wp_enqueue_style( 'pros-cons', get_stylesheet_directory_uri() . '/css/pros-cons.css' );
    }

}

function reviews_menu() {
	ob_start(); 
    
    $args = array(  
        'post_type' => 'reviews',
        'post_status' => 'publish',
        'orderby' => 'menu_order', 
        'order' => 'ASC',
        'posts_per_page' => 5,
    );
    $reviews = new WP_Query( $args ); 
    
    if( $reviews->have_posts() ):  ?>
        <div id="shortcode-menu-container">
            <ul id="menu-reviews" class="menu">
                <?php while ( $reviews->have_posts() ) : $reviews->the_post(); ?>
                    <li id="menu-item-<?php the_ID() ?>" class="menu-item menu-item-type-post_type menu-item-object-reviews menu-item-<?php the_ID() ?>"><a href="<?php the_permalink() ?>"><?php the_field('vpn_name') ?></a></li>
                <?php endwhile; wp_reset_postdata(); ?>
                <li class="menu-item menu-item-type-post_type menu-item-object-reviews menu-item-49650"><a href="<?php echo site_url('reviews'); ?>">See All Reviews</a></li>
            </ul>
        </div>
    <?php endif;  ?>
    
    <?php
	return ob_get_clean();
}

add_shortcode( 'reviews_menu', 'reviews_menu' );

function comparison_menu() {
	ob_start(); 
    
    $args2 = array(  
        'post_type' => 'comparisons',
        'post_status' => 'publish',
        'orderby' => 'menu_order', 
        'order' => 'ASC', 
        'posts_per_page' => 5,
    );
    
    $comparisons = new WP_Query( $args2 );
    
    if( $comparisons->have_posts() ):  ?>
        <div id="shortcode-menu-container">
            <ul id="menu-comparison" class="menu">
                <?php while ( $comparisons->have_posts() ) : $comparisons->the_post(); ?>
                    <li id="menu-item-<?php the_ID() ?>" class="menu-item menu-item-type-post_type menu-item-object-comparison menu-item-<?php the_ID() ?>"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></li>
                <?php endwhile; wp_reset_postdata(); ?>
            </ul>
        </div>
    <?php endif;  ?>
    
    <?php
	return ob_get_clean();
}

add_shortcode( 'comparison_menu', 'comparison_menu' );

// register meta boxes
add_action( 'add_meta_boxes', 'custom_field_checkboxes' );
function custom_field_checkboxes() {
    add_meta_box(
        'featured_coupon',                  // this is HTML id of the box on edit screen
        'Featured Coupon',                  // title of the box
        'handle_featured_coupon_on_edit',   // function to be called to display the checkboxes, see the function below
        'coupon_promotions',                // on which edit screen the box should appear
        'side',                             // part of page where the box should appear
        'default'                           // priority of the box
    );
}

/**
 * Handle is_featured_coupon metabox option logic when post is loaded into editor.
 *
 * @param type $coupon_post Object.
 */
function handle_featured_coupon_on_edit( $coupon_post ) {
    // add is_featured_coupon_nonce property to form for security purposes
    wp_nonce_field( 'wp_nonce_check', 'is_featured_coupon_nonce' );

    $is_post_featured_coupon = is_coupon_featured( $coupon_post->ID );
    $disable_on_load = false;
    
    // check if post is the featured coupon
    if( $is_post_featured_coupon ) {
        $coupon_post_fields = get_fields( $coupon_post->ID )['coupon_promotion'];
        $is_expired = is_utc_date_expired( $coupon_post_fields['expiration_date'], '-4 hours');

        // check if post expiration date is expired
        if( $is_expired ) {
            reset_featured_coupon();
            $disable_on_load = true;
        }
    }

    build_featured_coupon_checkbox_content( $coupon_post->ID, $disable_on_load );
}

add_action( 'save_post', 'handle_featured_coupon_on_save', 10, 1 );

/**
 * Handle is_featured_coupon metabox option logic when post is saved.
 *
 * @param type $coupon_post_id Integer.
 * @return type NULL.
 */
function handle_featured_coupon_on_save( $coupon_post_id ) {
    // check for autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

    // security check
    if ( !wp_verify_nonce( $_POST['is_featured_coupon_nonce'], 'wp_nonce_check' ) ) return;

    // if form includes is_featured_coupon and post_ID
    if ( isset( $_POST['is_featured_coupon'] ) && isset( $_POST['post_ID'] ) ) {
        $coupon_post_fields = get_fields( $_POST['post_ID'] )['coupon_promotion'];
        $is_expired = is_utc_date_expired( $coupon_post_fields['expiration_date'], '-4 hours');

        // check if saved coupon has an expired expiration date
        if( !$is_expired ) {
            set_featured_coupon( $_POST['post_ID'] );
            return;
        }
        return;
    } else {
        return;
    }
}

add_action( 'transition_post_status', 'handle_featured_coupon_on_transition', 10, 3 );

/**
 * Handle is_featured_coupon metabox option logic when post transitions.
 *
 * @param type $coupon_post Object.
 */
function handle_featured_coupon_on_transition( $new_status, $old_status, $coupon_post ) {
    // check if coupon is being deleted
    if( $new_status === 'trash' ) {
        $is_post_featured_coupon = is_coupon_featured( $coupon_post->ID );

        // check if post is the featured coupon
        if( $is_post_featured_coupon ) reset_featured_coupon();
    }
}

/**
 * Check if coupon is currently featured.
 *
 * @param type $coupon_post_id String or Integer.
 * @return type Boolean.
 */
function is_coupon_featured( $coupon_post_id ) {
    $featured_coupon_id = get_option('is_featured_coupon');
    
    return strval($coupon_post_id) === strval($featured_coupon_id);
}

/**
 * Check if utc is expired compared to (adjusted) current time.
 *
 * @param type $utc_date_string String.
 * @param type $adjustment_string String.
 * @return type Boolean.
 */
function is_utc_date_expired( $utc_date_string, $adjustment_string = '' ) {
    $now = new DateTime();
    if( $adjustment_string ) $now = $now->modify( $adjustment_string );
    $date_to_compare = new DateTime( $utc_date_string );
    
    return $now > $date_to_compare;
}

function get_coupon_deal($id) {
    $args = array(  
        'post_type' => 'coupon_promotions',
        'post_status' => 'publish',
        'orderby' => 'menu_order', 
        'order' => 'ASC',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => 'coupon_promotion_vpn_provider',
                'value' => $id,
                'compare' => '='
            )
        )
    );
    $coupons = get_posts( $args );
    $active_coupon = '';
    foreach ($coupons as $coupon){
        $expiration_date = get_field('coupon_promotion_expiration_date', $coupon->ID);
        $is_expired = is_utc_date_expired( $expiration_date, '-4 hours' );
        if (!$is_expired){
            $active_coupon = $coupon;
        }
    }

    $first = $active_coupon->ID;
    
    $coupon_fields = get_fields( $first )['coupon_promotion'];

    //return 'coupons';

    return $coupon_fields;
}

/**
 * Set is_featured_coupon metabox option to NULL.
 */
function reset_featured_coupon() {
    update_option( 'is_featured_coupon', NULL );
}

/**
 * Set is_featured_coupon metabox option to inputed id.
 *
 * @param type $coupon_post_id String or Integer.
 */
function set_featured_coupon( $coupon_post_id ) {
    update_option( 'is_featured_coupon', $coupon_post_id );
}

/**
 * Retrieve featured coupon post object.
 *
 * @return type Object.
 */
function get_featured_coupon_obj() {
    $featured_coupon_id = get_option('is_featured_coupon');
    $featured_coupon = $featured_coupon_id ? get_post( $featured_coupon_id ) : NULL;

    return $featured_coupon;
}

/**
 * Created is_featured_coupon metabox option.
 *
 * @param type $coupon_post_id String or Integer.
 * @param type $disabled_on_load Boolean.
 */
function build_featured_coupon_checkbox_content( $coupon_post_id, $disabled_on_load = false ) {
    $is_post_featured_coupon = is_coupon_featured( $coupon_post_id );
    $checked_attribute = '';
    $current_selection_message = '';

    if( $is_post_featured_coupon ) {
        $checked_attribute = 'checked';
        $current_selection_message .= '(Currently selected)';
    } else {
        $featured_coupon = get_featured_coupon_obj();
        $coupon_post_fields = get_fields( $coupon_post_id )['coupon_promotion'];
        $is_expired = is_utc_date_expired( $coupon_post_fields['expiration_date'], '-4 hours');

        if( $disabled_on_load || $is_expired ) $current_selection_message .= '<span style="color: red;">This coupon cannot be selected (or has been deselected) because it is expired. Update expiration date before selecting as the featured coupon.</span><br><br>';

        if( $featured_coupon ) {
            $featured_coupon_edit_link = get_edit_post_link( $featured_post->ID );
            $current_selection_message .= '(<a href="'. $featured_post_edit_link .'">'. $featured_coupon->post_title .'</a> is currently selected)';
        } else {
            $current_selection_message .= '(No coupons currently selected)';
        }
    }

    echo '<label><input type="checkbox" name="is_featured_coupon" value="1"'. $checked_attribute .' /> Feature this coupon<br><br>'. $current_selection_message .'</label>';
}

function custom_render_block_core_group ($block_content, $block){
    if ($block['blockName'] === 'core/table' && !is_admin() && !wp_is_json_request()){
        $custom_style = '';
        $figcaption = '';
        if (isset($block['attrs']['className'])){
            $custom_style = $block['attrs']['className'];
        }
        $table_arr = [];
        $contents = $block_content;
        $DOM = new DOMDocument('1.0', 'UTF-8');
        @$DOM->loadHTML($contents);

        $items = $DOM->getElementsByTagName('tr');
        $figcaption_obj = $DOM->getElementsByTagName('figcaption');
        if (is_object($figcaption_obj->item(0))){
            $figcaption = $figcaption_obj->item(0)->nodeValue;
        }
        foreach ($items as $node) {
            $row_arr = [];
            foreach ($node->childNodes as $element) {
                $row_arr[] = $DOM->saveXML($element);
            }
            $table_arr[] = $row_arr;
            
        }
        $header = $table_arr[0];
        array_shift($table_arr);
        $mobile_table = '';
        $mobile_table .= '<figure class="wp-block-table mobile-table '.$custom_style.'"><table>';
        foreach($table_arr as $row){
            foreach($row as $key => $cell){
                $row_class = '';
                if ($key == 0){
                    $row_class = 'top-mobile-row';
                }
                $mobile_table .= '<tr class="'.$row_class.'">'.$header[$key].''.$cell.'</tr>';
            }
        }
        $mobile_table .= '</table>';
        $mobile_table .= '<figcaption>'.$figcaption.'</figcaption></figure>';
        $block_content .= $mobile_table;
    }

    return $block_content;
}

add_filter('render_block', 'custom_render_block_core_group', null, 2);


/**
 * Truncate inputed content by inputed limit using inputed delimiter.
 *
 * @param type $string String.
 * @param type $length Integer.
 * @param type $append String.
 * @return type String.
 */
function truncate($string, $length = 100, $append = " &hellip;") {
    $string = trim($string);

    if(strlen($string) > $length) {
        $string = wordwrap($string, $length);
        $string = explode("\n", $string, 2);
        $string = $string[0] . $append;
    }

    return $string;
}

function pagination_bar( $query_wp, $addHash ) {
    $pages = $query_wp->max_num_pages;
    $big = 999999999; // need an unlikely integer
    $return = false;
    if ($pages > 1)
    {
        $page_current = max(1, get_query_var('paged'));
        $return = paginate_links(array(
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => '?paged=%#%',
            'current' => $page_current,
            'total' => $pages,
            'prev_text' => '<i class="chevron"></i>',
            'next_text' => '<i class="chevron"></i>',
            'add_fragment' => $addHash,
        ));
    }
    return $return;
}

//add_filter( 'use_widgets_block_editor', '__return_false' );

function modify_search_widget( $form ) {
     
    $form = '
    <form method="GET" action="'.home_url( '/' ).'" autocomplete="off">
        <div class="search-input-container">
            <input type="search" class="search-field form-control" placeholder="Search VPNs" value="'.get_search_query().'" name="s" />
            <button type="submit" class="form-control btn btn-warning">           
                <span class="fa fa-search"></span>
            </button>
        </div>
    </form>';

    return $form;
}

add_filter( 'get_search_form', 'modify_search_widget', 101 );

/**
* Add a custom link to the end of a specific menu that uses the wp_nav_menu() function
*/
add_filter('wp_nav_menu_items', 'add_search_form_nav', 10, 2);
function add_search_form_nav($items, $args){
    if( $args->theme_location == 'menu-1' ){
        $items .= '<li class="mega-menu-item mega-search main-menu-item mt-car-search">
         <form method="GET" action="'.home_url( '/' ).'" autocomplete="off">
                <div class="search-input-container">
                    <input type="search" class="search-field form-control" placeholder="Search VPNs" value="'.get_search_query().'" name="s" />
                    <button type="submit" class="form-control btn btn-warning">           
                        <span class="fa fa-search"></span>
                    </button>
                </div>
            </form>
        </li>';
    }
    return $items;
}

function sortByCouponCount($a, $b) {
    return $b->coupon_count <=> $a->coupon_count;
}

//Unregister all image sizes besides the default
add_action('init', function() {
    foreach ( get_intermediate_image_sizes() as $size ) {
        if ( !in_array( $size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
            remove_image_size( $size );
        }
    }

});


add_action('pre_get_posts', function($query) {

    if( $query->is_main_query() && is_search() && !is_admin()){
        $pages =  get_pages();
        $exclude = [];
        foreach($pages as $key => $v) {
            if ( Elementor\Plugin::instance()->db->is_built_with_elementor( $v->ID) ) {
                array_push($exclude, $v->ID);
            }
        }
        $query->set('post__not_in', $exclude);
    }
});

function hex2rgba($color, $opacity = false) {
 
	$default = 'rgb(0,0,0)';
 
	//Return default if no color provided
	if(empty($color))
          return $default; 
 
	//Sanitize $color if "#" is provided 
        if ($color[0] == '#' ) {
        	$color = substr( $color, 1 );
        }
 
        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
                return $default;
        }
 
        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);
 
        //Check if opacity is set(rgba or rgb)
        if($opacity){
        	if(abs($opacity)  > 1)
        		$opacity = 1.0;
        	$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
        	$output = 'rgb('.implode(",",$rgb).')';
        }
 
        //Return rgb(a) color string
        return $output;
}

add_shortcode( 'current_year', 'sc_year' );
function sc_year(){
    return date( 'Y' );
}

add_shortcode( 'current_month', 'sc_month' );
function sc_month(){
    return date( 'F' );
}

add_filter( 'single_post_title', 'shortcode_title', 9, 1);
add_filter( 'the_title', 'shortcode_title', 9, 1 );
add_filter( 'wpseo_title', 'shortcode_title', 9, 1 );
add_filter( 'wpseo_opengraph_title', 'shortcode_title', 9, 1 );
add_filter( 'wpseo_metadesc', 'shortcode_desc', 9, 1 );
add_filter( 'wpseo_opengraph_desc', 'shortcode_desc', 9, 1 );
add_filter( 'wpseo_schema_webpage', 'shortcode_schema', 10, 1 );
add_filter('wp_schema_pro_schema_article', 'shortcode_schema_article', 10, 3);
add_filter('wp_schema_pro_schema_video_object', 'shortcode_schema_video', 10, 3);
//add_filter( 'wpseo_schema_webpage', 'shortcode_schema', 9, 1 );
//add_filter( 'yoast_seo_development_mode', '__return_true' );

function shortcode_schema_article($schema, $data, $post) {
    // echo 'got here';
    // echo "<pre>";print_r($data);echo "</pre>";
    // echo 'schema';
    // echo "<pre>";print_r($schema);echo "</pre>";
    // error_log(print_r($data, TRUE));
    //echo "<pre>";print_r($data);echo "</pre>";
    if ( isset( $data['name'] ) && ! empty( $data['name'] ) ) {
		// For date/text type field
		$schema['headline'] = do_shortcode( $data['name'] );
    }
    if ( isset( $data['description'] ) && ! empty( $data['description'] ) ) {
		// For date/text type field
		$schema['description'] = do_shortcode( $data['description'] );
    }
    //echo "<pre>";print_r($schema);echo "</pre>";
    return $schema;
}

function shortcode_schema_video($schema, $data, $post) {

    if ( isset( $data['name'] ) && ! empty( $data['name'] ) ) {
		// For date/text type field
		$schema['name'] = do_shortcode( $data['name'] );
    }
    if ( isset( $data['description'] ) && ! empty( $data['description'] ) ) {
		// For date/text type field
		$schema['description'] = do_shortcode( $data['description'] );
    }
    //echo "<pre>";print_r($schema);echo "</pre>";
    return $schema;
}

function shortcode_schema($data) {

    $data['name'] = do_shortcode( $data['name'] );
    $data['description'] = do_shortcode( $data['description'] );
    //$data['headline'] = do_shortcode( $data['headline'] );

    return $data;
}

function shortcode_title( $title ){
    return do_shortcode( $title );
}

function shortcode_desc( $desc ){
    return do_shortcode( $desc );
}

add_action( 'in_admin_header', function() {
    $migration = get_field('migration_on', 'options');
    if($migration) {
        get_template_part('/template-parts/migration-banner');
    }
} );

add_filter('admin_body_class', function($classes) {
    $migration = get_field('migration_on', 'options');
    if($migration){
        return $classes . ' migration-on';
    }
});

add_filter('body_class', function($classes) {
    $migration = get_field('migration_on', 'options');
    if($migration && is_user_logged_in()){
        $classes[] = 'migration-on';
        //return $classes . ' migration-on';
    }
    return $classes;
});

function slugify($str){

    $str = strtolower(trim($str));
    $str = html_entity_decode($str);
    $str = preg_replace('/[^a-z0-9-]/', '-', $str);
    $str = preg_replace('/-+/', "-", $str);
    return $str;
}

function formatDatapoints($data, $id) {
    
    switch($data) {
        case 'lowest_price':
            $output = get_field_object('lowest_price', $id)['prepend'] . get_field('lowest_price', $id);
            break;
        case 'countries':
            $output = get_field('countries', $id) . ' Countries';
            break;
        case 'logging':
            $output = ($log = get_field('logging', $id)) ? $log : '';
            break;
        case 'customer_support':
            $data = get_field('customer_support', $id);
            if(preg_match('/^(\+|\(|\d)/', $data)) {
                $output = '<a href="tel:'. $data .'" target="_blank">Support</a>';
            }
            elseif(preg_match('/^[A-z0-9_\-]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z.]{2,4}$/', $data)) {
                $output = '<a href="mailto:'. $data .'" target="_blank">Support</a>';
            }
            else {
                $output = '<a href="'. $data .'" target="_blank">Support</a>';
            }
            break;
        case 'protocols': 
            $data = get_field('protocols', $id);
            $output = count($data);
            break;
        default:
            $output = get_field($data, $id);
            break;
    }

    if($output == '1') {
        $output = 'Yes';
    }
    elseif($output == '0') {
        $output = 'No';
    }
    elseif($output == false) {
        $output = '--';
    }
        
    return $output;
}

function weightedRating($priv, $enter, $avail, $speed, $security, $price) {
    $sum = ((float)$priv * 0.3) + ((float)$enter * 0.15) + ((float)$avail * 0.2) + ((float)$speed * 0.1) + ((float)$security * 0.2) + ((float)$price * 0.05);

    return number_format(round($sum, 1), 1, '.', '');
}

function add_nofollow() {
    wp_deregister_script('wplink');
    wp_register_script('wplink',  get_template_directory_uri() . '/js/nofollow.min.js', array('jquery'), false, 1);
    wp_enqueue_script('wplink');
    wp_localize_script('wplink', 'wpLinkL10n', array(
        'title' => __('Insert/edit link'),
        'update' => __('Update'),
        'save' => __('Add Link'),
        'noTitle' => __('(no title)'),
        'labelTitle' => __( 'Title' ),
        'noMatchesFound' => __('No results found.'),
        'noFollow' => __(' Add <code>rel="nofollow"</code> to link', 'title-and-nofollow-for-links')
    ));
}
add_action('wp_enqueue_editor', 'add_nofollow', 99999);


//streaming shortcodes

add_shortcode( 'show_title', 'streaming_show_title' );
function streaming_show_title(){
    $streaming_page_id = get_queried_object_id();
    $streaming_title_for_page = get_field('show_title', $streaming_page_id);
    return $streaming_title_for_page;
}

add_shortcode( '#1_VPN_link_here', 'num_1_vpn_link' );
function num_1_vpn_link(){
    $streaming_page_id = get_queried_object_id();
    
    $enable_provider_override_streaming = get_field('enable_provider_override', $streaming_page_id);
    
    if( $enable_provider_override_streaming){
        // use vpn order on streaming page
        $streaming_select_vpns = get_field('provider_override', $streaming_page_id);
        $streaming_num_1_id = $streaming_select_vpns[0]["vpn"]->ID;
        
    } else{
        // use vpn order from theme settings
        $streaming_select_vpns = get_field('select_vpns_streaming', 'option');
        $streaming_num_1_id = $streaming_select_vpns[0]["vpn"]->ID;
    }
   
    $streaming_num_1_url = get_permalink($streaming_num_1_id);
    $streaming_num_1_name = get_field('vpn_name',$streaming_num_1_id);
    $streaming_num_1_url_html = '<a href="'.$streaming_num_1_url.'">Visit '.$streaming_num_1_name.'</a>';
    return $streaming_num_1_url_html;

}

