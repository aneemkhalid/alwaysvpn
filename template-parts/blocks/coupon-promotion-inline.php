<?php

/**
 * Coupon Promotion.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$vpn_id = isset( $args['vpn_id']) && !empty( $args['vpn_id'] ) ? $args['vpn_id'] : "";
$vpn_name = isset( $args['vpn_name']) && !empty( $args['vpn_name'] ) ? $args['vpn_name'] : "";

$inline_coupon_id = get_field( 'coupon_promo_choice' );

if($inline_coupon_id){
    $coupon_post_fields = get_fields( $inline_coupon_id )['coupon_promotion'];
    $is_expired = is_utc_date_expired( $coupon_post_fields['expiration_date'], '-4 hours' );
    
    $provider_post_fields = get_fields( $coupon_post_fields['vpn_provider']);
    
    
    
    $vpn_name_id_coupon_il =  prepare_click_id_vpn_name( $coupon_post_fields['vpn_provider'] );
    
    
    if( !$is_expired && is_array( $coupon_post_fields ) ):
        extract($coupon_post_fields);
    
    
    
    $offerIDVPNCoupInL = getTrackingLinkInfoCoupon($cta_link, 'offer_id');
    
    $affIDVPNCoupInL= getTrackingLinkInfoCoupon($cta_link, 'aff_id');
    
    $pageTitle = get_the_title();
    
    $couponNameInL = get_post_field( 'post_name', $vpn_provider );
    
    
    if (get_field('category_of_page')) {
    $catVPNInL = get_field('category_of_page');
    } else {
        $catVPNInL =  get_permalink();   
        $catVPNInL = checkURLForCatDataLayer($catVPNInL);
    
    }
    //dataLayerCoupon($couponTitle, $serviceProvider, $VPNCat, $VPNSubCat, $couponType, $couponURL );
    $coupInLOnClick = dataLayerCoupon($title, $couponNameInL, $catVPNInL, $pageTitle, "Inline", $cta_link );

    
    ?>
    <div class="inline-coupon-content-container desktop">
        <div class="inline-coupon-icon-container">
            <img src="<?php echo $icon['sizes']['thumbnail']; ?>" alt="logo" class="inline-coupon-icon" height="100" width="100">
        </div>
        <div class="inline-coupon-title-description-container">
            <div class="inline-coupon-title-container">
                <h3 class="inline-coupon-title">
                    <?php echo $title; ?>
                </h3>
            </div>
            <div class="inline-coupon-description-container">
                <div class="inline-coupon-description">
                    <?php echo $description; ?>
            </div>
            </div>
            <div class="inline-coupon-legal-container">
                <div class="inline-coupon-legal">
                    <?php echo $legal_copy; ?>
                </div>
            </div>
        </div>
        <div class="inline-coupon-detail-button-container">
            <div class="inline-coupon-detail-container">
                <div class="inline-coupon-detail">
                    <?php echo $discount_detail; ?>
                </div>
            </div>
            <div class="inline-coupon-button-container">
    
                <a id="coupon_inline_desktop_<?php echo $vpn_name_id_coupon_il; ?>" href="<?php echo $cta_link; ?>" class="btn btn-primary btn-sm btn-icon" onClick="<?php echo $coupInLOnClick; ?>" target="_blank">
    
                    Get Deal
                </a>
            </div>
        </div>
    </div>
    <div class="inline-coupon-content-container mobile">
        <div class="inline-coupon-icon-container">
            <img src="<?php echo $icon['sizes']['thumbnail']; ?>" alt="logo" class="inline-coupon-icon" height="100" width="100">
        </div>
        <div class="inline-coupon-title-container">
            <h3 class="inline-coupon-title">
                <?php echo $title; ?>
            </h3>
        </div>
        <div class="inline-coupon-description-container">
            <div class="inline-coupon-description">
                <?php echo $description; ?>
        </div>
        </div>
        <div class="inline-coupon-legal-container">
            <div class="inline-coupon-legal">
                <?php echo $legal_copy; ?>
            </div>
        </div>
            <div class="inline-coupon-detail-container">
            <div class="inline-coupon-detail">
                <?php echo $discount_detail; ?>
            </div>
        </div>
        <div class="inline-coupon-button-container">
    
            <a id="coupon_inline_mobile_<?php echo $vpn_name_id_coupon_il; ?>" href="<?php echo $cta_link; ?>" class="btn btn-primary btn-lg btn-icon" onClick="<?php echo $coupInLOnClick; ?>" target="_blank">
    
                Get Deal
            </a>
        </div>
    </div>
    <?php endif;
} else {
    $coupon_args = array(
        'post_type' => 'coupon_promotions',
        'posts_per_page' => -1
        
    );
    $coupon_query = new WP_Query( $coupon_args );
    
    // The Loop
    if ( $coupon_query->have_posts() ) {
        while ( $coupon_query->have_posts() ) {
            $coupon_query->the_post();

            $coupon_promotion = get_field('coupon_promotion');
            $vpn_provider = $coupon_promotion['vpn_provider'];
            $expiration_date = $coupon_promotion['expiration_date'];
            $icon = $coupon_promotion['icon'];
            $title = $coupon_promotion['title'];
            $description = $coupon_promotion['description'];
            $legal_copy = $coupon_promotion['legal_copy'];
            $discount_detail = $coupon_promotion['discount_detail'];
            $cta_link = $coupon_promotion['cta_link'];
            $is_expired = is_utc_date_expired($expiration_date, '-4 hours');
            $vpn_name_id_coupon_il =  prepare_click_id_vpn_name( $coupon_promotion['vpn_provider'] );

            if($vpn_provider == $vpn_id){
                if(!$is_expired){ 
                    $offerIDVPNCoupInL = getTrackingLinkInfoCoupon($cta_link, 'offer_id');

                    $affIDVPNCoupInL= getTrackingLinkInfoCoupon($cta_link, 'aff_id');

                    $pageTitle = get_the_title();

                    $couponNameInL = get_post_field( 'post_name', $vpn_provider );


                    if (get_field('category_of_page')) {
                    $catVPNInL = get_field('category_of_page');
                    } else {
                        $catVPNInL =  get_permalink();   
                        $catVPNInL = checkURLForCatDataLayer($catVPNInL);

                    }
                    //dataLayerCoupon($couponTitle, $serviceProvider, $VPNCat, $VPNSubCat, $couponType, $couponURL );
                    $coupInLOnClick = dataLayerCoupon($title, $couponNameInL, $catVPNInL, $pageTitle, "Inline", $cta_link );
                    
                    ?>
                    <div class="inline-coupon-content-container desktop">
                        <div class="inline-coupon-icon-container">
                            <img src="<?php echo $icon['sizes']['thumbnail']; ?>" alt="logo" class="inline-coupon-icon" height="100" width="100">
                        </div>
                        <div class="inline-coupon-title-description-container">
                            <div class="inline-coupon-title-container">
                                <h3 class="inline-coupon-title">
                                    <?php echo $title; ?>
                                </h3>
                            </div>
                            <div class="inline-coupon-description-container">
                                <div class="inline-coupon-description">
                                    <?php echo $description; ?>
                            </div>
                            </div>
                            <div class="inline-coupon-legal-container">
                                <div class="inline-coupon-legal">
                                    <?php echo $legal_copy; ?>
                                </div>
                            </div>
                        </div>
                        <div class="inline-coupon-detail-button-container">
                            <div class="inline-coupon-detail-container">
                                <div class="inline-coupon-detail">
                                    <?php echo $discount_detail; ?>
                                </div>
                            </div>
                            <div class="inline-coupon-button-container">

                                <a id="coupon_inline_desktop_<?php echo $vpn_name_id_coupon_il; ?>" href="<?php echo $cta_link; ?>" class="btn btn-primary btn-sm btn-icon" onClick="<?php echo $coupInLOnClick; ?>" target="_blank">

                                    Get Deal
                                </a>
                            </div>
                        </div>
                    </div>


                    <div class="inline-coupon-content-container mobile">
                        <div class="inline-coupon-icon-container">
                            <img src="<?php echo $icon['sizes']['thumbnail']; ?>" alt="logo" class="inline-coupon-icon" height="100" width="100">
                        </div>
                        <div class="inline-coupon-title-container">
                            <h3 class="inline-coupon-title">
                                <?php echo $title; ?>
                            </h3>
                        </div>
                        <div class="inline-coupon-description-container">
                            <div class="inline-coupon-description">
                                <?php echo $description; ?>
                        </div>
                        </div>
                        <div class="inline-coupon-legal-container">
                            <div class="inline-coupon-legal">
                                <?php echo $legal_copy; ?>
                            </div>
                        </div>
                            <div class="inline-coupon-detail-container">
                            <div class="inline-coupon-detail">
                                <?php echo $discount_detail; ?>
                            </div>
                        </div>
                        <div class="inline-coupon-button-container">

                            <a id="coupon_inline_mobile_<?php echo $vpn_name_id_coupon_il; ?>" href="<?php echo $cta_link; ?>" class="btn btn-primary btn-lg btn-icon" onClick="<?php echo $coupInLOnClick; ?>" target="_blank">

                                Get Deal
                            </a>
                        </div>
                    </div>
                <?php
                }
            
            }
        }
    } 
    wp_reset_postdata();
}
