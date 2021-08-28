<?php
class DTWP_DBactions{
    
    static $instance = null;
    
    public function __construct(){
    
    }
    public static function Update($postData,$getData,$option_name,$url){
        unset($postData['submit']);
        if(!isset($getData['Edit'])){
            $id = $option_name.self::randNumber($option_name);
            $postData['id'] = $id;
            
            //insert to id list
            self::list_manage($id,$option_name.'list');
        }elseif(isset($getData['Edit'])){
            $id = $getData['Edit'];
            $postData['id'] = $getData['Edit'];
            
            if(!empty($url))
                header('Location: '.$url);
        }
        update_option($id,array_map( 'sanitize_textarea_field', $postData ));
        
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

    public static function Delete($getData,$option_name,$url){
        delete_option($getData['Delete']);
        $content_list = get_option($option_name.'list');
        if (($key = array_search($getData['Delete'], $content_list)) !== false) {
            unset($content_list[$key]);
        }
        update_option($option_name.'list', array_map( 'sanitize_text_field', $content_list ));
        header('Location: '.$url);
    }
}