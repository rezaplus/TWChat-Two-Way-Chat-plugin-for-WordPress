<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if(isset($_POST['submit'])
    && isset( $_POST['_wpnonce'] )
    && wp_verify_nonce( $_POST['_wpnonce'],'TWCH_nonce_field' )){
    $fields_TWCH = array(
        'float-icon' => sanitize_text_field( $_POST['float-icon'] ),
        'floatSize' => sanitize_text_field( $_POST['floatSize'] ),
        'floatBackground1' => sanitize_text_field( $_POST['floatBackground1'] ),
        'floatRadius1' => sanitize_text_field( $_POST['floatRadius1'] ),
        'floatPadding1' => sanitize_text_field( $_POST['floatPadding1'] ),
        'floatBackground2' => sanitize_text_field( $_POST['floatBackground2'] ),
        'floatRadius2' => sanitize_text_field( $_POST['floatRadius2'] ),
        'floatPadding2' => sanitize_text_field( $_POST['floatPadding2'] ),
        'float-location' => sanitize_text_field( $_POST['float-location'] ),
        'TWCH_SideSpace' => sanitize_text_field( $_POST['TWCH_SideSpace'] ),
        'TWCH_bottomDistance' => sanitize_text_field( $_POST['TWCH_bottomDistance'] ),
        'float-locationMobile' => sanitize_text_field( $_POST['float-locationMobile'] ),
        'TWCH_SideSpaceMobile' => sanitize_text_field( $_POST['TWCH_SideSpaceMobile'] ),
        'TWCH_bottomDistanceMobile' => sanitize_text_field( $_POST['TWCH_bottomDistanceMobile'] ),
        'floatBoxHeaderTitle' => sanitize_text_field( $_POST['floatBoxHeaderTitle'] ),
        'floatBoxHeaderDecs' => sanitize_text_field( $_POST['floatBoxHeaderDecs'] ),
        'floatBoxHeaderBackground' => sanitize_text_field( $_POST['floatBoxHeaderBackground'] ),
        'floatBoxTextColor' => sanitize_text_field( $_POST['floatBoxTextColor'] ),
        'floatBoxCloseBtnColor' => sanitize_text_field( $_POST['floatBoxCloseBtnColor'] )
    );
    update_option('TWCH_float_options', $fields_TWCH );
}
$float_option = get_option('TWCH_float_options');

//include float button
wp_enqueue_style( 'Float', TWCH_assets . 'floatStyle.css',true, TWCH_plugin_version );
require_once TWCH_DIR_path.'Pages/Float.php';
?>
<table class="form-table TWCH-form-table">
    <tr><th><h2><?php esc_html_e("Button style", 'TWCHLANG'); ?></h2></th><td><hr></td></tr>
    <tr class="TWCH-select-icon">
        <th scope="row">
        <?php esc_html_e("Icon", 'TWCHLANG'); ?></th>
        <td>
        <?php
        for($i=0;$i<=18;$i++){ $floatIcon = "float-icon$i.svg";?>
        
        <label>
            <input name="float-icon" type="radio" value="<?php esc_attr_e($floatIcon); ?>" <?php echo $float_option['float-icon'] == $floatIcon ? 'checked' : ''; ?>>
            <img class="TWCH-icon" src="<?php echo esc_url(TWCH_image."float-icon/".$floatIcon."?ver=".TWCH_plugin_version); ?>" >
        </label>
        <?php } ?>
        </td>
    </tr>
    <tr>
        <th scope="row"><?php esc_html_e('size','TWCHLANG'); ?></th>
        <td>
            <input name="floatSize" type="range" value="<?php echo isset($float_option) ? esc_attr( $float_option['floatSize']) : '40'; ?>" min="25" max="300" oninput="this.nextElementSibling.value = this.value+'px'">
            <output><?php echo isset($float_option) ? esc_html( $float_option['floatSize'] ) : '40px'; ?></output>
        </td>
    </tr>
    <tr><th><h2><?php esc_html_e("First layer", 'TWCHLANG'); ?></h2></th><td><hr></td></tr>
    <tr>
        <th scope="row"><?php esc_html_e('Padding','TWCHLANG'); ?></th>
        <td>
            <input name="floatPadding1" type="range" min="0" max="20" value="<?php echo isset($float_option) ? esc_attr( $float_option['floatPadding1'] ) : '50'; ?>" oninput="this.nextElementSibling.value = this.value+'px'">
            <output><?php echo isset($float_option) ? esc_html( $float_option['floatPadding1'] ) : '6'; ?>px</output>
        </td>
    </tr> 
    <tr>
        <th scope="row"><?php esc_html_e('Background color','TWCHLANG'); ?></th>
        <td>
            <input type="color" value="<?php echo isset($float_option) ? esc_attr( $float_option['floatBackground1'] ) : '#39a805'; ?>" style="width:80px" name="floatBackground1" oninput="this.nextElementSibling.value = this.value">
            <output><?php echo isset($float_option) ? esc_html( $float_option['floatBackground1'] ) : '#39a805'; ?></output>
        </td>
    </tr>
    <tr>
        <th scope="row"><?php esc_html_e('Radius','TWCHLANG'); ?></th>
        <td>
            <input name="floatRadius1" type="range" min="0" max="50" value="<?php echo isset($float_option) ? esc_attr($float_option['floatRadius1']) : '50'; ?>" oninput="this.nextElementSibling.value = this.value+'%'">
            <output><?php echo isset($float_option) ? esc_html($float_option['floatRadius1'] ) : '50'; ?>%</output>
        </td>
    </tr> 
    <tr><th><h2><?php esc_html_e("Second layer", 'TWCHLANG'); ?></h2></th><td><hr></td></tr>
    <tr>
        <th scope="row"><?php esc_html_e('Padding','TWCHLANG'); ?></th>
        <td>
            <input name="floatPadding2" type="range" min="0" max="20" value="<?php echo isset($float_option) ? esc_attr( $float_option['floatPadding2'] ) : '6'; ?>" oninput="this.nextElementSibling.value = this.value+'px'">
            <output><?php echo isset($float_option) ? esc_html( $float_option['floatPadding2'] ) : '6'; ?>px</output>
        </td>
    </tr> 
    <tr>
        <th scope="row"><?php esc_html_e('Background color','TWCHLANG'); ?></th>
        <td>
            <input type="color" value="<?php echo  isset($float_option) ? esc_attr( $float_option['floatBackground2'] ): '#39a805'; ?>" style="width:80px" name="floatBackground2" oninput="this.nextElementSibling.value = this.value">
            <output><?php echo isset($float_option) ?  esc_html( $float_option['floatBackground2'] ): '#39a805'; ?></output>
        </td>
    </tr>
    <tr>
        <th scope="row"><?php esc_html_e('Radius','TWCHLANG'); ?></th>
        <td>
            <input name="floatRadius2" type="range" min="0" max="50" value="<?php echo isset($float_option) ? esc_attr( $float_option['floatRadius2'] ): '50'; ?>" oninput="this.nextElementSibling.value = this.value+'%'">
            <output><?php echo isset($float_option) ? esc_html( $float_option['floatRadius2'] ) : '50'; ?>%</output>
        </td>
    </tr>  
    <tr><th><h2><?php esc_html_e("Desktop", 'TWCHLANG'); ?></h2></th><td><hr></td></tr>
    <tr>
        <th scope="row"><?php esc_html_e("Location", 'TWCHLANG'); ?></th>
        <td class="flex-dt">
        <label style="margin-right:5px;">
            <input name="float-location" type="radio" Value="Left" <?php echo $float_option['float-location']=='Left' ? 'checked' : ''; ?>>
            <?php esc_html_e('Left','TWCHLANG'); ?>
        </label>
        <label style="margin-left:5px;">
            <input name="float-location"  type="radio" Value="Right" <?php echo $float_option['float-location']=='Right' ? 'checked' : ''; ?>>
            <?php esc_html_e('Right','TWCHLANG'); ?>
        </label>
        </td>
    </tr>
    <tr>
        <th scope="row"><?php esc_html_e('Position','TWCHLANG'); ?></th>
        <td>
            <Label for="TWCH_SideSpace" style="line-height: 25px;" ><?php esc_html_e('Horizontal','TWCHLANG'); ?></label>
            <br>
            <input name="TWCH_SideSpace" type="range" min="1" max="300" value="<?php echo isset($float_option) ? esc_attr( $float_option['TWCH_SideSpace'] ) : '24'; ?>" oninput="this.nextElementSibling.value = this.value+'px'">
            <output><?php echo isset($float_option) ? esc_html( $float_option['TWCH_SideSpace'] ) : '24'; ?>px</output>
            <br>
            <Label for="TWCH_bottomDistance" style="line-height: 25px;"><?php esc_html_e('Vertical','TWCHLANG'); ?></label>
            <br>
            <input name="TWCH_bottomDistance" type="range" min="1" max="300" value="<?php echo  isset($float_option) ?esc_attr(  $float_option['TWCH_bottomDistance'] ) : '24'; ?>" oninput="this.nextElementSibling.value = this.value+'px'">
            <output><?php echo isset($float_option) ? esc_html( $float_option['TWCH_bottomDistance'] ) : '24'; ?>px</output>
        </td>
    </tr>
    <tr><th><h2><?php esc_html_e("Mobile", 'TWCHLANG'); ?></h2></th><td><hr></td></tr>
    <tr>
        <th scope="row"><?php esc_html_e("Location", 'TWCHLANG'); ?></th>
        <td class="flex-dt">
        <label style="margin-right:5px;">
            <input name="float-locationMobile" type="radio" Value="Left" <?php esc_html_e($float_option['float-locationMobile']=='Left' ? 'checked' : ''); ?>>
            <?php esc_html_e('Left','TWCHLANG'); ?>
        </label>
        <label style="margin-left:5px;">
            <input name="float-locationMobile"  type="radio" Value="Right" <?php esc_html_e($float_option['float-locationMobile']=='Right' ? 'checked' : ''); ?>>
            <?php esc_html_e('Right','TWCHLANG'); ?>
        </label>
        </td>
    </tr>
    <tr>
        <th scope="row"><?php esc_html_e('Position','TWCHLANG'); ?></th>
        <td>
            <Label for="TWCH_SideSpace" style="line-height: 25px;" ><?php esc_html_e('Horizontal','TWCHLANG'); ?></label>
            <br>
            <input name="TWCH_SideSpaceMobile" type="range" min="1" max="300" value="<?php echo isset($float_option) ? esc_attr( $float_option['TWCH_SideSpaceMobile'] ) : '24'; ?>" oninput="this.nextElementSibling.value = this.value+'px'">
            <output><?php echo isset($float_option) ? esc_html( $float_option['TWCH_SideSpaceMobile'] ) : '24'; ?>px</output>
            <br>
            <Label for="TWCH_bottomDistance" style="line-height: 25px;"><?php esc_html_e('Vertical','TWCHLANG'); ?></label>
            <br>
            <input name="TWCH_bottomDistanceMobile" type="range" min="1" max="300" value="<?php echo isset($float_option) ? esc_attr( $float_option['TWCH_bottomDistanceMobile'] ) : '24'; ?>" oninput="this.nextElementSibling.value = this.value+'px'">
            <output><?php echo isset($float_option) ? esc_html( $float_option['TWCH_bottomDistanceMobile'] ) : '24'; ?>px</output>
        </td>
    </tr>
    <tr><th><h2><?php esc_html_e("Box style", 'TWCHLANG'); ?></h2></th><td><hr></td></tr>
    <tr>
        <th scope="row">
            <?php esc_html_e('Title','TWCHLANG'); ?></th>
        <td>
            <input type="text" value="<?php echo isset($float_option) ? esc_attr( $float_option['floatBoxHeaderTitle'] ) : 'Two Way chat'; ?>" style="width:200px" name="floatBoxHeaderTitle">
        </td>
    </tr>
    <tr>
        <th scope="row">
            <?php esc_html_e('Description','TWCHLANG'); ?></th>
        <td>
            <input type="text" value="<?php echo isset($float_option) ? esc_attr( $float_option['floatBoxHeaderDecs'] ) : '#bdf6cf'; ?>" style="width:350px" name="floatBoxHeaderDecs">
        </td>
    </tr>
    <tr>
        <th scope="row">
            <?php esc_html_e('Header background color','TWCHLANG'); ?></th>
        <td>
            <input type="color" value="<?php echo  isset($float_option) ? esc_attr( $float_option['floatBoxHeaderBackground'] ) : '#bdf6cf'; ?>" style="width:80px" name="floatBoxHeaderBackground" oninput="this.nextElementSibling.value = this.value">
            <output><?php echo isset($float_option) ? esc_html( $float_option['floatBoxHeaderBackground'] ) : '#bdf6cf'; ?></output>
        </td>
    </tr>
    <tr>
        <th scope="row">
            <?php esc_html_e('Text color','TWCHLANG'); ?></th>
        <td>
            <input type="color" value="<?php echo isset($float_option) ? esc_attr( $float_option['floatBoxTextColor'] ) : '#bdf6cf'; ?>" style="width:80px" name="floatBoxTextColor" oninput="this.nextElementSibling.value = this.value">
            <output><?php echo isset($float_option) ? esc_html( $float_option['floatBoxTextColor'] ) : '#bdf6cf'; ?></output>
        </td>
    </tr>
    <tr>
        <th scope="row">
            <?php esc_html_e('Close botton color','TWCHLANG'); ?></th>
        <td>
            <input type="color" value="<?php echo isset($float_option) ? htmlspecialchars( $float_option['floatBoxCloseBtnColor'] ) : '#bdf6cf'; ?>" style="width:80px" name="floatBoxCloseBtnColor" oninput="this.nextElementSibling.value = this.value">
            <output><?php echo isset($float_option) ? esc_html( $float_option['floatBoxCloseBtnColor'] ) : '#bdf6cf'; ?></output>
        </td>
    </tr>
</table>
<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_attr_e('Save Changes','TWCHLANG'); ?>">

<script>
jQuery(function(){
    //fold wordpress admin menu
    jQuery(document).ready(function(){jQuery("body").addClass("folded")});
    //live float style
    jQuery('form :input').on('input', function() {
        var floatPadding1 = jQuery('input[name="floatSize"]').val()*jQuery('input[name="floatPadding1"]').val()/100;
        var floatPadding2 = jQuery('input[name="floatSize"]').val()*jQuery('input[name="floatPadding2"]').val()/100;
        var floatWidth = jQuery('input[name="floatSize"]').val()-floatPadding1-floatPadding2;
        
        jQuery("div.TWCHFloatBtn .TWCH-icon").prop('src',jQuery('input[name="float-icon"]:checked').next().attr('src'));
        
        //disable background when padding is 0
        if(floatPadding2!=0){
            jQuery("div.TWCHFloatBtn").css("background-color", jQuery('input[name="floatBackground2"]').val());
        }else{
            jQuery("div.TWCHFloatBtn").css("background-color", 'unset');
        }
        //disable background when padding is 0
        if(floatPadding1!=0){
            jQuery("div.TWCHFloatBtn div").css("background-color", jQuery('input[name="floatBackground1"]').val());
        }else{
            jQuery("div.TWCHFloatBtn div").css("background-color", 'unset');
        }
        jQuery("div.TWCHFloatBtn").css("border-radius", jQuery('input[name="floatRadius2"]').val()+'%');
        jQuery("div.TWCHBoxHeader").css("background-color", jQuery('input[name="floatBoxHeaderBackground"]').val());
        jQuery("div.TWCHBoxHeader").css("color", jQuery('input[name="floatBoxTextColor"]').val());
        jQuery("div.TWCHFloatBoxTitle").text(jQuery('input[name="floatBoxHeaderTitle"]').val());
        jQuery("div.TWCHBoxHeader p").text(jQuery('input[name="floatBoxHeaderDecs"]').val());
        jQuery("div.TWCHBoxHeader svg").css("fill", jQuery('input[name="floatBoxCloseBtnColor"]').val());
        jQuery("div.TWCHFloatBtn div").css("border-radius", jQuery('input[name="floatRadius1"]').val()+'%');
        jQuery(".TWCHFloatBtn .TWCH-icon").css("width",floatWidth +'px' );
        jQuery(".TWCHFloatBtn .TWCH-icon").css("height",floatWidth +'px' );
        jQuery("div.TWCHFloatBtn div").css("padding", floatPadding1 +'px');
        jQuery("div.TWCHFloatBtn").css("padding", floatPadding2 +'px');
        jQuery("div.TWCHFloatBtn").css("padding", floatPadding2 +'px');

        jQuery("div.TWCHFloatContainer").css("bottom", jQuery('input[name="TWCH_bottomDistance"]').val() +'px');
        jQuery("div.TWCHFloatBox").css("bottom", jQuery('input[name="TWCH_bottomDistance"]').val() +'px');
        if(jQuery('input[name="float-location"]:checked').val()=='Left'){
            jQuery("div.TWCHFloatContainer").css('left',jQuery('input[name="TWCH_SideSpace"]').val()+'px');
            jQuery('div.TWCHFloatContainer').css('right','unset');
            jQuery("div.TWCHFloatBox").css('left',(jQuery('input[name="TWCH_SideSpace"]').val()-1)+'px');
            jQuery('div.TWCHFloatBox').css('right','unset');
            jQuery('div.TWCHFloatBtn').css('float','left');
            jQuery('div.TWCHFloatBox').css('transform-origin','left bottom');
            
        }else{
            jQuery("div.TWCHFloatContainer").css('right',jQuery('input[name="TWCH_SideSpace"]').val()+'px');
            jQuery('div.TWCHFloatContainer').css('left','unset');
            jQuery("div.TWCHFloatBox").css('right',(jQuery('input[name="TWCH_SideSpace"]').val()-1)+'px');
            jQuery('div.TWCHFloatBox').css('left','unset');
            jQuery('div.TWCHFloatBtn').css('float','right');
            jQuery('div.TWCHFloatBox').css('transform-origin','right bottom');


        }
    });
   });
</script>