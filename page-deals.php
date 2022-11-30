<?php
/**
 * Template Name: Deals Page
 * Template Post Type: deals-pages
 *
 * @package WordPress
 * @subpackage Coinflip_Child
 * @since Coinflip Child 1.0
 * 
 * The template for displaying the deals page.
 *
 */

get_header(); 
echo create_breadcrumbs_html();

//$page_spacing = get_post_meta( get_the_ID(), 'page_spacing', true );

wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
$vpns_to_show = get_field('vpns_to_show');
$args = array(  
    'post_type' => 'reviews',
    'post_status' => 'publish',
    'orderby' => 'menu_order', 
    'order' => 'ASC',
    'posts_per_page' => -1,
    'post__in' => $vpns_to_show
);
$vpns = new WP_Query( $args );


$title = get_field('title');
$intro = get_field('intro');
$faqs_heading = get_field('faqs_heading');
$faqs = get_field('faqs');
$coupons_arr = [];

$args = array(  
    'post_type' => 'coupon_promotions',
    'post_status' => 'publish',
    'orderby' => 'menu_order', 
    'order' => 'ASC',
    'posts_per_page' => -1,
);
$coupons = get_posts( $args );
//loop through all coupons and organize them into arrays by their vpn ID s we can sort them
foreach ($coupons as $coupon){
    $vpn_coupon = get_field('coupon_promotion_vpn_provider', $coupon->ID);
    $expiration_date = get_field('coupon_promotion_expiration_date', $coupon->ID);
    $is_expired = is_utc_date_expired( $expiration_date, '-4 hours' );
    if (!$is_expired){
        $coupons_arr[$vpn_coupon][] = $coupon;
    }
}
for($i=0;$i<count($vpns->posts);$i++){
    $vpn_id = $vpns->posts[$i]->ID;
    if (array_key_exists($vpn_id, $coupons_arr)){
        $vpns->posts[$i]->coupon_count = count($coupons_arr[$vpns->posts[$i]->ID]);
    } else {
        $vpns->posts[$i]->coupon_count = 0;
    }
}

?>

    <!-- Page content -->
    <div id="primary" class="content-area no-sidebar deals-page content">
        <div class="container aggregate-page-container">
            <div class="row aggregate-row">
                <div class="main-content">
                    <div>
                        <h1 class="page-title"><?php echo $title; ?></h1>
                    </div>
                    <div class="header-separator"></div>
                        <div class="page-intro">
                            <?php echo $intro; ?>
                        </div>
                        <?php if( $vpns->have_posts() ): ?>
                            <div class="vpn-cards">
                                <?php while ( $vpns->have_posts() ) :
                                    $vpns->the_post();
                                    // collect provider ids for coupon popup validation
                                    $vpn_ids[] = $post->ID;
                                ?>
                                
                                    <?php get_template_part( 'template-parts/content', 'dealsloop' ); ?>
                                
                                <?php endwhile; ?>
                            </div>
                        <?php endif; ?>

                        <?php if($faqs_heading) echo ' <h2 id="faq">'.$faqs_heading.'</h2>'; ?>
                        <?php 
                        
                        if (!empty($faqs) && $faqs != NULL){
                            $faq_toc = $faq_list = '';
                            $faq_toc .= '<ul class="lists">';
                            foreach ($faqs as $key => $faq){
                                $counter = $key+1;
                                $question = $faq['question'];
                                $answer = $faq['answer'];
                                $faq_toc .= '<li><a href="#'.strtolower(str_replace(' ','-',$question)).'">'.$question.'</a></li>';
                                $faq_list .= '<h3 id="'.strtolower(str_replace(' ','-',$question)).'">'.$counter.'. '.$question.'</h3>';
                                $faq_list .= '<div class="faq_ans">'.$answer.'</div>';
                            }
                            $faq_toc .= '</ul>'; 
                            echo $faq_toc;
                            echo $faq_list;
                        } ?>
                        
                </div>
            </div>
        </div>
    </div>

<?php get_footer(); ?>