<?php 
   // var_dump($args); 
    $data = $args['data'];
?>

<div class="resource-side-item <?php echo $data['item_class']; ?>">
    <div class="content-container">
        <div>
            <?php echo wp_get_attachment_image( $data['img'], 'full' ); ?>
        </div>
        <div class="inside-content">
            <h4><?php echo do_shortcode($data['title']) ?></h4>
            <?php  if( array_key_exists('expire', $data)) :  ?>
                <div class="expire">Expires <?php echo $data['expire']; ?></div>
            <?php endif; ?>
            <?php if( array_key_exists('price', $data)) : ?>
                <div class="lowest-price">Lowest Price: <span><?php echo $data['price'] ?></span></div>
            <?php endif; ?>
            <div class="description">
                <?php echo $data['desc'] ?>
            </div>
            <div>
                <a href="<?php echo $data['cta_link'] ?>" target="<?php echo $data['cta_target']?>" class="btn btn-primary <?php echo $data['cta_class'] ?>"><?php echo $data['cta_text'] ?></a>
            </div>
            <?php  if( array_key_exists('legal_cta', $data)) :  ?>
                <?php echo $data['legal_cta']; ?>
            <?php endif; ?>
        </div>
    </div>
</div>