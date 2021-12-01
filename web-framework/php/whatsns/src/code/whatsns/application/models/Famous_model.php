<?php
class Famous_model extends CI_Model {

	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}


    function get_list($answersize=3, $start=0, $limit=3) {
        $famouslist = array();
        $query = $this->db->query("SELECT u.uid,u.username,u.questions,u.answers,u.signature,u.credit1,u.credit2,u.credit3,f.id,f.reason,f.time FROM " . $this->db->dbprefix . "famous as f," . $this->db->dbprefix . "user as u WHERE f.uid=u.uid ORDER BY f.id DESC LIMIT $start ,$limit");
        foreach ( $query->result_array () as $famous ) {
            $famous['avatar'] = get_avatar_dir($famous['uid']);
            $famous['time'] = tdate($famous['time']);
            $famous['bestanswer'] = $this->get_solve_answer($famous['uid'], 0, $answersize);
            $famouslist[] = $famous;
        }
        return $famouslist;
    }

    function get_solves($start=0, $limit=20) {
        $solvelist = array();
        $query = $this->db->query("SELECT a.qid,a.title FROM " . $this->db->dbprefix . "answer  as a ,`" . $this->db->dbprefix . "famous` as f WHERE a.authorid=f.uid ORDER BY a.time DESC LIMIT $start ,$limit");
        foreach ( $query->result_array () as $solve ) {
            $solvelist[] = $solve;
        }
        return $solvelist;
    }

    function add($uid, $resaon) {
        if ($this->get_by_uid($uid))
            $this->db->query("UPDATE " . $this->db->dbprefix . "famous SET `reason`='$resaon' ,`time`=" . time() . " WHERE uid=$uid");
        else
            $this->db->query("INSERT INTO " . $this->db->dbprefix . "famous (`uid` ,`reason` ,`time` ) VALUES ($uid,'$resaon'," . time() . ")");
    }

    function get_by_uid($uid) {
        return $this->db->query("SELECT * FROM " . $this->db->dbprefix . "famous WHERE uid=$uid")->row_array();
    }

    function remove($uid) {
        return $this->db->query("DELETE FROM " . $this->db->dbprefix . "famous WHERE uid = $uid");
    }

    function get_solve_answer($uid, $start=0, $limit=3) {
        $solvelist = array();
        $query = $this->db->query("SELECT * FROM `" . $this->db->dbprefix . "answer` WHERE `authorid`=" . $uid . " AND `adopttime`>0 ORDER BY `adopttime` DESC,`support` DESC LIMIT $start,$limit");
        foreach ( $query->result_array () as $solve ) {
            $solvelist[] = $solve;
        }
        return $solvelist;
    }

}

?>
