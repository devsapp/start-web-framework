<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

class curl_ssl {	
	
	public function curl_post($url = '', $post = array(), $type = 'post', $timeout = 30){

        $para_str = '';
        foreach ($post as $k => $v) {
            $para_str .= rawurlencode($k)."=".rawurlencode($v)."&";
        }

        $para_str = trim($para_str, '&');
		$url .= "?".$para_str;
		if(get_extension_funcs('curl')&&function_exists('curl_init')&&function_exists('curl_setopt')&&function_exists('curl_exec')&&function_exists('curl_close')){
			$curlHandle=curl_init(); 
			curl_setopt($curlHandle, CURLOPT_URL, $url); 
			if($type == 'post'){
				curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, "POST");  
				curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $post); 
			}else{
				curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, "GET");  
			}
			curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, FALSE);  
			curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, FALSE);  
			curl_setopt($curlHandle, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');  
			curl_setopt($curlHandle, CURLOPT_FOLLOWLOCATION, 1);  
			curl_setopt($curlHandle, CURLOPT_AUTOREFERER, 1);  
			 
			curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true); 
			$result=curl_exec($curlHandle); 
			curl_close($curlHandle); 
		} 
		$result=trim($result);
		return $result;
	}
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>