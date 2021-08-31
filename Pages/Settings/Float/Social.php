<?php
    if(isset($_POST['submit'])){
        unset($_POST['submit']);
        foreach($_POST as $key => $value){
            if(empty($value)){
                unset($_POST[$key]);
            }
        }
        update_option('DTWP_Float_social',array_map( 'sanitize_text_field', $_POST));
    }
    $DTWP_social = get_option('DTWP_Float_social');
?>
<table class="form-table dtwp-form-table dtwp-social-settings">
    <tbody>
        <tr>
            <th scope="row">
                <img src="<?php echo DTWP_image ?>socialIcons/instagram.svg">
            </th>
            <td>
                <input name="instagram" type="url" placeholder="https://..." value="<?php echo isset($DTWP_social['instagram']) ? esc_url($DTWP_social['instagram']) : '' ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <img src="<?php echo DTWP_image ?>socialIcons/facebook.svg">
            </th>
            <td>
                <input name="facebook" type="url" placeholder="https://..." value="<?php echo isset($DTWP_social['facebook']) ? esc_url($DTWP_social['facebook']) : '' ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <img src="<?php echo DTWP_image ?>socialIcons/twitter.svg">
            </th>
            <td>
                <input name="twitter" type="url" placeholder="https://..." value="<?php echo isset($DTWP_social['twitter']) ? esc_url($DTWP_social['twitter']) : '' ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <img src="<?php echo DTWP_image ?>socialIcons/telegram.svg">
            </th>
            <td>
                <input name="telegram" type="url" placeholder="https://..." value="<?php echo isset($DTWP_social['telegram']) ? esc_url( $DTWP_social['telegram']) : '' ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <img src="<?php echo DTWP_image ?>socialIcons/linkedin.svg">
            </th>
            <td>
                <input name="linkedin" type="url" placeholder="https://..." value="<?php echo isset($DTWP_social['linkedin']) ? esc_url($DTWP_social['linkedin']) : '' ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <img src="<?php echo DTWP_image ?>socialIcons/youtube.svg">
            </th>
            <td>
                <input name="youtube" type="url" placeholder="https://..." value="<?php echo isset($DTWP_social['youtube']) ? esc_url($DTWP_social['youtube']) : '' ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <img src="<?php echo DTWP_image ?>socialIcons/snapchat.svg">
            </th>
            <td>
                <input name="snapchat" type="url" placeholder="https://..." value="<?php echo isset($DTWP_social['snapchat']) ? esc_url($DTWP_social['snapchat']) : '' ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <img src="<?php echo DTWP_image ?>socialIcons/pinterest.svg">
            </th>
            <td>
                <input name="pinterest" type="url" placeholder="https://..." value="<?php echo isset($DTWP_social['pinterest']) ? esc_url($DTWP_social['pinterest']) : '' ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <img src="<?php echo DTWP_image ?>socialIcons/flickr.svg">
            </th>
            <td>
                <input name="flickr" type="url" placeholder="https://..." value="<?php echo isset($DTWP_social['flickr']) ? esc_url($DTWP_social['flickr']) : '' ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <img src="<?php echo DTWP_image ?>socialIcons/dribbble.svg">
            </th>
            <td>
                <input name="dribbble" type="url" placeholder="https://..." value="<?php echo isset($DTWP_social['dribbble']) ? esc_url($DTWP_social['dribbble']) : '' ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <img src="<?php echo DTWP_image ?>socialIcons/behance.svg">
            </th>
            <td>
                <input name="behance" type="url" placeholder="https://..." value="<?php echo isset($DTWP_social['behance']) ? esc_url($DTWP_social['behance']) : '' ?>">
            </td>
        <tr>
    </tbody>
</table>
<button type="submit" name="submit" class="button button-primary" value="social"><?php esc_html_e('Save Changes','DTWPLANG'); ?></button>