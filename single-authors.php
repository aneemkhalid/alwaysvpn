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
    //while ( have_posts() ) : 
        the_post();
$page_id = $wp_query->get_queried_object_id();
?>
 <section class="single_author">
    <div class="container">
      <div class="single_author_inner">
            <div class="img_wrap">
                <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" width="136" height="136">
            </div>
            <div class="author_content">
                <div class="head">
                    <div>
                        <h1><?php the_title(); ?></h1>
                        <p><?php the_field('article_author_title'); ?></p>
                    </div>
                    <?php if(get_field('linkedin_profile')) : ?>
                    <div class="social_icons">
                            <a href="<?php the_field('linkedin_profile'); ?>" target="_blank"><i class="fa fa-linkedin"></i></a>
                    </div>
                    <?php endif; ?>
                </div>
                <p><?php the_field('bio'); ?></p>
            </div>   
      </div>
    </div>
 </section>
 <section class="author_featured_post">
  <div class="container">
      <div class="blue-bg-heading">
          <h4>Featured</h4>
      </div>
      <?php
      $featured_posts = get_field('select_featured_articles');
        if( $featured_posts ): ?>
    <div class="row">
    <?php foreach( $featured_posts as $post ): 
          setup_postdata($post); ?>
      <div class="col-md-4 col-sm-6">
        <a href="<?php the_permalink(); ?>" class="box">
                <?php
                    $thumb_id = get_post_thumbnail_id();
                    $alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true); 
                ?>
             <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo $alt ?>" width="136" height="136"> 
             <div class="inner_content">
                <div>
                    <h5><?php echo get_the_date( 'F j, Y'); ?></h5>
                    <?php 
                    $excerpt = wp_strip_all_tags($post->post_content);
                    $excerpt = preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $excerpt);

                    $excerpt = create_custom_excerpt($excerpt, 100, '[...]');
                    ?>
                    <h4><?php the_title(); ?></h4>
                    <p><?php echo $excerpt; ?></p>
                </div>
                <?php $featuredPostAuthor = get_field('article_authors_dropdown', $post->ID); ?>
                <span>By: <?php echo get_the_title($featuredPostAuthor); ?></span>
             </div>
        </a>
      </div>
      <?php endforeach; ?>
    </div>
    <?php 
    wp_reset_postdata();
    endif; ?>
  </div>
 </section> 
 <section id="articles" class="single_author_articles_wrap">
    <div class="container">
        <div class="blue-bg-heading">
            <h4><?php the_title(); ?>’s Articles</h4>
        </div>
        <?php
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : '1';
        global $wp_query;
        $args = array(  
            'post_status' => 'publish',
            'orderby' => 'publish_date',
            // 'author' => $author_id,
            'order' => 'DESC',
            'posts_per_page' => 5,
            'paged'=> $paged,
            'meta_key' => 'article_authors_dropdown',
            'meta_value' => $page_id
        );

        $wp_query = new WP_Query( $args );
        if( $wp_query->have_posts() ): ?>

        <div class="author_wp_query_wrapper">

            <?php while ( $wp_query->have_posts()  ) : $wp_query->the_post(); ?>

            <a href="<?php the_permalink(); ?>" class="author_article">
            <div class="img_wrap">
                <?php
                    $thumb_id = get_post_thumbnail_id();
                    $alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true); 
                ?>
                <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo $alt; ?>" width="400" height="250">
            </div>
            <div class="article_content">
                <h4><?php the_title(); ?></h4>
                <?php 
                    $excerpt = wp_strip_all_tags(get_the_content());
                    $excerpt = preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $excerpt);

                    $excerpt = create_custom_excerpt($excerpt, 100, '[...]');
                    ?>
                <p><?php echo $excerpt; ?></p>
                <div class="tag">
                <?php $categories = get_the_category(); 
                foreach($categories as $category) {
                ?>
                <span><?php echo $category->name; ?></span>
                <?php } ?>
                </div>
                <span><?php echo get_the_date( 'F j, Y'); ?></span>
            </div>
            </a>

            <?php endwhile; ?>
        </div>
        <?php
        $pagination_bar = pagination_bar( $wp_query, "#articles" );
        if ($pagination_bar):
        ?>
        <div class="pagination-wrapper">
            <nav class="pagination">
                <?php echo $pagination_bar ?>
            </nav>
        </div>    
        <?php 
        endif;
        wp_reset_postdata();
        endif; ?>
    <div>
   </div>
 </div>
 </section>
 <section class="single_author meet_the_team">
    <div class="container">
        <h2>Meet the Team</h2>
        <?php
        $args = array(
            'post_type' => 'authors',
            'post_status' => 'publish',
            'orderby' => 'publish_date',
            'order' => 'DESC',
            'posts_per_page' => -1,
            'post__not_in' => array($page_id)
        );
        $authors = new WP_Query( $args ); 
        if( $authors->have_posts() ): ?>
        <div class="authors_wrapper">
        <?php while ( $authors->have_posts()  ) : $authors->the_post(); ?>
            <div class="single_author_inner">
                    <div class="img_wrap">
                    <?php
                        $thumb_id = get_post_thumbnail_id();
                        $alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true); 
                    ?>
                        <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo $alt ?>" width="136" height="136">
                    </div>
                    <div class="author_content">
                        <div class="head">
                            <div>
                                <h3><?php the_title(); ?></h3>
                                <p><?php the_field('article_author_title'); ?></p>
                            </div>
                            <?php if(get_field('linkedin_profile')) : ?>
                            <div class="social_icons">
                                    <a href="<?php the_field('linkedin_profile'); ?>" target="_blank"><i class="fa fa-linkedin"></i></a>
                            </div>
                            <?php endif; ?>
                        </div>
                        <p><?php the_field('bio'); ?></p>
                        <a class="btn btn-primary btn-sm " href="<?php the_permalink(); ?>">View Bio</a>
                    </div>   
            </div>
            <?php endwhile; ?>
        </div>
        <?php wp_reset_postdata();
        endif; ?>
    </div>
 </section>
     
<?php
//endwhile;
get_footer(); 

?>
