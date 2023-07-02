<?php

/**
 * TWChat_WooCommerce_Settings class
 * @package TWChat
 * @subpackage TWChat/add-ons/woocommerce/classes
 */

namespace twchat\addons\woo_integrate\classes;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class Settings
{
    /**
     * Default fields for WooCommerce settings
     * @var array
     */
    public $default_fields = [
        [
            'id' => 'application_mode',
            'title' => 'Application Mode',
            'description' => 'Choose the way you want to send messages to your customers',
            'type' => 'select',
            'callback' => 'select_callback',
            'page' => 'twchat-woocommerce',
            'section' => 'woocommerce',
            'args' => [
                'id' => 'application_mode',
                'options' => [
                    'auto' => 'Auto (Recommended)',
                    'application' => 'Application - Should have WhatsApp installed on your device',
                    'browser' => 'Browser (Web Application)'
                ],
                'default' => 'auto'
            ],
            'priority' => '0'
        ],
    ];

    /**
     * Initialize the Settings class
     */
    public function __construct()
    {
        // Add sections
        add_filter('twchat_settings_sections', [$this, 'add_section']);

        // Add fields
        add_filter('twchat_settings_fields', [$this, 'add_fields']);
    }

    /**
     * Add fields to TWChat settings
     * @param array $fields
     * @return array
     */
    public function add_fields($fields)
    {
        // Merge default fields with the fields array
        $fields = array_merge($fields, $this->default_fields);
        return $fields;
    }

    /**
     * Add WooCommerce section to TWChat settings
     * @param array $sections
     * @return array
     */
    public function add_section($sections)
    {
        $sections[] =  [
            'id' => 'woocommerce',
            'title' => __('WooCommerce', 'twchatlang'),
            'callback' => null,
            'page' => 'twchat-woocommerce',
            'priority' => 30,
        ];
        return $sections;
    }
}
