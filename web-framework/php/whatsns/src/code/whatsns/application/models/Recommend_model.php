<?php



class Recommend_model extends CI_Model {

	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}

    function get_list($start = 0, $limit = 10) {
        $recommendlist = array();
        $query = $this->db->query("SELECT * FROM " . $this->db->dbprefix . "recommend  ORDER BY TIME DESC LIMIT $start,$limit");
        foreach ( $query->result_array () as $recommend ) {
            $recommend['category_name'] = $this->base->category[$recommend['cid']]['name'];
            $recommend['format_time'] = tdate($recommend['time']);
            $recommend['category_name'] = $this->base->category[$recommend['cid']]['name'];
            $recommend['url'] = url('question/view/' . $recommend['qid'], $recommend['url']);
            $recommend['image'] =$recommend['image']?$recommend['image']:base_url().'static/css/default/recomend.jpg' ;
            $recommendlist[] = $recommend;
        }
        return $recommendlist;
    }

    function add($qids) {
        $time = $this->base->time;
        $query = $this->db->query("SELECT * FROM " . $this->db->dbprefix . "question WHERE `id` IN ($qids) AND status=6");
        $addsql = "REPLACE INTO ".$this->db->dbprefix."recommend (`qid`,`cid`,`title`,`description`,`image`,`url`,`time`) VALUES ";
         foreach ( $query->result_array () as $question ) {
            $src=getfirstimg($question['description']);
            $strip_titile = cutstr($question['title'], 45);
            $strip_desc = cutstr(strip_tags($question['description']),70);
            $addsql .="(".$question['id'].",".$question['cid'].",'$strip_titile','$strip_desc','$src','".$question['url']."',$time),";
        }
       return $this->db->query(substr($addsql,0,-1));
    }

    function remove($qids) {
        return $this->db->query("DELETE FROM ".$this->db->dbprefix."recommend WHERE qid IN ($qids)");
    }
}

?>
