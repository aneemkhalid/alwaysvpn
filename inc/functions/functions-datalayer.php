<?php


//datalayer info functions

function dataLayerCoupon($couponTitle, $serviceProvider, $VPNCat, $VPNSubCat, $couponType, $couponURL ) {


        //get coupon url and break it up.
        $offerIDVPN = getTrackingLinkInfoCoupon($couponURL, 'offer_id');

        $affIDVPN= getTrackingLinkInfoCoupon($couponURL, 'aff_id');

        $couponTitle = str_replace("'", "", $couponTitle);

          return "dataLayer.push({
                    'event': 'coupon',
                    'coupon': '" .  $couponTitle . "',
                    'serviceProviderName' : '" .  $serviceProvider . "',
                    'VPNCategory': '" .  $VPNCat . "',
                    'VPNSubCategory' : '" .  $VPNSubCat . "',
                    'couponType' : '" .  $couponType . "',
                    'offer_id': '" .  $offerIDVPN . "',
                    'aff_id': '" .  $affIDVPN . "'
                });";

}

function dataLayerProductImpressionWrapper($dataLayerInner ) {

    return "dataLayer.push({
                'event': 'productImpressions',
                'ecommerce': {
                'currencyCode': 'USD',
                'impressions': [
                   " . $dataLayerInner . "
                ]
                }
            });";

}
function dataLayerProductImpression($VPNName, $VPNID, $dataLayerBrand, $dataLayerCategory, $dataLayerVariant, $dataLayerList, $dataLayerPosition ) {


        $VPNID =  getTrackingLinkInfo($VPNID, 'offer_id');
        $dataLayerList = str_replace("'", "", $dataLayerList);
        $dataLayerVariant = str_replace("'", "", $dataLayerVariant);

        return "{
         'name': '".$VPNName."',
         'id': '".$VPNID."',
         'price': '00.01',
         'brand': '".$dataLayerBrand."',
         'category': '".$dataLayerCategory."',
         'variant': '".$dataLayerVariant."',
         'list': '".$dataLayerList."',
         'position': ".$dataLayerPosition."
       },";

}


function dataLayerProductClick($dataLayerList, $VPNName, $VPNID, $dataLayerBrand, $dataLayerVariant, $dataLayerPosition ) {

    $dataLayerList = str_replace("'", "", $dataLayerList);
    $dataLayerVariant = str_replace("'", "", $dataLayerVariant);

    return "dataLayer.push({
            'event': 'productClick',
            'ecommerce': {
                'click': {
                    'actionField': {'list':'".$dataLayerList."'},
                    'products': [{
                        'name': '" .  $VPNName . "',
                        'id': '" .  $VPNID . "',
                        'price': '00.01',
                        'brand': '" . $dataLayerBrand . "',
                        'variant': '" . $dataLayerVariant . "',
                        'position': '" . $dataLayerPosition . "',
                    }]
                }
            }
        });";
}


function dataLayerOutboundLink($VPNName, $VPNCat, $VPNSubCat,  $dataLayerOfferId, $dataLayerAffId, $dataLayerLinkType ) {

    $VPNCat = str_replace("'", "", $VPNCat);
    $VPNSubCat = str_replace("'", "", $VPNSubCat);

    return " dataLayer.push({
              'event': 'outboundLink',
              'serviceProviderName' : '" .  $VPNName . "',
              'VPNCategory': '" .  $VPNCat . "',
              'VPNSubCategory' : '" .  $VPNSubCat . "',
              'offer_id': '" .  $dataLayerOfferId . "',
              'aff_id': '" .  $dataLayerAffId . "',
              'linkType' : '" .  $dataLayerLinkType . "',
            });";
}


function dataLayerAddToCart($dataLayerOfferId, $dataLayerAffId, $dataLayerList,  $VPNName, $VPNID, $dataLayerBrand, $VPNCat, $dataLayerVariant ) {

        $dataLayerList = str_replace("'", "", $dataLayerList);
        $dataLayerVariant = str_replace("'", "", $dataLayerVariant);

            return "dataLayer.push({
                      'event': 'addToCart',
                      'offer_id': '" .  $dataLayerOfferId . "',
                      'aff_id': '" .  $dataLayerAffId . "',
                      'ecommerce': {
                       'currencyCode': 'USD',
                       'actionField': {'list':'".$dataLayerList."'},
                       'add': {
                         'products': [{
                            'name': '" .  $VPNName . "',
                            'id': '" .  $VPNID . "',
                            'price': '00.01',
                            'brand': '" . $dataLayerBrand  . "',
                            'category': '" . $VPNCat  . "',
                           'variant': '" .  $dataLayerVariant . "',
                           'quantity': 1
                           }]
                        }
                      }
                    });";

}

function dataLayerProductDetail($dataLayerList, $VPNName, $VPNID, $dataLayerBrand, $VPNCat, $dataLayerVariant ) {

                    return "dataLayer.push({
                              'event': 'productDetail',
                              'ecommerce': {
                                  'detail': {
                                      'actionField': {'list':'".$dataLayerList."'},
                                      'products': [{
                                          'name': '" .  $VPNName . "',
                                          'id': '" .  $VPNID . "',
                                          'price': '00.01',
                                          'brand': '" .  $dataLayerBrand . "',
                                          'category': '" .  $VPNCat . "',
                                          'variant': '" .  $dataLayerVariant . "'
                                      }]
                                  }
                              }
                          });";
};


//Get the link info from ACF field on the review page
function getTrackingLinkInfo($infoObjID, $partOfUrlToFind) {
        if ( get_field( 'multiple_tracking_links' , $infoObjID) ) {
                
                $linkRows = get_field( 'tracking_links' , $infoObjID);
                //var_dump($linkRows);
                if( $linkRows ) {
                     $firstLinkRows = $linkRows[0];
                     $linkURL = $firstLinkRows['link'];
                    
                     $linkParts = parse_url($linkURL);                
                     $linkOutput = [];                    
                 
                    if ( $linkParts['host'] === 'tracking.cswsaa.com') {
                        parse_str($linkParts['query'], $linkOutput);
                    }                 
                    
                    if (empty($linkOutput[$partOfUrlToFind])) {
                        return get_the_ID($infoObjID);
                    } else {
                        return $linkOutput[$partOfUrlToFind];
                    }
                    

                }
            
            
            } else {
              //add in the unquie page/post id if no tracking link
                return get_the_ID($infoObjID);
            }
}

//get the link info from just the link url itself
function getTrackingLinkInfoCoupon($cta_link, $partOfUrlToFind) {
  $linkParts = parse_url($cta_link);                
  $linkOutput = [];
  parse_str($linkParts['query'], $linkOutput);
  return $linkOutput[$partOfUrlToFind];    
}


//Check url for dataLayer to know what category for certain pages base on page url
function checkURLForCatDataLayer($catVPNinfo) {
    if (strpos($catVPNinfo, 'comparisons') !== false) {
        return 'Comparisons';
    } else if (strpos($catVPNinfo, 'reviews') !== false) {
        return 'Reviews';
    } else if (strpos($catVPNinfo, 'guides') !== false) {
        return 'Resources';
    } else if (strpos($catVPNinfo, 'insights') !== false) {
        return 'Insights';
    } else {
        return 'Need to set one up';
    }
    
}