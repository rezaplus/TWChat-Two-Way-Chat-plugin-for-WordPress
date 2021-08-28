<?php

if (!class_exists('DTWP_license')){
class DTWP_license
{
	static $check_url = 'http://guard.zhaket.com/api/';
	// Constructor of Zhaket_License class
	public	function	__construct()
	{
		
	}
	//-------------------------------------------------
	// This method sends GET request to specific url and returns the result
	public	static	function	sendRequest($method,$params=array())
	{
		$param_string = http_build_query($params);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, 
			self::$check_url.$method.'?'.$param_string
		);
		$content = curl_exec($ch);
		return json_decode($content);
	}
	//-------------------------------------------------
	public	static	function	isValid($license_token)
	{
		$result = self::sendRequest('validation-license',array('token'=>$license_token,'domain'=>self::getHost()));
		return $result;
	}
	//-------------------------------------------------
	public	static	function	install($license_token)
	{
		
		$result = self::sendRequest('install-license',array('product_token'=>'90f84ecf-4fce-4c5b-9b5a-6628e75a77d7','token'=>$license_token,'domain'=>self::getHost()));
		return $result;
	}
	//-------------------------------------------------
	public static function getHost() {
		$possibleHostSources = array('HTTP_X_FORWARDED_HOST', 'HTTP_HOST', 'SERVER_NAME', 'SERVER_ADDR');
		$sourceTransformations = array(
			"HTTP_X_FORWARDED_HOST" => function($value) {
				$elements = explode(',', $value);
				return trim(end($elements));
			}
		);
		$host = '';
		foreach ($possibleHostSources as $source)
		{
			if (!empty($host)) break;
			if (empty($_SERVER[$source])) continue;
			$host = $_SERVER[$source];
			if (array_key_exists($source, $sourceTransformations))
			{
				$host = $sourceTransformations[$source]($host);
			} 
		}

		// Remove port number from host
		$host = preg_replace('/:\d+$/', '', $host);
		// remove www from host
		$host = str_ireplace('www.', '', $host);
		
		return trim($host);
	}
    
    public static function isValid_S(){
        $key = get_option('DTWP_license')['key'];
        $result = '';
        if(!empty($key)){
            $result = self::isValid($key);
            if($result->status =='error')
                self::Deactive_DL();
        }
        return $result;
    }
    
    public static function deactivate(){
        self::Deactive_DL($licenseKey);
    }
    
    public static function activate($licenseKey){
        $result = self::install($licenseKey);
        if($result->status =='successful'){
            self::Activate_DL($licenseKey);
            return $result;
        }else if($result->status =='error'){
            self::Deactive_DL();
            return $result;
        }
    }
    public static function Activate_DL($licenseKey){
        update_option('DTWP_license',array('status'=>'active','key'=>$licenseKey));
        if(!empty(get_option('gen_setgs_temp_d2w2p'))){
            update_option('DTWP_General_Option',get_option('gen_setgs_temp_d2w2p'));
        }else{
            update_option('DTWP_General_Option',Array
                (
                    'float_is_enable' => '',
                    'Applicationmode' => 'app' ,
                    'fix_countrycode' => '',
                    'wc_is_enable' => '',
                    'qmessage_is_enable' => ''
                ));
        }
        update_option('gen_setgs_temp_d2w2p','');
    }
    public static function Deactive_DL(){
        update_option('DTWP_license',array('status'=>'deactive','key'=>''));
        update_option('gen_setgs_temp_d2w2p',get_option('DTWP_General_Option'));
        update_option('DTWP_General_Option',Array
            (
                'float_is_enable' => '',
                'Applicationmode' => 'app' ,
                'fix_countrycode' => '',
                'wc_is_enable' => '',
                'qmessage_is_enable' => ''
            ));
    }
}}
?>