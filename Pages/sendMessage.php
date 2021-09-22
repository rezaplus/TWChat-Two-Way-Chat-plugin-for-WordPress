<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$TWCH_general = get_option('TWCH_General_Option');
wp_enqueue_style('sendMessage',  TWCH_assets .'sendMessage.css', array() , TWCH_plugin_version);
wp_enqueue_script('TWCH_ORS', TWCH_assets . 'Orders.js', array() , TWCH_plugin_version , true);
wp_localize_script('TWCH_ORS', 'TWCH_ORS', array(
    'Applicationmode' => $TWCH_general['Applicationmode'],
    'fix_countrycode' => 'false',
    'Country_Code' => $TWCH_general['Country_Code']
)); 
?>
<h1><?php esc_html_e('Send message','TWCHLANG'); ?></h1>
<div id="sendMessageForm">
    <table class="form-table TWCH-form-table">
        <tr class="phoneNumber">
            <th><?php esc_html_e('Phone','TWCHLANG'); ?></th>
            <td>
                <input type="number" id="phone" required>
                <p><?php esc_html_e('Country code is required','TWCHLANG'); ?></p>
            </td>
        </tr>
        <tr>
            <th><?php esc_html_e('Message','TWCHLANG'); ?></th>
            <td>
                <select id="QuickMessage_list">
                <option value=""><?php esc_html_e('Choose Quick message','TWCHLANG'); ?></option>
                <?php
                    $QuikMessages = get_option('TWCH_Qmessage_list');
                    if(!empty($QuikMessages)){
                        foreach($QuikMessages as $msg_id){
                            $msg = get_option($msg_id);
                            ?> <option value="<?php esc_attr_e($msg['TWCH_Qmessage_Message']); ?>"><?php esc_html_e($msg['TWCH_Qmessage_Title']); ?></option><?php
                        }
                    }
                
                ?>
                <textarea class="TWCH_message" id="TWCH_message"></textarea>
            </td>
        </tr>
    </table>
    <button id="SubmitBtn" type="button" class="button button-primary"><?php esc_html_e('Send message','TWCHLANG'); ?></button>
</div>
<script>
//QuickMessages
jQuery('#QuickMessage_list').change(function(){
    jQuery("#TWCH_message").text(jQuery('#QuickMessage_list').find(":selected").val());
});


//form set params
jQuery('#SubmitBtn').click(function(){
    var phone =  jQuery("#phone").val();
    var message = jQuery("#TWCH_message").val();
    sendMessage(phone,message);
}); 
</script>