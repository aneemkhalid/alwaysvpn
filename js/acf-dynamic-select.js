jQuery(document).ready(function($){
    if (typeof acf == 'undefined') { return; }
    
    // console.log('ready');
    acf.addAction('load', function(){

        var fields = acf.findFields({
            key: 'field_60dddd5257306'

        });
        //console.log(fields);

        $(fields).each(function() {
            //console.log($(this));
            var block = $(this).closest('[data-type="acf/standalone-cta-button"]').data('block');
            //console.log('Block:' + block);
            var acfBlock = $(this).find('.acf-label label').attr('for').split("-");
            var postID = acf.get('post_id');

            update_target_link_load($, block, postID, acfBlock[1]);
        
            //console.log(block);
            //console.log(acfBlock);
        })

        var fieldResource = acf.findFields({
            key: 'field_623359f39ea85'
        });

        $(fieldResource).each(function() {

            var postID = acf.get('post_id');

            update_target_link_load($, null, postID, null);
        })
    })


    // }); 
    
    $(document).on('change', '[data-key="field_60ddd9ac542a0"] .acf-input select', function(e) {

        var block = $(this).closest("[data-block]", '.wp-block').data('block');
        //console.log(block);
        update_target_on_vpn_change(e, $, block);
    });
    $('[data-key="field_60ddd9ac542a0"] .acf-input select').trigger('ready');

    $(document).on('change', '[data-key="field_6230ab831106b"] .acf-input select', function(e) {

        update_target_on_vpn_change(e, $, null);
    });
    $('[data-key="field_6230ab831106b"] .acf-input select').trigger('ready');
});

function update_target_on_vpn_change(e, $, block) {
    //console.log('got here')
    if (this.request) {
        // if a recent request has been made abort it
        this.request.abort();
    }
    
    // get the city select field, and remove all exisiting choices
    if(block) {
        var target_select = $('[data-block="' + block +'"] [data-key="field_60dddd5257306"] select');
    }
    else {
        var target_select = $('[data-key="field_623359f39ea85"] select');
    }
    target_select.empty();
    
    // get the target of the event and then get the value of that field
    var target = $(e.target);
    var vpn = target.val();
    
    if (!vpn) {
        return;
    }
    
    // set and prepare data for ajax
    var data = {
        action: 'load_target_link_field_choices',
        vpn: vpn,
    }
    
    // call the acf function that will fill in other values
    // like post_id and the acf nonce
    data = acf.prepareForAjax(data);

    //console.log(acf.get('ajaxurl'));
    
    this.request = $.ajax({
        url: acf.get('ajaxurl'), // acf stored value
        data: data,
        type: 'post',
        dataType: 'json',
        success: function(json) {
            if (!json) {
                return;
            }
            //console.log(json)

            for(i=0; i<json.length; i++) {
                var target_item = '<option value="'+json[i]['value']+'"'+json[i]['selected']+'>'+json[i]['label']+'</option>';
                target_select.append(target_item);
            }
        }
    });
    
}

function update_target_link_load($, block, postID, acfBlock) {
    
    // get the link select field, and remove all exisiting choices
    if(block) {
        var target_select = $('[data-block="' + block +'"] [data-key="field_60dddd5257306"] select');
        var target = $('[data-block="' + block +'"] [data-key="field_60ddd9ac542a0"] select');
    }
    else {
        //Side Nav Resource
        var target_select = $('[data-key="field_623359f39ea85"] select');
        var target = $('[data-key="field_6230ab831106b"] select');
    }
    target_select.empty();
    
    // get the target of the event and then get the value of that field
    
    var vpn = target.val();

    //console.log(vpn)
    
    if (!vpn) {
        return;
    }
    
    // set and prepare data for ajax
    var data = {
        action: 'load_target_link_field_choices',
        vpn: vpn,
        postID: postID,
        block: acfBlock,
    }
    
    // call the acf function that will fill in other values
    // like post_id and the acf nonce
    data = acf.prepareForAjax(data);

    //console.log(acf.get('ajaxurl'));
    
    this.request = $.ajax({
        url: acf.get('ajaxurl'), // acf stored value
        data: data,
        type: 'post',
        dataType: 'json',
        success: function(json) {
            if (!json) {
                return;
            }
            //console.log(json)

            for(i=0; i<json.length; i++) {
                var target_item = '<option value="'+json[i]['value']+'"'+json[i]['selected']+'>'+json[i]['label']+'</option>';
                target_select.append(target_item);
            }
        }
    });
    
}