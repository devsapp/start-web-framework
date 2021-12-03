<?php

class Sitelog_model extends CI_Model{

function __construct() {
		parent::__construct ();
		$this->load->database ();
	}
    function get_list($start=0,$limit=1000) {
        $loglist=array();
        $query=$this->db->query("SELECT * FROM `".$this->db->dbprefix."site_log` ORDER BY `time` DESC limit $start,$limit");
        foreach ( $query->result_array () as $log ) {
            $log['time']=tdate($log['time'],3,0);
            $loglist[]=$log;
        }
        return $loglist;
    }
    function delete($starttime,$endtime){

    	    	 $this->db->query("delete from  `".$this->db->dbprefix."site_log` where time>=$starttime and time <=$endtime");
    }



}
?>
