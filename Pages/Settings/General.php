<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly
//Save and update this page options
if (
    isset($_POST['submit'])
    && isset($_POST['_wpnonce'])
    && wp_verify_nonce($_POST['_wpnonce'], 'TWCH_nonce_field')
) {
    $fields_TWCH = array(
        'float_is_enable' => sanitize_text_field($_POST['float_is_enable']),
        'floatApplication' => sanitize_text_field($_POST['floatApplication']),
        'wc_is_enable' => sanitize_text_field($_POST['wc_is_enable']),
        'qmessage_is_enable' => sanitize_text_field($_POST['qmessage_is_enable']),
        'Applicationmode' => sanitize_text_field($_POST['Applicationmode']),
        'fix_countrycode' => sanitize_text_field($_POST['fix_countrycode']),
        'Country_Code' => sanitize_text_field($_POST['Country_Code'])
    );
    update_option('TWCH_General_Option', $fields_TWCH);
}

//Get this page options
$dwtp_data = get_option('TWCH_General_Option');
?>
<table class="form-table TWCH-form-table <?php echo !class_exists('WooCommerce') ? 'woocommerce-disabled' : 'woocommerce-active'; ?>">
    <tr>
        <th scope="row"><?php esc_html_e('Float Widget', 'TWCHLANG'); ?></th>
        <td>
            <input type="checkbox" id="float_is_enable" oninput="this.nextElementSibling.value = this.checked" <?php echo  $dwtp_data['float_is_enable'] == 'true' ? 'checked' : 'unchecked'; ?>>
            <input type="hidden" name="float_is_enable" value="<?php esc_attr_e($dwtp_data['float_is_enable']); ?>">
            <label for="float_is_enable"><?php esc_html_e('Enable/Disable float whatsapp button.', 'TWCHLANG'); ?></label>
        </td>
    </tr>
    <tr>
        <th scope="row"><?php esc_html_e('Float Desktop Application', 'TWCHLANG'); ?></th>
        <td>
            <select name="floatApplication" required>
                <option value="app" <?php echo  $dwtp_data['Applicationmode'] == 'app' ? 'selected="selected"' : '';  ?>> <?php esc_html_e("application", 'TWCHLANG'); ?></option>
                <option value="web" <?php echo  $dwtp_data['Applicationmode'] == 'web' ? 'selected="selected"' : '';  ?>> <?php esc_html_e("web application", 'TWCHLANG'); ?></option>
                <option value="auto" <?php echo  $dwtp_data['Applicationmode'] == 'auto' ? 'selected="selected"' : '';  ?>> <?php esc_html_e("Auto", 'TWCHLANG'); ?></option>
            </select>
        </td>
    </tr>
    <tr class="twchat-woocommerce-tr">
        <th scope="row"><?php esc_html_e('Woocommerce', 'TWCHLANG'); ?></th>
        <td>
            <input type="checkbox" id="wc_is_enable" oninput="this.nextElementSibling.value = this.checked" <?php echo  $dwtp_data['wc_is_enable'] == 'true' ? 'checked' : 'unchecked'; ?>>
            <input type="hidden" name="wc_is_enable" value="<?php esc_attr_e($dwtp_data['wc_is_enable']); ?>">
            <label for="wc_is_enable"><?php esc_html_e('Enable/disable the WhatsApp button on orders.', 'TWCHLANG'); ?></label>
        </td>
    </tr>
    <tr class="twchat-woocommerce-tr">
        <th scope="row"><?php esc_html_e('Ready Messages', 'TWCHLANG'); ?></th>
        <td>
            <input type="checkbox" id="qmessage_is_enable" oninput="this.nextElementSibling.value = this.checked" <?php echo  $dwtp_data['wc_is_enable'] == 'true' ? '' : 'disabled'; ?> <?php echo  $dwtp_data['qmessage_is_enable'] == 'true' ? 'checked' : 'unchecked'; ?>>
            <input type="hidden" name="qmessage_is_enable" value="<?php esc_attr_e($dwtp_data['qmessage_is_enable']); ?>">
            <label for="qmessage_is_enable"><?php esc_html_e('Enable/Disable whatsapp Ready messages button on orders.', 'TWCHLANG'); ?></label>
        </td>
    </tr>
    <tr class="twchat-woocommerce-tr">
        <th scope="row"><?php esc_html_e("Woocommerce Application", 'TWCHLANG'); ?></th>
        <td>
            <select name="Applicationmode" required>
                <option value="app" <?php echo  $dwtp_data['Applicationmode'] == 'app' ? 'selected="selected"' : '';  ?>> <?php esc_html_e("application (Recommended)", 'TWCHLANG'); ?></option>
                <option value="web" <?php echo  $dwtp_data['Applicationmode'] == 'web' ? 'selected="selected"' : '';  ?>> <?php esc_html_e("web application", 'TWCHLANG'); ?></option>
                <option value="auto" <?php echo  $dwtp_data['Applicationmode'] == 'auto' ? 'selected="selected"' : '';  ?>> <?php esc_html_e("Auto (Not recommended)", 'TWCHLANG'); ?></option>
            </select>
            <p class="description"><?php esc_html_e("Choose the way you want to talk on WhatsApp.", 'TWCHLANG'); ?></p>
        </td>
    </tr>
    <tr class="twchat-woocommerce-tr">
        <th scope="row"><?php esc_html_e('Static Country Code', 'TWCHLANG'); ?></th>
        <td>
            <input type="checkbox" id="fix_countrycode" oninput="this.nextElementSibling.value = this.checked" <?php echo  $dwtp_data['fix_countrycode'] == 'true' ? 'checked' : 'unchecked'; ?>>
            <input type="hidden" name="fix_countrycode" value="<?php esc_attr_e($dwtp_data['fix_countrycode']); ?>">
            <label for="fix_countrycode"><?php esc_html_e('This option does not need to be activated if the users phone number comes with the country code.', 'TWCHLANG'); ?></label>
        </td>
    </tr>
    <tr class="twchat-woocommerce-tr">
        <th scope="row"><?php esc_html_e('Country Code', 'TWCHLANG'); ?></th>
        <td>
            <input type="hidden" name="Country_Code" value="">
            <select name="Country_Code" id="Country_Code" <?php echo  $dwtp_data['fix_countrycode'] == 'true' ? '' : 'disabled'; ?>>
                <?php require_once TWCH_DIR_path . 'Assets/Country_code.php'; ?>
            </select>
        </td>
    </tr>
</table>
<button type="submit" name="submit" class="button button-primary" value="General"><?php esc_html_e('Save Changes', 'TWCHLANG'); ?></button>

<script>
    document.getElementById('Country_Code').value = "<?php echo $dwtp_data['Country_Code']; ?>";

    jQuery('#wc_is_enable').change(function() {
        jQuery('#qmessage_is_enable').prop('disabled', function(i, v) {
            return !v;
        });
    });
    jQuery('#fix_countrycode').change(function() {
        jQuery('#Country_Code').prop('disabled', function(i, v) {
            jQuery('#Country_Code').val('');
            return !v;
        });
    });

</script>
