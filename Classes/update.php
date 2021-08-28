<?php
 DTWP_update::get_instance();
class DTWP_update{
    
    public $StableVersion_DB = '2';
    static $instance = null;
    
    public function __construct(){
        $PVersion = get_option('DTW_db_version');
        $check_version = $this->check_version($PVersion);
        if($check_version=='less'){
            require_once  DTWP_DIR_path.'Classes/DBactions.php';
            require_once  DTWP_DIR_path.'Classes/install.php';
            if($PVersion ==1.8){
                $this->update_to_1_9();
            }
            if($PVersion == 1.9){
                $this->update_to_2();
            }
        }elseif($check_version=='not set'){
            update_option('DTW_db_version',$this->StableVersion_DB);
        }
    }

    public function check_version($PVersion){
        if(!empty($PVersion)){
            if($PVersion < $this->StableVersion_DB){
                return 'less';
            }
        }else{
            return 'not set';
        }
    }
    
    public static function get_instance() {
    // If the single instance hasn't been set, set it now.
    if ( null == self::$instance ) {
        self::$instance = new self;
    }
    return self::$instance;
    }
    public function update_to_2(){
        //insert floatApplication input
        $general = get_option('DTWP_General_Option');
        $general['floatApplication'] = 'web';
        update_option('DTWP_General_Option',$general);
        
        //insert accounts default text input
        $Accounts = get_option('DTWP_Accounts_list');
        foreach($Accounts as $Account){
            $Account_data = get_option($Account);
            $Account_data['DefaultText']='';
            update_option($Account,$Account_data);
        }
        update_option('DTW_db_version',2);
    }
    public function update_to_1_9(){
        global $wpdb;
        $table_name = $wpdb->prefix . 'DTWhatsapptb';
        $QuickMessages = $wpdb->get_results("SELECT DTW_name,DTW_value FROM $table_name  WHERE DTW_use = 'QuickMessage'");
        if(!empty($QuickMessages)){
            foreach($QuickMessages as $value) {
                $data = array('DTW_Qmessage_Title'=>$value->DTW_name,'DTW_Qmessage_Message'=>$value->DTW_value);
                DTWP_DBactions::Update($data,'','DTWP_Qmessage_','');
                $wpdb->query( "DROP TABLE IF EXISTS $table_name" );
            }
            update_option('DTW_db_version',1.9);
        }
    }
    
    
    
}