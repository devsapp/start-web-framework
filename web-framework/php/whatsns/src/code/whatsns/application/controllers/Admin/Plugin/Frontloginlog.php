<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Frontloginlog extends ADMIN_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->model ( 'setting_model' );
	}
	function index() {
		if ($_POST) {
			$openloginlogin = intval ( $_POST ['openfrontlogin'] )==0 ? 1:0;
			$this->setting ['openfrontlogin'] = $openloginlogin;
			$this->setting_model->update ( $this->setting );
			if ($openloginlogin) {
				$message ['code'] = 200;
				$message ['msg'] = "设置成功";
				echo json_encode ( $message );
				exit ();
			} else {
				$message ['code'] = 2001;
				$message ['msg'] = "已关闭";
				echo json_encode ( $message );
				exit ();
			}
		}
		$navtitle = "前端用户登录错误日志管理";
		@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = 50;
		$startindex = ($page - 1) * $pagesize;
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( "login_info", " 1=1 ", $this->db->dbprefix ) )->row_array () );
		$departstr = page ( $rownum, $pagesize, $page, "admin/plugin/frontloginlog" );
		$loginloglist = $this->db->get ( "login_info" )->result_array ();
		include template ( "frontloginlog", "admin/plugin" );
	}
	/**
	
	* 设置前端登录错误信息
	
	* @date: 2020年10月23日 下午5:08:27
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function postfrontloginsetting(){
		try{
			$this->setting ['pwd_error_locktime'] = intval ( $_POST ['pwd_error_locktime'] );
			$this->setting ['pwd_error_num'] = intval ( $_POST ['pwd_error_num'] );
			$this->setting_model->update ( $this->setting );
			$message['code']=200;
			echo json_encode($message);
			exit();
		}catch (Exception $e){
			$message['code']=201;
			echo json_encode($message);
			exit();
		}
	
	}
}

?>