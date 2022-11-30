<?php 


if (array_key_exists('is_blog', $args) && $args['is_blog']):
?>
<div class="d-flex justify-content-between breadcrumbs-container flex-column flex-md-row is_blog">
    <nav aria-label="breadcrumb">
            <ol class="breadcrumbs-list d-flex align-items-center">
                <span>
                    <span>
                        <a href="<?php echo site_url() ?>">
                            <div class="icon-home"></div>
                        </a> 
                        <div class="icon-chevron-right"></div>
                        <a href="/resources">
                            Resources
                        </a> 
                         <div class="icon-chevron-right"></div>
                        <?php if (is_singular('post')): ?>
                        <a href="/resources/insights">
                            Insights
                        </a> 
                         <div class="icon-chevron-right"></div>
                        <span class="breadcrumb_last" aria-current="page">Article</span>
                        <?php else: ?>
                            Insights
                        <?php endif; ?>
                    </span>
                </span>
            </ol>
    </nav>

</div>
<?php elseif(array_key_exists('is_location', $args) && $args['is_location']): ?>
    <div class="d-flex justify-content-between breadcrumbs-container <?php if(array_key_exists('has_banner', $args) && $args['has_banner']) echo 'has-banner'; ?> <?php if(array_key_exists('is_blog', $args) && $args['is_blog']) echo 'is-blog'; ?>">
        <nav aria-label="breadcrumb">
                <ol class="breadcrumbs-list d-flex align-items-center">
                    <span>
                        <span>
                            <a href="<?php echo site_url() ?>">
                                <div class="icon-home"></div>
                            </a> 
                             <div class="icon-chevron-right"></div>
                            <a href="<?php echo $args['state_permalink']; ?>">
                                <?php echo $args['state']; ?>
                            </a> 
                             <div class="icon-chevron-right"></div>
                            <span class="breadcrumb_last" aria-current="page"><?php echo $args['city']; ?></span>
                        </span>
                    </span>
                </ol>
        </nav>
 
    </div>
<?php else: ?>
<div class="d-flex justify-content-between breadcrumbs-container <?php if(array_key_exists('has_banner', $args) && $args['has_banner']) echo 'has-banner'; ?> <?php if(array_key_exists('is_blog', $args) && $args['is_blog']) echo 'is-blog'; ?>">
    <nav aria-label="breadcrumb">
        <?php
            if ( function_exists('yoast_breadcrumb') && $post->post_name !== 'homepage') {
                yoast_breadcrumb( '<ol class="breadcrumbs-list d-flex align-items-center">','</ol>' );
            }
        ?>
    </nav>

</div>
<?php endif; ?>