<?php
/**
 * @package TWChat
 */

 namespace twchat\addons\floating_widget\classes;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

// customizer class for floating widget
class Customizer {

    public function __construct() {
        add_action( 'customize_register', array( $this, 'register_customizer' ) );
        // add customizer js
        add_action( 'customize_controls_enqueue_scripts', array( $this, 'twchat_customizer_script' ) );
    }

    public function register_customizer( $wp_customize ) {

       
        // Add a panel
        $wp_customize->add_panel( 'twchat_panel', array(
            'title'    => __('TWChat', 'twchatlang'),
            'priority' => 120,
        ) );

        // Add a section to the panel
        $wp_customize->add_section( 'twchat_floating_widget', array(
            'title'    => __('Floating Widget', 'twchatlang'),
            'priority' => 10,
            'panel'    => 'twchat_panel',
            'description' => __('Customize Floating Widget to your liking.', 'twchatlang'),
        ) );
        
       // Icon select
        $wp_customize->add_setting( 'twchat_floating_widget_icon', array(
            'default'           => 'float-icon-0',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'twchat_floating_widget_icon', array(
            'label'    => __('Icon', 'twchatlang'),
            'section'  => 'twchat_floating_widget',
            'settings' => 'twchat_floating_widget_icon',
            'priority' => 10,
            'type'     => 'select',
            'choices'  => array(
                'float-icon0' => __('Default', 'twchatlang'),
                'custom' => __('Custom Icon', 'twchatlang'),
                'float-icon1' => __('Icon 1', 'twchatlang'),
                'float-icon2' => __('Icon 2', 'twchatlang'),
                'float-icon3' => __('Icon 3', 'twchatlang'),
                'float-icon4' => __('Icon 4', 'twchatlang'),
                'float-icon5' => __('Icon 5', 'twchatlang'),
                'float-icon6' => __('Icon 6', 'twchatlang'),
                'float-icon7' => __('Icon 7', 'twchatlang'),
                'float-icon8' => __('Icon 8', 'twchatlang'),
                'float-icon9' => __('Icon 9', 'twchatlang'),
                'float-icon10' => __('Icon 10', 'twchatlang'),
                'float-icon11' => __('Icon 11', 'twchatlang'),
                'float-icon12' => __('Icon 12', 'twchatlang'),
                'float-icon13' => __('Icon 13', 'twchatlang'),
                'float-icon14' => __('Icon 14', 'twchatlang'),
                'float-icon15' => __('Icon 15', 'twchatlang'),
                'float-icon16' => __('Icon 16', 'twchatlang'),
                'float-icon17' => __('Icon 17', 'twchatlang'),
                'float-icon18' => __('Icon 18', 'twchatlang'),
            ),
        ) );
        
       // uoload custom icon
        $wp_customize->add_setting( 'twchat_floating_widget_custom_icon', array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ) );

        $wp_customize->add_control( new \WP_Customize_Image_Control( $wp_customize, 'twchat_floating_widget_custom_icon', array(
            'label'    => __('Custom Icon', 'twchatlang'),
            'section'  => 'twchat_floating_widget',
            'settings' => 'twchat_floating_widget_custom_icon',
            'priority' => 10,
            'type'     => 'image',
            'description' => __('Upload a custom icon for floating widget.', 'twchatlang'),
        ) ) );

        // add icon size between 20 to 100
        $wp_customize->add_setting( 'twchat_floating_widget_icon_size', array(
            'default'           => '40',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'twchat_floating_widget_icon_size', array(
            'label'    => __('Icon Size', 'twchatlang'),
            'section'  => 'twchat_floating_widget',
            'settings' => 'twchat_floating_widget_icon_size',
            'priority' => 10,
            'type'     => 'range',
            'description' => __('Set icon size between 20 to 100.', 'twchatlang'),
            'input_attrs' => array(
                'min' => 20,
                'max' => 100,
                'step' => 1,
            ),
        ) );

        // add padding between 0 to 50
        $wp_customize->add_setting( 'twchat_floating_widget_icon_padding', array(
            'default'           => '10',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'twchat_floating_widget_icon_padding', array(
            'label'    => __('Icon Padding', 'twchatlang'),
            'section'  => 'twchat_floating_widget',
            'settings' => 'twchat_floating_widget_icon_padding',
            'priority' => 10,
            'type'     => 'range',
            'description' => __('Set icon padding between 0 to 50.', 'twchatlang'),
            'input_attrs' => array(
                'min' => 0,
                'max' => 50,
                'step' => 1,
            ),
        ) );

        // add icon border radius between 0 to 50
        $wp_customize->add_setting( 'twchat_floating_widget_icon_border_radius', array(
            'default'           => '50',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'twchat_floating_widget_icon_border_radius', array(
            'label'    => __('Icon Border Radius', 'twchatlang'),
            'section'  => 'twchat_floating_widget',
            'settings' => 'twchat_floating_widget_icon_border_radius',
            'priority' => 10,
            'type'     => 'range',
            'description' => __('Set icon border radius between 0 to 50.', 'twchatlang'),
            'input_attrs' => array(
                'min' => 0,
                'max' => 50,
                'step' => 1,
            ),
        ) );

        // add icon background color
        $wp_customize->add_setting( 'twchat_floating_widget_icon_bg_color', array(
            'default'           => '#000000',
            'sanitize_callback' => 'sanitize_hex_color',
        ) );

        $wp_customize->add_control( new \WP_Customize_Color_Control( $wp_customize, 'twchat_floating_widget_icon_bg_color', array(
            'label'    => __('Icon Background Color', 'twchatlang'),
            'section'  => 'twchat_floating_widget',
            'settings' => 'twchat_floating_widget_icon_bg_color',
            'priority' => 10,
            'type'     => 'color',
        ) ) );

        // add desktop icon alignment
        $wp_customize->add_setting( 'twchat_floating_widget_icon_alignment', array(
            'default'           => 'right',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'twchat_floating_widget_icon_alignment', array(
            'label'    => __('Icon Alignment', 'twchatlang'),
            'section'  => 'twchat_floating_widget',
            'settings' => 'twchat_floating_widget_icon_alignment',
            'priority' => 10,
            'type'     => 'radio',
            'choices'  => array(
                'left' => __('Left', 'twchatlang'),
                'right' => __('Right', 'twchatlang'),
            ),
        ) );

        // add icon desktop Horizontal position between 0 to 100 
        $wp_customize->add_setting( 'twchat_floating_widget_icon_horizontal_position', array(
            'default'           => '50',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'twchat_floating_widget_icon_horizontal_position', array(
            'label'    => __('Icon Horizontal Position', 'twchatlang'),
            'section'  => 'twchat_floating_widget',
            'settings' => 'twchat_floating_widget_icon_horizontal_position',
            'priority' => 10,
            'type'     => 'range',
            'description' => __('Set icon horizontal position between 0 to 100.', 'twchatlang'),
            'input_attrs' => array(
                'min' => 0,
                'max' => 100,
                'step' => 1,
            ),
        ) );

        // add icon desktop Vertical position between 0 to 100
        $wp_customize->add_setting( 'twchat_floating_widget_icon_vertical_position', array(
            'default'           => '50',
            'sanitize_callback' => 'sanitize_text_field',
        ) ); 

        $wp_customize->add_control( 'twchat_floating_widget_icon_vertical_position', array(
            'label'    => __('Icon Vertical Position', 'twchatlang'),
            'section'  => 'twchat_floating_widget',
            'settings' => 'twchat_floating_widget_icon_vertical_position',
            'priority' => 10,
            'type'     => 'range',
            'description' => __('Set icon vertical position between 0 to 100.', 'twchatlang'),
            'input_attrs' => array(
                'min' => 0,
                'max' => 100,
                'step' => 1,
            ),
        ) );

        // add icon mobile alignment
        $wp_customize->add_setting( 'twchat_floating_widget_icon_mobile_alignment', array(
            'default'           => 'right',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'twchat_floating_widget_icon_mobile_alignment', array(
            'label'    => __('Icon Mobile Alignment', 'twchatlang'),
            'section'  => 'twchat_floating_widget',
            'settings' => 'twchat_floating_widget_icon_mobile_alignment',
            'priority' => 10,
            'type'     => 'radio',
            'choices'  => array(
                'left' => __('Left', 'twchatlang'),
                'right' => __('Right', 'twchatlang'),
            ),
        ) );

        // add icon mobile Horizontal position between 0 to 100
        $wp_customize->add_setting( 'twchat_floating_widget_icon_mobile_horizontal_position', array(
            'default'           => '50',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'twchat_floating_widget_icon_mobile_horizontal_position', array(
            'label'    => __('Icon Mobile Horizontal Position', 'twchatlang'),
            'section'  => 'twchat_floating_widget',
            'settings' => 'twchat_floating_widget_icon_mobile_horizontal_position',
            'priority' => 10,
            'type'     => 'range',
            'description' => __('Set icon mobile horizontal position between 0 to 100.', 'twchatlang'),
            'input_attrs' => array(
                'min' => 0,
                'max' => 100,
                'step' => 1,
            ),
        ) );

        // add icon mobile Vertical position between 0 to 100
        $wp_customize->add_setting( 'twchat_floating_widget_icon_mobile_vertical_position', array(
            'default'           => '50',
            'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'twchat_floating_widget_icon_mobile_vertical_position', array(
            'label'    => __('Icon Mobile Vertical Position', 'twchatlang'),
            'section'  => 'twchat_floating_widget',
            'settings' => 'twchat_floating_widget_icon_mobile_vertical_position',
            'priority' => 10,
            'type'     => 'range',
            'description' => __('Set icon mobile vertical position between 0 to 100.', 'twchatlang'),
            'input_attrs' => array(
                'min' => 0,
                'max' => 100,
                'step' => 1,
            ),
        ) );

        // add Bubble background color
        $wp_customize->add_setting( 'twchat_floating_widget_bubble_bg_color', array(
            'default'           => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
        ) );

        $wp_customize->add_control( new \WP_Customize_Color_Control( $wp_customize, 'twchat_floating_widget_bubble_bg_color', array(
            'label'    => __('Bubble Background Color', 'twchatlang'),
            'section'  => 'twchat_floating_widget',
            'settings' => 'twchat_floating_widget_bubble_bg_color',
            'priority' => 10,
            'type'     => 'color',
        ) ) );

        // add bubble text color
        $wp_customize->add_setting( 'twchat_floating_widget_bubble_text_color', array(
            'default'           => '#000000',
            'sanitize_callback' => 'sanitize_hex_color',
        ) );

        $wp_customize->add_control( new \WP_Customize_Color_Control( $wp_customize, 'twchat_floating_widget_bubble_text_color', array(
            'label'    => __('Bubble Text Color', 'twchatlang'),
            'section'  => 'twchat_floating_widget',
            'settings' => 'twchat_floating_widget_bubble_text_color',
            'priority' => 10,
            'type'     => 'color',
        ) ) );


        // add background color for chatbox
        $wp_customize->add_setting( 'twchat_floating_widget_chatbox_bg_color', array(
            'default'           => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
        ) );

        $wp_customize->add_control( new \WP_Customize_Color_Control( $wp_customize, 'twchat_floating_widget_chatbox_bg_color', array(
            'label'    => __('Chatbox Background Color', 'twchatlang'),
            'section'  => 'twchat_floating_widget',
            'settings' => 'twchat_floating_widget_chatbox_bg_color',
            'priority' => 10,
            'type'     => 'color',
        ) ) );

        // add Header color for chatbox
        $wp_customize->add_setting( 'twchat_floating_widget_chatbox_header_color', array(
            'default'           => '#000000',
            'sanitize_callback' => 'sanitize_hex_color',
        ) );

        $wp_customize->add_control( new \WP_Customize_Color_Control( $wp_customize, 'twchat_floating_widget_chatbox_header_color', array(
            'label'    => __('Chatbox Header Color', 'twchatlang'),
            'section'  => 'twchat_floating_widget',
            'settings' => 'twchat_floating_widget_chatbox_header_color',
            'priority' => 10,
            'type'     => 'color',
        ) ) );

        // add Close button color for chatbox
        $wp_customize->add_setting( 'twchat_floating_widget_chatbox_close_btn_color', array(
            'default'           => '#000000',
            'sanitize_callback' => 'sanitize_hex_color',
        ) );

        $wp_customize->add_control( new \WP_Customize_Color_Control( $wp_customize, 'twchat_floating_widget_chatbox_close_btn_color', array(
            'label'    => __('Chatbox Close Button Color', 'twchatlang'),
            'section'  => 'twchat_floating_widget',
            'settings' => 'twchat_floating_widget_chatbox_close_btn_color',
            'priority' => 10,
            'type'     => 'color',
        ) ) );


    }
    
    // script for customizer
    public function twchat_customizer_script() {
        twchat_load_scripts( 'js' ,'TWChat_customizer_script', TWCHAT_ADDON_FLOATING_DIR_URL . 'includes/assets/js/twchat-customizer.js', array( 'jquery' ), array(), TWCHAT_ADDON_FLOATING_VERSION, true );
    }
}