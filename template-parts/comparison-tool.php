<div class="compare-container">
        <div class="container comp-item-container">
            <?php foreach($comp_data as $comp) : ?>
                <div class="comp-item">
                    <div class="logo">
                        <a href="<?php echo $comp['link'] ?>">
                            <?php echo wp_get_attachment_image( $comp['logo'], 'full' ); ?>
                        </a>
                    </div>
                    <div class="pros-cons-container">
                        <div class="pros-container">
                            <?php foreach($comp['pros'] as $pro) : ?>
                                <div class="pro-item">
                                    <img src="<?php echo get_stylesheet_directory_uri() . '/images/icons/check-circle.svg'; ?>" alt="check-circle" height="18" width="18">
                                    <?php echo $pro['pros'] ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="cons-container">
                            <?php foreach($comp['cons'] as $con) : ?>
                                <div class="con-item">
                                    <img src="<?php echo get_stylesheet_directory_uri() . '/images/icons/cancel-circle.svg'; ?>" alt="cancel-circle" height="18" width="18">
                                    <?php echo $con['cons'] ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="btn-container">
                        <a href="<?php echo $comp['link'] ?>" class="review-btn" onclick="<?php echo $comp['datalayer'] ?>">Read our Review</a>
                        <button class="compare-blue-btn" data-id="<?php echo $comp['id'] ?>" data-image="<?php echo $comp['image'] ?>">
                            <img src="<?php echo get_stylesheet_directory_uri() . '/images/icons/compare-cancel.svg'; ?>" alt="compare-cancel" height="30" width="30">
                            <span>COMPARE</span>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="vpn-compare-footer">
        <div class="container">
            <div class="compare-text">SELECT UP TO 5 VPNS TO COMPARE</div>
            <div class="slider-mobile">
                <div class="vpn-slider-container">
                    <div class="vpn-slider">


                        <?php for($i = 0; $i < 6; $i++) : ?>
                            <button class="vpn-item-container">
                                <div></div>
                            </button>
                        <?php endfor; ?>

            
                    </div>
                </div>
                <div class="btn-container">
                    <button class="compare-red-btn">COMPARE</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        <?php echo $vpn_prod_impress_wrap; ?>
    </script>