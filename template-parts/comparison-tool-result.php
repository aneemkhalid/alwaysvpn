<div class="compare-result-container vpn-count-<?php echo $vpnCount ?>">
    <div class="container">
        <div class="result-logos mobile">
            <?php foreach($vpn_info as $vpn) : ?>
                <a href="<?php echo $vpn['link'] ?>" target="_blank" class="vpn-linkout" onclick="<?php echo $vpn['click'] ?>">
                    <div class="logo-container">
                        <?php echo wp_get_attachment_image($vpn['logo'], 'full'); ?>
                    </div>
                    <div class="name-container">
                        Visit <?php echo $vpn['name'] ?>
                    </div>
                </a>
            <?php endforeach; ?>
            <div class="compare-return-container">
                <a href="<?php echo get_permalink() ?>" class="compare-return-btn">Compare Other VPNs</a>
            </div>
        </div>
    </div>

    <div class="results-bar-container">
        <div class="container">
            <div class="results-bar desktop">
                <table>
                    <tr>
                        <td class="title">
                            <h2><?php echo $title ?></h2>
                            <a href="<?php echo get_permalink() ?>" class="compare-return-btn">Compare Other VPNs</a>
                        </td>
                        <?php foreach($vpn_info as $vpn) : ?>
                            <td>
                                <a href="<?php echo $vpn['link'] ?>" target="_blank" class="vpn-linkout" onclick="<?php echo $vpn['click'] ?>">
                                    <div class="logo-container">
                                        <?php echo wp_get_attachment_image($vpn['logo'], 'full'); ?>
                                    </div>
                                    <div class="name-container">
                                        Visit <?php echo $vpn['name'] ?>
                                    </div>
                                </a>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="vpn-table-container">
            <?php foreach($vpn_table as $table => $item) :  ?>
                <?php 
                $table_slug = slugify($table);
                $total_rows = count($item);
                $view_more = false;
                if ($total_rows > 2){
                    $view_more = true;
                }
                ?>
                <div class="compare-table-container">
                    <div class="swipe-text mb-1">swipe to see all</div>
                    <div class="table-scroll-container">
                        <div class="gradient-right"></div>
                        <div class="table-scroll carousel drag">
                            <table class="carousel-cell rounded-top-10 <?php echo (!$view_more) ? 'rounded-bottom-10 no-view-more' : ''; ?>">
                                <tbody>
                                <tr>
                                    <td class="table-key"><?php echo $table ?></td>
                                    <?php foreach($vpn_info as $val) : ?>
                                        <td>
                                            <a class="vpn-logo-container" href="<?php echo $vpn['link'] ?>" target="_blank" onclick="<?php echo $vpn['click'] ?>">
                                                <?php echo wp_get_attachment_image($val['logo'], 'full'); ?>
                                            </a>
                                        </td>
                                    <?php endforeach; ?>
                                </tr>
                                <?php $table_row_count = 1; ?>
                                <?php foreach($item as $key => $value) : ?>
                                    <?php  if($table_row_count == 3) : ?>
                                    </tbody>
                                    <tbody class="collapse-item">
                                    <?php  endif; ?>
                                        <tr>
                                            <td class="table-key"><?php echo $key ?></td>
                                            <?php foreach($value as $val) : ?>
                                                <td>
                                                    <?php echo $val ?>
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>
                                    <?php $table_row_count++; ?>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php if ($view_more): ?>
                        <div class="view-more-collapse rounded-bottom-10 pt-2 pb-2">
                            <span>View More</span>
                            <svg class="ml-1" width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 1L6 6L11 1" stroke="#006ADE" stroke-width="1.5"/>
                            </svg>
                        </div>
                    <?php endif; ?>

                </div>
            <?php endforeach; ?>
        
    </div>

    <div class="cta-bar-container">
        <div class="container">
            <div class="cta-bar desktop">
                <table>
                    <tr>
                        <td class="title">
                            <h2><?php echo $title ?></h2>
                        </td>
                        <?php foreach($vpn_info as $vpn) : ?>
                            <td>
                                <a href="<?php echo $vpn['link'] ?>" target="_blank" class="vpn-linkout" onclick="<?php echo $vpn['click'] ?>">
                                    <div class="name-container">
                                        Visit <?php echo $vpn['name'] ?>
                                    </div>
                                </a>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="result-logos mobile repeat">
            <?php foreach($vpn_info as $vpn) : ?>
                <a href="<?php echo $vpn['link'] ?>" target="_blank" class="vpn-linkout" onclick="<?php echo $vpn['click'] ?>">
                    <div class="logo-container">
                        <?php echo wp_get_attachment_image($vpn['logo'], 'full'); ?>
                    </div>
                    <div class="name-container">
                        Visit <?php echo $vpn['name'] ?>
                    </div>
                </a>
            <?php endforeach; ?>
            <div class="compare-return-container">
                <a href="<?php echo get_permalink() ?>" class="compare-return-btn">Compare Other VPNs</a>
            </div>
        </div>
    </div>

</div>

<script>
    <?php echo $vpn_prod_impress_result_wrap; ?>
</script>