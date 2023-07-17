<?php

namespace twchat\addons\floating_widget\classes;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

use twchat\helpers\AutoLoader;

AutoLoader::init()->getInstanceOf(Template_render::class, [], 'both');

class Template extends Template_render
{

    public $widget_style = array();

    public function __construct()
    {
        // Header Title action
        add_action('twchat/addon/floating/chatbox/header', array($this, 'render_header_title'), 10);
        // Header Description action
        add_action('twchat/addon/floating/chatbox/header', array($this, 'render_header_description'), 20);
        // add accounts action
        add_action('twchat/addon/floating/chatbox/body', array($this, 'render_accounts'), 20);
        // add social links action to footer of chatbox
        add_action('twchat/addon/floating/chatbox/footer', array($this, 'render_social_links'), 10);
        // add account title action
        add_action('twchat/addon/floating/chatbox/accounts/details', array($this, 'account_title'), 10);
        // add account name action
        add_action('twchat/addon/floating/chatbox/accounts/details', array($this, 'account_name'), 20);
        // add account available time action
        add_action('twchat/addon/floating/chatbox/accounts/details', array($this, 'account_available_time'), 30);
        // add account chat buttons action
        add_action('twchat/addon/floating/chatbox/accounts/details', array($this, 'account_chat_buttons'), 40);
        // add twchat to footer
        add_action('wp_footer', array($this, 'render_widget_html'));
    }

    // header title
    public function render_header_title($options)
    {
        echo "<div class='TWCHFloatBoxTitle'>";
        echo !empty($options['widget_title']) ? $options['widget_title'] : __('Chat with us', 'twchatlang');
        echo "</div>";
    }

    // header description
    public function render_header_description($options)
    {
        echo '<p class="TWCHFloatBoxDescription">';
        echo !empty($options['widget_description']) ? $options['widget_description'] : __('We are here to answer any question you may have about our services. Reach out to us and we\'ll respond as soon as we can.', 'twchatlang');
        echo '</p>';
    }

    // render accounts
    public function render_accounts($options)
    {
        $accounts = $this->get_accounts();
        include TWCHAT_ADDON_FLOATING_DIR . 'templates/accounts_template.php';
    }

    // add account chat buttons
    public function account_chat_buttons($account)
    {
        include TWCHAT_ADDON_FLOATING_DIR . 'templates/buttons_template.php';
    }

    // add account available time
    public function account_available_time($account)
    {
        echo '<div class="TWCHBoxACSavailableTime">';
        esc_html_e('Available from ', 'twchatlang');
        esc_html_e($account->available_time->from);
        echo ' '._x('to', 'Available from to', 'twchatlang').' ';
        esc_html_e($account->available_time->to);
        echo '</div>';
    }

    // add account name
    public function account_name($account)
    {
        echo '<div class="TWCHBoxACSName">' . $account->name . '</div>';
    }


    // add account title
    public function account_title($account)
    {
        echo '<div class="TWCHBoxACSTitle">' . $account->title . '</div>';
    }

    // render social links
    public function render_social_links()
    {
        $social_links = $this->get_social_links();
        include TWCHAT_ADDON_FLOATING_DIR . 'templates/social_template.php';
    }


    // get social links
    public function get_social_links()
    {
        $social_links = array();
        $TWCH_social = twchat_get_setting('social');
        if (!empty($TWCH_social) || is_array($TWCH_social)) {
            foreach ($TWCH_social as $social) {
                $social_links[] = (object) array(
                    'name' => $social['icon'],
                    'icon' => TWCHAT_ASSETS_URL . 'images/social/' . $social['icon'] . '.svg',
                    'link' => $social['url'],
                );
            }
        }
        return $social_links;
    }

    // get accounts posts
    public function get_accounts()
    {
        $args = array(
            'post_type' => 'twchat_account',
            'posts_per_page' => -1,
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'post_status' => 'publish',
        );
        $accounts = get_posts($args);
        // get accounts meta
        foreach ($accounts as $key => $account) {
            $account_details = get_post_meta($account->ID, 'TWChat_account_details', true);
            $account_profile = get_post_meta($account->ID, 'TWChat_account_profile', true);
            $account_contacts = get_post_meta($account->ID, 'TWChat_floating_contacts', true);
            if (isset($account_profile['thumbnail']) && !empty($account_profile['thumbnail'])) {
                $thumbnail_url =  TWCHAT_ASSETS_URL . "images/account_default_images/" . $account_profile['thumbnail'] . ".png";
            } else {
                $thumbnail_url = TWCHAT_ASSETS_URL . "images/account_default_images/account_3.png";
            }

            $accounts[$key] = (object) array(
                'ID' => $account->ID,
                'name' => $account->post_title,
                'title' => isset($account_details['title']) ? $account_details['title'] : '',
                'thumbnail' => get_the_post_thumbnail_url($account->ID, 'full') ? get_the_post_thumbnail_url($account->ID, 'full') : $thumbnail_url,
                'is_available' => $this->is_available($account_profile['available_from'], $account_profile['available_to']),
                'available_time' => (object) (array(
                        'from' => $account_profile['available_from'],
                        'to' => $account_profile['available_to'],
                    )
                ),
                'contacts' => !empty($account_contacts['available_contacts']) ? $account_contacts['available_contacts'] : array(),
            );
        }
        return $accounts;
    }

    public function is_available($available_from, $available_to)
    {
        // if available is not set or empty means available all time
        if (empty($available_from) || empty($available_to)) {
            return true;
        }

        $available_from = explode(':', $available_from);
        $available_to = explode(':', $available_to);
        $current_time = explode(':', date('H:i'));
        if ($current_time[0] >= $available_from[0] && $current_time[0] <= $available_to[0]) {
            if ($current_time[0] == $available_from[0] && $current_time[1] < $available_from[1]) {
                return false;
            }
            if ($current_time[0] == $available_to[0] && $current_time[1] > $available_to[1]) {
                return false;
            }
            return true;
        }
        return false;
    }

    public function css_style()
    {
        $this->get_widget_style();
        add_filter('twchat/floating_widget/style', array($this, 'render_css_style'));
        add_filter('twchat/floating_widget/style', array($this, 'render_mobile_css_style'));
        add_filter('twchat/floating_widget/style', array($this, 'render_chatbox_css_style'));
        return $this->render_inline_css();
    }




    // render html
    public function render_widget_html()
    {
        if(!empty(get_theme_mod('twchat_floating_widget_icon')) || !empty(get_theme_mod('twchat_floating_widget_custom_icon'))){
            $icon = get_theme_mod('twchat_floating_widget_icon') != 'custom' ?esc_url(TWCHAT_ADDON_FLOATING_IMG_URL . "widgetIcons/" . get_theme_mod('twchat_floating_widget_icon').".svg") : get_theme_mod('twchat_floating_widget_custom_icon');
        }else{
            $icon = TWCHAT_ADDON_FLOATING_IMG_URL . "widgetIcons/float-icon14.svg";
        }

        $html = $this->css_style();
        $html  .= '<div class="TWCHFloatContainer ' . (is_rtl() ? 'RTL' : '') . '">';
        $html .= $this->render_chatbox_html();
        $html .= '<div class="TWCHFloatBtn" onclick="document.getElementById(\'TWCHFloatBox\').classList.toggle(\'show\');" >';
        $html .= '<img src="'.$icon.'" class="TWCH-icon">';
        $html .= $this->render_bubble_html();
        $html .= '</div>';
        $html .= '</div>';
        echo $html;

    }

    // render bubble html
    public function render_bubble_html()
    {
        // bubble text
        $bubble = twchat_get_settings(array('widget_bubble_is_enabled', 'widget_bubble_text'));
        $html = '';
        if (isset($bubble['widget_bubble_is_enabled']) && $bubble['widget_bubble_is_enabled']) {
            $html .= '<div class="TWCHBubble">';
            $html .= '<span class="TWCHBubbleText">' . $bubble['widget_bubble_text'] . '</span>';
            $html .= '</div>';
        }
        return $html;
    }

    public function render_chatbox_html()
    {
        $options = twchat_get_settings();
        return include TWCHAT_ADDON_FLOATING_DIR . 'templates/widget_ChatBox.php';
    }

    // render css style
    public function render_css_style($default_css)
    {
        // render TWCHFloatContainer
        $css[] = $this->render_css_code(
            '.TWCHFloatContainer',
            array(
                array('property' => $this->widget_style['desktop_alignment'], 'value' => $this->widget_style['desktop_horizontal_position'] . 'px'),
                array('property' => 'bottom', 'value' => $this->widget_style['desktop_vertical_position'] . 'px'),
            )
        );
        // render TWCHFloatBtn
        $css[] = $this->render_css_code(
            '.TWCHFloatBtn',
            array(
                array('property' => 'float', 'value' => $this->widget_style['desktop_alignment']),
                array('property' => 'border-radius', 'value' => $this->widget_style['widget_size'] . '%'),
                array('property' => 'padding', 'value' => $this->widget_style['padding'] . 'px'),
            )
        );
        
        // render .TWCHBubble align
        $css[] = $this->render_css_code(
            '.TWCHBubble',
            array(
                array('property' => $this->widget_style['desktop_alignment'], 'value' => $this->widget_style['width'] + 8 . 'px !important'),
                array('property' => $this->widget_style['desktop_alignment'] == 'left' ? 'left' : 'right', 'value' => 'unset', 'important' => true),
                array('property' => 'background', 'value' => $this->widget_style['bubble_bg_color']. ' !important'),
            )
        );

        // render .TWCHBubbleText color
        $css[] = $this->render_css_code(
            '.TWCHBubbleText',
            array(
                array('property' => 'color', 'value' => $this->widget_style['bubble_text_color']),
            )
        );

        // render TWCHFloatBtn .TWCH-icon background
        $css[] = $this->render_css_code(
            '.TWCHFloatBtn',
            array(
                array('property' => 'background', 'value' => $this->widget_style['icon_bg_color']),
                array('property' => 'border-radius', 'value' => $this->widget_style['icon_radius'] . '%'),
            )
        );

        // render TWCHFloatBtn .TWCH-icon
        $css[] = $this->render_css_code(
            '.TWCHFloatBtn .TWCH-icon',
            array(
                array('property' => 'width', 'value' => $this->widget_style['width'] . 'px'),
                array('property' => 'height', 'value' => $this->widget_style['width'] . 'px'),
                array('property' => 'display', 'value' => 'block'),
                array('property' => 'border-radius', 'value' => $this->widget_style['icon_radius'] . '%'),
            )
        );

        // render TWCHFloatBtn div
        $css[] = $this->render_css_code(
            '.TWCHFloatBtn div',
            array(
                array('property' => 'padding', 'value' => $this->widget_style['padding'] . 'px'),
                array('property' => 'border-radius', 'value' => $this->widget_style['widget_size'] . '%'),
            )
        );


        // implode css
        $css = implode('', $css);
        // return css with default css
        return $default_css . $css;
    }

    // render chatbox css style
    public function render_chatbox_css_style($default_css)
    {
        // render TWCHFloatBox
        $css[] = $this->render_css_code(
            '.TWCHFloatBox',
            array(
                array('property' => $this->widget_style['desktop_alignment'], 'value' => $this->widget_style['desktop_horizontal_position'] . 'px'),
                array('property' => 'bottom', 'value' => $this->widget_style['desktop_vertical_position'] . 'px'),
                array('property' => 'transform-origin', 'value' => $this->widget_style['desktop_alignment'] . ' bottom'),
            )
        );

        // render TWCHBoxHeader background color
        $css[] = $this->render_css_code(
            '.TWCHBoxHeader',
            array(
                array('property' => 'background-color', 'value' => $this->widget_style['chatbox_bg_color']),
            )
        );

        // TWCHFloatBoxTitle
        $css[] = $this->render_css_code(
            '.TWCHFloatBoxTitle',
            array(
                array('property' => 'color', 'value' => $this->widget_style['chatbox_header_color']),
            )
        );

        // TWCHBoxHeader p color
        $css[] = $this->render_css_code(
            '.TWCHBoxHeader p',
            array(
                array('property' => 'color', 'value' => $this->widget_style['chatbox_header_color']),
            )
        );

        // close button color
        $css[] = $this->render_css_code(
            '.TWCHBoxHeader svg',
            array(
                array('property' => 'fill', 'value' => $this->widget_style['chatbox_close_btn_color']),
            )
        );


        // implode css
        $css = implode('', $css);
        // return css with default css
        return $default_css . $css;
    }





    // render mobile css style
    public function render_mobile_css_style($default_css)
    {
        $css[] = '@media screen and (max-width: 767px){ ';
        // render TWCHFloatContainer
        $css[] = $this->render_css_code(
            '.TWCHFloatContainer',
            array(
                array('property' => 'float', 'value' => $this->widget_style['mobile_alignment'], 'important' => true),
                array('property' => 'position', 'value' => 'fixed', 'important' => true),
                array('property' => $this->widget_style['mobile_alignment'], 'value' => $this->widget_style['mobile_horizontal_position'] . 'px', 'important' => true),
            )
        );

        // render .TWCHBubble
        $css[] = $this->render_css_code(
            '.TWCHBubble',
            array(
                array('property' => $this->widget_style['mobile_alignment'], 'value' => $this->widget_style['width'] + 8 . 'px !important'),
                array('property' => $this->widget_style['mobile_alignment'] == 'left' ? 'right' : 'left', 'value' => 'unset', 'important' => true),
            )
        );

        // render TWCHFloatBtn
        $css[] = $this->render_css_code(
            '.TWCHFloatBtn',
            array(
                array('property' => 'float', 'value' => $this->widget_style['mobile_alignment'], 'important' => true),
            )
        );

        // end media
        $css[] = ' }';
        // implode css
        $css = implode('', $css);
        // return css with default css
        return $default_css . $css;
    }
}
