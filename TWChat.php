<?php
/**
 * Plugin Name: TWChat
 * Description: Two Way Chat | Communication between you and your customers through WhatsApp.
 * Plugin URI: "https://rellaco.com/product/TwoWayChat"
 * Author: rezaplus
 * Version: 3.1.4
 * Text Domain: TWCHLANG
 * Author URI: https://rezaplus.com/
 * 
 * Requires PHP: 5.4
 * WC requires at least: 3.0
 * WC tested up to: 5.6
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

if ( ! defined( 'ABSPATH' ) ) exit;

TWCH_class::get_instance();
define('TWCH_plugin_version', "3.1.4");

class TWCH_class{
    
    static $instance = null;

    public function __construct(){
        $this->define_constants();
        //Localization
        add_action( 'init', array( $this, 'Localization_setup' ));
        //include main functions
        require_once  TWCH_DIR_path.'Classes/functions.php';     
    }
    /**
     * define all constants and main addresses
     */
    function define_constants(){
        
        $this->define('TWCH_DIR_path_file', __FILE__ );
        $this->define('TWCH_BASE_NAME', plugin_basename(__FILE__) );
        $this->define('TWCH_DIR_path',plugin_dir_path( __FILE__ ));
        $this->define('TWCH_classes_path', plugin_dir_path((__FILE__)) . 'Classes/');
        $this->define('TWCH_image', plugin_dir_url((__FILE__)) . 'Assets/img/');
        $this->define('TWCH_assets', plugin_dir_url((__FILE__)) . 'Assets/');
    }
    /**
    * Define constant if not already defined
    */
    protected function define( $name, $value ) {
        if ( ! defined( $name ) ) {
            define( $name, $value );
        }
    }
    
    /**
     * Initialize plugin for localization
     *
     * @uses load_plugin_textdomain()
     */
    public function Localization_setup() {
        load_plugin_textdomain('TWCHLANG', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }
    
    public static function get_instance() {
    // If the single instance hasn't been set, set it now.
    if ( null == self::$instance ) {
        self::$instance = new self;
    }
    return self::$instance;
    }
}

