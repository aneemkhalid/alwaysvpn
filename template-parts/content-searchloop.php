<?php 
// SEARCHLOOP

$author = get_field('author');
$authorName = $author ? get_the_title($author) : esc_html(get_the_author());
$post_name = $post->post_name;
$page_slugs_with_intro_content_field = array('reviews', 'best-vpn', 'comparisons');

$full_excerpt = get_the_excerpt();

if(!$full_excerpt) {
    $content = wp_strip_all_tags(get_the_content());
    $full_excerpt = preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $content);

    if($post_name === 'alwaysvpn') $full_excerpt = get_field('banner_text_desktop');

    if($post_name === 'faqs') $full_excerpt = get_block_data($post, 'acf/faq-list-block' )['faq_list_0_answer'];
    
    if(in_array($post_name, $page_slugs_with_intro_content_field)) $full_excerpt = get_field('intro_content');
}

$truncated_excerpt = create_custom_excerpt($full_excerpt, 100, '[...]');

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('single-post list-view blogloop-v5 blogloop-no-flex no-featured-image search-result-article'); ?> > 
    <div class="blog_custom">

        <!-- POST DETAILS -->
        <div class="post-details">
            <div class="post-details-holder">
                <!-- POST TITLE -->
                <h3 class="post-name row text-left">
                    <a title="<?php the_title() ?>" href="<?php echo esc_url(get_the_permalink()); ?>">
                        <!-- POST TITLE -->
                        <?php the_title() ?>
                    </a>
                </h3>
                
                <!-- POST METAS (DATE / TAGS / AUTHOR / COMMENTS) -->
                <div class="post-category-comment-date row text-left">
                    <?php /*If image is not set, show date*/ ?>
                    <!-- POST META: DATE -->
                    <span class="post-date">
                        <a title="<?php the_title() ?>" href="<?php echo esc_url(get_the_permalink()); ?>">
                            <i class="icon-calendar"></i>
                            <?php echo esc_html(get_the_date()); ?>
                        </a>
                    </span>
                    <!-- POST META: AUTHOR -->
                    <span class="post-author"><i class="icon-user icons"></i><?php echo $authorName; ?></span>
                </div>

                <!-- POST CONTENT / EXCERPT -->
                <div class="post-excerpt row text-left">
                    <?php echo $truncated_excerpt; ?>
                    <div class="clearfix"></div>

                    <?php
                        wp_link_pages( array(
                            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'coinflip' ),
                            'after'  => '</div>',
                        ) );
                    ?>

                    <p class="search-results-button">
                        <a href="<?php echo esc_url(get_the_permalink()); ?>" class="btn btn-secondary">
                            <?php echo esc_html__( 'Continue Reading' ); ?>
                        </a>
                    </p>
                    <div class="clearfix"></div>

                    
                </div>
            </div>
        </div>
    </div>
</article>

