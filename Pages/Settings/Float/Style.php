<?php

if(isset($_POST['submit'])){
    unset($_POST['submit']);
    update_option('DTWP_float_options',array_map( 'sanitize_text_field', $_POST ));
}
$float_option = get_option('DTWP_float_options');

//include float button
wp_enqueue_style( 'Float', DTWP_assets . 'floatStyle.css',true, DTWP_plugin_version );
require_once DTWP_DIR_path.'Pages/Float.php';
?>
<table class="form-table dtwp-form-table">
    <tr><th><h2><?php esc_html_e("Button style", 'DTWPLANG'); ?></h2></th><td><hr></td></tr>
    <tr class="dtwp-select-icon">
        <th scope="row">
        <?php esc_html_e("Icon", 'DTWPLANG'); ?></th>
        <td>
        <?php
        for($i=0;$i<=18;$i++){ $floatIcon = "float-icon$i.svg";?>
        
        <label>
            <input name="float-icon" type="radio" value="<?php esc_attr_e($floatIcon); ?>" <?= $float_option['float-icon'] == $floatIcon ? 'checked' : ''; ?>>
            <img class="dtwp-icon" src="<?= esc_url(DTWP_image."float-icon/".$floatIcon."?ver=".DTWP_plugin_version); ?>" >
        </label>
        <?php } ?>
        </td>
    </tr>
    <tr>
        <th scope="row"><?php esc_html_e('size','DTWPLANG'); ?></th>
        <td>
            <input name="floatSize" type="range" value="<?= isset($float_option) ? esc_attr( $float_option['floatSize']) : '40'; ?>" min="25" max="300" oninput="this.nextElementSibling.value = this.value+'px'">
            <output><?= isset($float_option) ? esc_html( $float_option['floatSize'] ) : '40px'; ?></output>
        </td>
    </tr>
    <tr>
        <th scope="row"><?php esc_html_e('First background color','DTWPLANG'); ?></th>
        <td>
            <input type="color" value="<?= isset($float_option) ? esc_attr( $float_option['floatBackground1'] ) : '#39a805'; ?>" style="width:80px" name="floatBackground1" oninput="this.nextElementSibling.value = this.value">
            <output><?= isset($float_option) ? esc_html( $float_option['floatBackground1'] ) : '#39a805'; ?></output>
        </td>
    </tr>
    <tr>
        <th scope="row"><?php esc_html_e('Rounded corners','DTWPLANG'); ?></th>
        <td>
            <input name="floatRadius1" type="range" min="0" max="50" value="<?= isset($float_option) ? esc_attr($float_option['floatRadius1']) : '50'; ?>" oninput="this.nextElementSibling.value = this.value+'%'">
            <output><?= isset($float_option) ? esc_html($float_option['floatRadius1'] ) : '50'; ?>%</output>
        </td>
    </tr> 
    <tr>
        <th scope="row"><?php esc_html_e('Padding','DTWPLANG'); ?></th>
        <td>
            <input name="floatPadding1" type="range" min="0" max="20" value="<?= isset($float_option) ? esc_attr( $float_option['floatPadding1'] ) : '50'; ?>" oninput="this.nextElementSibling.value = this.value+'px'">
            <output><?= isset($float_option) ? esc_html( $float_option['floatPadding1'] ) : '6'; ?>px</output>
        </td>
    </tr> 
    <tr>
        <th scope="row"><?php esc_html_e('Second background color','DTWPLANG'); ?></th>
        <td>
            <input type="color" value="<?=  isset($float_option) ? esc_attr( $float_option['floatBackground2'] ): '#39a805'; ?>" style="width:80px" name="floatBackground2" oninput="this.nextElementSibling.value = this.value">
            <output><?=isset($float_option) ?  esc_html( $float_option['floatBackground2'] ): '#39a805'; ?></output>
        </td>
    </tr>
    <tr>
        <th scope="row"><?php esc_html_e('Rounded corners','DTWPLANG'); ?></th>
        <td>
            <input name="floatRadius2" type="range" min="0" max="50" value="<?= isset($float_option) ? esc_attr( $float_option['floatRadius2'] ): '50'; ?>" oninput="this.nextElementSibling.value = this.value+'%'">
            <output><?= isset($float_option) ? esc_html( $float_option['floatRadius2'] ) : '50'; ?>%</output>
        </td>
    </tr>  
    <tr>
        <th scope="row"><?php esc_html_e('Padding','DTWPLANG'); ?></th>
        <td>
            <input name="floatPadding2" type="range" min="0" max="20" value="<?= isset($float_option) ? esc_attr( $float_option['floatPadding2'] ) : '6'; ?>" oninput="this.nextElementSibling.value = this.value+'px'">
            <output><?= isset($float_option) ? esc_html( $float_option['floatPadding2'] ) : '6'; ?>px</output>
        </td>
    </tr> 
    <tr><th><h2><?php esc_html_e("Desktop", 'DTWPLANG'); ?></h2></th><td><hr></td></tr>
    <tr>
        <th scope="row"><?php esc_html_e("location", 'DTWPLANG'); ?></th>
        <td class="flex-dt">
        <label style="margin-right:5px;">
            <input name="float-location" type="radio" Value="Left" <?= $float_option['float-location']=='Left' ? 'checked' : ''; ?>>
            <?php esc_html_e('Left','DTWPLANG'); ?>
        </label>
        <label style="margin-left:5px;">
            <input name="float-location"  type="radio" Value="Right" <?= $float_option['float-location']=='Right' ? 'checked' : ''; ?>>
            <?php esc_html_e('Right','DTWPLANG'); ?>
        </label>
        </td>
    </tr>
    <tr>
        <th scope="row"><?php esc_html_e('position','DTWPLANG'); ?></th>
        <td>
            <Label for="dtwp_SideSpace" style="line-height: 25px;" ><?php esc_html_e('Distance from the side','DTWPLANG'); ?></label>
            <br>
            <input name="dtwp_SideSpace" type="range" min="1" max="300" value="<?= isset($float_option) ? esc_attr( $float_option['dtwp_SideSpace'] ) : '24'; ?>" oninput="this.nextElementSibling.value = this.value+'px'">
            <output><?= isset($float_option) ? esc_html( $float_option['dtwp_SideSpace'] ) : '24'; ?>px</output>
            <br>
            <Label for="dtwp_bottomDistance" style="line-height: 25px;"><?php esc_html_e('Distance from the bottom','DTWPLANG'); ?></label>
            <br>
            <input name="dtwp_bottomDistance" type="range" min="1" max="300" value="<?=  isset($float_option) ?esc_attr(  $float_option['dtwp_bottomDistance'] ) : '24'; ?>" oninput="this.nextElementSibling.value = this.value+'px'">
            <output><?= isset($float_option) ? esc_html( $float_option['dtwp_bottomDistance'] ) : '24'; ?>px</output>
        </td>
    </tr>
    <tr><th><h2><?php esc_html_e("Mobile", 'DTWPLANG'); ?></h2></th><td><hr></td></tr>
    <tr>
        <th scope="row"><?php esc_html_e("location", 'DTWPLANG'); ?></th>
        <td class="flex-dt">
        <label style="margin-right:5px;">
            <input name="float-locationMobile" type="radio" Value="Left" <?= $float_option['float-locationMobile']=='Left' ? 'checked' : ''; ?>>
            <?php esc_html_e('Left','DTWPLANG'); ?>
        </label>
        <label style="margin-left:5px;">
            <input name="float-locationMobile"  type="radio" Value="Right" <?= $float_option['float-locationMobile']=='Right' ? 'checked' : ''; ?>>
            <?php esc_html_e('Right','DTWPLANG'); ?>
        </label>
        </td>
    </tr>
    <tr>
        <th scope="row"><?php esc_html_e('position','DTWPLANG'); ?></th>
        <td>
            <Label for="dtwp_SideSpace" style="line-height: 25px;" ><?php esc_html_e('Distance from the side','DTWPLANG'); ?></label>
            <br>
            <input name="dtwp_SideSpaceMobile" type="range" min="1" max="300" value="<?= isset($float_option) ? esc_attr( $float_option['dtwp_SideSpaceMobile'] ) : '24'; ?>" oninput="this.nextElementSibling.value = this.value+'px'">
            <output><?= isset($float_option) ? esc_html( $float_option['dtwp_SideSpaceMobile'] ) : '24'; ?>px</output>
            <br>
            <Label for="dtwp_bottomDistance" style="line-height: 25px;"><?php esc_html_e('Distance from the bottom','DTWPLANG'); ?></label>
            <br>
            <input name="dtwp_bottomDistanceMobile" type="range" min="1" max="300" value="<?= isset($float_option) ? esc_attr( $float_option['dtwp_bottomDistanceMobile'] ) : '24'; ?>" oninput="this.nextElementSibling.value = this.value+'px'">
            <output><?= isset($float_option) ? esc_html( $float_option['dtwp_bottomDistanceMobile'] ) : '24'; ?>px</output>
        </td>
    </tr>
    <tr><th><h2><?php esc_html_e("Box style", 'DTWPLANG'); ?></h2></th><td><hr></td></tr>
    <tr>
        <th scope="row">
            <?php esc_html_e('Title','DTWPLANG'); ?></th>
        <td>
            <input type="text" value="<?= isset($float_option) ? esc_attr( $float_option['floatBoxHeaderTitle'] ) : 'DTWhatsapp'; ?>" style="width:200px" name="floatBoxHeaderTitle">
        </td>
    </tr>
    <tr>
        <th scope="row">
            <?php esc_html_e('Description','DTWPLANG'); ?></th>
        <td>
            <input type="text" value="<?= isset($float_option) ? esc_attr( $float_option['floatBoxHeaderDecs'] ) : '#bdf6cf'; ?>" style="width:350px" name="floatBoxHeaderDecs">
        </td>
    </tr>
    <tr>
        <th scope="row">
            <?php esc_html_e('Header background color','DTWPLANG'); ?></th>
        <td>
            <input type="color" value="<?=  isset($float_option) ? esc_attr( $float_option['floatBoxHeaderBackground'] ) : '#bdf6cf'; ?>" style="width:80px" name="floatBoxHeaderBackground" oninput="this.nextElementSibling.value = this.value">
            <output><?= isset($float_option) ? esc_html( $float_option['floatBoxHeaderBackground'] ) : '#bdf6cf'; ?></output>
        </td>
    </tr>
    <tr>
        <th scope="row">
            <?php esc_html_e('Text color','DTWPLANG'); ?></th>
        <td>
            <input type="color" value="<?= isset($float_option) ? esc_attr( $float_option['floatBoxTextColor'] ) : '#bdf6cf'; ?>" style="width:80px" name="floatBoxTextColor" oninput="this.nextElementSibling.value = this.value">
            <output><?= isset($float_option) ? esc_html( $float_option['floatBoxTextColor'] ) : '#bdf6cf'; ?></output>
        </td>
    </tr>
    <tr>
        <th scope="row">
            <?php esc_html_e('Close botton color','DTWPLANG'); ?></th>
        <td>
            <input type="color" value="<?= isset($float_option) ? htmlspecialchars( $float_option['floatBoxCloseBtnColor'] ) : '#bdf6cf'; ?>" style="width:80px" name="floatBoxCloseBtnColor" oninput="this.nextElementSibling.value = this.value">
            <output><?= isset($float_option) ? esc_html( $float_option['floatBoxCloseBtnColor'] ) : '#bdf6cf'; ?></output>
        </td>
    </tr>
</table>
<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_attr_e('Save Changes','DTWPLANG'); ?>">

<script>
jQuery(function(){
    //fold wordpress admin menu
    jQuery(document).ready(function(){jQuery("body").addClass("folded")});
    //live float style
    jQuery('form :input').on('input', function() {
        var floatPadding1 = jQuery('input[name="floatSize"]').val()*jQuery('input[name="floatPadding1"]').val()/100;
        var floatPadding2 = jQuery('input[name="floatSize"]').val()*jQuery('input[name="floatPadding2"]').val()/100;
        var floatWidth = jQuery('input[name="floatSize"]').val()-floatPadding1-floatPadding2;
        
        jQuery("div.dtwpFloatBtn .dtwp-icon").prop('src',jQuery('input[name="float-icon"]:checked').next().attr('src'));
        
        //disable background when padding is 0
        if(floatPadding2!=0){
            jQuery("div.dtwpFloatBtn").css("background-color", jQuery('input[name="floatBackground2"]').val());
        }else{
            jQuery("div.dtwpFloatBtn").css("background-color", 'unset');
        }
        //disable background when padding is 0
        if(floatPadding1!=0){
            jQuery("div.dtwpFloatBtn div").css("background-color", jQuery('input[name="floatBackground1"]').val());
        }else{
            jQuery("div.dtwpFloatBtn div").css("background-color", 'unset');
        }
        jQuery("div.dtwpFloatBtn").css("border-radius", jQuery('input[name="floatRadius2"]').val()+'%');
        jQuery("div.dtwpBoxHeader").css("background-color", jQuery('input[name="floatBoxHeaderBackground"]').val());
        jQuery("div.dtwpBoxHeader").css("color", jQuery('input[name="floatBoxTextColor"]').val());
        jQuery("div.dtwpFloatBoxTitle").text(jQuery('input[name="floatBoxHeaderTitle"]').val());
        jQuery("div.dtwpBoxHeader p").text(jQuery('input[name="floatBoxHeaderDecs"]').val());
        jQuery("div.dtwpBoxHeader svg").css("fill", jQuery('input[name="floatBoxCloseBtnColor"]').val());
        jQuery("div.dtwpFloatBtn div").css("border-radius", jQuery('input[name="floatRadius1"]').val()+'%');
        jQuery(".dtwpFloatBtn .dtwp-icon").css("width",floatWidth +'px' );
        jQuery(".dtwpFloatBtn .dtwp-icon").css("height",floatWidth +'px' );
        jQuery("div.dtwpFloatBtn div").css("padding", floatPadding1 +'px');
        jQuery("div.dtwpFloatBtn").css("padding", floatPadding2 +'px');
        jQuery("div.dtwpFloatBtn").css("padding", floatPadding2 +'px');

        jQuery("div.dtwpFloatContainer").css("bottom", jQuery('input[name="dtwp_bottomDistance"]').val() +'px');
        jQuery("div.dtwpFloatBox").css("bottom", jQuery('input[name="dtwp_bottomDistance"]').val() +'px');
        if(jQuery('input[name="float-location"]:checked').val()=='Left'){
            jQuery("div.dtwpFloatContainer").css('left',jQuery('input[name="dtwp_SideSpace"]').val()+'px');
            jQuery('div.dtwpFloatContainer').css('right','unset');
            jQuery("div.dtwpFloatBox").css('left',(jQuery('input[name="dtwp_SideSpace"]').val()-1)+'px');
            jQuery('div.dtwpFloatBox').css('right','unset');
            jQuery('div.dtwpFloatBtn').css('float','left');
            jQuery('div.dtwpFloatBox').css('transform-origin','left bottom');
            
        }else{
            jQuery("div.dtwpFloatContainer").css('right',jQuery('input[name="dtwp_SideSpace"]').val()+'px');
            jQuery('div.dtwpFloatContainer').css('left','unset');
            jQuery("div.dtwpFloatBox").css('right',(jQuery('input[name="dtwp_SideSpace"]').val()-1)+'px');
            jQuery('div.dtwpFloatBox').css('left','unset');
            jQuery('div.dtwpFloatBtn').css('float','right');
            jQuery('div.dtwpFloatBox').css('transform-origin','right bottom');


        }
    });
   });
</script>