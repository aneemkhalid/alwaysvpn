<?php
/**

 * Template Name: Resource Page
 * Template Post Type: post,page
 * @package WordPress
 * @subpackage Coinflip_Child
 * @since Coinflip Child 1.0
 * 
 * The template for displaying the best vpns aggregate page.
 *
 */

get_header(); 
echo create_breadcrumbs_html();

$obj_id = get_queried_object_id();
$current_url = get_permalink( $obj_id );

$video_url = get_field('video_embed_url');
//echo $video_url;

    while ( have_posts() ) : the_post(); 

        $author = get_field('article_authors_dropdown');
        $author_type = get_field('author_type');

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

//Resource side nav logic

$side_nav = get_field('side_nav');
$has_toc = get_field('toc_toggle');
$toc_active = (get_field('toc_toggle')) ? 'toc-active' : '';
$side_data = [];
$side_pos_below = false;
$side_pos_above = false;
$show_sidebar = false;


if(in_array($side_nav['type'], ['Tool', 'Commercial Page'])) {
    $side_pos_below = true;
}
elseif(in_array($side_nav['type'], ['Tracking', 'Deal', 'Review'])) {
    $side_pos_above = true;
}

if($side_nav && $side_nav['type'] == 'Deal') {
    $provider = $side_nav['vpn_provider'];
    $args = array(  
        'post_type' => 'coupon_promotions',
        'post_status' => 'publish',
        'orderby' => 'menu_order', 
        'order' => 'ASC',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => 'coupon_promotion_vpn_provider',
                'value' => $provider,
                'compare' => '='
            )
        )
    );
    $coupons = get_posts( $args );
    $active_coupon = '';
    foreach ($coupons as $coupon){
        $expiration_date = get_field('coupon_promotion_expiration_date', $coupon->ID);
        $is_expired = is_utc_date_expired( $expiration_date, '-4 hours' );
        if (!$is_expired){
            $active_coupon = $coupon;
            $side_pos_above = true;
            $show_sidebar = true;
            break;
        }
        else {
            $side_pos_above = false;
            if(!$has_toc) {
                $show_sidebar = false;
            }
        }
    }
    $first = $active_coupon->ID;


    $coupon_fields = get_fields( $first )['coupon_promotion'];


    if ($coupon_fields['legal_copy']){
        $terms_link = '<a href="#" data-toggle="modal" data-target="#terms-'.$first.'" class="legal-cta">Terms & Conditions</a>';
        $popup_args = [
            'legal-copy' => $coupon_fields['legal_copy'],
            'id' => 'terms-'.$first
        ];
        get_template_part( 'templates/legal-popup', null,  $popup_args);
    } else {
       $terms_link = "";
    }

    $date = date_create($coupon_fields['expiration_date']);
    $nav_expiry = date_format($date, 'm/d/y');

    $side_data = [
        'title' => $coupon_fields['title'],
        'desc' => $coupon_fields['description'],
        'img' => get_post_thumbnail_id($provider),
        'cta_link' => $coupon_fields['cta_link'],
        'cta_text' => 'Get Deal',
        'cta_target' => '_blank',
        'cta_class' => 'btn-icon',
        'coupon_id' => $first,
        'legal_cta' => $terms_link,
        'expire' => $nav_expiry,
        'item_class' => 'item-above',
    ];
}
if($side_nav && $side_nav['type'] == 'Tracking') {
    $provider = $side_nav['vpn_provider'];
    $provider_name = get_field('vpn_name', $provider);
    $lowest_price = get_field('lowest_price', $provider);

    $select_target_link = $side_nav['select_target_link'];
    $multiple = get_field('multiple_tracking_links', $provider);
    if ($multiple){
        foreach (get_field('tracking_links', $provider) as $key => $links) {
            if($links['link_type'] == $select_target_link){
                $nav_link = $links['link'];
            }
        }
    }
    else {
        $vpn_link = get_field('vpn_link', $provider);
        $nav_link = $vpn_link['url'];
    }

    $show_sidebar = true;
    $side_data = [
        'title' => $side_nav['header'],
        'desc' => $side_nav['description'],
        'img' => get_post_thumbnail_id($provider),
        'cta_link' => $nav_link,
        'cta_text' => ($ov_cta_text = $side_nav['cta_text']) ? $ov_cta_text : 'Get ' . $provider_name,
        'cta_target' => '_blank',
        'cta_class' => 'btn-icon',
        'price' => $lowest_price,
        'item_class' => 'item-above',
    ];
}
if($side_nav && $side_nav['type'] == 'Review') {
    $provider = $side_nav['vpn_provider'];
    $provider_name = get_field('vpn_name', $provider);
    $lowest_price = get_field('lowest_price', $provider);

    $show_sidebar = true;
    $side_data = [
        'title' => ($ov_title = $side_nav['header']) ? $ov_title : $provider_name . ' Review',
        'desc' => $side_nav['description'],
        'img' => get_post_thumbnail_id($provider),
        'cta_link' => get_permalink($provider),
        'cta_text' => 'Read Review',
        'cta_target' => '',
        'cta_class' => '',
        'price' => $lowest_price,
        'item_class' => 'item-above',
    ];
}
if( $side_nav && $side_nav['type'] == 'Tool') {

    $show_sidebar = true;
    $side_data = [
        'title' => $side_nav['header'],
        'desc' => $side_nav['description'],
        'img' => $side_nav['image'],
        'cta_link' => $side_nav['cta_link']['url'],
        'cta_text' => $side_nav['cta_text'],
        'cta_target' => $side_nav['cta_link']['target'],
        'cta_class' => '',
        'item_class' => 'item-below',
    ];
}
if($side_nav && $side_nav['type'] == 'Commercial Page') {

    $page_id = $side_nav['commercial_page'];
    $show_sidebar = true;
    $side_data = [
        'title' => ($ov_title = $side_nav['header']) ? $ov_title : get_the_title($page_id),
        'desc' => $side_nav['description'],
        'img' => get_post_thumbnail_id($page_id),
        'cta_link' => get_permalink($page_id),
        'cta_text' => ($ov_cta_text = $side_nav['cta_text']) ? $ov_cta_text : 'Best VPNs',
        'cta_target' => '',
        'cta_class' => '',
        'item_class' => 'item-below',
    ];

}

?>

<section class="main_wrap toc-sidebar <?php if($side_nav) {echo 'side-navi';}  if ($has_toc || $show_sidebar) {echo ' side-navi-show';}?>">
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
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink(); ?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri() . '/images/icons/fb-avpn.svg' ?>" alt="facebook icon" width="30" height="30"/></a>
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

                <?php the_content() ?>

             </div>
             <div class="share-post d-flex mt-5 mb-5 align-items-center">
				<h6 class="mb-0 mr-3">Share this post:</h6>
				<div class="social-share mb-0">
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink(); ?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri() . '/images/icons/fb-avpn.svg' ?>" alt="facebook icon" width="30" height="30"/></a>
                    <a href="https://twitter.com/intent/tweet?url=<?php echo get_permalink(); ?>&text=<?php the_title(); ?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri() . '/images/icons/twitter-avpn.svg' ?>" width="30" height="30" alt="twitter icon"></a>
                </div>
			</div>	
             <div class="related-article-wrap">

                <h3><?php the_field('additional_content_title') ?></h3>
                <?php
                 $related_articles = get_field('select_related_articles');
                 if( $related_articles ): ?>
                <div class="row">
                    <?php foreach( $related_articles as $post ):
                    setup_postdata($post); ?>
                    <div class="col-lg-4">
                        <a href="<?php the_permalink(); ?>" class="related-article">
                            <img src="<?php echo get_the_post_thumbnail_url(); ?>" width="597" height="383" alt="<?php echo the_title(); ?>">
                            <div class="related-article-content">
                                <div>
                                    <h5><?php echo get_the_date( 'F j, Y'); ?></h5>
                                    <h4><?php the_title(); ?></h4>
                                    <?php 
                                    $excerpt = wp_strip_all_tags($post->post_content);
                                    $excerpt = preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $excerpt);

                                    $excerpt = create_custom_excerpt($excerpt, 100, '[...]'); ?>
                                    <p><?php echo $excerpt; ?></p>
                                </div>
                                <?php $relatedAuthor = get_field('article_authors_dropdown', $post->ID); ?>
                                <span>By: <?php echo get_the_title($relatedAuthor); ?></span>
                            </div>
                         </a>
                    </div>
                    <?php endforeach; ?>

                </div>
                <?php 
	            wp_reset_postdata();
                endif; ?>
            </div>
        </div>
        <?php if( $has_toc || $show_sidebar){ ?>

        <div class="right">
            <div class="sticky-wrapper <?php echo $toc_active; echo ($side_pos_below) ? 'resource-below' : 'resource-above'; ?>">

                <?php if($side_pos_above) : ?>
                    <?php get_template_part('/template-parts/resource-side-item', null, ['data' => $side_data]); ?>
                <?php endif; ?>

                <?php if(get_field('toc_toggle')) : ?>
                    <div class="toc_wrapper">
                        <?php echo do_shortcode('[toc]'); ?>
                        <style>
                            .main_wrap.toc-sidebar .ez-toc-title-container:before {
                                position: absolute;
                                content: '<?php echo addslashes(get_field("toc_heading")); ?>';
                                padding: 10px 15px 10px 25px;
                                font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
                                font-size: 14px;
                                font-weight: bold;
                                color: #686868;
                                border-bottom: solid 1px #bcbcbc;
                                margin-bottom: 0;
                                width: 100%;
                                top: 0;
                                left: 0;
                            }
                        </style>
                    </div>
                <?php endif; ?>

                <?php if($side_pos_below) : ?>
                    <?php get_template_part('/template-parts/resource-side-item', null, ['data' => $side_data]); ?>
                <?php endif; ?>

                <?php if(get_field('toc_toggle')) : ?>
                 
                <?php endif; ?>
            </div>
        </div>

        <?php }else{ ?>

        <style>
            #ez-toc-container {
                display: none !important;
            }
        </style>

        <?php } ?>

    </div>
    <?php if($side_nav['type'] != 'None') : ?>   
    
        <div class="sticky-cta">
            <div class="inside-content">
                <!-- <h5><?php echo $side_data['title'] ?></h5> -->
                <a href="<?php echo $side_data['cta_link'] ?>" target="<?php echo $side_data['cta_target'] ?>" class="btn <?php echo $side_data['cta_class']?>">
                    <?php echo $side_data['cta_text'] ?>
                </a>
            </div>
        </div>
    <?php endif; ?>
</section>

<?php
endwhile;
get_footer(); 

?>