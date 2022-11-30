<?php

$template = array(

);
?>

<section class="commercial-top-block">
    <div class="admin-instructions">
        <h2>Commercial Top Blocks</h2>
        <p>Add new blocks within this block to appear above our picks.</p>
        <hr />
    </div>
    <InnerBlocks template="<?php echo esc_attr( wp_json_encode( $template )) ?>"/>
</section>


