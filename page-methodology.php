<?php
/**

 * Template Name: Methodology Page
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

?>

<section class="main_wrap">
    <div class="container">
        <div class="middle">
            <div class="reviews_main">
                <h1><?php the_title(); ?></h1>
                <div class="author-wrapper mb-md-0">
                    <a href="<?php echo $authorLink; ?>" class="author-info">
                        <?php echo $author_image; ?>
                        <p>
                            <?php echo $authorName; ?>
                            <span>Last updated: <?php the_date(); ?></span>
                        </p>
                    </a>
                    <!-- <div class="social-share">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink(); ?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri() . '/images/icons/fb-avpn.svg' ?>" alt="facebook icon" width="30" height="30"/></a>
                        <a href="https://twitter.com/intent/tweet?url=<?php echo get_permalink(); ?>&text=<?php the_title(); ?>" target="_blank"><img src="<?php echo get_stylesheet_directory_uri() . '/images/icons/twitter-avpn.svg' ?>" alt="twitter icon" width="30" height="30"></a>
                    </div> -->
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
        </div>

        <style>
            #ez-toc-container {
                display: none !important;
            }
        </style>

    </div>
</section>

<?php
endwhile;
get_footer(); 

?>