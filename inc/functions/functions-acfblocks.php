<?php


add_action('acf/init', 'my_acf_blocks_init');
function my_acf_blocks_init() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // register a gray text block.
        acf_register_block_type(array(
            'name'              => 'disclaimer-box',
            'title'             => __('Disclaimer Box'),
            'description'       => __('A custom Disclaimer block.'),
            'render_template'   => 'template-parts/blocks/disclaimer-box.php',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'keywords'          => array( 'disclaimer-box' ),
        ));
        // Register a Pros & Cons block.
        acf_register_block_type(array(
            'name'              => 'pros-cons',
            'title'             => __('Pros & Cons'),
            'description'       => __('A custom Pros & Cons block.'),
            'render_template'   => 'template-parts/blocks/pros-cons.php',
            'category'          => 'formatting',
            'post_types'        => array('reviews', 'page', 'post'),
        ));
        // Register a comparison box block.
        acf_register_block_type(array(
            'name'              => 'comp-box',
            'title'             => __('VPN Comparison Box'),
            'description'       => __('VPN comparison block.'),
            'render_template'   => 'template-parts/blocks/comp-box.php',
            'category'          => 'formatting',
            'post_types'        => array('comparisons'),
        ));
        // Register an editor's pick block.
        acf_register_block_type(array(
            'name'              => 'editors-pick',
            'title'             => __('Editor\'s Pick'),
            'description'       => __('Editor\'s Pick block.'),
            'render_template'   => 'template-parts/blocks/editors-pick.php',
            'category'          => 'formatting',
            'icon'              => 'list-view',
        ));
        // Register a why vpn block.
        acf_register_block_type(array(
            'name'              => 'frontpage-intro',
            'title'             => __('Frontpage Intro'),
            'description'       => __('Frontpage Intro block.'),
            'render_template'   => 'template-parts/blocks/frontpage-intro.php',
            'category'          => 'formatting',
            'icon'              => 'list-view',
        ));
        // Register a best vpns block.
        acf_register_block_type(array(
            'name'              => 'best-vpns',
            'title'             => __('Best VPNs'),
            'description'       => __('Best VPNs by Category block.'),
            'render_template'   => 'template-parts/blocks/best-vpns.php',
            'category'          => 'formatting',
            'icon'              => 'list-view',
        ));
        // Register a vpn comparisons block.
        acf_register_block_type(array(
            'name'              => 'vpn-comparisons',
            'title'             => __('VPN Comparisons'),
            'description'       => __('VPN Comparisons block.'),
            'render_template'   => 'template-parts/blocks/vpn-comparisons.php',
            'category'          => 'formatting',
            'icon'              => 'list-view',
        ));
        // Register an faq block.
        acf_register_block_type(array(
            'name'              => 'faq-list-block',
            'title'             => __('FAQ List Block'),
            'description'       => __('FAQ List block.'),
            'render_template'   => 'template-parts/blocks/faq-list-block.php',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
        ));
        // Register a coupon promotion block.
        acf_register_block_type(array(
            'name'              => 'inline-coupon-promotion',
            'title'             => __('Inline Coupon Promotion Block'),
            'description'       => __('Inline Coupon Promotion block.'),
            'render_template'   => 'template-parts/blocks/coupon-promotion-inline.php',
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
        ));
        // Register a rating block.
        acf_register_block_type(array(
            'name'              => 'rating',
            'title'             => __('Rating'),
            'description'       => __('Rating block.'),
            'render_template'   => 'template-parts/blocks/rating.php',
            'category'          => 'formatting',
            'icon'              => 'star-filled',
        ));

        // Register a Provider Table block.
        acf_register_block_type(array(
            'name'              => 'provider-table',
            'title'             => __('Provider Table'),
            'description'       => __('Provider Table block.'),
            'render_template'   => 'template-parts/blocks/provider-table.php',
            'category'          => 'formatting',
            'icon'              => 'editor-table',
        ));

        // Register a Blue callout element.
        acf_register_block_type(array(
            'name'              => 'blue-callout-element',
            'title'             => __('Blue Callout Element'),
            'description'       => __('Blue Callout Element.'),
            'render_template'   => 'template-parts/blocks/blue-callout-element.php',
            'category'          => 'formatting',
            'icon'              => 'editor-table',
        ));
          // Register a Blue Bold Sentence callout element.
        acf_register_block_type(array(
            'name'              => 'blue-bold-sentence-callout-element',
            'title'             => __('Blue Bold Sentence Callout Element'),
            'description'       => __('Blue Bold Sentence Callout Element.'),
            'render_template'   => 'template-parts/blocks/blue-bold-sentence-callout-element.php',
            'category'          => 'formatting',
            'icon'              => 'editor-table',
        ));
        // Register a CTA Button block.
        acf_register_block_type(array(
            'name'              => 'standalone-cta-button',
            'title'             => __('CTA Button'),
            'description'       => __('CTA Button'),
            'render_template'   => 'template-parts/blocks/standalone-cta-button.php',
            'category'          => 'formatting',
            'icon'              => 'button',
        ));

        // Styled Numbering
        acf_register_block_type(array(
            'name'              => 'styled-numbering',
            'title'             => __('Styled Numbering'),
            'description'       => __('Styled Numbering'),
            'render_template'   => 'template-parts/blocks/styled-numbering.php',
            'category'          => 'formatting',
            'mode'              =>  'edit',
            'icon' => array(
                'background' => '#e5f4ff',
                'foreground' => '#006ade',
                'src' => 'editor-ol',
              ),
        ));

        // Visual CTA's
        acf_register_block_type(array(
            'name'              => 'creative-cta',
            'title'             => __('Creative CTA'),
            'description'       => __('Creative CTA'),
            'render_template'   => 'template-parts/blocks/creative-cta.php',
            'category'          => 'formatting',
            'mode'              =>  'edit',
            'icon' => array(
                'background' => '#e5f4ff',
                'foreground' => '#006ade',
                'src' => 'button',
              ),
        ));

        acf_register_block_type(array(
            'name'              => 'likes-dislikes',
            'title'             => __('Likes/Dislikes'),
            'description'       => __('Likes/Dislikes'),
            'render_template'   => 'template-parts/blocks/likes-dislikes.php',
            'category'          => 'formatting',
            'mode'              =>  'edit',
        ));

         // Quote Callout
         acf_register_block_type(array(
            'name'              => 'quote-callout',
            'title'             => __('Quote Callout'),
            'description'       => __('Quote Callout'),
            'render_template'   => 'template-parts/blocks/quote-callout.php',
            'category'          => 'formatting',
            'mode'              =>  'edit',
        ));
        // Register a How we Evaluate block.
        acf_register_block_type(array(
            'name'              => 'evaluate-block',
            'title'             => __('How we Evaluate'),
            'description'       => __('How we Evaluate block'),
            'render_template'   => 'template-parts/blocks/evaluate-block.php',
            'category'          => 'formatting',
            'mode'              =>  'edit',
        ));
        // Register a How we Evaluate block.
        acf_register_block_type(array(
            'name'              => 'homepage-guides',
            'title'             => __('Homepage Guides'),
            'description'       => __('Homepage Guides block'),
            'render_template'   => 'template-parts/blocks/homepage-guides.php',
            'category'          => 'formatting',
            'mode'              =>  'edit',
        ));
      // Visual Commercial CTA's
         acf_register_block_type(array(
            'name'              => 'visual-commercial-cta',
            'title'             => __('Visual Commercial CTA'),
            'description'       => __('Visual Commercial CTA'),
            'render_template'   => 'template-parts/blocks/visual-commercial-cta.php',
            'category'          => 'formatting',
            'mode'              =>  'edit',
            'icon' => array(
                'background' => '#e5f4ff',
                'foreground' => '#006ade',
                'src' => 'button',
              ),
        ));
        acf_register_block_type(array(
            'name'              => 'highlight-reviews',
            'title'             => __('Highlight Reviews'),
            'description'       => __('Highlight Reviews Block'),
            'render_template'   => 'template-parts/blocks/highlight-reviews.php',
            'category'          => 'lander',
            'mode'              =>  'edit',
        ));
        acf_register_block_type(array(
            'name'              => 'highlight-features',
            'title'             => __('Highlight Features'),
            'description'       => __('Highlight Features Block'),
            'render_template'   => 'template-parts/blocks/highlight-features.php',
            'category'          => 'lander',
            'mode'              =>  'edit',
        ));
        acf_register_block_type(array(
            'name'              => 'highlight-table',
            'title'             => __('Highlight Table'),
            'description'       => __('Highlight Table Block'),
            'render_template'   => 'template-parts/blocks/highlight-table.php',
            'category'          => 'lander',
            'mode'              =>  'edit',
        ));
        acf_register_block_type(array(
            'name'              => 'comparison-tool-cta',
            'title'             => __('Comparison Tool CTA'),
            'description'       => __('Comparison Tool CTA'),
            'render_template'   => 'template-parts/blocks/comparison-tool-cta.php',
            'category'          => 'formatting',
            'mode'              =>  'edit',
            'icon' => array(
                'background' => '#e5f4ff',
                'foreground' => '#006ade',
                'src' => 'button',
            ),
        ));
        acf_register_block_type(array(
            'name'              => 'compact-comparison',
            'title'             => __('Compact Comparison'),
            'description'       => __('Compact Comparison block'),
            'render_template'   => 'template-parts/blocks/compact-comparison.php',
            'category'          => 'formatting',
            'mode'              =>  'edit',
        ));
        acf_register_block_type(array(
            'name'              => 'image-text',
            'title'             => __('Image/Text'),
            'description'       => __('Image/Text block'),
            'render_template'   => 'template-parts/blocks/image-text.php',
            'category'          => 'formatting',
            'mode'              =>  'edit',
        ));
        acf_register_block_type(array(
            'name'              => 'commercial-top',
            'title'             => __('Commercial Top Block'),
            'description'       => __('Commercial Top Block'),
            'render_template'   => 'template-parts/blocks/commercial-top.php',
            'category'          => 'formatting',
            'mode'              =>  'preview',
            'align' => 'wide',
            'supports'		=> [
                'align' => true,
                'mode' => false,
                'jsx' => true,
            ]
        ));
        acf_register_block_type(array(
            'name'              => 'commercial-bottom',
            'title'             => __('Commercial Bottom Block'),
            'description'       => __('Commercial Bottom Block'),
            'render_template'   => 'template-parts/blocks/commercial-bottom.php',
            'category'          => 'formatting',
            'mode'              =>  'preview',
            'align' => 'wide',
            'supports'		=> [
                'align' => true,
                'mode' => false,
                'jsx' => true,
            ]
        ));
        acf_register_block_type(array(
            'name'              => 'related-posts',
            'title'             => __('Related Posts'),
            'description'       => __('Related Posts block'),
            'render_template'   => 'template-parts/blocks/related-posts.php',
            'category'          => 'formatting',
            'mode'              =>  'edit',
        ));
        acf_register_block_type(array(
            'name'              => 'get-in-touch',
            'title'             => __('Get in touch'),
            'description'       => __('Get in touch block'),
            'render_template'   => 'template-parts/blocks/get-in-touch.php',
            'category'          => 'formatting',
            'mode'              =>  'edit',
        ));
    }
}

function acf_load_article_authors_field_choices( $field ) {

    $field['choices'] = array();

    // retrieve all article authors
    $args = array(
        'post_type' => 'authors',
        'post_status' => 'publish',
        'orderby' => 'post_title',
        'order' => 'ASC',
    );
    $authors = new WP_Query( $args );

    // loop through article authors and set their id as the key and their
    // name/post_title as the value
    if( is_array($authors->posts) ) {
        foreach( $authors->posts as $author ) {
            $field['choices'][$author->ID] = $author->post_title;
        }
    }

    return $field;

}

add_filter( 'block_categories', function($categories, $post) {
    return array_merge(
		$categories,
		array(
			array(
				'slug' => 'lander',
				'title' => 'Lander Blocks',
			),
		)
	);
}, 10, 2);

// use the acf_load_article_authors_field_choices function to dynamically
// populate the options for the Article Authors Dropdown ACF
add_filter('acf/load_field/name=article_authors_dropdown', 'acf_load_article_authors_field_choices');

function acf_load_vpn_reviews_choices( $field ) {

    $field['choices'] = array();

    // retrieve all reviews
    $args = array(
        'post_type' => 'reviews',
        'post_status' => 'publish',
        'orderby' => 'post_title',
        'order' => 'ASC',
        'posts_per_page' => -1,
    );
    $reviews = new WP_Query( $args );

    // loop through article reviews and set their id as the key and their
    // name/post_title as the value
    if( is_array($reviews->posts) ) {
        foreach( $reviews->posts as $review ) {
            $field['choices'][$review->ID] = $review->post_title;
        }
    }

    return $field;

}

// use the acf_load_vpn_reviews_choices function to dynamically
// populate the options for the Reviews Radio Buttons ACF and
// the Choose VPN Providers Dropdown ACF
add_filter('acf/load_field/name=editors_choice', 'acf_load_vpn_reviews_choices');
add_filter('acf/load_field/name=vpn_provider', 'acf_load_vpn_reviews_choices');

function acf_load_vpn_comparisons_choices( $field ) {

    $field['choices'] = array();

    // retrieve all reviews
    $args = array(
        'post_type' => 'comparisons',
        'post_status' => 'publish',
        'orderby' => 'post_title',
        'order' => 'ASC',
        'posts_per_page' => -1,
    );
    $comparisons = new WP_Query( $args );

    // loop through article comparisons and set their id as the key and their
    // name/post_title as the value
    if( is_array($comparisons->posts) ) {
        foreach( $comparisons->posts as $comparison ) {
            $field['choices'][$comparison->ID] = $comparison->post_title;
        }
    }

    return $field;

}

// use the acf_load_vpn_comparisons_choices function to dynamically
// populate the options for the Reviews Radio Buttons ACF
add_filter('acf/load_field/name=comparison_choice', 'acf_load_vpn_comparisons_choices');

function acf_load_coupon_list_choices( $field ) {

    $field['choices'] = array();
    // retrieve all coupons
    $args = array(
        'post_type' => 'coupon_promotions',
        'post_status' => 'publish',
        'orderby' => 'post_title',
        'order' => 'ASC',
        'posts_per_page' => -1,
    );
    $coupons = new WP_Query( $args );

    // loop through article coupons and set their id as the key and their
    // name/post_title as the value
    if( is_array($coupons->posts) ) {
        foreach( $coupons->posts as $coupon ) {
            $coupon_post_fields = get_fields( $coupon->ID )['coupon_promotion'];
            $is_expired = is_utc_date_expired( $coupon_post_fields['expiration_date'], '-4 hours');

            if( !$is_expired ) $field['choices'][$coupon->ID] = $coupon->post_title;
        }
    }

    return $field;

}

// use the acf_load_coupon_list_choices function to dynamically
// populate the options for the Inline Coupon Dropdown ACF
add_filter('acf/load_field/name=coupon_promo_choice', 'acf_load_coupon_list_choices');


if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title'	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	
}

add_action( 'after_setup_theme', function() {
    register_nav_menus( array(
        'footer_menu'  => __( 'Footer Menu', 'avpn' ),
        'footer_lander' => __( 'Footer Lander', 'avpn')
    ) );
}, 20 );




function load_target_enqueue_script() {
    // enqueue acf extenstion

    global $post;
    if (!$post ||
        !isset($post->ID) ||
        get_post_type($post->ID) == 'acf-field-group' ) {
        return;
    }

    $handle = 'acf-dynamic-select';
    $version = acf_get_setting('version');

    $src = get_stylesheet_directory_uri() . '/js/acf-dynamic-select.js';

    // make this script dependent on acf-input
    $depends = array('acf-pro-input');

    wp_enqueue_script($handle, $src, $depends, $version, true);
}

add_action('wp_ajax_load_target_link_field_choices', 'ajax_load_target_link_field_choices');
add_action('acf/input/admin_enqueue_scripts', 'load_target_enqueue_script');



/************************Provider Table Ajax*******************************/

// Add Link Types to dropdown
function provider_table_cta_link() { ?>
    <script>
        jQuery(document).ready(function($){
            jQuery('body').on('change', '.provider_table_select .acf-input .select2-hidden-accessible', function() {
                var i = $( this ).index('.provider_table_select .acf-input .select2-hidden-accessible');
                $this = $(this);
                var post_id = this.value;
                var parent_post_id = '<?php echo $_GET['post']; ?>';
                var ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
                var str = 'post_id=' + post_id + '&parent_post_id=' + parent_post_id + '&action=provider_table_cta_link_ajax';
                jQuery.ajax({
                    type: "POST",
					dataType: "html",
					url: ajaxurl,
					data: str,
					beforeSend: function(){},
					success: function(data){
                        var SecDropDown = jQuery(".provider_table_cta_link_type .acf-input select:eq("+i+")");
                        SecDropDown.html('');
                        if(data.length){
                            SecDropDown.append(data);
                        }
					},
					complete: function(){},
					error : function(jqXHR, textStatus, errorThrown) {}
				});
            });
        })
    </script>
    <?php
}
add_action('admin_footer', 'provider_table_cta_link');

function provider_table_cta_link_ajax() {
    $post_id = (isset($_POST['post_id'])) ? $_POST['post_id'] : 0;

    $parent_post_id = $_POST['parent_post_id'];
    if($post_id!=0){
        $multiple_tracking_links = get_field('multiple_tracking_links',$post_id);
        if($multiple_tracking_links){
            $dataArray = [];
            $tracking_links = get_field('tracking_links',$post_id);
            $out .= '<option value=""> -- Please select -- </option>';
            foreach ($tracking_links as $vpn) {
                $link_type = $vpn['link_type'];

                $out .= '<option value="'.$link_type.'">' . ucfirst($link_type) . '</option>';
            }
        }
    }
    die($out);
}

function load_provider_table_cta_link() { ?>
    <script>
        jQuery(window).load(function(){
            var provider_post_id = [];

            var provider_id = jQuery('.provider_table_select');
            var parent_post_id = '<?php echo $_GET['post']; ?>';
            var ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
            for(var i = 0; i < (provider_id.length - 1); i++){

                var SelId = $(provider_id[i]).children(".acf-input").children("select").attr("id");

                provider_post_id.push(jQuery( "#" + SelId + " :selected").val());
            }

            var formData = 'post_id=' + provider_post_id + '&parent_post_id=' + parent_post_id + '&action=load_provider_table_cta_link_ajax';
            jQuery.ajax({
                type: "POST",
                dataType: "html",
                url: ajaxurl,
                data: formData,
                beforeSend: function(){},
                success: function(data){
                    var json_array = JSON.parse(data);
                    for(var i = 0; i < (provider_id.length - 1); i++){
                        var SecDropDown = jQuery(".provider_table_cta_link_type .acf-input select:eq("+i+")");
                        SecDropDown.html('');
                        if(data.length){
                            SecDropDown.append(json_array[i]);
                        }
                    }
                },
                complete: function(){},
                error : function(jqXHR, textStatus, errorThrown) {}
            });
        });
    </script>
    <?php
}
add_action('admin_footer', 'load_provider_table_cta_link');

function load_provider_table_cta_link_ajax() {
    // Array of post ids (Reviews Post ID)
    $post_ids = explode(",",$_POST['post_id']);
    // Page / Post ID
    $parent_post_id = $_POST['parent_post_id'];
    // Get Post Data
    $pid = get_post($parent_post_id);
    // Get blocks data
    $blocks = parse_blocks( $pid->post_content );

    
    $dataArray = [];

    // Set the select values
    foreach ( $blocks as $block ) {
        if( $block['blockName'] == 'acf/provider-table' ){
            $fields_data    =   $block['attrs']['data'];
            $rep_field      =   'table_providers';
            $sub_field      =   'provider_table_link_type';
            
            for ($i=0; $i < 100; $i++) {
                $final_name = $rep_field.'_'.$i.'_'.$sub_field; 
                if( $fields_data[$final_name] ){
                    $selected_values[$i] = $fields_data[$final_name];
                }
            }
        }
    }

    //Get the depandent dropdown values
    foreach ($post_ids as $key => $id) {
        if($id){
            $out = '';
            // check true false
            $multiple_tracking_links = get_field('multiple_tracking_links',$id);
            if($multiple_tracking_links){
                // get tracking links repeater
                $tracking_links = get_field('tracking_links',$id);
                // Creating Output data
                $out .= '<option value=""> -- Please select -- </option>';
                foreach ($tracking_links as $vpn) {
                    // Link type value
                    $link_type = $vpn['link_type'];
                    // Link detail
                    $link = $vpn['link'];
                    if ( $selected_values[$key] == $link_type ){
                        $selt = ' selected ';
                    }else{
                        $selt = '';
                    }
                    $out .= '<option ' . $selt . ' value="'.$link_type.'">' . ucfirst($link_type) . '</option>';
                }
            }
            $dataArray[$key] = $out;
        }
    }

    $json_data  =   json_encode($dataArray);
    echo $json_data;
    die();
}


// Add Links
function load_provider_table_link() { ?>
    <script>
        jQuery(document).ready(function($){
            jQuery('body').on('change', '.provider_table_cta_link_type .acf-input select', function() {
                var index_no = $( this ).index('.provider_table_cta_link_type .acf-input select');
                $this = $(this);
                var provider_type = this.value;

                var provider_select = jQuery('.provider_table_select');
                var parent_post_id = '<?php echo $_GET['post']; ?>';
                var ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";

                var SelId = $(provider_select[index_no]).children(".acf-input").children("select").attr("id");
                var provider_post_id = (jQuery( "#" + SelId + " :selected").val());
           
                var str = 'provider_post_id=' + provider_post_id + '&action=load_provider_table_link_ajax';
                jQuery.ajax({
                    type: "POST",
					dataType: "json",
					url: ajaxurl,
					data: str,
					beforeSend: function(){},
					success: function(data){
                        var tracking_links_array = data;            
                        tracking_links_array.forEach(function(tracking){
                            tracking.forEach(function(element) {
                                    if(element['link_type'] == provider_type) {
                                        tracking_link_final = element['link'];
                                    }
                             });
                        });
                            jQuery(".provider_table_ctalnk .acf-input input:eq("+index_no+")").val(tracking_link_final);
					},
					complete: function(){},
					error : function(jqXHR, textStatus, errorThrown) {}
				});
            });
        })
    </script>
    <?php
}
add_action('admin_footer', 'load_provider_table_link');

function load_provider_table_link_ajax() {
    $post_ids = explode(",",$_POST['provider_post_id']);
    if($post_ids){
        foreach($post_ids as $post_id) {
            $tracking_links[] = get_field('tracking_links',$post_id);
        }
        echo json_encode($tracking_links);
    }
    die();
}

// Action Hooks for Provider Table Link Start

add_action( 'wp_ajax_provider_table_cta_link_ajax', 'provider_table_cta_link_ajax' );
add_action( 'wp_ajax_nopriv_provider_table_cta_link_ajax', 'provider_table_cta_link_ajax' );

add_action( 'wp_ajax_load_provider_table_cta_link_ajax', 'load_provider_table_cta_link_ajax' );
add_action( 'wp_ajax_nopriv_load_provider_table_cta_link_ajax', 'load_provider_table_cta_link_ajax' );

add_action( 'wp_ajax_load_provider_table_link_ajax', 'load_provider_table_link_ajax' );
add_action( 'wp_ajax_nopriv_load_provider_table_link_ajax', 'load_provider_table_link_ajax' );

/************************Provider Table Ajax*******************************/

function my_acf_format_value( $value, $post_id, $field ) {

    return do_shortcode( $value );
}
add_filter('acf/format_value/type=text', 'my_acf_format_value', 10, 3);
add_filter('acf/format_value/type=textarea', 'my_acf_format_value', 10, 3);
add_filter('acf/format_value/type=wysiwyg', 'my_acf_format_value', 10, 3);

//ACF Dynamically Populate Selects with VPN Review choices
function acf_load_data_field_choices( $field ) {
    
    // reset choices
    $field['choices'] = array();
    
    
    // get the textarea value from options page without any formatting
    $choices = [
        'webrtc_leak_protection' => 'Webrtc Leak Protection',
        'dns_leak_protection' => 'DNS Leak Protection',
        'ip_leak_protection' => 'IP Leak Protection',
        'password_manager' => 'Password Manager',
        'ad_blocker' => 'Ad Blocker',
        'protocols' => 'Protocols',
        'browser_extension' => 'Browser Extension',
        'kill_switch' => 'Kill Switch',
        'router_support' => 'Router Support',
        'logging' => 'Logging Policy',
        'lowest_price' => 'Lowest Price',
        'free_trial' => 'Free Trial',
        'cryptocurrency_payment_method' => 'Cryptocurrency Payment Method',
        'money_back_guarantee' => 'Money Back Guarantee',
        'countries' => 'Number of Countries',
        'works_in_china' => 'Works in China',
        'mobile_app_available' => 'Mobile App Available',
        'number_of_ips' => 'Number of IPs',
        'number_of_servers' => 'Number of Servers',
        'number_of_devices' => 'Number of Devices / Licenses',
        'avgdl_speed' => 'Avg. Download Speed',
        'speed_loss' => '% Speed Loss',
        'unlimited_data' => 'Unlimited Data',
        'jurisdiction' => 'Jurisdiction',
        'customer_support' => 'Customer Support',
        'torrenting_allowed' => 'Torrenting Allowed?',
        'unblocks_netflix' => 'Unblocks Netflix?',
    ];

    // loop through array and add to field 'choices'
    if( is_array($choices) ) {
        
        foreach( $choices as $k => $v ) {
            
            $field['choices'][ $k ] = $v;
            
        }
        
    }

    // return the field
    return $field;
    
}

add_filter('acf/load_field/key=field_62a7ad81e3698', 'acf_load_data_field_choices');
add_filter('acf/load_field/key=field_62a7a7b098314', 'acf_load_data_field_choices');
