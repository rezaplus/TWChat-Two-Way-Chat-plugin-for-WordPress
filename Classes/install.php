<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
TWCH_install::get_instance();
class TWCH_install{
    
    static $instance = null;
    
    public function __construct(){
            $this->import();
    }
    
    public function import(){
        $TWCH_General_Option =
            Array
            (
                'float_is_enable' => '',
                'floatApplication' => 'web',
                'Applicationmode' => 'app' ,
                'fix_countrycode' => '',
                'Country_Code' => '',
                'wc_is_enable' => '',
                'qmessage_is_enable' => ''
            );
        $TWCH_float_options = 
            Array
            (
                'float-icon' => 'float-icon1.svg',
                'floatSize' => 50,
                'floatBackground1' => '#ffffff',
                'floatRadius1' => 50,
                'floatPadding1' => 4,
                'floatBackground2' => '#9bcfa8',
                'floatRadius2' => 50,
                'floatPadding2' => 5,
                'float-location' => 'Right',
                'TWCH_SideSpace' => 50,
                'TWCH_bottomDistance' => 40,
                'float-locationMobile' => 'Right',
                'TWCH_SideSpaceMobile' => 50,
                'TWCH_bottomDistanceMobile' => 40,
                'floatBoxHeaderTitle' =>  __('Hello!','TWCHLANG'),
                'floatBoxHeaderDecs' => __("if you couldn't find your question in FAQs, text me without hesitation.",'TWCHLANG'),
                'floatBoxHeaderBackground' => '#24ae5b',
                'floatBoxTextColor' => '#ffffff',
                'floatBoxCloseBtnColor' => '#ffffff'
            );
 
        if(empty(get_option('TWCH_General_Option')))
            update_option('TWCH_General_Option',$TWCH_General_Option);
            
        if(empty(get_option('TWCH_float_options')))
            update_option('TWCH_float_options',$TWCH_float_options);
        
        if(empty(get_option('TWCH_Accessibility_settings')))
            update_option('TWCH_Accessibility_settings',array('administrator'));
            
        if(empty(get_option('TWCH_Accessibility_WC')))
            update_option('TWCH_Accessibility_WC',array('administrator'));
    }
    public static function get_instance() {
    // If the single instance hasn't been set, set it now.
    if ( null == self::$instance ) {
        self::$instance = new self;
    }
    return self::$instance;
    }
}