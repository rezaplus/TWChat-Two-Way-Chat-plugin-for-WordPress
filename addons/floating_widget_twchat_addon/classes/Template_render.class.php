<?php
/**
 * Render the floating widget
 */

namespace twchat\addons\floating_widget\Classes;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Template_render {
    public $widget_style = array();
    public $inline_css = '';

    public function __construct() {
        // Load CSS file
        add_action('wp_enqueue_scripts', array($this, 'load_css'));
    }

    /**
     * Prepare the widget style data
     */
    public function get_widget_style() {
        // Calculate widget style properties based on theme mods
        $this->widget_style['padding'] = get_theme_mod('twchat_floating_widget_icon_size') * get_theme_mod('twchat_floating_widget_icon_padding') / 100;
        $this->widget_style['width'] = get_theme_mod('twchat_floating_widget_icon_size') - $this->widget_style['padding'];
        $this->widget_style['widget_size'] = get_theme_mod('twchat_floating_widget_icon_size');
        $this->widget_style['icon_radius'] = get_theme_mod('twchat_floating_widget_icon_border_radius');
        $this->widget_style['icon_bg_color'] = $this->widget_style['padding'] > 0 ? get_theme_mod('twchat_floating_widget_icon_bg_color') : 'transparent';
        $this->widget_style['desktop_alignment'] = get_theme_mod('twchat_floating_widget_icon_alignment');
        $this->widget_style['desktop_horizontal_position'] = get_theme_mod('twchat_floating_widget_icon_horizontal_position');
        $this->widget_style['desktop_vertical_position'] = get_theme_mod('twchat_floating_widget_icon_vertical_position');
        $this->widget_style['mobile_alignment'] = get_theme_mod('twchat_floating_widget_icon_mobile_alignment');
        $this->widget_style['mobile_horizontal_position'] = get_theme_mod('twchat_floating_widget_icon_mobile_horizontal_position');
        $this->widget_style['mobile_vertical_position'] = get_theme_mod('twchat_floating_widget_icon_mobile_vertical_position');
        $this->widget_style['bubble_bg_color'] = get_theme_mod('twchat_floating_widget_bubble_bg_color');
        $this->widget_style['bubble_text_color'] = get_theme_mod('twchat_floating_widget_bubble_text_color');
        $this->widget_style['chatbox_bg_color'] = get_theme_mod('twchat_floating_widget_chatbox_bg_color');
        $this->widget_style['chatbox_header_color'] = get_theme_mod('twchat_floating_widget_chatbox_header_color');
        $this->widget_style['chatbox_close_btn_color'] = get_theme_mod('twchat_floating_widget_chatbox_close_btn_color');
    }

    /**
     * Render inline CSS code
     */
    public function render_inline_css() {
        $css = '<style type="text/css">';
        $css .= apply_filters('twchat/floating_widget/style', $this->inline_css);
        $css .= '</style>';
        echo $css;
    }

    /**
     * Render CSS code for a given selector and styles
     *
     * @param string $selector The CSS selector
     * @param array $styles The CSS styles as an array of associative arrays with 'property' and 'value' keys
     * @param bool $important Whether to apply the 'important' flag to the styles
     * @return string The generated CSS code
     */
    public function render_css_code($selector, $styles, $important = false) {
        $css = $selector . ' { ';
        foreach ($styles as $style) {
            $css .= $style['property'] . ':' . $style['value'] . ($important ? ' !important' : '') . '; ';
        }
        $css .= '} ';
        return $css;
    }

    /**
     * Load the CSS file
     */
    public function load_css() {
        // Enqueue the widget CSS file
        twchat_load_scripts('css', 'twchat-floating-widget', TWCHAT_ADDON_FLOATING_DIR_URL . 'includes/assets/css/widget.css', array(), TWCHAT_ADDON_FLOATING_VERSION, 'all');
    }
}
