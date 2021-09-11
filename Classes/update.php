<?php
 TWCH_update::get_instance();
class TWCH_update{
    
    public $StableVersion_DB = '2.1';
    static $instance = null;
    
    private function __construct(){
        $PVersion = get_option('DTW_db_version');
        $check_version = $this->check_version($PVersion);
        if ($check_version=='less') {
            require_once  TWCH_DIR_path.'Classes/DBactions.php';
            if ($PVersion ==1.8) {
                $this->update_to_1_9();
            }
            if ($PVersion == 1.9) {
                $this->update_to_2();
            }
            if ($PVersion == 2) {
                $this->update_to_2_1();
            }
        } elseif ($check_version=='not set') {
            require_once  TWCH_DIR_path.'Classes/install.php';
            update_option('DTW_db_version', $this->StableVersion_DB);
        }
    }

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
    private function update_to_2_1()
    {
        //rename options key
        global $wpdb;
        $table_name = $wpdb->prefix . 'options';
        $options_name = $wpdb->get_results("SELECT option_name FROM $table_name where option_name LIKE 'DTWP%'");
        var_dump($options_name);
        foreach ($options_name as $option_Name) {
            $this->rename_option($option_Name->option_name, str_replace('DTWP', 'TWCH', $option_Name->option_name));
        }
        update_option('DTW_db_version', 2.1);
    }
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
                    if (strpos($key, 'DTW') !== false ) {
                        $key_new = str_replace('DTWP', 'TWCH', $key_new);
                        $key_new = str_replace('DTW', 'TWCH', $key_new);
                        $option_data[$key_new] = $value;
                        unset($option_data[$key]);
                    }
                    //rename array value
                    if (strpos($value, 'DTW') !== false ) {
                        $value = str_replace('DTWP', 'TWCH', $value);
                        $value = str_replace('DTW', 'TWCH', $value);
                        $option_data[$key_new] = $value;
                    }
                }
            }else{//rename value
                str_replace('DTWP','TWCHAT',$option_data);
                str_replace('DTW','TWCHAT',$option_data);
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