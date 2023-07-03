<?php
/**
 * TWChat_floating_settings class
 * @package TWChat
 */

namespace twchat\addons\floating_widget\classes;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Settings {

    public function __construct() {
        // Hook into the filter to add sections
        add_filter('twchat_settings_sections', array($this, 'add_section'));
        // Hook into the filter to add fields
        add_filter('twchat_settings_fields', array($this, 'add_fields'));
    }

    // Callback function to add fields
    public function add_fields($fields) {
        // Define an array of default fields for the floating widget
        $default_fields =  array(
            array(
                'id' => 'widget_title',
                'title' => __('Heading Title', 'twchatlang'),
                'description' => __('It will be displayed on the top of the widget.', 'twchatlang'),
                'type' => 'text',
                'callback' => 'text_callback',
                'page' => 'twchat-floating',
                'section' => 'floating',
                'args' => array('id' => 'widget_title' , 'default' => __('Chat with us!', 'twchatlang')),
                'priority' => '0'
            ),
            array(
                'id' => 'widget_description',
                'title' => __('Description', 'twchatlang'),
                'description' => __('It will be displayed after the title.', 'twchatlang'),
                'type' => 'textarea',
                'callback' => 'textarea_callback',
                'page' => 'twchat-floating',
                'section' => 'floating',
                'args' => array('id' => 'widget_description' , 'default' => __("We are here to answer any question you may have about our services. Reach out to us and we'll respond as soon as we can.", 'twchatlang')),
                'priority' => '10'
            ),
            array(
                'id' => 'widget_bubble_is_enabled',
                'title' => __('Bubble', 'twchatlang'),
                'description' => __('Enable or disable the bubble.', 'twchatlang'),
                'type' => 'checkbox',
                'callback' => 'checkbox_callback',
                'page' => 'twchat-floating',
                'section' => 'floating',
                'args' => array('id' => 'widget_bubble_is_enabled' , 'default' => '1'),
                'priority' => '20'
            ),
            array(
                'id' => 'widget_bubble_text',
                'title' => __('Bubble Text', 'twchatlang'),
                'description' => __('It will be displayed on the bubble when the widget is minimized.', 'twchatlang'),
                'type' => 'text',
                'callback' => 'textarea_callback',
                'page' => 'twchat-floating',
                'section' => 'floating',
                'args' => array('id' => 'widget_bubble_text' , 'default' => __('Need help?', 'twchatlang'), 'attributes' => array('data-conditional-id' => 'widget_bubble_is_enabled')),
                'priority' => '30'
            ),
            array(
                'id' => 'widget_style',
                'title' => __('Style', 'twchatlang'),
                'type' => 'button',
                'callback' => 'button_callback',
                'page' => 'twchat-floating',
                'section' => 'floating',
                'args' => array('id' => 'widget_style', 'label' => __('Customize Style in Customizer', 'twchatlang') , 'button_class' => 'button button-secondary', 'url' => '/wp-admin/customize.php?autofocus[section]=twchat_floating_widget', 'target' => '_blank'),
                'priority' => '40'
            ),
        );

        // Merge default fields with the existing fields
        $fields = array_merge($fields, $default_fields);
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
