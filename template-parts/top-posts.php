
<div class="widget_wrapper">
<?php if( have_rows('top_posts') ){
    while( have_rows('top_posts') ) {
        the_row();
        $TopPost = '';
        $Top_Post = get_sub_field('select_top_post');

        $PostId = $Top_Post->ID;
        
        $PostDateTime =  explode(" ", $Top_Post->post_date);
        $PostDateArr = $PostDateTime[0];
        $PostDateRaw = date_create($PostDateArr);
        $PostDate = date_format($PostDateRaw,"M d, Y");

        $PostTitle = get_the_title($PostId);
        $PostLink = get_permalink($PostId); //$Top_Post->guid;
        $Postimg = get_the_post_thumbnail( $PostId);

        $TopPost .= '<a class="top_post_cnt box" href="' . $PostLink . '">';
        $TopPost .= '   <div class="col_left">';
        $TopPost .= '       <span class="post_date">' . $PostDate . '</span>';
        $TopPost .= '       <h4 class="post_title">' . $PostTitle . '</h4>';
        $TopPost .= '   </div>';
        $TopPost .= '   <div class="col_right">';
        $TopPost .= '       <div class="post_img">' . $Postimg . '</div>';
        $TopPost .= '   </div>';
        $TopPost .= '</a>';

        echo $TopPost;        
    }
} ?>
</div>