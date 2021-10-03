<?php
function TWCH_manage_accessibility(){
    //check nonce.
    if (isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'],'TWCH_nonce_field' )) {
        $roles = get_users_roles();
        foreach ($roles as $key => $value) {
            //get accessibility
            $accessibility_settings = (isset($_POST['S_'.$key])) ? true : false;
            $accessibility_woocommerce = (isset($_POST['W_'.$key])) ? true : false;
            //add or remove cap from users.
            TWCH_capabilities_add_remove('TWCH_settings', $key, $accessibility_settings);
            TWCH_capabilities_add_remove('TWCH_woocommerce', $key, $accessibility_woocommerce);
        }
    }
}

function TWCH_capabilities_add_remove($cap, $roleKey, $accessibility)
{
    $role = get_role($roleKey);
    if (!$accessibility) {
        if ($role->has_cap($cap)) {
            $role->remove_cap($cap);
        }
    } else {
        if (!$role->has_cap($cap)) {
            $role->add_cap($cap);
        }
    }
}

function get_users_roles(){
    global $wp_roles;
    $roles = $wp_roles->roles;
    unset($roles['administrator']);
    unset($roles['subscriber']);
    return $roles;
}