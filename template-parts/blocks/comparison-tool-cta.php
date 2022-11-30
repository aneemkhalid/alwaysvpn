<?php

/**
 * Comparison Tool CTA
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */


$comparison_tool_cta = get_field('comparison_tool_cta');
if($comparison_tool_cta) {
?>
 <div class="visual-creative-cta generic comparison-tool <?php echo $comparison_tool_cta['select_background_image']; ?>">
    <a href="<?php echo site_url(); ?>" class="cta_logo">
        <?php 
        if($comparison_tool_cta['select_logo'] == 'white_logo'){
            echo '<img src="'. get_stylesheet_directory_uri() .'/images/visual-commercial-cta-bg/alwaysVPN_logo_white.png" alt="logo">';
        } else {
            echo '<img src="wp-content/uploads/2020/12/alwaysVPN_mainlogo.svg" alt="logo">';
        }
        ?>      
    </a>
    <div class="<?php echo $comparison_tool_cta['select_description_color']; ?>">
        <?php echo $comparison_tool_cta['description']; ?>
    </div>
    <div class="visual-cta-link-wrap">
        <?php
        if(!empty($comparison_tool_cta['commercial_cta_link'])) { ?>
        <a id="comparison-tool_cta_<?php echo $creativeProvider; ?>" class="btn btn-lg btn-primary" href="<?php echo $comparison_tool_cta['commercial_cta_link']; ?>"><?php echo $comparison_tool_cta['commercial_cta_text']; ?></a>
        <?php } else { ?>
        <a id="comparison-tool_cta_<?php echo $creativeProvider; ?>" class="btn btn-lg btn-primary" href="tools/comparison-tool"><?php echo $comparison_tool_cta['commercial_cta_text']; ?></a>
        <?php } ?>
    </div>
 </div>

 <?php
}