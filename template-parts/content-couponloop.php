<?php

//Coupon loop
$coupon = $args['coupon'];
$provider_id = $args['provider_id'];
$is_active = $args['is_active'];
$coupon_post_fields = get_fields( $coupon->ID )['coupon_promotion'];
$icon = get_the_post_thumbnail_url($provider_id);
$expiry_date = '';
$couponDataLayerOnClick = "";
if ($coupon_post_fields['expiration_date'] != ''){
    $date = date_create($coupon_post_fields['expiration_date']);
    $expiry_date = date_format($date, 'm/d/y');
}
$cta_link = $overlay = $coupon_inactive = $btn_inactive = $terms_link = '';

if ($is_active){
	$cta_link = 'href="'.$coupon_post_fields['cta_link'].'"';
    if ($coupon_post_fields['legal_copy']){
        $terms_link = '<a href="#" data-toggle="modal" data-target="#terms-'.$coupon->ID.'">Terms & Conditions</a>';
        $popup_args = [
            'legal-copy' => $coupon_post_fields['legal_copy'],
            'id' => 'terms-'.$coupon->ID
        ];
        get_template_part( 'template-parts/legal-popup', null,  $popup_args);
    }
    //datalayer info
    
    //dataLayerCoupon($couponTitle, $serviceProvider, $VPNCat, $VPNSubCat, $couponType, $couponURL )  
    $counter4Coupon =  $args['counter'];
    $couponDataLayerOnClick = dataLayerCoupon($coupon_post_fields['title'],get_field('vpn_name', $provider_id), "Deals", get_the_title(), "Inline", $coupon_post_fields['cta_link'] );
    
    
    
    $clickID4Coupon = 'coupon_page_'.prepare_click_id_vpn_name($provider_id) ."_". $counter4Coupon;
    
   
    
} else {
    $coupon_inactive = 'inactive-coupon';
	$btn_inactive = 'btn-inactive';
    $clickID4Coupon = "";
}

?>


<div class="inline-coupon-content-container">
    <div class="inline-coupon-content-inner <?php echo $coupon_inactive; ?>">
        <div class="deals-coupon-icon-container">
            <img src="<?php echo $icon; ?>" alt="<?php echo get_field('vpn_name', $provider_id); ?>" class="deals-coupon-icon" width="250" height="130" />
            <?php if ($is_active): ?>
                <a <?php echo $cta_link; ?> class="fill-coupon-container <?php  echo $clickID4Coupon; ?>" target="_blank" onclick="<?php echo $couponDataLayerOnClick; ?>"></a>   
            <?php endif; ?>
        </div>
        <div class="inline-coupon-title-description-container">
            <div class="deals-coupon-title-expiry-container">
                <h4 class="inline-coupon-title">
                    <?php echo $coupon_post_fields['title']; ?>
                </h4>
                <?php echo $expiry_date ? '<div class="deals-coupon-expiry">Expires: '.$expiry_date.'</div>' : false ?>
            </div>
            <div class="deals-coupon-description">
                    <?php echo $coupon_post_fields['description']; ?>
            </div>
             <?php if ($is_active): ?>
                <a <?php echo $cta_link; ?> class="fill-coupon-container <?php  echo $clickID4Coupon; ?>" target="_blank" onclick="<?php echo $couponDataLayerOnClick; ?>"></a>   
            <?php endif; ?>
        </div>
        <div class="inline-coupon-detail-button-container">
            <div class="inline-coupon-button-container">
                <a <?php echo $cta_link; ?> class="btn btn-primary btn-icon <?php echo $btn_inactive; ?> <?php  echo $clickID4Coupon; ?>" onclick="<?php echo $couponDataLayerOnClick; ?>" target="_blank">
                    Get this Deal
                </a>
            </div>
            <div class="inline-coupon-legal-container">
                <div class="inline-coupon-legal">
                    <?php  echo $terms_link; ?>
                </div>
            </div>
        </div>
    </div> 
</div>