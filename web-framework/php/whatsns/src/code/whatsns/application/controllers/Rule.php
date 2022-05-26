<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Rule extends CI_Controller {

	var $whitelist;
	function __construct() {
		$this->whitelist = "index";
		parent::__construct ();

	}
	function index() {
		$navtitle="网站财富值规则明细";
		include template ( 'rule' );
	}

}