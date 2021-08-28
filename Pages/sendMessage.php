<?php

$DTWP_general = get_option('DTWP_General_Option');
wp_enqueue_style('sendMessage',  DTWP_assets .'sendMessage.css', array() , DTWP_plugin_version);
wp_enqueue_script('DTWP_ORS', DTWP_assets . 'Orders.js', array() , DTWP_plugin_version , true);
wp_localize_script('DTWP_ORS', 'DTWP_ORS', array(
    'Applicationmode' => $DTWP_general['Applicationmode'],
    'fix_countrycode' => 'false',
    'Country_Code' => $DTWP_general['Country_Code']
)); 
?>
<h1><?php esc_html_e('Send message','DTWPLANG'); ?></h1>
<div id="sendMessageForm">
    <table class="form-table dtwp-form-table">
        <tr class="phoneNumber">
            <th><?php esc_html_e('Phone','DTWPLANG'); ?></th>
            <td>
                <input type="number" id="phone" required>
                <p><?php esc_html_e('Country code is required','DTWPLANG'); ?></p>
            </td>
        </tr>
        <tr>
            <th><?php esc_html_e('Message','DTWPLANG'); ?></th>
            <td>
                <select id="QuickMessage_list">
                <option value=""><?php esc_html_e('Choose Quick message','DTWPLANG'); ?></option>
                <?php
                    $QuikMessages = get_option('DTWP_Qmessage_list');
                    if(!empty($QuikMessages)){
                        foreach($QuikMessages as $msg_id){
                            $msg = get_option($msg_id);
                            ?> <option value="<?php esc_attr_e($msg['DTW_Qmessage_Message']); ?>"><?php esc_html_e($msg['DTW_Qmessage_Title']); ?></option><?php
                        }
                    }
                
                ?>
                <textarea class="dtwp_message" id="dtwp_message"></textarea>
            </td>
        </tr>
    </table>
    <button id="SubmitBtn" type="button" class="button button-primary"><?php esc_html_e('Send message','DTWPLANG'); ?></button>
</div>
<script>
//QuickMessages
jQuery('#QuickMessage_list').change(function(){
    jQuery("#dtwp_message").text(jQuery('#QuickMessage_list').find(":selected").val());
});


//form set params
jQuery('#SubmitBtn').click(function(){
    var phone =  jQuery("#phone").val();
    var message = jQuery("#dtwp_message").val();
    sendMessage(phone,message);
}); 
</script>