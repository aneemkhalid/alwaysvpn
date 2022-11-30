<?php 
// DEALSLOOP

$post_img = '';
$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'coinflip_blog_900x550' );
if ($thumbnail_src) {
    $post_img = '<img class="blog_post_image" src="'. esc_url($thumbnail_src[0]) . '" alt="'.esc_attr(the_title_attribute( 'echo=0' )).'" />';
    $post_col = 'col-md-12';
}else{
    $post_col = 'col-md-12 no-featured-image';
}
$vpn_name = get_field('vpn_name');
$thumbnail_url = get_the_post_thumbnail_url(get_the_ID());
$permalink = str_replace('reviews', 'deals', get_the_permalink());

?>

<article id="review-<?php the_ID(); ?>" class="vpn-card">
    <div class="image-rating-container<?php if(!$thumbnail_url) echo ' empty-image-height' ?>">
        <a href="<?php echo $permalink; ?>" class="vpn-img-link">
            <?php if($thumbnail_url): ?>    
                <img src="<?php echo $thumbnail_url; ?>" alt="<?php echo $vpn_name; ?>" width="360" height="220">
            <?php endif; ?>
        </a>
    </div>

    <div class="info-container">
        <div class="text-container">
            <div class="name-container">
                <p class="vpn-name">
                    <?php echo $vpn_name; ?>
                </p>
            </div>
        </div>
        <div class="link-container">
            <a href="<?php echo $permalink; ?>" class="btn btn-primary  <?php echo $post->coupon_count === 0 ? 'no-coupons' : false;?>">
                <span class="vpn-link-text">
                    <?php echo $post->coupon_count; echo $post->coupon_count === 1 ? ' deal' : ' deals';?> available
                </span>
            </a>
        </div>
    </div>
</article>

