<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wp-alwaysvpn
 */

$logo = get_field('logo_alt', 'option');
$descrip = get_field('footer_description', 'option');
$menu = wp_get_nav_menu_items( 'footer' );

$menu_format = [];
$currParent = 0;

foreach($menu as $item) {
    if($item->menu_item_parent == 0) {
        $menu_format[$item->ID] = [
            'title' => $item->title,
            'url' => $item->url,
            'classes' => $item->classes,
            'target' => $item->target,
            'children' => [],
        ];
        $currParent = $item->ID;
    }
    if($item->menu_item_parent == $currParent) {
        $menu_format[$currParent]['children'][] = [
            'title' => $item->title,
            'url' => $item->url,
            'classes' => $item->classes,
            'target' => $item->target,
        ];
    }
}

?>
   
    <a class="back-to-top" href="<?php echo esc_url('#0'); ?>">
        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                 viewBox="0 0 402.9 945" enable-background="new 0 0 402.9 945" xml:space="preserve" width="8" height="18.75">
            <path fill="#fff" d="M399.1,249c-3.1,6.6-8.1,9.8-15,9.8H268.2v645.7c0,4.8-1.6,8.8-4.7,11.9c-3.1,3.1-7.1,4.7-11.9,4.7h-99.3
                c-4.8,0-8.8-1.6-11.9-4.7c-3.1-3.1-4.7-7.1-4.7-11.9V258.8H19.8c-7.2,0-12.2-3.3-15-9.8c-2.8-6.6-1.9-12.6,2.6-18.1L188.5,32.2
                c3.4-3.4,7.4-5.2,11.9-5.2c4.8,0,9,1.7,12.4,5.2l183.7,198.7C401,236.4,401.8,242.4,399.1,249z"/>
        </svg>
    </a>

    <!-- FOOTER -->
    <footer>
        <!-- <?php echo "<pre>"; //print_r( $menu ); echo "</pre>"; ?> -->
        <!-- <?php echo "<pre>"; //print_r( $menu_format ); echo "</pre>"; ?> -->
        <div class="nav-container">

        
            <div class="footer-info">
                <div class="logo-container">
                    <a href="<?php echo esc_url(get_site_url()); ?>">
                        <?php echo wp_get_attachment_image( $logo, 'full', null, array("class" => 'footer_logo') ) ?>
                    </a>
                </div>
                <div class="main-menu-item mt-car-search">
                    <form method="GET" action="<?php echo home_url( '/' ); ?>" autocomplete="off">
                        <div class="search-input-container">
                            <input type="search" class="search-field form-control" placeholder="<?php esc_attr_e( 'Search VPNs', 'coinflip' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
                            <button type="submit" class="form-control btn btn-warning">
                                <span class="fa fa-search"></span>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="descrip-container">
                    <?php echo $descrip ?>
                </div>              
            </div>

            <nav>
                <?php 
                    foreach($menu_format as $item) : 
                    $combine = ['Deals', 'Resources', 'Company'];
                    if(!in_array($item['title'], $combine)) :
                    if(strtolower($item['title']) == 'best vpns') :
                ?>
                    <div class="vpn-container">
                        <a href="<?php echo $item['url'] ?>" class="parent"><?php echo $item['title'] ?></a>
                        <?php if($children = $item['children']) : ?>
                            <div class="nav-children">
                                <?php foreach($children as $child) : ?>
                                    <a href="<?php echo $child['url'] ?>" class="child"><?php echo $child['title'] ?></a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <div class="main-menu-item mt-car-search">
                            <form method="GET" action="<?php echo home_url( '/' ); ?>" autocomplete="off">
                                <div class="search-input-container">
                                    <input type="search" class="search-field form-control" placeholder="<?php esc_attr_e( 'Search VPNs', 'coinflip' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
                                    <button type="submit" class="form-control btn btn-warning">
                                        <span class="fa fa-search"></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                <?php else : ?>
                    <div>
                        <a href="<?php echo $item['url'] ?>" class="parent"><?php echo $item['title'] ?></a>
                        <?php if($children = $item['children']) : ?>
                            <div class="nav-children">
                                <?php foreach($children as $child) : ?>
                                    <a href="<?php echo $child['url'] ?>" class="child"><?php echo $child['title'] ?></a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php
                    endif;
                    endif; 
                    endforeach; 
                ?>
                <!-- Get custom last column -->
                <div class="combine-column">
                    <?php 
                        foreach($menu_format as $item) : 
                        $combine = ['Deals', 'Resources', 'Company'];
                        if(in_array($item['title'], $combine)) :

                    ?>
                        <div>
                            <a href="<?php echo $item['url'] ?>" class="parent <?php echo strtolower($item['title']) ?>-title"><?php echo $item['title'] ?></a>
                            <?php if($children = $item['children']) : ?>
                                <div class="nav-children">
                                    <?php foreach($children as $child) : ?>
                                        <a href="<?php echo $child['url'] ?>"><?php echo $child['title'] ?></a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php
                        endif; 
                        endforeach; 
                    ?>
                    <div>
                        <aside id="coinflip_address_social_icons-4" class="widget vc_column_vc_container widget_coinflip_address_social_icons">
                            <div class="sidebar-social-networks address-social-links">
                                <ul class="social-links-list">
                                    <li><a href="https://www.facebook.com/AlwaysVPN" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" width="10.25" height="18"><path fill="#000" d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"/></svg></a></li>
                                    <li><a href="https://twitter.com/AlwaysVPN_" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="16.75" height="18"><path fill="#000" d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"/></svg></a></li>
                                </ul>
                                
                            </div>
                        </aside>
                    </div>
                </div>
            </nav>

            <div class="descrip-container mobile">
                <?php echo $descrip ?>
            </div>
        </div>




        <!-- FOOTER BOTTOM -->
        <div class="footer-div-parent">
            <div class="container footer">
                <div class="container_inner_footer">
                    <div class="row">
                        <div class="col-md-12 cr-wrapper">
                            <p class="copyright text-center">
                                &#169; <?php echo date('Y'); ?> Copyright: AlwaysVPN
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

<?php wp_footer(); ?>

</body>
</html>
