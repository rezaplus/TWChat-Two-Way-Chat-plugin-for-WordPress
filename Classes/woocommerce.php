<?php

 DTWP_woocommerce::get_instance();

class DTWP_woocommerce extends DTWP_class{
    
    static $instance = null;
    public $generalOptions;
    
    function __construct(){
        $this->include_exceptions();    
        add_action('admin_enqueue_scripts', array($this,'include_scrips_DTW'));
    }
    function include_exceptions(){
        $this->generalOptions = get_option('DTWP_General_Option');
        if($this->generalOptions['wc_is_enable']=='true'){
            require_once 'woocommerce/Preview_order_button.php' ;   
            require_once 'woocommerce/Order_details_page.php' ;   
        }    
    }
        
        
    function include_scrips_DTW()
    {
        if (get_post_type(get_the_ID()) != 'shop_order') return;
        
        wp_enqueue_script('DTWP_ORS', DTWP_assets . 'Orders.js', array() , DTWP_plugin_version , true);
        wp_localize_script('DTWP_ORS', 'DTWP_ORS', array(
            'Applicationmode' => $this->generalOptions['Applicationmode'],
            'fix_countrycode' => $this->generalOptions['fix_countrycode'],
            'Country_Code' => $this->generalOptions['Country_Code']
        )); 
    }
    
    public static function get_instance() {
    // If the single instance hasn't been set, set it now.
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
        return self::$instance;
    }
    
}
   




