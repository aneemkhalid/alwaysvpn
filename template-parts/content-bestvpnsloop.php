<?php 
// BESTVPNSLOOP

// THUMBNAIL
$post_img = '';
$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'coinflip_blog_900x550' );
if ($thumbnail_src) {
    $post_img = '<img class="blog_post_image" src="'. esc_url($thumbnail_src[0]) . '" alt="'.esc_attr(the_title_attribute( 'echo=0' )).'" />';
    $post_col = 'col-md-12';
}else{
    $post_col = 'col-md-12 no-featured-image';
}

$is_published = get_field('add_to_aggregate_page');


if($is_published):
    $author = get_field('author');
    if($author){
        $authorName = get_the_title($author);
    }else{
        $authorName = get_the_author();
    }
    $title = get_the_title();
    $thumbnail_url = get_the_post_thumbnail_url(get_the_ID());
    $url = get_the_permalink();
    $date = get_the_date();
    $content = get_the_content();
    $description = create_custom_excerpt($content, 100, '[...]');
?>

<article id="review-<?php the_ID(); ?>" class="best-vpn-card">
    <div class="image-rating-container<?php if(!$thumbnail_url) echo ' empty-image-height' ?>">
        <?php if($thumbnail_url): ?>
            <a href="<?php echo $url; ?>">
                <img src="<?php echo $thumbnail_url; ?>" alt="<?php echo $title; ?>" width="780" height="500">
            </a>
        <?php endif; ?>
    </div>

    <div class="info-container">
        <div class="date-name-container">
            <div class="date-container">
                <p class="best-vpn-date">
                    <?php echo get_the_date(); ?>
                </p>
            </div>
            <div class="name-container">
                <h4 class="best-vpn-name">
                    <a href="<?php echo $url; ?>">
                        <?php echo $title; ?>
                    </a>
                </h4>
            </div>
        </div>
        <div class="description-container">
            <p class="best-vpn-description">
                <?php echo $description; ?>
            </p>
        </div>
        <div class="link-container">
            <div class="best-vpn-line-separator"></div>
            <div class="author-container">
                By: <span class="best-vpn-author-name"><?php echo $authorName; ?></span>
            </div>
        </div>
    </div>
</article>

<?php endif; ?>