<?php
add_action('woocommerce_admin_order_preview_start',function(){ ?>
<style>
    #TWCH_woocommerce img {
        color: #00aa20a6;
        width: 30px;
        cursor: pointer;
    }
    #TWCH_woocommerce {
        margin-top: 8px;
        display: flex;
    }
    .qms_premium:hover span {
    display: block;
    position: absolute;
    background: #4d4d4d;
    padding: 10px;
    color: #e1e1e1;
    width: max-content;
    border-radius: 5px;
    top: -5px;
    left: 40px;
    }
    .TWCH-tooltip{
        display:none;
    }
</style>
    <div id="TWCH_woocommerce">
    <img   onclick="sendMessage('{{data.data.billing.phone}}','')" src="<?php echo TWCH_image ?>whatsapp.svg">
    <?php
	$TWCH_general = get_option('TWCH_General_Option');
	if($TWCH_general['qmessage_is_enable']=='true'){ ?>
        <div class="qms_premium" style=" filter: grayscale(1); display: flex;">
            <img   src="<?php echo TWCH_image ?>Quick.svg" id="QuickMessage_btn">
            <span class='TWCH-tooltip'><?php esc_html_e('You need to get the premium version for this feature.','TWCHLANG'); ?></span>
        </div>
    <?php } ?>
    </div>
    <style onload="TWCH_Preview_order_pos();"></style>
    <?php });
