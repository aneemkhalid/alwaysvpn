<?php

/**
 * Related Posts Block.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$related_posts = get_field('related_posts');
?>

<section class="related_posts_main_wrap mb-4">
    <div class="related_posts_wrap p-4">
        <?php if($related_posts) : ?>
        <div class="related_posts_inner">
            <?php foreach($related_posts as $related_post) :
                $post_image = get_the_post_thumbnail_url($related_post['select_post']->ID);
                $post_title = $related_post['select_post']->post_title;
                $post_excerpt = $related_post['select_post']->post_excerpt;
                $authorid = get_field('article_authors_dropdown', $related_post['select_post']->ID);
                $author_name = get_the_title($authorid);
                $post_date = get_the_date('F j, Y', $related_post['select_post']->ID);
                $post_link = get_permalink($related_post['select_post']->ID);
            ?>
            <a class="related_posts d-flex mb-4 align-items-start" href="<?php echo $post_link; ?>">
                <?php if(!empty($related_post['image'])) : ?>
                    <img class="mb-4 mb-md-0" src="<?php echo $related_post['image']; ?>" alt="">
                <?php else : ?>
                        <img class="mb-4 mb-md-0" src="<?php echo $post_image; ?>" alt="">
                <?php endif; ?>
                <div class="related_posts_content pl-md-4">
                    <?php if(!empty($related_post['heading'])) : ?>
                        <h3><?php echo $related_post['heading']; ?></h3>
                    <?php else : ?>
                        <h3><?php echo $post_title; ?></h3>
                    <?php endif; ?>
                    <div class="info mb-2">
                        <span><b><?php echo $author_name; ?> | </b><?php echo $post_date; ?></span>
                    </div>
                    <p class="mb-0"><?php echo $post_excerpt; ?>..<b>Read More</b></p>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <div class="text-center show-less mt-4">
            <a href="javascript:void(0)">Show more</a>
        </div>
    </div>
</section>