<?php

/**
 * TWChat WooCommerce Send Message
 * Send message to Customers on WooCommerce
 *
 * @package TWChat
 * @version 1.0.0
 */

namespace twchat\addons\woo_integrate\classes;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Send_message
{
    /**
     * Options for sending messages
     * @var array
     */
    public $options = [];

    /**
     * Initialize the SendMessage class
     */
    public function __construct()
    {
        // Get settings options
        $this->get_settings_options();

        // Add action to WooCommerce admin order preview
        add_action('woocommerce_admin_order_preview_start', [$this, 'twchat_woocommerce_preview_order']);

        // Add action to WooCommerce admin order preview actions
        add_action('twchat/addon/woo_integrate/order_preview', [$this, 'send_message_button_preview']);

        // Add meta box to WooCommerce admin order edit page
        add_action('add_meta_boxes', [$this, 'twchat_woocommerce_add_meta_box']);

        // Add send message textarea to WooCommerce admin order edit page actions
        add_action('twchat/addon/woo_integrate/order_edit', [$this, 'send_message_textarea_edit_page'], 10, 1);

        // Add WhatsApp button to WooCommerce admin order edit page actions
        add_action('twchat/addon/woo_integrate/order_edit', [$this, 'whatsapp_button_edit_page'], 20, 1);

        // Load scripts on WooCommerce admin orders page
        add_action('admin_enqueue_scripts', [$this, 'woocommerce_admin_scripts']);
    }

    /**
     * Get settings options
     */
    public function get_settings_options()
    {
        $this->options = twchat_get_settings(['application_mode', 'static_country_code', 'country_code']);
    }

    /**
     * Add meta box to WooCommerce admin order edit page
     */
    public function twchat_woocommerce_add_meta_box()
    {

        // return if is not order edit page
        if (get_post_type() !== 'shop_order' || !isset($_GET['post']) || (isset($_GET['action']) && $_GET['action'] !== 'edit')) {
            return;
        }

        add_meta_box(
            'twchat_woocommerce_send_message',
            __('Send Message', 'twchatlang'),
            [$this, 'twchat_woocommerce_send_message_meta_box'],
            'shop_order',
            'side',
            'core'
        );
    }

    /**
     * Render meta box content
     */
    public function twchat_woocommerce_send_message_meta_box()
    {
        // Get order phone number
        $order = new \WC_Order($_GET['post'] ?? '');
        $phoneNumber = $order->get_billing_phone();        

        if (empty($phoneNumber)) {
            echo sprintf(
                '<p>%s</p>',
                __('Phone number is not available', 'twchatlang')
            );
            return;
        }

        ob_start();
        do_action('twchat/addon/woo_integrate/order_edit', $phoneNumber);
        $actionsHtml = ob_get_clean();

        echo sprintf(
            '<div id="twchat_woocommerce" class="twchat_send_message_section">%s</div>',
            $actionsHtml
        );
    }

    /**
     * Render WhatsApp button on WooCommerce admin order edit page
     */
    public function whatsapp_button_edit_page($phoneNumber)
    {
        $onclick = sprintf("twchat.sendMessage('%s', document.getElementById('twch_message_text').value)", $phoneNumber);

        $buttonHtml = sprintf(
            '<input type="button" class="button button-secondary" value="%s" onClick="%s" />',
            __('Send via WhatsApp', 'twchatlang'),
            $onclick
        );

        echo $buttonHtml;
    }

    /**
     * Render send message textarea on WooCommerce admin order edit page
     */
    public function send_message_textarea_edit_page($phoneNumber)
    {
        echo sprintf(
            '<textarea id="twch_message_text" style="%s" placeholder="%s"></textarea>',
            'width:100%; height: 100px;',
            __('Type your message here', 'twchatlang')
        );
    }

    /**
     * Perform action on WooCommerce admin order preview
     */
    public function twchat_woocommerce_preview_order()
    {
        ob_start();
        do_action('twchat/addon/woo_integrate/order_preview');
        $buttonHtml = ob_get_clean();
        echo sprintf(
            '<div id="twchat_woocommerce" class="twchat_send_message_section">%s</div>',
            $buttonHtml
        );
        echo '<style onload="replaceButtonLocation()"></style>';
    }

    /**
     * Render send message button on WooCommerce admin order preview
     */
    public function send_message_button_preview()
    {
        $src = TWCHAT_ADDON_WOOINTEGRATE_IMG_URL . 'whatsapp.svg';
        $onclick = "twchat.sendMessage('{{data.data.billing.phone}}', jQuery('.twchat_send_message_button').data('message'))";
        $style = 'width: 30px; height: 30px; cursor: pointer; margin-top: 10px;';
        echo sprintf(
            '<img src="%s" onclick="%s" style="%s" title="Send Message" alt="Send Message" data-message="" class="twchat_send_message_button" />',
            $src,
            $onclick,
            $style
        );
    }

    /**
     * Load scripts on WooCommerce admin orders page
     */
    public function woocommerce_admin_scripts()
    {
        // Get options
        $args = $this->options;

        // Get country code
        $args['country_code'] = $this->get_country_code();

        twchat_load_scripts(
            'js',
            'twchat_woocommerce_admin_note_scripts',
            TWCHAT_ADDON_WOOINTEGRATE_DIR_URL . 'includes/assets/js/twchat_woo_orders.js',
            ['jquery'],
            null,
            TWCHAT_ADDON_WOOINTEGRATE_VERSION,
            true,
            $args
        );
    }

    /**
     * Get the country code
     * @return string
     */
    public function get_country_code()
    {
        // Check if static country code is enabled
        if (isset($this->options['static_country_code']) && $this->options['static_country_code']) {
            // Check if country code is set
            if (isset($this->options['country_code']) && !empty($this->options['country_code'])) {
                return $this->options['country_code'];
            }
        }
        // Return empty string if not set
        return '';
    }
}
