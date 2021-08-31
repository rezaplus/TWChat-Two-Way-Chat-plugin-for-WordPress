<?php
//Save and update this page options
if(isset($_POST['submit'])){
    unset($_POST['submit']);
    if(update_option('DTWP_General_Option', $_POST ));
}

//Get this page options
$dwtp_data = get_option('DTWP_General_Option');

?>
<table class="form-table dtwp-form-table">
    <tr>
        <th scope="row"><?php esc_html_e('Float widget','DTWPLANG'); ?></th>
        <td>
            <input type="checkbox" id="float_is_enable" oninput="this.nextElementSibling.value = this.checked" <?php echo  $dwtp_data['float_is_enable']=='true' ? 'checked' : 'unchecked'; ?>>
            <input type="hidden" name="float_is_enable" value="<?php esc_attr_e($dwtp_data['float_is_enable']); ?>">
            <label for="float_is_enable" ><?php esc_html_e('Enable/Disable float whatsapp button.','DTWPLANG'); ?></label>
        </td>
    </tr>
    <tr>
        <th scope="row"><?php esc_html_e('Float desktop Application','DTWPLANG'); ?></th>
        <td>
            <select name="floatApplication" required>
                <option value="app" <?php echo  $dwtp_data['floatApplication'] == 'app' ? 'selected="selected"' : '' ;  ?>> <?php esc_html_e("application", 'DTWPLANG'); ?></option>
                <option value="web" <?php echo  $dwtp_data['floatApplication'] == 'web' ? 'selected="selected"' : '' ;  ?>> <?php esc_html_e("web application", 'DTWPLANG'); ?></option>
                <option value="auto" <?php echo  $dwtp_data['floatApplication'] == 'auto' ? 'selected="selected"' : ''  ;  ?>> <?php esc_html_e("Auto", 'DTWPLANG'); ?></option>
            </select>
        </td>
    </tr>
    <tr><th colspan="2"><hr></th></tr>
    <tr>
        <th scope="row"><?php esc_html_e('Woocommerce','DTWPLANG'); ?></th>
        <td>
            <input type="checkbox" id="wc_is_enable" oninput="this.nextElementSibling.value = this.checked" <?php echo  $dwtp_data['wc_is_enable']=='true' ? 'checked' : 'unchecked'; ?>>
            <input type="hidden" name="wc_is_enable" value="<?php esc_attr_e($dwtp_data['wc_is_enable']); ?>">
            <label for="wc_is_enable" ><?php esc_html_e('Enable/disable the WhatsApp button on orders.','DTWPLANG'); ?></label>
        </td>
    </tr>
    <tr>
        <th scope="row"><?php esc_html_e('Quick messages','DTWPLANG');?> - <?php esc_html_e('premium','DTWPLANG');?></th>
        <td>
            <input type="checkbox" id="qmessage_is_enable" oninput="this.nextElementSibling.value = this.checked" <?php echo  $dwtp_data['wc_is_enable'] == 'true' ? '' : 'disabled'; ?> <?php echo  $dwtp_data['qmessage_is_enable']=='true' ? 'checked' : 'unchecked'; ?>> 
            <input type="hidden" name="qmessage_is_enable" value="<?php esc_attr_e($dwtp_data['qmessage_is_enable']); ?>">
            <label for="qmessage_is_enable" ><?php esc_html_e('Enable/Disable whatsapp Ready messages button on orders.','DTWPLANG'); ?></label>
        </td>
    </tr>
    <tr>
        <th scope="row"><?php esc_html_e("Woocommerce Application", 'DTWPLANG'); ?></th>
        <td>
            <select name="Applicationmode" required>
                <option value="app" <?php echo  $dwtp_data['Applicationmode'] == 'app' ? 'selected="selected"' : '' ;  ?>> <?php esc_html_e("application (Recommended)", 'DTWPLANG'); ?></option>
                <option value="web" <?php echo  $dwtp_data['Applicationmode'] == 'web' ? 'selected="selected"' : '' ;  ?>> <?php esc_html_e("web application", 'DTWPLANG'); ?></option>
                <option value="auto" <?php echo  $dwtp_data['Applicationmode'] == 'auto' ? 'selected="selected"' : ''  ;  ?>> <?php esc_html_e("Auto (Not recommended)", 'DTWPLANG'); ?></option>
            </select>
            <p class="description"><?php esc_html_e("Choose the way you want to talk on WhatsApp.",'DTWPLANG'); ?></p>
        </td>
    </tr>
    <tr>
        <th scope="row"><?php esc_html_e('Fixed country code','DTWPLANG'); ?></th>
        <td>
            <input type="checkbox" id="fix_countrycode" oninput="this.nextElementSibling.value = this.checked" <?php echo  $dwtp_data['fix_countrycode']=='true' ? 'checked' : 'unchecked'; ?>>
            <input type="hidden"  name="fix_countrycode" value="<?php esc_attr_e($dwtp_data['fix_countrycode']); ?>" >
            <label for="fix_countrycode" ><?php esc_html_e('This option does not need to be activated if the users phone number comes with the country code.','DTWPLANG'); ?></label>
        </td>
    </tr>
    <tr>
        <th scope="row"><?php esc_html_e('Country code','DTWPLANG'); ?></th>
        <td>
            <select name="Country_Code" id="Country_Code" <?php echo  $dwtp_data['fix_countrycode'] == 'true' ? '' : 'disabled'; ?>>
                <?php require_once DTWP_DIR_path.'Assets/Country_code.php'; ?>
            </select>
        </td>
    </tr>
    <tr><th colspan="2"><hr></th></tr>
    <?php if ( !class_exists( 'OSPO_OrdersPro' )){ ?>
    <tr>
        <th scope="row"><?php esc_html_e('Orders pro','DTWPLANG'); ?></th>
        <td>
            <input type="checkbox" class="dtwp_orders_pro" id="dtwp_orders_pro">
            <label class="dtwp_orders_pro" for="dtwp_orders_pro" ><?php esc_html_e('Suggested feature','DTWPLANG'); ?></label>
            <div id="dtwp_orders_pro_description"><?php printf( __('It is recommended to install the %s plugin.','DTWPLANG'),
            '<a target="_blank" href="plugin-install.php?s=orders%20pro%20rezaplus&tab=search&type=term">Orders pro</a>'); ?></div>
        </td>
    </tr>
    <?php } ?>
</table>
<button type="submit" name="submit" class="button button-primary" value="General"><?php esc_html_e('Save Changes','DTWPLANG'); ?></button>

<script>
    document.getElementById('Country_Code').value="<?php echo $dwtp_data['Country_Code']; ?>";
 
    jQuery('#wc_is_enable').change(function(){
        jQuery('#qmessage_is_enable').prop('disabled', function(i, v) {  return !v; });
    });
    jQuery('#fix_countrycode').change(function(){
        jQuery('#Country_Code').prop('disabled', function(i, v) {  jQuery('#Country_Code').val(''); return !v; });
    });
    
    jQuery('#dtwp_orders_pro').change(function(){
        jQuery('#dtwp_orders_pro_description').css('display','block');
        jQuery('#dtwp_orders_pro').prop('checked',false);
    });
</script>