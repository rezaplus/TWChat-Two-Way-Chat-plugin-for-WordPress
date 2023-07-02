<?php

namespace twchat\addons\floating_widget\classes;

use twchat\helpers\AutoLoader;
use twchat\classes\Custom_post_type;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

AutoLoader::init()->getInstanceOf(Custom_post_type::class, [], 'admin');

class Accounts extends Custom_post_type
{
    public $post_type = 'twchat_account';

    public function __construct()
    {
        // Add metaboxes using the 'twchat/account_details/metaboxes' filter
        add_filter('twchat/account_details/metaboxes', array($this, 'initialize_metaboxes'), 50, 1);

        // Add metaboxes using the 'TWChat_floating_contacts_fields' filter
        add_filter('TWChat_floating_contacts_fields', array($this, 'TWChat_floating_contacts_fields'));

        // Add WhatsApp contact HTML using the 'twchat/floating_widget/contact_WhatsApp' filter
        add_filter('twchat/floating_widget/contact_WhatsApp', array($this, 'twchat_floating_widget_contact_WhatsApp'), 10, 1);

        // Add email contact HTML using the 'twchat/floating_widget/contact_Email' filter
        add_filter('twchat/floating_widget/contact_Email', array($this, 'twchat_floating_widget_contact_Email'), 10, 1);

        // Add phone contact HTML using the 'twchat/floating_widget/contact_Phone' filter
        add_filter('twchat/floating_widget/contact_Phone', array($this, 'twchat_floating_widget_contact_Phone'), 10, 1);
    }

    /**
     * Initialize metaboxes.
     *
     * @param array $metaboxes Existing metaboxes.
     * @return array Modified metaboxes.
     */
    public function initialize_metaboxes($metaboxes)
    {
        $floating_metaboxes = array(
            array('TWChat_floating_contacts', __('Available Contacts', 'twchatlang'), 'side', 'high'),
        );
        return array_merge($metaboxes, $floating_metaboxes);
    }

    /**
     * Define meta fields.
     *
     * @param array $fields Existing meta fields.
     * @return array Modified meta fields.
     */
    public function TWChat_floating_contacts_fields($fields)
    {
        // Add available contacts field
        $fields['available_contacts'] = array(
            'label' => __('Choose the available contacts for the floating widget.', 'twchatlang'),
            'type' => 'checkbox',
            'priority' => '10',
            'options' => array(
                'WhatsApp' => __('WhatsApp', 'twchatlang'),
                'Phone' => __('Phone', 'twchatlang'),
                'Email' => __('Email', 'twchatlang')
            )
        );
        return $fields;
    }

    /**
     * Add WhatsApp contact HTML.
     *
     * @param int $account_id Account ID.
     * @return array|false WhatsApp contact HTML or false if not set.
     */
    public function twchat_floating_widget_contact_WhatsApp($account_id)
    {
        $account_whatsapp = get_post_meta($account_id, 'TWChat_account_whatsapp', true);
        
        // If account WhatsApp is not set, return false
        if (!isset($account_whatsapp['whatsapp_number']) || empty($account_whatsapp['whatsapp_number'])) {
            return false;
        }
        
        $icon = TWCHAT_ADDON_FLOATING_IMG_URL . 'icons/whatsapp.svg';
        
        // Link
        $link = 'https://api.whatsapp.com/send?phone=' . esc_attr($account_whatsapp['whatsapp_number']) . '&text=' . esc_attr($account_whatsapp['whatsapp_message']);
        
        return array(
            'Icon' => $icon,
            'Link' => $link,
        );
    }

    /**
     * Add email contact HTML.
     *
     * @param int $account_id Account ID.
     * @return array|false Email contact HTML or false if not set.
     */
    public function twchat_floating_widget_contact_Email($account_id)
    {
        $account_email = get_post_meta($account_id, 'TWChat_account_details', true);
        
        // If account email is not set, return false
        if (!isset($account_email['email']) || empty($account_email['email'])) {
            return false;
        }
        
        $icon = TWCHAT_ADDON_FLOATING_IMG_URL . 'icons/email.svg';
        
        // Link
        $link = 'mailto:' . esc_attr($account_email['email']);
        
        return array(
            'Icon' => $icon,
            'Link' => $link,
        );
    }

    /**
     * Add phone contact HTML.
     *
     * @param int $account_id Account ID.
     * @return array|false Phone contact HTML or false if not set.
     */
    public function twchat_floating_widget_contact_Phone($account_id)
    {
        $account_phone = get_post_meta($account_id, 'TWChat_account_details', true);
        
        // If account phone is not set, return false
        if (!isset($account_phone['phone']) || empty($account_phone['phone'])) {
            return false;
        }
        
        $icon = TWCHAT_ADDON_FLOATING_IMG_URL . 'icons/phone.svg';
        
        // Link
        $link = 'tel:' . esc_attr($account_phone['phone']);
        
        return array(
            'Icon' => $icon,
            'Link' => $link,
        );
    }
}
