const $ = jQuery;
import Flickity from 'flickity';

$(document).ready(() => {

    // Temporarily add reject button dynamically
    const rejectButton = $('<a href="#" id="cn-reject-cookie" class="cn-button bootstrap" aria-label="Accept">No, Thanks</a>').on('click', e => {
        $('#cookie-notice').hide();
    });
    $('#cn-notice-buttons').append(rejectButton);
    setTimeout(() => $('#cookie-notice').fadeOut('fast'), 15000);

    $('.main-navigation .mt-car-search form .search-input-container input[name="s"]').val('');
    $('.widget_search .search-input-container input[name="s"]').val('');
    
    $('.footer-top .search-field').attr('placeholder', 'Search VPNs');

    $('footer .social-links').addClass('social-links-list').removeClass('social-links');

    //Cookie Notice
    $('.cookie-bar-close').click(function(){
        $('#cookie-law-info-bar').slideUp();
        $('#cookie-law-info-again').slideDown();
    });

    // Pass gclid param to cta links
    handleGclidParam();

    if ($('#exit-popup').length){

        // Creating custom :external selector
        $.expr[':'].external = function(obj){
            return !obj.href.match(/^mailto\:/) && !obj.href.match(/tracking.cswsaa.com/)
                    && (obj.hostname != location.hostname);
        };

        // Manage clicks on external links
        $('a:external').click(function(e) {
            // do your stuff here, ie send the link href to some server-side script
            e.preventDefault();
            const continueToHref = $(this).attr('href');
            $('#exit-popup .continue-to-site').attr("href", continueToHref);
            $('#exit-popup').addClass('modal-centered');
            $('#exit-popup').modal('show');
        });
    }

    $('.view-more-collapse').on('click', function(e){
        $(this).prev().find('.collapse-item').toggle();
        $(this).toggleClass('view-more-open');
        if ($(this).hasClass('view-more-open')) {
            $(this).find('span').text('View Less');
           // $(this).prev().find('.collapse-item').css('display', 'block');
       } else {
            $(this).find('span').text('View More');
       }

    });


});


// decorates the URL with query params
function decorateUrl(urlToDecorate) {
    var queryParams = [
        'gclid', //add or remove query parameters you want to transfer
    ];
    urlToDecorate = (urlToDecorate.indexOf('?') === -1) ? urlToDecorate + '?' : urlToDecorate + '&';
    var collectedQueryParams = [];
    for (var queryIndex = 0; queryIndex < queryParams.length; queryIndex++) {
        if (getQueryParam(queryParams[queryIndex])) {
            collectedQueryParams.push(queryParams[queryIndex] + '=' + getQueryParam(queryParams[queryIndex]))
        }
        else if(sessionStorage.getItem('gclid')) {
            collectedQueryParams.push('gclid=' + sessionStorage.getItem('gclid'));
        }
    }
    return urlToDecorate + collectedQueryParams.join('&');
}
//retrieves the value of a query parameter
function getQueryParam(name) {
    if (name = (new RegExp('[?&]' + encodeURIComponent(name) + '=([^&]*)')).exec(window.location.search))
        return decodeURIComponent(name[1]);
}

//adds gclid to search forms
function addGclidToSearch(){
    var gclid = getQueryParam('gclid');
    if (gclid && $('.search-input-container .search-field').length){
        $('.search-input-container .search-field').after('<input type="hidden" name="gclid" value="'+gclid+'">');
    }
}
addGclidToSearch();
var numOfTries = 0;

const handleGAParam = (ifLoadedGA) => {
    
    numOfTries++;    
 
    if(window.ga && ga.loaded) {    

        const gaparam = ga.getAll()[0].get('clientId');
        clearInterval(ifLoadedGA);

            $('a[href*="clientid"]').each((i, el) => {

                const trackingUrl = decodeURI($(el).attr('href'));
                const trackingUrlParams = new URLSearchParams(trackingUrl);
                const affClickId = trackingUrlParams.get('aff_sub4');

                if(affClickId === '{$clientid}') {               
                    const updatedLink = trackingUrl.replace('{$clientid}', gaparam);        
                    $(el).attr('href', updatedLink);
                }
                 if(affClickId === '$clientid') {               
                    const updatedLink = trackingUrl.replace('$clientid', gaparam);        
                    $(el).attr('href', updatedLink);
                }
                
            });
    }
    //turn off if 15 seconds has passed
    if(numOfTries === 30 ) {  
        clearInterval(ifLoadedGA);
    }
}

/**
 * Retrieves gclid param from url and injects it into all
 * href values that contain the {$gclid} substring variable
 */
const handleGclidParam = () => {
    const urlParams = new URLSearchParams(window.location.search);
    let gclid = urlParams.get('gclid');

    if (gclid) {
        sessionStorage.setItem('gclid', gclid);
    }
    //console.log(gclid);
    if(!gclid && sessionStorage.getItem('gclid')) {
        gclid = sessionStorage.getItem('gclid');
    }

    if(gclid) {
        // select all a tags where the value of href
        // contains the substring "gclid"
        $('a[href*="gclid"]').each((i, el) => {
            // some of the urls have encoded special characters
            const trackingUrl = decodeURI($(el).attr('href'));
            const trackingUrlParams = new URLSearchParams(trackingUrl);
            const affClickId = trackingUrlParams.get('aff_click_id');

            if(affClickId === '{$gclid}') {
                const updatedLink = trackingUrl.replace('{$gclid}', gclid);
                $(el).attr('href', updatedLink);
            }
            if(affClickId === '$gclid') {
                const updatedLink = trackingUrl.replace('$gclid', gclid);
                $(el).attr('href', updatedLink);
            }
        });

        var domainsToDecorate = [
            'alwaysvpn.com', //add or remove domains (without https or trailing slash) 
            'localhost:8888',
            'wpengine.com',
            'alwaysvpn.test',
        ];
        // do not edit anything below this line
        var links = document.querySelectorAll('a'); 

        // check if links contain domain from the domainsToDecorate array and then decorates
        for (var linkIndex = 0; linkIndex < links.length; linkIndex++) {
            for (var domainIndex = 0; domainIndex < domainsToDecorate.length; domainIndex++) { 
                if (links[linkIndex].href.indexOf(domainsToDecorate[domainIndex]) > -1 && links[linkIndex].href.indexOf("#") === -1) {
                    links[linkIndex].href = decorateUrl(links[linkIndex].href);
                }
            }
        }
    }
 
    if('https://stagealwaysvpn.wpengine.com' === window.location.origin || 'https://www.alwaysvpn.com' === window.location.origin || 'https://devalwaysvpn.wpengine.com' === window.location.origin) {
        const ifLoadedGA =   setInterval(function(){ handleGAParam(ifLoadedGA) }, 500);
   }
    
}



    // browser window scroll (in pixels) after which the "back to top" link is shown
    var offset = 300,
    //browser window scroll (in pixels) after which the "back to top" link opacity is reduced
    offset_opacity = 1200,
    //duration of the top scrolling animation (in ms)
    scroll_top_duration = 700,
    //grab the "back to top" link
    $back_to_top = jQuery('.back-to-top');

    //hide or show the "back to top" link
    jQuery(window).scroll(function(){
        ( jQuery(this).scrollTop() > offset ) ? $back_to_top.addClass('modeltheme-is-visible') : $back_to_top.removeClass('modeltheme-is-visible modeltheme-fade-out');
        if( jQuery(this).scrollTop() > offset_opacity ) { 
            $back_to_top.addClass('modeltheme-fade-out');
        }
    });
    //smooth scroll to top
    $back_to_top.on('click', function(event){
        event.preventDefault();
        $('body,html').animate({
            scrollTop: 0 ,
            }, scroll_top_duration
        );
    });

/*Guides page code*/
function guidesShowAll() {
    jQuery('.filter-wrapper .active').removeClass('active');
    jQuery('.filter-wrapper .filter-all').addClass('active');
    jQuery('.filter-posts').hide();
    jQuery('.filter-posts-all-wrapper').show();
}

function showHideFilters(key) {
    $('.filter-posts').hide();
    $('.filter-wrapper .active').removeClass('active');
    $('.filter-posts-'+key+'-wrapper').show();
    $('.filter-wrapper .filter-'+key).addClass('active');  
}

function guidesPageRun() {
    var hashForGuidesPage = location.hash;

    var filters = $(".filter-wrapper").attr("data-filters");
    filters = JSON.parse(filters);
    $.each(filters, function(key, value) {
        if (hashForGuidesPage === "#"+key){
            showHideFilters(key);
        }

    });
} 
if ($('.resources-aggregate-page').length){
    guidesPageRun();
}

$("body:not([class*='page-paged-']) .filter-all").on("click", function(event){
     history.pushState("", document.title, window.location.pathname + window.location.search);
    event.preventDefault();  
    guidesShowAll();    
});
$("body:not([class*='page-paged-']) .filter-wrapper li:not(.filter-all)").on("click", function(){
    var key = $(this).attr('class');
    key = key.replace('filter-','');
    showHideFilters(key);
});

jQuery(".anchor-tile").on( "click", function(e) {
    e.preventDefault();
    var hash = jQuery(this).attr('href');
    var ScrollPos = jQuery(hash).offset().top - 50 ;
    jQuery('html,body').animate({ scrollTop: ScrollPos }, 'slow');
});

if($('.vpn-slider').length) {
    var vpnSlider =  new Flickity('.vpn-slider', {
        groupCells: 3,
        draggable: false,
        //contain: true,
        cellAlign: 'left',
        watchCSS: true,
        pageDots: false,
    })
}


$('.compare-container .compare-blue-btn').on('click', function() {
    var img = $(this).data('image');
    var id = $(this).data('id');
    //console.log(img)
    //console.log(id)

    if($(this).hasClass('is-set')) {
        $(this).removeClass('is-set');
        $("span", this).text("COMPARE");

        var item = $('.vpn-slider-container')
            .find('.vpn-item-container[data-id="' + id + '"]');

        var elem = $('<button class="vpn-item-container"><div></div></button>')

        if($('.vpn-slider').hasClass('flickity-enabled')) {
            vpnSlider.remove(item);
            vpnSlider.append(elem);
        }
        else {
            item.remove();
            $('.vpn-slider').append(elem);
        }

    }
    else {
        var count = $('.vpn-item-container.is-set').length;
        //console.log(count);
        if(count < 5) {
            $(this).addClass('is-set');
            $("span", this).text("REMOVE");

            $('.vpn-slider-container .vpn-item-container:not(.is-set):first')
                .addClass('is-set')
                .attr('data-id', id)
                .find('div').css('background-image', 'url(' + img + ')')
                //.css('background-image', 'url(' + img + ')')
                .data('id', id);
        }
    }

    checkCompareCount();
})

$('.compare-vpn .vpn-add-to-compare').on("click", function(){
    var img = $(this).data('image');
    var id = $(this).data('id');
    //console.log(img)
    //console.log(id)

    if($(this).hasClass('is-set')) {
        $(this).removeClass('is-set');
        $("h6", this).text("Add to Compare");

        var item = $('.vpn-slider-container')
            .find('.vpn-item-container[data-id="' + id + '"]');

        var elem = $('<button class="vpn-item-container"><div></div></button>')

        if($('.vpn-slider').hasClass('flickity-enabled')) {
            vpnSlider.remove(item);
            vpnSlider.append(elem);
        }
        else {
            item.remove();
            $('.vpn-slider').append(elem);
        }

    }
    else {
        var count = $('.vpn-item-container.is-set').length;
        //console.log(count);
        if(count < 5) {
            $(this).addClass('is-set');
            $("h6", this).text("Selected to Compare");

            $('.vpn-slider-container .vpn-item-container:not(.is-set):first')
                .addClass('is-set')
                .attr('data-id', id)
                .find('div').css('background-image', 'url(' + img + ')')
                //.css('background-image', 'url(' + img + ')')
                .data('id', id);
        }
    }
    var counter = $('.vpn-add-to-compare.is-set').length;
    if(counter >=1 ) {
        // alert('lol');
        $('.vpn-compare-footer-container').addClass('slide-toggle');
    } else {
        $('.vpn-compare-footer-container').removeClass('slide-toggle');
    }

    checkCompareCount();
});


$('.vpn-compare-footer').on('click', '.vpn-item-container', function() {

    if($(this).hasClass('is-set')) {
        var id = $(this).data('id');
        //console.log(id);
        //console.log('clicked')

        var elem = $('<button class="vpn-item-container"><div></div></button>')

        if($('.vpn-slider').hasClass('flickity-enabled')) {
            vpnSlider.remove($(this));

            
            vpnSlider.append(elem);
        }
        else {
            $(this).remove();
            $('.vpn-slider').append(elem);
        }
        
        $('.comp-item-container').find('.compare-blue-btn[data-id="' + id + '"]')
            .removeClass('is-set')
            .find('span').text('COMPARE');

        $('.top-five-vpn').find('.vpn-add-to-compare[data-id="' + id + '"]')
            .removeClass('is-set')
            .find('h6').text('Add to Compare');

        $('.vpn-list').find('.vpn-add-to-compare[data-id="' + id + '"]')
            .removeClass('is-set')
            .find('h6').text('Add to Compare');
    }
    var counter = $('.vpn-add-to-compare.is-set').length;
    if(counter <1) {
        $('.best-vpn-comparison').removeClass('slide-toggle');
    }

    checkCompareCount();
})

function checkCompareCount() {
    var count = $('.vpn-item-container.is-set').length;

    //console.log(count)
    if(count == 0) {
        $('.vpn-compare-footer-container').removeClass('slide-toggle');
    }

    if(count < 2) {
        $('.compare-red-btn').prop('disabled', true);
    }
    else {
        $('.compare-red-btn').prop('disabled', false);
    }

    if(count <= 3) {
        vpnSlider.select( 0 );
    }

    if(count < 4) {
        $('.flickity-prev-next-button.next').addClass('is-less')
    }
    else {
        $('.flickity-prev-next-button.next').removeClass('is-less')
    }
}

$( document ).ready(function() {

    if($('.vpn-slider').length) {
        checkCompareCount();
    }

    //check if we are on safari mobile, if so then add 44px padding to bottom of nav to avoid the dead zone
    const isIOSSafari = !!window.navigator.userAgent.match(/Version\/[\d\.]+.*Safari/);   

    //get the sticky element
    const stickyElm = document.querySelector('.results-bar-container')

    if(stickyElm) {
        const observer = new IntersectionObserver( 
        ([e]) => {
            if(e.intersectionRatio < 1) {
                e.target.classList.add('is-sticky');
            }
            else {
                e.target.classList.remove('is-sticky');
            }
            //e.target.classList.toggle('is-sticky', e.intersectionRatio < 1)
        }, 
        {threshold: [1], delay: 150, rootMargin: '0px'}
    
        );
    
        observer.observe(stickyElm)
    }

    //make fixed nav appear at bottom if vpn results section is at or above top of page
    if ($('.vpn-table-container').length){
        var distance = $('.vpn-table-container').offset().top;

        $(window).scroll(function() {
            //check that we are on mobile to show/hide the fixed menu
            if ($(window).width() < 768){
                if (isIOSSafari){  
                    $('.results-bar-container').css('padding-bottom', '44px'); 
                }
                if ( $(this).scrollTop() >= distance ) {
                    $('.results-bar-container').fadeIn(200);
                } else {
                    $('.results-bar-container').fadeOut(200);
                }
            } else {
                $('.results-bar-container').css('padding-bottom', '0px'); 

            }
        });
    }

    //Calculate window width w/ scrollbar

    resizeFunction();

    //Handle clicking on table row Comparison Page 2.0
    $('.vpn-table-list .tr-click').on('click', function() {
        var href = $(this).data('href');
        window.location = href;
    })
    
    $('.view-details.collapse').on('show.bs.collapse', function() {
        var view = $(this).parent('.vpn-item').find('.view-details-btn');
        view.find('.text').text('Hide Details');
        view.find('.icon').css('transform', 'rotate(180deg)')
    });
    $('.view-details.collapse').on('hide.bs.collapse', function() {
        var view = $(this).parent('.vpn-item').find('.view-details-btn');
        view.find('.text').text('View Details');
        view.find('.icon').css('transform', 'rotate(0deg)')
    });

})

function setVw() {
    let vw = document.documentElement.clientWidth / 100;
    //console.log(vw)
    document.documentElement.style.setProperty('--vw', `${vw}px`);
}
function setMaxHeight() {
    var maxHeight = 0;
    let vw = document.documentElement.clientWidth;

    if(vw > 768) {
        $('#vpn-list .vpn-item').each(function() {
            $(this).find('.desktop .top-info').each(function() {
                var height = $(this).height();
                if (height > maxHeight) {
                    maxHeight = height;
                }
            }).each(function() {
                $(this).height(maxHeight);
            })
        })
    }
}

function toggleDropdown (e) {
    const _d = $(e.target).closest('.dropdown'),
      _m = $('.dropdown-menu', _d);
    setTimeout(function(){
      const shouldOpen = e.type !== 'click' && _d.is(':hover');
      _m.toggleClass('show', shouldOpen);
      _d.toggleClass('show', shouldOpen);
      $('[data-toggle="dropdown"]', _d).attr('aria-expanded', shouldOpen);
    }, e.type === 'mouseleave' ? 150 : 0);
}

$('.rating-container')
    .on('mouseenter mouseleave','.dropdown',toggleDropdown)
    .on('click', '.dropdown-menu a', toggleDropdown);

var resizeTimer; // Set resizeTimer to empty so it resets on page load

function resizeFunction() {
    setVw();
    setMaxHeight();
    // Stuff that should happen on resize
};

// On resize, run the function and reset the timeout
// 250 is the delay in milliseconds. Change as you see fit.
$(window).resize(function() {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(resizeFunction, 100);
});

$('.vpn-compare-footer .compare-red-btn').on('click', function() {
    var curr = window.location.href;
    var params = window.location.search.substring(1);

    var urlParts = curr.split('?');
    var urlParams = new URLSearchParams(urlParts[1]);

    var url = '/tools/comparison-tool';
    
    urlParams.toString();
    
    var providers = [];

    $('.vpn-item-container.is-set').each(function() {
        var id = $(this).data('id')
        providers.push(id); 
    })

    providers.join(', ');

    //console.log(providers);


    if(params) {
        if(!urlParams.has("vpn") && urlParams.has("gclid")) {
            
            var gclidPartHold = urlParams.get('gclid');
            urlParams.delete('gclid');
            //url = urlParts[0];
            
            url += '?vpn=' + providers + '&gclid=' + gclidPartHold;
            
        } else if (!urlParams.has("vpn")) {
             url += '&vpn=' + providers;        
        }

    }
    else {
        url += '?vpn=' + providers;
    }

    //url += '?vpn=' + providers;   
    window.location.assign(url);

    //console.log(prov);
    //console.log(url);
})

$('.compare-result-container .compare-return-btn').on('click', function(e) {
    var url = window.location.href;
    var params = window.location.search.substring(1);

    var urlParts = url.split('?');
    var urlParams = new URLSearchParams(urlParts[1]);

    if(params) {
        e.preventDefault();
        if(urlParams.has('vpn')) {
            urlParams.delete("vpn")
        }

        if(urlParams.values().next().done) {
            url = urlParts[0];
        }
        else {
            url = urlParts[0] +  '?' + urlParams.toString();
        }

        //url = urlParts[0] +  '?' + urlParams.toString();
        window.location.replace(url);
    }
})

$('.table-scroll-container').each(function() {
    $('.table-scroll', this).scroll(function() {
        //console.log('scrolling')
        //console.log($(this).scrollLeft());
        //console.log($('.carousel-cell', this).width() - $(this).width())
        //console.log($(this).width())
        if ( $(this).scrollLeft() == ($('.carousel-cell', this).width() - $(this).width()) + 17) {
            $(this).prev('.gradient-right').hide();
        }
        else {
            $(this).prev('.gradient-right').show();
        }
    })
})



$( ".vpns-list-wrap .select-vpn:first-child" ).addClass('vpn-selected');
$( ".vpns-list-wrap .select-vpn:nth-of-type(2)" ).addClass('vpn-selected');
$( ".vpns-list-wrap .select-vpn:nth-of-type(3)" ).addClass('vpn-selected');

$( ".compact-comparison .vpns-list-wrap .select-vpn:nth-of-type(3)" ).removeClass('vpn-selected');

$( ".vpns-list-wrap .select-vpn" ).each(function( index ) {
    $(this).on("click", function(){
        if($(this).hasClass('vpn-selected')){
            $(this).removeClass('vpn-selected');
        }
        else{
            $(this).addClass('vpn-selected');
        }

        var count_vpn = $('.select-vpn.vpn-selected').length;
        
        if(count_vpn < 2) {
            $('.vpn-comparison-tool-main .select-vpns-compare .vpn-btn').prop('disabled', true);
        }
        else {
            $('.vpn-comparison-tool-main .select-vpns-compare .vpn-btn').prop('disabled', false);
            $('.vpns-list-wrap .select-vpn:not(.vpn-selected)').addClass('vpn-disabled');
        }

        if(count_vpn == 5) {
            $('.vpns-list-wrap .select-vpn:not(.vpn-selected)').addClass('vpn-disabled');
        }
        else{
            $('.vpns-list-wrap .select-vpn:not(.vpn-selected)').removeClass('vpn-disabled');
        }
    });
    
});

$('.vpns-list-wrap .select-vpn.btn_sh_vpn').hide();

$('.show-hide-vpns .show-vpns').on("click", function(){
    $(this).hide();
    $('.show-hide-vpns .hide-vpns').show();
    $('.vpns-list-wrap .select-vpn.btn_sh_vpn').slideDown(200);
});
$('.show-hide-vpns .hide-vpns').on("click", function(){
    $(this).hide();
    $('.show-hide-vpns .show-vpns').show();
    $('.vpns-list-wrap .select-vpn.btn_sh_vpn').slideUp(200);
});


$('.select-vpns-compare .vpn-btn').on('click', function() {

    var url = window.location.href;
    var params = window.location.search.substring(1);

    var urlParts = url.split('?');
    var urlParams = new URLSearchParams(urlParts[1]);


    var providers = [];
    var url = 'tools/comparison-tool'

    $('.vpns-list-wrap .select-vpn.vpn-selected').each(function() {
        var id = $(this).data('id')
        providers.push(id); 
    })

    providers.join(',');

    if(params) {
        if(!urlParams.has("vpn") && urlParams.has("gclid")) {          
           
            
            var gclidPartHold = urlParams.get('gclid');          
            
            urlParams.delete('gclid');
           
            url += '?vpn=' + providers + '&gclid=' + gclidPartHold;
              
            
        } else if (!urlParams.has("vpn")) {
             url += '&vpn=' + providers;        
        }
        
    }
    else {
        url += '?vpn=' + providers;
    }
 
    window.location.replace(url);

})

//TOC Scroll
    var addClassOnScroll = function () {
        var windowTop = jQuery(window).scrollTop();
        jQuery('.content h2 span[id]').each(function (index, elem) {
            var offsetTop = jQuery(elem).offset().top;
            var outerHeight = jQuery(this).outerHeight(true);
            var widnowsHeight = jQuery(window).height();

            if( windowTop >= offsetTop - 100) {
                var elemId = jQuery(elem).attr('id');
                jQuery(".ez-toc-list li.active").removeClass('active');
                jQuery(".ez-toc-list li a[href='#" + elemId + "']").parent().addClass('active');
            }
        });
    };

//Review page TOC 
if (jQuery('body').hasClass('single-reviews')) {
    
    jQuery(window).on("scroll", () => {
        jQuery(".main_wrap .content h2:first-of-type").each(function() {
            var offset = jQuery(this).offset().top - jQuery(window).scrollTop();
            var footTop = jQuery('footer').offset().top - jQuery(window).scrollTop();
            if (offset <= 0) {
                jQuery('.mobile_floating_cta').addClass('activated');
                var footerTop = jQuery('footer').position().top; // or .offset().top
                var scrollTop = jQuery(window).scrollTop();
                var viewportHeight = jQuery(window).height();
                if (footerTop <= scrollTop + viewportHeight) {
                    jQuery('.mobile_floating_cta').removeClass('activated');
                } else {
                    jQuery('.mobile_floating_cta').addClass('activated');
                }
            } else {
                jQuery('.mobile_floating_cta').removeClass('activated');
            }
        })
    }).trigger("scroll");


    jQuery(function () {
        jQuery(window).on('scroll', function () {
            addClassOnScroll();
        });
        jQuery('body').on('click','.ez-toc-list > li',function(){
            addClassOnScroll();
        });
    });
 
}

if (jQuery('body').hasClass('post-template-single-resource-php')) {

    jQuery(function () {
        jQuery(window).on('scroll', function () {
            addClassOnScroll();
        });
        jQuery('body').on('click','.toc_wrapper .ez-toc-list > li',function(){
            addClassOnScroll();
        });
    });

}


//TOC Single Resource

if (jQuery('body').hasClass('single-resource')) {
    
      var addClassOnScrollResource = function () {
      var windowTop = jQuery(window).scrollTop();
      jQuery('.content h2 span[id]').each(function (index, elem) {
          var offsetTop = jQuery(elem).offset().top;
          var outerHeight = jQuery(this).outerHeight(true);
          var widnowsHeight = jQuery(window).height();

          if (windowTop >= offsetTop - 100) {
              var elemId = jQuery(elem).attr('id');
              jQuery(".toc_wrapper .ez-toc-list li.active").removeClass('active');
              jQuery(".toc_wrapper .ez-toc-list li a[href='#" + elemId + "']").parent()
                  .addClass('active');
          }
      });
  };

  jQuery(function () {
      jQuery(window).on('scroll', function () {
          addClassOnScrollResource();
      });
      jQuery('body').on('click', '.toc_wrapper .ez-toc-list > li', function () {
          addClassOnScrollResource();
      });
  });
    
}

//FAQ List Blocks Schema Custom Code

if ($(".faq-list-content")[0]){ 
    
const createFAQMainEntities = data => {
    const mainEntities = [];
    data.forEach(d => {
        mainEntities.push({
            '@type': 'Question',
            'name': d.question,
            'acceptedAnswer': {
                '@type': 'Answer',
                'text': d.answer
            }
        })
    })

    return mainEntities;
}
    
const mainEntities = createFAQMainEntities( FAQListBlockInfo );
const $ldJson = $('<script>').attr('type', 'application/ld+json').text(JSON.stringify(
    {
        '@context': 'https://schema.org',
        '@type': 'FAQPage',
        'mainEntity': mainEntities
    }
));

$('head').append($ldJson);
    
}

if ($(".legal-modal")[0]){ 
    jQuery('#'+legalPopUpIdModal).on('show.bs.modal', function (e) {
      jQuery(this).addClass('modal-centered');
    })
}

if($('.review-carousel').length) {
    var reviewSlider = new Flickity('.review-carousel', {
        draggable: false,
        contain: true,
        //cellAlign: 'left',
        watchCSS: true,
        pageDots: true,
        prevNextButtons: false,
    })


}


// TOAST SHOW / HIDE
jQuery(document).ready(function($) {

    // make unique key with postID-toast
    // check session storage for key
    let current_pid = $('#avpn-toast').data('pid') + '-toast'
    let toast_status = sessionStorage.getItem(current_pid)

    // show toast if it has not been set to hide
    setTimeout(function(){
        if( toast_status != 'hide' ){
            $('.toast').addClass('active')
        }
    }, 2000);

    // close toast function & add page id to session variable
    $('#close-toast').on('click', function(){

        $('.toast').removeClass('active')
        sessionStorage.setItem(current_pid, 'hide');

    })

    $( ".related_posts_main_wrap" ).each(function( index ) {
        var countRelatedPosts = $(this).children().children().children('.related_posts').length;
        if (countRelatedPosts>1){
            $(this).children('.related_posts_wrap').addClass("expand-related-posts");
            $(this).children('.related_posts_wrap').children('.show-less').children('a').click(function () {
                if($(this).parent().parent(".related_posts_wrap").hasClass("expand-related-posts")) {
                    $(this).text("SHOW LESS");
                } else {
                    $(this).text("SHOW MORE");
                }
                $(this).parent().parent(".related_posts_wrap").toggleClass("expand-related-posts");
            });
        }
        else{
            $(this).children('.related_posts_wrap').removeClass("expand-related-posts");
            $(this).children('.related_posts_wrap').children('.show-less').hide();
            $(this).children().children().children('.related_posts').css('margin-bottom','0 !important');
        }
    });
    
    //Get in Touch
    $(".get-in-touch .frm_form_field input[type='email']").keyup(function(){
        console.log($(this).val());
        if($(this).val().length == 0){
            $(this).parent().removeClass("remove-require");
            $(this).parent().addClass("second-require-remove");
        }
        else{
            $(this).parent().addClass("remove-require");
            $(this).parent().removeClass("second-require-remove");
            if($(this).siblings('.frm_error').text() == 'This field cannot be blank.'){
                $('.frm_error').hide();
            }
        }
    });
})
