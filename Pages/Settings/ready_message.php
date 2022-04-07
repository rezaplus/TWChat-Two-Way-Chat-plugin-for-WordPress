<style>
.wrap form{
    cursor: not-allowed;
}
.wrap form table {
    filter: blur(1px);
    pointer-events: none;
}
.notice-TWCH-premium {
    display: flex;
    justify-content: flex-start;
    padding: 7px 15px;
    align-items: center;
}
</style>
<div class="notice notice-warning notice-TWCH-premium">
             <p><?php esc_html_e('You need to get the premium version for this feature.','TWCHLANG'); ?></p>
             <a href="https://rellaco.com/product/TWChat/" target="_blank"class="button-primary"><?php  esc_html_e('Upgrade','TWCHLANG'); ?></a>
</div>
<table class="form-table TWCH-form-table">
    <tbody>
        <tr>
            <th scope="row">
            <?php esc_html_e('Title','TWCHLANG'); ?>
            </th>
            <td>
                <input type="text" name="TWCH_Qmessage_Title" value="<?php echo   isset($TWCH_Qmessage_Edit) ? esc_attr( $TWCH_Qmessage_Edit['TWCH_Qmessage_Title']) : '' ; ?>" required>
            </td>
        </tr>
        <tr>
            <th scope="row">
            <?php esc_html_e('Message','TWCHLANG'); ?>
            </th>
            <td>
                <textarea name="TWCH_Qmessage_Message" id="TWCH_Qmessage_Message" required><?php echo isset($TWCH_Qmessage_Edit) ? esc_textarea( $TWCH_Qmessage_Edit['TWCH_Qmessage_Message']) : '' ;?></textarea>
                <ul id="shortcode" >
                    <li data-value="[Fname]"><?php esc_html_e('First name','TWCHLANG'); ?></li>
                    <li data-value="[Lname]"><?php esc_html_e('Last name','TWCHLANG'); ?> </li>
                    <li data-value="[phone]"><?php esc_html_e('Phone','TWCHLANG'); ?></li>
                    <li data-value="[Email]"><?php esc_html_e('Email','TWCHLANG'); ?></li>
                    <li data-value="[state]"><?php esc_html_e('State','TWCHLANG'); ?></li>
                    <li data-value="[City]"><?php esc_html_e('City','TWCHLANG'); ?></li>
                    <li data-value="[Address1]"><?php esc_html_e('Address','TWCHLANG'); ?></li>
                    <li data-value="[Address2]"><?php esc_html_e('Address2','TWCHLANG'); ?></li>
                    <li data-value="[PaymentMethod]"><?php esc_html_e('Payment method','TWCHLANG'); ?> </li>
                    <li data-value="[Transaction]"> <?php esc_html_e('Transaction number','TWCHLANG'); ?> </li>
                    <li data-value="[payment_url]"> <?php esc_html_e('Payment link','TWCHLANG'); ?> </li>
                    <li data-value="[shipping_method]"> <?php esc_html_e('Shipping method','TWCHLANG'); ?> </li>
                    <li data-value="[shipping_total]"> <?php esc_html_e('Shipping cost','TWCHLANG'); ?> </li>
                    <li data-value="[Status]"> <?php esc_html_e('Order status','TWCHLANG'); ?> </li>
                    <li data-value="[Items]"> <?php esc_html_e('Order items','TWCHLANG'); ?> </li>
                    <li data-value="[product_Link]"><?php esc_html_e('Order items link','TWCHLANG'); ?></li>
                    <li data-value="[orderID]"><?php esc_html_e('Order id','TWCHLANG'); ?> </li>
                    <li data-value="[total]"><?php esc_html_e('Order total','TWCHLANG'); ?></li>
                    <li data-value="[thanks_page]"><?php esc_html_e('Thank you page','TWCHLANG'); ?> </li>
                    <li data-value="[review]"><?php esc_html_e('Order items review link','TWCHLANG'); ?></li>
                </ul>
            </td>
        </tr>
    </tbody>
</Table>