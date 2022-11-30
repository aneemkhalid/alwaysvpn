<?php
/**
 * Pros & Cons Block.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
?>
<?php 
$ShowPros = get_field("show_pros");
$ShowCons = get_field("show_cons");

// echo "<pre>"; print_r( $ShowPros ); echo "</pre>";
// echo "<pre>"; print_r( $ShowCons ); echo "</pre>";

if ( $ShowPros == "" ){
    $ShowPros = 1;
}

if ( $ShowCons == "" ){
    $ShowCons = 1;
}

?>
<div class="pros_cons">
<?php if ( $ShowPros == "1" ) { ?>
    <div class="pros">
        <h3><i class="fa fa-plus"></i>pros</h3>
        <?php if(get_field('pros_description')) {
            echo '<p>'.get_field('pros_description').'</p>'; 
        }?>
        <ul>
            <?php // Check rows exists.
                if( have_rows('pros') ):
                    while( have_rows('pros') ) : the_row();
                        $pros = get_sub_field('pros');
                        echo '<li>'.$pros.'</li>';
                    endwhile;
                else :
                    // Do something...
                endif; ?>
        </ul>
    </div>
<?php }?>

<?php if ( $ShowCons == "1" ) { ?>
    <div class="cons">
        <h3><i class="fa fa-minus"></i>cons</h3>
        <?php if(get_field('cons_description')){
            echo '<p>'.get_field('cons_description').'</p>';
        }?>
        <ul>
            <?php // Check rows exists.
                if( have_rows('cons') ):
                    while( have_rows('cons') ) : the_row();
                        $cons = get_sub_field('cons');
                        echo '<li>'.$cons.'</li>';
                    endwhile;
                else :
                    // Do something...
                endif; ?>
        </ul>
    </div>
<?php } ?>
</div>