<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Admin_editor extends ADMIN_Controller {

	function __construct() {
		parent::__construct ();
		$this->load->model ( 'editor_model' );
		$this->load->model ( 'setting_model' );
	}

	function index($msg = '') {
		$toolbarlist = $this->editor_model->get_list ( 0 );
		$msg && $message = $msg;
		include template ( 'toolbarlist', 'admin' );
	}

	function setting() {
		if (null !== $this->input->post ( 'submit' )) {
			checkattack($_POST);
			foreach ( $_POST as $key => $value ) {
				if ('editor' == substr ( $key, 0, 6 )) {
					$this->setting [$key] = stripslashes ( $value );
				}
			}

			$this->setting_model->update ( $this->setting );
			$message = '编辑器全局设置更新成功！';
		}
		include template ( 'setting_editor', 'admin' );
	}

	function status() {
		$id = $this->uri->segment ( 3 );
		$available = $this->uri->segment ( 4 );
		$this->editor_model->update ( $id, $available );
		$this->ondefault ( '状态操作成功！' );
	}

	function order() {
		$this->editor_model->order ( $this->input->post ( 'order' ) );
	}

	function upeditor() {

		$setting ['editor_items'] = $this->editor_model->get_items ();
		$this->setting_model->update ( $setting );
		$this->ondefault ( '更新编辑器成功！' );
	}

}

?>