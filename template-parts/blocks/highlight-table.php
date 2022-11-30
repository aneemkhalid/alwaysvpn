<?php

global $post;  
$page_id = $post->ID;

$main =get_field('provider', $page_id);
//$color = ($pcolor = get_field('primary_color', $page_id)) ? $pcolor : get_field('highlight_color_override');
$color = ($ocolor = get_field('highlight_color_override')) ? $ocolor : get_field('primary_color', $page_id); 
$rgba = hex2rgba($color, 0.1);

//Get CTA Link
$coupon_fields = get_coupon_deal($main);
$deal_override = get_field('deal_override', $page_id);

$expired = true;

if($coupon_fields) {
    $expired = false;
}
//print_r($coupon_fields);

//Set defaults or overrides
$cta_text = ($octatext = $deal_override['cta_text']) ? $octatext : 'Get this Deal';
$cta_link = ($octalink = $deal_override['cta_link']) ? $octalink : $coupon_fields['cta_link'];

//Start getting table data
$title = get_field('title');
$fields = get_field('table_fields');
$vpns = get_field('providers');
if($main && $vpns) {
    array_unshift($vpns , $main);
    $vpnCount = count($vpns);
}

//Get logo and permalink
$vpn_info = [];
//Array for table info
$vpn_table = [];

if($vpns) :
    foreach($vpns as $id) {

        $vpn_name = get_field('vpn_name', $id);
        $vpn_info[] = [
            'logo' => get_field('vpn_logo', $id),
            'name' => $vpn_name,
        ];

        foreach($fields as $item) {
            $vpn_table[$item['field']['label']][] = get_field($item['field']['value'], $id);
        }
    }


    //print_r($vpn_info);
    //print_r($vpn_table);

    //Data transformations for table and unset empty items

    foreach($vpn_table as $arr => &$value) {
        $filter = array_filter($value);
        //Unset subarray if completely empty
        if(empty($filter)) {
            unset($vpn_table[$arr]);
        }
        //Change customer support links to actual link
        if($arr == 'Customer Support') {
            foreach($value as &$val) {
                if($val) {
                    if(preg_match('/^(\+|\(|\d)/', $val)) {
                        $val = '<a href="tel:'. $val .'" target="_blank">Support</a>';
                    }
                    elseif(preg_match('/^[A-z0-9_\-]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z.]{2,4}$/', $val)) {
                        $val = '<a href="mailto:'. $val .'" target="_blank">Support</a>';
                    }
                    else {
                        $val = '<a href="'. $val .'" target="_blank">Support</a>';
                    }
                }
            }
        }
        if($arr == 'Protocols') {
            foreach($value as &$val) {
                if($val) {
                    $val = count($val);
                }
            }
        }
        if($arr == 'Logging') {
            foreach($value as &$val) {
                ($val == 'Yes') ? 1 : '';
            }
        }
        foreach($value as &$val) {
            //echo $val;
            if($val == '1') {
                $val = '<svg xmlns="http://www.w3.org/2000/svg" class="compare-checkmark" viewBox="0 0 20 20" height="20" width="20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>';
            }
            elseif($val == '0') {
                $val = 'No';
            }
            elseif($val == false) {
                $val = '--';
            }
            
        }
        unset($val);
        
    }
endif;



//print_r($fields);
// echo '<pre>';
// print_r($vpn_table);
// echo '</pre>';
?>

<section class="highlight-table-block">
    <div>
        <h2><?php echo $title ?></h2>

        <div class="vpn-table-container">
        

            <div class="compare-table-container">
                <div class="swipe-text">swipe to see all</div>
                <div class="table-scroll-container <?php echo ($expired) ? 'expired' : ''; ?>">
                    <div class="gradient-right"></div>
                    <table class="highlight-table carousel-cell">
                        <thead>
                            <tr>
                                <th class="table-key" style="color: white">Table Keys</th>
                            <?php $i = 1; foreach($vpn_info as $val) : ?>
                                <th class="column-<?php echo $i ?>" style="--rgba: <?php echo $rgba ?>; --color: <?php echo $color ?>;">
                                    <div class="vpn-logo-container">
                                        <?php echo wp_get_attachment_image($val['logo'], 'full'); ?>
                                    </div>
                                </th>
                            <?php $i++; endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($vpn_table as $key => $items) : ?>
                                <tr>
                                    <td class="table-key">
                                        <div><?php echo $key ?></div>
                                    </td>
                                    <?php $i = 1; foreach($items as $item) : ?>
                                        <td class="column-<?php echo $i ?>" style="--rgba: <?php echo $rgba ?>; --color: <?php echo $color ?>;">
                                            <?php echo $item ?>
                                        </td>
                                    <?php $i++; endforeach; unset($item);?>
                                </tr>
                            <?php endforeach; ?>
                            <?php if(!$expired) : ?>
                                <tr class="last-row">
                                    <td class="table-key" style="color: white">
                                        <div>Button Row</div>
                                    </td>
                                    <td class="cta-td" style="--rgba: <?php echo $rgba ?>; --color: <?php echo $color ?>;">
                                        <a href="<?php echo $cta_link ?>" target="_blank" style="background: <?php echo $color; ?>;"><?php echo $cta_text ?></a>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <?php if(!$expired) : ?>
                    <div class="cta-container">
                        <a href="<?php echo $cta_link ?>" target="_blank" style="background: <?php echo $color; ?>;" class="cta-lander"><?php echo $cta_text ?></a>
                    </div>
                <?php endif; ?>

            </div>
        
        </div>
    </div>
</section>