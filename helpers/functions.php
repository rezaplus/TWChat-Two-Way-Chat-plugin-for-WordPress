<?php
/**
 * general functions of the plugin
 * @package TWChat
 * @since 4.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * display svg element
 * 
 * @param string $address - address of the svg file
 * @param string $class - style class of the svg element
 * @param boolean $echo - echo or return the svg element
 * @return html
 */
if (!function_exists('TWChat_svg')){
    function TWChat_svg($address, $class = '', $echo = true){
        $svg = file_get_contents($address);
        $svg = str_replace('<svg', '<svg class="'.$class.'"', $svg);
        if($echo){
            echo $svg;
        }else{
            return $svg;
        }
    }
}

/**
 * console log for debugging
 * 
 * @param mixed $data
 * @return html
 */
if(!function_exists('twchat_console_log')){
    function twchat_console_log($data){
        // if WP_DEBUG is not set or is false return
        if(!defined('WP_DEBUG') || !WP_DEBUG){
            return;
        }
        // if $data is array or object
        if (is_array($data) || is_object($data)){
            echo '<script>';
            echo 'console.log('. json_encode($data) .')';
            echo '</script>';
        }else{ // else :D 
            echo '<script>';
            echo 'console.log("'.$data.'")';
            echo '</script>';
        }
    }
}