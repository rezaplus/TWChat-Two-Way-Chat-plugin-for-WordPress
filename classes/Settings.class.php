<?php

namespace twchat\classes;

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

use twchat\helpers\Autoloader;
use twchat\classes\Settings_callback;

/**
 * Class Settings
 * Manages the settings page for the TWChat plugin.
 */
class Settings
{
    public $fields = array();
    public $sections = array();

    /**
     * Initializes the Settings class.
     */
    public function __construct()
    {
        // if is not TWChat_settings page, return
        if (!isset($_GET['page']) || $_GET['page'] != 'TWChat_settings') {
            return;
        }

        add_action('admin_init', array($this, 'page_init'));
        add_action('admin_notices', array($this, 'settings_notice'));
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
    }

    /**
     * Creates the admin page.
     */
    public function create_admin_page()
    {
        $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'general';
        $sections = $this->sections;
        require_once TWCHAT_TEMPLATES_PATH . 'admin/settings.php';
    }

    /**
     * Initializes the plugin settings.
     */
    public function page_init()
    {
        register_setting(
            'TWChat_option_group',
            'TWChatPlugin_options',
            array($this, 'sanitize')
        );

        $settings_fields = Autoloader::init()->getInstanceOf(Settings_fields::class, [], 'admin');
        $this->generate_sections($settings_fields->get_default_sections());
        $this->generate_fields($settings_fields->get_default_fields());
    }

    /**
     * Sanitizes the input data.
     *
     * @param array $input The input data.
     * @return array The sanitized input data.
     */
    public function sanitize($input)
    {
        foreach ($input as $key => $value) {
            $fieldType = $this->get_field_type($key);
            $input[$key] = $this->sanitize_field($value, $fieldType);
        }
        return $input;
    }

    /**
     * Sanitizes a field value based on its type.
     *
     * @param mixed $input The field value.
     * @param string $fieldType The field type.
     * @return mixed The sanitized field value.
     */
    public function sanitize_field($input, $fieldType)
    {
        switch ($fieldType) {
            case in_array($fieldType, array('text', 'checkbox', 'select', 'radio', 'number', 'date')):
                $input = sanitize_text_field($input);
                break;
            case 'textarea':
                $input = sanitize_textarea_field($input);
                break;
            case 'email':
                $input = sanitize_email($input);
                break;
            case 'url':
                $input = esc_url_raw($input);
                break;
            case 'array':
                array_walk_recursive($input, function (&$item, $key) {
                    $item = sanitize_text_field($item);
                });
                break;
            default:
                $input = sanitize_text_field($input);
                break;
        }
        return $input;
    }

    /**
     * Retrieves the field type based on its ID.
     *
     * @param string $id The field ID.
     * @return mixed The field type if found, false otherwise.
     */
    public function get_field_type($id)
    {
        foreach ($this->fields as $field) {
            if ($field['id'] == $id) {
                if (isset($field['type'])) {
                    return $field['type'];
                } else {
                    return false;
                }
            }
        }
    }

    /**
     * Generates the sections for the settings page.
     *
     * @param array $sections The sections data.
     */
    public function generate_sections($sections)
    {
        $this->sections = $sections;
        usort($this->sections, function ($a, $b) {
            return $a['priority'] <=> $b['priority'];
        });
        foreach ($this->sections as $section) {
            add_settings_section(
                $section['id'],
                $section['title'],
                $section['callback'],
                $section['page']
            );
        }
    }

    /**
     * Generates the fields for the settings page.
     *
     * @param array $fields The fields data.
     */
    public function generate_fields($fields)
    {
        $this->fields = $fields;
        usort($this->fields, function ($a, $b) {
            return $a['priority'] <=> $b['priority'];
        });

        $callback = Autoloader::init()->getInstanceOf(Settings_callback::class, [], 'admin');

        foreach ($this->fields as $field) {
            if (isset($field['description'])) {
                $field['args']['description'] = $field['description'];
            }
            add_settings_field(
                $field['id'],
                $field['title'],
                array($callback, $field['callback']),
                $field['page'],
                $field['section'],
                $field['args']
            );
        }
    }


    function settings_notice()
    {
        if (isset($_GET['settings-updated']) && !isset($_GET['reload'])) {
            $reloadUrl = admin_url('admin.php?page=TWChat_settings&settings-updated=true&reload=true');
            echo '<script type="text/javascript">window.location.href = "' . $reloadUrl . '";</script>';
        } elseif (isset($_GET['reload']) && isset($_GET['settings-updated'])) {
            TWChat_notice(__('Settings saved successfully.', 'twchatlang'), 'success');
        } elseif (isset($_GET['error'])) {
            TWChat_notice(__('Error occurred while saving settings. Please try again.', 'twchatlang'), 'error');
        }
    }

    /**
     * Enqueues the necessary JavaScript and CSS files for the settings page.
     */
    public function admin_enqueue_scripts()
    {
        twchat_load_scripts('css', 'twchat-settings', TWCHAT_ASSETS_URL . '/css/twchat_settings.css', array(), array('twchat_page_TWChat_settings'), TWCH_VERSION);
        twchat_load_scripts('js', 'twchat-settings', TWCHAT_ASSETS_URL . '/js/twchat_settings.js', array(), array('twchat_page_TWChat_settings'), TWCH_VERSION, true);
    }
}
