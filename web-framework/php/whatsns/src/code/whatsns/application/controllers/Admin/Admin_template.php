<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Admin_template extends ADMIN_Controller {

	function __construct() {
		parent::__construct ();
		$this->load->model ( 'setting_model' );
		if($this->user['groupid']!=1){
			$this->message("由于修改模板权限比较隐私，只放开给超级管理员使用");
			exit();
		}
	}
	function index($message = '', $type = 'correctmsg') {
		if ($this->uri->segment ( 3 ) == 'wap') {
			include template ( 'tmp_wap', 'admin' );
		} else {
			include template ( 'tmp_pc', 'admin' );
		}

	}

	function editdirfile() {
		if (null !== $this->input->post ( 'submit' )) {

			$message = "模板编辑成功!";
			$dir = $this->input->post ( 'dir' );
			$dir_file = $this->input->post ( 'dir_file' );

			if(is_dir($dir)){
					chmod ( "views/" . $dir, 0777 );
			}

			file_put_contents ( APPPATH . "views/" . $dir . "/" . $dir_file . ".php", stripslashes ( htmlspecialchars_decode ( $this->input->post ( 'tpl_content' ,FALSE) ) ) );

			$tpl_content = file_get_contents ( APPPATH . "views/" . $dir . "/" . $dir_file . ".php" );
		} else {
			$dir = $this->uri->segment ( 3 );
			$dir_file = $this->uri->segment ( 4 );
			$dir_file2 = null!==$this->uri->segment ( 5 ) ? '/'.$this->uri->segment ( 5 ):'';

			$dir_file=$dir_file.$dir_file2;
			$tpl_content = htmlspecialchars ( file_get_contents ( APPPATH . "views/" . $dir . "/" . $dir_file . ".php" ) );

		}

		include template ( 'tmp_editfile', 'admin' );
	}
	function getpcdir() {
		$tpllist = $this->setting_model->tpl_list ();
		$tppclist = implode ( ',', $tpllist );
		echo $tppclist;
	}
	function getwapdir() {
		$tpllist = $this->setting_model->tpl_waplist ();
		$tppclist = implode ( ',', $tpllist );
		echo $tppclist;
	}
	function getpcdirfile() {
		$dir = $this->input->post ( 'dirname' );
		$file_dir = APPPATH . "views/" . $dir;

		include $file_dir . '/' . $dir . '.php';
		echo json_encode ( $tphtml );
	}

}