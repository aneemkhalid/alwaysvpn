<?php

$template = array(

);
?>

<section class="commercial-bottom-block">
    <div class="admin-instructions">
        <h2>Commercial Bottom Blocks</h2>
        <p>Add new blocks within this block to appear below vpn list.</p>
        <hr />
    </div>
    <InnerBlocks template="<?php echo esc_attr( wp_json_encode( $template )) ?>"/>
</section>


