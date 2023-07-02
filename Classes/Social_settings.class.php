<?php

/**
 * The Social_settings class
 *
 * @since 4.0.0
 * @package TWChat
 */

 namespace twchat\classes;

 // Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Class Social_settings
 * Defines the social settings fields and sections.
 */
class Social_settings
{
    /**
     * The default fields array
     *
     * @var array
     */
    public $defaultFields;

    /**
     * The default sections array
     *
     * @var array
     */
    public $defaultSections;

    /**
     * Initializes the Social_settings class.
     */
    public function __construct()
    {

        // set default sections
        $this->set_defaultSections();

        // set default fields
        $this->set_defaultFields();

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
     * Set the default fields
     * 
     * @return void
     */
    public function set_defaultFields()
    {
        $this->defaultFields = array(
            array(
                'id' => 'social',
                'title' => __('Social Links', 'twchatlang'),
                'description' => __('Please enter your social links.', 'twchatlang'),
                'type' => 'array',
                'callback' => 'social_callback',
                'page' => 'twchat-social',
                'section' => 'social',
                'args' => array('id' => 'social', 'default' => array(
                    'instagram' => array(
                        'url' => 'https://www.instagram.com/rellaco_com/',
                        'icon' => 'instagram'
                    ),
                )),
                'priority' => '20'
            )
        );
    }

    /**
     * Set the default sections
     * 
     * @return void
     */
    public function set_defaultSections()
    {
        $this->defaultSections = array(
            array(
                'id' => 'social',
                'title' => __('Social', 'twchatlang'),
                'callback' => null,
                'page' => 'twchat-social',
                'priority' => '80'
            ),
        );
    }
}
