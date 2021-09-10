<?php
    if(isset($_POST['submit'])){
        unset($_POST['submit']);
        foreach($_POST as $key => $value){
            if(empty($value)){
                unset($_POST[$key]);
            }
        }
        update_option('TWCH_Float_social',array_map( 'sanitize_text_field', $_POST));
    }
    $TWCH_social = get_option('TWCH_Float_social');
?>
<table class="form-table TWCH-form-table TWCH-social-settings">
    <tbody>
        <tr>
            <th scope="row">
                <img src="<?php echo TWCH_image ?>socialIcons/instagram.svg">
            </th>
            <td>
                <input name="instagram" type="url" placeholder="https://..." value="<?php echo isset($TWCH_social['instagram']) ? esc_url($TWCH_social['instagram']) : '' ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <img src="<?php echo TWCH_image ?>socialIcons/facebook.svg">
            </th>
            <td>
                <input name="facebook" type="url" placeholder="https://..." value="<?php echo isset($TWCH_social['facebook']) ? esc_url($TWCH_social['facebook']) : '' ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <img src="<?php echo TWCH_image ?>socialIcons/twitter.svg">
            </th>
            <td>
                <input name="twitter" type="url" placeholder="https://..." value="<?php echo isset($TWCH_social['twitter']) ? esc_url($TWCH_social['twitter']) : '' ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <img src="<?php echo TWCH_image ?>socialIcons/telegram.svg">
            </th>
            <td>
                <input name="telegram" type="url" placeholder="https://..." value="<?php echo isset($TWCH_social['telegram']) ? esc_url( $TWCH_social['telegram']) : '' ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <img src="<?php echo TWCH_image ?>socialIcons/linkedin.svg">
            </th>
            <td>
                <input name="linkedin" type="url" placeholder="https://..." value="<?php echo isset($TWCH_social['linkedin']) ? esc_url($TWCH_social['linkedin']) : '' ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <img src="<?php echo TWCH_image ?>socialIcons/youtube.svg">
            </th>
            <td>
                <input name="youtube" type="url" placeholder="https://..." value="<?php echo isset($TWCH_social['youtube']) ? esc_url($TWCH_social['youtube']) : '' ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <img src="<?php echo TWCH_image ?>socialIcons/snapchat.svg">
            </th>
            <td>
                <input name="snapchat" type="url" placeholder="https://..." value="<?php echo isset($TWCH_social['snapchat']) ? esc_url($TWCH_social['snapchat']) : '' ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <img src="<?php echo TWCH_image ?>socialIcons/pinterest.svg">
            </th>
            <td>
                <input name="pinterest" type="url" placeholder="https://..." value="<?php echo isset($TWCH_social['pinterest']) ? esc_url($TWCH_social['pinterest']) : '' ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <img src="<?php echo TWCH_image ?>socialIcons/flickr.svg">
            </th>
            <td>
                <input name="flickr" type="url" placeholder="https://..." value="<?php echo isset($TWCH_social['flickr']) ? esc_url($TWCH_social['flickr']) : '' ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <img src="<?php echo TWCH_image ?>socialIcons/dribbble.svg">
            </th>
            <td>
                <input name="dribbble" type="url" placeholder="https://..." value="<?php echo isset($TWCH_social['dribbble']) ? esc_url($TWCH_social['dribbble']) : '' ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <img src="<?php echo TWCH_image ?>socialIcons/behance.svg">
            </th>
            <td>
                <input name="behance" type="url" placeholder="https://..." value="<?php echo isset($TWCH_social['behance']) ? esc_url($TWCH_social['behance']) : '' ?>">
            </td>
        <tr>
    </tbody>
</table>
<button type="submit" name="submit" class="button button-primary" value="social"><?php esc_html_e('Save Changes','TWCHLANG'); ?></button>