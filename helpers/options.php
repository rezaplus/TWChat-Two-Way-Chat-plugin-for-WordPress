<?php

/**
 * return settings of the plugin in array or return specific option
 * 
 * if TWChatPlugin_options set return TWChatPlugin_options else return default settings
 * 
 * @param array|string $fields
 * @package TWChat
 * @since 4.0.0
 */

 // Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

if (!function_exists('twchat_get_settings')) {
    function twchat_get_settings($fields = array())
    {
        /**
         * get all settings of the plugin
         */
        $TWChatPlugin_options = get_option('TWChatPlugin_options', array());


        /**
         * get default settings of the plugin from filter hook 'twchat_settings_fields'
         *  
         * @see classes/Settings_fields.class.php
         */
        $twchat_settings_fields = apply_filters('twchat_settings_fields', array());

        // move fields id to array key
        $twchat_settings_fields = array_combine(array_column($twchat_settings_fields, 'id'), $twchat_settings_fields);

        // if TWChatPlugin_options is empty 
        if (!empty($TWChatPlugin_options)) {
            $fields_list = array_keys($TWChatPlugin_options);
        }else{
            $fields_list = array_keys($twchat_settings_fields);
        }

        /**
         * collect settings of the plugin in array
         */
        $options = array();
        foreach ($fields_list as $value) {
            if (empty($TWChatPlugin_options) && isset($twchat_settings_fields[$value]['args']['default'])) {
                $options[$value] = $twchat_settings_fields[$value]['args']['default'];
            }elseif (!empty($TWChatPlugin_options) && isset($TWChatPlugin_options[$value])) {
                $options[$value] = $TWChatPlugin_options[$value];   
            }
            
        }

        // if $fields is empty return all settings of the plugin else return specific settings
        if (empty($fields)) {
            return $options;
        }elseif (is_array($fields)) {
            $settings = array();
            foreach ($fields as $value) {
                if (isset($options[$value])) {
                    $settings[$value] = $options[$value];
                }
            }
            return $settings;
        }elseif (is_string($fields)) {
            if (isset($options[$fields])) {
                return $options[$fields];
            }
        }else{
            return false;
        }
    }
}

/**
 * return specific setting of the plugin
 * 
 * @param string $optionName
 * @package TWChat
 * @since 4.0.0
 */
if (!function_exists('twchat_get_setting')) {
    function twchat_get_setting($optionName)
    {
        /*
         * if $optionName is null or empty or not set return false
        */
        if (is_null($optionName) || empty($optionName) || !isset($optionName)) {
            return false;
        }
        /**
         * get all settings of the plugin
         */
        $TWChatPlugin_options = get_option('TWChatPlugin_options', array());

        // get default settings of the plugin from filter hook 'twchat_settings_fields'
        $fields = apply_filters('twchat_settings_fields', array());

        /**
         * move fields id to array key
         */
        $fields = array_combine(array_column($fields, 'id'), $fields);


        /**
         * if option is set return option value
         */
        if (isset($TWChatPlugin_options[$optionName])) {
            return $TWChatPlugin_options[$optionName]; // return option value
        }elseif (isset($fields[$optionName]['args']['default'])) { // if option is not set and default value is set
            return $fields[$optionName]['args']['default']; // return default value
        }
        // return false if option is not set
        return false;
    }
}

