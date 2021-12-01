<?php



class Banned_model extends CI_Model  {

	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}

    function get_list($start=0, $limit=20) {
        $bannedlist = array();
        $this->refresh();
        $query = $this->db->query("SELECT * FROM `" . $this->db->dbprefix  . "banned` ORDER BY id DESC LIMIT $start,$limit");
        foreach ( $query->result_array () as $banned ) {
            $banned['endtime'] = tdate($banned['time'] + $banned['expiration']);
            $banned['starttime'] = tdate($banned['time']);
            if ($banned['ip1'] < 0)
                $banned['ip1'] = '*';
            if ($banned['ip2'] < 0)
                $banned['ip2'] = '*';
            if ($banned['ip3'] < 0)
                $banned['ip3'] = '*';
            if ($banned['ip4'] < 0)
                $banned['ip4'] = '*';
            $banned['ip'] = $banned['ip1'] . '.' . $banned['ip2'] . '.' . $banned['ip3'] . '.' . $banned['ip4'];
            $bannedlist[] = $banned;
        }
        return $bannedlist;
    }

    function add($ips, $expiration) {
    	global $user;
        $expiration = ($expiration) ? $expiration * 3600 * 24 : 0;
        list($ip1, $ip2, $ip3, $ip4) = $ips;
        $time=time();
        $this->db->query("INSERT INTO `" . $this->db->dbprefix . "banned` (`ip1`,`ip2`,`ip3`,`ip4`,`admin`,`time`,`expiration`) VALUES ('$ip1','{$ip2}','{$ip3}','{$ip4}','{$user['username']}','{$time}','{$expiration}')");
        $this->cache->remove('banned');
    }

    function remove($ips) {
    	$this->db->where_in('id',$ips)->delete('banned');

    }

    function refresh() {
    	$time=time();
        $this->db->query("DELETE FROM `" .  $this->db->dbprefix . "banned` WHERE (`time`+`expiration`)<$time");
    }

    function update() {
        $ips = $this->get_list();
        $this->cache->write('banned', $ips);
    }

}

?>