<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Sitemap extends ADMIN_Controller {
	function __construct() {
		parent::__construct ();
	}
	function index() {
		$navtitle="站内地图xml";
		include template ( "plugin/rss", "admin" );
	}

	
}