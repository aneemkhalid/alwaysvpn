<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 */

get_header();
echo create_breadcrumbs_html();
    while ( have_posts() ) : the_post(); 

        $author = get_field('author');
        $author_type = get_field('author_type');

        $select_vpns = get_field('select_vpns');

        // collect provider ids for coupon popup validation
        if($select_vpns) {
            $vpn_ids = array_column($select_vpns, 'vpn'); 
        }

        $best_of_to_use_menu_order = get_field('best_vpn_pages_selected', 'option');
        $current_best_of_id =  get_queried_object_id();

        //use menu order if best of page is selected in theme settings
         if (!empty($best_of_to_use_menu_order) && in_array($current_best_of_id, $best_of_to_use_menu_order) ) {
                foreach($select_vpns as $i => $item) {  
                    $select_vpns[$i]["Order"] = get_post_field( 'menu_order', $vpn_ids[$i]);    
                }

                usort($select_vpns, function ($item1, $item2) {
                    return $item1['Order'] <=> $item2['Order'];
                });
        }


        if($author){
            $authorName = get_the_title($author);
            $authorLink = get_permalink($author);
            $authorImageURL = get_the_post_thumbnail_url($author);
            $author_image = '';
            if($authorImageURL){
                $author_image = '<img src="'.get_the_post_thumbnail_url($author).'" width="50" height="50" alt="'.$authorName.'" />';
            }
        }else{
            $authorName = get_the_author();
            $author_image = '';
        }
        if($author_type == 'Editor') {
            $authorName = 'Edited by: ' . $authorName;
        }

        $slug = $post->post_name;
        $capitalized_slug = '';
        if(isset($slug) && !empty($slug)) {
            if($slug === 'iphone') {
                $slug[1] = strtoupper($slug[1]);
                $capitalized_slug = $slug;
            } else {
                $capitalized_slug = ucfirst($slug);
            }
        }
        $priceNumbBest = 00.01;
        $positionNumBest = 0;
        $VPNBestAllHolder = ""; 
        $listVPNBest = get_the_title();

        $catVPNBest = get_field('category_of_page');
        
        $video_url = get_field('video_embed_url');

        global $post;
        ?>

        <section class="main_wrap middle_main side_nav">
            <div class="container">
                <div class="middle">
                    
                    <div class="reviews_main">
                        <h1><?php the_title(); ?></h1>
                        <div class="author-wrapper">
                            <a href="<?php echo $authorLink; ?>" class="author-info">
                                <?php echo $author_image; ?>
                                <p>
                                    <?php echo $authorName; ?>
                                    <span>Last updated: <?php the_date(); ?></span>
                                </p>
                            </a>
                            <div class="social-share">
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink(); ?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri() . '/images/icons/fb-avpn.svg' ?>" alt="facebook icon" width="30" height="30" /></a>
                                <a href="https://twitter.com/intent/tweet?url=<?php echo get_permalink(); ?>&text=<?php the_title(); ?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri() . '/images/icons/twitter-avpn.svg' ?>" alt="twitter icon" width="30" height="30"></a>
                            </div>
                        </div>
                    </div>
                       <div class="content">

                       <?php if($video_url || has_post_thumbnail()) : ?>
                            <div class="comparison_image">
                                <?php if($video_url) : ?>
                                    <iframe src="<?php echo $video_url; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                <?php elseif(!wp_is_mobile() && has_post_thumbnail()) : ?>
                                    <?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'large' ); ?>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php // ANCHOR TILES
                        include(locate_template( 'template-parts/anchor-tiles.php' )); ?>

                        <?php the_content(); ?>
                        
                        <?php if($select_vpns): ?>
                            <?php if(get_field('table_heading')) echo '<h3 id="list">'.get_field('table_heading').'</h3>'; ?>
                            <div class="vpn-table-wrap">

                                <?php 
                                foreach (array_slice($select_vpns, 0, 5) as $key => $vpn) { 
                                    $vpn_id = $vpn['vpn'];
                                    $vpn_image = get_field('vpn_image',$vpn_id);
                                    $vpn_logo = get_field('vpn_logo', $vpn_id);
                                    
                                    $outbound_id = prepare_outbound_id( $vpn_id );

                                    // AVG Rating
                                    $privacy = get_field('privacy',$vpn_id);
                                    $trust = get_field('trust',$vpn_id);
                                    $ease_of_use = get_field('ease_of_use',$vpn_id);
                                    $price = get_field('price',$vpn_id);
                                    $speed = get_field('speed',$vpn_id);
                                    $avg_rating = array_sum(array($privacy, $trust, $ease_of_use, $price, $speed))/5;
                                    $avg_rating = number_format((float)$avg_rating, 1, '.', '');
                                    $vpn_name = get_field('vpn_name',$vpn_id);
                                    $vpn_name_id =  prepare_click_id_vpn_name( $vpn_id );
                                    

                                    $multiple_tracking_links = get_field('multiple_tracking_links',$vpn_id);
                                    if($multiple_tracking_links){
                                        $cta_link = '';
                                        $tracking_links = get_field('tracking_links',$vpn_id);
                                        foreach ($tracking_links as $links) {
                                            // echo $links['link'].' '.$links['link_type'];
                                            $post_slug = $post->post_name;
                                            if($post_slug == $links['link_type']){
                                                $cta_link = $links['link'];
                                                break;
                                            }elseif($links['link_type'] == 'general'){
                                                $cta_link = $links['link'];
                                            }
                                        }
                                    }else{
                                        if(get_field('vpn_link',$vpn_id))
                                            $cta_link = get_field('vpn_link',$vpn_id)['url'];
                                    }
                                        
                                    //if first use this top of the list text
                                     
                                    if ( $key === 0 && !empty($vpn['top_of_the_list_table_description']) ) {
                                         $table_description = $vpn['top_of_the_list_table_description'];
                                    } else {
                                         $table_description = $vpn['table_description'];
                                    }
                                       
                                        
                                        //dataLayer info
                                        $idNumVPNTableBest = getTrackingLinkInfo($vpn_id, 'offer_id');
                                
                                        $idNumAffTableVPNBest = getTrackingLinkInfo($vpn_id, 'aff_id'); 
                                        
                  
                                        
                                // dataLayerAddToCart($dataLayerOfferId, $dataLayerAffId, $dataLayerList,  $VPNName, $VPNID, $dataLayerBrand, $VPNCat, $dataLayerVariant )
                              $VPNBestIndvTableOnClick = dataLayerAddToCart($idNumVPNTableBest, $idNumAffTableVPNBest, get_field('table_heading'),  $vpn_name, $idNumVPNTableBest, $listVPNBest, $catVPNBest, 'commercial_table' );

                                //dataLayerOutboundLink($VPNName, $VPNCat, $VPNSubCat,  $dataLayerOfferId, $dataLayerAffId, $dataLayerLinkType )
                              $VPNBestIndvTableOnClick .= dataLayerOutboundLink($vpn_name, $catVPNBest, $slug,  $idNumVPNTableBest, $idNumAffTableVPNBest, 'commercial_table' );      

                                                                                
                                ?>


                                <div class="vpn-table-list">
                                    <div class="vpn-item">
                                        <div class="logo-container">
                                            <div class="number"><span><?php echo $key+1; ?></span></div>
                                            <a href="#<?php echo strtolower(str_replace (' ','-',$vpn_name)) ?>" class="vpn-logo">
                                                <?php if($vpn_logo) : 
                                                    echo wp_get_attachment_image($vpn_logo, 'full');
                                                endif; ?>
                                            </a>
                                        </div>
                                        <div class="descrip-container">
                                            <div class="description"><?php if(!empty($table_description)) echo $table_description ?></div>
                                            <a href="#<?php echo strtolower(str_replace (' ','-',$vpn_name)) ?>">
                                                Read More
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>

                            </div>
                            <div class="top-five-vpn">   
                                <?php 
                                foreach (array_slice($select_vpns, 0, 5) as $vpnNumber => $vpn) { 
                                    $vpn_id = $vpn['vpn'];
                                    $vpn_name = get_field('vpn_name',$vpn_id);
                                    $vpn_image = get_field('vpn_image',$vpn_id);
                                    $vpn_link = get_field('vpn_link',$vpn_id);
                                    $outbound_id = prepare_outbound_id( $vpn_id );

                                    // AVG Rating
                                    $privacy = get_field('privacy',$vpn_id);
                                    $trust = get_field('trust',$vpn_id);
                                    $ease_of_use = get_field('ease_of_use',$vpn_id);
                                    $price = get_field('price',$vpn_id);
                                    $speed = get_field('speed',$vpn_id);
                                    $avg_rating = array_sum(array($privacy, $trust, $ease_of_use, $price, $speed))/5;
                                    $avg_rating = number_format((float)$avg_rating, 1, '.', '');

                                    $short_description = get_field('short_description',$vpn_id);

                                    $availble_on = get_field('availble_on',$vpn_id);

                                    $lowest_price = get_field('lowest_price',$vpn_id);
                                    $avgdl_speed = get_field('avgdl_speed',$vpn_id);
                                    $logging = get_field('logging',$vpn_id);
                                    $countries = get_field('countries',$vpn_id);
                                    
                                    $pros = get_field('pros',$vpn_id);
                                    $cons = get_field('cons',$vpn_id);
                                    
                                
                                    //if first use this top of the list text

                                    if ( $vpnNumber === 0 && !empty($vpn['top_of_the_list_description']) ) {
                                        $description = $vpn['top_of_the_list_description'];
                                    } else {
                                        $description = $vpn['description'];
                                    }
                                        
                                    
                                    
                                    if( array_key_exists('coupon_promo_choice', $vpn)) {
                                        $inline_coupon_id = $vpn['coupon_promo_choice'];
                                    }
                                    $permalink = get_the_permalink($vpn_id);

                                    $multiple_tracking_links = get_field('multiple_tracking_links',$vpn_id);
                                    if($multiple_tracking_links){
                                        $cta_link = '';
                                        $tracking_links = get_field('tracking_links',$vpn_id);
                                        foreach ($tracking_links as $links) {
                                            // echo $links['link'].' '.$links['link_type'];
                                            $post_slug = $post->post_name;
                                            if($post_slug == $links['link_type']){
                                                $cta_link = $links['link'];
                                                break;
                                            }elseif($links['link_type'] == 'general'){
                                                $cta_link = $links['link'];
                                            }
                                        }
                                    }else{
                                        if(get_field('vpn_link',$vpn_id))
                                            $cta_link = get_field('vpn_link',$vpn_id)['url'];
                                    }
                            
                                    
                                    //dataLayer info
                                    $idNumVPNBest = getTrackingLinkInfo($vpn_id, 'offer_id');
                                    
                                    $idNumAffVPNBest = getTrackingLinkInfo($vpn_id, 'aff_id');
                                    
                                    $positionNumBest++;                             
                                    
                                    //dataLayerProductImpression($VPNName, $VPNID, $dataLayerBrand, $dataLayerCategory, $dataLayerVariant, $dataLayerList, $dataLayerPosition )
                                    
                                    $VPNBestIndv = dataLayerProductImpression($vpn_name, $vpn_id, $listVPNBest, $catVPNBest, "commercial_provider_overview", $listVPNBest, $positionNumBest );

                                    
                                    $VPNBestAllHolder .= $VPNBestIndv;
                                    
                                    
                    
                                    
                                    // dataLayerAddToCart($dataLayerOfferId, $dataLayerAffId, $dataLayerList,  $VPNName, $VPNID, $dataLayerBrand, $VPNCat, $dataLayerVariant )
                                    $VPNBestIndvOnClick = dataLayerAddToCart($idNumVPNBest, $idNumAffVPNBest, $listVPNBest,  $vpn_name, $idNumVPNBest, $listVPNBest, $catVPNBest, 'commercial_provider_overview' );
                                        
                                    //dataLayerProductClick($dataLayerList, $VPNName, $VPNID, $dataLayerBrand, $dataLayerVariant, $dataLayerPosition ) 
                                    $VPNBestIndvLogoOnClick = dataLayerProductClick($listVPNBest, $vpn_name, $idNumVPNBest, $vpn_name, 'commercial_provider_overview', $positionNumBest ) ;
                                    
                                    //dataLayerOutboundLink($VPNName, $VPNCat, $VPNSubCat,  $dataLayerOfferId, $dataLayerAffId, $dataLayerLinkType )
                                    $VPNBestIndvOnClick .= dataLayerOutboundLink($vpn_name, $catVPNBest, $slug,  $idNumVPNBest, $idNumAffVPNBest, 'commercial_provider_overview' );    
                                    
                                    ?>
                                
                                    <div class="vpn-list">
                                        <div class="vpn">
                                            <div class="head d-flex align-items-center justify-content-start flex-wrap">
                                                <h2 id="<?php echo strtolower(str_replace(' ','-',$vpn_name)); ?>"><?php echo $vpnNumber+1; echo ". ".$vpn_name; ?></h2>
                                                <div class="compare-vpn">
                                                    <div class="d-flex align-items-center vpn-add-to-compare" data-id="<?php echo $vpn_id; ?>" data-image="<?php echo $vpn_image; ?>">
                                                        <img class="vpn-add-to-compare-img" src="<?php echo get_template_directory_uri(); ?>/images/icons/add-to-compare.svg">
                                                        <img class="vpn-selected-to-compare-img" src="<?php echo get_template_directory_uri(); ?>/images/icons/selected-to-compare.svg">
                                                        <h6>Add to Compare</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if($vpn_image) echo '<a href="'.$permalink.'" class="img-permalink"><img src="'.$vpn_image.'" width="180" height="180" alt="'.$vpn_name.'" onClick="'.$VPNBestIndvLogoOnClick.'"></a>'; ?>
                                            <div class="vpn-content">
                                                <div class="rating_availablity">
                                                    <!-- <div class="rating rating-<?php echo round($avg_rating) ?>">
                                                        <span><?php echo $avg_rating; ?></span>
                                                        <i class="fa fa-star"></i>
                                                    </div> -->
                                                    <div class="availability">
                                                        <span>Availabile On:</span>
                                                        <div class="devices">
                                                            <?php 
                                                                if($availble_on){
                                                                    foreach ($availble_on as $device) {
                                                                        echo '<img src="'.get_stylesheet_directory_uri().'/images/icons/'.$device.'.svg" width="15" height="15" alt="'.$device.'">';
                                                                    }
                                                                }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p><?php echo $short_description; ?></p>
                                                <a id="<?php echo $outbound_id; ?>" class="btn btn-primary btn-icon btn-lg" href="<?php echo $cta_link; ?>" onClick="<?php echo $VPNBestIndvOnClick; ?>" target="_blank">Visit <?php echo $vpn_name; ?></a>
                                            </div>
                                        </div>
                                        <div class="vpn-features">
                                            <div class="individual-feature">
                                                <div class="feature-icon">
                                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/cost_icon.svg" width="27" height="25" alt="Cost">
                                                </div>
                                                <div class="feature-info">
                                                    Lowest Price:
                                                    <span><?php echo $lowest_price; ?></span>
                                                </div>
                                            </div>
                                            <div class="individual-feature">
                                                <div class="feature-icon">
                                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/images/icons/speed_icon.svg" width="27" height="25" alt="Speed">
                                                </div>
                                                <div class="feature-info">
                                                    Avg.DL Speed:
                                                    <span><?php echo $avgdl_speed; ?></span>
                                                </div>
                                            </div>
                                            <div class="individual-feature">
                                                <div class="feature-icon">
                                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/images/icons/contract_icon.svg" width="27" height="25" alt="Contract">
                                                </div>
                                                <div class="feature-info">
                                                    Logging:
                                                    <span><?php echo $logging; ?></span>
                                                </div>
                                            </div>
                                            <div class="individual-feature">
                                                <div class="feature-icon">
                                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/images/icons/location_icon.svg" width="27" height="25" alt="Location">
                                                </div>
                                                <div class="feature-info">
                                                    Countries:
                                                    <span><?php echo $countries; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pros_cons">
                                            <?php 
                                                if($pros){
                                                    echo '<div class="pros">
                                                            <h3><i class="fa fa-plus"></i>pros</h3>
                                                            <ul>';
                                                    foreach ($pros as $pros) {
                                                        echo '<li>'.$pros['pros'].'</li>';
                                                    }

                                                    echo '</ul>
                                                    </div>';
                                                }

                                                if($pros){
                                                    echo '<div class="cons">
                                                            <h3><i class="fa fa-minus"></i>cons</h3>
                                                            <ul>';
                                                    foreach ($cons as $cons) {
                                                        echo '<li>'.$cons['cons'].'</li>';
                                                    }

                                                    echo '</ul>
                                                    </div>';
                                                }
                                            ?>
                                        </div>
                                        <?php echo $description; ?>
                                    </div>
                                    <?php 
                                    if( $vpn_id ): ?>
                                        <?php get_template_part( 'template-parts/blocks/coupon-promotion-inline', '', array( 'vpn_id' => $vpn_id ) ); ?>
                                    <?php endif; ?>
                                    <?php 
                                } ?>
                            </div>

                            
                        <?php endif; ?>
                        
                        <?php // BAR TILES
                       if ( have_rows('anchor_tile') >= 1 ) {
                        $AnchorTilesGroup = array( "popular", "device", "service", "location" );
                        $SectionHeaderFields = array( "section_header_by_popular", "section_header_by_device", "section_header_by_service", "section_header_by_location" );

                        // By Popular
                        $TitleSlug = '';
                        $TitleSlug = str_replace (" ","_", strtolower($AnchorTilesTitle[0]) );
                        $AnchorTilesTitle2[0]['group'] = $AnchorTilesGroup[0];
                        $AnchorTilesTitle2[0]['title'] = $AnchorTilesTitle[0];
                        $AnchorTilesTitle2[0]['slug'] = $TitleSlug;
                        $AnchorTilesTitle2[0]['RepeatField'] = 'by_popular';
                        $AnchorTilesTitle2[0]['RepeatSubField'] = 'select_by_popular';
                        
                        // By Device
                        $TitleSlug = '';
                        $TitleSlug = str_replace (" ","_", strtolower($AnchorTilesTitle[1]) );
                        $AnchorTilesTitle2[1]['group'] = $AnchorTilesGroup[1];
                        $AnchorTilesTitle2[1]['title'] = $AnchorTilesTitle[1];
                        $AnchorTilesTitle2[1]['slug'] = $TitleSlug;
                        $AnchorTilesTitle2[1]['RepeatField'] = 'by_device';
                        $AnchorTilesTitle2[1]['RepeatSubField'] = 'select_by_device';

                        // By Service
                        $TitleSlug = '';
                        $TitleSlug = str_replace (" ","_", strtolower($AnchorTilesTitle[2]) );
                        $AnchorTilesTitle2[2]['group'] = $AnchorTilesGroup[2];
                        $AnchorTilesTitle2[2]['title'] = $AnchorTilesTitle[2];
                        $AnchorTilesTitle2[2]['slug'] = $TitleSlug;
                        $AnchorTilesTitle2[2]['RepeatField'] = 'by_service';
                        $AnchorTilesTitle2[2]['RepeatSubField'] = 'select_by_service';

                        // By Location
                        $TitleSlug = '';
                        $TitleSlug = str_replace (" ","_", strtolower($AnchorTilesTitle[3]) );
                        $AnchorTilesTitle2[3]['group'] = $AnchorTilesGroup[3];
                        $AnchorTilesTitle2[3]['title'] = $AnchorTilesTitle[3];
                        $AnchorTilesTitle2[3]['slug'] = $TitleSlug;
                        $AnchorTilesTitle2[3]['RepeatField'] = 'by_location';
                        $AnchorTilesTitle2[3]['RepeatSubField'] = 'select_by_location';
                        for( $a=0; $a<=(count($AnchorTilesTitle)-1); $a++ ){
                            $BarTileGroup = $AnchorTilesTitle2[$a]['group'];
                            if( have_rows($BarTileGroup) ){
                                while( have_rows($BarTileGroup) ){
                                    the_row();
                                    $SectionHeader = trim(get_sub_field( $SectionHeaderFields[$a] ));
                                    $AchTileTitle = $AnchorTilesTitle2[$a]['title'];
                                    if ( $SectionHeader != ""){
                                        $BarTileTitle = $SectionHeader;
                                    }else{
                                        $BarTileTitle = $AchTileTitle;
                                    }
                                    $BarTileSlug = $AnchorTilesTitle2[$a]['slug'];
                                    $RepeatField = $AnchorTilesTitle2[$a]['RepeatField'];
                                    $RepeatSubField = $AnchorTilesTitle2[$a]['RepeatSubField'];
                                    include(locate_template( 'template-parts/bar-tiles-template.php' ));
                                }
                            }                            
                        }
                       }
                        ?>
                        
                        <?php if(get_field('faqs_heading')) echo ' <h2 id="faq">'.get_field('faqs_heading').'</h2>'; ?>
                        <?php 
                        // Check rows exists.
                            if( have_rows('faqs') ):
                                $counter = 1;
                                echo '<ul class="lists">';
                                    // Loop through rows.
                                    while( have_rows('faqs') ) : the_row();

                                        // Load sub field value.
                                        $question = get_sub_field('question');
                                        echo '<li><a href="#'.strtolower(str_replace(' ','-',$question)).'">'.$question.'</a></li>';
                                        // Do something...

                                    // End loop.
                                    
                                    endwhile;
                                echo '</ul>';                                
                                // Loop through rows.
                                while( have_rows('faqs') ) : the_row();
                                    // Load sub field value.
                                    $question = get_sub_field('question');
                                    $answer = get_sub_field('answer');
                                    echo '<h3 id="'.strtolower(str_replace(' ','-',$question)).'">'.$counter.'. '.$question.'</h3>';
                                    echo '<div class="faq_ans">'.$answer.'</div>';
                                    $counter ++;
                                // End loop.
                                endwhile;

                            // No value.
                            else :
                                // Do something...
                            endif;
                        ?>
                        
                    </div>
                </div>                
                <?php get_template_part( 'template-parts/side-nav-widgets' ); ?>                
            </div>
        </section>
        <section class="page-template-page-vpn-comparisons best-vpn-comparison">
            <div class="vpn-compare-footer">
                <div class="container">
                    <div class="compare-text">SELECT UP TO 5 VPNS TO COMPARE</div>
                    <div class="slider-mobile">
                        <div class="vpn-slider-container">
                            <div class="vpn-slider">


                                <?php for($i = 0; $i < 6; $i++) : ?>
                                    <button class="vpn-item-container">
                                        <div></div>
                                    </button>
                                <?php endfor; ?>

                    
                            </div>
                        </div>
                        <div class="btn-container">
                            <button class="compare-red-btn-bestvpn">COMPARE</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>                        
     <?php
       $VPNBestOnLoad = dataLayerProductImpressionWrapper($VPNBestAllHolder);
           
    ?>
    <script>
    <?php echo $VPNBestOnLoad ; ?>
    </script>   

<?php endwhile; // end of the loop.



get_footer(); ?>
