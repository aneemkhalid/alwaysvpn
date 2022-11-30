
<div class="widget_wrapper">
<?php if( have_rows('vpn_reviews') ){
    while( have_rows('vpn_reviews') ) {
        the_row();
        $VPN_Review = '';
        $VpnReview = get_sub_field('select_vpn_review');
        $PostId = $VpnReview->ID;
        
        $PostDateTime =  explode(" ", $VpnReview->post_date);
        $PostDateArr = $PostDateTime[0];
        $PostDateRaw = date_create($PostDateArr);
        $PostDate = date_format($PostDateRaw,"M d, Y");

        $PostTitle = get_the_title($PostId);
        $PostContent = get_field('short_description', $PostId);

        $PostLink = get_permalink($PostId); //$VpnReview->guid;
        $Postimg = get_field('vpn_image', $PostId); //get_the_post_thumbnail( $PostId);
        $Postname = get_field('vpn_name', $PostId); //get_the_post_thumbnail( $PostId);

        $VPN_Review .= '<a class="vpn_review_cnt box"  href="' . $PostLink . '">';
        $VPN_Review .= '   <div class="col_left">';
        $VPN_Review .= '       <div class="post_img"><img src="' . $Postimg . '" width="50" height="50" alt="' .  $Postname . '"/></div>';
        $VPN_Review .= '   </div>';
        $VPN_Review .= '   <div class="col_right">';
        $VPN_Review .= '       <h4 class="post_title">' . $PostTitle . '</h4>';
        $VPN_Review .= '       <p class="post_content">';
        $VPN_Review .= '            ' . $PostContent;
        $VPN_Review .= '       </p>';
        $VPN_Review .= '   </div>';
        $VPN_Review .= '</a>';
        //echo "<pre>"; print_r( $VpnReview ); echo "</pre>";
        echo $VPN_Review;
    }
} ?>
</div>