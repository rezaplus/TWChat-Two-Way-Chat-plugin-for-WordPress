<?php

/**
 * Direct Message class.
 * Send a message to any number you want.
 */

namespace twchat\classes;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Direct_message
{

    /**
     * Initializes the class.
     */
    public function __construct()
    {
        /*
        * add admin bar menu for direct message 
        * if enable_direct_message is true
        */
        if (twchat_get_setting('enable_direct_message')) {
            add_action('admin_bar_menu', array($this, 'admin_bar_menu'), 99);
        }
        // enqueue scripts
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
    }

    /**
     * Create the send message to custom number page.
     */
    public function create_admin_page()
    {
        require_once TWCHAT_TEMPLATES_PATH . 'admin/direct_message.php';
    }
    
    /**
     * Add admin bar menu.
     * 
     * @param object $wp_admin_bar
     * @return void
     */
    public function admin_bar_menu($wp_admin_bar)
    {
        $args = array(
            'id' => 'direct-message',
            'title' => '<span class="ab-icon dashicons dashicons-whatsapp" style="font-size: large;line-height: 23px;"></span>',
            'href' => admin_url() . 'admin.php?page=TWChat_direct_message'
        );
        $wp_admin_bar->add_node($args);
    }

    /**
     * Enqueues the necessary JavaScript and CSS files for the settings page.
     */
    public function admin_enqueue_scripts()
    {
        twchat_load_scripts('css', 'twchat-settings', TWCHAT_ASSETS_URL . '/css/twchat_direct_message.css', array(), array('twchat_page_TWChat_direct_message'), TWCH_VERSION);
    }
}
