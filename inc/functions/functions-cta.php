<?php


/************************Creative CTA Ajax*******************************/


// Add Link Types to dropdown
function provider_cta_link() { ?>
    <script>
        jQuery(document).ready(function($){
            jQuery('body').on('change', '.provider_select .acf-input .select2-hidden-accessible', function() {
                $this = $(this);
                var post_id = this.value;
                var parent_post_id = '<?php echo $_GET['post']; ?>';
                var ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
                var str = 'post_id=' + post_id + '&parent_post_id=' + parent_post_id + '&action=provider_cta_link_ajax';
                jQuery.ajax({
                    type: "POST",
					dataType: "html",
					url: ajaxurl,
					data: str,
					beforeSend: function(){},
					success: function(data){
                        var SecDropDown = jQuery(".cta_link_type .acf-input select");
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
add_action('admin_footer', 'provider_cta_link');

function provider_cta_link_ajax() {
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

// Saving CTA Link Type Ajax
function provider_link_type() { ?>
    <script>
        jQuery(document).ready(function($){
            jQuery('body').on('change', '.cta_link_type .acf-input select', function() {
                var selc_opt = this.value;
                var sid = this.id;
                var parent_post_id = '<?php echo $_GET['post']; ?>';
                var ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
                var selid = sid;
                var str = 'selc_opt=' + selc_opt + '&parent_post_id=' + parent_post_id + '&selid=' + selid + '&action=provider_link_type_ajax';
                jQuery.ajax({
                    type: "POST",
					dataType: "html",
					url: ajaxurl,
					data: str,
					beforeSend: function(){},
					success: function(data){
                        var $data = jQuery(data);
					},
					complete: function(){},
					error : function(jqXHR, textStatus, errorThrown) {}
				});
            });
        })
    </script>
    <?php
}
add_action('admin_footer', 'provider_link_type');

function provider_link_type_ajax() {
    $selc_opt = (isset($_POST['selc_opt'])) ? $_POST['selc_opt'] : 0;
    $parent_post_id = (isset($_POST['parent_post_id'])) ? $_POST['parent_post_id'] : 0;
    update_post_meta( $parent_post_id, 'cta_link_type' , $selc_opt );
    die($out);
}

// Load CTA Link Type
function load_cta_link_type() { ?>
    <script>
    function SelectVPNs(){
        jQuery( ".provider_select" ).each(function( index ) {
            var SelId = jQuery(this).children(".acf-input").children("select").attr("id");
            var VPN_VAL = jQuery( "#" + SelId + " :selected").val();

            var post_id = VPN_VAL;
            var parent_post_id = '<?php echo $_GET['post']; ?>';
            var ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
            var str = 'post_id=' + post_id + '&parent_post_id=' + parent_post_id + '&SelId=' + SelId + '&action=load_cta_link_type_ajax';
            jQuery.ajax({
                type: "POST",
                dataType: "html",
                url: ajaxurl,
                data: str,
                beforeSend: function(){},
                success: function(data){
                    var SecDropDown = jQuery(".cta_link_type .acf-input select");
                    SecDropDown.html('');
                    if(data.length){
                        SecDropDown.append(data);
                    }
                },
                complete: function(){},
                error : function(jqXHR, textStatus, errorThrown) {}
            });
        });
    }
    </script>
    <?php
}
add_action('admin_footer', 'load_cta_link_type');

function load_cta_link_type_ajax() {
    $post_id = $_POST['post_id']; // Reviews Post ID
    $parent_post_id = $_POST['parent_post_id'];
    $My_Post_Meta = get_post_meta( $parent_post_id, 'cta_link_type', true );

    if($post_id!=0){
        $multiple_tracking_links = get_field('multiple_tracking_links',$post_id);
        if($multiple_tracking_links){
            $dataArray = [];
            $tracking_links = get_field('tracking_links',$post_id);
            $out .= '<option value=""> -- Please select -- </option>';
            foreach ($tracking_links as $vpn) {
                $link_type = $vpn['link_type'];
                $link = $vpn['link'];
                if ( $My_Post_Meta == $link_type ){
                    $selt = ' selected ';
                }else{
                    $selt = '';
                }
                $out .= '<option ' . $selt . ' value="'.$link_type.'">' . ucfirst($link_type) . '</option>';
            }
        }
    }
    die($out);
}

function load_cta_link() { ?>
    <script>
        jQuery(document).ready(function($){
            jQuery('body').on('change', '.cta_link_type .acf-input select', function() {
                var post_id = jQuery('.provider_select .acf-input .select2-hidden-accessible').val();
                var ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
                var str = 'post_id=' + post_id + '&action=load_cta_link_ajax';
                jQuery.ajax({
                    type: "POST",
                    dataType: "json",
                    url: ajaxurl,
                    data: str,
                    beforeSend: function(){},
                    success: function(data){
                        for (let index = 0; index < data.length; index++) {
                            if(data[index]['link_type'] == jQuery('.cta_link_type .acf-input select').val()){
                                var link_val = data[index]['link'];
                            }
                        }
                        jQuery('.ctalnk .acf-input input').val(link_val);
                    },
                    complete: function(){},
                    error : function(jqXHR, textStatus, errorThrown) {}
                });
            });
        })
    </script>
    <?php
}
add_action('admin_footer', 'load_cta_link');

function load_cta_link_ajax() {
    $post_id = (isset($_POST['post_id'])) ? $_POST['post_id'] : 0;
    if($post_id!=0){
        $tracking_links = get_field('tracking_links',$post_id);
        echo json_encode($tracking_links);
        die();
    }
    die();
}

function save_cta_link() { ?>
    <script>
        jQuery(document).ready(function($){
            jQuery('body').on('change', '.cta_link_type .acf-input select', function(){
                setTimeout(function(){
                    var selc_opt = jQuery('.ctalnk .acf-input .acf-input-wrap input').val();
                    var parent_post_id = '<?php echo $_GET['post']; ?>';
                    var ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
                    var str =  'parent_post_id=' + parent_post_id + '&selc_opt=' + encodeURIComponent(selc_opt) + '&action=save_cta_link_ajax';
                    // console.log( str );
                    jQuery.ajax({
                        type: "POST",
                        dataType: "html",
                        url: ajaxurl,
                        data: str,
                        beforeSend: function(){},
                        success: function(data){
                            //var $data = jQuery(data);
                            //console.log(data);
                        },
                        complete: function(){},
                        error : function(jqXHR, textStatus, errorThrown) {
                            console.log('error');
                        }
                    });
                }, 3000);

            });
        })
    </script>
    <?php
}
add_action('admin_footer', 'save_cta_link');

function save_cta_link_ajax() {
    $selc_opt = (isset($_POST['selc_opt'])) ? $_POST['selc_opt'] : 0;
    $parent_post_id = (isset($_POST['parent_post_id'])) ? $_POST['parent_post_id'] : 0;
    update_field( 'cta_link', $selc_opt, $parent_post_id);
    die();
}

function view_cta_link_type() { ?>
    <script>
        jQuery(window).load(function(){
            var parent_post_id = '<?php echo $_GET['post']; ?>';
            var ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
            var str = 'parent_post_id=' + parent_post_id + '&action=view_cta_link_type_ajax';
            jQuery.ajax({
                type: "POST",
                dataType: "html",
                url: ajaxurl,
                data: str,
                beforeSend: function(){},
                success: function(data){
                    jQuery('.ctalnk .acf-input .acf-input-wrap input').val(data);
                },
                complete: function(){},
                error : function(jqXHR, textStatus, errorThrown) {}
            });
        });
    </script>
    <?php
}
add_action('admin_footer', 'view_cta_link_type');

function view_cta_link_type_ajax() {
    $parent_post_id = $_POST['parent_post_id'];
    $My_Post_Meta = get_post_meta( $parent_post_id, 'cta_link', true );
    echo $My_Post_Meta;
    die();
}

//Functions for Standalone CTA Select Target Field
function get_field_from_block( $selector, $post_id, $block_id ) {
    // If the post object doesn't even have any blocks, abort early and return false
    if ( ! has_blocks( $post_id ) ) {
        return false;
    }

    // Get our blocks from the post content of the post we're interested in
    $post_blocks = parse_blocks( get_the_content( '', false, $post_id ) );

    // Loop through all the blocks
    foreach ( $post_blocks as $block ) {

        // Only look at the block if it matches the $block_id
        if ( isset( $block['attrs']['id'] ) && $block_id == $block['attrs']['id'] ) {

            if ( isset( $block['attrs']['data'][$selector] ) ) {
                return $block['attrs']['data'][$selector];
            } else {
                break;  // If we found our block but didn't find the selector, abort the loop
            }

        }

    }

    return false;

}

function ajax_load_target_link_field_choices() {

    if (!wp_verify_nonce($_POST['nonce'], 'acf_nonce')) {
        die();
    }
    $vpn = 0;
    if (isset($_POST['vpn'])) {
        $vpn = intval($_POST['vpn']);
    }

    if (isset($_POST['postID'])) {
        $postID = intval($_POST['postID']);
    }

    if (isset($_POST['block'])) {
        $block = $_POST['block'];


    }

    if($postID && $block) {
        $target = get_field_from_block('select_target_link', $postID, $block);
    }
    
    else {
        $group = get_field('side_nav', $postID);
        $target = $group['select_target_link'];
    }
    //$target = parse_blocks( get_the_content( '', false, 53489 ) );

    // echo json_encode($target);
    // exit;

    $choices = array();

    $links = get_field('multiple_tracking_links', $vpn);
    $vpn_link = get_field('vpn_link', $vpn);
    $tracking = get_field('tracking_links', $vpn);

    if($links) {
        $index = 0;
        foreach($tracking as $item) {
            if($item['link_type'] == $target && $target) {
                $choices[] = array(
                    'value' => $item['link_type'], 
                    'label' => ucfirst($item['link_type']),
                    'selected' => 'selected',
                );
            }
            elseif(!$target && $index = 0) {
                $choices[] = array(
                    'value' => $item['link_type'], 
                    'label' => ucfirst($item['link_type']),
                    'selected' => 'selected',
                );
            }
            else {
                $choices[] = array(
                    'value' => $item['link_type'], 
                    'label' => ucfirst($item['link_type']),
                    'selected' => '',
                );
            } 
            $index++;
        }
    }
    else {
        $choices[] = array(
            'value' => 'website',
            'label' => 'Website', 
            'selected' => 'selected'
        );
    }

    echo json_encode($choices);
    exit;
}

/************************Creative CTA Ajax*******************************/

// Action Hooks for Creative CTA Start
add_action( 'wp_ajax_provider_cta_link_ajax', 'provider_cta_link_ajax' );        // to logged in users
add_action( 'wp_ajax_nopriv_provider_cta_link_ajax', 'provider_cta_link_ajax' );

add_action( 'wp_ajax_provider_link_type_ajax', 'provider_link_type_ajax' );        // to logged in users
add_action( 'wp_ajax_nopriv_provider_link_type_ajax', 'provider_link_type_ajax' );

add_action( 'wp_ajax_load_cta_link_type_ajax', 'load_cta_link_type_ajax' );        // to logged in users
add_action( 'wp_ajax_nopriv_load_cta_link_type_ajax', 'load_cta_link_type_ajax' );

add_action( 'wp_ajax_load_cta_link_ajax', 'load_cta_link_ajax' );        // to logged in users
add_action( 'wp_ajax_nopriv_load_cta_link_ajax', 'load_cta_link_ajax' );

add_action( 'wp_ajax_save_cta_link_ajax', 'save_cta_link_ajax' );        // to logged in users
add_action( 'wp_ajax_nopriv_save_cta_link_ajax', 'save_cta_link_ajax' );

add_action( 'wp_ajax_view_cta_link_type_ajax', 'view_cta_link_type_ajax' );        // to logged in users
add_action( 'wp_ajax_nopriv_view_cta_link_type_ajax', 'view_cta_link_type_ajax' );
// Action Hooks for Creative CTA End