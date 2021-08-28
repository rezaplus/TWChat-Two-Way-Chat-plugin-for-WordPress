<?php
if(!current_user_can('administrator')){
    die(esc_html('Only administrators have access to this page.','DTWPLANG'));
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
    update_option('DTWP_Accessibility_settings',$settings_);
    update_option('DTWP_Accessibility_WC',$WC_);
}
    $settings_get= get_option('DTWP_Accessibility_settings');
    $WC_get= get_option('DTWP_Accessibility_WC');

global $wp_roles;
$roles = $wp_roles->roles;
unset($roles['administrator']);
unset($roles['subscriber']);
?>
<h2><?php esc_html_e('Selected user roles will have access to plugin features.','DTWPLANG'); ?></h2>
<table class="wp-list-table widefat striped table-view-list">
    <tr>
        <th><?php esc_html_e('Role','DTWPLANG'); ?></th>
        <th><?php esc_html_e('Settings','DTWPLANG'); ?></th>
        <th><?php esc_html_e('Woocommerce','DTWPLANG'); ?></th>
    </tr>
<?php
foreach($roles as $key => $value){
?>
    <tr>
        <td><?= $value['name'] ?></td>
        <td><input type="checkbox" name="S_<?= $key ?>" value="Settings" <?= in_array($key,$settings_get) ? 'checked' : '' ?>></td>
        <td><input type="checkbox" name="W_<?= $key ?>"value="WC" <?= in_array($key,$WC_get) ? 'checked' : '' ?>></td>
<?php } ?>
    </tr>
</table>
<button type="submit" name="submit" class="button button-primary" value="Accessibility"><?php esc_html_e('Save Changes','DTWPLANG'); ?></button>
