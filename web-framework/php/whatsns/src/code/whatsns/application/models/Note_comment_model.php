<?php


class Note_comment_model extends CI_Model{

function __construct() {
		parent::__construct ();
		$this->load->database ();
	}

    function get_by_noteid($noteid, $start = 0, $limit = 10) {
    	$noteid=intval($noteid);
        $commentlist = array();
        $query = $this->db->query("SELECT * FROM " . $this->db->dbprefix . "note_comment WHERE noteid='$noteid' ORDER BY `time` DESC LIMIT $start,$limit");
        foreach ( $query->result_array () as $comment ) {
            $comment['avatar'] = get_avatar_dir($comment['authorid']);
            $comment['format_time'] = tdate($comment['time']);
                $comment['content'] = checkwordsglobal($comment['content']);
            $commentlist[] = $comment;
        }
        return $commentlist;
    }

    function add($noteid, $content) {
        $username = $this->base->user['username'];
        $uid = $this->base->user['uid'];
        $data=array(
        		'noteid'=>$noteid,
        		'authorid'=>$uid,
        		'author'=>$username,
        		'content'=>$content,
        		'time'=>time()
        );
        $this->db->insert('note_comment',$data);
       
        return $this->db->insert_id();
    }

    function remove($commentid, $noteid) {
    	$noteid=intval($noteid);
    	$commentid=intval($commentid);
        $sql = "DELETE FROM " . $this->db->dbprefix . "note_comment WHERE `id`=" . $commentid;
        if (($this->base->user['grouptype'] != 1)) {
            $sql.=" AND authorid=" . $this->base->user['uid'];
        }
        if ($this->db->query($sql)) {
            $this->db->query("UPDATE " . $this->db->dbprefix . "note SET comments=comments-1 WHERE `id`=$noteid");
        }
    }

}

?>
