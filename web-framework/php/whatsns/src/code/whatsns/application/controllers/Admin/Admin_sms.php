<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Admin_sms extends ADMIN_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->model ( 'setting_model' );
	}
	function index() {
		if (null !== $this->input->post ( 'submit' )) {
			checkattack ( $_POST, 'post' );
			foreach ( $_POST as $key => $value ) {
				if ('aliyunsms' == substr ( $key, 0, 9 )) {
					$this->setting [$key] = $value;
				}
			}
			
			$this->setting_model->update ( $this->setting );
			$message = '阿里云短信设置更新成功！';
		}
		include template ( "setting_sms", "admin" );
	}
	/**
	
	* 短信平台配置和启用短信配置
	
	* @date: 2019年8月2日 下午12:58:58
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function set(){
		if (null !== $this->input->post ( 'submit' )) {
			checkattack ( $_POST, 'post' );
	
			if ($this->input->post ( 'smscanuse' ) == 'on') {
				$this->setting ['smscanuse'] = 1;
			} else {
				$this->setting ['smscanuse'] = 0;
			}
			$smsplatform=$this->input->post ( 'allow_smsplatform' );
			if(!$smsplatform){
				$message = '请选择默认的短信平台！';
			}else{
				$this->setting ['allow_smsplatform'] = $smsplatform;
				$this->setting_model->update ( $this->setting );
				$message = '聚合短信设置更新成功！';
			}
			
		}
		include template ( 'setting_sms', 'admin' );
	}
	/* 短信设置 */
	function sms() {
		if (null !== $this->input->post ( 'submit' )) {
			checkattack ( $_POST, 'post' );
			foreach ( $_POST as $key => $value ) {
				if ('sms' == substr ( $key, 0, 3 )) {
					$this->setting [$key] = $value;
				}
			}
			if ($this->input->post ( 'smscanuse' ) == 'on') {
				$this->setting ['smscanuse'] = 1;
			} else {
				$this->setting ['smscanuse'] = 0;
			}
			$this->setting_model->update ( $this->setting );
			$message = '聚合短信设置更新成功！';
		}
		include template ( 'setting_sms', 'admin' );
	}
	function testsms() {
		if (null !== $this->input->post ( 'submit' )) {
			
			$phone = $this->input->post ( 'userphone' );
			if (! $phone) {
				$message = "手机号不能为空";
			} else {
				$num = rand ( 100000, 999999 );
				$codenum = $this->setting ['smstmpvalue'];
				$codenum = str_replace ( '{code}', $num, $codenum );
				$msg = sendsms ( $this->setting ['smskey'], $phone, $this->setting ['smstmpid'], $codenum );
				if ($msg ['errorcode'] == 0) {
					$message = '短信测试成功！';
				} else {
					$message = '短信测试失败！' . $msg ['msg'];
				}
			}
		}
		include template ( 'setting_sms', 'admin' );
	}
	function testaliyunsms() {
		if (null !== $this->input->post ( 'submit' )) {
			
			$phone = $this->input->post ( 'userphone' );
			if (! $phone) {
				$message = "手机号不能为空";
			} else {
				$smsresult = aliyunsms ( $phone, $this->setting ['aliyunsmsregtmpid'], rand ( 1000, 9999 ) );
				if ($smsresult ['Message'] == 'OK') {
					$message = '短信测试成功！';
				} else {
					$message = '短信测试失败！' . $smsresult ['Message'];
				}
			}
		}
		include template ( 'setting_sms', 'admin' );
	}
	function testfindpwdaliyunsms() {
		if (null !== $this->input->post ( 'submit' )) {
			
			$phone = $this->input->post ( 'finduserphone' );
			if (! $phone) {
				$message = "手机号不能为空";
			} else {
				$smsresult = aliyunsms ( $phone, $this->setting ['aliyunsmsfindpwdtmpid'], rand ( 1000, 9999 ) );
				if ($smsresult ['Message'] == 'OK') {
					$message = '找回密码短信测试成功！';
				} else {
					$message = '短信测试失败！' . $smsresult ['Message'];
				}
			}
		}
		include template ( 'setting_sms', 'admin' );
	}
}

?>