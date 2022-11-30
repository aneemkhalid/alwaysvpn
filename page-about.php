<?php
/**
 * Template Name: About Page
 *
 * @package WordPress
 * @subpackage Coinflip_Child
 * @since Coinflip Child 1.0
 * 
 * The template for displaying the about us page.
 *
 */

get_header(); 
echo create_breadcrumbs_html();



wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );




$intro_content = get_field('intro_content');
$review_process = get_field('review_process');
$unbiased_expertise = get_field('unbiased_expertise');
$meet_the_team_title = get_field('meet_the_team_title');
$meet_the_teams = get_field('meet_the_teams');
$meet_the_team = get_field('meet_the_team');

$contact_us_title = get_field('contact_us_title');
$support_tile = get_field('support_tile');
$partnerships_tile = get_field('partnerships_tile');
$press_tile = get_field('press_tile');
?>

    <!-- Page content -->
    <div id="main" class="content-area no-sidebar about-us-page">
        
        <div id="about-us-row" class="container ">
            <div class="row ">               
                <div class="col">
                    <h1 class="page-title"><?php the_title(); ?></h1>

                    <div class="header-separator"></div>
                    <div class="about-intro">
                       <?php echo $intro_content; ?>
                    </div>                       
                </div>
            </div>
        </div>
        
        <div id="review-process-row" >
            <div class="container ">
                <div  class="row ">               

                    <div class="col-sm-6">
                        <?php echo $review_process['text_side']; ?>
                        <a class="btn btn-primary btn-lg" href="<?php echo $review_process['button_url']; ?>"><?php echo $review_process['button_text']; ?></a>
                    </div> 
                    
                    <div class="col-sm-6">              
                        <img src="<?php echo $review_process['image_side']; ?>" alt="Reviews" width="800" height="533">                    
                    </div>  

                </div>
            </div>
        </div>
        
         <div id="unbiased-expertise-row" class="container ">
                <div  class="row ">               

                    <div class="col-sm-6 col-md-5 col-md-offset-1">                 
             
                        <img src="<?php echo $unbiased_expertise['image_side']; ?>" alt="Unbiased Expertise" width="800" height="533">          

                    </div> 
                    
                    <div class="col-sm-6 col-md-5 col-md-offset-1">
                        <?php echo $unbiased_expertise['text_side']; ?>
                        <a class="btn btn-primary btn-lg" href="<?php echo $unbiased_expertise['button_url']; ?>"><?php echo $unbiased_expertise['button_text']; ?></a>
                    
                    </div>  

                </div>
            </div>
        
        <div id="team-row" >
            <div class="container ">
                <div class="row team-row-top">               
                    <div class="col">
                        <h2 class="page-title"><?php echo $meet_the_team_title ?></h2>

                        <div class="header-separator"></div>
                    </div>  
                </div>
                
                <?php 

                    if($meet_the_team) : 
                        foreach($meet_the_team as $item) : 
                            $thumb = get_the_post_thumbnail_url($item);
                            $bio = get_field('bio', $item);
                            $title = get_field('article_author_title', $item);
                            $name = get_the_title($item);
                            $url = get_permalink($item);
                        ?>
                        <div class="row team-row-info">
                            <div class="col-sm-3 text-center">
                                <a href="<?php echo $url ?>"><img src="<?php echo $thumb ?>" alt="Team Member" width="200" height="200"></a>
                            </div>
                            <div class="col-sm-9">
                                <h4><?php echo $name ?></h4>
                                <h5><?php echo $title ?></h5>
                                <p><?php echo $bio ?></p>
                            </div>
                        </div>
                        <?php 
                        endforeach;    
                    endif; 

                ?>               
       
              
            </div>
        </div>
        
        
        <div id="contact-us-image-row" >
            <div class="container ">
                <div class="row contact-us-row-top">               
                    <div class="col">
                        <h2 class="page-title"><?php echo $contact_us_title; ?></h2>

                        <div class="header-separator"></div>
                    </div>  
                </div>
                <div id="contact-tile-row" class="row ">
                
                    <div class="col-md-4 text-center contact-tile">
                        <img src=" <?php echo $support_tile['image']; ?>" alt="Support Icon" width="150" height="150">
                        <?php echo $support_tile['text']; ?>
                        <a class="btn btn-primary " href="mailto:<?php echo $support_tile['button_email_address']; ?>"><?php echo $support_tile['button_text']; ?></a>
                    </div>
                     <div class="col-md-4 text-center contact-tile">
                        <img src="<?php echo $partnerships_tile['image']; ?>" alt="Partnerships Icon" width="150" height="150">
                        <?php echo $partnerships_tile['text']; ?>
                        <a class="btn btn-primary " href="mailto:<?php echo $partnerships_tile['button_email_address']; ?>"><?php echo $partnerships_tile['button_text']; ?></a>
                    </div>
                    <div class="col-md-4 text-center contact-tile">
                        <img src="<?php echo $press_tile['image']; ?>" alt="Press Icon" width="150" height="150">
                        <?php echo $press_tile['text']; ?>
                        <a class="btn btn-primary " href="mailto:<?php echo $press_tile['button_email_address']; ?>"><?php echo $press_tile['button_text']; ?></a>                    
                    </div>
                  
                </div>
              
            </div>
         
        </div>
        
        
  
    </div>
 

<?php get_footer(); ?>
