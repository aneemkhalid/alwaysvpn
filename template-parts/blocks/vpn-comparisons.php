<?php

/**
 * VPN Comparisons Block.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$vpn_comparisons_title = get_field('vpn_comparisons_title');
$vpn_comparisons_description = get_field('vpn_comparisons_description');
$vpn_comparisons_image = get_field('vpn_comparison_image');
$select_vpns_for_pills = get_field('select_vpns_for_pills');
?>
<div class="vpn-comparison-tool-main">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="vpn-comparison-tool-content">
                    <?php if(!empty($vpn_comparisons_title)){ ?>
                        <h2><?php echo $vpn_comparisons_title; ?></h2>
                    <?php } else { ?>
                        <h2>VPN Comparison Tool</h2>
                    <?php } ?>
                    <p><?php echo $vpn_comparisons_description ?></p>
                </div>
            </div>
            <div class="col-md-5">
                <div class="img-wrap">
                    <img src="<?php echo $vpn_comparisons_image; ?>" alt="VPN-Comparison-tool-Img">
                </div>
            </div>
        </div>
        <div class="select-vpns-compare">
           <h4>Select up to 5 VPNs to compare</h4>
           <div class="vpns-list-wrap">
           <?php
            if($select_vpns_for_pills){
                foreach( $select_vpns_for_pills as $select_vpns ){
                    $selected_vpns[] = $select_vpns->ID;
                    ?>
                    <div class="select-vpn" data-id="<?php echo $select_vpns->ID; ?>">
                        <img class="add-to-compare" src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/Vector-1.svg" alt="add icon" height="21" width="25">
                        <img class="vpn-checked" src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/Vector-2.svg" alt="check icon" height="21" width="25">
                        <img class="vpn-removal" src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/Vector-3.svg" alt="remove icon" height="21" width="25">
                        <img class="add-to-compare-hover" src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/Vector-4.svg" alt="compare icon" height="21" width="25">
                        <span><?php the_field('vpn_name', $select_vpns->ID); ?></span>
                    </div>
                    <?php
                }
                $selected_vpns_arr = $selected_vpns;
            }else{
                $selected_vpns_arr = [49596, 49633, 49545, 49650, 49666, 50422, 50617, 50465];
                $args = array(  
                    'post_type' => 'reviews',
                    'post_status' => 'publish',
                    'posts_per_page' => -1,
                    'order' => 'ASC',
                    'post_name__in' => ['nordvpn', 'cyberghost', 'ipvanish', 'surfshark', 'private-internet-access', 'atlas-vpn', 'hola-vpn', 'purevpn']
                );
    
                $comparisons = new WP_Query( $args );
                while($comparisons->have_posts()){
                    $comparisons->the_post(); ?>
                    <div class="select-vpn" data-id="<?php echo get_the_ID(); ?>">
                        <img class="add-to-compare" src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/Vector-1.svg" alt="compare icon" height="21" width="25">
                        <img class="vpn-checked" src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/Vector-2.svg" alt="check icon" height="21" width="25">
                        <img class="vpn-removal" src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/Vector-3.svg" alt="remove icon" height="21" width="25">
                        <img class="add-to-compare-hover" src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/Vector-4.svg" alt="compare icon" height="21" width="25">
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
                    <img class="add-to-compare" src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/Vector-1.svg" alt="compare icon" height="21" width="25">
                    <img class="vpn-checked" src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/Vector-2.svg" alt="check icon" height="21" width="25">
                    <img class="vpn-removal" src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/Vector-3.svg" alt="remove icon" height="21" width="25">
                    <img class="add-to-compare-hover" src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/Vector-4.svg" alt="compare icon" height="21" width="25">
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
