<?php

global $post;  
$page_id = $post->ID;

$id = get_field('provider', $page_id);
$coupon_fields = get_coupon_deal($id);
$expired = true;

if($coupon_fields) {
    $expired = false;
}

$deal_override = get_field('deal_override', $page_id);

//print_r($coupon_fields);

//Set defaults or overrides
$cta_text = ($octatext = $deal_override['cta_text']) ? $octatext : 'Get this Deal';
$cta_link = ($octalink = $deal_override['cta_link']) ? $octalink : $coupon_fields['cta_link'];

$features = get_field('features');
$title = get_field('title');
$color = get_field('primary_color', $page_id);
?>

<section class="highlight-feature-block">
    <div>
        <h2><?php echo $title ?></h2>
        <div class="feature-container">
            <?php foreach($features as $item) : ?>
                <div class="item">
                    <div class="img-container">
                        <img src="<?php echo $item['icon']['url'] ?>" alt="<?php echo $item['icon']['alt'] ?>" height="64" width="64">
                    </div>
                    <div class="content-container">
                        <h5><?php echo $item['title'] ?></h5>
                        <div class="content"><?php echo $item['content'] ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php if(!$expired) : ?>
        <div class="cta-container">
            <a href="<?php echo $cta_link ?>" target="_blank" style="background: <?php echo $color; ?>;" class="cta-lander"><?php echo $cta_text ?></a>
        </div>
        <?php endif; ?>
    </div>
</section>