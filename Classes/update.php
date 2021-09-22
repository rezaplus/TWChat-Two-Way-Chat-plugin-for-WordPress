<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
TWCH_update::get_instance();
class TWCH_update{
    //DB stable version
    public $StableVersion_DB = '2.1';
    static $instance = null;
    
    private function __construct(){
        //get current version on db.
        $PVersion = get_option('DTW_db_version');
        //check version
        $check_version = $this->check_version($PVersion);
        // If db is not up to date, it will start updating
        if ($check_version=='less') {
            //include db actions.
            require_once  TWCH_DIR_path.'Classes/DBactions.php';
            //is temp varible
            $v = $PVersion;
            for ($v ; $v <= $this->StableVersion_DB - 0.1  ; $v = $v + 0.1) {
                $v = strval($v);
                if ($v == 1.8) {
                    $this->update_to_1_9();
                }
                if ($v == 1.9) {
                    $this->update_to_2();
                }
                if ($v == 2) {
                    $this->update_to_2_1();
                }
            }
        //else if the plugin is installed for the first time. The current version of the database is saved.
        } elseif ($check_version=='not set') {
            require_once  TWCH_DIR_path.'Classes/install.php';
            update_option('DTW_db_version', $this->StableVersion_DB);
        }
    }
    /**
     * Checks the status of the database version.
     *
     * @param [int] $PVersion
     * @return database status
     */
    private function check_version($PVersion){
        if (!empty($PVersion)) {
            if ($PVersion < $this->StableVersion_DB) {
                return 'less';
            }
        } else {
            return 'not set';
        }
    }
    
    public static function get_instance() {
        // If the single instance hasn't been set, set it now.
        if (null == self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }
    /**
     * rename plugin
     *
     * @return void
     */
    private function update_to_2_1()
    {
        //rename options key
        global $wpdb;
        $table_name = $wpdb->prefix . 'options';
        $options_name = $wpdb->get_results("SELECT option_name FROM $table_name where option_name LIKE 'DTWP%'");
        foreach ($options_name as $option_Name) {
            $this->rename_option($option_Name->option_name, str_replace('DTWP', 'TWCH', $option_Name->option_name));
        }
        update_option('DTW_db_version', 2.1);
    }
    /**
     * set new fields
     *
     * @return void
     */
    private function update_to_2(){
        //insert floatApplication input
        $general = get_option('DTWP_General_Option');
        $general['floatApplication'] = 'web';
        update_option('TWCH_General_Option', $general);
        
        //insert accounts default text input
        $Accounts = get_option('DTWP_Accounts_list');
        foreach ($Accounts as $Account) {
            $Account_data = get_option($Account);
            $Account_data['DefaultText']='';
            update_option($Account, $Account_data);
        }
        update_option('DTW_db_version', 2);
    }
    /**
     * import Quick messages to new version
     *
     * @return void
     */
    private function update_to_1_9(){
        global $wpdb;
        $table_name = $wpdb->prefix . 'DTWhatsapptb';
        $QuickMessages = $wpdb->get_results("SELECT DTW_name,DTW_value FROM $table_name  WHERE DTW_use = 'QuickMessage'");
        if (!empty($QuickMessages)) {
            foreach ($QuickMessages as $value) {
                $data = array('TWCH_Qmessage_Title'=>$value->DTW_name,'TWCH_Qmessage_Message'=>$value->DTW_value);
                TWCH_DBactions::Update($data, '', 'TWCH_Qmessage_', '');
                $wpdb->query("DROP TABLE IF EXISTS $table_name");
            }
            update_option('DTW_db_version', 1.9);
        }
    }

    /**
     * rename option key
     * for update 2.1
     * 
     * @param [String] $oldName
     * @param [String] $newName
     * @return status
     */
    private function rename_option($oldName,$newName){
        $status = false;
        $option_data = get_option($oldName);

        // rename option content
        if (!empty($option_data)) {
            //rename array contents
            if (is_array($option_data)) {
                foreach ($option_data as $key => $value) {
                    //rename array key
                    $key_new = $key;
                    if (stripos($key, 'DTW') !== false ) {
                        $key_new = str_ireplace('DTWP', 'TWCH', $key_new);
                        $key_new = str_ireplace('DTW', 'TWCH', $key_new);
                        $option_data[$key_new] = $value;
                        unset($option_data[$key]);
                    }
                    //rename array value
                    if (stripos($value, 'DTW') !== false ) {
                        //rename image link directory
                        if($key_new == 'img-ACS'){
                            $value = str_ireplace('DTWhatsapp', 'TWCHat', $value);
                        }
                        //rename value
                        $value = str_ireplace('DTWP', 'TWCH', $value);
                        $value = str_ireplace('DTW', 'TWCH', $value);
                        $option_data[$key_new] = $value;
                    }
                }
            }else{//rename value
                str_ireplace('DTWP','TWCHAT',$option_data);
                str_ireplace('DTW','TWCHAT',$option_data);
            }

            //rename option name
            $status = update_option($newName, $option_data);
            if ($status) {
                //delete old option
                delete_option($oldName);
            }
        }
        return $status;
    }
}
