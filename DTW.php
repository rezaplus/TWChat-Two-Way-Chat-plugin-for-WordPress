<?php
/**
 * Plugin Name: DTCHAT
 * Description: Direct To Whatsapp | Communication between you and your customers through WhatsApp.
 * Plugin URI: "https://rellaco.com/product/dtw"
 * Author: rezaplus
 * Version: 3.1.2
 * Text Domain: DTWPLANG
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

DTWP_class::get_instance();
define('DTWP_plugin_version', "3.1.2");

class DTWP_class{
    
    static $instance = null;

    public function __construct(){
        $this->define_constants();
        //Localization
        add_action( 'init', array( $this, 'Localization_setup' ));
        //include main functions
        require_once  DTWP_DIR_path.'Classes/functions.php';
        
        /**
         * settings session start
         * only zhaket version
        */
        add_action('admin_init',function(){
            if(isset($_GET['page']))
                if($_GET['page']=='DTWP_settings')
                    session_start();
        });        
    }
    /**
     * define all constants and main addresses
     */
    function define_constants(){
        
        $this->define('DTWP_DIR_path_file', __FILE__ );
        $this->define('DTWP_BASE_NAME', plugin_basename(__FILE__) );
        $this->define('DTWP_DIR_path',plugin_dir_path( __FILE__ ));
        $this->define('DTWP_classes_path', plugin_dir_path((__FILE__)) . 'Classes/');
        $this->define('DTWP_image', plugin_dir_url((__FILE__)) . 'Assets/img/');
        $this->define('DTWP_assets', plugin_dir_url((__FILE__)) . 'Assets/');
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
        load_plugin_textdomain('DTWPLANG', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }
    
    public static function get_instance() {
    // If the single instance hasn't been set, set it now.
    if ( null == self::$instance ) {
        self::$instance = new self;
    }
    return self::$instance;
    }
}

