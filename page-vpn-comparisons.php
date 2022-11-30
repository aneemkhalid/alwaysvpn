<?php
/**
 * Template Name: VPN Comparisons Tool
 *
 * @package WordPress
 * @subpackage Coinflip_Child
 * @since Coinflip Child 1.0
 * 
 * The template for displaying the comparisons aggregate page.
 *
 */

get_header(); 
echo create_breadcrumbs_html(array('disclosure' => true));

$title = get_field('title');
$results_title = get_field('results_title');
$description = get_field('description');

$args = array(  
    'post_type' => 'reviews',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'orderby' => 'menu_order', 
    'order' => 'ASC', 
);

$comparisons = new WP_Query( $args );

//Get review data for vpns to compare
$comp_data = [];

//Datalayer
$vpn_product_impression = "";
$vpn_pos = 1;

while($comparisons->have_posts()): $comparisons->the_post();

    $id = get_the_ID();

    $vpn_name = get_field('vpn_name', $id);

    $image = ($comp = get_field('compare_logo', $id)) ? $comp : get_field('vpn_image', $id);
    $comp_data[] = [
        'logo' => get_field('vpn_logo', $id),
        'pros' => get_field('pros', $id),
        'cons' => get_field('cons', $id),
        'link' => get_permalink($id),
        'image' => $image,
        'id' => $id,
        'datalayer' => dataLayerProductClick('Comparison Tool', $vpn_name, $id, $vpn_name, 'comparison_tool', $vpn_pos)
    ];

    //Datalayer info
    $vpn_impression = dataLayerProductImpression($vpn_name, $id, 'Comparison Tool', 'Comparison', 'comparison_tool', 'Comparison Tool', $vpn_pos);
    $vpn_product_impression .= $vpn_impression;

    $vpn_pos++;
    
endwhile;
wp_reset_postdata();

//Result page variables
$result = isset($_GET['vpn']);
$result_title = get_field('result_title');

$title = (!$result) ? $title : $result_title;

//Get vpns from url param
$vpns = $_GET['vpn'];
$vpns = explode(",", $vpns);
$vpnCount = count($vpns);

//Get logo and permalink
$vpn_info = [];
//Array for table info
$vpn_table = [];

//Datalayer
$vpn_result_pos = 1;
$vpn_product_impression_result = "";

//If vpns get data for tables
if($result) {
    foreach($vpns as $id) {

        //Get tracking link
        $multiple_tracking_links = get_field('multiple_tracking_links', $id);
        if($multiple_tracking_links){
            $cta_link = '';
            $tracking_links = get_field('tracking_links',$id);
            foreach ($tracking_links as $links) {
                // echo $links['link'].' '.$links['link_type'];
                if($links['link_type'] == 'general'){
                    $cta_link = $links['link'];
                }
            }
        } else{
            if(get_field('vpn_link', $id))
                $cta_link = get_field('vpn_link', $id)['url'];
        }

        $vpn_name = get_field('vpn_name', $id);
        $id_offer = getTrackingLinkInfo($id, 'offer_id');
        $id_aff = getTrackingLinkInfo($id, 'aff_id');

        $vpn_ind_click = dataLayerAddToCart($id_offer, $id_aff, 'Comparison Tool Result', $vpn_name, $id, 'Comparison Tool Result', 'Comparison', 'comparison_tool_result');

        $vpn_ind_click .= dataLayerOutboundLink($vpn_name, 'Comparison Tool', 'Result', $id_offer, $id_aff, 'comparison_tool_result');

        $vpn_info[] = [
            'logo' => get_field('vpn_logo', $id),
            'link' => $cta_link,
            'name' => $vpn_name,
            'click' => $vpn_ind_click,
        ];

        $vpn_impression = dataLayerProductImpression($vpn_name, $id, 'Comparison Tool Result', 'Comparison', 'comparison_tool_result', 'Comparison Tool Result', $vpn_result_pos);
        $vpn_product_impression_result .= $vpn_impression;
        //Privacy Table Info
        $vpn_table['Privacy/<wbr>Security']['WebRTC Leak Protection'][] =   get_field('webrtc_leak_protection', $id);
        $vpn_table['Privacy/<wbr>Security']['DNS Leak Protection'][] =      get_field('dns_leak_protection', $id);
        $vpn_table['Privacy/<wbr>Security']['IP Leak Protection'][] =       get_field('ip_leak_protection', $id);
        $vpn_table['Privacy/<wbr>Security']['Password Manager'][] =         get_field('password_manager', $id);
        $vpn_table['Privacy/<wbr>Security']['Ad Blocker'][] =               get_field('ad_blocker', $id);
        $vpn_table['Privacy/<wbr>Security']['Protocols'][] =                get_field('protocols', $id);
        $vpn_table['Privacy/<wbr>Security']['Browser Extension'][] =        get_field('browser_extension', $id);
        $vpn_table['Privacy/<wbr>Security']['Kill Switch'][] =              get_field('kill_switch', $id);
        $vpn_table['Privacy/<wbr>Security']['Router Support'][] =           get_field('router_support', $id);
        $vpn_table['Privacy/<wbr>Security']['Logging Policy'][] =           (get_field('logging', $id) == 'Yes') ? 1 : '';

        //Pricing/Payment
        $vpn_table['Pricing/<wbr>Payment']['Lowest Price'][] = get_field_object('lowest_price', $id)['prepend'] . get_field('lowest_price', $id);
        $vpn_table['Pricing/<wbr>Payment']['Free Trial'][] = get_field('free_trial', $id);
        $vpn_table['Pricing/<wbr>Payment']['Cryptocurrency Payment Method'][] = get_field('cryptocurrency_payment_method', $id);
        $vpn_table['Pricing/<wbr>Payment']['Money-Back Guarantee'][] = get_field('money_back_guarantee', $id);

        //Availability
        $vpn_table['Availability']['Number of Countries'][] = get_field('countries', $id);
        $vpn_table['Availability']['Works in China'][] = get_field('works_in_china', $id);
        $vpn_table['Availability']['Mobile App Available'][] = get_field('mobile_app_available', $id);
        $vpn_table['Availability']['Number of IPs'][] = get_field('number_of_ips', $id);
        $vpn_table['Availability']['Number of Servers'][] = get_field('number_of_servers', $id);
        $vpn_table['Availability']['Number of Devices / Licenses'][] = get_field('number_of_devices', $id);

        //Speed Table
        $vpn_table['Speed']['Avg. Download Speed'][] = get_field('avgdl_speed', $id);
        $vpn_table['Speed']['% Speed Loss'][] = get_field('speed_loss', $id);
        $vpn_table['Speed']['Unlimited Data'][] = get_field('unlimited_data', $id);

        //Company Info
        $vpn_table['Company Info']['Jurisidiction'][] = get_field('jurisdiction', $id);
        $vpn_table['Company Info']['Customer Support'][] = get_field('customer_support', $id);

        //Entertainment Table
        $vpn_table['Entertainment']['Torrenting Allowed?'][] = get_field('torrenting_allowed', $id);
        $vpn_table['Entertainment']['Unblocks Netflix?'][] = get_field('unblocks_netflix', $id);


        $vpn_result_pos++;
    }

    //Filter out empty subarrays inside vpn_table
    foreach($vpn_table as $tab => &$sub) {
        foreach($sub as $arr => &$value) {
            $filter = array_filter($value);
            //Unset subarray if completely empty
            if(empty($filter)) {
                unset($vpn_table[$tab][$arr]);
            }
            //Change customer support links to actual link
            if($arr == 'Customer Support') {
                foreach($value as &$val) {
                    if($val) {
                        if(preg_match('/^(\+|\(|\d)/', $val)) {
                            $val = '<a href="tel:'. $val .'" target="_blank">Support</a>';
                        }
                        elseif(preg_match('/^[A-z0-9_\-]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z.]{2,4}$/', $val)) {
                            $val = '<a href="mailto:'. $val .'" target="_blank">Support</a>';
                        }
                        else {
                            $val = '<a href="'. $val .'" target="_blank">Support</a>';
                        }
                    }
                }
            }
            if($arr == 'Protocols') {
                foreach($value as &$val) {
                    if($val) {
                        $val = count($val);
                    }
                }
            }
            foreach($value as &$val) {
                //echo $val;
                if($val == '1') {
                    $val = '<svg xmlns="http://www.w3.org/2000/svg" class="compare-checkmark" viewBox="0 0 20 20" height="20" width="20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>';
                }
                elseif($val == '0') {
                    $val = 'No';
                }
                elseif($val == false) {
                    $val = '--';
                }
                
            }
            unset($val);
            

        }
    }
}

//Generate product impression wrapper
$vpn_prod_impress_wrap = dataLayerProductImpressionWrapper($vpn_product_impression);
$vpn_prod_impress_result_wrap = dataLayerProductImpressionWrapper($vpn_product_impression_result);


?>

<div id="primary">

    <div class="header-content">
        <div class="container">
            <div>
                <h1 class="page-title"><?php echo $title ?></h1>
            </div>
            <div class="header-separator"></div>
            <div class="content-description">
                <?php echo $description ?>
            </div>
        </div>
    </div>

    <?php 
        if(!$result) {
            include('template-parts/comparison-tool.php');
        }
        else {
            include('template-parts/comparison-tool-result.php');
        }
    ?>
    
    <?php //echo "<pre>"; print_r( $vpn_privacy ); echo "</pre><hr />"; ?>
    <?php //echo "<pre>"; print_r( $vpn_table ); echo "</pre><hr />"; ?>
</div>

<?php get_footer(); ?>