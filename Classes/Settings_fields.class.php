<?php

/**
 * Define Plugin Settings Fields and Sections
 *
 * usage:
 * add_filter( 'twchat_settings_fields', function($defaultFields){ return $defaultFields[]; });
 * add_filter( 'twchat_settings_sections', function($defaultSections){ return $defaultSections[]; });
 *
 * @package TWChat
 * @since 4.0.0
 */

namespace twchat\classes;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Define default sections
$defaultSections = array(
    array(
        'id' => 'general',
        'title' => __('General Settings', 'twchatlang'),
        'callback' => null,
        'page' => 'twchat-general',
        'priority' => '0'
    ),
);

// Define default fields for the general section
$defaultFields = array(
    array(
        'id' => 'enable_direct_message',
        'title' => 'Enable Direct Message',
        'description' => 'Enable/Disable WhatsApp Button in admin toolbar for easy access to the send message page.',
        'type' => 'checkbox',
        'callback' => 'checkbox_callback',
        'page' => 'twchat-general',
        'section' => 'general',
        'args' => array('id' => 'enable_direct_message', 'default' => 1),
        'priority' => '0'
    ),
    array(
        'id' => 'static_country_code',
        'title' => 'Enable Static Country Code',
        'description' => 'If phone numbers are being submitted without a country code, you can enable the option to set a static country code.',
        'type' => 'checkbox',
        'callback' => 'checkbox_callback',
        'page' => 'twchat-general',
        'section' => 'general',
        'args' => array('id' => 'static_country_code'),
        'priority' => '10'
    ),
    array(
        'id' => 'country_code',
        'title' => 'Country Code',
        'description' => 'Select a country code to be used for all phone numbers.',
        'type' => 'select',
        'callback' => 'country_code_callback',
        'page' => 'twchat-general',
        'section' => 'general',
        'args' => array('id' => 'country_code', 'attributes' => array('data-conditional-id' => 'static_country_code')),
        'priority' => '20'
    ),
);

// Initialize the Settings_fields class
$settings_fields = Settings_fields::init();
$settings_fields->set_defaults_section($defaultSections);
$settings_fields->set_defaults_field($defaultFields);

class Settings_fields
{

    /**
     * The name of the settings
     * 
     * @var string
     */
    public $settings_name = 'twchat_settings';


    /**
     * The default fields array
     *
     * @var array
     */
    public $defaultFields = array();
    /**
     * The default sections array
     *
     * @var array
     */
    public $defaultSections = array();

    /**
     * Instance of the Settings_fields class
     * 
     */
    private static $instance;

    /**
     * initialize the Settings_fields class
     *
     * @return void
     */
    public function __construct()
    {
        // Add sections
        add_filter('twchat_settings_sections', array($this, 'add_sections'));
        
        // Add fields
        add_filter('twchat_settings_fields', array($this, 'add_fields'));

    }

    /**
     * Add fields to the existing fields array
     *
     * @param array $fields The existing fields array
     * @return array The modified fields array
     */
    public function add_fields($fields)
    {
        // Merge default fields with the existing fields
        $fields = array_merge($fields, $this->defaultFields);
        return $fields;
    }

    /**
     * Add sections to the existing sections array
     *
     * @param array $sections The existing sections array
     * @return array The modified sections array
     */
    public function add_sections($sections)
    {
        // Merge default sections with the existing sections
        $sections = array_merge($sections, $this->defaultSections);
        return $sections;
    }

    /**
     * Get the default sections
     *
     * @return array The default sections array
     */
    public function get_default_sections()
    {
        return apply_filters($this->settings_name.'_sections', array());
    }

    /**
     * Get the default fields
     *
     * @return array The default fields array
     */
    public function get_default_fields()
    {
        return apply_filters($this->settings_name.'_fields', array());
    }

    /**
     * Set the default sections
     * 
     * @param array $sections The default sections array
     * @return void
     */
    public function set_defaults_section($sections)
    {
        $this->defaultSections = $sections;
    }

    /**
     * Set the default fields
     * 
     * @param array $fields The default fields array
     * @return void
     */
    public function set_defaults_field($fields)
    {
        $this->defaultFields = $fields;
    }

    /**
     * Get the Settings_fields class instance
     *
     * @return object The Settings_fields class instance
     */
    public static function init()
    {
        if (!isset(self::$instance) && !(self::$instance instanceof Settings_fields)) {
            self::$instance = new Settings_fields();
        }
        return self::$instance;
    }
}
