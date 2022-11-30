<?php

/**
 * Why Use a VPN Block.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$frontpage_intro_title = get_field('frontpage_intro_title');
$frontpage_intro_content = get_field('frontpage_intro_content');
$frontpage_intro_cta_text = get_field('frontpage_intro_cta_text');
$frontpage_intro_cta_link = get_field('frontpage_intro_cta_link');
$frontpage_intro_blocks = get_field('frontpage_intro_block');
$frontpage_intro_anchor_link = get_field('frontpage_intro_anchor_link');

if(is_array($frontpage_intro_blocks)):
?>

<div class="home-banner-main">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-7">
                <div class="home-banner-content">
                    <h1><?php echo $frontpage_intro_title; ?></h1>
                    <p><?php echo $frontpage_intro_content; ?></p>
                    <a class="btn btn-primary " href="<?php echo $frontpage_intro_cta_link; ?>"><?php echo $frontpage_intro_cta_text; ?></a>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="img-wrap">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/VPN-protection-hero-image.svg" alt="banner-img" width="416" height="262">   
                </div>
            </div>                    
        </div>
    </div>
</div>
<div class="intro-tiles-wrap">
    <div class="container">
        <div class="intro-tiles">
            <?php foreach($frontpage_intro_blocks as $intro_block): ?>
            <div class="intro-tile-box">
                <a href="<?php echo $intro_block['url']; ?>" class="intro-tile">
                    <img src="<?php echo $intro_block['image']; ?>" alt="<?php echo $intro_block['title_2']; ?>-icon" width="40" height="50">
                    <img class="hover_image" src="<?php echo $intro_block['hover_image']; ?>" alt="<?php echo $intro_block['title_2']; ?>-icon" width="40" height="50">
                    <p><?php 
                    if( !empty($intro_block['title_1']) ) {
                    echo $intro_block['title_1']; 
                    } else {
                        echo "Best VPN for";
                    }
                    ?></p>
                    <h4><?php echo $intro_block['title_2']; ?></h4>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php endif; ?>

