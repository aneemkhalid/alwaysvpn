<?php

/**
 * Coupon Promotion Popup.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$is_featured_coupon_option = get_option('is_featured_coupon');
$current_popup;

if($is_featured_coupon_option) $current_popup = get_post($is_featured_coupon_option);

if(is_object($current_popup)):
    $fields = get_fields($current_popup->ID)['coupon_promotion'];
    extract($fields);

    // NEW EXPIRY DATE
    /*
    $Exp_Day = $_COOKIE['exp_day'];
    $Exp_Hour = $_COOKIE['exp_hour'];
    $Exp_Mins = $_COOKIE['exp_mins'];
    $Exp_Secs = $_COOKIE['exp_secs'];

    $nowUnixTime = current_time( 'timestamp' ); //new DateTime();
    $now1 = date("Y-m-d H:i:s", $nowUnixTime );
    $ServerDate = new DateTime( $now1 );
    $now = new DateTime( $now1 );
    date_add( $now, date_interval_create_from_date_string("50 minutes") );

    //echo "<pre> SERVER TIME : "; print_r($ServerDate); echo "</pre>";
    //echo "<pre> CURRENT TIME +5 : "; print_r($now); echo "</pre>";
    $expiration_date = date_format($now,"Y-m-d H:i:s");

    $is_expired = $ServerDate > $expiration_date;
    $show_coupon_popup = true;

    // $cookie_name = "exp_time";
    // $cookie_value = $expiration_date;
    // setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
    // if(!isset($_COOKIE['exp_time'])) {
    //     echo "Cookie named `exp_time` is not set!";
    // } else {
    //     echo "Cookie `exp_time` is set!<br>";
    //     echo "Value is: " . $_COOKIE['exp_time'];
    // }
    */
    // NEW EXPIRY DATE

    $is_expired = is_utc_date_expired($expiration_date, '-4 hours');
    $show_coupon_popup = false;
    
    $vpn_name_id_coupon_pop =  prepare_click_id_vpn_name( $fields['vpn_provider'] );

    $vpn_name_id_coupon_pop =  prepare_click_id_vpn_name( $fields['vpn_provider'] );

    if( !$is_expired ) {
        if( isset( $args['post_id'] ) && strval($args['post_id']) === strval($vpn_provider) ) $show_coupon_popup = true;
        if( isset( $args['post_ids'] ) && is_array( $args['post_ids'] ) && in_array( $vpn_provider, $args['post_ids'] ) ) $show_coupon_popup = true;
        if( isset( $args['show_coupon_popup'] ) && $args['show_coupon_popup'] ) $show_coupon_popup = true;
    }

$offerIDVPNCoupPop = getTrackingLinkInfoCoupon($cta_link, 'offer_id');
        
$affIDVPNCoupPop = getTrackingLinkInfoCoupon($cta_link, 'aff_id');

$pageTitle = get_the_title();

$couponName = get_post_field( 'post_name', $vpn_provider );


if (get_field('category_of_page')) {
$catVPNPop = get_field('category_of_page');
} else {
    $catVPNPop =  get_permalink();   
    $catVPNPop = checkURLForCatDataLayer($catVPNPop);
}

$coupPopOnClick = "dataLayer.push({
                    'event': 'coupon',
                    'coupon': '" .  $title . "',
                    'serviceProviderName' : '" .  $couponName . "',
                    'VPNCategory': '" .  $catVPNPop . "',
                    'VPNSubCategory' : '" .  $pageTitle . "',
                    'couponType' : 'Popup', 
                    'offer_id': '" .  $offerIDVPNCoupPop . "',
                    'aff_id': '" .  $affIDVPNCoupPop . "'
                });";


    if( $show_coupon_popup ):
        // Convert to UNIX and then encode to JSON
        // in order to pass to JavaScript
        $json_date = json_encode(strtotime($expiration_date));
?>
<div class="modal fade coupon-modal" id="couponPopup" tabindex="-1" role="dialog" aria-labelledby="couponModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content slide-from-bottom">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="coupon-content-container desktop">
                    <div class="left-coupon-content-container">
                        <div class="coupon-icon-container">
                            <img src="<?php echo $icon; ?>" alt="" class="coupon-icon">
                        </div>
                        <div class="coupon-detail-container">
                            <div class="coupon-detail">
                                <?php echo $discount_detail; ?>
                            </div>
                        </div>
                        <div class="coupon-legal-container">
                            <div class="coupon-legal">
                                <?php echo $legal_copy; ?>
                            </div>
                        </div>
                    </div>
                    <div class="right-coupon-content-container">
                        <div class="coupon-title-container">
                            <h3 class="coupon-title">
                                <?php echo $title; ?>
                            </h3>
                        </div>
                        <div class="coupon-description-container">
                            <p class="coupon-description">
                                <?php echo $description; ?>
                            </p>
                        </div>
                        <div class="coupon-button-container">

                            <a id="coupon_popup_<?php echo $vpn_name_id_coupon_pop; ?>" href="<?php echo $cta_link; ?>" class="coupon-button cta-btn" onClick="<?php echo $coupPopOnClick; ?>">
                                Get Deal
                            </a>
                        </div>
                        <div class="coupon-expiration-container">
                            <p class="coupon-expiration-intro">This offer will expire in:</p>
                            <div class="coupon-expiration-details-container">
                                <div class="coupon-expiration">
                                    <div class="countdown-container" data-unit="days"></div>
                                    <p class="countdown-text expiration-days">Days</p>
                                </div>
                                <div class="colon-container">:</div>
                                <div class="coupon-expiration">
                                    <div class="countdown-container" data-unit="hours"></div>
                                    <p class="countdown-text expiration-hours">Hrs</p>
                                </div>
                                <div class="colon-container">:</div>
                                <div class="coupon-expiration">
                                    <div class="countdown-container" data-unit="minutes"></div>
                                    <p class="countdown-text expiration-minutes">Mins</p>
                                </div>
                                <div class="colon-container">:</div>
                                <div class="coupon-expiration">
                                    <div class="countdown-container" data-unit="seconds"></div>
                                    <p class="countdown-text expiration-seconds">Secs</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="coupon-content-container mobile">
                    <div class="coupon-icon-container">
                        <img src="<?php echo $icon; ?>" alt="" class="coupon-icon">
                    </div>
                    <div class="coupon-title-container">
                        <h3 class="coupon-title">
                            <?php echo $title; ?>
                        </h3>
                    </div>
                    <div class="coupon-description-container">
                        <p class="coupon-description">
                            <?php echo $description; ?>
                        </p>
                    </div>
                    <div class="coupon-button-container">
                        <a href="<?php echo $cta_link; ?>" class="coupon-button cta-btn" onClick="<?php echo $coupPopOnClick; ?>">
                            Get Deal
                        </a>
                    </div>
                    <div class="coupon-detail-container">
                        <div class="coupon-detail">
                            <?php echo $discount_detail; ?>
                        </div>
                    </div>
                    <div class="coupon-legal-container">
                        <div class="coupon-legal">
                            <?php echo $legal_copy; ?>
                        </div>
                    </div>
                    <div class="coupon-expiration-container">
                        <p class="coupon-expiration-intro">This offer will expire in:</p>
                        <div class="coupon-expiration-details-container">
                            <div class="coupon-expiration">
                                <div class="countdown-container" data-unit="days"></div>
                                <p class="countdown-text expiration-days">Days</p>
                            </div>
                            <div class="colon-container">:</div>
                            <div class="coupon-expiration">
                                <div class="countdown-container" data-unit="hours"></div>
                                <p class="countdown-text expiration-hours">Hrs</p>
                            </div>
                            <div class="colon-container">:</div>
                            <div class="coupon-expiration">
                                <div class="countdown-container" data-unit="minutes"></div>
                                <p class="countdown-text expiration-minutes">Mins</p>
                            </div>
                            <div class="colon-container">:</div>
                            <div class="coupon-expiration">
                                <div class="countdown-container" data-unit="seconds"></div>
                                <p class="countdown-text expiration-seconds">Secs</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const $couponPopup = jQuery('#couponPopup');
const expirationDate = <?php echo $json_date; ?>;

/**
* Handles the show/hide logic for the coupon popup
*
* @param {object} e - event object
* @param {boolean} hideCoupon - determines conditional logic
*
*/

/*
const toggleCouponPopup = (e, hideCoupon = false) => {
    if(!hideCoupon) {
        // Bootstrap config
        jQuery('body').addClass('modal-open');
        // Bootstrap config
        $couponPopup.addClass('in').css({
            "display": "block",
            "padding-right": "0px",
        }).attr('aria-hidden', "false");

        // If no backdrop element exists, create one
        const $backdrop = jQuery('.coupon-modal .modal-backdrop');

        if(!$backdrop.length){
            const $newBackdrop = jQuery('<div class="modal-backdrop fade in">').css({ "height": "100vh", });
            $newBackdrop.on('click', toggleCouponPopup.bind(null, true));
            $couponPopup.prepend($newBackdrop);
        }

    } else {
        // If user closes modal, don't show it again during their session
        sessionStorage.setItem('disableCouponPopup', true);
        // Bootstrap config
        jQuery('body').removeClass('modal-open');
        // Bootstrap config
        $couponPopup.removeClass('in').css({
            "display": "none",
        }).attr('aria-hidden', "true");
        // Remove backdrop and unbind event
        jQuery('.coupon-modal .modal-backdrop').off('click').remove();
    }
}
*/

/*
const getTimeRemaining = endtime => {
    // Convert Unix timestamp to UTC
    const adjustedEndTime = new Date(endtime * 1000);
    //adjustedEndTime.setHours(adjustedEndTime.getHours() - 2);
    adjustedEndTime.setHours(adjustedEndTime.getHours());
    const total = Date.parse(adjustedEndTime) - Date.parse(new Date());
    const seconds = Math.floor( (total/1000) % 60 );
    const minutes = Math.floor( (total/1000/60) % 60 );
    const hours = Math.floor( (total/(1000*60*60)) % 24 );
    const days = Math.floor( total/(1000*60*60*24) );

    return {
        total,
        days,
        hours,
        minutes,
        seconds
    };
}
*/

jQuery(document).ready(() => {

    /*
    const countdownTimer = setInterval(() => {
        const countdownUnits = getTimeRemaining(expirationDate);

        if (countdownUnits.total < 1) {
            clearInterval(countdownTimer);
            jQuery('.coupon-expiration-intro').html('<span style="color: red;">Sorry, this offer has expired!</span>');
        }

        jQuery('.countdown-container').each((i, el) => {
            const unit = $(el).attr('data-unit');
            $(el).text(countdownUnits[unit]);
        })

        const daysText = countdownUnits.days === 1 ? 'Day' : 'Days';
        jQuery('.expiration-days').text(daysText);
        const hoursText = countdownUnits.hours === 1 ? 'Hr' : 'Hrs';
        jQuery('.expiration-hours').text(hoursText);
        const minutesText = countdownUnits.minutes === 1 ? 'Min' : 'Mins';
        jQuery('.expiration-minutes').text(minutesText);
        const secondsText = countdownUnits.seconds === 1 ? 'Sec' : 'Secs';
        jQuery('.expiration-seconds').text(secondsText);

    

    }, 1000);
    /* */
    jQuery(window).on('scroll', e => {
        // If user closes modal, don't show it again during their session
        const disableCouponPopup = sessionStorage.getItem('disableCouponPopup');
        // Calculate 25% point of document height in order to
        // determine when to trigger the coupon popup
        const couponPopupTriggerPoint = jQuery(document).height() / 4;
        const windowScrollTop = jQuery(window).scrollTop();
        
        if(windowScrollTop >= couponPopupTriggerPoint && !$couponPopup.hasClass('in') && !disableCouponPopup){
        //if(windowScrollTop >= couponPopupTriggerPoint && !$couponPopup.hasClass('in') ){
            //toggleCouponPopup();
            var exp_day = parseInt(getCookie("exp_day"));
            var exp_hour = parseInt(getCookie("exp_hour"));
            var exp_mins = parseInt(getCookie("exp_mins"));
            var exp_secs = parseInt(getCookie("exp_secs"));
            //console.log( exp_day + "\n" + exp_hour + "\n" + exp_mins + "\n" + exp_secs + "\n" );

            if ( (exp_day === 0) && (exp_hour === 0) && (exp_mins === 0) && (exp_secs === 0) ){
                // Do Nothing
            }else{
                $('#couponPopup').modal('show');
            }
        }
    }).trigger('scroll');
    
    // Register click event 'X' in modal to close coupon
    // jQuery('#couponPopup .close').on('click', toggleCouponPopup.bind(null, true));
});

jQuery('#couponPopup').on('hide.bs.modal', function (e) {
    //console.log ( 'BYE BYE!!!' );
    sessionStorage.setItem('disableCouponPopup', true);
    // SAVE COUNT DOWN ON HIDE
    setCookie("exp_day", jQuery(".countdown-container[data-unit=days]" ).html(), 1);
    setCookie("exp_hour", jQuery(".countdown-container[data-unit=hours]" ).html(), 1);
    setCookie("exp_mins", jQuery(".countdown-container[data-unit=minutes]" ).html(), 1);
    setCookie("exp_secs", jQuery(".countdown-container[data-unit=seconds]" ).html(), 1);
});

jQuery('#couponPopup').on('shown.bs.modal', function (e) {
    // START COUNTDOWN
    // Set the date we're counting down to
    //var countDownDate = new Date("Sep 1, 2021 13:44:00").getTime();
    var d1 = new Date (),
    d2 = new Date ( d1 );

    var exp_day = getCookie("exp_day");
    if ( exp_day == "" ){
        var DaysToHours = 0;
    }else{
        var DaysToHours = ( parseInt(exp_day) * 24);
    }

    var exp_hour = getCookie("exp_hour");
    if ( exp_hour == "" ){
        d2.setHours ( d1.getHours() + ( 0 + DaysToHours ) );
    }else{
        d2.setHours ( d1.getHours() + ( parseInt(exp_hour) + DaysToHours ) );
    }

    var exp_mins = getCookie("exp_mins");
    if ( exp_mins == "" ){
        d2.setMinutes ( d1.getMinutes() + 5 );
    }else{
        d2.setMinutes ( d1.getMinutes() + parseInt(exp_mins) );
    }

    var exp_secs = getCookie("exp_secs");
    if ( exp_secs == "" ){
        d2.setSeconds ( d1.getSeconds() + 0 );
    }else{
        d2.setSeconds ( d1.getSeconds() + parseInt(exp_secs) );
    }
    countDownDate = d2;

    // Update the count down every 1 second
    var x = setInterval(function() {
        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        jQuery(".countdown-container[data-unit=days]" ).text( AddZero(days) );
        jQuery(".countdown-container[data-unit=hours]" ).text( AddZero(hours) );
        jQuery(".countdown-container[data-unit=minutes]" ).text( AddZero(minutes) );
        jQuery(".countdown-container[data-unit=seconds]" ).text( AddZero(seconds) );

        // If the count down is over, write some text 
        if (distance < 0) {
            clearInterval(x);
            jQuery(".countdown-container[data-unit=days]" ).text( AddZero(0) );
            jQuery(".countdown-container[data-unit=hours]" ).text( AddZero(0) );
            jQuery(".countdown-container[data-unit=minutes]" ).text( AddZero(0) );
            jQuery(".countdown-container[data-unit=seconds]" ).text( AddZero(0) );
            jQuery(".coupon-expiration-intro").html('<span style="color: red;">Sorry, this offer has expired!</span>');

            // SAVE COUNT DOWN ON HIDE
            setCookie("exp_day", jQuery(".countdown-container[data-unit=days]" ).html(), 1);
            setCookie("exp_hour", jQuery(".countdown-container[data-unit=hours]" ).html(), 1);
            setCookie("exp_mins", jQuery(".countdown-container[data-unit=minutes]" ).html(), 1);
            setCookie("exp_secs", jQuery(".countdown-container[data-unit=seconds]" ).html(), 1);
            
            jQuery(".coupon-button-container a.coupon-button").attr("href", "#");
            jQuery(".coupon-button-container a.coupon-button").css("background-image", "linear-gradient(to bottom, #e4e4e4, #848484)");

            setTimeout(function(){                
                jQuery('#couponPopup').modal('hide');
            }, 1500);

        }
    }, 1000);
    // START COUNTDOWN
});


function AddZero(num){
    if ( num <= 9 ){
        num = "0" + num;
    }else{
        num = num;
    }
    return num;
}

function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    let name = cname + "=";
    let ca = document.cookie.split(';');
    for(let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
</script>

<?php
    endif;
endif;
?>