<?php
/**
 * Class Migrations
 * migrate old version of the plugin to the new version
 * 
 * @param string $version current version of the plugin
 */

namespace TWChat\Classes;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Migrations{

    private $twchat_current_version;
    private $twchat_last_migrated_version;

    public function __construct(){
        // check if the plugin needs to be migrated
        add_action('plugins_loaded', array($this, 'check'), 10);
    }

    /**
     * check if the plugin needs to be migrated
     */
    public function check(){
        // get current version of the plugin
        $this->twchat_current_version = TWCH_VERSION;
        // get last migrated version of the plugin
        $this->twchat_last_migrated_version = get_option('twchat_last_migrated_version', '0.0.0');
        // if the current version is not equal to the last migrated version
        if($this->twchat_current_version != $this->twchat_last_migrated_version){
            // migrate the plugin
            $this->migrate();
        }
    }

    /**
     * Migrate old version of the plugin to the new version
     * 
     * @since 4.0.0
     * @access private
     * @return void
     */
    public function migrate(){
        // convert dot to dash
        $current_version_dash = str_replace('.', '-', $this->twchat_last_migrated_version);
        // find migrate file in the migrations folder in includes
        $migrate_file = TWCHAT_INCLUDES_PATH . 'migrations/migrate-to-' . $current_version_dash . '.php';
        // if the file exists
        if(file_exists($migrate_file)){
            // include the file
            include_once $migrate_file;
            // update the last migrated version
            update_option('twchat_last_migrated_version', $this->twchat_current_version);
        }
    }
}