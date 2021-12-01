<?php
class Weixin_setting_model extends CI_Model {

	public function __construct() {
		parent::__construct ();
		$this->load->database ();
	}

	function get() {
		$query = $this->db->from( 'weixin_setting' )->limit ( 1, 0 )->get();
		$wxsetting = $query->row_array ();
		return $wxsetting;
	}

	function add($wxname, $wxid, $weixin, $appid, $appsecret, $winxintype) {
		$this->db->empty_table ( 'weixin_setting' );
		$data = array ('wxname' => $wxname, 'wxid' => $wxid, 'weixin' => $weixin, 'appid' => $appid, 'appsecret' => $appsecret, 'winxintype' => $winxintype );
		$this->db->insert ( 'weixin_setting', $data );
		return $this->db->insert_id ();
	}

}

?>
