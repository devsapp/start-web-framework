<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Api_article extends CI_Controller {

	var $apikey = '';
	var $whitelist;
	var $domain;
	//构造函数
	function __construct() {
		$this->whitelist = "clist,newqlist,hotqlist,hotalist";
		parent::__construct ();
		$this->load->model( 'topic_model' );

		$this->domain =SITE_URL;
	}
	function clist() {

		$content = array ();
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix  . "topic order by id desc LIMIT 0,3" );
			foreach ( $query->result_array () as $topic ) {

			//$topic['viewtime'] = tdate($topic['viewtime']);
			// $description=cutstr(strip_tags($topic['describtion']),120,'');
			$description = '';
			if (strstr ( $topic ['image'], 'http' )) {
				$content [] = array ("Title" => $topic ['title'], "Description" => $description, "PicUrl" => $topic ['image'], "Url" =>url('topic/topicone/'. $topic ['id']) );
			} else {
				$content [] = array ("Title" => $topic ['title'], "Description" => $description, "PicUrl" => $this->domain . $topic ['image'], "Url" => url('topic/topicone/'. $topic ['id']));
			}

		}
		echo json_encode ( $content );
	}
	function newqlist() {

		$questionlist = array ();
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix  . "question where status in (1,2) order by id desc LIMIT 0,3" );

		$description = '';
		//$description=cutstr(strip_tags($question['describtion']),120,'');
		foreach ( $query->result_array () as $question ) {
			//$question['describtion']='';
			//  $question['describtion']=cutstr(strip_tags($question['describtion']),120,'');
			$firstimg = getfirstimg ( $question ['describtion'] );
			if ($firstimg != '') {
				$question ['avatar'] = $firstimg;
				runlog ( 'img', $firstimg );
			} else {
				$question ['avatar'] = get_avatar_dir ( $question ['authorid'] );
			}

			$question ['url'] = url("question/view/".$question ['id']);
			$questionlist [] = $question;
		}
		//


		echo json_encode ( $questionlist );

	}
	function hotqlist() {
		$questionlist = array ();
		// $attentionlist=$this->fromcache('attentionlist');
		$i = 0;
		$timestart = time() - 7 * 24 * 3600;
		$timeend = time();
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix  . "question WHERE status in (1,2) AND  `time`>$timestart AND `time`<$timeend  ORDER BY answers DESC,views DESC, `time` DESC LIMIT 0,4" );

		$description = '';

		foreach ( $query->result_array () as $question ) {

			$firstimg = getfirstimg ( $question ['describtion'] );
			if ($firstimg != '') {
				$question ['avatar'] = $firstimg;
				//runlog ( 'img', $firstimg );
			} else {
				$question ['avatar'] = get_avatar_dir ( $question ['authorid'] );
			}

			$question ['url'] = url("question/view/".$question ['id']);
			$questionlist [] = $question;
		}
		echo json_encode ( $questionlist );
	}
	function hotalist() {
		$content = array ();
		$modellist = $this->fromcache ( 'hottopiclist' );

		$i = 1;
		foreach ( $modellist as $key => $val ) {
			if ($i >= 3)
				break;

			$description = '';
			if (strstr ( $modellist [$key] ['image'], 'http' )) {
				$content [] = array ("Title" => $modellist [$key] ['title'], "Description" => $description, "PicUrl" => $modellist [$key] ['image'], "Url" =>url("topic/topicone/".$modellist [$key] ['id']));
			} else {
				$content [] = array ("Title" => $modellist [$key] ['title'], "Description" => $description, "PicUrl" => 'http://' . $_SERVER ['HTTP_HOST'] . $modellist [$key] ['image'], "Url" => url("topic/topicone/".$modellist [$key] ['id']) );
			}
			$i ++;
		}

		echo json_encode ( $content );
	}
}

?>