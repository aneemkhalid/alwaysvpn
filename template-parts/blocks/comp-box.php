<?php

/**
 * Comparison Box Block.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$information_type = get_field('information_type');

$vpn_ID = get_field('select_first_vpn');

//dataLayer
$priceNumbComp = 00.01;
$positionNumComp = 0;
$positionNumPricing = 0;
$VPNCompAllHolder = "";
if($information_type == 'detailed_information'): ?>
    <div class="comparison_box_wrap">
        <?php 
            
            for( $i=0; $i<2; $i++ ){

                $features_list = get_field('first_features_list');
                $vpn_anchor_id = get_field('vpn_anchor_id');
                $featured_img_url = get_the_post_thumbnail_url($vpn_ID,'full');

                if($i > 0){ 
                    $vpn_ID = get_field('select_second_vpn'); 
                    $features_list = get_field('second_features_list');
                    $vpn_anchor_id = get_field('second_vpn_anchor_id');
                    $featured_img_url = get_the_post_thumbnail_url($vpn_ID,'full');
                }
                
                $vpn_image = get_field('vpn_image',$vpn_ID);
                $vpn_name = get_field('vpn_name',$vpn_ID);
                $vpn_link = get_field('vpn_link',$vpn_ID);
                $detailed_information_outbound_id = prepare_outbound_id( $vpn_ID );
                $short_information_outbound_id = prepare_outbound_id( $vpn_ID );
                
                $lowest_price = get_field('lowest_price',$vpn_ID);

                $avgdl_speed = get_field('avgdl_speed',$vpn_ID);
                $logging = get_field('logging',$vpn_ID);
                $countries = get_field('countries',$vpn_ID);

                $privacy = get_field('privacy',$vpn_ID);
                $trust = get_field('trust',$vpn_ID);
                $ease_of_use = get_field('ease_of_use',$vpn_ID);
                $price = get_field('price',$vpn_ID);
                $speed = get_field('speed',$vpn_ID);
                $avg_rating = array_sum(array($privacy, $trust, $ease_of_use, $price, $speed))/5;
                $avg_rating = number_format((float)$avg_rating, 1, '.', '');
                
                
                  
                //dataLayer info
                $idNumVPNComp = getTrackingLinkInfo($vpn_ID, 'offer_id');

                $idNumAffVPNComp = getTrackingLinkInfo($vpn_ID, 'aff_id');

                  $positionNumComp++;                             
                  $subCatPageTitle = get_the_title();

                  //dataLayerProductImpression($VPNName, $VPNID, $dataLayerBrand, $dataLayerCategory, $dataLayerVariant, $dataLayerList, $dataLayerPosition )
                  $VPNCompIndv = dataLayerProductImpression($vpn_name, $vpn_ID, "VPN", "Comparisons", "comparison_provider_overview", $subCatPageTitle , $positionNumComp );

                  $VPNCompAllHolder .= $VPNCompIndv;

                 // dataLayerAddToCart($dataLayerOfferId, $dataLayerAffId, $dataLayerList,  $VPNName, $VPNID, $dataLayerBrand, $VPNCat, $dataLayerVariant )
                        
                $VPNCompIndvOnClick = dataLayerAddToCart($idNumVPNComp, $idNumAffVPNComp, "Comparisons - ". $subCatPageTitle,  $vpn_name, $idNumVPNComp, $vpn_name, 'Comparisons', 'comparison_end_of_page' );  
                
                //dataLayerOutboundLink($VPNName, $VPNCat, $VPNSubCat,  $dataLayerOfferId, $dataLayerAffId, $dataLayerLinkType )
                $VPNCompIndvOnClick .= dataLayerOutboundLink($vpn_name, 'Comparisons', $subCatPageTitle,  $idNumVPNComp, $idNumAffVPNComp, 'comparison_provider_summary' );

                if($vpn_ID): 
                    ?>
                    <div class="comparison_box">
                        <?php if($featured_img_url) echo ' <img src="'.$featured_img_url.'" alt="">'; ?>
                        <div class="comparison_box_inner" <?php if($vpn_anchor_id) echo 'id="'.$vpn_anchor_id.'"'; ?>>
                            <?php 
                                if($vpn_name)
                                    echo '<h4>'.$vpn_name.'</h4>';
                            ?>
                            
                            <div class="vpn-features">
                                <div class="individual-feature">
                                    <div class="feature-icon">
                                        <img src="<?php echo get_stylesheet_directory_uri() ?>/images/icons/cost_icon.svg" alt="Cost">
                                    </div>
                                    <div class="feature-info">
                                        Lowest Price:
                                        <span><?php if($lowest_price) echo '$'.$lowest_price; ?></span>
                                    </div>
                                </div>
                                <div class="individual-feature">
                                    <div class="feature-icon">
                                        <img src="<?php echo get_stylesheet_directory_uri() ?>/images/icons/speed_icon.svg" alt="Speed">
                                    </div>
                                    <div class="feature-info">
                                        Avg.DL Speed:
                                        <span><?php echo $avgdl_speed; ?></span>
                                    </div>
                                </div>
                                <div class="individual-feature">
                                    <div class="feature-icon">
                                        <img src="<?php echo get_stylesheet_directory_uri() ?>/images/icons/contract_icon.svg" alt="Contract">
                                    </div>
                                    <div class="feature-info">
                                        Logging:
                                        <span><?php echo $logging; ?></span>
                                    </div>
                                </div>
                                <div class="individual-feature">
                                    <div class="feature-icon">
                                        <img src="<?php echo get_stylesheet_directory_uri() ?>/images/icons/location_icon.svg" alt="Location">
                                    </div>
                                    <div class="feature-info">
                                        Countries:
                                        <span><?php echo $countries; ?></span>
                                    </div>
                                </div>
                            </div>
                            <?php
                                // the_field('features');
                                // Check rows exists.
                                if( $features_list ):
                                    echo '<ul>';
                                        // Loop through rows.
                                        foreach ($features_list as $key => $feature) {
                                            if($feature['feature']){
                                                echo '<li>'.$feature['feature'].'</li>';
                                            }
                                            
                                        }
                                    echo '</ul>';
                                // No value.
                                else :
                                    // Do something...
                                endif;
                            ?> 
                            <?php 
                                if($vpn_name){

                                    $MultiLink = get_field('multiple_tracking_links',$vpn_ID);
                                    if ( $MultiLink == 0 ){
                                        if($vpn_link){
                                            $vpn_link = $vpn_link['url'];
                                        }else{
                                            $vpn_link = '';
                                        }
                                    }else{
                                        $rows = get_field('tracking_links', $vpn_ID);
                                        if( $rows ) {
                                            $first_row = $rows[0];
                                            $link_type = $first_row['link_type'];
                                            $link_url = $first_row['link'];
                                            $vpn_link = $link_url;
                                        }else{
                                            $vpn_link = '';
                                        }
                                    }                                
                                echo '<div class="vpn-btn-wrap">
                                        <a href="'.$vpn_link.'" id="'.$short_information_outbound_id.'" class="btn btn-primary btn-icon btn-lg " onClick="'. $VPNCompIndvOnClick .'"  target="_blank">Visit '.$vpn_name.'</a>
                                    </div>';

                                }
                            ?>
                            
                        </div>
                        
                        <!-- <div class="rating rating-<?php echo round($avg_rating); ?>">
                            <span><?php echo $avg_rating; ?></span>
                            <i class="fa fa-star"></i>
                        </div> -->
                    </div>
                    <?php 
                endif;
            }
        ?>
    </div>
     <?php

       $VPNCompOnLoad = dataLayerProductImpressionWrapper($VPNCompAllHolder);
           
    ?>
    <script>
    <?php echo $VPNCompOnLoad ; ?>
    </script>   

<?php
elseif($information_type == 'short_information'): ?>
    <div class="comparison_box_wrap no-feature">
        <?php 
            for( $i=0; $i<2; $i++ ){ 
                    if($i > 0){ 
                        $vpn_ID = get_field('select_second_vpn'); 
                    } 
                    $featured_img_url = get_the_post_thumbnail_url($vpn_ID,'full');
                    $thumb_id = get_post_thumbnail_id($vpn_ID);
                    $alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true); 
                    $vpn_image = get_field('vpn_image',$vpn_ID);
                    $vpn_name = get_field('vpn_name',$vpn_ID);
                    $vpn_link = get_field('vpn_link',$vpn_ID);
                    $short_information_outbound_id = prepare_outbound_id( $vpn_ID );

                    $privacy = get_field('privacy',$vpn_ID);
                    $trust = get_field('trust',$vpn_ID);
                    $ease_of_use = get_field('ease_of_use',$vpn_ID);
                    $price = get_field('price',$vpn_ID);
                    $speed = get_field('speed',$vpn_ID);

                    $avg_rating = array_sum(array($privacy, $trust, $ease_of_use, $price, $speed))/5;
                    $avg_rating = number_format((float)$avg_rating, 1, '.', '');
                
                        
                  //dataLayer info
                  $idNumVPNComp = getTrackingLinkInfo($vpn_ID, 'offer_id');

                  $idNumAffVPNComp = getTrackingLinkInfo($vpn_ID, 'aff_id');

                $subCatPageTitle = get_the_title();

                   // dataLayerAddToCart($dataLayerOfferId, $dataLayerAffId, $dataLayerList,  $VPNName, $VPNID, $dataLayerBrand, $VPNCat, $dataLayerVariant )
                        
                    $VPNCompIndvEndofPageOnClick = dataLayerAddToCart($idNumVPNComp, $idNumAffVPNComp, "Comparisons - ". $subCatPageTitle,  $vpn_name, $idNumVPNComp, $vpn_name, 'Comparisons', 'comparison_end_of_page' );  
                        
                    //dataLayerOutboundLink($VPNName, $VPNCat, $VPNSubCat,  $dataLayerOfferId, $dataLayerAffId, $dataLayerLinkType )
                   $VPNCompIndvEndofPageOnClick .= dataLayerOutboundLink($vpn_name, 'Comparisons', $subCatPageTitle,  $idNumVPNComp, $idNumAffVPNComp, 'comparison_end_of_page' );
                
                    ?>
                    <div class="comparison_box">
                        <?php if($featured_img_url) echo ' <img src="'.$featured_img_url.'" alt="'. $alt . '">'; ?>
                        <div class="comparison_box_inner">
                            <?php if($vpn_name){ echo '<h4>'.$vpn_name.'</h4>'; } ?>
                            <?php 
                                if($vpn_name){
                                    $MultiLink = get_field('multiple_tracking_links',$vpn_ID);
                                    if ( $MultiLink == 0 ){
                                        if($vpn_link){
                                            $vpn_link = $vpn_link['url'];
                                        }else{
                                            $vpn_link = '';
                                        }
                                    }else{
                                        $rows = get_field('tracking_links', $vpn_ID);
                                        if( $rows ) {
                                            $first_row = $rows[0];
                                            $link_type = $first_row['link_type'];
                                            $link_url = $first_row['link'];
                                            $vpn_link = $link_url;
                                        }else{
                                            $vpn_link = '';
                                        }
                                    }                                
                                echo '<div class="vpn-btn-wrap">
                                        <a href="'.$vpn_link.'" id="'.$short_information_outbound_id.'" class="btn btn-primary btn-icon btn-lg" onClick="'. $VPNCompIndvEndofPageOnClick .'"  target="_blank">Visit '.$vpn_name.'</a>
                                    </div>';
                                }
                            ?>
                        </div>
                        <!-- <div class="rating rating-< ?php echo round($avg_rating); ?>">
                            <span>< ?php echo $avg_rating; ?></span>
                            <i class="fa fa-star"></i>
                        </div> -->
                    </div>
                <?php
            }
        ?>
        
    </div>
<?php 
elseif($information_type == 'pricing_comparison'):

    $second_vpn_ID = get_field('select_second_vpn');
    $pricing_anchor_id = get_field('pricing_anchor_id');

    $plan_link = get_field('plan_link');
    $second_plan_link = get_field('second_plan_link');

    $vpn_image = get_field('vpn_image',$vpn_ID);
    $second_vpn_image = get_field('vpn_image',$second_vpn_ID);

    $money_back_guarantee = get_field('money_back_guarantee',$vpn_ID);
    $second_money_back_guarantee = get_field('money_back_guarantee',$second_vpn_ID);
    
    $number_of_devices = get_field('number_of_devices',$vpn_ID);
    $second_number_of_devices = get_field('number_of_devices',$second_vpn_ID);

    $lowest_price = get_field('lowest_price',$vpn_ID);
    $second_lowest_price = get_field('lowest_price',$second_vpn_ID);
    
    //dataLayer info
    $priceNumbCompPrice = 00.01;
    $idNumVPNCompPricing1 = getTrackingLinkInfo($vpn_ID, 'offer_id');
    $idNumVPNCompPricing2 = getTrackingLinkInfo($second_vpn_ID, 'offer_id');
    $subCatPageTitlePricing = get_the_title();
    $vpn_name1 = get_field('vpn_name',$vpn_ID);
    $vpn_name2 = get_field('vpn_name',$second_vpn_ID);


     //dataLayerProductClick($dataLayerList, $VPNName, $VPNID, $dataLayerBrand, $dataLayerVariant, $dataLayerPosition ) 

    $VPNCompIndvPricingOnClick1 = dataLayerProductClick("Comparisons - ". $subCatPageTitlePricing, $vpn_name1, $idNumVPNCompPricing1, $vpn_name1, 'comparison_pricing_table', 1 );

    $VPNCompIndvPricingOnClick2 = dataLayerProductClick("Comparisons - ". $subCatPageTitlePricing, $vpn_name2, $idNumVPNCompPricing2, $vpn_name2, 'comparison_pricing_table', 2 );


    ?>
    <div class="pricing-table-wrap">
            <table class="pricing-table" width="100%" border="0" cellpadding="0" cellspacing="0" style="border:0;">
                <thead>
                    <tr>
                        <th>Pricing</th>
                    </tr>
                </thead>
                <tr>
                    <td>
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" style="border:0;" <?php if($pricing_anchor_id) echo 'id="'.$pricing_anchor_id.'"'; ?>>
                            <tr>
                                <td></td>
                                <td><?php if($vpn_image) echo ' <img src="'.$vpn_image.'" alt="' . $vpn_name1 . '">'; ?></td>
                                <td><?php if($second_vpn_image) echo ' <img src="'.$second_vpn_image.'" alt="' . $vpn_name2 . '">'; ?></td>
                            </tr>
                            <tr>
                                <td>Lowest Price</td>
                                <td><?php if($lowest_price) echo '$'.$lowest_price; ?></td>
                                <td><?php if($second_lowest_price) echo '$'.$second_lowest_price; ?></td>
                            </tr>
                            <tr>
                                <td>Money Back Guarantee</td>
                                <td><?php if($money_back_guarantee) echo $money_back_guarantee; ?></td>
                                <td><?php if($second_money_back_guarantee) echo $second_money_back_guarantee; ?></td>
                            </tr>
                            <tr>
                                <td># of Devices</td>
                                <td><?php if($number_of_devices) echo $number_of_devices; ?></td>
                                <td><?php if($second_number_of_devices) echo $second_number_of_devices; ?></td>
                            </tr>
                            <tr>
                                <td>See Plans &amp; Pricing</td>
                                <td><a class="btn btn-primary btn-sm" href="<?php if($plan_link) echo $plan_link; ?>" onClick="<?php echo $VPNCompIndvPricingOnClick1 ?>">See Plans</a></td>
                                <td><a class="btn btn-primary btn-sm" href="<?php if($second_plan_link) echo $second_plan_link; ?>" onClick="<?php echo $VPNCompIndvPricingOnClick2 ?>">See Plans</a></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
<?php
endif;