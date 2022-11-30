<?php
/**
 * Template Name: Guides Aggregate Page
 *
 * @package WordPress
 * @subpackage Coinflip_Child
 * @since Coinflip Child 1.0
 * 
 * The template for displaying the comparisons aggregate page.
 *
 */

get_header(); 
echo create_breadcrumbs_html();

//$page_spacing = get_post_meta( get_the_ID(), 'page_spacing', true );

wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );

$filters_obj = get_field_object('field_60f5ccddbb7d6');
$filters = $filters_obj['choices'];
$filters_json = json_encode($filters);

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : '1';

$args = array(  
    'post_status' => 'publish',
    'orderby' => 'publish_date', 
    'order' => 'DESC', 
    'category_name' => 'Guides',
    'posts_per_page' => 6,
    'paged'=> $paged
);

$resoucesInfo= new WP_Query( $args );

foreach ($filters as $key => $filter){
    ${"args" . $key} = array(  
        'post_status' => 'publish',
        'orderby' => 'publish_date', 
        'order' => 'DESC', 
        'category_name' => 'Guides',
        'posts_per_page' => 6,
        'paged'=> $paged,
        'meta_query'    => array(
            array(
                'key' => 'guides_filters',
                'value' => $key,
                'compare' => 'LIKE'
           )
        )
    );
    ${"resourcesInfo" . $key} = new WP_Query( ${"args" . $key} );
}

$intro_content = get_field('intro_content');
$main_content_title = get_field('main_content_title');
$main_content_body = get_field('main_content_body');

$flexible_page_tiles = get_field('flexible_page_tiles');

?>

    <!-- Page content -->
    <div id="primary" class="content-area no-sidebar resources-aggregate-page guides-page">
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
                    
                    
                    <?php if(is_array($flexible_page_tiles)): ?>
                    <div class="flexible-content-container">
                        <div class="flexible-content-title-container">
                            <h2 class="flexible-content-title"><?php echo $flexible_page_tiles['title']; ?></h2>
                        </div>

                        <div class="flexible-content-blocks-container">
                            <?php foreach($flexible_page_tiles['content_blocks'] as $key => $content_block):
                            
                                $page_obj = $content_block['content_block_page'];
                                $author_name = get_the_author_meta('display_name', $page_obj->post_author);

                                $main_img   = get_the_post_thumbnail( $page_obj, 'full' ); // returns the featured image <img> element
                                $content_title = get_the_title($page_obj->ID);
                            
                                $excerpt = wp_strip_all_tags($page_obj->post_content);
                                $excerpt = preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $excerpt);
                            
                                if ( $key !== 0 ) {
                                    $excerpt = create_custom_excerpt($excerpt, 100, '[...]');
                                } else {
                                     $excerpt = create_custom_excerpt($excerpt, 200, '[...]');   
                                }    
                                                
                                $date_to_display =  get_the_date( 'F j, Y', $page_obj->ID );
                                                        
                                
                                if (get_field('guides_filters', $page_obj->ID)) {
                                    $filter_tags = get_field('guides_filters', $page_obj->ID);
                                    $filter_tags = array_column($filter_tags, 'label'); 
                                    $filter_tags = implode(", ", $filter_tags);
                                } else {
                                    $filter_tags = " ";
                                }
         
                         
                            ?>
                                <div class="flexible-content-block-container content-block-<?php echo $key;?>">
                                    <a href="<?php echo get_permalink($page_obj->ID); ?>" class="flexible-content-block-link">
                                        <div class="content-container">
                                            <div class="content-image-container">
                                            
                                                <?php echo $main_img; ?>
                                                
                                            </div>
                                            <div class="content-text-container">
                                               
                                                <div class="content-title-container">
                                                    <h4 class="content-title"><?php echo $content_title; ?></h4>
                                               
                                                </div>
                                                <div class="content-summary-container">
                                                    <p><?php echo $excerpt; ?></p>
                                                </div>
                                                 <div class="content-tag-container">
                                                    <div class="content-tag">
                                                        <p><?php echo $filter_tags ?></p>
                                                    </div>
                                                </div>
                                                <div class="content-byline-container">
                                                    <div class="content-byline">                                            
                                                        <p><?php echo $date_to_display; ?> </p>    
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
 
                    
                <div class="filter-wrapper" data-filters='<?php echo $filters_json;?>'>
                    <ul>
                        <li class="filter-all active"><a href="/guides">All</a></li>
                        <?php
                        foreach ($filters as $key => $filter){
                            ?>
                            <li class="filter-<?php echo $key; ?>"><a href="/guides#<?php echo $key; ?>"><?php echo $filter; ?></a></li>
                            <?php
                        }
                        ?>
                    </ul> 
                </div>  
                    
                <div class="filter-posts-all-wrapper filter-posts">   
                 <?php if( $resoucesInfo->have_posts() ): ?>
                        <div class="vpn-cards">
                            <?php while ( $resoucesInfo->have_posts()  ) : $resoucesInfo->the_post(); ?>
                            <?php  get_template_part( 'template-parts/content', 'filtersloop' )  ?>
                            <?php endwhile; ?>

                        </div>
                         <?php
                            $pagination_bar = pagination_bar( $resoucesInfo, "" );
                            if ($pagination_bar):
                            ?>
                            <div class="pagination-wrapper">
                                <nav class="pagination">
                                    <?php echo $pagination_bar ?>
                                </nav>
                            </div>    
                        <?php 
                            endif;
                        endif; ?>
                </div>     
                <?php
                foreach ($filters as $key => $value){
                    ?>
                    <div class="filter-posts-<?php echo $key; ?>-wrapper filter-posts" style="display: none;">   
                     <?php if( ${"resourcesInfo" . $key}->have_posts() ): ?>
                            <div class="vpn-cards">
                                <?php while ( ${"resourcesInfo" . $key}->have_posts()  ) : ${"resourcesInfo" . $key}->the_post(); ?>
           

                                <?php  get_template_part( 'template-parts/content', 'filtersloop' )  ?>
                                <?php endwhile; ?>

                            </div>
                            <?php
                            $pagination_bar = pagination_bar( ${"resourcesInfo" . $key}, '#'.$key );
                            if ($pagination_bar):
                                ?>
                                <div class="pagination-wrapper">
                                    <nav class="pagination">
                                        <?php echo $pagination_bar ?>
                                    </nav>
                                </div>    
                            <?php 
                            endif;
                        endif; ?>
                        
                    </div> 
                <?php
                }        
                    
                ?>
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