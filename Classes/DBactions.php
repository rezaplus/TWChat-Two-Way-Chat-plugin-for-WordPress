<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class TWCH_DBactions{
    
    static $instance = null;
    
    public function __construct(){
    
    }
    public static function Update($fields,$getEditId,$option_name,$url){
        if(empty($getEditId)){
            
            $id = $option_name.self::randNumber($option_name);
            $postData['id'] = $id;
            
            //insert to id list
            self::list_manage($id,$option_name.'list');
        }elseif(isset($getEditId)){
            $id = $getEditId;
            $fields['id'] = $getEditId;
            
            if(!empty($url))
                header('Location: '.$url);
        }
        update_option($id,$fields);
        
    }
  
    public static function randNumber($option_name){
        $rnd_id=mt_rand(100,999);
        $IDs_list = get_option($option_name.'list');
        if(!empty($IDs_list)){
            while(in_array($option_name.$rnd_id,$IDs_list)){
                $rnd_id=mt_rand(100,999);
            }
        }
        return $rnd_id;
    }
    public static function list_manage($id,$option_list_name){
    $IDs = array();
    $IDs_list = get_option($option_list_name);
        if(!empty($IDs_list)){
            $IDs = $IDs_list;
        }
        if(!in_array($id,$IDs)){
            array_push($IDs,$id);
            update_option($option_list_name,array_map( 'sanitize_text_field',$IDs));
        }
    }

    public static function Delete($ID,$option_name,$url){
        $url = esc_url_raw( $url );
        $ID = sanitize_text_field($ID);
        delete_option($ID);
        $content_list = get_option($option_name.'list');
        if (($key = array_search($ID, $content_list)) !== false) {
            unset($content_list[$key]);
        }
        update_option($option_name.'list', array_map( 'sanitize_text_field', $content_list ));

        if(!empty($url))
            header('Location:'.$url);
    }
}