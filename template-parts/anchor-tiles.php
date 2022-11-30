<?php
$AnchorTilesIcons = array( "by-popular.svg", "by-device.svg", "by-service.svg", "by-location.svg" );
$AnchorTilesTitle = array();
if ( have_rows('anchor_tile') >= 1 ) { ?>
    <div class="anchor-tiles-wrap">
        <?php $a = 0;
        while( have_rows('anchor_tile') ) {
            the_row();
            $AnchorTitle = get_sub_field('tile_title');
            $TitleSlug = str_replace (" ","_", strtolower($AnchorTitle) );
            $AnchorTilesTitle[] = $AnchorTitle;
            ?>            
            <a href="#<?php echo $TitleSlug; ?>" class="anchor-tile" >
                <img src="<?php 
                echo get_stylesheet_directory_uri() . "/images/icons/" . $AnchorTilesIcons[$a];
                //echo dirname(get_template_directory_uri()) . "/alwaysvpn/icons/" . $AnchorTilesIcons[$a];
                //echo get_template_directory_uri() . '/icons/' . $AnchorTilesIcons[$a];
                ?>" alt="<?php echo $AnchorTitle; ?>" height="48" width="48" />
                <h5><?php echo get_sub_field('tile_title'); ?></h5>
            </a>        
        <?php $a++;
    } ?>
    </div>
<?php } ?>