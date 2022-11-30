<?php

/**
 * Visual CTA
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */


$creativeElement = get_field('creative_elements');
$services = get_field('services');
$parent_post_meta = get_field( 'cta_link_type', 50869 );
$service = get_field('service');
$ctaLink = get_post_meta( get_the_ID(), 'cta_link', true);
$creativeProvider = prepare_click_id_vpn_name(get_field('providers'));

if($services != '') {
?>
 <div class="visual-creative-cta <?php echo $services; ?>">
    <div class="cta_logo">
        <?php if($service['logo']) : ?>
            <img src="<?php echo $service['logo']['url']; ?>" alt="<?php echo $service['logo']['alt']; ?>" width="150" height="25">
        <?php endif; ?>
    </div>
    <?php echo $service['description']; ?>
    <div class="visual-cta-link-wrap">
         <a id="visual_creative_cta_<?php echo $creativeProvider; ?>" class="btn btn-primary" href="<?php echo $ctaLink; ?>"><?php echo $service['cta_text']; ?></a>
    </div>
 </div>

 <?php
} else {
    echo "";
}