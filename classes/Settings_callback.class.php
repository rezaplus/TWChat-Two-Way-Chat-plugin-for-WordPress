<?php

/**
 * Callbacks for Settings Fields and Sections
 * 
 * @package TWChat
 * @since 4.0.0
 */

namespace twchat\classes;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Settings_callback
{

    public $options;

    public function __construct()
    {
        $this->options = twchat_get_settings();
    }
    
    public function generate_attributes($attributes)
    {
        $attributes_string = '';
        foreach ($attributes as $key => $value) {
            $attributes_string .= $key . '="' . $value . '" ';
        }
        return $attributes_string;
    }

    public function checkbox_callback($args)
    {
        $id = $args['id'];
        $checked = isset($this->options[$id]) ? $this->options[$id] : '';
        $attributes = isset($args['attributes']) ? $this->generate_attributes($args['attributes']) : '';
        echo '<label for="' . $id . '">';
        echo '<input class="twchat-setting-field" type="checkbox" id="' . $id . '" name="TWChatPlugin_options[' . $id . ']" value="1" ' . checked(1, $checked, false) . ' ' . $attributes . '/>';
        echo isset($args['description']) ? ' ' . $args['description'] : '';
        echo '</label>';
    }

    public function select_callback($args)
    {
        $id = $args['id'];
        $options = $args['options'];
        $selected = isset($this->options[$id]) ? $this->options[$id] : '';
        $attributes = isset($args['attributes']) ? $this->generate_attributes($args['attributes']) : '';

        echo '<label for="' . $id . '">';
        echo '<select id="' . $id . '" class="twchat-setting-field" name="TWChatPlugin_options[' . $id . '] ' . $attributes . '">';
        foreach ($options as $key => $value) {
            $selected_attr = ($selected == $key) ? 'selected' : '';
            echo '<option value="' . $key . '" ' . $selected_attr . '>' . $value . '</option>';
        }
        echo '</select>';
        echo isset($args['description']) ? ' ' . $args['description'] : '';
        echo '</label>';
    }

    public function text_callback($args)
    {
        $id = $args['id'];
        $type = isset($args['type']) ? $args['type'] : 'text';
        $placeholder = isset($args['placeholder']) ? $args['placeholder'] : '';
        $value = isset($this->options[$id]) ? $this->options[$id] : '';
        $attributes = isset($args['attributes']) ? $this->generate_attributes($args['attributes']) : '';
        echo '<label for="' . $id . '">';
        echo '<input class="twchat-setting-field" type="' . $type . '" id="' . $id . '" name="TWChatPlugin_options[' . $id . ']" value="' . $value . '" placeholder="' . $placeholder . '" ' . $attributes . '/>';
        echo isset($args['description']) ? ' ' . $args['description'] : '';
        echo '</label>';
    }

    public function textarea_callback($args)
    {
        $id = $args['id'];
        $value = isset($this->options[$id]) ? $this->options[$id] : '';
        $placeholder = isset($args['placeholder']) ? $args['placeholder'] : '';
        $attributes = isset($args['attributes']) ? $this->generate_attributes($args['attributes']) : '';
        echo '<label for="' . $id . '">';
        echo '<textarea class="twchat-setting-field twchat_textarea_callback" id="' . $id . '" name="TWChatPlugin_options[' . $id . ']" ' . $attributes . ' placeholder="' . $placeholder . '">' . $value . '</textarea>';
        echo '<br />';
        echo isset($args['description']) ? ' ' . $args['description'] : '';
        echo '</label>';
    }

    public function color_callback($args)
    {
        $id = $args['id'];
        $value = isset($this->options[$id]) ? $this->options[$id] : '';
        $attributes = isset($args['attributes']) ? $this->generate_attributes($args['attributes']) : '';
        echo '<label for="' . $id . '">';
        echo '<input class="twchat-setting-field" type="color" id="' . $id . '" name="TWChatPlugin_options[' . $id . ']" value="' . $value . '" class="twchat-color-picker" ' . $attributes . '/>';
        echo isset($args['description']) ? ' ' . $args['description'] : '';
        echo '</label>';
    }

    public function country_code_callback($args)
    {
        $id = $args['id'];
        $countryCodes = json_decode(file_get_contents(TWCHAT_INCLUDES_PATH . 'country_codes.json'), true);
        $selected = $this->options[$id] ?? '';

        // Disable select if static code is disabled
        $disabled = isset($this->options['static_country_code']) ? '' : 'disabled';
        $attributes = isset($args['attributes']) ? $this->generate_attributes($args['attributes']) : '';

        $html = '<label for="' . $id . '">';
        $html .= '<select class="twchat-setting-field" id="country_code_select" ' . $disabled . ' ' . $attributes . '>';
        $html .= '<option value="">Select a country code</option>';

        foreach ($countryCodes as $key => $value) {
            $selectedAttr = ($selected == $key) ? 'selected' : '';
            $html .= sprintf(
                '<option data-country-code="%s" value="%s" %s>%s</option>',
                $value['code'],
                $key,
                $selectedAttr,
                $value['name']
            );
        }

        $html .= '</select>';
        $html .= isset($args['description']) ? ' ' . $args['description'] : '';
        $html .= '</label>';
        $html .= sprintf(
            '<input type="hidden" name="TWChatPlugin_options[%s]" value="%s" id="twchat_country_code" />',
            $id,
            $selected
        );

        echo $html;
    }

    public function button_callback($args)
    {
        $attributes = isset($args['attributes']) ? $this->generate_attributes($args['attributes']) : '';
        echo '<label for="' . $args['id'] . '">';
        echo "<a href='$args[url]' class='twchat-setting-field $args[button_class]' target='$args[target]' $attributes>$args[label]</a>";
        echo isset($args['description']) ? ' ' . $args['description'] : '';
        echo '</label>';
    }

    // social_callback repeater field
    public function social_callback($args)
    {
        $id = $args['id'];
        $value = isset($this->options[$id]) ? $this->options[$id] : array();
        $description = isset($args['description']) ? ' ' . $args['description'] : '';

        $html = $description;
        $html .= '<div class="twchat-social-fields description">';
        $html .= '<div class="twchat-social-fields-container">';
        $html .= '<div class="twchat-social-field hidden">';
        $html .= '<div class="twchat-social-field-container twchat-repeater-field">';
        $html .= '<div class="twchat-social-field-item">';
        $html .= '<label for="' . $id . '_0_icon">';
        $html .= '<select class="twchat-setting-field" id="' . $id . '_0_icon" name="TWChatPlugin_options[' . $id . '][0][icon]" disabled>';
        $html .= '<option value="">' . __('Select a social media', 'twchatlang') . '</option>';
        $html .= $this->social_icon_options();
        $html .= '</select>';
        $html .= '</label>';
        $html .= '</div>';
        $html .= '<div class="twchat-social-field-item">';
        $html .= '<label for="' . $id . '_0_url">';
        $html .= '<input type="url" id="' . $id . '_0_url" name="TWChatPlugin_options[' . $id . '][0][url]" value="" placeholder="URL" disabled />';
        $html .= '</label>';
        $html .= '</div>';
        $html .= '<div class="twchat-social-field-item">';
        $html .= '<button type="button" class="button button-secondary twchat-social-field-remove">' . __('Remove', 'twchatlang') . '</button>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';

        if (count($value) > 0) {
            foreach ($value as $key => $social) {
                $html .= '<div class="twchat-social-field">';
                $html .= '<div class="twchat-social-field-container twchat-repeater-field">';
                $html .= '<div class="twchat-social-field-item">';
                $html .= '<label for="' . $id . '_' . $key . '_icon">';
                $html .= '<select id="' . $id . '_' . $key . '_icon" name="TWChatPlugin_options[' . $id . '][' . $key . '][icon]">';
                $html .= '<option value="">' . __('Select a social media', 'twchatlang') . '</option>';
                $html .= $this->social_icon_options($social['icon']);
                $html .= '</select>';
                $html .= '</label>';
                $html .= '</div>';
                $html .= '<div class="twchat-social-field-item">';
                $html .= '<label for="' . $id . '_' . $key . '_url">';
                $html .= '<input type="url" id="' . $id . '_' . $key . '_url" name="TWChatPlugin_options[' . $id . '][' . $key . '][url]" value="' . $social['url'] . '" placeholder="URL" />';
                $html .= '</label>';
                $html .= '</div>';
                $html .= '<div class="twchat-social-field-item">';
                $html .= '<button type="button" class="button button-secondary twchat-social-field-remove">' . __('Remove', 'twchatlang') . '</button>';
                $html .= '</div>';
                $html .= '</div>';
                $html .= '</div>';
            }
        }

        $html .= '</div>';
        $html .= '<button type="button" class="button button-secondary twchat-social-field-add">' . __('Add', 'twchatlang') . '</button>';
        $html .= '</div>';

        echo $html;
    }

    public function social_icon_options($selected = '')
    {
        $images = glob(TWCHAT_INCLUDES_PATH . 'assets/images/social/*.svg');
        $options = '';
        foreach ($images as $image) {
            $image = basename($image, '.svg');
            $selectedAttr = ($selected == $image) ? 'selected' : '';
            $options .= '<option value="' . $image . '" ' . $selectedAttr . '>' . $image . '</option>';
        }
        return $options;
    }
}
