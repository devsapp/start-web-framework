<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Loginlog extends ADMIN_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->model ( 'setting_model' );
	}
	function index() {
		if ($_POST) {
			$openadminlogin = intval ( $_POST ['openadminlogin'] )==0 ? 1:0;
			$this->setting ['openadminlogin'] = $openadminlogin;
			$this->setting_model->update ( $this->setting );
			if ($openadminlogin) {
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
		$navtitle = "后台登录日志管理";
		@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( "loginlog", " 1=1 ", $this->db->dbprefix ) )->row_array () );
		$departstr = page ( $rownum, $pagesize, $page, "admin/plugin/loginlog" );
		$loginloglist = $this->db->get ( "loginlog" )->result_array ();
		include template ( "loginlog", "admin/plugin" );
	}
}

?>