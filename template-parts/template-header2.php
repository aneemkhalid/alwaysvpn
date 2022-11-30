<?php
    $menu_items = prepare_menu_items();

    $args = array(  
        'post_type' => 'reviews',
        'post_status' => 'publish',
        'orderby' => 'menu_order', 
        'order' => 'ASC',
        'posts_per_page' => 10,
    );
    $reviews = new WP_Query( $args );
    
?>
<header class="header2">
    <!-- BOTTOM BAR -->
    <nav class="navbar navbar-default logo-infos" id="modeltheme-main-head">
        <div class="vpn-header-container">
            <div class="row">
                <!-- LOGO -->
                <div class="navbar-header col-md-3">
                    <!-- NAVIGATION BURGER MENU -->
                    <button type="button" id="toggle-hamburger" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <div id="navbar-hamburger">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </div>
                        <div id="navbar-close" class="hidden">
                            <span class="glyphicon glyphicon-remove"></span>
                        </div>
                    </button>

                    <?php $custom_logo_url = get_post_meta( get_the_ID(), 'smartowl_header_custom_logo', true );
                    if(isset($custom_logo_url) && !empty($custom_logo_url)) { ?>
                        <div class="logo">
                            <a href="<?php echo esc_url(get_site_url()); ?>">
                                <img src="<?php echo esc_url($custom_logo_url); ?>" alt="<?php echo esc_attr(get_bloginfo()); ?>" width="220" height="38" />
                            </a>
                        </div>
                    <?php } else { ?>
                        <div class="logo">
                            <a href="<?php echo esc_url(get_site_url()); ?>">
                                <img src="<?php echo esc_url(coinflip_redux('mt_logo','url')); ?>" alt="<?php echo esc_attr(get_bloginfo()); ?>" width="220" height="38"/>
                            </a>
                        </div>
                    <?php } ?>
                </div>
                <!-- NAV MENU --> 
                <div class="navbar-collapse col-md-9">
                    <ul class="menu nav navbar-nav pull-right nav-effect nav-menu">
                        <?php
                            if ( has_nav_menu( 'primary' ) ):
                                foreach($menu_items as $item):
                                    $submenu_class = strtolower(str_replace(' ', '-', $item['title'])).'-submenu'; ?>
                                <li class="main-menu-item">
                                    <div class="main-menu-item-link-container">
                                        <a href="<?php echo $item['url']; ?>" class="main-menu-item-link"><?php echo strtoupper($item['title']); ?></a>
                                        <span class="glyphicon glyphicon-chevron-down"></span>
                                    </div>
                                    <?php if($item['has_subcats']): ?>
                                        <div class="main-submenu mega-submenu <?php echo $submenu_class; ?>">
                                            <div class="mega-menu-columns">
                                                <?php foreach($item['submenu_items'] as $key => $subcat): ?>
                                                    <?php if(strtolower($key) == 'tools') : ?>
                                                        <div>
                                                            <p class="mega-menu-heading" title="<?php echo $key; ?>"><?php echo strtoupper($key); ?></p>
                                                            <div class="vpn-comp-container">
                                                                <a href="<?php echo $subcat[0]['url'] ?>" class="content-container">
                                                                    <?php 
                                                                        $image = get_field('vpn_comparison_image', 'option');
                                                                        if($image) {
                                                                            echo wp_get_attachment_image($image, 'medium');
                                                                        }
                                                                    ?>
                                                                    <div class="text-content">
                                                                        <p class="title"><?php echo $subcat[0]['title'] ?></p>
                                                                        <p class="desc"><?php echo mb_strimwidth($subcat[0]['desc'], 0, 101) ?></p>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    <?php else : ?>
                                                        <div>

                                                            <?php $check_key = ['popular', 'guides', 'insights', 'deals', 'all', 'tools']; ?>
                                                            <p class="mega-menu-heading" title="<?php echo $key; ?>"><?php echo (in_array(strtolower($key), $check_key)) ? '' : 'BY '; echo strtoupper($key); ?></p>

                                                            <ul class="main-submenu-list <?php echo str_replace("/", "",str_replace(" ", "-", strtolower($key))); ?>">
                                                                <?php 
                                                                echo create_nav_list_items($item['submenu_items'][$key]); ?>
                                                            </ul>
                                                            
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="main-submenu <?php echo $submenu_class; ?>">
                                            <ul>
                                                <?php echo create_nav_list_items($item['submenu_items']); ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        
                        <?php if( $reviews->have_posts() ): ?>
                            <li class="main-menu-item">
                                <div class="main-menu-item-link-container">
                                    <a href="<?php echo site_url('reviews'); ?>" class="main-menu-item-link">REVIEWS</a>
                                    <span class="glyphicon glyphicon-chevron-down"></span>
                                </div>
                                <div class="main-submenu reviews-submenu">
                                    <ul>
                                        <?php while ( $reviews->have_posts() ) : $reviews->the_post(); ?>
                                            <li><a href="<?php the_permalink() ?>"><?php the_field('vpn_name') ?></a></li>
                                        <?php endwhile; wp_reset_postdata(); ?>
                                        <li class="see_all"><a href="<?php echo site_url('reviews'); ?>">See All Reviews <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a></li>
                                    </ul>
                                </div>
                            </li>
                        <?php endif; ?>
                        <?php $comparisons = wp_get_nav_menu_items( 'comparison' ); ?>
                            <li class="main-menu-item">
                                <div class="main-menu-item-link-container">
                                    <a href="<?php echo site_url('comparisons'); ?>" class="main-menu-item-link">COMPARISONS</a>
                                    <span class="glyphicon glyphicon-chevron-down"></span>
                                </div>
                                <div class="main-submenu">
                                    <ul>
                                        <?php foreach($comparisons as $comparison){ ?>
                                            <li><a href="<?php echo $comparison->url; ?>"><?php echo $comparison->title; ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </li>
                          <li class="main-menu-item mt-car-search">
                                <form method="GET" action="<?php echo home_url( '/' ); ?>" autocomplete="off">
                                    <div class="search-input-container">
                                        <input type="search" class="search-field form-control" placeholder="<?php esc_attr_e( 'Search VPNs', 'coinflip' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
                                        <button type="submit" class="form-control btn btn-warning">
                                            <span class="fa fa-search"></span>
                                        </button>
                                    </div>
                                </form>
                            </li>                  
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>