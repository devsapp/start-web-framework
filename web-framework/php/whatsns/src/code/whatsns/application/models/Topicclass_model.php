<?php

class Topicclass_model  extends CI_Model {

	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}

/* 获取分类信息 */

    function get_list() {
           $topicclasslist = array();

        $query = $this->db->query("SELECT * FROM " . $this->db->dbprefix . "topicclass");
        foreach ( $query->result_array () as $cate ) {
            $topicclasslist[] = $cate;

        }

        return $topicclasslist;
    }

}