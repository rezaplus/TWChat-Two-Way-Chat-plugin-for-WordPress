<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if(!current_user_can('administrator')){
    die(esc_html('Only administrators have access to this page.','TWCHLANG'));
}

if(isset($_POST['submit'])){
    unset($_POST['submit']);
    $settings_=array();
    $WC_ = array();
    foreach($_POST as $key => $val){
        if($val=='Settings'){
            array_push($settings_,str_replace('S_','',$key));
        }elseif($val=='WC'){
            array_push($WC_,str_replace('W_','',$key));
        }
    }
    update_option('TWCH_Accessibility_settings',array_map( 'sanitize_text_field', $settings_ ));
    update_option('TWCH_Accessibility_WC',array_map( 'sanitize_text_field', $WC_ ));
}
    $settings_get= get_option('TWCH_Accessibility_settings');
    $WC_get= get_option('TWCH_Accessibility_WC');

global $wp_roles;
$roles = $wp_roles->roles;
unset($roles['administrator']);
unset($roles['subscriber']);
?>
<h2><?php esc_html_e('Selected user roles will have access to plugin features.','TWCHLANG'); ?></h2>
<table class="wp-list-table widefat striped table-view-list">
    <tr>
        <th><?php esc_html_e('Role','TWCHLANG'); ?></th>
        <th><?php esc_html_e('Settings','TWCHLANG'); ?></th>
        <th><?php esc_html_e('Woocommerce','TWCHLANG'); ?></th>
    </tr>
<?php
foreach($roles as $key => $value){
?>
    <tr>
        <td><?php echo  $value['name'] ?></td>
        <td><input type="checkbox" name="S_<?php echo  $key ?>" value="Settings" <?php echo  in_array($key,$settings_get) ? 'checked' : '' ?>></td>
        <td><input type="checkbox" name="W_<?php echo  $key ?>"value="WC" <?php echo  in_array($key,$WC_get) ? 'checked' : '' ?>></td>
<?php } ?>
    </tr>
</table>
<button type="submit" name="submit" class="button button-primary" value="Accessibility"><?php esc_html_e('Save Changes','TWCHLANG'); ?></button>
