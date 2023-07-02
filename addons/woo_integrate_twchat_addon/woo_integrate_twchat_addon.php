<?php
/**
 * Plugin Name: WooCommerce Integration
 * Description: Send messages to your WooCommerce customers.
 * Plugin URI: https://rellaco.com/product/plugins/add-ons/twchat/
 * Version: 1.0.0
 * Author: Rellaco
 * Author URI: https://rellaco.com
 */

namespace twchat\addons\woo_integrate;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

use twchat\TWChat_Core;
use twchat\helpers\AutoLoader;
use twchat\Addons\woo_integrate\classes\Settings;
use twchat\Addons\woo_integrate\classes\Send_message;


// Initialize the addon
woo_integrate_twchat_addon::get_instance();

class woo_integrate_twchat_addon extends TWChat_Core
{
    /**
     * instance of the class
     * 
     * @var object
     */
    private static $instance;


    /**
     * Initializes the addon.
     */
    public function __construct()
    {
        // Define constants
        $this->define_constants();

        $className = str_replace(__NAMESPACE__ . '\\', '', __CLASS__);

        // Load classes
        AutoLoader::init()->setAddonAutoLoader($className);

        // Load settings
        AutoLoader::init()->getInstanceOf(Settings::class, [], 'admin');

        // Only load on WooCommerce orders page or order edit page
        if ((isset($_GET['post_type']) && $_GET['post_type'] == 'shop_order') || (isset($_GET['post']) && get_post_type($_GET['post']) == 'shop_order')) {
            // Load send message
            AutoLoader::init()->getInstanceOf(Send_message::class, [], 'admin');
        }
    }

    /**
     * Defines the addon constants.
     */
    public function define_constants()
    {
        // Define constants
        defined('TWCHAT_ADDON_WOOINTEGRATE_VERSION') or define('TWCHAT_ADDON_WOOINTEGRATE_VERSION', '1.0.0');
        defined('TWCHAT_ADDON_WOOINTEGRATE_DIR_URL') or define('TWCHAT_ADDON_WOOINTEGRATE_DIR_URL', plugin_dir_url(__FILE__));
        defined('TWCHAT_ADDON_WOOINTEGRATE_IMG_URL') or define('TWCHAT_ADDON_WOOINTEGRATE_IMG_URL', TWCHAT_ADDON_WOOINTEGRATE_DIR_URL . 'includes/assets/images/');
    }

    /**
     * Returns an instance of this class.
     * 
     * @return object A single instance of this class.
     */
    public static function get_instance()
    {
        if (!isset(self::$instance) && !(self::$instance instanceof self)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}