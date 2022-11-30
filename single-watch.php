<?php
/**
 * The template for displaying single programmatic posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wp-alwaysvpn
 */

get_header();
echo create_breadcrumbs_html(); 

the_post();
$page_id = $wp_query->get_queried_object_id();

$show_title = get_field('show_title', $page_id);
$author = get_field('author', $page_id);
$author_type = get_field('author_type', $page_id);

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

$show_feat_img = get_field('show_featured_image', $page_id);
$featured_img = get_the_post_thumbnail($post_id, 'large');
$intro_text = get_field('intro_text', $page_id);
$enable_provider_override = get_field('enable_provider_override');

if( $enable_provider_override){
    // use vpn order on streaming page
    $select_vpns = get_field('provider_override', $page_id);
} else{
    // use vpn order from theme settings
    $select_vpns = get_field('select_vpns_streaming', 'option');
}


$vpn_ids = array_column($select_vpns, 'vpn');

$why_copy = get_field('why_you_need_a_vpn_for_show_title', $page_id);
$best_copy = get_field('best_vpn_for_show_title');
$conclusion_text = get_field('conclusion_text');
$year = date("Y");



?>

<section class="main_wrap middle_main">
    <div class="container">
        <div class="middle">
            <div class="vpn_main programmatic_main">
                <h1>How To Watch <?php echo $show_title; ?> From Anywhere <?php echo $year; ?></h1>
                <div class="author-wrapper <?php echo !$show_feat_img ? 'no-feat-img' : ''; ?>">
                    <a href="<?php echo $authorLink; ?>" class="author-info d-flex justify-content-center align-items-center mb-0">
                        <?php echo $author_image; ?>
                        <p>
                            <?php echo $authorName; ?>
                            <span>Last updated: <?php the_date(); ?></span>
                        </p>
                    </a>
                    <div class="social-share">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink(); ?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri() . '/images/icons/fb-avpn.svg' ?>" alt="facebook icon" width="30" height="30"/></a>
                        <a href="https://twitter.com/intent/tweet?url=<?php echo get_permalink(); ?>&text=<?php the_title(); ?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri() . '/images/icons/twitter-avpn.svg' ?>" alt="twitter icon" width="30" height="30"></a>
                    </div>
                </div>
            </div>

            <div class="content programmatic-content">
                <?php if( $show_feat_img ): ?>
                    <div class="feat-img-cont">
                        <?php echo $featured_img; ?>
                    </div>
                    <div class="disclaimer-cont feat-img">
                        <p class="programmatic-disclaimer">Disclaimer: Partnerships & affiliate links help us create better content. <a href="/disclosure">Learn how.</a></p>
                    </div>
                <?php else: ?>
                    <div class="disclaimer-cont no-feat-img mb-0">
                        <p class="programmatic-disclaimer">We may be compensated by our partners when you purchase products featured here. This may influence which products we write about but all opinions and reviews are independent and honest.</p>
                    </div>
                <?php endif; ?>

                <?php 
                ///////////////////////////////////////////
                /////////////// Intro Text //////////////// 
                ///////////////////////////////////////////
                ?>
                <div class="intro-text-cont">
                    <p class="intro-text"><?php echo $intro_text; ?></p>
                </div>

                <?php 
                ///////////////////////////////////////////
                ////////////////// Top 5 //////////////////
                ///////////////////////////////////////////
                ?>
                <div class="top-providers-cont">
                    <h2>Top 5 VPNs to stream <?php echo $show_title; ?></h2>

                    <?php if($select_vpns): ?>
                            <div class="vpn-table-wrap">

                                <?php 
                                foreach (array_slice($select_vpns, 0, 5) as $key => $vpn):
                                    // print_r($vpn);
                                    $vpn_id = $vpn['vpn'];
                                    $vpn_image = get_field('vpn_image',$vpn_id);
                                    $vpn_logo = get_field('vpn_logo', $vpn_id);
                                    $vpn_name = get_field('vpn_name',$vpn_id);
                                    $vpn_name_id =  prepare_click_id_vpn_name( $vpn_id );

                                    // $table_description = get_field('table_description', $vpn_id);

                                    $vpn_streaming = get_field('streaming', $vpn_id);
                                    $table_description = $vpn_streaming['table_description'];
                                    if( !$table_description ){
                                        $table_description = get_field('short_description', $vpn_id);
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
                                        
                            //              //dataLayer info
                            //             $idNumVPNTableBest = getTrackingLinkInfo($vpn_id, 'offer_id');
                                
                            //             $idNumAffTableVPNBest = getTrackingLinkInfo($vpn_id, 'aff_id'); 
                                        
                            //             // dataLayerAddToCart($dataLayerOfferId, $dataLayerAffId, $dataLayerList,  $VPNName, $VPNID, $dataLayerBrand, $VPNCat, $dataLayerVariant )
                            //   $VPNBestIndvTableOnClick = dataLayerAddToCart($idNumVPNTableBest, $idNumAffTableVPNBest, get_field('table_heading'),  $vpn_name, $idNumVPNTableBest, $listVPNBest, $catVPNBest, 'commercial_table' );
                                        
                            //              //dataLayerOutboundLink($VPNName, $VPNCat, $VPNSubCat,  $dataLayerOfferId, $dataLayerAffId, $dataLayerLinkType )
                            //             $VPNBestIndvTableOnClick .= dataLayerOutboundLink($vpn_name, $catVPNBest, $slug,  $idNumVPNTableBest, $idNumAffTableVPNBest, 'commercial_table' ); 
                                                        
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
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <?php 
                ///////////////////////////////////////////
                ///////////// How To Use A VPN ////////////
                ///////////////////////////////////////////
                ?>
                <div class="how-to-cont">
                    <h3 class="how-to-title">How To Watch <?php echo $show_title; ?> in <?php echo $year; ?></h3>
                    <div class="how-to-item item-1 d-flex">
                        <span class="item-num h4 d-flex align-items-center justify-content-center">1</span>
                        <p>Download a VPN</p>
                    </div>
                    <div class="how-to-item item-2 d-flex">
                        <span class="item-num h4 d-flex align-items-center justify-content-center">2</span>
                        <p>Connect to the server of your choice</p>
                    </div>
                    <div class="how-to-item item-3 d-flex">
                        <span class="item-num h4 d-flex align-items-center justify-content-center mb-0">3</span>
                        <p class="mb-0">Start watching</p>
                    </div>
                </div>

                <?php 
                ///////////////////////////////////////////
                //////////// Why You Need A VPN ///////////
                ///////////////////////////////////////////
                ?>
                <div class="why-cont">
                    <h2>Why you need a VPN for <?php echo $show_title; ?></h2>
                    <div class="why-content">
                        <?php echo $why_copy; ?>
                    </div>
                </div>

                <?php 
                ///////////////////////////////////////////
                /////////////// Best VPNs ///////////////// 
                ///////////////////////////////////////////
                                                
                $winner_vpn_logo = get_field('vpn_logo', $select_vpns[0]['vpn']->ID);
                $winner_vpn_name = get_field('vpn_name',$select_vpns[0]['vpn']->ID);
                $winner_multiple_tracking_links = get_field('multiple_tracking_links',$select_vpns[0]['vpn']->ID);
                $winner_cta_link = '';
                if($winner_multiple_tracking_links){
                    $winner_cta_link = '';
                    $tracking_links = get_field('tracking_links',$select_vpns[0]['vpn']->ID);
                    foreach ($tracking_links as $links) {
                        // echo $links['link'].' '.$links['link_type'];
                        $post_slug = $post->post_name;
                        if($post_slug == $links['link_type']){
                            $winner_cta_link = $links['link'];
                            break;
                        }elseif($links['link_type'] == 'general'){
                            $winner_cta_link = $links['link'];
                        }
                    }
                }else{
                    if(get_field('vpn_link',$select_vpns[0]['vpn']->ID))
                        $winner_cta_link = get_field('vpn_link',$select_vpns[0]['vpn']->ID)['url'];
                }

                $enable_winner_copy_override = get_field('enable_winner_callout_copy_override', $page_id);
                $winner_card_title = 'VPN WINNER';
                $winner_card_copy = 'We recommend downloading ' . $winner_vpn_name . ' for ' . $show_title;
                $winner_card_cta_text = 'Get ' . $winner_vpn_name;
                if($enable_winner_copy_override){
                    $winner_card_title = get_field('winner_callout_card_title', $page_id);
                    $winner_card_copy = get_field('winner_callout_card_text', $page_id);
                    $winner_card_cta_text = get_field('winner_callout_card_cta_text', $page_id);
                }
                ?>
                <div class="winner-cont">
                    <div class="winner-intro">
                        <h2>Best VPN for <?php echo $show_title; ?> in <?php echo $year; ?></h2>
                        <?php echo $best_copy; ?>
                    </div>

                    <div class="winner-callout">
                        <div class="title-bar d-flex align-items-center justify-content-center flex-row">
                            <img class="award-icon" src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/award-icon-white.svg" alt="award icon">
                            <h3 class="award-title"><?php echo $winner_card_title; ?></h3>
                        </div>
                        
                        <div class="content-cont flex-column d-flex justify-content-center align-items-center">
                            <?php echo wp_get_attachment_image($winner_vpn_logo, 'full', false, array('class' => 'winner-logo')); ?>
                            <h4 class="winner-copy"><?php echo $winner_card_copy; ?></h4>
                            <a href="<?php echo $winner_cta_link; ?>" target="_blank" class="btn btn-primary btn-lg"><?php echo $winner_card_cta_text; ?></a>
                        </div>
                        
                    </div>
                </div>

                <?php 
                $vpn_counter = 1;
                foreach (array_slice($select_vpns, 0, 5) as $key => $vpn): 
                    $vpn_id = $vpn['vpn'];
                    $vpn_image = get_field('vpn_image',$vpn_id);
                    $vpn_logo = get_field('vpn_logo', $vpn_id);
                    $pros = get_field('pros',$vpn_id);
                    $cons = get_field('cons',$vpn_id);
                    $vpn_name = get_field('vpn_name',$vpn_id);
                    $vpn_name_id =  prepare_click_id_vpn_name( $vpn_id );
                    $outbound_id = prepare_outbound_id( $vpn_id );
                    $permalink = get_permalink( $vpn_id );

                    $vpn_programmatic_category = get_the_category($page_id)[0]->slug;
                    $vpn_programmatic_content = get_field($vpn_programmatic_category, $vpn_id);
                    $description = $vpn_programmatic_content['general_copy'];
                    if( $vpn_counter == 1 ){
                        $description = $vpn_programmatic_content['first_placement_copy'];
                    }
                    $card_title = $vpn_programmatic_content['card_title'];
                    $card_bullets = $vpn_programmatic_content['card_bullet_points'];

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
                ?>
                    
                <div class="vpn-list">
                    <div class="vpn">
                        <h2 id="<?php echo strtolower(str_replace(' ','-',$vpn_name)); ?>"><?php echo $vpn_counter; echo ". ".$vpn_name; ?></h2>

                        <div class="programmatic-vpn-card d-flex flex-column flex-md-row align-items-center justify-content-center">

                            <?php if($vpn_image) echo '<a href="'.$permalink.'" class="img-permalink"><img src="'.$vpn_image.'" width="180" height="180" alt="'.$vpn_name.'" ></a>'; ?>

                            <div class="vpn-content">
                                <h5 class="card-title"><?php echo $card_title; ?></h5>
                                <?php if($card_bullets): ?>
                                    <ul class="mb-0">
                                    <?php foreach($card_bullets as $card_bullet): ?>
                                        <li><?php echo $card_bullet['bullet_point']; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                            <div class="vpn-card-btn">
                                <a id="<?php echo $outbound_id; ?>" class="btn btn-primary btn-md vpn-card-btn d-flex align-items-center justify-content-center" href="<?php echo $cta_link; ?>" onClick="<?php //echo $VPNBestIndvOnClick; ?>"  target="_blank">Visit <?php echo $vpn_name; ?></a>
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

                <?php ++$vpn_counter; endforeach; ?>
                
                <?php 
                ///////////////////////////////////////////
                /////////////// Conlclusion /////////////// 
                ///////////////////////////////////////////
                ?>
                <div class="conclusion-cont">
                    <h2 class="conclusion">Conclusion</h2>
                    <?php echo $conclusion_text; ?>
                </div>


                <div class="winner-cont">
                    <div class="winner-callout">
                        <div class="title-bar d-flex align-items-center justify-content-center flex-row">
                            <img class="award-icon" src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/award-icon-white.svg" alt="award icon">
                            <h3 class="award-title"><?php echo $winner_card_title; ?></h3>
                        </div>
                        
                        <div class="content-cont flex-column d-flex justify-content-center align-items-center">
                            <?php echo wp_get_attachment_image($winner_vpn_logo, 'full', false, array('class' => 'winner-logo')); ?>
                            <h4 class="winner-copy"><?php echo $winner_card_copy; ?></h4>
                            <a href="<?php echo $winner_cta_link; ?>" target="_blank" class="btn btn-primary btn-lg"><?php echo $winner_card_cta_text; ?></a>
                        </div>
                        
                    </div>
                </div>

                <div class="faq-cont">
                    <h2 class="faq-title">FAQs</h2>
                    <?php 
                    // Check rows exists.
                    if( have_rows('faq_streaming', 'option') ):
                        $counter = 1;

                        while( have_rows('faq_streaming', 'option') ) : the_row();
                            $question = get_sub_field('question');
                            $answer = get_sub_field('answer'); ?>
                                <div class="faq-item">
                                    <h3 class="faq-title"><?php echo $counter . '. ' . $question; ?></h3>
                                    <?php echo $answer; ?>
                                </div>

                            <?php
                            $counter++;
                        endwhile;
                    endif;
                    ?>
                </div>

            </div>
        </div>
    </div>
</section>


<?php

get_footer(); 

?>