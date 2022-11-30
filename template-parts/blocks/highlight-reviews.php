<?php

$title = get_field('title');
$reviews = get_field('reviews');
$trust = get_stylesheet_directory_uri() . '/images/icons/trust.svg';
$rating_0 = get_stylesheet_directory_uri() . '/images/icons/rating_0.svg';
$rating_1 = get_stylesheet_directory_uri() . '/images/icons/rating_1.svg';
$rating_2 = get_stylesheet_directory_uri() . '/images/icons/rating_2.svg';
$rating_3 = get_stylesheet_directory_uri() . '/images/icons/rating_3.svg';
$rating_4 = get_stylesheet_directory_uri() . '/images/icons/rating_4.svg';
$rating_5 = get_stylesheet_directory_uri() . '/images/icons/rating_5.svg';
?>

<section class="highlight-reviews-block">
    <div>
        <h2><?php echo $title ?></h2>
        <div class="review-carousel">
            <?php foreach($reviews as $item) : ?>
                <div class="carousel-cell">
                    <div>
                        <?php if($img = $item['logo_override']) : ?>
                            <img src="<?php echo $img['url'] ?>" class="logo" alt="<?php echo $img['alt'] ?>" width="66" height="16">
                        <?php else : ?>
                            <img src="<?php echo $trust ?>" class="logo" alt="trustpilot logo" width="66" height="16">
                        <?php endif; ?>
                    </div>
                    <h4><?php echo $item['title'] ?></h4>
                    <div class="content">
                        <?php echo $item['content'] ?>
                    </div>
                    <div><?php echo $item['name'] ?></div>
                    <div class="stars rating-<?php echo $item['rating'] ?>">
                        <img src="<?php echo get_stylesheet_directory_uri() . '/images/icons/rating_'. $item['rating'] .'.svg'; ?>" alt="star rating icon" width="104" height="20">
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>