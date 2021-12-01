<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Admin_jpush extends CI_Controller {

  	function __construct() {
		parent::__construct ();
        
    }
    function index($msg = ''){
    	$msg && $message = $msg;
    	include template('jpushindex', 'admin');
    }
    function sendmessage(){
    
   
    	$message=trim($_POST['sendmsg']);
    	if($message==""){
    		$this->index("推送消息不能为空");
    	}
    
    	jpushmsg($message,"1","您得问题有新回答",'https://www.ask2.cn/article-14878.html');
    
    	$this->index("推送成功");
    }

}
