<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wp-alwaysvpn
 */
$migration = get_field('migration_on', 'options');
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php if($migration): ?>
	<?php get_template_part('/template-parts/migration-banner'); ?>
<?php endif; ?>

	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'wp-alwaysvpn' ); ?></a>
    
      <?php if(get_field('show_ip_bar')) : ?>

        <div class="identification_banner">
            <div class="container">
                <div class="identification_banner_inner d-flex">
                    <h6 class="identification_banner_ip mb-0"><span>Your IP: </span> <?php echo $_SERVER['REMOTE_ADDR']; ?></h6>
                    <h6 class="identification_banner_location mb-0"><span>Your Location is: </span> Exposed</h6>
                    <h6 class="identification_banner_torrent mb-0"><a href="<?php echo get_field('bar_link');  ?>"><?php echo get_field('bar_title');  ?> <i class="fa fa-angle-right"></i></a></h6>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <?php
            $exit_popup_group = get_field('exit_popup');
            if ($exit_popup_group && $exit_popup_group['enable_exit_popup']) {
              require_once get_stylesheet_directory() . '/template-parts/exit-popup.php';
            }
        
        ?>
    
	<header id="masthead" class="site-header">
         <div class="container">
            <div class="row">
                <div class="col-8 col-md-6 col-lg-3 header-left">
                    <div class="site-branding">
                        <?php
                        the_custom_logo();
                        if ( is_front_page() && is_home() ) :
                            ?>
                            <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                            <?php
                        else :
                            ?>
                            <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                            <?php
                        endif;
                        $wp_alwaysvpn_description = get_bloginfo( 'description', 'display' );
                        if ( $wp_alwaysvpn_description || is_customize_preview() ) :
                            ?>
                            <p class="site-description"><?php echo $wp_alwaysvpn_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
                        <?php endif; ?>
                    </div><!-- .site-branding -->
                </div>
                <div class="col-4 col-md-6 col-lg-9 header-right d-flex justify-content-end">
                    <nav id="site-navigation" class="main-navigation">
                       
                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'menu-1',
                                'menu_id'        => 'primary-menu',
                            )
                        );
                        ?>
                    </nav><!-- #site-navigation -->
                </div>        
	</header><!-- #masthead -->
