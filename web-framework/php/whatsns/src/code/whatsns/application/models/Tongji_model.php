<?php

class Tongji_model extends CI_Model {

	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}

	//获取今日注册用户数
	function rownum_by_today_user_regtime($starttime, $endtime) {
		$m = $this->db->query ( "select count(*) as num from " . $this->db->dbprefix . "user where regtime>=$starttime and regtime<=$endtime" )->row_array ();
		return $m ['num'];

	}

	//获取今日问题数
	function rownum_by_today_submit_question($starttime, $endtime) {

		$m = $this->db->query ( "select count(*) as num from " . $this->db->dbprefix . "question where time>=$starttime and time<=$endtime " )->row_array ();
		return $m ['num'];
	}
	//获取今日问题数
	function rownum_by_today_submit_answer($starttime, $endtime) {
		$m = $this->db->query ( "select count(*) as num from " . $this->db->dbprefix . "answer where time>=$starttime and time<=$endtime " )->row_array ();
		return $m ['num'];
	}
	//获取今日文章数
	function rownum_by_today_submit_article($starttime, $endtime) {
		$m = $this->db->query ( "select count(*) as num from " . $this->db->dbprefix . "topic where viewtime>=$starttime and viewtime<=$endtime " )->row_array ();
		return $m ['num'];
	}
}
?>
