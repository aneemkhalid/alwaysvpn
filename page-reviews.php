<?php
/**
 * Template Name: Reviews Aggregate Page
 *
 * @package WordPress
 * @subpackage Coinflip_Child
 * @since Coinflip Child 1.0
 * 
 * The template for displaying the reviews aggregate page.
 *
 */

get_header(); 
echo create_breadcrumbs_html();

//$page_spacing = get_post_meta( get_the_ID(), 'page_spacing', true );

wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );

$args = array(  
    'post_type' => 'reviews',
    'post_status' => 'publish',
    'orderby' => 'menu_order', 
    'order' => 'ASC',
    'posts_per_page' => -1,
);
$reviews = new WP_Query( $args );

$intro_content = get_field('intro_content');
$main_content_title = get_field('main_content_title');
$main_content_body = get_field('main_content_body');

    //dataLayer info
            $positionNumReviewList = 0;
            $priceNumbReviewList = 00.01; 

$vpn_ids = array();

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
                    <?php if( $reviews->have_posts() ): ?>
                        <div class="vpn-cards">
                            <?php while ( $reviews->have_posts() ) :
                                $reviews->the_post();
                                // collect provider ids for coupon popup validation
                                $vpn_ids[] = $post->ID;
                                $positionNumReviewList++
                            ?>
                            
                      
                                <?php get_template_part( 'template-parts/content', 'reviewloop', ['price' => $priceNumbReviewList, "counter" => $positionNumReviewList ]); ?>
                            
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