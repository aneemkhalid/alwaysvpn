<?php

/**
 * Disclaimer Block.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
 $disclaimer_text = get_field('disclaimer_text');
if($disclaimer_text):
?>
    <div class="disclaimer">
        <?php echo '<p><span>Disclaimer: </span>'.$disclaimer_text.'<a href="'.site_url('disclosure').'"> Learn how.</a></p>'; ?>
    </div>
<?php
endif;