<?php

/**
 * How We Evaluate Block
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$evaluate_group = get_field('evaluate_group');

if(is_array($evaluate_group)):
?>

<div class="how-we-evaluate-main">
    <div class="container">
        <h2><?php echo $evaluate_group['evaluate_title']; ?></h2>
        <div class="row">
            <?php 
            $evaluate_block_1 = $evaluate_group['evaluate_block_1'];
            if(is_array($evaluate_block_1)):
            ?>
            <div class="col-md-3 col-sm-6">    
                <div class="how-we-evaluate-tile">
                    <div class="icon-wrap">
                        <?php if(!empty($evaluate_block_1['icon_image'])) { ?>
                            <img src="<?php echo $evaluate_block_1['icon_image']['url']; ?>" height="36" width="36" alt="<?php echo $evaluate_block_1['icon_image']['alt']; ?>">
                        <?php } else { ?>
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/value-prop.svg" alt="value prop" height="36" width="36">
                        <?php } ?>
                    </div>
                    <h4><?php echo $evaluate_block_1['title']; ?></h4>
                    <p><?php echo $evaluate_block_1['description']; ?></p>
                </div>
            </div>
            <?php endif; ?>
            <?php 
            $evaluate_block_2 = $evaluate_group['evaluate_block_2'];
            if(is_array($evaluate_block_2)):
            ?>
            <div class="col-md-3 col-sm-6">   
                <div class="how-we-evaluate-tile">
                    <div class="icon-wrap">
                        <?php if(!empty($evaluate_block_2['icon_image'])) { ?>
                                <img src="<?php echo $evaluate_block_2['icon_image']['url']; ?>" height="36" width="36" alt="<?php echo $evaluate_block_2['icon_image']['alt']; ?>">
                            <?php } else { ?>
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/helpful-tool.svg" alt="helpful tool" height="36" width="36">
                        <?php } ?>
                    </div>
                    <h4><?php echo $evaluate_block_2['title']; ?></h4>
                    <p><?php echo $evaluate_block_2['description']; ?></p>
                </div>
            </div>
            <?php endif; ?>
            <?php 
            $evaluate_block_3 = $evaluate_group['evaluate_block_3'];
            if(is_array($evaluate_block_3)):
            ?>
            <div class="col-md-3 col-sm-6">   
                <div class="how-we-evaluate-tile">
                        <div class="icon-wrap">
                        <?php if(!empty($evaluate_block_3['icon_image'])) { ?>
                            <img src="<?php echo $evaluate_block_3['icon_image']['url']; ?>" height="36" width="36" alt="<?php echo $evaluate_block_3['icon_image']['alt']; ?>">
                        <?php } else { ?>
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/why-you-need-a-vpn.svg" alt="need a vpn" height="36" width="36">
                        <?php } ?>
                    </div>
                    <h4><?php echo $evaluate_block_3['title']; ?></h4>
                    <p><?php echo $evaluate_block_3['description']; ?></p>
                </div>
            </div>
            <?php endif; ?>
            <?php 
            $evaluate_block_4 = $evaluate_group['evaluate_block_4'];
            if(is_array($evaluate_block_4)):
            ?>
            <div class="col-md-3 col-sm-6">   
                <div class="how-we-evaluate-tile">
                    <div class="icon-wrap">
                    <?php if(!empty($evaluate_block_4['icon_image'])) { ?>
                            <img src="<?php echo $evaluate_block_4['icon_image']['url']; ?>" height="36" width="36" alt="<?php echo $evaluate_block_4['icon_image']['alt']; ?>">
                        <?php } else { ?>
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/icons/expert-info.svg" alt="expert info" height="36" width="36">
                        <?php } ?>
                    </div>
                    <h4><?php echo $evaluate_block_4['title']; ?></h4>
                    <p><?php echo $evaluate_block_4['description']; ?></p>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php 
endif;
?>