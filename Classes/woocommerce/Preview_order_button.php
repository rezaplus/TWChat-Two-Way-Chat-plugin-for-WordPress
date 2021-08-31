<?php
add_action('woocommerce_admin_order_preview_start',function(){ ?>
<style>
    #DTWhatsap_woocommerce img {
        color: #00aa20a6;
        width: 30px;
        cursor: pointer;
    }
    #DTWhatsap_woocommerce {
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
    right: 40px;
    }
    .dtwp-tooltip{
        display:none;
    }
</style>
    <div id="DTWhatsap_woocommerce">
    <img   onclick="sendMessage('{{data.data.billing.phone}}','')" src="<?php echo DTWP_image ?>whatsapp.svg">
        <div class="qms_premium" style=" filter: grayscale(1); display: flex;">
            <img   src="<?php echo DTWP_image ?>Quick.svg" id="QuickMessage_btn">
            <span class='dtwp-tooltip'><?php esc_html_e('You need to get the premium version for this feature.','DTWPLANG'); ?></span>
        </div>
    </div>
    <style onload="DTWP_Preview_order_pos();"></style>
    <?php });
