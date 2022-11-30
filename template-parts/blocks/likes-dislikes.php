<?php

/**
 * Likes Dislikes Block.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$likes = get_field('likes');
$dislikes = get_field('dislikes');
$ltitle = get_field('likes_title');
$dtitle = get_field('dislike_title');

$check = get_stylesheet_directory_uri() . '/images/icons/check.svg';
$close = get_stylesheet_directory_uri() . '/images/icons/close.svg';

?>

<section class="likes-dislikes-block">
    <div class="comp-container">
        <div class="likes-container">
            <h3><?php echo $ltitle ?></h3>
            <div>
                <?php foreach($likes as $item) : ?>
                    <div class="like-item">
                        <div class="icon-container">
                            <img src="<?php echo $check ?>" alt="check icon" height="32" width="32">
                        </div>
                        <div>
                            <?php echo $item['bullet'] ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="dislikes-container">
            <h3><?php echo $dtitle ?></h3>
            <div>
                <?php foreach($dislikes as $item) : ?>
                    <div class="like-item">
                        <div class="icon-container">
                            <img src="<?php echo $close ?>" alt="close icon" height="32" width="32">
                        </div>
                        <div>
                            <?php echo $item['bullet'] ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>