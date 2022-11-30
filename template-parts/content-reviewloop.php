<?php 
// REVIEWLOOP

// THUMBNAIL
$post_img = '';
$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'coinflip_blog_900x550' );
if ($thumbnail_src) {
    $post_img = '<img class="blog_post_image" src="'. esc_url($thumbnail_src[0]) . '" alt="'.esc_attr(the_title_attribute( 'echo=0' )).'" />';
    $post_col = 'col-md-12';
}else{
    $post_col = 'col-md-12 no-featured-image';
}
$privacy = get_field('privacy');
$trust = get_field('trust');
$ease_of_use = get_field('ease_of_use');
$price = get_field('price');
$speed = get_field('speed');
$vpn_name = get_field('vpn_name');
$avg_rating = array_sum(array($privacy, $trust, $ease_of_use, $price, $speed))/5;
$rating_css_class = set_rating_css_background($avg_rating);
$is_published = get_field('add_to_aggregate_page');
$thumbnail_url = get_the_post_thumbnail_url(get_the_ID());


          
            $idNumVPNReviewList = getTrackingLinkInfo($post->ID, 'offer_id');
            
            //dataLayerProductClick($dataLayerList, $VPNName, $VPNID, $dataLayerBrand, $dataLayerVariant, $dataLayerPosition ) 
            $vpnReviewsListOnClick = dataLayerProductClick('VPN Reviews', $vpn_name, $idNumVPNReviewList, $vpn_name, 'reviews_list_cards', $args['counter'] ) ;

  

if($is_published):
?>

<article id="review-<?php the_ID(); ?>" class="vpn-card">
    <div class="image-rating-container<?php if(!$thumbnail_url) echo ' empty-image-height' ?>">
        <a href="<?php the_permalink(); ?>" class="vpn-img-link" onclick="<?php echo $vpnReviewsListOnClick; ?>">
            <?php if($thumbnail_url): ?>    
                <img src="<?php echo $thumbnail_url; ?>" alt="<?php echo $vpn_name; ?>" width="360" height="220">
            <?php endif; ?>
        </a>
        <!-- <div class="rating-card <?php echo $rating_css_class; ?>">
            <span class="vpn-rating">
                <?php echo sprintf('%.1f', $avg_rating); ?>
            </span>
            <span class="star-icon">
                <i class="fa fa-star"></i>
            </span>
        </div> -->
    </div>

    <div class="info-container">
        <div class="text-container">
            <div class="name-container">
                <p class="vpn-name">
                    <?php echo $vpn_name; ?>
                </p>
            </div>
            <div class="description-container">
                <p class="vpn-description">
                    <?php echo get_field('short_description') ?>
                </p>
            </div>
        </div>
        <div class="link-container">
            <a href="<?php the_permalink(); ?>" class="btn btn-primary" onclick="<?php echo $vpnReviewsListOnClick; ?>">
                
                    Read Review
                
            </a>
        </div>
    </div>
</article>

<?php endif; ?>