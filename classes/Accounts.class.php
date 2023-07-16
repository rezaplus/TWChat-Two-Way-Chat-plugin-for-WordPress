<?php
/**
 * Register account custom post type
 * this class is disabled by default and can be enabled by using filter 'twchat_accouns_is_enable' like this:
 * add_filter('twchat_accouns_is_enable', '__return_true');
 * 
 * @package TWChat
 */

namespace twchat\classes;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

use twchat\helpers\AutoLoader;

AutoLoader::init()->getInstanceOf(Custom_post_type::class, [], 'admin');


class Accounts extends Custom_post_type
{

    /**
     * define custom post type name
     * 
     * @var string
     */
    public $post_type = 'twchat_account';

    /**
     * constructor function to register custom post type
     * and add account meta boxs
     * 
     * @var string
     * @since 4.0.0
     */
    public function __construct()
    {
        // check if the post type not exists
        if (!post_type_exists($this->post_type)) {
            add_action('init', array($this, 'register_post_type')); // register custom post type
            add_action('add_meta_boxes', array($this, 'add_account_meta_boxes')); // add account details meta box
            add_action('save_post', array($this, 'save_account_meta_boxes')); // save account details meta box
            add_filter('wp_insert_post_data', array($this, 'save_post_title'), 10, 2); // save account full name as post title
            add_filter('TWChat_account_details_fields', array($this, 'TWChat_account_details_fields')); // fields of account details meta box
            add_filter('TWChat_account_profile_fields', array($this, 'TWChat_account_profile_fields')); // fields of account profile meta box
            add_filter('TWChat_account_whatsapp_fields', array($this, 'TWChat_account_whatsapp_fields')); // fields of account whatsapp meta box
            add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts')); // enqueue admin scripts
        }
    }

    /**
     * register accounts post type function
     * Note: this function will be called from constructor function
     * 
     * @since 4.0.0
     * @return void
     */
    public function register_post_type()
    {
        // define labels of custom post type
        $labels = array(
            'name'                  => _x('Accounts', 'Post type general name', 'twchatlang'),
            'singular_name'         => __('Account', 'twchatlang'),
            'menu_name'             => __('TWChat', 'twchatlang'),
            'name_admin_bar'        => __('Account', 'twchatlang'),
            'add_new'               => __('Create New', 'twchatlang'),
            'add_new_item'          => __('Create New Account', 'twchatlang'),
            'new_item'              => __('New Account', 'twchatlang'),
            'edit_item'             => __('Edit Account', 'twchatlang'),
            'view_item'             => __('View Account', 'twchatlang'),
            'all_items'             => __('Accounts', 'twchatlang'),
            'search_items'          => __('Search Accounts', 'twchatlang'),
            'parent_item_colon'     => __('Parent Accounts:', 'twchatlang'),
            'not_found'             => __('No Accounts found.', 'twchatlang'),
            'not_found_in_trash'    => __('No Accounts found in Trash.', 'twchatlang'),
            'featured_image'        => __('Account Image', 'twchatlang'),
            'set_featured_image'    => __('Set account image', 'twchatlang'),
            'remove_featured_image' => __('Remove account image', 'twchatlang'),
            'use_featured_image'    => __('Use as account image', 'twchatlang'),
            'archives'              => __('Account archives', 'twchatlang'),
            'insert_into_item'      => __('Insert into account', 'twchatlang'),
            'uploaded_to_this_item' => __('Uploaded to this account', 'twchatlang'),
            'filter_items_list'     => __('Filter accounts list', 'twchatlang'),
            'items_list_navigation' => __('Accounts list navigation', 'twchatlang'),
            'items_list'            => __('Accounts list', 'twchatlang'),
        );
        // define args of custom post type
        $args = array(
            'labels'             => $labels,
            'description'        => __('Manage TWChat Support Accounts', 'twchatlang'),
            'public'             => false,
            'publicly_queryable' => false,
            'show_ui'            => true,
            'show_in_menu'       => 'twchat',
            'query_var'          => true,
            'rewrite'            => array('slug' => 'twchat_account'),
            'capability_type'    => 'post',
            'has_archive'        => false,
            'hierarchical'       => false,
            'menu_position'      => 100,
            'supports'           => array('thumbnail', 'revisions'),
        );
        // register custom post type
        register_post_type($this->post_type, $args);
    }

    /**
     * Initialize account meta boxes
     * default meta boxes defined in this function
     * it can be added or removed meta boxes by using filter
     * 
     * @since 4.0.0
     * @return array
     */
    public function initialize_metaboxes()
    {
        $this->meta_boxes  = array(
            array('TWChat_account_details', __('Details', 'twchatlang'), 'normal', 'high'),
            array('TWChat_account_profile', __('Profile', 'twchatlang'), 'side', 'high'),
            array('TWChat_account_whatsapp', __('WhatsApp', 'twchatlang'), 'normal', 'low'),
        );

        return apply_filters('twchat/account_details/metaboxes', $this->meta_boxes);
    }

    /**
     * Add account meta boxes by using custom post type class
     * first initialize meta boxes
     * second set post type
     * third set meta boxes
     * fire add_meta_boxes function
     * 
     * @since 4.0.0
     * @return void
     */
    public function add_account_meta_boxes()
    {
        $metaboxes = $this->initialize_metaboxes();
        parent::set_post_type($this->post_type);
        parent::set_meta_boxes($metaboxes);
        parent::add_meta_boxes();
    }

    /**
     * Save account meta boxes by using custom post type class
     * first check if post type is account
     * second initialize meta boxes
     * third set post type
     * fourth set meta boxes
     * fire save_meta_boxes function
     * 
     * @since 4.0.0
     * @param  mixed $post_id
     * @return void
     */
    public function save_account_meta_boxes($post_id)
    {
        if (!isset($_POST['post_type']) or $_POST['post_type'] != $this->post_type) {
            return;
        }
        $metaboxes = $this->initialize_metaboxes();
        parent::set_post_type($this->post_type);
        parent::set_meta_boxes($metaboxes);
        parent::save_meta_boxes($post_id);
    }

    /**
     * save name of the account as post title
     *
     * @param  mixed $data
     * @param  mixed $postarr
     * @return void
     */
    public function save_post_title($data, $postarr)
    {
        if ($data['post_type'] == $this->post_type) {
            $first_name = isset($postarr['TWChat_account_details']['first_name']) ? $postarr['TWChat_account_details']['first_name'] : '';
            $last_name = isset($postarr['TWChat_account_details']['last_name']) ? $postarr['TWChat_account_details']['last_name'] : '';
            $nickname = isset($postarr['TWChat_account_details']['nickname']) ? $postarr['TWChat_account_details']['nickname'] : '';
            switch ($postarr['TWChat_account_details']['display_name_as']) {
                case 'first_last':
                    $data['post_title'] = $first_name . ' ' . $last_name;
                    break;
                case 'last_first':
                    $data['post_title'] = $last_name . ', ' . $first_name;
                    break;
                case 'first':
                    $data['post_title'] = $first_name;
                    break;
                case 'last':
                    $data['post_title'] = $last_name;
                    break;
                case 'nickname':
                    $data['post_title'] = $nickname;
                    break;
            }
        }
        return $data;
    }

    /**
     * default fields of account profile meta box
     * NOTE: 
     * first part of the function name is same as metabox id defined in initialize_metaboxes function
     * second part should be finished with _fields
     *
     * @param  mixed $columns
     * @return void
     */
    public function TWChat_account_profile_fields($fields)
    {
        $fields['account_status'] = array(
            'label' => __('Account Status', 'twchatlang'),
            'type' => 'select',
            'options' => array(
                'active' => __('Active', 'twchatlang'),
                'inactive' => __('Inactive', 'twchatlang'),
                'away' => __('Away', 'twchatlang'),
                'busy' => __('Busy', 'twchatlang'),
            ),
            'required' => false,
            'priority' => '10',
        );

        $fields['available_from'] = array(
            'label' => __('Available From', 'twchatlang'),
            'type' => 'time',
            'placeholder' => __('When are you available from?', 'twchatlang'),
            'required' => false,
            'priority' => '20',
        );

        $fields['available_to'] = array(
            'label' => __('Available To', 'twchatlang'),
            'type' => 'time',
            'placeholder' => __('When are you available to?', 'twchatlang'),
            'required' => false,
            'priority' => '30',
        );
        $fields['thumbnail'] = array(
            'label' => __('Photo', 'twchatlang'),
            'type' => 'profile_image_radio',
            'placeholder' => __('Photo', 'twchatlang'),
            'required' => false,
            'priority' => '10',
            'options' => $this->get_default_profile_images(),
        );
        return $fields;
    }


    /**
     * default fields of account details meta box
     * NOTE: 
     * first part of the function name is same as metabox id defined in initialize_metaboxes function
     * second part should be finished with _fields
     *
     * @param  mixed $columns
     * @return void
     */
    public function TWChat_account_details_fields($fields)
    {
        $fields['first_name'] = array(
            'label' => __('First Name', 'twchatlang'),
            'type' => 'text',
            'placeholder' => __('First Name', 'twchatlang'),
            'required' => false,
            'priority' => '10',
        );
        $fields['last_name'] = array(
            'label' => __('Last Name', 'twchatlang'),
            'type' => 'text',
            'placeholder' => __('Last Name', 'twchatlang'),
            'required' => false,
            'priority' => '20',
        );
        $fields['nickname'] = array(
            'label' => __('Nickname', 'twchatlang'),
            'type' => 'text',
            'placeholder' => __('Nickname', 'twchatlang'),
            'required' => false,
            'priority' => '30',
        );
        $fields['title'] = array(
            'label' => __('Title', 'twchatlang'),
            'desc' => __('Position or title of the owner of the account.', 'twchatlang'),
            'type' => 'text',
            'placeholder' => __('Title of the account', 'twchatlang'),
            'required' => false,
            'priority' => '40',
        );
        $fields['email'] = array(
            'label' => __('Email', 'twchatlang'),
            'type' => 'email',
            'placeholder' => __('Email', 'twchatlang'),
            'required' => false,
            'priority' => '50',
        );
        $fields['phone'] = array(
            'label' => __('Phone', 'twchatlang'),
            'type' => 'text',
            'placeholder' => __('Phone', 'twchatlang'),
            'required' => false,
            'priority' => '60',
        );
        $fields['display_name_as'] = array(
            'label' => __('display name as', 'twchatlang'),
            'desc' => __('Select how you want to display the name of the account.', 'twchatlang'),
            'type' => 'select',
            'options' => array(
                'first_last' => __('First Last', 'twchatlang'),
                'last_first' => __('Last First', 'twchatlang'),
                'first' => __('Only First Name', 'twchatlang'),
                'last' => __('Only Last Name', 'twchatlang'),
                'nickname' => __('Nickname', 'twchatlang'),
            ),
            'required' => true,
            'default' => 'first_last',
            'priority' => '60',
        );
        return $fields;
    }

    /**
     * default fields of account whatsapp meta box
     * NOTE: 
     * first part of the function name is same as metabox id defined in initialize_metaboxes function
     * second part should be finished with _fields
     *
     * @param  mixed $columns
     * @return void
     */
    public function TWChat_account_whatsapp_fields($fields)
    {
        $fields['whatsapp_number'] = array(
            'label' => __('Whatsapp Number', 'twchatlang'),
            'desc' => __('Whatsapp Number with country code.', 'twchatlang'),
            'type' => 'text',
            'placeholder' => __('Ex: +18038475568', 'twchatlang'),
            'required' => false,
            'priority' => '10',
        );
        $fields['whatsapp_message'] = array(
            'label' => __('Whatsapp Message', 'twchatlang'),
            'type' => 'textarea',
            'placeholder' => __('Whatsapp Message', 'twchatlang'),
            'required' => false,
            'priority' => '20',
        );
        return $fields;
    }
    /**
     * Helper function to get profile images from the assets folder.
     *
     * @return array
     */
    public function get_default_profile_images()
    {
        $default_images = [
            'custom' => [
                'name'  => 'custom',
                'url'   => TWCHAT_ASSETS_URL . 'images/Upload-icon.png',
                'class' => 'TWChat-default-account-image TWChat-upload-image-icon',
            ],
        ];

        // Get all images from the default images folder in the plugin
        $image_files = glob(TWCHAT_INCLUDES_PATH . 'assets/images/account_default_images/*.png');
        // Order images by name
        natcasesort($image_files);

        // Add images to the array of default images
        foreach ($image_files as $image_file) {
            $imageName = basename($image_file, '.png');
            $default_images[] = [
                'name'  => $imageName,
                'url'   => TWCHAT_ASSETS_URL . "images/account_default_images/{$imageName}.png",
                'class' => 'TWChat-default-account-image',
            ];
        }

        return $default_images;
    }

    public function admin_enqueue_scripts()
    {
        twchat_load_scripts('js', 'twchat-custom-post-type', TWCHAT_ASSETS_URL . '/js/accounts_admin.js', array(), array('twchat_account'), TWCH_VERSION);
    }
}
