<?php
 /**
 * Plugin Name: Floating Widget
 * Description: Add a floating widget to your website to allow your customers to contact you.
 * Plugin URI: https://rellaco.com/product/plugins/add-ons/twchat/
 * Version: 1.0.0
 * Author: Rellaco
 * Author URI: https://rellaco.com
 */

namespace twchat\addons\floating_widget;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

use twchat\TWChat_Core;
use twchat\helpers\AutoLoader;
use twchat\addons\floating_widget\classes\Settings;
use twchat\addons\floating_widget\classes\Customizer;
use twchat\addons\floating_widget\classes\Template;
use twchat\addons\floating_widget\classes\Accounts;

// Initialize the addon
floating_widget_twchat_addon::get_instance();


class floating_widget_twchat_addon extends TWChat_Core
{

    /**
     * instance of the class
     * 
     * @var object
     */
    private static $instance;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Define constants
        $this->define_constants();

        // Get current class name with namespace
        $className = str_replace(__NAMESPACE__ . '\\', '', __CLASS__);

        // Load addon autoloader
        AutoLoader::init()->setAddonAutoLoader($className);

        // Load settings
        AutoLoader::init()->getInstanceOf(Settings::class, [], 'admin');

        // Load customizer
        AutoLoader::init()->getInstanceOf(Customizer::class , [], 'both');
        AutoLoader::init()->getInstanceOf(Template::class, [], 'both');

        // Load account
        AutoLoader::init()->getInstanceOf(Accounts::class , [], 'both');

        // Enable accounts
        add_filter('twchat_accouns_is_enable', '__return_true');

        // Enable social settings
        add_filter('twchat_social_is_enable', '__return_true');
    }

    /**
     * Define constants
     */
    public function define_constants()
    {
        // Define constants
        defined('TWCHAT_ADDON_FLOATING_VERSION') or define('TWCHAT_ADDON_FLOATING_VERSION', '1.0.0');
        defined('TWCHAT_ADDON_FLOATING_DIR') or define('TWCHAT_ADDON_FLOATING_DIR', plugin_dir_path(__FILE__));
        defined('TWCHAT_ADDON_FLOATING_DIR_URL') or define('TWCHAT_ADDON_FLOATING_DIR_URL', plugin_dir_url(__FILE__));
        defined('TWCHAT_ADDON_FLOATING_IMG_URL') or define('TWCHAT_ADDON_FLOATING_IMG_URL', TWCHAT_ADDON_FLOATING_DIR_URL . 'includes/assets/images/');
    }

    /**
     * Load template
     */
    public function load_template()
    {
        require_once TWCHAT_ADDONS_PATH . 'floating_widget/templates/widget.php';
    }

    /**
     * Get instance of the class
     * 
     * @return object
     */
    public static function get_instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}


