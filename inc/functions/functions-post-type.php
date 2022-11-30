<?php


/**
 * Foreach post type & taxonomy registration
 *
 * @link https://codex.wordpress.org/Post_Types#Custom_Post_Types
 * @link https://codex.wordpress.org/Function_Reference/register_post_type
 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
 */
add_action('init', 'post_types');
function post_types(){

    global $wp_post_types;
    global $wp_taxonomies;

    $post_types = array(

        array(
            'slug'        => 'reviews',
            'single_name' => 'Review',
            'plural_name' => 'Reviews',
            'menu_name'	  => 'Reviews',
            'description' => 'Reviews that we Provide',
            'dashicon'    => 'dashicons-admin-page',
            'supports'    => array('title', 'editor', 'thumbnail', 'page-attributes'),
            'menu_position' => 6,
            'has_archive' => false,
        ),
        array(
            'slug'        => 'comparisons',
            'single_name' => 'Comparison',
            'plural_name' => 'Comparisons',
            'menu_name'	  => 'Comparisons',
            'description' => 'Comparisons that we do',
            'dashicon'    => 'dashicons-admin-page',
            'supports'    => array('title', 'editor', 'thumbnail', 'page-attributes'),
            'menu_position' => 7,
            'has_archive' => false,
        ),
        array(
            'slug'        => 'best-vpn',
            'single_name' => 'Best VPN',
            'plural_name' => 'Best VPNs',
            'menu_name'	  => 'Best VPNs',
            'description' => 'Best VPNs that we do',
            'dashicon'    => 'dashicons-admin-page',
            'supports'    => array('title', 'editor', 'thumbnail', 'page-attributes'),
            'hierarchical' => false,
            'menu_position' => 8,
            'has_archive' => false,
        ),
        array(
            'slug'        => 'authors',
            'single_name' => 'Author',
            'plural_name' => 'Authors',
            'menu_name'	  => 'Authors',
            'description' => 'Authors that we Provide',
            'dashicon'    => 'dashicons-welcome-write-blog',
            'supports'    => array('title', 'thumbnail', 'custom-fields'),
            'menu_position' => 9,
        ),
        array(
            'slug'        => 'coupon_promotions',
            'single_name' => 'Coupon Promotion',
            'plural_name' => 'Coupon Promotions',
            'menu_name'	  => 'Coupon Promos',
            'description' => 'Coupon Promotions for VPN providers',
            'dashicon'    => 'dashicons-tickets-alt',
            'supports'    => array('title', 'thumbnail', 'custom-fields'),
            'menu_position' => 10,
            'has_archive' => false,
            'publicly_queryable' => false,
            'exclude_from_search' => true,
        ),
        array(
            'slug'        => 'watch',
            'single_name' => 'Watch',
            'plural_name' => 'Watch',
            'menu_name'	  => 'Programmatic Posts',
            'description' => 'Templated blog posts to quickly generate posts in a category',
            'dashicon'    => 'dashicons-media-document',
            'supports'    => array('title', 'thumbnail', 'editor', 'page-attributes'),
            'menu_position' => 11,
            'has_archive' => false,
            'publicly_queryable' => true,
            'exclude_from_search' => true,
        ),
    );

    foreach ($post_types as $post_type) {
        $post_type_labels = array(
            'name'                  => _x($post_type["plural_name"], 'Post Type General Name', 'phos'),
            'singular_name'         => _x($post_type["single_name"], 'Post Type Singular Name', 'phos'),
            'menu_name'             => __($post_type["menu_name"], 'phos'),
            'name_admin_bar'        => __($post_type["plural_name"], 'phos'),
            'archives'              => __($post_type["single_name"] . ' Archives', 'phos'),
            'attributes'            => __($post_type["single_name"] . ' Attributes', 'phos'),
            'parent_item_colon'     => __('Parent ' . $post_type["single_name"], 'phos'),
            'all_items'             => __('All ' . $post_type["plural_name"], 'phos'),
            'add_new_item'          => __('Add New ' . $post_type["single_name"], 'phos'),
            'add_new'               => __('Add New ' . $post_type["single_name"], 'phos'),
            'new_item'              => __('New ' . $post_type["single_name"], 'phos'),
            'edit_item'             => __('Edit ' . $post_type["single_name"], 'phos'),
            'update_item'           => __('Update ' . $post_type["single_name"], 'phos'),
            'view_item'             => __('View ' . $post_type["single_name"], 'phos'),
            'view_items'            => __('View ' . $post_type["single_name"], 'phos'),
            'search_items'          => __('Search ' . $post_type["single_name"], 'phos'),
            'not_found'             => __('Not found', 'phos'),
            'not_found_in_trash'    => __('Not found in Trash', 'phos'),
            'featured_image'        => __($post_type["single_name"] . ' Image', 'phos'),
            'set_featured_image'    => __('Set ' . $post_type["single_name"] . ' image', 'phos'),
            'remove_featured_image' => __('Remove ' . $post_type["single_name"] . ' image', 'phos'),
            'use_featured_image'    => __('Use as ' . $post_type["single_name"] . ' image', 'phos'),
            'insert_into_item'      => __('Insert into ' . $post_type["single_name"], 'phos'),
            'uploaded_to_this_item' => __('Uploaded to this ' . $post_type["single_name"], 'phos'),
            'items_list'            => __($post_type["single_name"] . ' list', 'phos'),
            'items_list_navigation' => __($post_type["single_name"] . ' list navigation', 'phos'),
            'filter_items_list'     => __('Filter ' . $post_type["single_name"] . ' list', 'phos')
        );

        $post_types_args = array(
            'label'                 => __($post_type["single_name"], 'phos'),
            'description'           => __($post_type["description"], 'phos'),
            'labels'                => $post_type_labels,
            'supports'              => $post_type["supports"],
            // 'taxonomies'            => array('example', 'post_tag'),
            'hierarchical'          => array_key_exists("hierarchical", $post_type) ? $post_type["hierarchical"] : false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'show_in_rest'          => true,
            'menu_position'         => $post_type["menu_position"],
            'menu_icon'             => $post_type["dashicon"],
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => array_key_exists("has_archive", $post_type) ? $post_type["has_archive"] : true,
            'exclude_from_search'   => array_key_exists("exclude_from_search", $post_type) ? $post_type["exclude_from_search"] : false,
            'publicly_queryable'    => array_key_exists("publicly_queryable", $post_type) ? $post_type["publicly_queryable"] : true,
            'capability_type'       => 'page'
        );

        $slug = $post_type['slug'];

        /**
         * Gutenberg & Rest API Support
         */
        if (isset($wp_post_types[$slug])) {
            $wp_post_types[$slug]->show_in_rest = true;
            $wp_post_types[$slug]->rest_base = $slug;
            $wp_post_types[$slug]->rest_controller_class = 'WP_REST_Posts_Controller';
        }

        register_post_type($post_type['slug'], $post_types_args);
    }

}

// Post Types for Pages
add_action('init', 'page_types');
function page_types(){

    global $wp_page_types;

    $page_types = array(

        array(
            'slug'        => 'paid-landers',
            'single_name' => 'Paid Lander',
            'plural_name' => 'Paid Landers',
            'menu_name'	  => 'Paid Landers',
            'description' => 'Paid Landers that we Provide',
            'dashicon'    => 'dashicons-admin-page',
            'supports'    => array('title', 'editor', 'thumbnail', 'page-attributes'),
            'menu_position' => 20,
            'has_archive' => false,
            'exclude_from_search' => true,
        ),
        array(
            'slug'        => 'deals-pages',
            'single_name' => 'Deal',
            'plural_name' => 'Deals',
            'menu_name'	  => 'Deals',
            'description' => 'Deals that we do',
            'dashicon'    => 'dashicons-admin-page',
            'supports'    => array('title', 'editor', 'thumbnail', 'page-attributes'),
            'menu_position' => 21,
            'has_archive' => false,
        ),
        array(
            'slug'        => 'custom-partner-pages',
            'single_name' => 'Custom Partner Page',
            'plural_name' => 'Custom Partner',
            'menu_name'	  => 'Custom Partner',
            'description' => 'Custom Partner that we do',
            'dashicon'    => 'dashicons-admin-page',
            'supports'    => array('title', 'editor', 'thumbnail', 'page-attributes'),
            'menu_position' => 22,
            'has_archive' => false,
        ),
    );

    foreach ($page_types as $page_type) {
        $page_type_labels = array(
            'name'                  => _x($page_type["plural_name"], 'Post Type General Name', 'phos'),
            'singular_name'         => _x($page_type["single_name"], 'Post Type Singular Name', 'phos'),
            'menu_name'             => __($page_type["menu_name"], 'phos'),
            'name_admin_bar'        => __($page_type["plural_name"], 'phos'),
            'archives'              => __($page_type["single_name"] . ' Archives', 'phos'),
            'attributes'            => __($page_type["single_name"] . ' Attributes', 'phos'),
            'parent_item_colon'     => __('Parent ' . $page_type["single_name"], 'phos'),
            'all_items'             => __('All ' . $page_type["plural_name"], 'phos'),
            'add_new_item'          => __('Add New ' . $page_type["single_name"], 'phos'),
            'add_new'               => __('Add New ' . $page_type["single_name"], 'phos'),
            'new_item'              => __('New ' . $page_type["single_name"], 'phos'),
            'edit_item'             => __('Edit ' . $page_type["single_name"], 'phos'),
            'update_item'           => __('Update ' . $page_type["single_name"], 'phos'),
            'view_item'             => __('View ' . $page_type["single_name"], 'phos'),
            'view_items'            => __('View ' . $page_type["single_name"], 'phos'),
            'search_items'          => __('Search ' . $page_type["single_name"], 'phos'),
            'not_found'             => __('Not found', 'phos'),
            'not_found_in_trash'    => __('Not found in Trash', 'phos'),
            'featured_image'        => __($page_type["single_name"] . ' Image', 'phos'),
            'set_featured_image'    => __('Set ' . $page_type["single_name"] . ' image', 'phos'),
            'remove_featured_image' => __('Remove ' . $page_type["single_name"] . ' image', 'phos'),
            'use_featured_image'    => __('Use as ' . $page_type["single_name"] . ' image', 'phos'),
            'insert_into_item'      => __('Insert into ' . $page_type["single_name"], 'phos'),
            'uploaded_to_this_item' => __('Uploaded to this ' . $page_type["single_name"], 'phos'),
            'items_list'            => __($page_type["single_name"] . ' list', 'phos'),
            'items_list_navigation' => __($page_type["single_name"] . ' list navigation', 'phos'),
            'filter_items_list'     => __('Filter ' . $page_type["single_name"] . ' list', 'phos')
        );

        $page_types_args = array(
            'label'                 => __($page_type["single_name"], 'phos'),
            'description'           => __($page_type["description"], 'phos'),
            'labels'                => $page_type_labels,
            'supports'              => $page_type["supports"],
            'hierarchical'          => true,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'show_in_rest'          => true,
            'menu_position'         => $page_type["menu_position"],
            'menu_icon'             => $page_type["dashicon"],
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            //  'rewrite'               => array('slug' => 'deals'),
            'has_archive'           => array_key_exists("has_archive", $page_type) ? $page_type["has_archive"] : true,
            'exclude_from_search'   => array_key_exists("exclude_from_search", $page_type) ? $page_type["exclude_from_search"] : false,
            'publicly_queryable'    => array_key_exists("publicly_queryable", $page_type) ? $page_type["publicly_queryable"] : true,
            'capability_type'       => 'page'
        );

        $slug = $page_type['slug'];

        /**
         * Gutenberg & Rest API Support
         */
        if (isset($wp_page_types[$slug])) {
            $wp_page_types[$slug]->show_in_rest = true;
            $wp_page_types[$slug]->rest_base = $slug;
            $wp_page_types[$slug]->rest_controller_class = 'WP_REST_Posts_Controller';
        }

        register_post_type($page_type['slug'], $page_types_args);
    }
}


add_action('init','add_categories_to_cpt');
function add_categories_to_cpt(){
    register_taxonomy_for_object_type('category', 'watch');
}