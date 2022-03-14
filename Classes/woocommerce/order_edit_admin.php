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
        $html .= "<label for='ready_messages_list' >" . __('Ready messages', 'TWCHLANG') . wc_help_tip('Choose ready meassages') . "</label>";
        $html .= "<select id='ready_messages_list' style='width:100%; margin-bottom: 5px;' onchange='document.getElementById(\"TWCH_message_text\").value=this.value'>";
        $html .= "<option value=''>" . __('Empty', 'TWCHLANG') . "</option>";
        $html .=  replace_message_shortcodes($order);
        $html .= "</select>";
    }
    $html .= "<label for='TWCH_message_text' >" . __('Message text', 'TWCHLANG') . "</label>";
    $html .= "<textarea id='TWCH_message_text' style='width:100%; height: 100px;'></textarea>";
    $html .= "<div class='wide' style='text-align: left' >";
    $html .= "<hr><input type='button' class='button button-primary' value='" . __('Send Message', 'TWCHLANG') . "' onclick='sendMessage($whatsapp_number, document.getElementById(\"TWCH_message_text\").value )'  ></div>";
    $html .= "</div>";
    echo $html;
}
/**
 * replace message shortcodes
 * return ready messages
 */
function replace_message_shortcodes($order)
{

    $country = $order->get_billing_country();
    $state = $order->get_billing_state();
    $state = WC()->countries->get_states($country)[$state];
    $ready_messages = get_option('TWCH_Qmessage_list');
    $options = '';
    foreach ($ready_messages as $qmsg) {
        $qmsg = get_option($qmsg);
        $message = esc_html($qmsg['TWCH_Qmessage_Message']);
        $message = str_replace("[orderID]", $order->get_order_number(), $message);
        $message = str_replace("[Fname]", $order->get_billing_first_name(), $message);
        $message = str_replace("[Lname]", $order->get_billing_last_name(), $message);
        $message = str_replace("[PaymentMethod]", $order->get_payment_method_title(), $message);
        $message = str_replace("[Status]", wc_get_order_status_name($order->get_status()), $message);
        $message = str_replace("[state]", $state, $message);
        $message = str_replace("[City]", $order->get_billing_city(), $message);
        $message = str_replace("[Address1]", $order->get_billing_address_1(), $message);
        $message = str_replace("[Address2]", $order->get_billing_address_2(), $message);
        $message = str_replace("[phone]", $order->get_billing_phone(), $message);
        $message = str_replace("[Email]", $order->get_billing_email(), $message);
        $message = str_replace("[Transaction]", $order->get_transaction_id(), $message);
        $message = str_replace("[Items]", items_order($order), $message);
        $message = str_replace("[thanks_page]", urlencode($order->get_checkout_order_received_url()), $message);
        $message = str_replace("[payment_url]", urlencode($order->get_checkout_payment_url()), $message);
        $message = str_replace("[shipping_total]", $order->get_shipping_total() . " " . get_woocommerce_currency_symbol(), $message);
        $message = str_replace("[shipping_method]", $order->get_shipping_method(), $message);
        $message = str_replace("[review]", order_list_review($order), $message);
        $message = str_replace("[product_Link]", order_list_link($order), $message);
        $message = str_replace("[total]", $order->get_total() . " " . get_woocommerce_currency_symbol(), $message);


        $options .= "<option value='" . $message . "'>";
        $options .= esc_html($qmsg['TWCH_Qmessage_Title']);
        $options .= "</option>";
    }
    return $options;
}
