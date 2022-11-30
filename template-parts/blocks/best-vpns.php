<?php

/**
 * Best VPNs Block.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$best_vpns = get_field('best_vpns_group');
$best_vpns_title = get_field('best_vpns_title');
$best_vpns_description = get_field('best_vpns_description');
$best_vpns_anchor_link = get_field('best_vpns_anchor_link');

if(is_array($best_vpns)):
?>
<div id="<?php echo $best_vpns_anchor_link; ?>">
    <div class="best-vpns-container container-width">
        <div class="best-vpns-title-container">
            <h2 class="best-vpns-title">
                <?php echo $best_vpns_title; ?>
            </h2>
        </div>
        <div class="header-separator"></div>
        <div class="best-vpns-text-container">
            <p class="best-vpns-text">
                <?php echo $best_vpns_description; ?>
            </p>
        </div>
        <div class="best-vpns-blocks">
            <?php foreach($best_vpns as $vpn): ?>
                <a href="<?php echo $vpn['best_vpn_link']; ?>" class="best-vpns-block">
                    
                        <div class="best-vpns-block-image-container">
                            <img src="<?php echo $vpn['best_vpn_icon']; ?>" alt="<?php echo $vpn['best_vpn_title']; ?>" class="best-vpns-block-image">
                        </div>
                        <div class="best-vpns-block-text-container">
                            <div>
                                <div class="best-vpns-block-title-container">
                                    <?php echo $vpn['best_vpn_title']; ?>
                                </div>
                                <div class="best-vpns-block-description-container">
                                    <?php echo $vpn['best_vpn_description']; ?>
                                </div>
                            </div>
                            <div class="best-vpns-block-link-container">
                                See <?php echo $vpn['best_vpn_title']; ?> VPNs <i class="fa fa-long-arrow-right"></i>
                            </div>
                        </div>
                    
                </a>
            <?php endforeach; ?>
        </div>
        <div class="best-vpns-cta-link-container">
            <a href="/best-vpn">See Best VPNs Overall <i class="fa fa-long-arrow-right"></i></a>
        </div>
    </div>
</div>

<?php endif; ?>
