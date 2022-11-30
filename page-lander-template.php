<?php
/**
 * Template Name: Custom Landing Page
 * Template Post Type: custom-partner-pages
 *
 * @package WordPress
 * @subpackage Coinflip_Child
 * @since Coinflip Child 1.0
 * 
 * The template for displaying custom landing page.
 *
 */

$id = get_field('provider');
$color = get_field('primary_color');
$vpn_logo = get_field('vpn_logo', $id);
$shield = get_stylesheet_directory_uri() . '/images/icons/vpn_shield.svg';
$hero_img = get_field('shield_override');

$highlight = get_field('highlight');

//Footer Nav
$footer = get_field('footer');
$menuLocs = get_nav_menu_locations();
$menuID = $menuLocs['footer_lander'];
$menu = wp_get_nav_menu_items($menuID);

//print_r($menu);

$menu_format = [];
$currParent = 0;

foreach($menu as $item) {
    if($item->menu_item_parent == 0) {
        $menu_format[$item->ID] = [
            'title' => $item->title,
            'url' => $item->url,
            'classes' => $item->classes,
            'target' => $item->target,
            'children' => [],
        ];
        $currParent = $item->ID;
    }
    if($item->menu_item_parent == $currParent) {
        $menu_format[$currParent]['children'][] = [
            'title' => $item->title,
            'url' => $item->url,
            'classes' => $item->classes,
            'target' => $item->target,
        ];
    }
}

//Deal Info
$coupon_fields = get_coupon_deal($id);
$expired = true;

if($coupon_fields) {
    $expired = false;
}

//print_r($coupon_fields);

$date = date_create($coupon_fields['expiration_date']);
$expire = date_format($date, 'm/d/y');

$deal_override = get_field('deal_override');

//Set defaults or overrides
$discount_detail = ($ddiscount = $deal_override['discount_detail']) ? $ddiscount : $coupon_fields['discount_detail'];
$title = ($dtitle = $deal_override['title']) ? $dtitle : $coupon_fields['title'];
$price = $deal_override['price'];
$cta_text = ($octatext = $deal_override['cta_text']) ? $octatext : 'Get this Deal';
$cta_link = ($octalink = $deal_override['cta_link']) ? $octalink : $coupon_fields['cta_link'];
$disclaimer = ($odisclaimer = $deal_override['disclaimer']) ? $odisclaimer : $coupon_fields['legal_copy'];
$logo = ($ologo = get_field('logo_override')) ? $ologo : $vpn_logo;

//print_r($deal_override);
//print_r($coupon_fields);
//print_r($logo);
get_header(); 
?>
<div id="primary">
    <div class="hero">
        <div class="container">
            <div class="logo-container">
                <?php echo  wp_get_attachment_image( $logo, 'full', null, array("class" => '')) ?>
            </div>
        </div>

        <div class="content-container">
            <div class="container">
                <div class="content">
                    <div class="inside">
                        <h1><?php echo $discount_detail ?></h1>
                        <p class="title"><?php echo $title ?></p>
                        <p class="price" style="color: <?php echo $color ?>;"><?php echo $price ?></p>
                        <?php if(!$expired) : ?>
                        <div class="cta-container">
                            <a href="<?php echo $cta_link ?>" target="_blank" style="background: <?php echo $color; ?>;"><?php echo $cta_text ?></a>
                        </div>
                        <?php endif; ?>
                        <?php if($disclaimer) : ?>
                        <p class="legal-container">
                            <?php echo $disclaimer ?>
                        </p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="icon">
                    <?php if($hero_img) : ?>
                        <img src="<?php echo $hero_img['url'] ?>" alt="<?php echo $hero_img['alt'] ?>" width="475" height="350">
                    <?php else: ?>
                        <img src="<?php echo $shield ?>" alt="vpn shield icon" width="475" height="350">
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php if($highlight['show']) : ?>
        <div class="highlight-container">
            <div class="container">
                <h3><?php echo $highlight['title'] ?></h3>
                <div class="logos-container">
                    <?php foreach($highlight['logos'] as $item) : ?>
                        <a href="<?php echo $item['link'] ?>" target="_blank">
                            <img src="<?php echo $item['logo']['url'] ?>" alt="<?php echo $item['logo']['alt'] ?>" height="25" width="auto">
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
    </div>

    <main>
        <div class="container">
            <?php echo the_content(); ?>
        </div>
    </main>

    <div class="footer">
        <div class="footer-content">
            <div class="bg-radial-gradient"></div>
            <div class="container">
                <div class="content">
                    <h2><?php echo $footer['title'] ?><span class="pricing-line" style="color: <?php echo $color; ?>;"><?php echo $price ?></span></h2>
                    <?php if(!$expired) : ?>
                    <div class="cta-container">
                        <a href="<?php echo $cta_link ?>" target="_blank" style="background: <?php echo $color; ?>;" class="cta-lander"><?php echo $cta_text ?></a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="footer-links">
            <div class="container">
                <div class="links">
                    <?php foreach($menu_format as $item) : ?>
                        <a href="<?php echo $item['url'] ?>" class="parent"><?php echo $item['title'] ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>


<?php echo wp_footer(); ?>