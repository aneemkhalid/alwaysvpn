
<div class="widget_wrapper">
<?php if( have_rows('comparison_widget_tool') ){
    while( have_rows('comparison_widget_tool') ) {
        the_row();
        
        $heading = get_sub_field('heading');
        $description = get_sub_field('description');
        $cta_text = get_sub_field('cta_text');
        
        $ComparisonTool = '';

        $ComparisonTool .= '<div class="comparison_tool_widget">';
        $ComparisonTool .= '<img src="'.get_template_directory_uri().'/images/vpnagencies-graphic.png">';
        $ComparisonTool .= '   <div class="comparison_tool_widget_content text-center">';

        if($heading) {
        $ComparisonTool .= '       <h4>' . $heading . '</h4>';
        } else{
        $ComparisonTool .= '       <h4>VPN Comparison Tool</h4>';
        }

        if($description) {
        $ComparisonTool .= '       <p class="mb-4">' . $description . '</p>';
        } else {
        $ComparisonTool .= '       <p class="mb-4">Compare key features from dozens of top VPNs to discover which provider is right for you</p>';
        }

        if($cta_text) {
        $ComparisonTool .= '       <a class="btn btn-primary btn-md" href="/tools/comparison-tool">' . $cta_text . '</a>';
        } else {
        $ComparisonTool .= '       <a class="btn btn-primary btn-md" href="/tools/comparison-tool">Compare VPNs</a>';
        }

        $ComparisonTool .= '   </div>';
        $ComparisonTool .= '</div>';

        echo $ComparisonTool;        
    }
} ?>
</div>