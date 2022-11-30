<?php
/**
 * Template Name: Resource Page
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

$obj_id = get_queried_object_id();
$current_url = get_permalink( $obj_id );

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
   <section class="main_wrap toc-sidebar">
       <div class="container">
         <div class="middle">
             <div class="reviews_main">
                <h1><?php the_title(); ?></h1>
                <div class="author-detail_wrapper">
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
                <div class="comparison_image">
                    <img src="<?php echo get_the_post_thumbnail_url(); ?>" width="768" height="492" alt="<?php the_title(); ?>">
                    <?php //the_post_thumbnail(); ?>
                </div>
                
                <?php the_content() ?>
             </div>
         </div>
        <?php if( get_field('toc_toggle') ){ ?>
            
            <div class="right">
                <div class="toc_wrapper">
                    <?php echo do_shortcode('[toc]'); ?>
                    <style>
                        .main_wrap.toc-sidebar .ez-toc-title-container:before{
                            position: absolute;
                            content:'<?php echo addslashes(get_field("toc_heading")); ?>';
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
          
            </div>
        
        <?php }else{ ?>

            <style>
                #ez-toc-container{ display: none !important; }
            </style>

        <?php } ?>
       
       </div>
   </section>
     
<?php
endwhile;
get_footer(); 

?>
