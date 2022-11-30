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
    
    // collect provider ids for coupon popup validation
    $vpn_ids = array();
    foreach( parse_blocks( $post->post_content ) as $block ) {
        if( $block['blockName'] === 'acf/comp-box' ) {
            if( isset( $block['attrs']['data'] ) && $block['attrs']['data']['information_type'] === 'detailed_information' ) {
                $vpn_ids[] = $block['attrs']['data']['select_first_vpn'];
                $vpn_ids[] = $block['attrs']['data']['select_second_vpn'];
            }
        }
    }

    //$featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full');
    
    $video_url = get_field('video_embed_url');
?>

        <section class="main_wrap comparison  side_nav">
            <div class="container">
                <div class="middle">
                    <div class="reviews_main">
                        <h1> <?php the_title(); ?></h1>
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
                                <a href="https://twitter.com/intent/tweet?url=<?php echo get_permalink(); ?>&text=<?php the_title(); ?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri() . '/images/icons/twitter-avpn.svg' ?>" alt="twiiter icon" width="30" height="30"></a>
                            </div>
                        </div>
                        <?php if($video_url || has_post_thumbnail()) : ?>
                            <div class="comparison_image">
                                <?php if($video_url) : ?>
                                    <iframe src="<?php echo $video_url; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                <?php elseif(!wp_is_mobile() && has_post_thumbnail()) : ?>
                                    <?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'large' ); ?>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        
                    </div>
                    <div class="content">
                        <?php the_content(); ?>
                    </div>
                </div>
                <?php get_template_part( 'template-parts/side-nav-widgets' ); ?>
            </div>
        </section>

<?php 
    endwhile; // end of the loop.
get_footer(); ?>