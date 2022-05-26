<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Main extends ADMIN_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->model ( 'setting_model' );
	}
	/**
	 *
	 * 获取开发者参数信息
	 *
	 * @date: 2020年11月9日 下午3:56:15
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function setdevparms() {
		if ($_POST) {
			$this->setting ['dev_appid'] = $this->input->post ( 'dev_appid' );
			$this->setting ['dev_appsecret'] = $this->input->post ( 'dev_appsecret' );
			$this->setting_model->update ( $this->setting );
			if (! isset ( $_SESSION )) {
				session_start ();
			}
			unset($_SESSION['dev_accesstion']);
			$message ['code'] = 200;
			$message ['msg'] = "更新成功";
			echo json_encode ( $message );
			exit ();
		}
		$message ['code'] = 201;
		$message ['msg'] = "操作异常";
		echo json_encode ( $message );
		exit ();
	}
	/**
	 *
	 * 反馈问题
	 *
	 * @date: 2020年11月10日 上午9:08:34
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function replayquestion() {
		$title = trim ( $this->input->post ( 'title' ) );
		$content = $this->input->post ( 'content' );
		if ($title == '') {
			$message ['code'] = 201;
			$message ['msg'] = "标题不能为空";
			echo json_encode ( $message );
			exit ();
		}
		$accessToken=getAccessToken();//获取accesstoken
	
		if(is_array($accessToken)){
			echo json_encode($accessToken);
			exit();
		}
		$data = array (
				'title' => $title,
				'content' => $content,
				'accesstoken'=>$accessToken
		);

		$result=curl_post(config_item("postquestion"),$data);
		echo json_encode($result);
		exit();
		
	}
	/**
	
	* 追加问题
	
	* @date: 2020年11月10日 下午5:39:01
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function appendreplayquestion(){
		$onlyid = trim ( $this->input->post ( 'onlyid' ) );
		$content = $this->input->post ( 'content' );
		if (clearhtml($content) == '') {
			$message ['code'] = 201;
			$message ['msg'] = "追问描述需包含文字说明";
			echo json_encode ( $message );
			exit ();
		}
		$accessToken=getAccessToken();//获取accesstoken
		if(is_array($accessToken)){
			echo json_encode($accessToken);
			exit();
		}
		$data = array (
				'onlyid'=>$onlyid,
				'content' => $content,
				'accesstoken'=>$accessToken
		);
		
		$result=curl_post(config_item("postappendquestion"),$data);
		echo json_encode($result);
		exit();
	}
	/**
	
	* 判断是否有新回复
	
	* @date: 2020年11月10日 下午7:29:00
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function hasnewmessage(){
		global $setting;
		// 判断是否设置了appid和appsecret
		if ($setting['dev_appid'] == '' || ! isset ( $setting['dev_appid'] ) || $setting['dev_appsecret'] == '' || ! isset ( $setting['dev_appsecret'] )) {
			$message ['code'] = 2001;
			$message ['msg'] = "appid或者appsecret不能为空";
			echo json_encode ( $message );
			exit ();
		}
		$accessToken=getAccessToken();//获取accesstoken
		if(is_array($accessToken)){
			echo json_encode($accessToken);
			exit();
		}
		$data = array (
				'accesstoken'=>$accessToken
		);	
		$result=curl_post(config_item("hasnewmessage"),$data);
		echo json_encode($result);
		exit();
	}
	
}

?>