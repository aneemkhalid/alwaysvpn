<?php
/**
 * Template Name: Best VPNs Aggregate Page
 *
 * @package WordPress
 * @subpackage Coinflip_Child
 * @since Coinflip Child 1.0
 * 
 * The template for displaying the best vpns aggregate page.
 *
 */

get_header(); 
echo create_breadcrumbs_html();

//$page_spacing = get_post_meta( get_the_ID(), 'page_spacing', true );

wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );

$is_mobile = (bool)($post->post_name == 'mobile') ? true : false;

$mobile_meta_query = array(
    array(
        'key' => 'mobile_commercial_page',
        'value' => 1
    )
);

$args = array(  
    'post_type' => 'best-vpn',
    'post_status' => 'publish',
    'orderby' => 'menu_order', 
    'order' => 'ASC',
    'posts_per_page' => -1,
    'meta_query' => $is_mobile ? $mobile_meta_query : '',
);


$best_vpns = new WP_Query( $args );

$intro_content = get_field('intro_content');
$main_content_title = get_field('main_content_title');
$main_content_body = get_field('main_content_body');

?>

    <!-- Page content -->
    <div id="primary" class="content-area no-sidebar">
        <div class="container aggregate-page-container">
            <div class="row aggregate-row">
                <div class="main-content">
                    <div>
                        <h1 class="page-title"><?php the_title(); ?></h1>
                    </div>
                    <div class="header-separator"></div>
                    <div class="page-intro">
                        <?php echo $intro_content; ?>
                    </div>
                    <?php if( $best_vpns->have_posts() ): ?>
                        <div class="vpn-cards<?php if($is_mobile) echo ' mobile-vpn-cards';?>">
                            <?php while ( $best_vpns->have_posts() ) : $best_vpns->the_post(); ?>
                            
                                <?php get_template_part( 'template-parts/content', 'bestvpnsloop' ); ?>
                            
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>
                </main>
                <div>
                    <h2 class="main-body-title"><?php echo $main_content_title; ?></h2>
                </div>
                <div class="main-body-content">
                    <?php echo $main_content_body; ?>
                </div>
            </div>
        </div>
    </div>

<?php get_footer(); ?>
