<?php
/**
 * The General class of the TWChat plugin
 * 
 * @package TWChat
 * @subpackage TWChat/classes
 */
namespace twchat\classes;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

use twchat\helpers\AutoLoader;
use twchat\classes\Addon_controller;
use twchat\classes\Settings;
use twchat\classes\Activation;
use twchat\classes\Social_settings;

class General{

    /**
     * Initialize the TWChat plugin and its dependencies
     */
    public function __construct(){

        // Register activation hook
        register_activation_hook( __FILE__, array( $this, 'activation_hook' ) );
        // Register deactivation hook
        register_deactivation_hook( __FILE__, array( $this, 'deactivation_hook' ) );

        // Add main page to admin menu
        add_action( 'admin_menu', array( $this, 'add_main_page' ) , 10);
        // add Settings page to admin menu
        add_action('admin_menu', array($this, 'add_settings_page'), 50);
        // add custom number page to admin menu
        add_action('admin_menu', array($this, 'add_custom_number_page'), 10);
        // Remove submenu to hide main page
        add_action( 'admin_menu', array( $this, 'remove_submenu' ) , 11);
        // plugin action links
        add_filter( 'plugin_action_links_twchat/twchat.php', array( $this, 'plugin_action_links' ) );
        // plugin row meta
        add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 2 );

        // Initialize Addon_controller
        AutoLoader::init()->getInstanceOf(Addon_controller::class);

        // Check if accounts are enabled
        if(apply_filters('twchat_accouns_is_enable', false)){
            AutoLoader::init()->getInstanceOf(Accounts::class, [], 'admin');
        }

        // Check if social settings are enabled
        if(apply_filters('twchat_social_is_enable', false)){
            AutoLoader::init()->getInstanceOf(Social_settings::class, [], 'admin');
        }
    }    

    /**
     * Add the main page to the admin menu
     */
    public function add_main_page(){

        $menu_icon = "data:image/svg+xml;base64," . base64_encode( file_get_contents( TWCHAT_INCLUDES_PATH . 'assets/images/twchat.svg' ) );
        add_menu_page(
            __('TWChat', 'twchatlang'), // Page title
            __('TWChat', 'twchatlang'), // Menu title
            'manage_options', // Capability required to access the menu item
            'twchat', // Menu slug
            array( $this, 'main_page' ), // Callback function to render the page content
            $menu_icon, // Menu icon
            120 // Menu position
        );
    }

    /**
     * add Settings page to admin menu
     */
    public function add_settings_page()
    {
        add_submenu_page(
            'twchat',
            __('Settings', 'twchatlang'),
            __('Settings', 'twchatlang'),
            'manage_options',
            'TWChat_settings',
            array( AutoLoader::init()->getInstanceOf( Settings::class, [], 'admin'), 'create_admin_page' ),
            50
        );
    }

    /**
     * add custom number page to admin menu
     */
    public function add_custom_number_page()
    {
        add_submenu_page(
            'twchat',
            __('Direct Message', 'twchatlang'),
            __('Direct Message', 'twchatlang'),
            'manage_options',
            'TWChat_direct_message',
            array( AutoLoader::init()->getInstanceOf( Direct_message::class ,[],'admin'), 'create_admin_page' ),
            0
        );
    }

    /**
     * Remove submenu to hide the main page
     */
    public function remove_submenu(){
        remove_submenu_page( 'twchat', 'twchat' );
    }

    /**
     * Plugin action links
     * 
     * @param array $links
     * @return array
     */
    public function plugin_action_links( $links ){
        $links[] = '<a href="' . admin_url( 'admin.php?page=TWChat_settings' ) . '">' . __( 'Settings', 'twchatlang' ) . '</a>';
        $links[] = '<a href="' . admin_url( 'admin.php?page=TWChat_addons' ) . '">' . __( 'Addons', 'twchatlang' ) . '</a>';
        return $links;
    }

    /**
     * Plugin row meta
     * 
     * @param array $links
     * @param string $file
     * @return array
     */
    public function plugin_row_meta( $links, $file ){
        if ( $file == 'twchat/twchat.php' ) {
            $links[] = '<a href="https://wordpress.org/plugins/twchat/#reviews" target="_blank">' . __( 'Rate', 'twchatlang' ) . '</a>';
            $links[] = '<a href="https://rellaco.com/support/" target="_blank">' . __( 'Support', 'twchatlang' ) . '</a>';
            $links[] = '<a href="https://rellaco.com/docs-category/twchat-documentation/" target="_blank">' . __( 'Docs', 'twchatlang' ) . '</a>';
        }
        return $links;
    }

    /**
     * Activation hook
     * Perform actions when the plugin is activated
     */
    public static function activation_hook(){
        $activation = AutoLoader::init()->getInstanceOf( Activation::class, [], 'admin' );
        $activation->activation();
    }

    /**
     * Deactivation hook
     * Perform actions when the plugin is deactivated
     */
    public static function deactivation_hook(){
        $deactivation = AutoLoader::init()->getInstanceOf( Activation::class ,[],'admin');
        $deactivation->deactivation();
    }

}
