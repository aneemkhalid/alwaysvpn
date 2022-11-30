<?php
/**
 * The template for displaying search results.
 *
 */

get_header(); 
echo create_breadcrumbs_html();

$class_row = "col-md-8";
/*if ( coinflip_redux('mt_blog_layout') == 'mt_blog_fullwidth' ) {
    $class_row = "col-md-12";
}elseif ( coinflip_redux('mt_blog_layout') == 'mt_blog_right_sidebar' or coinflip_redux('mt_blog_layout') == 'mt_blog_left_sidebar') {
    $class_row = "col-md-8";
}*/
$sidebar = 'sidebar-1';
/*if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
    $sidebar = coinflip_redux('mt_blog_layout_sidebar');
    if (!is_active_sidebar($sidebar)) {
        $class_row = "col-md-12";
    }
}*/

?>

    <!-- Page content -->
    <div class="search-results-container">
        <div class="search-results-column">
            <?php if ( have_posts() ) : ?>
                <p class="search-results-for">Search results for</p>
                <h1 class="query-string"><?php echo get_search_query(); ?></h1>
            <div class="">
                <?php /* Start the Loop */ ?>
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php get_template_part( 'template-parts/content', 'searchloop', $post ); ?>
                <?php endwhile; ?>

               <!-- <div class="modeltheme-pagination-holder pagination-container">
                    <div class="modeltheme-pagination pagination">             
                        
                    </div>
                </div>-->
                
                <div class="pagination-wrapper search-page-section">
                <?php the_posts_pagination(array(
              
                    'prev_text' => __( '', '' ),
                    'next_text' => __( '', '' ),
                ) ); ?>
                </div>
                
            </div>
        <?php else : ?>
            <?php get_template_part( 'template-parts/content', 'none' ); ?>
        <?php endif; ?>
        </div>
        

            <div class="sidebar-column">
                <?php get_sidebar(); ?>
            </div>
   
    </div>

<?php get_footer(); ?>