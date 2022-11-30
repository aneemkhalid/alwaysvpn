<?php

/**
 * Homepage Guides Block
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$featured_large_tiles = get_field('featured_large_tiles');
$featured_small_tiles = get_field('featured_small_tiles');

if(is_array($featured_large_tiles)):
?>
<div class="guides-and-insights-main guides">
    <div class="container">
        <div class="inner">
            <h2><?php echo $featured_large_tiles['large_tile_title']; ?></h2>
            <a class="btn btn-link btn-sm view-all" href="<?php echo $featured_large_tiles['select_post_type']; ?>">View All <?php echo ucfirst($featured_large_tiles['select_post_type']); ?></a>
            <?php 
            if( have_rows('featured_large_tiles') ):
                while ( have_rows('featured_large_tiles') ) : the_row();
                    $large_tiles_posts = get_sub_field('select_large_tiles_posts');
            ?>
            <div class="row">
                <?php 
                if(is_array($large_tiles_posts)) {
                foreach( $large_tiles_posts as $post ): ?>
                <div class="col-lg-4 col-sm-6">
                    <a href="<?php echo get_permalink( $post->ID ); ?>" class="guides-insights-box">
                        <img src="<?php echo get_the_post_thumbnail_url( $post->ID ); ?>" width="737" height="473" alt="<?php echo get_the_title($post->ID) ?>">
                        <div class="guides-insights-box-content">
                        <span><?php echo get_the_date( 'F j, Y', $post->ID ); ?></span>
                        <h4><?php echo get_the_title( $post->ID ); ?></h4>
                        </div>
                    </a>
                </div>
                <?php 
                endforeach; 
                } else {
                $args = array(
                    'post_type' => 'post',
                    'category_name' => 'Guides',
                    'posts_per_page' => 3,
                    'post_status' => 'publish',
                );
                $the_query = new WP_Query( $args );
                if ( $the_query->have_posts() ) {
                    while ( $the_query->have_posts() ) {
                    $the_query->the_post();
                ?>
                <div class="col-lg-4 col-sm-6">
                    <a href="<?php echo get_permalink(); ?>" class="guides-insights-box">
                        <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo get_the_title(); ?>" width="737" height="473">
                        <div class="guides-insights-box-content">
                        <span><?php echo get_the_date( 'F j, Y'); ?></span>
                        <h4><?php echo get_the_title(); ?></h4>
                        </div>
                    </a>
                </div>
                <?php 
                }
                }
                wp_reset_postdata();
                ?>
                <?php } ?>
            </div>
            <?php 
            endwhile;
            endif;
            ?>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if(is_array($featured_small_tiles)): ?>
<div class="guides-and-insights-main insights">
    <div class="container">
        <div class="inner">
            <h2><?php echo $featured_small_tiles['small_tile_title']; ?></h2>
            <a class="btn btn-link btn-sm view-all" href="<?php echo $featured_small_tiles['select_post_type']; ?>">View All <?php echo ucfirst($featured_small_tiles['select_post_type']); ?></a>
            <?php 
            if( have_rows('featured_small_tiles') ):
                while ( have_rows('featured_small_tiles') ) : the_row();
                    $select_small_tiles_posts = get_sub_field('select_small_tiles_posts');
            ?>
            <div class="row">
                <?php 
                if(is_array($select_small_tiles_posts)) {
                foreach( $select_small_tiles_posts as $post ): ?>
                <div class="col-lg-4 col-sm-6">
                    <a href="<?php echo get_permalink( $post->ID ); ?>" class="guides-insights-box">
                        <img src="<?php echo get_the_post_thumbnail_url( $post->ID ); ?>" width="107" height="117" alt="<?php echo get_the_title( $post->ID ); ?>">
                        <div class="guides-insights-box-content">
                        <span><?php echo get_the_date( 'F j, Y', $post->ID ); ?></span>
                        <h4><?php echo get_the_title( $post->ID ); ?></h4>
                        </div>
                    </a>
                </div>
                <?php 
                endforeach; 
                } else {
                $args = array(
                    'post_type' => 'post',
                    'category_name' => 'Insights',
                    'posts_per_page' => 3,
                    'post_status' => 'publish',
                );
                $the_query = new WP_Query( $args );
                if ( $the_query->have_posts() ) {
                    while ( $the_query->have_posts() ) {
                    $the_query->the_post();
                ?>
                <div class="col-lg-4 col-sm-6">
                    <a href="<?php echo get_permalink(); ?>" class="guides-insights-box">
                        <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php echo get_the_title(); ?>" width="107" height="117">
                        <div class="guides-insights-box-content">
                            <span><?php echo get_the_date( 'F j, Y'); ?></span>
                            <h4><?php echo get_the_title(); ?></h4>
                        </div>
                    </a>
                </div>
                <?php 
                }
                }
                wp_reset_postdata();
                ?>
                <?php } ?>
            </div>
            <?php 
            endwhile;
            endif;
            ?>
        </div>
    </div>
</div>
<?php endif; ?>