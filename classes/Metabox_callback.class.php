<?php
/**
 * The Metabox_callback class of the TWChat plugin
 * render meta fields html for custom post types
 * 
 * @package TWChat
 * @since 4.0.0
 */

namespace twchat\classes;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

class Metabox_callback
{

    /**
     * Generate HTML for the specified field type
     *
     * @param string $post_meta_key The meta key for the post meta field
     * @param array $field The field configuration array
     * @param string $id The unique identifier for the field
     * @param mixed $value The current value of the field
     */
    public function get_field_html($post_meta_key, $field, $id, $value)
    {
        $field['id'] = $id;
        $field['value'] = $value;
        $field['meta_key'] = $post_meta_key;
        switch ($field['type']) {
            case 'text':
                $this->text_field($field, 'text');
                break;
            case 'email':
                $this->text_field($field, 'email');
                break;
            case 'link':
                $this->text_field($field, 'url');
                break;
            case 'time':
                $this->text_field($field, 'time');
                break;
            case 'select':
                $this->select_field($field);
                break;
            case 'checkbox':
                $this->checkbox_field($field);
                break;
            case 'radio':
                $this->radio_field($field);
                break;
            case 'textarea':
                $this->textarea_field($field);
                break;
            case 'profile_image_radio':
                $this->profile_image_radio_field($field);
                break;
        }
    }

    /**
     * Generate HTML for a text field
     *
     * @param array  $field The field configuration array
     * @param string $type  The input type (default: 'text')
     */
    public function text_field($field, $type = 'text')
    {
        $template = '
    <div class="twchat-field">
        <label for="%s">%s</label>
        <input type="%s" class="form-control" id="%s" name="%s[%s]" placeholder="%s" value="%s" %s>
        %s
    </div>';

        $required = $field['required'] ? 'required' : '';
        $desc = isset($field['desc']) && $field['desc'] !== '' ? '<p class="description">' . $field['desc'] . '</p>' : '';

        printf(
            $template,
            $field['id'],
            $field['label'],
            $type,
            $field['id'],
            $field['meta_key'],
            $field['id'],
            $field['placeholder'],
            $field['value'],
            $required,
            $desc
        );
    }

    /**
     * Generate HTML for a select field
     *
     * @param array $field The field configuration array
     */
    public function select_field($field)
    {
        // HTML template for the select field
        $template = '
    <div class="twchat-field">
        <label for="%s">%s</label>
        <select class="form-control" id="%s" name="%s[%s]" %s>
            %s
        </select>
        %s
    </div>';

        // Generate the HTML for each option
        $options = '';
        foreach ($field['options'] as $key => $option) {
            $selected = $field['value'] == $key ? 'selected' : '';
            $options .= sprintf('<option value="%s" %s>%s</option>', $key, $selected, $option);
        }

        // Check if the field is required
        $required = $field['required'] ? 'required' : '';

        // Check if a description is provided
        $desc = isset($field['desc']) && $field['desc'] !== '' ? '<p class="description">' . $field['desc'] . '</p>' : '';

        // Output the formatted HTML using printf
        printf(
            $template,
            $field['id'], // %s - Field ID
            $field['label'], // %s - Field Label
            $field['id'], // %s - Field ID
            $field['meta_key'], // %s - Meta Key
            $field['id'], // %s - Field ID
            $required, // %s - Required attribute
            $options, // %s - Option HTML
            $desc // %s - Description HTML
        );
    }


    /**
     * Generate HTML for a radio field
     *
     * @param array $field The field configuration array
     */
    public function radio_field($field)
    {
        // HTML template for the radio field
        $template = '
    <div class="twchat-field">
        <label for="%s">%s</label>
        %s
        %s
    </div>';

        $optionsHtml = ''; // Stores the HTML for radio options

        // Generate HTML for each radio option
        foreach ($field['options'] as $key => $option) {
            $checked = $field['value'] == $key ? 'checked' : '';

            // Format radio option HTML using sprintf
            $optionHtml = sprintf(
                '<div class="radio">
                <label>
                    <input type="radio" name="%s[%s]" id="%s" value="%s" %s>
                    %s
                </label>
            </div>',
                $field['meta_key'],
                $field['id'],
                $field['id'],
                $key,
                $checked,
                $option
            );

            $optionsHtml .= $optionHtml; // Append option HTML to the optionsHtml variable
        }

        $descriptionHtml = ''; // Stores the HTML for the description

        // Generate HTML for the description if available
        if (isset($field['desc']) && $field['desc'] !== '') {
            $descriptionHtml = sprintf(
                '<p class="description">%s</p>',
                $field['desc']
            );
        }

        // Format and print the final HTML using sprintf
        printf(
            $template,
            $field['id'], // Field ID for label and input
            $field['label'], // Field label
            $optionsHtml, // Radio options HTML
            $descriptionHtml // Description HTML
        );
    }



    /**
     * Generate HTML for a checkbox field
     *
     * @param array $field The field configuration array
     */
    public function checkbox_field($field)
    {
        // HTML template for the checkbox field
        $template = '
    <div class="twchat-field">
        <label for="%s">%s</label>
        %s
        %s
    </div>';

        $optionsHtml = ''; // Stores the HTML for checkbox options

        // Generate HTML for each checkbox option
        foreach ($field['options'] as $key => $option) {
            $checked = is_array($field['value']) && in_array($key, $field['value']) ? 'checked' : '';

            // Format checkbox option HTML using sprintf
            $optionHtml = sprintf(
                '<div class="checkbox">
                <label>
                    <input type="checkbox" name="%s[%s][]" id="%s" value="%s" %s>
                    %s
                </label>
            </div>',
                $field['meta_key'],
                $field['id'],
                $field['id'],
                $key,
                $checked,
                $option
            );

            $optionsHtml .= $optionHtml; // Append option HTML to the optionsHtml variable
        }

        $descriptionHtml = ''; // Stores the HTML for the description

        // Generate HTML for the description if available
        if (isset($field['desc']) && $field['desc'] !== '') {
            $descriptionHtml = sprintf(
                '<p class="description">%s</p>',
                $field['desc']
            );
        }

        // Format and print the final HTML using sprintf
        printf(
            $template,
            $field['id'], // Field ID for label and input
            $field['label'], // Field label
            $optionsHtml, // Checkbox options HTML
            $descriptionHtml // Description HTML
        );
    }


    /**
     * Generate HTML for a textarea field
     *
     * @param array $field The field configuration array
     */
    public function textarea_field($field)
    {
        // HTML template for the textarea field
        $template = '
    <div class="twchat-field">
        <label for="%s">%s</label>
        <textarea class="form-control" id="%s" name="%s[%s]" placeholder="%s" %s>%s</textarea>
        %s
    </div>';

        $required = $field['required'] ? 'required' : '';

        // Format and print the final HTML using sprintf
        printf(
            $template,
            $field['id'], // Field ID for label and textarea
            $field['label'], // Field label
            $field['id'], // Field ID for textarea
            $field['meta_key'],
            $field['id'],
            $field['placeholder'],
            $required,
            $field['value'],
            isset($field['desc']) && $field['desc'] !== '' ? '<p class="description">' . $field['desc'] . '</p>' : '' // Description HTML
        );
    }


    /**
     * Generate HTML for a radio field with profile images
     *
     * @param array $field The field configuration array
     */
    public function profile_image_radio_field($field)
    {
        echo '<label for="' . $field['id'] . '">' . $field['label'] . '</label>';
        echo '<div class="twchat-field TWChat-default-account-images">';

        foreach ($field['options'] as $key => $option) {
            echo '<div class="radio">';
            echo '<input type="radio" id="' . $option['name'] . '" name="' . $field['meta_key'] . '[' . $field['id'] . ']" value="' . $option['name'] . '" ' . ($field['value'] == strval($option['name']) ? 'checked' : '') . '>';
            echo '<label for="' . $option['name'] . '">';
            echo '<img src="' . $option['url'] . '" alt="' . $option['name'] . '" class="' . $option['class'] . '">';
            echo '</label>';
            echo '</div>';
        }

        if (isset($field['desc']) && $field['desc'] != '') {
            echo '<p class="description">' . $field['desc'] . '</p>';
        }

        echo '</div>';
    }
}