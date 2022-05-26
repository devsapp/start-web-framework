<?php

class Keywords_model extends CI_Model {

	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}

	function get_list($start = 0, $limit = 20) {
		$wordlist = array ();
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "keywords  ORDER BY `id` DESC LIMIT $start,$limit" );
		foreach ( $query->result_array () as $word ) {
			$word['find']=str_replace("\"","&#34;",$word['find']);
			$word['find'] = str_replace( "'", "&#39;",$word['find']);
			$word['replacement']=str_replace("\"","&#34;",$word['replacement']);
			$word['replacement'] = str_replace( "'", "&#39;",$word['replacement']);
			$word ['num'] = 0;
			$wordlist [] = $word;
		}
		return $wordlist;
	}
	function add($wids, $finds, $replacements, $admin) {
		$wsize = count ( $wids );
		for($i = 0; $i < $wsize; $i ++) {
			if ($wids [$i]) {
				$data1=array(
						'find'=>$finds[$i],
						'replacement'=>$replacements[$i]
						
				);
				$this->db->where(array('id'=>$wids[$i]))->update('keywords',$data1);

			} else {
				if($finds [$i]){
					$data1=array(
							'admin'=>$admin,
							'find'=>$finds[$i],
							'replacement'=>$replacements[$i]
							
					);
					$this->db->insert('keywords',$data1);
				}

		
			}
		}
	}

	function multiadd($lines, $admin) {

		$datas=array();
		foreach ( $lines as $line ) {
			$line = str_replace ( array ("\r\n", "\n", "\r" ), '', $line );
			if (empty ( $line ))
				continue;
				@list ( $find, $replacement ) = explode ( '=', $line );
			//htmlspecialchars ( $name )
			$data=array(
					'admin' => $admin,
					'find' => $find ,
					'replacement' =>$replacement
					
			);
			array_push($datas, $data);
		}
		
		
		$this->db->insert_batch('keywords', $datas);
		
	}

	function remove_by_id($ids) {
		$ids=explode(',', $ids);
		$this->db->where_in("id",$ids)->delete('keywords');
		
	}

}
?>