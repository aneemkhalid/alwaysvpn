<?php
$section_titles = get_field('section_titles');

if(get_field('top_posts_toggle') || get_field('vpn_reviews_toggle') || get_field('ymal_toggle') || get_field('comparison_tool_toggle')) :
?>    

    <div class="right">
        <div class="sidenav_inner">
            <?php if( get_field('top_posts_toggle') ) {
                if( (have_rows('top_posts') >= 1) ) { ?>
                <div class="sidebar-widget">
                             
                    <?php if ($section_titles['top_post_title']) {                                                       
                            echo '<h3>'.$section_titles['top_post_title'].'</h3>';  
                        } else {
                            echo '<h3>Top Posts</h3>';
                        }            
                    ?>   
                    
                    <?php include_once("top-posts.php"); ?>
                </div>
            <?php 
                } 
            }
            ?>

            <?php if( get_field('vpn_reviews_toggle') ) {
                if( (have_rows('vpn_reviews') >= 1) ) {?>
                <div class="sidebar-widget">
                    <?php if ($section_titles['vpn_reviews_title']) {                                                       
                            echo '<h3>'.$section_titles['vpn_reviews_title'].'</h3>';  
                        } else {
                            echo '<h3>VPN Reviews</h3>';
                        }            
                    ?>   
                    
                    <?php include_once("vpn-reviews.php"); ?>
                </div>
            <?php 
                } 
            }
            ?>

            <?php if( get_field('ymal_toggle') ) {
                if( (have_rows('you_may_also_like') >= 1) ) {?>                
                <div class="sidebar-widget">
                    <?php if ($section_titles['also_like_title']) {                                                       
                         echo '<h3>'.$section_titles['also_like_title'].'</h3>';  
                      } else {
                          echo '<h3>You may also like</h3>';
                      }          
                    ?> 
                    <?php include_once("u-may-like.php"); ?>
                </div>
            <?php 
            } 
            }
            ?>

            <?php if( get_field('comparison_tool_toggle') ) { ?>           
                <div class="sidebar-widget">
                    <?php if ( get_field('comparison_widget_title') ) {                                                       
                         echo '<h3>'.get_field('comparison_widget_title').'</h3>';  
                      } else {
                          echo '<h3>Compare VPNs</h3>';
                      }          
                    ?> 
                    <?php include_once("comparison-tool-widget.php"); ?>
                </div>
            <?php } ?>
            
        </div>
    </div>
<?php endif; ?>