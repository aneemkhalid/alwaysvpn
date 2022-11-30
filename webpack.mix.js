// webpack.mix.js

let mix = require('laravel-mix');

var argv = require('minimist')(process.argv.slice(2));


require('laravel-mix-purgecss');
require('laravel-mix-clean-css');

mix.webpackConfig({
    externals: {
        "jquery": "jQuery"
    }
});

mix.options({ processCssUrls: false });

mix.js('js/index.js', 'build')
//creating this bridge js file till we get that table reworked
mix.js('js/datatable-bridge.js', 'build')

mix.sass('sass/style.scss', 'style.min.css')
    .sourceMaps(false, 'source-map')
    .purgeCss({
     //enabled: true,
       content:  ['template-parts/*.php', 'template-parts/blocks/*.php', 'inc/*.php', 'inc/functions/*.php', 'js/*.js', '*.php'],
     safelist: [
    'rtl',
    'home',
    'blog',
    'archive',
    'date',
    'error404',
    'logged-in',
    'admin-bar',
    'no-customize-support',
    'custom-background',
    'wp-custom-logo',
    'alignnone',
    'alignright',
    'alignleft',
    'wp-caption',
    'wp-caption-text',
    'screen-reader-text',
    'comment-list',
    'slick-list',
    'slick',
    'partnerships-page',
    'with_frm_style',
    'frm_form_field',
    'form-field',
    'ez-toc-widget-container', 
    'wp-block-table', 
    'is-style-hso-table', 
    'privacy-policy',
    'money_back', 
    'android',
    'torreting',
    'streaming',
    'gaming',
    'netflix',
    'firefox',
    'apple',
    'sec_prv',
    'cryptocurrency',
    'affordable',
    'insights-submenu',
    'deals-submenu',
    'best-vpns-submenu',    
    'cpt-sidebar-menu',
    'widget_search',
    'ez-toc-list', 
    'wt-cli-non-eu-country',
    'wt-cli-eu-country',
    'gdpr-cookie-message',
    'ccpa-cookie-message',     
    'elementor-page',
    'prev',
    'single-post',
    'nav-links',
    'light_blue_red_shield',
    'dark_blue_media_screen',
    'light_blue_vpn_files',
    'dark_blue_mobile_vpn',
    'light_blue_desktop_and_mobile',
    'black_laptop_vpn',
    'dark_blue_globe_vpn',
    'black_headphoned_user',
    'comparison-tool',
    'comparison_tool_light_bg',
    'comparison_tool_dark_bg',
    'black_text',   
    'in',
    'show',
    'fade',     
    'expired',
    'is-selected',
    'compact-comparison',
    'vpn-comp-container',
    'mega-resources',
    'collapse',
    'collapsing',
    'wp-block-embed',
    'wp-embed-aspect-16-9',
    'dropdown-menu',
    /^search(-.*)?$/,
    /^(.*)-template(-.*)?$/,
    /^(.*)?-?single(-.*)?$/,
    /^postid-(.*)?$/,
    /^attachmentid-(.*)?$/,
    /^attachment(-.*)?$/,
    /^page(-.*)?$/,
    /^(post-type-)?archive(-.*)?$/,
    /^author(-.*)?$/,
    /^category(-.*)?$/,
    /^tag(-.*)?$/,
    /^tax-(.*)?$/,
    /^term-(.*)?$/,
    /^(.*)?-?paged(-.*)?$/,
    /^slick-(.*)?$/,    
    /^contact-(.*)?$/,
    /^content-block-(.*)?$/,
    /^frm_(.*)?$/,
    /^wp-block-(.*)?$/,
    /^ez-toc-(.*)?$/,
    /^resources-(.*)?$/,
    /^vpn-count-(.*)?$/,
    /^counter-(.*)?$/,
    /^cli-(.*)?$/,
    /^cookie-(.*)?$/,
    /^breadcrumbs-(.*)?$/,
    /^mega-(.*)?$/, 
    /^modal-(.*)?$/,
    /^flex-(.*)?$/,
    /^justify-(.*)?$/,
    /^align-items-(.*)?$/,
    /^p-(.*)?$/,
    /^pr-(.*)?$/,
    /^pl-(.*)?$/,
    /^pt-(.*)?$/,
    /^pb-(.*)?$/,
    /^m-(.*)?$/,
    /^mr-(.*)?$/,
    /^ml-(.*)?$/,
    /^mt-(.*)?$/,
    /^mb-(.*)?$/,
    /^dataTables_(.*)?$/,
    /^dtfc-(.*)?$/,
    /^column-(.*)?$/,
    /^flickity-(.*)?$/,
    /^mega-resources(.*)?$/,           
    /^dropdown-menu(.*)?$/,            
    ]
   })
  .cleanCss({
    level: 2
  })

mix.sass('sass/admin-styles.scss', 'admin-styles.css')
  .sourceMaps({generateForProduction: false});


if (argv.user === 'brad') {
    //add in your browserSync settings that you need
    mix.browserSync({
        proxy: 'alwaysvpn.test',
        browser: 'firefox'
    });
 } else if (argv.user === 'edward') {
    //add in your browserSync settings that you need
    mix.browserSync({
        proxy: 'alwaysvpn.test'
    });
 } else if (argv.user === 'jessi') {
    //add in your browserSync settings that you need
    mix.browserSync({
        proxy: 'alwaysvpn.test'
    });
 } else if (argv.user === 'ryan') {
    //add in your browserSync settings that you need
    mix.browserSync({
        proxy: 'alwaysvpn.test'
    });
 } else if (argv.user === 'syed') {
     //add in your browserSync settings that you need
    mix.browserSync({
        proxy: 'alwaysvpn.test'
    });
 }  




