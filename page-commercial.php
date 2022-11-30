<?php
/**

 * Template Name: Commercial Pages 2.0
 * Template Post Type: post,page,best-vpn
 * @package WordPress
 * @subpackage Coinflip_Child
 * @since Coinflip Child 1.0
 * 
 * The template for displaying the best vpns aggregate page.
 *
 */

get_header();
echo create_breadcrumbs_html();

    while ( have_posts() ) : the_post(); 

        $select_vpns = get_field('select_vpns');

        // collect provider ids for coupon popup validation
        if($select_vpns) {
            $vpn_ids = array_column($select_vpns, 'vpn');

            //use menu order if best of page is selected in theme settings
            if (!empty($best_of_to_use_menu_order) && in_array($current_best_of_id, $best_of_to_use_menu_order) ) {
                foreach($select_vpns as $i => $item) {  
                    $select_vpns[$i]["Order"] = get_post_field( 'menu_order', $vpn_ids[$i]);    
                }

                usort($select_vpns, function ($item1, $item2) {
                    return $item1['Order'] <=> $item2['Order'];
                });
            }
        }


        $best_of_to_use_menu_order = get_field('best_vpn_pages_selected', 'option');
        $current_best_of_id =  get_queried_object_id();

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

        //VPN Table and Other Info
        $vpn_table = [];
        $tbl_datapoints = get_field('datapoints');

        $vpn_list = [];
        //var_dump($tbl_datapoints);
        //$count = 1;
        foreach ($select_vpns as $key => $vpn) :
            $vpn_id = $vpn['vpn'];
            $vpn_image = get_field('vpn_image',$vpn_id);
            $vpn_logo = get_field('vpn_logo', $vpn_id);
            $logo_mobile = ($mob = get_field('logo_wide', $vpn_id)) ? $mob : $vpn_image;
            $compare_logo = get_field('compare_logo', $vpn_id);

            //echo $compare_logo;
            
            $outbound_id = prepare_outbound_id( $vpn_id );

            $vpn_name = get_field('vpn_name',$vpn_id);
            $vpn_name_id =  prepare_click_id_vpn_name( $vpn_id );


            //List Fields
            $list_datapoints = [];

            $lowest_price = formatDatapoints('lowest_price',$vpn_id);
            $money = formatDatapoints('money_back_guarantee',$vpn_id);
            $logging = formatDatapoints('logging',$vpn_id);
            $countries = formatDatapoints('countries',$vpn_id);

            if($dp_or = $vpn['datapoints_override']) {
                //var_dump($vpn['datapoints_override']);
                foreach($dp_or as $item) {
                    $list_datapoints[$item['label']] = formatDatapoints($item['value'],$vpn_id);
                }
            }
            else {
                $list_datapoints['Lowest Price'] = $lowest_price;
                $list_datapoints['Server Network'] = $countries;
                $list_datapoints['Logging'] = $logging;
                $list_datapoints['Money-Back Guarantee'] = $money;
            }


            $pros = ($pros_or = $vpn['pros_override']) ? $pros_or : get_field('pros',$vpn_id);
            $cons = ($cons_or = $vpn['cons_override']) ? $cons_or : get_field('cons',$vpn_id);

            $topic = get_field('page_topic');
            $short_desc = ($tbl_desc = $vpn['table_description']) ? $tbl_desc : get_field('short_description',$vpn_id);
            $flag = '';
            $desc = $vpn['description'];

            if($topic) {
                $rating_title = $topic . ' Rating';
            }
            else {
                $rating_title = 'Rating';
            }

            if($key == 0) {
                if($topic) {
                    $flag = 'Our #1 VPN for ' . $topic;
                }
                if($top = $vpn['top_of_the_list_description']) {
                    $desc = $top;
                }
                if($top_desc = $vpn['top_of_the_list_table_description']) {
                    $short_desc = $top_desc;
                }
            }

            $review_link = get_permalink($vpn_id);

            $coupon = [];
            //Get Deal info for top 3 vpns
            if($key <= 2) {
                $coupon_fields = get_coupon_deal($vpn_id);
                $expired = true;

                if($coupon_fields) {
                    $expired = false;
                    $coupon = [
                        'disc' => $coupon_fields['discount_detail'],
                        'title' => $coupon_fields['title'],
                        'desc' => $coupon_fields['description'],
                        'link' => $coupon_fields['cta_link'],
                    ];
                }
            }
        
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
            $idNumVPNTableBest = getTrackingLinkInfo($vpn_id, 'offer_id');
    
            $idNumAffTableVPNBest = getTrackingLinkInfo($vpn_id, 'aff_id'); 
                
            // dataLayerAddToCart($dataLayerOfferId, $dataLayerAffId, $dataLayerList,  $VPNName, $VPNID, $dataLayerBrand, $VPNCat, $dataLayerVariant )
            $VPNBestIndvTableOnClick = dataLayerAddToCart($idNumVPNTableBest, $idNumAffTableVPNBest, 'Our Picks',  $vpn_name, $idNumVPNTableBest, $listVPNBest, $catVPNBest, 'commercial_table' );

            //dataLayerOutboundLink($VPNName, $VPNCat, $VPNSubCat,  $dataLayerOfferId, $dataLayerAffId, $dataLayerLinkType )
            $VPNBestIndvTableOnClick .= dataLayerOutboundLink($vpn_name, $catVPNBest, $slug,  $idNumVPNTableBest, $idNumAffTableVPNBest, 'commercial_table' );      
            
            $vpn_table[] = [
                'count' => $key + 1,
                'name' => $vpn_name,
                'logo' => $vpn_logo,
                'rating' => $vpn['rating'],
                'dp_1' => formatDatapoints($tbl_datapoints[0]['datapoint'],$vpn_id),
                'dp_2' => formatDatapoints($tbl_datapoints[1]['datapoint'],$vpn_id),
            ];

            $vpn_list[] = [
                'count' => $key + 1,
                'id' => $vpn_id,
                'rating' => $vpn['rating'],
                'flag' => $flag,
                'name' => $vpn_name,
                'img' => $vpn_image,
                'mobile' => $logo_mobile,
                'compare' => $compare_logo,
                'short' => $short_desc,
                'data' => $list_datapoints,
                'coupon' => $coupon,
                'desc' => $desc,
                'cta' => $cta_link,
                'review' => $review_link,
                'pros' => $pros,
                'cons' => $cons,
            ];

        endforeach;
        // echo '<pre>';
        // print_r($vpn_list);
        // echo '</pre>';
        ?>

        <section class="main_wrap middle_main side_nav">
            <div class="container">
                <div class="middle pb-5">
                    
                    <div class="hero position-relative mb-xl-5">
                        <div class="reviews_main">
                            <h1><?php the_title(); ?></h1>
                            <?php include(locate_template( 'template-parts/author-wrapper.php' )); ?>
                        </div>

                        <?php if($video_url || has_post_thumbnail() ) : ?>
                            <div class="comparison_image row-full">
                                <div class="blue-bg-banner position-absolute"></div>
                                <?php if($video_url) : ?>
                                    <iframe src="<?php echo $video_url; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                <?php elseif(!wp_is_mobile() && has_post_thumbnail()) : ?>
                                    <?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'large' ); ?>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="content">
                    
                    <?php // ANCHOR TILES
                    include(locate_template( 'template-parts/anchor-tiles.php' )); ?>

                    <div class="content-top mb-5">
                        <?php the_content(); ?>
                    </div>
                    
                    
                    <?php if($vpn_table) : ?>
                        <div class="vpn-table-list mb-5 row-full">

                            <div class="scroll-text text-right mb-2 d-md-none">Slide to scroll</div>
                            <div class="table-scroll-container">
                                <div class="gradient-right"></div>
                                <div class="table-scroll carousel drag">
                                    <table class="carousel-cell">
                                        <thead>
                                            <tr class="bg-white"> 
                                                <th class="index-th"><span class="d-none">Index</span></th>
                                                <th>Our Picks</th>
                                                <th><div class="rating-title"><?php echo $rating_title; ?></div></th>
                                                <th class="leading-none"><?php echo $tbl_datapoints[0]['title'] ?></th>
                                                <th class="leading-none"><?php echo $tbl_datapoints[1]['title'] ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($vpn_table as $item) : ?>
                                            <tr data-href="#<?php echo strtolower(str_replace (' ','-',$item['name'])) ?>" class="tr-click">
                                                <td class="index-td font-weight-bold text-blue-100"><?php echo $item['count']; ?></td>
                                                <td>
                                                    <div class="vpn-table-logo d-none d-md-block">
                                                        <?php  echo wp_get_attachment_image($item['logo'], 'full'); ?>
                                                    </div>
                                                    <div class="vpn-table-name text-left font-weight-bold text-blue-100 d-md-none">
                                                        <?php echo  $item['count'] . '. ' . $item['name']; ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="vpn-table-rating d-flex align-items-center">
                                                        <svg width="24" height="23" viewBox="0 0 24 23" xmlns="http://www.w3.org/2000/svg" class="mr-2">
                                                            <path d="M12.0188 0L15.6995 7.56579L24 8.77632L18.0282 14.6776L19.4178 23L12.0188 19.0658L4.58216 23L6.00939 14.6776L0 8.77632L8.30047 7.56579L12.0188 0Z" />
                                                        </svg>
                                                        <?php echo $item['rating']; ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="vpn-table-dp">
                                                        <?php echo $item['dp_1']; ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="vpn-table-dp-2">
                                                        <?php echo $item['dp_2']; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if($vpn_list) : ?>
                        <div id="vpn-list" class="vpn-list d-flex flex-column mb-4">
                            <?php foreach($vpn_list as $item) : ?>
                                <div class="vpn-item bg-white <?php echo ($item['count'] == 1) ? 'item-1': ''; ?>" id="<?php echo strtolower(str_replace (' ','-',$item['name'])) ?>">
                                    <?php if($flag = $item['flag']) : ?>
                                        <div class="flag text-center font-weight-bold">
                                            <?php echo $flag; ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="top-container">
                                        <div class="mobile d-md-none">
                                            <!-- Mobile Layout   -->
                                            <div class="vpn-name">
                                                <h2 id="<?php echo strtolower(str_replace(' ','-',$item['name'])); ?>" class="mb-0"><?php echo $item['count'] . '. ' . $item['name'] ?></h2>
                                                <button class="compare-vpn px-0">
                                                    <div class="vpn-add-to-compare d-flex align-items-center" data-id="<?php echo $item['id']; ?>" data-image="<?php echo $item['compare']; ?>">
                                                        <div class="add-icon">
                                                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M5.93555 1L5.80137 10.737" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                <path d="M1 5.80151L10.737 5.93569" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                            </svg>
                                                        </div>
                                                        <h6 class="mb-0 ml-2">Add to Compare</h6>
                                                    </div>
                                                </button>
                                            </div>
                                            
                                            <div class="rating-bar d-flex align-items-center justify-content-between mb-3">
                                                <?php get_template_part('/template-parts/rating', null, ['rating' => $item['rating']]); ?>
                                                <a href="<?php echo $item['review'] ?>" class="review-link">Read Review</a>
                                            </div>

                                            <div class="vpn-logo mb-3">
                                                <a href="<?php echo $item['review'] ?>">
                                                    <img src="<?php echo $item['mobile'] ?>" alt="<?php echo $item['name'] . ' logo'; ?>" width="315" height="100" />
                                                </a>
                                            </div>

                                            <div class="vpn-short mb-4">
                                                <h4><?php echo $item['short']; ?></h4>
                                            </div>

                                            <div class="datapoints mb-4">
                                                <?php foreach($item['data'] as $k => $v) : ?>
                                                    <div class="datapoint">
                                                        <div class="title font-weight-bold mb-2">
                                                            <?php echo $k; ?>:
                                                        </div>
                                                        <div class="value">
                                                            <?php echo $v; ?>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>

                                            <div class="cta px-2 mb-4 text-center">
                                                <a href="<?php echo $item['cta'] ?>" target="_blank" class="btn btn-primary btn-lg btn-icon">
                                                    Get This VPN
                                                </a>
                                            </div>
                                        </div>

                                        <div class="d-none d-md-block desktop">
                                            <!-- Desktop Layout   -->
                                            <div class="row mx-0 mb-3">
                                                <h2 id="<?php echo strtolower(str_replace(' ','-',$item['name'])); ?>" class="col mb-0"><?php echo $item['count'] . '. ' . $item['name'] ?></h2>
                                                <button class="compare-vpn">
                                                    <div class="vpn-add-to-compare d-flex align-items-center" data-id="<?php echo $item['id']; ?>" data-image="<?php echo $item['compare']; ?>">
                                                        <div class="add-icon">
                                                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M5.93555 1L5.80137 10.737" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                <path d="M1 5.80151L10.737 5.93569" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                            </svg>
                                                        </div>
                                                        <h6 class="mb-0 ml-2">Add to Compare</h6>
                                                    </div>
                                                </button>
                                            </div>
                                            <div class="row mx-0 mb-5">

                                                <div class="left-content col-4">
                                                    <div class="vpn-logo mb-5 top-info">
                                                        <a href="<?php echo $item['review'] ?>">
                                                            <img src="<?php echo $item['img'] ?>" alt="<?php echo $item['name'] . ' logo'; ?>" width="180" height="180" />
                                                        </a>
                                                    </div>
                                                    <div class="datapoints mb-4">
                                                        <?php foreach($item['data'] as $k => $v) : ?>
                                                            <div class="datapoint">
                                                                <div class="title font-weight-bold mb-2">
                                                                    <?php echo $k; ?>:
                                                                </div>
                                                                <div class="value">
                                                                    <?php echo $v; ?>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>

                                                <div class="right-content col pl-5">
                                                    <div class="mb-5 top-info">
                                                        <div class="vpn-short mr-4">
                                                            <h3 class="mb-3"><?php echo $item['short']; ?></h3>
                                                        </div>
                                                        <div class="rating-bar d-flex align-items-center mb-3">
                                                            <?php get_template_part('/template-parts/rating', null, ['rating' => $item['rating'], 'show_tooltip' => true]); ?>
                                                            <div>
                                                                <a href="<?php echo $item['review'] ?>" class="review-link ml-3">Read Review</a>
                                                            </div>
                                                        </div>
                                                        <div class="cta mb-4">
                                                            <a href="<?php echo $item['cta'] ?>" target="_blank" class="btn btn-primary btn-lg btn-icon">
                                                                Get This VPN
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="args-container">
                                                        <div class="pros mb-3">
                                                            <h5 class="text-uppercase d-inline-flex align-items-center leading-none">
                                                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" class="mr-3" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M0 6H12" stroke="black" stroke-width="3"/>
                                                                    <path d="M6 0L6 6L6 12" stroke="black" stroke-width="3"/>
                                                                </svg>
                                                                Pros
                                                            </h5>
                                                            <ul class="dashed">
                                                                <?php foreach($item['pros'] as $pro) : ?>
                                                                    <li class="d-flex"><?php echo $pro['pros']; ?></li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        </div>
                                                        <div class="cons">
                                                            <h5 class="text-uppercase d-inline-flex align-items-center leading-none">
                                                                <svg width="10" height="10" viewBox="0 0 12 12" fill="none" class="mr-3" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M0 6H12" stroke="black" stroke-width="3"/>
                                                                    <!-- <path d="M6 0L6 6L6 12" stroke="black" stroke-width="3"/> -->
                                                                </svg>
                                                                Cons
                                                            </h5>
                                                            <ul class="dashed mb-0">
                                                                <?php foreach($item['cons'] as $con) : ?>
                                                                    <li class="d-flex"><?php echo $con['cons']; ?></li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <?php if($item['coupon']) : ?>
                                            <div class="row mx-0">                                                
                                                <div class="coupon-container mb-4 col py-4">
                                                    <div class="col row mx-0 p-0">
                                                        <div class="col-12 d-flex align-items-center col-md-3 justify-content-md-center">
                                                            <h3 class="discount mb-0"><?php echo $item['coupon']['disc'] ?></h3>
                                                        </div>
                                                        <div class="col-12 mb-3 col-md-6 mb-md-0">
                                                            <h3 class="coupon-title">
                                                                <?php echo $item['coupon']['title']; ?>
                                                            </h3>
                                                            <p class="mb-0"><?php echo $item['coupon']['desc']?></p>
                                                        </div>
                                                        <div class="text-center col-12 d-flex align-items-center justify-content-center col-md-3">
                                                            <a href="<?php echo $item['coupon']['link'] ?>" class="btn btn-sm btn-primary btn-icon">Get Deal</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div id="collapse-<?php echo $item['count'] ?>" class="view-details collapse show">
                                        <div class="bot-container">
                                            <div class="args-container mb-4 d-md-none">
                                                <div class="pros mb-3">
                                                    <h5 class="text-uppercase d-inline-flex align-items-center leading-none">
                                                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" class="mr-3" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M0 6H12" stroke="black" stroke-width="3"/>
                                                            <path d="M6 0L6 6L6 12" stroke="black" stroke-width="3"/>
                                                        </svg>
                                                        Pros
                                                    </h5>
                                                    <ul class="dashed">
                                                        <?php foreach($item['pros'] as $pro) : ?>
                                                            <li class="d-flex"><?php echo $pro['pros']; ?></li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </div>
                                                <div class="cons">
                                                    <h5 class="text-uppercase d-inline-flex align-items-center leading-none">
                                                        <svg width="10" height="10" viewBox="0 0 12 12" fill="none" class="mr-3" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M0 6H12" stroke="black" stroke-width="3"/>
                                                            <!-- <path d="M6 0L6 6L6 12" stroke="black" stroke-width="3"/> -->
                                                        </svg>
                                                        Cons
                                                    </h5>
                                                    <ul class="dashed">
                                                        <?php foreach($item['cons'] as $con) : ?>
                                                            <li class="d-flex"><?php echo $con['cons']; ?></li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="desc-container px-md-3">
                                                <?php echo $item['desc']; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <button data-toggle="collapse" data-target="#collapse-<?php echo $item['count'] ?>" aria-expanded="true" aria-controls="collapse-<?php echo $item['count'] ?>" class="view-details-btn d-flex align-items-center justify-content-center font-weight-bold">
                                            <span class="text">Hide Details</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 icon" height="24" width="24" viewBox="0 0 20 20" fill="currentColor" style="transform: rotate(180deg);">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>

                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                    <?php endif; ?>
                                        
                    <div class="content-bottom">
                        <?php the_content(); ?>
                    </div>

                        
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
                    endif;
                    ?>
                        
                    </div>
                </div>

                <?php get_template_part( 'template-parts/side-nav-widgets' ); ?>      

            </div>

            <div class="vpn-compare-footer-container">
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
                                <button class="compare-red-btn">COMPARE</button>
                            </div>
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
