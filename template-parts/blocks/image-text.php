<?php
/**
 * Image/Text Block
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$content = get_field('content');
$image = get_field('image');
$pos = ($side = get_field('image_position')) ? 'img-left' : 'img-right';


?>

<div class="image-text-block py-4 <?php echo $pos ?>">
    <div class="container px-md-0">
        <div class="row mx-md-0">
          <div class="col-12 p-0 img-container col-md-6 col-lg-6 mb-3 mb-md-0">
            <div class="d-flex justify-content-center h-100">
              <?php
                if ($image):
                  echo wp_get_attachment_image( $image['ID'], 'large',  );
                endif; 
              ?>  
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-6 content-container d-md-flex align-items-md-center px-0">
            <div class="content">
              <?php echo $content; ?>
            </div>
          </div>
        </div>
    </div> 
</div>
