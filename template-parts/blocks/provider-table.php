<?php

/**
 * Provider Table.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
$table_providers = get_field('table_providers');
$table_data = get_field('table_data');
$table_description_table = get_field('table_description');
?>
<section class="customizable-table-wrap">
    <div class="customizable-table">
        <?php if($table_providers){ ?>
            
            <style type="text/css">
                @media only screen and (max-width: 767px) {
                    .customizable-table table td:nth-of-type(1):before { content: "VPN"; }
                    <?php $a = 2;
                    foreach ($table_data as $tData) {                        
                        echo '.customizable-table table td:nth-of-type(' . $a . '):before { content: "' . $tData['table_column_name'] . '"; }';
                        $a++;
                    } ?>                    
                }
            </style>

            <?php
            $table = ''; $table_th = ''; $table_td = '';
            $table_th = '           <tr>';
            $table_th .= '           <th>VPN</th>';
            foreach ($table_data as $tData) {
                $table_th .= '          <th>'.$tData['table_column_name'].'</th>';
            }
            $table_th .= '           </tr>';
            foreach ($table_providers as $table_provider) { 
                $pID = $table_provider['providers'];
                $link_type = $table_provider['select_link_type'];
                
                if($link_type == "tracking_link"){
                    $link =  $table_provider['provider_table_link'];
                } else {
                    $link = get_the_permalink($pID);
                }
                $table_td .= '      <tr>';
                $table_td .= '          <td><a href="' . $link . '" target="_blank" >'.get_field('vpn_name', $pID).'</a></td>';
                foreach ($table_data as $tData) {
                    if($tData['select_data_field'] == 'lowest_price'){
                        $tdData = '$'.get_field($tData['select_data_field'],$pID);
                    }else{
                        $tdData = get_field($tData['select_data_field'],$pID);
                    }
                    $table_td .= '          <td>'.$tdData.'</td>';
                }
                $table_td .= '      </tr>';
            }
            $table .= '<table>';
            $table .= ' <thead>';
            $table .= $table_th;
            $table .= ' </thead>';
            $table .= ' <tbody>';
            $table .= $table_td;
            $table .= ' </tbody>';
            $table .= '</table>';
            echo $table;
            echo '<figcaption>' . $table_description_table . '</figcaption>';
       }?>
       
        <?php /*
        <table>
            <thead>
                <tr>
                <?php 
                    echo '<th>Provider</th>';
                    foreach ($table_data as $tData) {
                        echo '<th>'.$tData['table_column_name'].'</th>';
                    }   
                ?>
                </tr>
            </thead>
            <tbody>
            <?php 
            if($select_provider){
                foreach ($select_provider as $key => $pID) {
                    echo '<tr>';
                    echo '<td>'.get_the_title($pID).'</td>';
                    foreach ($table_data as $tData) {
                        echo '<td>'.get_field($tData['select_data_field'],$pID).'</td>';
                    }
                    echo '</tr>';
                }
            }
            ?>
            </tbody>
        </table>
        */ ?>
    </div>
    <?php echo $table_description_table; ?>
</section>