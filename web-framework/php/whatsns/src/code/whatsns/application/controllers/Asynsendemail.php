<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Asynsendemail extends CI_Controller {
	var $whitelist;
	function __construct() {
		$this->whitelist = "msend";
		parent::__construct ();
	}
	/**
	 *
	 * 异步发送邮件
	 *
	 * @date: 2018年7月6日 上午9:29:58
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: 空
	 *        	
	 * @return :
	 *
	 *
	 */
	function msend() {
		// $this->load->model ( 'user_model' );
		$tousername = $_POST['tousername'];
		$mailtitle = $this->input->post ( 'mailtitle', TRUE );
		$mailcontent = $_POST ['mailcontent'];
		$emails=explode(',', $tousername);
		if (isset ( $this->setting ['notify_mail'] ) && $this->setting ['notify_mail'] == '1') {
			
			if (is_array($emails)) {
		
				foreach ( $emails as $email ) {
				
					sendemailtouser ( $email, $mailtitle, $mailcontent );
				}
			} else {
				sendemailtouser ( $emails, $mailtitle, $mailcontent );
			}
		}
		
		exit ( "ok" );
	}
}