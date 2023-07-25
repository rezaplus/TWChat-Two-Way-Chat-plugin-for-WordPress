<?php

/**
 * Add-ons controller class
 * load activated add-ons
 * This class show add-ons page in wordpress admin menu
 * Handle add-ons actions like activate, deactivate
 * 
 * @package TWChat
 * @since 4.0.0
 */

namespace twchat\classes;

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class Addon_controller
{
    /**
     * Add-ons page name
     * @var string
     */
    public $addonsPage = 'TWChat_addons';

    /**
     * Add-ons api url
     * @var string
     */
    private $addonsApiUrl = 'https://hooks.rellaco.com/hook/addons/v1/?plugin=twchat';

    /**
     * Installed add-ons list who installed in wordpress as plugin or located in twchat add-ons folder
     * @var array
     */
    public $installed_addons = array();
    /**
     * activated add-ons list who activated in wordpress as plugin or located in twchat add-ons folder
     * @var array
     */
    public $activated_addons = array();

    /**
     * constructor of addons class
     * 
     * @var void
     */
    public function __construct()
    {
        $this->get_installed_addons(); // get installed add-ons
        $this->get_activated_addons(); // get activated add-ons
        $this->load_activated_addons(); // load local activated add-ons
        add_action('plugins_loaded', array($this, 'load_addons_ls'), 10);
        add_action('admin_menu', array($this, 'add_addons_page'), 10); // register addons page
        add_action('admin_enqueue_scripts', array($this, 'load_scripts')); // load scripts and styles
    }

    /**
     * load activated add-ons
     * NOTE:
     * Add-ons main file name is same as add-on folder name.
     * Add-ons main file must be located in add-on folder.
     * 
     * this function load only local and activated add-ons. as a result, external add-ons not loaded here.
     * external add-ons loaded in own plugin file.
     * 
     * @var void
     */
    public function load_activated_addons()
    {
        foreach ($this->activated_addons as $addon) {
            $addon_path = TWCHAT_ADDONS_PATH . $addon . '/' . $addon . '.php';
            if (file_exists($addon_path) && is_readable($addon_path)) {
                include_once $addon_path;
            }
        }
    }

    /**
     * Register add-ons page in wordpress admin menu
     * 
     * @var void
     */
    public function add_addons_page()
    {
        add_submenu_page(
            'twchat',
            __('Add-ons', 'twchatlang'),
            __('Add-ons', 'twchatlang'),
            'manage_options',
            $this->addonsPage,
            array($this, 'displayAddonsPage'),
            20,
        );
    }



    /**
     * add-ons page callback function - display add-ons page
     * 
     * @var html
     */
    public function displayAddonsPage()
    {
        $action = $this->handleAddonActions(); // get action from url - thid variable is used in addons.php template
        $addons = $this->generateAddonsDetails($this->getAddons_from_API_OR_DB());

        include_once TWCHAT_TEMPLATES_PATH . 'admin/addons.php';
        if (empty($addons)) {
            TWChat_notice(__('Something went wrong. Please try again later. if problem persists, contact support.', 'twchatlang'), 'error', false, array('text' => __('Support', 'twchatlang'), 'url' => 'https://rellaco.com/support/', 'target' => '_blank'));
        }
    }

    /**
     * Get add-ons list from api or database if exists
     * 
     * @var void
     */
    public function getAddons_from_API_OR_DB()
    {
        // get addons list from database
        $addons = get_option('twchat_addons_list');
        // if addons list exists in database and not expired, get addons list from database
        if (isset($addons['addons']) && isset($addons['expired_date']) && $addons['expired_date'] > date('Y-m-d H:i:s') && TWCH_DEV_MODE == false) {
            $result = $addons;
        } else { // if addons list not exists in database or expired, get addons list from api
            $result = $this->fetchAddonsDetailsFromAPI();
            if (isset($result['addons'])) { // save addons list in database if exists
                update_option('twchat_addons_list', $result);
            }
        }
        return isset($result['addons']) ? $result['addons'] : array();
    }

    /**
     * Get installed add-ons list from wordpress plugins folder and twchat add-ons folder
     * 
     * @var array
     */
    public function get_installed_addons()
    {
        $internalAddonsDir = TWCHAT_ADDONS_PATH;

        if (!is_dir($internalAddonsDir) || !is_readable($internalAddonsDir)) {
            // Add appropriate error handling or logging here
            return false;
        }

        // Get internal add-ons - add-ons installed as part of TWChat
        $internalAddons = scandir($internalAddonsDir);

        // Remove . and ..
        $internalAddons = array_diff($internalAddons, ['.', '..']);

        // Get external add-ons - add-ons installed as plugins
        $externalAddons = $this->get_external_addons();
        $externalAddonNames = array_map(function ($addon) {
            return basename($addon, '.php');
        }, array_keys($externalAddons));

        // Merge internal and external add-ons
        $installedAddons = array_merge($internalAddons, $externalAddonNames);

        // Reorganize the array
        $installedAddons = array_values($installedAddons);

        $this->installed_addons = $installedAddons;

        return $installedAddons;
    }


    /**
     * Handle addon actions and return the result
     *
     * @return mixed|false The result of the action or false if no action is performed
     */
    public function handleAddonActions()
    {
        $result = false;

        if (isset($_GET['twchat_activate_addon'])) {
            $result = $this->activate_addon($_GET['twchat_activate_addon']);
        }
        if (isset($_GET['twchat_deactivate_addon'])) {
            $result = $this->deactivate_addon($_GET['twchat_deactivate_addon']);
        }

        // Remove action from URL without reloading the page
        if (isset($_GET['reload']) && $_GET['reload'] === 'true' && isset($_GET['result'])) {
            $this->notice_action_result($_GET['result']);
            $url = remove_query_arg(
                ['reload', 'result', 'twchat_activate_addon', 'twchat_deactivate_addon']
            );
            echo "<script>history.replaceState({}, '', '$url');</script>";
        } elseif (isset($result)) {
            wp_redirect(admin_url('admin.php?page=' . $this->addonsPage . '&reload=true&result=' . $result));
            exit;
        }

        return $result;
    }


    /**
     * Notice result of action in add-ons page
     *
     * @param string $result
     * @return void
     */
    public function notice_action_result($result)
    {
        switch ($result) {
            case 'activated':
                $message = __('Add-on activated successfully.', 'twchatlang');
                $type = 'success';
                break;
            case 'deactivated':
                $message = __('Add-on deactivated successfully.', 'twchatlang');
                $type = 'success';
                break;
            case 'not_installed':
                $message = __('Add-on not installed.', 'twchatlang');
                $type = 'error';
                break;
            case 'already_activated':
                $message = __('Add-on already activated.', 'twchatlang');
                $type = 'warning';
                break;
            case 'already_deactivated':
                $message = __('Add-on already deactivated.', 'twchatlang');
                $type = 'warning';
                break;
            case 'not_found':
                $message = __('Add-on not found.', 'twchatlang');
                $type = 'error';
                break;
            case 'error':
                $message = __('Error, Please try again later.', 'twchatlang');
                $type = 'error';
                break;
            default:
                $message = '';
                $type = '';
                break;
        }
        if (!empty($message)) {
            TWChat_notice($message, $type);
        }
    }


    /**
     * get list of activated addons from database 
     * 
     */
    public function get_activated_addons()
    {
        $this->activated_addons = get_option('twchat_activated_addons', array());
    }

    /**
     * check addon activation status 
     * 
     * @param string $addon
     * @return boolean true if addon is activated, false if not activated
     */
    public function is_activated($addon)
    {
        return in_array($addon, $this->activated_addons) ? true : false;
    }

    /**
     * check addon installation status 
     * 
     * @param string $addon
     * @return boolean true if addon is installed, false if not installed
     */
    public function is_installed($addon)
    {
        // check if add-on exists
        return in_array($addon, $this->installed_addons) ? true : false;
    }

    /**
     * Generate addons details array from api response
     *
     * @param array $addons_list The list of addons
     * @return array The addons list with button details added
     */
    public function generateAddonsDetails($addons_list)
    {
        // If addons list is empty, return an empty array
        if (empty($addons_list)) {
            return [];
        }

        foreach ($addons_list as $key => $addon) {
            $is_installed = $this->is_installed($key);
            $is_activated = $this->is_activated($key);
            $button_details = $this->prepareAddonButtonData($is_installed, $is_activated, $key, $addon);

            $addons_list[$key]['button'] = [
                'text' => $button_details['text'],
                'class' => $button_details['class'],
                'link' => $button_details['link'],
                'target' => $button_details['target'],
                'PriceDetails' => $button_details['PriceDetails'],
            ];

            $addons_list[$key]['infoButton'] = [
                'text' => __('More Details', 'twchatlang'),
                'link' => $addon['Doc'],
            ];

            $addons_list[$key]['PriceDetails'] = '';

            if (strtolower($addon['PricingModel']) == 'paid' && $this->is_installed($key)) {
                $ls_status = $this->get_ls_data($key, 'status');
                if ($ls_status) {
                    $addons_list[$key]['ls'] = [
                        'status' => $ls_status == 'active' ? __('Active', 'twchatlang') : __('Please activate your license key.', 'twchatlang'),
                        'link' => admin_url('admin.php?page=' . $key . '&referral=' . $this->addonsPage),
                        'color' => $ls_status == 'active' ? 'green' : '#e40003',
                    ];
                } else {
                    $addons_list[$key]['ls'] = [
                        'status' => __('Please activate your license key.', 'twchatlang'),
                        'link' => admin_url('admin.php?page=' . $key . '&referral=' . $this->addonsPage),
                        'color' => '#e40003',
                    ];
                }
            }
        }

        return $addons_list;
    }



    /**
     * Prepare the data for the add-on button.
     *
     * @param bool   $isInstalled   Whether the add-on is installed in WordPress or TWChat.
     * @param bool   $isActivated   Whether the add-on is activated in WordPress.
     * @param string $key           The add-on key.
     * @param array  $addon         The add-on details.
     *
     * @return array The add-on button details.
     */
    public function prepareAddonButtonData($isInstalled, $isActivated, $key, $addon = array())
    {
        if ($isInstalled) {
            if ($addon['Type'] == 'External' && !is_plugin_active($key . '/' . $key . '.php')) {
                // External add-on not activated in WordPress
                $text = __('Activate in WordPress', 'twchatlang');
                $class = 'button button-primary';
                $link = admin_url('plugins.php/?s=TWChat');
                $target = '_self';
                $priceDetails = $addon['PricingModel'] == 'Free' ? 'Free Add-on' : __('Paid Add-on', 'twchatlang');
            } else {
                if ($isActivated) {
                    // Add-on installed and activated in WordPress
                    $text = __('Deactivate', 'twchatlang');
                    $class = 'button button-secondary';
                    $link = "?page=$this->addonsPage&twchat_deactivate_addon=" . $key;
                    $target = '_self';
                    $priceDetails = $addon['PricingModel'] == 'Free' ? 'Free Add-on' : __('Paid Add-on', 'twchatlang');
                } else {
                    // Add-on installed but not activated in TWChat
                    $text = __('Activate', 'twchatlang');
                    $class = 'button button-primary';
                    $link = "?page=$this->addonsPage&twchat_activate_addon=" . $key;
                    $target = '_self';
                    $priceDetails = $addon['PricingModel'] == 'Free' ? 'Free Add-on' : __('Paid Add-on', 'twchatlang');
                }
            }
        } else {
            // Add-on not installed in WordPress or TWChat
            if ($addon['PricingModel'] == 'Free') {
                // Free add-on
                $text = __('Download', 'twchatlang');
                $class = 'button button-primary';
                $link = $addon['Url'];
                $target = '_blank';
                $priceDetails = 'Free Add-on';
            } else {
                // Paid add-on
                $text = __('Purchase & Install', 'twchatlang');
                $class = 'button button-primary';
                $link = $addon['Url'];
                $target = '_blank';
                $priceDetails = __('Paid Add-on', 'twchatlang');
            }
        }

        return array(
            'text' => $text,
            'class' => $class,
            'link' => $link,
            'target' => $target,
            'PriceDetails' => $priceDetails,
        );
    }



    /**
     * Request the add-ons list from the API.
     *
     * @return array The add-ons list.
     */
    public function fetchAddonsDetailsFromAPI()
    {
        $bearer = 'Bearer ' . 'YOUR_BEARER_TOKEN';

        // Prepare the headers for the API request
        $headers = array(
            'Authorization' => $bearer,
        );

        // Send a GET request to the add-ons API
        $response = wp_remote_get($this->addonsApiUrl, array(
            'headers' => $headers,
        ));

        // Check if the API request encountered an error
        if (is_wp_error($response)) {
            // Error occurred, return an empty array
            return array();
        }

        // Check if the API response is successful (status code 200)
        if ($response['response']['code'] !== 200) {
            // Error occurred, return an empty array
            return array();
        }

        // Parse the response body as JSON
        $addons_list = json_decode($response['body'], true);

        return $addons_list;
    }

    /**
     * Get TWChat external addons from the installed plugins
     *
     * @return array The list of TWChat external addons
     */
    public function get_external_addons()
    {
        // Check if the 'get_plugins' function exists, require plugin.php if not
        if (!function_exists('get_plugins')) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        $twchat_plugins = array(); // Initialize an empty array for TWChat addons
        $plugins = get_plugins(); // Get all installed plugins

        // Loop through each installed plugin and filter out TWChat addons
        foreach ($plugins as $key => $plugin) {
            if (strpos($key, 'twchat_addon_') !== false) {
                $twchat_plugins[$key] = $plugin;
            }
        }

        return $twchat_plugins; // Return the list of TWChat external addons
    }


    /**
     * Activate an addon
     *
     * @param string $addon The addon to activate
     * @return string The activation result
     */
    public function activate_addon($addon)
    {
        if (!in_array($addon, $this->installed_addons)) {
            return 'not_installed'; // Addon is not installed
        }
        if (in_array($addon, $this->activated_addons)) {
            return 'already_activated'; // Addon is already activated
        }
        
        if ($this->checkRequirements($addon, true) !== true) {
            return; // Addon requirements are not met
        }

        $this->lsHandler($addon);


        // Activate the addon
        $this->activated_addons[] = $addon;

        // Update the activated addons list
        update_option('twchat_activated_addons', $this->activated_addons);

        return 'activated'; // Addon activated successfully
    }

    /**
     * Deactivate an addon
     *
     * @param string $addon The addon to deactivate
     * @return string The deactivation result
     */
    public function deactivate_addon($addon)
    {
        if (!in_array($addon, $this->installed_addons)) {
            return 'not_installed'; // Addon is not installed
        }
        if (!in_array($addon, $this->activated_addons)) {
            return 'already_deactivated'; // Addon is already deactivated
        }

        // Deactivate the addon
        $this->activated_addons = array_diff($this->activated_addons, array($addon));

        // Update the activated addons list
        update_option('twchat_activated_addons', $this->activated_addons);

        return 'deactivated'; // Addon deactivated successfully
    }

    // get addons data
    public function get_addons_data()
    {
        $addons_data = get_option('twchat_addons_list');
        if (!$addons_data) {
            return false;
        }
        return $addons_data;
    }

    // get ls data
    public function get_ls_data($addon, $key = false)
    {
        $ls_data = get_option($addon . '_ls_data');

        if (!$ls_data) {
            return false;
        }

        if (!$key) {
            return $ls_data;
        }

        if (isset($ls_data[$key])) {
            return $ls_data[$key];
        }

        return false;
    }

    /**
     * Check the addon requirements
     *
     * @param string $addon The addon to check
     * @param bool $checkVersion Whether to check the addon version or not
     * @return bool Whether the requirements are met or not
     */
    public function checkRequirements($addon, $checkVersion = false)
    {
        // Get addon data
        $addonData = $this->get_addons_data();

        if (!$addonData) {
            twchat_notice(__('Something went wrong, please try again later.', 'twchatlang'), 'error');
            exit;
        }

        // Get addon requirements
        $requiredPlugins = $addonData['addons'][$addon]['requires'] ?? false;

        $passed = true;

        // Check if required plugins are active
        if ($requiredPlugins) {
            foreach ($requiredPlugins as $plugin => $version) {
                // If plugin has '/', it's an internal addon
                if (strpos($plugin, '/')) {
                    // Get addon name
                    $internalAddon = explode('/', $plugin)[1];

                    // Check if the addon is active
                    if (!in_array($internalAddon, $this->activated_addons)) {
                        twchat_notice(sprintf(__('%s add-on is required to activate this add-on. Please activate it first.', 'twchatlang'), $internalAddon), 'error');
                        $passed = false;
                    }

                    // If version is set, check if the version is compatible
                    if (isset($version) && $checkVersion) {
                        $installedVersion = get_plugin_data(TWCHAT_ADDONS_PATH . $internalAddon . '/' . $internalAddon . '.php')['Version'];
                        // die(var_dump(version_compare($installedVersion, $version, '<=')).' '.$installedVersion.' '.$version);
                        if (version_compare($installedVersion, $version, '<=')) {
                            twchat_notice(sprintf(__('%s add-on version %s or higher is required to activate this add-on. Please update it first.', 'twchatlang'), $internalAddon, $version), 'error');
                            $passed = false;
                        }
                    }

                    continue;
                }

                // Check if plugin is active
                if (!is_plugin_active($plugin . '/' . $plugin . '.php')) {
                    twchat_notice(sprintf(__('%s plugin is required to activate this add-on. Please install and activate it first.', 'twchatlang'), $plugin), 'error');
                    $passed = false;
                    continue;
                }

                // If version is set, check if the version is compatible
                if (isset($version) && $checkVersion) {
                    $installedVersion = get_plugin_data(WP_PLUGIN_DIR . '/' . $plugin . '/' . $plugin . '.php')['Version'];
                    if (version_compare($installedVersion, $version, '<=')) {
                        twchat_notice(sprintf(__('%s plugin version %s or higher is required to activate this add-on. Please update it first.', 'twchatlang'), $plugin, $version), 'error');
                        $passed = false;
                    }
                }
            }
        }

        return $passed;
    }


    /**
     * ls handler
     * 
     * @param string $addon The addon to handle
     * 
     */
    public function lsHandler($addon)
    {
        // get addon data
        $addon_data = $this->get_addons_data();
        $ls_data = $this->get_ls_data($addon, 'status');
        if (!$addon_data) {
            twchat_notice(__('Something went wrong, please try again later.', 'twchatlang'), 'error');
            exit;
        }

        foreach ($addon_data['addons'] as $key => $value) {
            if ($key == $addon) {
                if (isset($value['PricingModel'])) {
                    if (strtolower($value['PricingModel']) != 'paid') {
                        return;
                    }
                } else {
                    return;
                }
            }
        }

        if (!$ls_data || $ls_data != 'active') {
            wp_redirect(admin_url('admin.php?page=' . $_GET['twchat_activate_addon'] . '&referral=' . $this->addonsPage));
            exit;
        }
    }

    /**
     * load addon ls
     * 
     * @var void
     */
    public function load_addons_ls()
    {
        $addons = $this->get_addons_data();
        if (!$addons) {
            return;
        }

        foreach ($addons['addons'] as $key => $value) {
            if (isset($value['PricingModel'])) {
                if (strtolower($value['PricingModel']) == 'paid') {
                    $ls_data = $this->get_ls_data($key, 'status');
                    // check if addon is not active
                    if (!$ls_data || $ls_data != 'active') {
                        if (in_array($key, $this->activated_addons)) {
                            $this->deactivate_addon($key);
                        }
                    }
                    // load addon ls
                    $addon_path = WP_PLUGIN_DIR . '/' . $key . '/includes/addon.php';
                    if (file_exists($addon_path) && is_readable($addon_path)) {
                        include_once $addon_path;
                    }
                }
            }
        }
    }


    /**
     * Load style for addons panel by twchat_load_scripts helper function
     * @return void
     */
    public function load_scripts()
    {
        // Load CSS
        twchat_load_scripts(
            'css', // Type: CSS
            'twchat-addons-panel', // Handle for the stylesheet
            TWCHAT_ASSETS_URL . '/css/twchat_addons_panel.css', // URL to the CSS file
            array(),
            array('twchat_page_TWChat_addons'),
            TWCH_VERSION // Version number of the TWChat plugin
        );
    }
}
