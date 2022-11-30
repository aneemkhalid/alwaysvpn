<?php
/**
 * Template Name: Deals Child Page
 * Template Post Type: deals-pages
 *
 * @package WordPress
 * @subpackage Coinflip_Child
 * @since Coinflip Child 1.0
 * 
 * The template for displaying the deals child page.
 *
 */

get_header(); 
echo create_breadcrumbs_html(array('disclosure' => true));

$title = get_field('title');
$intro = get_field('intro');
$faqs_heading = get_field('faqs_heading');
$faqs = get_field('faqs');
$provider_id = get_field('vpn_provider');
$args = array(  
    'post_type' => 'coupon_promotions',
    'post_status' => 'publish',
    'orderby' => 'menu_order', 
    'order' => 'ASC',
    'posts_per_page' => -1,
    'meta_query' => array(
        array(
            'key' => 'coupon_promotion_vpn_provider',
            'value' => $provider_id,
            'compare' => '='
        )
    )
);
$coupons = get_posts( $args );
$active_coupons = [];
$expired_coupons = [];
$counterActiveCoupon = 0;
$couponAllHolder = '';
//loop through all coupons and organize them into arrays of active or expired
foreach ($coupons as $coupon){
    $expiration_date = get_field('coupon_promotion_expiration_date', $coupon->ID);
    $is_expired = is_utc_date_expired( $expiration_date, '-4 hours' );
    if ($is_expired){
        $expired_coupons[] = $coupon;
    } else {
        $active_coupons[] = $coupon;
    }
}
?>

    <!-- Page content -->
    <div id="primary" class="content-area no-sidebar deals-page content">
        <div class="container aggregate-page-container">
            <div class="row aggregate-row">
                <div class="main-content">
                    <div>
                        <h1 class="page-title"><?php echo $title; ?></h1>
                    </div>
                    <div class="header-separator"></div>
                        <div class="page-intro">
                            <?php echo $intro; ?>
                        </div>

                        <?php if (!empty($active_coupons)): ?>
                            <div class="active-coupons-container">
                                <?php foreach($active_coupons as $key=> $active_coupon):
                                    
                                    $counterActiveCoupon++;
                                
                                    $args = [
                                        'coupon' => $active_coupon,
                                        'is_active' => true,
                                        'provider_id' => $provider_id,
                                        'counter' => $counterActiveCoupon
                                    ];

                                    get_template_part( 'template-parts/content', 'couponloop', $args );
                                
                                    //dataLayer info
                                    //dataLayerProductImpression($VPNName, $VPNID, $dataLayerBrand, $dataLayerCategory, $dataLayerVariant, $dataLayerList, $dataLayerPosition )
                                    $couponInfoDataLayerNeeds = get_fields( $active_coupon->ID )['coupon_promotion'];
                                
                                    $couponProductImpression = dataLayerProductImpression(get_field('vpn_name', $provider_id), $couponInfoDataLayerNeeds['cta_link'], get_the_title(), "Deals", $couponInfoDataLayerNeeds['title'], get_the_title(), $counterActiveCoupon );
                                
                                    $couponAllHolder .= $couponProductImpression;

                                endforeach;?>
                            </div>
                    
                    
                                 <?php
                                   $dealChildPageOnLoad = dataLayerProductImpressionWrapper($couponAllHolder);
                             
                                ?>
                                <script>
                                <?php echo $dealChildPageOnLoad ; ?>
                                </script>  
                    
                        <?php else: ?>
                            <div class="no-active-coupons-container">
                                <div>Currently there are no active deals for this VPN provider   :-( </div>
                            </div>
                        <?php endif; ?> 
                        <div class="review-button-container"> 
                            <a href="<?php the_permalink($provider_id); ?>" class="btn btn-link btn-lg"> 
                                <span class="review-button-text"> Read our Review of <?php the_field('vpn_name', $provider_id); ?> </span> 
                            </a>
                        </div>
                        <?php if (!empty($expired_coupons)): ?>
                            <div class="expired-coupons-container">
                                <h2>Previous Deals</h2>
                                <?php foreach($expired_coupons as $key=> $expired_coupon):

                                    $args = [
                                        'coupon' => $expired_coupon,
                                        'is_active' => false,
                                        'provider_id' => $provider_id
                                    ];

                                    get_template_part( 'template-parts/content', 'couponloop', $args);

                                endforeach;?>
                            </div>
                        <?php endif; ?>   

                        

                        <?php if($faqs_heading) echo ' <h2 id="faq">'.$faqs_heading.'</h2>'; ?>
                        <?php 
                        
                        if (!empty($faqs) && $faqs != NULL){
                            $faq_toc = $faq_list = '';
                            $faq_toc .= '<ul class="lists">';
                            foreach ($faqs as $key => $faq){
                                $counter = $key+1;
                                $question = $faq['question'];
                                $answer = $faq['answer'];
                                $faq_toc .= '<li><a href="#'.strtolower(str_replace(' ','-',$question)).'">'.$question.'</a></li>';
                                $faq_list .= '<h3 id="'.strtolower(str_replace(' ','-',$question)).'">'.$counter.'. '.$question.'</h3>';
                                $faq_list .= '<div class="faq_ans">'.$answer.'</div>';
                            }
                            $faq_toc .= '</ul>'; 
                            echo $faq_toc;
                            echo $faq_list;
                        } ?>
                        
                </div>
            </div>
        </div>
    </div>


  

<?php get_footer(); ?>