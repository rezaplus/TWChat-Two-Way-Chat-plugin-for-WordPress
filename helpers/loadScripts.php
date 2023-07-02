<?php

/** 
 * load scripts with page condition and version control and dev mode
 * 
 * @since 4.0.0
 * @package TWChat
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * load scripts with page condition and version control and dev mode
 * 
 * @param string $type - type of the script (css or js)
 * @param string $handle - name of the script
 * @param string $src - address of the script
 * @param array $deps - dependencies of the script
 * @param array $pages - pages that the script should be loaded
 * @param string $version - version of the script
 * @param boolean $in_footer - load script in footer or header
 * @param array $args - arguments for localize script
 * @return void
 */
if (!function_exists('twchat_load_scripts')) {
    function twchat_load_scripts($type, $handle, $src, $deps = array(), $pages = array(), $version, $in_footer = true, $args = array())
    {
        if (function_exists('get_current_screen')) { // check if function exists - some pages don't have this function
            // if array is empty load scripts in all pages else load scripts in specific pages
            if (!empty($pages) && !in_array(get_current_screen()->id, $pages)) {
                return;
            }
        }

        /**
         * randomize version number to prevent cache issues in development mode
         * 
         * @since 4.0.0
         */
        if (defined('TWCH_DEV_MODE') && TWCH_DEV_MODE) {
            $src = add_query_arg('t', time(), $src);
        }

        /**
         * load css styles
         */
        if ($type == 'css') {
            wp_enqueue_style($handle, $src, $deps, $version);
        }

        /**
         * load js scripts and add localize script
         */
        if ($type == 'js') {
            wp_enqueue_script($handle, $src, $deps, $version, $in_footer);
            // add localize
            if (!empty($args)) {
                wp_localize_script($handle, 'TWCH', $args);
            }
        }
    }
}
