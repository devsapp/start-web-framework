<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Admin_fankui extends ADMIN_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->model ( 'setting_model' );
	}
	/**
	 *
	 * 获取反馈问题列表
	 *
	 * @date: 2020年11月10日 下午3:35:56
	 *
	 * @author : 61703
	 *
	 * @param
	 *        	: variable
	 *
	 * @return :
	 *
	 *
	 */
	function questionlist() {
		$navtitle="我的反馈问题记录";
		$msg='';
		$token=getAccessToken();
		if(is_array($token)){
			$msg.=$token['msg'];
		}else{
			$result=curl_post(config_item("getquestionlist"),array('accesstoken'=>$token));
			$questionlist=null;
			
			if($result['code']==200){
				$questionlist=$result['data']['data'];
			}else{
				$result=json_decode($result,true);
				$msg=$result['msg'];
			}
		}
	
		include template ( 'fankuilist', 'admin' );
	}
	/**
	
	* 查看问题详情
	
	* @date: 2020年11月10日 下午4:25:32
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function view($onlyid){
		$navtitle="问题详情记录";
		$token=getAccessToken();
		$msg='';
		if(is_array($token)){
			$msg.=$token['msg'];
		}else{
			$result=curl_post(config_item("getquestiondetail"),array('accesstoken'=>$token,'onlyid'=>$onlyid));
			if($result['code']==201){
				$this->message('反馈问题不存在');
				exit();
			}
			$question=$result['data']['data'];
		}
	
		include template ( 'fankuidetail', 'admin' );
	}
}
