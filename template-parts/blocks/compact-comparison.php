<?php

/**
 * Compact Comparison Block
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$compact_comparisons_title = get_field('compact_comparisons_title');
$compact_comparisons_description = get_field('compact_comparisons_description');
$select_compact_vpns_for_pills = get_field('select_compact_vpns_for_pills');
?>
<div class="vpn-comparison-tool-main compact-comparison">
    <div class="container">
        <div class="compact-comparison-inner">
            <div class="vpn-comparison-tool-content">
                <?php if(!empty($compact_comparisons_title)){ ?>
                    <h2><?php echo $compact_comparisons_title; ?></h2>
                <?php } else { ?>
                    <h2>VPN Comparison Tool</h2>
                <?php } ?>
                <?php if(!empty($compact_comparisons_description)){ ?>
                    <p><?php echo $compact_comparisons_description; ?></p>
                <?php } else { ?>
                    <p>Before picking a provider, use our VPN Comparison Tool to find the best fit for your needs. Choose up to five VPNs at once to compare their features and pricing side-by-side.</p>
                <?php } ?>
            </div>
            <div class="select-vpns-compare">
                <h4>Select up to 5 VPNs to compare</h4>
                <div class="vpns-list-wrap">
                <?php
                    if($select_compact_vpns_for_pills){
                        foreach( $select_compact_vpns_for_pills as $select_vpns ){
                            $selected_vpns[] = $select_vpns->ID;
                            ?>
                            <div class="select-vpn" data-id="<?php echo $select_vpns->ID; ?>">
                                <img class="add-to-compare" src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/Vector-1.svg">
                                <img class="vpn-checked" src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/Vector-2.svg">
                                <img class="vpn-removal" src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/Vector-3.svg">
                                <img class="add-to-compare-hover" src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/Vector-4.svg">
                                <span><?php the_field('vpn_name', $select_vpns->ID); ?></span>
                            </div>
                            <?php
                        }
                        $selected_vpns_arr = $selected_vpns;
                    }else{
                        $selected_vpns_arr = [49596, 49633, 49545, 49650, 49666, 53078, 49664 ];
                        $args = array(  
                            'post_type' => 'reviews',
                            'post_status' => 'publish',
                            'posts_per_page' => -1,
                            'order' => 'ASC',
                            'post_name__in' => ['nordvpn', 'cyberghost', 'ipvanish', 'surfshark', 'private-internet-access', 'strongvpn', 'expressvpn']
                        );
            
                        $comparisons = new WP_Query( $args );
                        while($comparisons->have_posts()){
                            $comparisons->the_post(); ?>
                            <div class="select-vpn" data-id="<?php echo get_the_ID(); ?>">
                                <img class="add-to-compare" src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/Vector-1.svg">
                                <img class="vpn-checked" src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/Vector-2.svg">
                                <img class="vpn-removal" src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/Vector-3.svg">
                                <img class="add-to-compare-hover" src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/Vector-4.svg">
                                <span><?php the_field('vpn_name', get_the_ID()); ?></span>
                            </div>
                            <?php
                        }
                        wp_reset_postdata();
                    }
                    $args = array(  
                        'post_type' => 'reviews',
                        'post_status' => 'publish',
                        'posts_per_page' => -1,
                        'order' => 'ASC',
                        'post__not_in' => $selected_vpns_arr
                    );

                    $comparisons2 = new WP_Query( $args );
                    while($comparisons2->have_posts()){
                        $comparisons2->the_post();
                        ?>
                        <div class="select-vpn btn_sh_vpn" data-id="<?php echo get_the_ID(); ?>">
                            <img class="add-to-compare" src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/Vector-1.svg">
                            <img class="vpn-checked" src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/Vector-2.svg">
                            <img class="vpn-removal" src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/Vector-3.svg">
                            <img class="add-to-compare-hover" src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/Vector-4.svg">
                            <span><?php the_field('vpn_name', get_the_ID()); ?></span>
                        </div>
                        <?php 
                    }
                    wp_reset_postdata();
                    ?>
                    </div>
                <div class="show-hide-vpns-wrap">
                    <a href="javascript:void(0)" class="show-hide-vpns">
                        <span class="show-vpns">+ Show more VPNs</span>
                        <span class="hide-vpns">- Hide VPNs</span>
                    </a>
                </div>
                <button class="btn btn-primary vpn-btn" >Compare VPNs</button>
            </div>
        </div>
    </div>
</div>