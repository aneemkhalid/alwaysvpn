<?php

/**
 * FAQ Block.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$faq_list = get_field('faq_list');
$faq_list_json = json_encode($faq_list);

if(is_array($faq_list)):
?>
<div class="row">
    <div class="col-md-12 faq-list-content">
        <ul class="faq-list">
            <?php foreach($faq_list as $i => $faq):
                $anchor_link = convert_string_to_anchor_link( $faq['question'] );
            ?>
                
                <li class="faq-list-item"><a href="#<?php echo $anchor_link; ?>"><?php echo $faq['question']; ?></a></li>
                
            <?php endforeach; ?>
        </ul>
    </div>
    <main id="main" class="col-md-12 site-main main-content">
        <?php foreach($faq_list as $i => $faq):
            $anchor_link_target = convert_string_to_anchor_link( $faq['question'] );
        ?>
                    
            <h3 id="<?php echo $anchor_link_target; ?>" class="faq-title"><?php echo $i + 1 ?>. <?php echo $faq['question']; ?></h3>
            <?php echo $faq['answer'] ?>
                    
        <?php endforeach; ?>
    </main>
</div>

<script>

    const FAQListBlockInfo =  <?php echo $faq_list_json; ?>;
   
</script>
<?php endif; ?>
