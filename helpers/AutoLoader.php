<?php

/**
 * Load the classes of the plugin
 * @return Class object
 * @package TWChat
 */

namespace twchat\helpers;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }

use ReflectionClass;

class AutoLoader
{

    /**
     * instance of the class
     *
     * @var null
     */
    private static $instance = null;


    /**
     * set the addon name
     *
     * @var string
     */
    public $addon = null;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * get the instance of the class
     * 
     * @param  mixed $class - class object
     * @param  mixed $args - arguments to pass to the class
     * @param  string $where (admin|front|both) - default admin
     * 
     * Remember: When first class limited to admin, you can't change it to front in child class or vice versa
     *
     * @return object|false - return the object of the class or false
     */
    public static function getInstanceOf($class, $args = [], $where = 'both')
    {

        if (($where == 'admin' && !is_admin()) || ($where == 'front' && is_admin())) {
            return false;
        }

        if (class_exists($class)) {
            $reflector = new ReflectionClass($class);
            return $reflector->newInstanceArgs($args);
        }else{
            TWChat_notice(sprintf(__('Class %s not found. please contact the plugin developer.', 'twchatlang'), $class), 'error', false);
        }
    }


    /**
     * load the core classes of the plugin
     *
     * @return void
     */
    public function CoreAutoLoader()
    {
        spl_autoload_register(array($this, 'coreLoad'));
    }

    /**
     * load the addon classes of the plugin
     *
     * @param  mixed $addon
     * @return void
     */
    public function setAddonAutoLoader($addon)
    {
        $this->addon = $addon;
        spl_autoload_register(array($this, 'addonLoad'));
    }

    /**
     * set the external addon classes
     * 
     * @param  mixed $addon
     * @return void
     */
    public function setExternalAddonAutoLoader($addon)
    {
        $this->addon = $addon;
        spl_autoload_register(array($this, 'externalAddonLoad'));
    }

    /**
     * load the core classes of the plugin
     *
     * @param  mixed $className
     * @return void
     */
    public function coreLoad($className)
    {
        // remove the namespace from the class name
        $className = substr($className, strrpos($className, "\\") + 1);
        $path = TWCHAT_DIR_PATH . 'classes/' . $className . '.class.php';
        self::includeClass($path);
    }

    /**
     * load the addon classes of the plugin
     *
     * @param  mixed $className
     * @return void
     */
    public function addonLoad($className)
    {
        // remove the namespace from the class name
        $className = substr($className, strrpos($className, "\\") + 1);
        $path = TWCHAT_DIR_PATH . 'addons/' . $this->addon . '/classes/' . $className . '.class.php';
        self::includeClass($path);
    }

    /**
     * load the external addon classes of the plugin
     *
     * @param  mixed $className
     * @return void
     */
    public function externalAddonLoad($className)
    {
        // remove the namespace from the class name
        $className = substr($className, strrpos($className, "\\") + 1);
        // include from plugins directory
        $path = WP_PLUGIN_DIR . '/' . $this->addon . '/classes/' . $className . '.class.php';
        self::includeClass($path);
    }

    /**
     * include the class
     * 
     * @param  mixed $class
     * @return void
     */
    public function includeClass($path)
    {
        if (strpos($path, 'class') !== false && file_exists($path) && is_readable($path)) {
            include_once $path;
        }
    }


    /**
     * get the instance of the class
     *
     * @return object
     */
    public static function init()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // distroy the addon name
    public function __destruct()
    {
        $this->addon = null;
    }
}