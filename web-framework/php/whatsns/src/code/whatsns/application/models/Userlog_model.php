<?php

class Userlog_model extends CI_Model {

	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}

	/**
	 * 添加用户操作记录
	 * @param enum $type=login|ask|answer
	 * @return int
	 */
	function add($type) {
		$this->db->query ( "INSERT INTO " . $this->db->dbprefix . "userlog(`id`,`sid`,`type`,`time`) VALUES (null,'{$this->base->user['uid']}','$type',{$this->base->time})" );
		return $this->db->insert_id ();
	}

	/**
	 * 按时间计算用户的操作次数
	 * @param ENUM $type
	 * @param INT $hours
	 * @return INT
	 */
	function rownum_by_time($type = 'ask', $hours = 1) {
		$starttime = strtotime ( date ( "Y-m-d H:00:00", $this->base->time ) );
		$endtime = $starttime + $hours * 3600;
		$sid = $this->base->user ['uid'];

		$m = $this->db->query ( "select count(*) as num from " . $this->db->dbprefix . "userlog where `time`>$starttime AND `time`<$endtime AND sid='$sid' AND type='$type'" )->row_array ();
		return $m ['num'];
	}

}

?>
