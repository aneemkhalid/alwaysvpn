<?php

/**
 * Best VPNs Block.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$description = get_field('description'); 
$rating = get_field('rating'); 
if(empty($rating))
    $rating = 0;
?>


<div class="text-rating">
    <div class="bar-head">
        <span><?php echo $description; ?></span>
        <div class="percentage">
            <?php echo $rating; ?>/10
        </div>
    </div>   
    <div class="percentage-bar-full">
        <div class="percentage-bar-inner" style="width:<?php echo round( (float)$rating * 10 ), '%'; ?>;"></div>
    </div>
</div>