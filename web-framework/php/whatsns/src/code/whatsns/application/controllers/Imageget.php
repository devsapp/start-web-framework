<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Imageget extends CI_Controller {

	var $whitelist;
	function __construct() {
		$this->whitelist = "getid";
		parent::__construct ();

	}
	/**
	
	* 获取图片
	
	* @date: 2019年5月5日 上午10:50:39
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function getid($type,$id){
		switch ($type){
			case 'cat':
				echo get_cid_dir($id);
				break;
			case 'user':
				
				echo get_avatar_dir($id);
				break;
		}
		exit();
	}
	
}