
<div class="widget_wrapper">
<?php if( have_rows('you_may_also_like') ){
    while( have_rows('you_may_also_like') ) {
        the_row();
        $YouMayAlsoLike = '';
        $YouMayLike = get_sub_field('select_post');

        $PostId = $YouMayLike->ID;        
        $PostDateTime =  explode(" ", $YouMayLike->post_date);
        $PostDateArr = $PostDateTime[0];
        $PostDateRaw = date_create($PostDateArr);
        $PostDate = date_format($PostDateRaw,"M d, Y");

        $PostTitle = get_the_title($PostId);
        $PostContent = '';
        $PostContentRaw = wpautop($YouMayLike->post_content);
        
        $PostContent = substr( $PostContentRaw, 0, strpos( $PostContentRaw, '<!-- /wp:paragraph -->' ) + 4 );
        $PostContent = strip_tags($PostContent);
        $pos = strpos($PostContent, ' ', 72);
        $PostContent = substr($PostContent,0, $pos) . "...";
        
        $PostLink = get_permalink($PostId); //$YouMayLike->guid;
        //echo "<pre>"; print_r( $YouMayLike->guid ); echo "</pre>";
        $Postimg = get_the_post_thumbnail( $PostId);

        $YouMayAlsoLike .= '<div class="you_may_like_cnt box">';
        $YouMayAlsoLike .= '   <div class="col_full">';
        $YouMayAlsoLike .= '       <span class="post_date">' . $PostDate . '</span>';
        $YouMayAlsoLike .= '       <h4 class="post_title"><a href="' . $PostLink . '">' . $PostTitle . '</a></h4>';
        $YouMayAlsoLike .= '       <p class="post_content">';
        $YouMayAlsoLike .= '            ' . $PostContent;
        $YouMayAlsoLike .= '       </p>';
        $YouMayAlsoLike .= '   </div>';
        $YouMayAlsoLike .= '</div>';
        //echo "<pre>"; print_r( $VpnReview ); echo "</pre>";
        echo $YouMayAlsoLike;
    }
} ?>
</div>