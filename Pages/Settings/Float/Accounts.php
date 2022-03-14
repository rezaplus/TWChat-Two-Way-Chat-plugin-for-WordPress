<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
require_once  TWCH_DIR_path.'Classes/DBactions.php';

if(isset($_GET['Delete'])){
    TWCH_DBactions::Delete(sanitize_text_field($_GET['Delete']),'TWCH_Accounts_');
}
if(isset($_POST['submit'])
    && isset( $_POST['_wpnonce'] )
    && wp_verify_nonce( $_POST['_wpnonce'],'TWCH_nonce_field' )){
    $getEditId_TWCH = sanitize_text_field(( isset( $_GET['Edit'] ) ) ? $_GET['Edit'] : '');
    $fields_TWCH= array(
        'img-ACS' => sanitize_text_field( $_POST['img-ACS'] ),
        'Account-name' => sanitize_text_field( $_POST['Account-name'] ),
        'Account-title' => sanitize_text_field( $_POST['Account-title'] ),
        'Account-availableFrom' => sanitize_text_field( $_POST['Account-availableFrom'] ),
        'Account-availableTo' => sanitize_text_field( $_POST['Account-availableTo'] ),
        'Country_Code' => sanitize_text_field( $_POST['Country_Code'] ),
        'Account-whatsapp-number' => sanitize_text_field( $_POST['Account-whatsapp-number'] ),
        'DefaultText' => sanitize_textarea_field( $_POST['DefaultText'] )
    );
    TWCH_DBactions::Update($fields_TWCH,$getEditId_TWCH,'TWCH_Accounts_');
}
//Edit Account
if(isset($_GET['Edit'])){
   $Accounts_edit = get_option(sanitize_text_field( $_GET['Edit'] )); 
}

//Get this page options
$Accounts_info = get_option('TWCH_Accounts_list');
?>

<table class="form-table TWCH-form-table Accounts">
    <tr>
        <th scope="row">
        <img src="<?php echo  esc_url(isset($_GET['Edit']) ? $Accounts_edit['img-ACS'] : TWCH_image.'users/user(15).png'); ?>" id="img-src">
        <input type="hidden" name="img-ACS"  id="img-ACS" value="<?php echo  isset($_GET['Edit']) ? esc_attr($Accounts_edit['img-ACS']) : TWCH_image.'users/user(15).png'; ?>">
        
        <div class="TWCH_userImg_list">
            <?php
                //include media library
                wp_enqueue_media();
            ?>
            <img id="img-upload"  class="TWCH-icon TWCH-upload" src="<?php echo TWCH_image; ?>Upload.png" >
            <?php
            for($i=1;$i<=15;$i++){ $floatIcon = TWCH_image."users/user($i).png"; ?>
                <img class="TWCH-users " src="<?php echo  esc_url($floatIcon); ?>" >
            <?php } ?>
        </div>
        </th>
        <td class="TWCH-Account-info">
            <label for="Account-name"><?php esc_html_e('Full Name','TWCHLANG'); ?></label>
            <input type="text" name="Account-name" value="<?php echo  isset($_GET['Edit']) ? esc_attr( $Accounts_edit['Account-name'] ) : ''; ?>" >
            <br>
            <label for="Account-title"><?php esc_html_e('Title','TWCHLANG'); ?></label>
            <input type="text" name="Account-title" value="<?php echo  isset($_GET['Edit']) ? esc_attr( $Accounts_edit['Account-title']  ): ''; ?>" >
            <br>
            <label for="Account-availableFrom"><?php esc_html_e('Available From','TWCHLANG'); ?></label>
            <input type="time" name="Account-availableFrom" value="<?php echo  isset($_GET['Edit']) ? esc_attr( $Accounts_edit['Account-availableFrom'] ) : '' ; ?>" >
            <br>
            <label for="Account-availableTo"><?php esc_html_e('To','TWCHLANG'); ?></label>
            <input type="time" name="Account-availableTo" value="<?php echo   isset($_GET['Edit']) ? esc_attr( $Accounts_edit['Account-availableTo'] ) : '' ; ?>" >
            <br>
            <label ><?php esc_html_e('Country Code','TWCHLANG'); ?></label>
            <select name="Country_Code" id="Country_Code" required><?php require_once TWCH_DIR_path.'Assets/Country_code.php'; ?></select>
            <br>
            <label for="Account-whatsapp-number"><?php esc_html_e('Whatsapp Number','TWCHLANG'); ?></label>
            <input type="number" value="<?php echo   isset($_GET['Edit']) ? esc_attr( $Accounts_edit['Account-whatsapp-number'] ) : '' ; ?>" name="Account-whatsapp-number" id="Account-whatsapp-number"  required>
            <br>
            <label for="DefaultText"><?php esc_html_e('Message Text','TWCHLANG'); ?></label>
            <textarea id="DefaultText" name="DefaultText"><?php echo   isset($_GET['Edit']) ? esc_attr( $Accounts_edit['DefaultText'] ) : '' ; ?></textarea>
            <button type="submit" name="submit" class="button button-primary" value="Accounts"><?php isset($_GET['Edit'])? esc_html_e('Save','TWCHLANG') : esc_html_e('Insert','TWCHLANG'); ?></button>
            <br>
            <a href="?page=TWCH_settings&tab=Float&sT=Accounts" class="button button-small new-ACS-btn" style="<?php echo  isset($_GET['Edit']) ? '' : 'display:none;' ?>"><?php esc_html_e('New','TWCHLANG'); ?></a>

        </td>
    </tr>
   
</table>

    <?php
    if(!empty($Accounts_info)){
        echo "<table class='form-table TWCH-form-table Accounts Accounts-view'>";
        foreach($Accounts_info as $Account){
            
            $ACSInfo = get_option($Account);
            $availableTime = __('Available from','TWCHLANG').' '. $ACSInfo['Account-availableFrom'] .' '.__('To','TWCHLANG').' '.$ACSInfo['Account-availableTo'];
            
            echo "<tr><th scope='row'><img src='".esc_url($ACSInfo['img-ACS'])."'></th>";
            echo "<td class='TWCH-Account-info-view'>";
                    echo "<div>".esc_html($ACSInfo['Account-name'])."</div>";
                    echo "<div>".esc_html($ACSInfo['Account-title'])."</div>";
                ?><div>
                    <?php !empty($ACSInfo['Account-availableFrom'])? esc_html_e($availableTime) : ''; ?>
                </div>
                <?php
                    echo "<div>".esc_html($ACSInfo['Country_Code'].$ACSInfo['Account-whatsapp-number'])."</div>";
                    echo "<div>".esc_html($ACSInfo['DefaultText'])."</div>";
                    echo "<div><a href='?page=TWCH_settings&tab=Float&sT=Accounts&Edit=$Account'>".__('Edit','TWCHLANG')."</a>
                    <a href='?page=TWCH_settings&tab=Float&sT=Accounts&Delete=$Account'>".__('Delete','TWCHLANG')."</a>";
                echo "</div></td></tr>";
            
        }
        echo "</table>";
    }
        ?>
        

<script>
    jQuery(document).ready(function($){
       $('#img-upload').click(function(e){
            e.preventDefault();
            var upload = wp.media({
                multiple:false
            }).on('select', function(){
                var select = upload.state().get('selection');
                var attach = select.first().toJSON();
                $('#img-ACS').attr('value',attach.url);
                $('#img-src').attr('src',attach.url);
            })
            .open();
       });
       
       $('.TWCH-users').click(function(){
            $('#img-ACS').attr('value',$(this).attr('src'));
            $('#img-src').attr('src',$(this).attr('src'));             
       });
       
    });
    
    <?php
    if(isset($_GET['Edit'])){ ?>
        document.getElementById('Country_Code').value="<?php esc_html_e($Accounts_edit['Country_Code']); ?>";
    <?php } ?>
    
    jQuery('#Account-whatsapp-number').on('input', function() {
         var number = jQuery('#Account-whatsapp-number').val();
        if (number.startsWith('0'))
            number = number.substring(1);
            jQuery('#Account-whatsapp-number').val(number)
    });
</script>
