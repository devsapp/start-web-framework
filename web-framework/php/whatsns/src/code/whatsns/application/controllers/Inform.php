<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Inform extends CI_Controller {

	function __construct() {

		parent::__construct ();
		$this->load->model ( "inform_model" );

	}

	/*添加举报*/
	function add() {

		$this->input->post ('group-type') ==null && $this->message ( '请选择举报类型，谢谢！', 'BACK' );
		$this->input->post ('type') ==null&& $this->message ( '请选择举报原因，谢谢！', 'BACK' );
	  $this->input->post ('type') ==null  && $this->message ( '请填写举报描述，谢谢！', 'BACK' );
		$this->inform_model->add ( $this->input->post ('qid'), $this->input->post ('qtitle'), $this->user ['uid'], $this->user ['username'], $this->input->post ('aid'), $this->input->post ('type'), $this->input->post ('content'), $this->input->post ('group-type') );
		$this->message ( '举报成功，健康的网络环境需要大家共同维护，谢谢您的支持 :)', 'BACK' );
	
	}
}
?>