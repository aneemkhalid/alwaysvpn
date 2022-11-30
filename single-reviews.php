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
 
            // AVG Rating
            $privacy = get_field('privacy');
            $trust = get_field('trust');
            $ease_of_use = get_field('ease_of_use');
            $price = get_field('price');
            $speed = get_field('speed');
            $author = get_field('author');
            $author_type = get_field('author_type');
            $vpn_name = get_field('vpn_name');
            $avg_rating = array_sum(array($privacy, $trust, $ease_of_use, $price, $speed))/5;
            $avg_rating = number_format((float)$avg_rating, 1, '.', '');
            $outbound_id = prepare_outbound_id( $post->ID );
            
            if($author){
                $authorName = get_the_title($author);
                $authorLink = get_permalink($author);
                $authorImageURL = get_the_post_thumbnail_url($author);
                $author_image = '';
                if($authorImageURL){
                    $author_image = '<img src="'.get_the_post_thumbnail_url($author).'" alt="'.$authorName.'" width="50" height="50" />';
                }
            }else{
                $authorName = get_the_author();
                $author_image = '';
            }
            if($author_type == 'Editor') {
                $authorName = 'Edited by: ' . $authorName;
            }

            $multiple_tracking_links = get_field('multiple_tracking_links');
            if($multiple_tracking_links){
                $cta_link = '';
                $tracking_links = get_field('tracking_links');
                if ( $tracking_links != "" ){
                    foreach ($tracking_links as $key => $links) {
                        // echo $links['link'].' '.$links['link_type'];
                        $post_slug = $post->post_name;
                        if($links['link_type'] == 'general'){
                            $cta_link = $links['link'];
                        }
                    }
                }
            }else{
                if(get_field('vpn_link'))
                    $cta_link = get_field('vpn_link')['url'];
            }

            //Rating logic
            $rating_priv = get_field('privacy_rating');
            $rating_enter = get_field('entertainment_rating');
            $rating_avail = get_field('available_rating');
            $rating_speed = get_field('speed_perf_rating');
            $rating_security = get_field('security_rating');
            $rating_price = get_field('privacy_rating');

            $overall_rating = weightedRating($rating_priv, $rating_enter, $rating_avail, $rating_speed, $rating_security, $rating_price);

           

//dataLayer 
        $idNumVPN = getTrackingLinkInfo($post->ID, 'offer_id');
        $idNumAffVPN = getTrackingLinkInfo($post->ID, 'aff_id');


        $priceNumbReview = 00.01;
        $subCatPageTitleReview = get_the_title();


    //dataLayerProductDetail($dataLayerList, $VPNName, $VPNID, $dataLayerBrand, $VPNCat, $dataLayerVariant );
    $VPNReviewOnLoad = dataLayerProductDetail('Reviews', $vpn_name, $idNumVPN, $vpn_name, 'Reviews', 'vpn_review_page' );


    // dataLayerAddToCart($dataLayerOfferId, $dataLayerAffId, $dataLayerList,  $VPNName, $VPNID, $dataLayerBrand, $VPNCat, $dataLayerVariant )

    $VPNReviewOnClick = dataLayerAddToCart($idNumVPN, $idNumAffVPN, "Reviews",  $vpn_name, $idNumVPN, $vpn_name, 'Reviews', 'review_toc' ); 

    //dataLayerOutboundLink($VPNName, $VPNCat, $VPNSubCat,  $dataLayerOfferId, $dataLayerAffId, $dataLayerLinkType )
    $VPNReviewOnClick .= dataLayerOutboundLink($vpn_name, 'Reviews', $subCatPageTitleReview,  $idNumVPN, $idNumAffVPN, 'review_toc' );
?>

    <script>   
        
        <?php echo $VPNReviewOnLoad; ?>
    </script>    

            <section class="main_wrap">
                <div class="container">
                    <div class="left">
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
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink(); ?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri() . '/images/icons/fb-avpn.svg' ?>" alt="facebook icon" width="30" height="30"/></a>
                                <a href="https://twitter.com/intent/tweet?url=<?php echo get_permalink(); ?>&text=<?php the_title(); ?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri() . '/images/icons/twitter-avpn.svg' ?>" alt="twitter icon" width="30" height="30"></a>
                            </div>
                        </div>
                        </div>
                        <div class="vpn single-review">
                            <?php 
                                if(get_field('vpn_image'))
                                    echo '<img src="'.get_field('vpn_image').'" alt="'.$vpn_name.'" width="100" height="100">';
                            ?>
                            
                            <div class="vpn-content">
                                <?php 
                                    if($vpn_name)
                                        echo '<h2>'.$vpn_name.'</h2>';
                                ?>
                            
                            <div class="rating_availablity">
                                <div class="availability">
                                    <span>Availabile On:</span>
                                    <div class="devices">
                                        <?php
                                            $availble_on = get_field('availble_on');
                                            if( $availble_on ): ?>
                                                <?php foreach( $availble_on as $device ): ?>
                                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/images/icons/<?php echo $device; ?>.svg" alt="<?php echo $device; ?>" height="15" width="15">
                                                <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php 
                                if(get_field('short_description'))
                                    echo '<p>'.get_field('short_description').'</p>';
                                ?>
                            </div>
                            <div class="availability">
                                    <span>Availabile On:</span>
                                    <div class="devices">
                                        <?php
                                            $availble_on = get_field('availble_on');
                                            if( $availble_on ): ?>
                                                <?php foreach( $availble_on as $device ): ?>
                                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/images/icons/<?php echo $device; ?>.svg" alt="<?php echo $device; ?>" height="15" width="15">
                                                <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                            </div>
                            <?php 
                                if(get_field('short_description'))
                                    echo '<p>'.get_field('short_description').'</p>';
                                ?>
                        </div>
                        
                        <?php if($overall_rating > 0) : ?>
                        <div class="ratings-container mb-5">
                            <div class="overall d-md-flex align-items-md-center">
                                <span class="font-weight-bold mr-md-3">Overall Rating:</span>
                                <?php get_template_part('/template-parts/rating', null, ['rating' => $overall_rating, 'show_tooltip' => true]); ?>
                            </div>
                            <div class="weighted-container">
                                <div>
                                    Privacy:
                                    <?php get_template_part('/template-parts/rating', null, ['rating' => $rating_priv]); ?>
                                </div>
                                <div>
                                    Entertainment:
                                    <?php get_template_part('/template-parts/rating', null, ['rating' => $rating_enter]); ?>
                                </div>
                                <div>
                                    Availability & Ease of Use:
                                    <?php get_template_part('/template-parts/rating', null, ['rating' => $rating_avail]); ?>
                                </div>
                                <div>
                                    Speed & Performance:
                                    <?php get_template_part('/template-parts/rating', null, ['rating' => $rating_speed]); ?>
                                </div>
                                <div>
                                    Security:
                                    <?php get_template_part('/template-parts/rating', null, ['rating' => $rating_security]); ?>
                                </div>
                                <div>
                                    Pricing:
                                    <?php get_template_part('/template-parts/rating', null, ['rating' => $rating_price]); ?>
                                </div>
                            </div>             
                        </div>
                        <?php endif; ?>

                        <div class="pros_cons">
                            <div class="pros">
                                <h3><i class="fa fa-plus"></i>pros</h3>
                                <ul>
                                        <?php
                                            // Check rows exists.
                                            if( have_rows('pros') ):

                                                // Loop through rows.
                                                while( have_rows('pros') ) : the_row();

                                                    // Load sub field value.
                                                    $pros = get_sub_field('pros');
                                                    // Do something...
                                                    echo '<li>'.$pros.'</li>';
                                                // End loop.
                                                endwhile;

                                            // No value.
                                            else :
                                                // Do something...
                                            endif;
                                        ?>
                                </ul>
                            </div>
                            <div class="cons">
                                    <h3><i class="fa fa-minus"></i>cons</h3>
                                    <ul>
                                        <?php
                                            // Check rows exists.
                                            if( have_rows('cons') ):

                                                // Loop through rows.
                                                while( have_rows('cons') ) : the_row();

                                                    // Load sub field value.
                                                    $cons = get_sub_field('cons');
                                                    // Do something...
                                                    echo '<li>'.$cons.'</li>';
                                                // End loop.
                                                endwhile;

                                            // No value.
                                            else :
                                                // Do something...
                                            endif;
                                        ?>
                                    </ul>
                            </div>
                        </div>
                            <div class="content">
                                <?php 
                                    if($vpn_name)
                                        echo '<a href="'.$cta_link.'" id="'.$outbound_id.'" class="mobile_floating_cta btn btn-primary btn-icon btn-lg btn-block" onClick="'.$VPNReviewOnClick.'" target="_blank" >Visit '.$vpn_name.'</a>';
                                ?>
                                <?php the_content(); ?>
                            </div>
                    </div>
                    <div class="right">
                        <div class="toc_wrapper sticky-wrapper">
                            <div class="visit-vpn">
                                <?php 
                                    if(get_field('vpn_image'))
                                        echo '<img src="'.get_field('vpn_image').'" alt="'.get_the_title().'" height="150" width="150">';
                                ?>
                                <h6>Lowest Price: <span><?php if(get_field('lowest_price')) echo '$'.get_field('lowest_price'); else echo 'Free'; ?></span></h6>
                                <?php 
                                    if($vpn_name)
                                        echo '<a href="'.$cta_link.'" id="'.$outbound_id.'" class="btn btn-primary btn-icon btn-lg" onClick="'.$VPNReviewOnClick.'" target="_blank">Visit '.$vpn_name.'</a>';
                                ?>
                                
                            </div>
                            <?php echo do_shortcode("[toc]") ?>
                        </div>
                        
                    </div>
                </div>
            </section>

    <?php endwhile; // end of the loop.
get_footer(); ?>

