<?php

/**
 * Editor's Picks Block.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$editors_picks_title = get_field('editors_picks_title');
$editors_picks_description = get_field('editors_picks_description');
$editors_picks = get_field('editors_picks_group');

$positionNumEditorPicks = 0;
$priceNumbEditorPicks = 00.01;
$homepageAllHolder = '';
if(is_array($editors_picks)):
?>

<div class="editors-pick-main">
     <div class="container">
     <a href="disclosure" class="advertiser_disclosure">Advertiser Disclosure</a>
        <div class="editors-pick-head">
           <h2><?php echo $editors_picks_title; ?></h2>
           <a class="btn btn-link btn-sm view-all" href="reviews">View All Reviews </a>
           <p><?php echo $editors_picks_description; ?></p> 
           <div class="row">
        <?php foreach($editors_picks as $pick):
            $superlative_title = $pick['superlative_title'];
            $short_description = $pick['short_description'];
            $pick_obj = get_post($pick['editors_choice']);
            $url = get_permalink($pick_obj);
            $vpn_title = $pick_obj->post_title;
            $vpn_logo_id = get_post_meta($pick_obj->ID, 'vpn_logo', true);
            $vpn_name = get_post_meta($pick_obj->ID, 'vpn_name', true);


            $positionNumEditorPicks++; 

            $idNumVPN = getTrackingLinkInfo($pick_obj->ID, 'offer_id');
            
            
            $editorPickOnClick = dataLayerProductClick("Homepage Editors Pick of 2021", $vpn_name, $idNumVPN, $superlative_title, "editor_picks", $positionNumEditorPicks );
      
            $homepageIndv = dataLayerProductImpression($vpn_name, $pick_obj->ID, $superlative_title, "Homepage", "editor_picks", "Homepage Editors Pick of 2021", $positionNumEditorPicks );

            $homepageAllHolder .= $homepageIndv;
            ?>
            <div class="col-sm-6">
                <div class="editor-pick-box">
                    <div class="editor-pick-box-inner">
                        <div class="logo-wrap">
                        <a href="<?php echo $url; ?>"><img src="<?php echo wp_get_attachment_image_url($vpn_logo_id); ?>" alt="" width="260" height="50"></a>
                        </div>
                        <h5><?php echo $superlative_title; ?></h5>
                        <p><?php echo $short_description; ?></p>
                    </div>
                    <a class="btn btn-primary  btn-lg" href="<?php echo $url; ?>"><?php echo $vpn_title; ?></a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        </div>
        
    </div>
    <?php
       $homepageOnLoad = dataLayerProductImpressionWrapper($homepageAllHolder); ?>
    <script>
    <?php echo $homepageOnLoad ; ?>
    </script> 
</div>

<?php
endif;
