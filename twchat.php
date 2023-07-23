<?php
/**
 * Plugin Name: Two Way Chat
 * Description: Allowing admins to send messages to customers and vice versa through popular chat platforms.
 * Author: Rellaco
 * Version: 4.0.0
 * Author URI: https://rellaco.com
 * Plugin URI: "https://rellaco.com/product/TwoWayChat"
 * Text Domain: twchatlang
 * Domain Path: /languages
 * Requires at least: 5.9
 * Tested up to: 6.2.2
 * Requires PHP: 7.4
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */

namespace TWChat;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

use twchat\helpers\AutoLoader;
use twchat\classes\General;

/**
 * Define plugin dev mode
 * 
 * Avoid cache issues while developing, if you are not a developer, please set this to false
 * 
 * @since 4.0.0
 */
defined( 'TWCH_DEV_MODE' ) or define( 'TWCH_DEV_MODE', true );

/**
 * Define plugin version
 * 
 * @since 1.0.0
 */
defined( 'TWCH_VERSION' ) or define( 'TWCH_VERSION', '4.0.0' );

// run plugin
if ( ! class_exists( 'TWChat_Core' ) ) {
    new TWChat_Core();
}

class TWChat_Core{

    /**
     * instance of the class
     * 
     * @since 1.0.0
     * @access private
     * @var object
     */
    private static $instance;


    /**
     * Constructor
     * 
     * run plugin core functions and classes
     * 
     * @since 1.0.0
     * @access public
     * @return void
     */
    public function __construct(){
        /**
         * define constants of the plugin core
         * 
         * @since 1.0.0
         */
        $this->define_constants();

        /**
         * load helpers functions
         * 
         * @since 4.0.0
         */
        $this->load_helpers();

        /**
         * Localization setup
         * 
         * @since 1.0.0
         */
        $this->Localization_setup();

        /**
         * load plugin core classes
         * 
         * @since 4.0.0
         */
        AutoLoader::init()->CoreAutoLoader();

        /**
         * run general class of the plugin
         * 
         * @since 4.0.0
         */
        AutoLoader::init()->getInstanceOf( General::class );

    }

    
    /**
     * Define core constants of the plugin
     *
     * @return void
     */
    public function define_constants(){
        defined('TWCHAT_BASENAME') or define('TWCHAT_BASENAME', plugin_basename(__FILE__));
        defined( 'TWCHAT_DIR_PATH' ) or define( 'TWCHAT_DIR_PATH', plugin_dir_path( __FILE__ ) );
        defined( 'TWCHAT_CLASSES_PATH' ) or define( 'TWCHAT_CLASSES_PATH', TWCHAT_DIR_PATH . 'classes/' );
        defined( 'TWCHAT_INCLUDES_PATH' ) or define( 'TWCHAT_INCLUDES_PATH', TWCHAT_DIR_PATH . 'includes/' );
        defined( 'TWCHAT_ASSETS_URL' ) or define( 'TWCHAT_ASSETS_URL', plugin_dir_url( __FILE__ ) . 'includes/assets/' );
        defined( 'TWCHAT_TEMPLATES_PATH' ) or define( 'TWCHAT_TEMPLATES_PATH', TWCHAT_DIR_PATH . 'templates/' );
        defined( 'TWCHAT_ADDONS_PATH' ) or define( 'TWCHAT_ADDONS_PATH', TWCHAT_DIR_PATH . 'addons/' );
    }

    /**
     * Load helpers functions
     * 
     * @since 4.0.0
     * @access public
     * @return void
     */
    public function load_helpers(){
        /**
         * load class autoloader
         */
        require_once dirname( __FILE__ ) . '/helpers/AutoLoader.php';
        /**
         * load scripts and styles helper functions
         */
        require_once dirname( __FILE__ ) . '/helpers/loadScripts.php';
        /**
         * load options helper functions
         */
        require_once dirname( __FILE__ ) . '/helpers/options.php';
        /**
         * load general helper functions
         */
        require_once dirname( __FILE__ ) . '/helpers/functions.php';
        /**
         * load notices helper functions
         */
        require_once dirname( __FILE__ ) . '/helpers/notices.php';
    }

    /**
     * Localization setup
     * 
     * @since 1.0.0
     * @access public
     * @return void
     */
    public function Localization_setup(){
        load_plugin_textdomain( 'twchatlang', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
    }
    
    /**
     * Get instance of the class
     * 
     * @since 1.0.0
     * @access public
     * @return object
     */
    public static function init(){
        if ( ! isset( self::$instance ) && ! ( self::$instance instanceof TWChat_Core ) ) {
            self::$instance = new TWChat_Core();
        }
        return self::$instance;
    }

}