<?php

function add_toast(){
    
    if (!is_404()) {
        global $post;
        $pid = $post->ID;
    
    $toaster_obj = get_field('toaster', 'option');
    $target_pages = [];
        
    if( $toaster_obj  && !empty($toaster_obj[0]['target_pages'])) {
        // create array of page id's that are using toast
        // loops through toast repeater in theme options and assigns page id's to array
        $index = 0;
        foreach($toaster_obj as $toaster_arr){
            foreach($toaster_arr['target_pages'] as $toaster_target){
                // assign page id to array and it's key in the acf object               
                $target_pages[$toaster_target['page']] = $index;
                
            }
            ++$index;
        }
       
        // if current post id is in array of post id's with toast
        // find array of toast meta associate with the current page
        if( array_key_exists($pid, $target_pages) ){

            $toaster_obj_key = $target_pages[$pid]; // get the key of toast meta to find it in the acf object
            $toast_arr = $toaster_obj[$toaster_obj_key]; // search the acf object for the associate toast meta
            $link_target = $toast_arr['link_open_new_tab'] ? 'target="_blank"' : '';
            // add toast meta to html
            $toast_html =
            '<div class="toast" id="avpn-toast" data-pid="'. get_the_ID() . '">'. 
                '<figure class="icon-cont">'.
                    '<img width="35px" src="' . get_stylesheet_directory_uri() . '/images/icons/avpn-logo-icon.svg">'.
                '</figure>'. 
                '<div class="copy-cont">'. 
                    '<p class="description">'. $toast_arr['description'] . '</p>'. 
                    '<a href="' . $toast_arr['link_url'] . '" class="toat-link" '. $link_target .'>' . $toast_arr['link_text'] . ' <span class="toast-link-chevron"><img src="' . get_stylesheet_directory_uri() . '/images/icons/chevron-blue.svg"/></span></a>'. 
                '</div>'. 
                '<span class="close-btn"><img id="close-toast" height="20px" width="20px" src="' . get_stylesheet_directory_uri() . '/images/icons/close-white.svg"/></span>'.
            '</div>';
            echo $toast_html;
        }
    }
    }    
}
add_action('wp_footer', 'add_toast');