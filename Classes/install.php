<?php
DTWP_install::get_instance();
class DTWP_install{
    
    static $instance = null;
    
    public function __construct(){
            $this->import();
    }
    
    public function import(){
        $DTWP_General_Option =
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
        $DTWP_float_options = 
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
                'dtwp_SideSpace' => 50,
                'dtwp_bottomDistance' => 40,
                'float-locationMobile' => 'Right',
                'dtwp_SideSpaceMobile' => 50,
                'dtwp_bottomDistanceMobile' => 40,
                'floatBoxHeaderTitle' =>  __('Hello!','DTWPLANG'),
                'floatBoxHeaderDecs' => __('If you do not find the answer to the following questions, we are ready to answer.','DTWPLANG'),
                'floatBoxHeaderBackground' => '#24ae5b',
                'floatBoxTextColor' => '#ffffff',
                'floatBoxCloseBtnColor' => '#ffffff'
            );
 
        if(empty(get_option('DTWP_General_Option')))
            update_option('DTWP_General_Option',$DTWP_General_Option);
            
        if(empty(get_option('DTWP_float_options')))
            update_option('DTWP_float_options',$DTWP_float_options);
        
        if(empty(get_option('DTWP_Accessibility_settings')))
            update_option('DTWP_Accessibility_settings',array('administrator'));
            
        if(empty(get_option('DTWP_Accessibility_WC')))
            update_option('DTWP_Accessibility_WC',array('administrator'));
    }
    public static function get_instance() {
    // If the single instance hasn't been set, set it now.
    if ( null == self::$instance ) {
        self::$instance = new self;
    }
    return self::$instance;
    }
}