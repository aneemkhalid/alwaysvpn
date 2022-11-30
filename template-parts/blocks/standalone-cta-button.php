<?php

/**
 * Comparison Box Block.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$select_vpn = get_field('select_vpn');
$link_type = get_field('link_type');
$select_target_link = get_field('select_target_link');
$TrkLinks = get_field('tracking_links',$select_vpn);
$cta_type = get_field('cta_type');
$other_link = get_field('other_link');
$DebugInfo = false;

if  ( $DebugInfo == true ){
    echo "<pre>"; print_r( "Selected VPN : " . $select_vpn ); echo "</pre>"; 
    echo "<pre>"; print_r( "Link Type : " . $link_type ); echo "</pre>"; 
    echo "<pre>"; print_r( "Select Target Link : " . $select_target_link ); echo "</pre>";
    echo "<pre>"; print_r( "Tarcking Link : " . $TrkLinks ); echo "</pre>";
}

$General_Button = ''; $Review_Button = '';
$VPN_Link = ''; $VPN_Target = '';
$Review_Link = ''; $Review_Target = '';

if($cta_type != 'Other') { // BEGIN VPN CTA

    $VPN_Link = get_the_permalink($select_vpn);
    $VPN_Target = ' target="_blank" ';

    $vpn_id_name_standalone = prepare_outbound_id( $select_vpn );

    //echo "<pre>"; print_r( "Track Links : " . $TrkLinks ); echo "</pre>";
    //echo "<pre>"; print_r( $select_target_link ); echo "</pre>";

    //datalayer info

    $ctaVPNID = getTrackingLinkInfo($select_vpn, 'offer_id');
    $ctaVPNIDAff = getTrackingLinkInfo($select_vpn,  'aff_id'); 
    $ctaVPNName = get_field('vpn_name',$select_vpn);
    $ctaCategory =  get_the_category();

    //if no category switch it to standard
    if ($ctaCategory[0]->cat_name) {
        $ctaCategory = $ctaCategory[0]->cat_name;
    } else {
        $ctaCategory = "Standard";
    }

    //dataLayerProductClick($dataLayerList, $VPNName, $VPNID, $dataLayerBrand, $dataLayerVariant, $dataLayerPosition )
    $ctaPCDL = dataLayerProductClick(get_the_title(), $ctaVPNName, $ctaVPNID,  $ctaVPNName, "Standalone CTA - Read Review", 1 );

    // dataLayerAddToCart($dataLayerOfferId, $dataLayerAffId, $dataLayerList,  $VPNName, $VPNID, $dataLayerBrand, $VPNCat, $dataLayerVariant )
    $ctaOBATCDL = dataLayerAddToCart($ctaVPNID, $ctaVPNIDAff, get_the_title(),  $ctaVPNName, $ctaVPNID, $ctaVPNName, $ctaCategory, 'Standalone CTA - Visit' );
    //dataLayerOutboundLink($VPNName, $VPNCat, $VPNSubCat,  $dataLayerOfferId, $dataLayerAffId, $dataLayerLinkType )
    $ctaOBATCDL .= dataLayerOutboundLink($ctaVPNName, $ctaCategory,  get_the_title(),  $ctaVPNID, $ctaVPNIDAff, 'Standalone CTA - Visit' );

    $multiple = get_field('multiple_tracking_links', $select_vpn);
    if ($multiple){
        foreach (get_field('tracking_links', $select_vpn) as $key => $links) {
            if($links['link_type'] == $select_target_link){
                $Review_Link = $links['link'];
                $Review_Target = ' target="_blank" ';
            }
        }
    }
    else {
        $vpn_link = get_field('vpn_link', $select_vpn);
        $Review_Link = $vpn_link['url'];
        $Review_Target = ' target="_blank" ';
    }

    $General_Button = '<a id="'.$vpn_id_name_standalone.'" href="' . $Review_Link . '"' . $Review_Target . ' class="btn btn-primary btn-icon btn-lg" onclick="'.$ctaOBATCDL.'">Visit ' . get_field('vpn_name',$select_vpn ) . ' </a>';
    if ( $link_type == 'tracking_link' ){
        $Review_Button = '<a href="' . $VPN_Link . '" ' . ' class="btn btn-link btn-lg" onclick="'.$ctaPCDL.'">Read our ' . get_field('vpn_name',$select_vpn) . ' Review</a>';
    }else{
        $Review_Button = '';
    }
    echo '<div class="cta_cnt">' . $General_Button . $Review_Button . '</div>';
} 
else { //END VPN CTA BEGIN OTHER CTA
    $other_type = get_field('other_type');

    if($other_type == 'affiliate') {
        $addon_name = get_field('addon_name');
        $aff_link = $other_link['url'];

        $aff_url = parse_str(parse_url($aff_link, PHP_URL_QUERY), $aff_query);

        //echo '<pre>' . print_r($aff_query) . '</pre>';

        $datalayer = dataLayerOutboundLink($addon_name, '', '', $aff_query['offer_id'], $aff_query['aff_id'], 'standalone_cta_button' );
        $datalayer .= dataLayerAddToCart( $aff_query['offer_id'], $aff_query['aff_id'], get_the_title(),  $addon_name, '', get_the_title(), 'AddOn', 'standalone_cta_button' );
    }
    elseif($other_type == 'external') {
        $datalayer = dataLayerOutboundLink($other_link['title'], '', '',  '', '', 'standalone_cta_button' );
    }

    if($other_link) { ?>
    <div class="cta_cnt">
        <a href="<?php echo $other_link['url'] ?>" class="vpn-btn standalone-cta-button cta-btn" target="_blank" onclick="<?php echo $datalayer ?>"><?php echo $other_link['title'] ?></a>
    </div>
<?php }
}

/*
if( $button_type == 'cta'){
    if($link_type == 'vpn_link'){
        $link = get_the_permalink($select_vpn);
        $target = '';
    }else{
        if(get_field('multiple_tracking_links',$select_vpn)){
            foreach (get_field('tracking_links',$select_vpn) as $key => $links) {
                if($links['link_type'] == $select_target_link){
                    $link = $links['link'];
                    $target = 'target="_blank"';
                }
            }
        }
    }
    echo '<a href="'.$link.'" '.$target.' class="vpn-btn standalone-cta-button"><i class="fa fa-arrow-circle-right"></i>Visit '.get_field('vpn_name',$select_vpn).'</a>';
}else{
    echo '<a href="'.get_the_permalink($select_vpn).'" class="standalone-cta-button v2">Read our '.get_field('vpn_name',$select_vpn).' Review <i class="fa fa-long-arrow-right"></i></a>';
}
*/
?>