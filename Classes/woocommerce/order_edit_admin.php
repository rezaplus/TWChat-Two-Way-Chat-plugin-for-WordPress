<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Register Whatsapp meta box.
 */
function TWCH_register_whatsapp_meta_boxes()
{
    add_meta_box('TWCH_woo_whatsapp', __('Whatsapp', 'TWCHLANG'), 'TWCH_woo_whatsapp_metabox_callback', 'shop_order', 'side', 'core');
}
add_action('add_meta_boxes', 'TWCH_register_whatsapp_meta_boxes');

/**
 * Whatsapp Meta box callback
 * return meta box HTML
 */
function TWCH_woo_whatsapp_metabox_callback()
{
    global  $post;
    $order = new WC_Order($post->ID);
    $whatsapp_number = esc_html($order->get_billing_phone());
    $html = "<div>";
    if (get_option('TWCH_General_Option')['qmessage_is_enable'] == 'true') {
        $premium_html = " (<a href='https://rellaco.com/product/twchat-premium/'>".__('Premium','TWCHLANG')."</a>) ";
        $html .= "<label for='ready_messages_list' >" . __('Quick Messages', 'TWCHLANG') .$premium_html. "</label>";
        $html .= "<select id='ready_messages_list' style='width:100%; margin-bottom: 5px;' onchange='document.getElementById(\"TWCH_message_text\").value=this.value' disabled>";
        $html .= "<option value=''>" . __('Empty', 'TWCHLANG') . "</option>";
        $html .= "</select>";
    }
    $html .= "<label for='TWCH_message_text' >" . __('Message', 'TWCHLANG') . "</label>";
    $html .= "<textarea id='TWCH_message_text' style='width:100%; height: 100px;'></textarea>";
    $html .= "<div class='wide' style='text-align: left' >";
    $html .= "<hr><input type='button' class='button button-primary' value='" . __('Send Message', 'TWCHLANG') . "' onclick='sendMessage($whatsapp_number, document.getElementById(\"TWCH_message_text\").value )'  ></div>";
    $html .= "</div>";
    echo $html;
}

