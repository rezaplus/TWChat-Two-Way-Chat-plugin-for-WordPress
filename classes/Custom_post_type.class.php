<?php
/**
 * The Custom_post_type class of the TWChat plugin
 * Manage custom post types for the TWChat plugin
 * manage meta boxes and meta fields
 * 
 * extend this class to create custom post types
 * 
 * @package TWChat
 * @since 1.0.0
 */

namespace twchat\classes;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

use twchat\helpers\AutoLoader;
use twchat\classes\Metabox_callback;

class Custom_post_type
{
    /**
     * The post type slug
     *
     * @var string
     */
    public $post_type;
    /**
     * An array of meta boxes
     *
     * @var array
     */
    public $meta_boxes = array();
    /**
     * An instance of the Metabox_callback class
     *
     * @var Metabox_callback
     */
    public $Metabox_callback;

    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * Set the post type for the custom post type
     * This should be called before the init action hook
     *
     * @param string $post_type The post type slug
     */
    public function set_post_type($post_type)
    {
        $this->post_type = $post_type;
    }

    /**
     * Set the meta boxes for the custom post type
     * This should be called before the init action hook
     *
     * @param array $meta_boxes An array of meta boxes
     */
    public function set_meta_boxes($meta_boxes)
    {
        $this->meta_boxes = $meta_boxes;
    }

    /**
     * Add meta boxes for selected post type
     * All meta boxes are added to the same post type as defined in the set_post_type method
     */
    public function add_meta_boxes()
    {
        /**
         * An instance of the Metabox_callback class
         * this is used to generate the meta fields for the meta boxes
         * @see Metabox_callback
         * @var Metabox_callback
         */
        $this->Metabox_callback = AutoLoader::init()->getInstanceOf(Metabox_callback::class, [], 'admin');

        /**
         * Add meta boxes
         */
        add_action('admin_enqueue_scripts', array($this, 'include_css'));

        // loop through meta boxes and add them to the post type edit page
        foreach ($this->meta_boxes as $meta_box) {
            add_meta_box(
                $meta_box[0], // Meta box ID
                $meta_box[1], // Title
                array($this, 'meta_box_callback'), // Callback function
                $this->post_type, // Post type
                $meta_box[2], // Context
                $meta_box[3], // Priority
                array('meta_box' => $meta_box[0]) // Additional arguments
            );
        }
    }

    /**
     * Callback function for displaying the meta box.
     *
     * @param WP_Post $post The current post object.
     * @param array   $args Additional arguments passed to the callback.
     */
    public function meta_box_callback($post, $args)
    {
        // get meta box ID
        $meta_box = isset($args['args']['meta_box']) ? $args['args']['meta_box'] : '';
        if (empty($meta_box)) {
            return; // Exit early if meta box is not defined
        }

        $data = get_post_meta($post->ID, $meta_box, true);
        wp_nonce_field($meta_box, $meta_box . '_nonce');

        /**
         * get meta box fields
         * set meta box fields using filter when registering meta box
         * first part of filter name is the meta box ID
         * last part of filter name is _fields
         * 
         * @see twchat\classes\Metabox_callback
         * @var array
         */
        $fields = apply_filters($meta_box . '_fields', array());

        // loop through meta box fields and generate the html
        foreach ($fields as $key => $field) {
            $value = isset($data[$key]) ? $data[$key] : ''; // get current post meta data's value
            /**
             * Generate html for meta box field using Metabox_callback class
             * @see twchat\classes\Metabox_callback
             * @return string html
             */
            echo $this->Metabox_callback->get_field_html($meta_box, $field, $key, $value); // generate html for meta box field
        }
    }

    /**
     * Save meta box data when the post is saved
     *
     * @param int $post_id The ID of the post being saved
     */
    public function save_meta_boxes($post_id)
    {
        // loop through meta boxes and save the meta box data
        foreach ($this->meta_boxes as $meta_box) {
            // verify nonce
            if (!isset($_POST[$meta_box[0] . '_nonce']) && !wp_verify_nonce($_POST[$meta_box[0] . '_nonce'], $meta_box[0])) {
                continue;
            }
            // check autosave
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                continue;
            }
            // check permissions
            if (!current_user_can('edit_post', $post_id)) {
                continue;
            }
            $meta_box_data = isset($_POST[$meta_box[0]]) ? $_POST[$meta_box[0]] : array();
            // save meta box data as post meta
            update_post_meta($post_id, $meta_box[0], $meta_box_data);
        }
    }

    /**
     * Include CSS files
     */
    public function include_css()
    {
        twchat_load_scripts('css', 'twchat-custom-post-type', TWCHAT_ASSETS_URL . '/css/twchat_custom_post_style.css', array(), array(), TWCH_VERSION);
    }
}
