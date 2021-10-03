<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if(!current_user_can('administrator')){
    die(esc_html('Only administrators have access to this page.','TWCHLANG'));
}
//import accessibility functions
require_once  TWCH_DIR_path.'Classes/accessibility.php';

//submit accessibilitys changes
if(isset($_POST['submit']) && $_POST['submit'] == 'Accessibility')
    TWCH_manage_accessibility();

// get users with accessibilitys
$roles = get_users_roles();

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
        <td><input type="checkbox" name="S_<?php echo  $key ?>" value="TWCH_settings" <?php echo  (isset($value['capabilities']['TWCH_settings'])) ? 'checked' : '' ?>></td>
        <td><input type="checkbox" name="W_<?php echo  $key ?>" value="TWCH_woocommerce" <?php echo  (isset($value['capabilities']['TWCH_woocommerce'])) ? 'checked' : '' ?>></td>
<?php } ?>
    </tr>
</table>
<button type="submit" name="submit" class="button button-primary" value="Accessibility"><?php esc_html_e('Save Changes','TWCHLANG'); ?></button>
