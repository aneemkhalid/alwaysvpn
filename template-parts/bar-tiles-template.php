<div id="<?php echo $BarTileSlug; ?>" class="bar-tiles-wrap">
    <h2><?php echo $BarTileTitle; ?></h2>
    <?php if ( have_rows($RepeatField) >= 1 ) { ?>
        <?php while( have_rows($RepeatField) ) {
            the_row();
            $BarTilePost = ''; $DateToShow = '';
            $BarTilePost = get_sub_field($RepeatSubField);

            $PostId = $BarTilePost->ID;
            //echo "<pre>"; print_r( $BarTilePost ); echo "</pre>";
            
            $PostUpdateDateTime =  explode(" ", $BarTilePost->post_date);
            $PostUpdateDateArr = $PostUpdateDateTime[0];
            $PostUpdateDateRaw = date_create($PostUpdateDateArr);
            $PostUpdateDate = date_format($PostUpdateDateRaw,"M d, Y");

            $PostCreatedDateTime =  explode(" ", $BarTilePost->post_date);
            $PostCreatedDateArr = $PostCreatedDateTime[0];
            $PostCreatedDateRaw = date_create($PostCreatedDateArr);
            $PostCreatedDate = date_format($PostCreatedDateRaw,"M d, Y");
            
            $date1 = $PostCreatedDate; $date2 = $PostUpdateDate;

            $dateTimestamp1 = strtotime($date1);
            $dateTimestamp2 = strtotime($date2);

            if ( $dateTimestamp1 > $dateTimestamp2 ){
                $DateToShow = $date1;
                //echo "$date1 is latest than $date2";
            }else{
                $DateToShow = $date2;
                //echo "$date1 is older than $date2";
            }
            $PostTitle = get_the_title($PostId);
            $PostLink = get_permalink($PostId); //$BarTilePost->guid;
            $Postimg = get_the_post_thumbnail( $PostId);

            $PostContentRaw = wpautop($BarTilePost->post_content);

            $PostContentStart = strpos( $PostContentRaw, '<!-- wp:paragraph -->' );    
            $PostContentEnd = strpos( $PostContentRaw, '<!-- /wp:paragraph -->' );
            $PostContentLength = $PostContentEnd - $PostContentStart;
            $PostContent = substr( $PostContentRaw, $PostContentStart, $PostContentLength + 4 );
            
            $PostContent = trim(strip_tags($PostContent));    
         
            $decCharCount = strlen($PostContent);
    
            if ( $decCharCount < 100 ) {                
                $decOffsetLimit = 0;                
            } else {                
                $decOffsetLimit = 100;
            }
    
            $Pos = strpos($PostContent, ' ', $decOffsetLimit);    
    
            $PostContent = substr($PostContent,0, $Pos) . "&nbsp;[...]"; ?>
            <a href="<?php echo $PostLink; ?>">
              <div class="bar-tile">                
                    <?php echo $Postimg; ?>
                    <div class="bar-tile-content">
                        <h3><?php echo $PostTitle; ?></h3>
                        <p><?php echo $PostContent; ?></p>
                        <span><?php echo $DateToShow; // . "<br /><br />" . $PostCreatedDate . " | " . $PostUpdateDate . "<hr /><br />"; ?></span>
                    </div>                
              </div>
            </a>
        <?php } ?>
    <?php } ?>
</div>