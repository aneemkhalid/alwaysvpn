<?php

/**
 ** Styled Numbering Block.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$Sn_Number = get_field('sn_number');
$Sn_Heading = get_field('sn_heading');
$Heading_Style = get_field('heading_style');
$DebugInfo = false;

if ( $DebugInfo == true ){
    echo "<pre>"; print_r( "Sn_Number : " . $Sn_Number ); echo "</pre>";
    echo "<pre>"; print_r( "Sn_Heading : " . $Sn_Heading ); echo "</pre>";
    echo "<pre>"; print_r( "Heading_Style : " . $Heading_Style ); echo "</pre>";
}

$Styled_Number = '';
$Styled_Number .= '<div class="styled_number_element">';
$Styled_Number .= '     <span class="styled_number">' . $Sn_Number . '</span>';
$Styled_Number .= '     <' . $Heading_Style . ' class="styled_heading">' . $Sn_Heading . '</' . $Heading_Style . '>';
$Styled_Number .= '</div>';

echo $Styled_Number; ?>