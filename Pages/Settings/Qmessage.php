<style>
.wrap form{
    cursor: not-allowed;
}
.wrap form table {
    filter: blur(1px);
    pointer-events: none;
}
.notice-dtwp-premium {
    display: flex;
    justify-content: space-between;
    padding: 7px 15px;
    align-items: center;
}
</style>
<div class="notice notice-warning notice-dtwp-premium">
             <p><?php esc_html_e('You need to get the premium version for this feature.','DTWPLANG'); ?></p>
             <a href="https://rellaco.com/product/dtw/" target="_blank"class="button-primary"><?= __('Upgrade','DTWPLANG'); ?></a>
         </div>
<table class="form-table dtwp-form-table">
    <tbody>
        <tr>
            <th scope="row">
            <?php esc_html_e('Title','DTWPLANG'); ?>
            </th>
            <td>
                <input type="text" name="DTW_Qmessage_Title" value="<?=  isset($DTWP_Qmessage_Edit) ? esc_attr( $DTWP_Qmessage_Edit['DTW_Qmessage_Title']) : '' ; ?>" required>
            </td>
        </tr>
        <tr>
            <th scope="row">
            <?php esc_html_e('Message','DTWPLANG'); ?>
            </th>
            <td>
                <textarea name="DTW_Qmessage_Message" id="DTW_Qmessage_Message" required><?php echo isset($DTWP_Qmessage_Edit) ? esc_textarea( $DTWP_Qmessage_Edit['DTW_Qmessage_Message']) : '' ;?></textarea>
                <ul id="shortcode" >
                    <li data-value="[Fname]"><?php esc_html_e('First name','DTWPLANG'); ?></li>
                    <li data-value="[Lname]"><?php esc_html_e('Last name','DTWPLANG'); ?> </li>
                    <li data-value="[phone]"><?php esc_html_e('Phone','DTWPLANG'); ?></li>
                    <li data-value="[Email]"><?php esc_html_e('Email','DTWPLANG'); ?></li>
                    <li data-value="[state]"><?php esc_html_e('State','DTWPLANG'); ?></li>
                    <li data-value="[City]"><?php esc_html_e('City','DTWPLANG'); ?></li>
                    <li data-value="[Address1]"><?php esc_html_e('Address','DTWPLANG'); ?></li>
                    <li data-value="[Address2]"><?php esc_html_e('Address2','DTWPLANG'); ?></li>
                    <li data-value="[PaymentMethod]"><?php esc_html_e('Payment method','DTWPLANG'); ?> </li>
                    <li data-value="[Transaction]"> <?php esc_html_e('Transaction number','DTWPLANG'); ?> </li>
                    <li data-value="[payment_url]"> <?php esc_html_e('Payment link','DTWPLANG'); ?> </li>
                    <li data-value="[shipping_method]"> <?php esc_html_e('Shipping method','DTWPLANG'); ?> </li>
                    <li data-value="[shipping_total]"> <?php esc_html_e('Shipping cost','DTWPLANG'); ?> </li>
                    <li data-value="[Status]"> <?php esc_html_e('Order status','DTWPLANG'); ?> </li>
                    <li data-value="[Items]"> <?php esc_html_e('Order items','DTWPLANG'); ?> </li>
                    <li data-value="[product_Link]"><?php esc_html_e('Order items link','DTWPLANG'); ?></li>
                    <li data-value="[orderID]"><?php esc_html_e('Order id','DTWPLANG'); ?> </li>
                    <li data-value="[total]"><?php esc_html_e('Order total','DTWPLANG'); ?></li>
                    <li data-value="[thanks_page]"><?php esc_html_e('Thank you page','DTWPLANG'); ?> </li>
                    <li data-value="[review]"><?php esc_html_e('Order items review link','DTWPLANG'); ?></li>
                </ul>
            </td>
        </tr>
    </tbody>
</Table>