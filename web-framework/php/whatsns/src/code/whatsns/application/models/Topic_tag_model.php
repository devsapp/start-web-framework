<?php

class Topic_tag_model  extends CI_Model{

	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}


	function get_by_aid($aid) {
		$taglist = array ();
		$query = $this->db->query ( "select at.id,at.tagname,at.tagalias from " . $this->db->dbprefix . "tag as at," . $this->db->dbprefix . "tag_item as ati where ati.tagid=at.id and ati.typeid=$aid and ati.itemtype='article'  LIMIT 0,10" );
		foreach ( $query->result_array () as $tag ) {
			$taglist [] = $tag;
		}
		return $taglist;
	}
    function list_by_name($name) {
        return $this->db->query("SELECT * FROM `" . $this->db->dbprefix . "topic_tag` WHERE name='$name'")->row_array();
    }
   function list_by_countname($name) {
        return $this->db->query("SELECT count(*) as sum FROM `" . $this->db->dbprefix . "topic_tag` WHERE name='$name'")->row_array();
    }
    function list_by_tagname($tagname,$start = 0, $limit = 100){
    	   $taglist = array();
    	$query=$this->db->query("SELECT  distinct name FROM `" . $this->db->dbprefix . "topic_tag` WHERE name like '%$tagname%'  ORDER BY qid DESC LIMIT $start,$limit");
    	 foreach ( $query->result_array () as $tag ) {
      	$tag['count']=$this->list_by_countname($tag['name']);
            $taglist[] = $tag;
        }
          return $taglist;
    }
    function get_list($start = 0, $limit = 100) {
        $taglist = array();
        $query = $this->db->query("SELECT count(aid) as questions ,name FROM " . $this->db->dbprefix . "topic_tag GROUP BY name ORDER BY aid DESC LIMIT $start,$limit");
         foreach ( $query->result_array () as $tag ) {
            $taglist[] = $tag;
        }
        return $taglist;
    }

    function rownum() {
        $query = $this->db->query("SELECT count(name) FROM " . $this->db->dbprefix . "topic_tag GROUP BY name");
        return $this->db->num_rows($query);
    }

    function multi_add($namelist, $aid) {

        if (empty($namelist))
            return false;
        $this->db->query("DELETE FROM " . $this->db->dbprefix . "topic_tag WHERE aid=$aid");
        $insertsql = "INSERT INTO " . $this->db->dbprefix . "topic_tag(`aid`,`name`,`time`) VALUES ";
        foreach ($namelist as $name) {
            $insertsql .= "($aid,'".  htmlspecialchars($name)."',{$this->base->time}),";
        }

        $this->db->query(substr($insertsql, 0, -1));
    }

    function remove_by_name($names) {
        $namestr = "'" . implode("','", $names) . "'";
        $this->db->query("DELETE FROM " . $this->db->dbprefix . "topic_tag WHERE `name` IN ($namestr)");
    }

}

?>
