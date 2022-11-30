<?php

/**
 * Visual Commercial CTA Block
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */


$visual_commercial_cta = get_field('visual_commercial_cta');

if($visual_commercial_cta) {
?>
 <div class="visual-creative-cta generic <?php echo $visual_commercial_cta['select_background_image']; ?>">
    <a href="<?php echo site_url(); ?>" class="cta_logo">
        <?php 
        if($visual_commercial_cta['select_logo'] == 'white_logo'){
            echo '<img src="'. get_stylesheet_directory_uri() .'/images/visual-commercial-cta-bg/alwaysVPN_logo_white.png" alt="logo" height="25" width="150">';
        } else {
            echo '<img src="/wp-content/uploads/2020/12/alwaysVPN_mainlogo.svg" alt="logo" height="25" width="150">';
        }
        ?>      
    </a>
    <div class="<?php echo $visual_commercial_cta['select_description_color']; ?>">
        <?php echo $visual_commercial_cta['description']; ?>
    </div>
    <div class="visual-cta-link-wrap">
         <a id="visual_creative_cta_" class="btn btn-lg btn-primary" href="<?php echo $visual_commercial_cta['commercial_cta_link']; ?>"><?php echo $visual_commercial_cta['commercial_cta_text']; ?></a>
    </div>
 </div>

 <?php
}