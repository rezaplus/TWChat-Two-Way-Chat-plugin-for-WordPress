<?php
/**
 * TWChat_floating_settings class
 * @package TWChat
 */

namespace twchat\addons\floating_widget\classes;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Settings {
    
    // Define an array of default fields for the floating widget
    public $default_fields = array(
        array(
            'id' => 'widget_title',
            'title' => 'Title',
            'description' => 'It will be displayed on the top of the widget.',
            'type' => 'text',
            'callback' => 'text_callback',
            'page' => 'twchat-floating',
            'section' => 'floating',
            'args' => array('id' => 'widget_title' , 'default' => 'Chat with us!'),
            'priority' => '0'
        ),
        array(
            'id' => 'widget_description',
            'title' => 'Description',
            'description' => 'It will be displayed after the title.',
            'type' => 'textarea',
            'callback' => 'textarea_callback',
            'page' => 'twchat-floating',
            'section' => 'floating',
            'args' => array('id' => 'widget_description' , 'default' => "We are here to answer any question you may have about our services. Reach out to us and we'll respond as soon as we can."),
            'priority' => '10'
        ),
        array(
            'id' => 'widget_bubble_is_enabled',
            'title' => 'Bubble',
            'description' => 'Enable or disable the bubble.',
            'type' => 'checkbox',
            'callback' => 'checkbox_callback',
            'page' => 'twchat-floating',
            'section' => 'floating',
            'args' => array('id' => 'widget_bubble_is_enabled' , 'default' => '1'),
            'priority' => '20'
        ),
        array(
            'id' => 'widget_bubble_text',
            'title' => 'Bubble Text',
            'description' => 'It will be displayed on the bubble of the widget.',
            'type' => 'text',
            'callback' => 'textarea_callback',
            'page' => 'twchat-floating',
            'section' => 'floating',
            'args' => array('id' => 'widget_bubble_text' , 'default' => 'Hey! Need help?', 'attributes' => array('data-conditional-id' => 'widget_bubble_is_enabled')),
            'priority' => '30'
        ),
        array(
            'id' => 'widget_style',
            'title' => 'Style',
            'type' => 'button',
            'callback' => 'button_callback',
            'page' => 'twchat-floating',
            'section' => 'floating',
            'args' => array('id' => 'widget_style', 'label' => 'Customize Style in Customizer', 'button_class' => 'button button-secondary', 'url' => '/wp-admin/customize.php?autofocus[section]=twchat_floating_widget', 'target' => '_blank'),
            'priority' => '40'
        ),
    );

    public function __construct() {
        // Hook into the filter to add sections
        add_filter('twchat_settings_sections', array($this, 'add_section'));
        // Hook into the filter to add fields
        add_filter('twchat_settings_fields', array($this, 'add_fields'));
    }

    // Callback function to add fields
    public function add_fields($fields) {
        // Merge default fields with the existing fields
        $fields = array_merge($fields, $this->default_fields);
        return $fields;
    }

    // Callback function to add section
    public function add_section($sections) {
        // Add a new section for the floating widget
        $sections[] = array(
            'id' => 'floating',
            'title' => __('Floating Widget', 'twchatlang'),
            'callback' => null,
            'page' => 'twchat-floating',
            'priority' => 20,
        );
        return $sections;
    }
}
