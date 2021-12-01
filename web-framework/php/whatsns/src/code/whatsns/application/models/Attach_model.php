<?php

class Attach_model extends CI_Model {

	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}

	function movetmpfile($attach, $targetfile) {
		forcemkdir ( dirname ( $targetfile ) );
		if (copy ( $attach ['tmp_name'], $targetfile ) || move_uploaded_file ( $attach ['tmp_name'], $targetfile )) {
			return 1;
		}
		if (is_readable ( $attach ['tmp_name'] )) {
			$fp = fopen ( $attach ['tmp_name'], 'rb' );
			flock ( $fp, 2 );
			$attachedfile = fread ( $fp, $attach ['size'] );
			fclose ( $fp );
			$fp = fopen ( $targetfile, 'wb' );
			flock ( $fp, 2 );
			if (fwrite ( $fp, $attachedfile )) {
				unlink ( $attach ['tmp_name'] );
			}
			fclose ( $fp );
			return 1;
		}
		return 0;
	}

	function add($filename, $ftype, $fsize, $location, $isimage = 1) {
		global $user;
		$uid = $user ['uid'];
		$data = array ('time' => time (), 'filename' => $filename, 'filetype' => $ftype, 'filesize' => $fsize, 'location' => $location, 'isimage' => $isimage, 'uid' => $uid );
		$this->db->insert ( 'attach', $data );
		return $this->db->insert_id ();
	}

}
?>