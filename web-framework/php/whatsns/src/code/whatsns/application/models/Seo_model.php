<?php
class Seo_model extends CI_Model {
	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}
	function get_bycatid($catid,$paixu, $start = 0, $limit = 6) {
		$topiclist = array ();
		$wherecategory="";
		$lastwhere="";
		if($catid){
			$wherecategory=" articleclassid in($catid) and ";
		}
		switch ($paixu) {
			case 'new' :
				$lastwhere=" $wherecategory state=1  ";
				$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic where $lastwhere order by viewtime desc LIMIT $start,$limit" );
				
				break;
			case 'weeklist' :
				$timeweekstart = $this->base->time - 7 * 24 * 3600;
				$timedaystart = $this->base->time - 1 * 24 * 3600;
				$timemonthstart = $this->base->time - 30 * 24 * 3600;
				$timeyearstart = $this->base->time - 365 * 24 * 3600;
				$timeend = $this->base->time;
				$query = null;
				// 先看一天内文章是否超过10条
				$dayrownum = returnarraynum ( $this->db->query ( getwheresql ( 'topic', " $wherecategory state=1 AND  `viewtime`>$timedaystart AND `viewtime`<$timeend ", $this->db->dbprefix ) )->row_array () );
				if ($dayrownum >= 10) {
					$lastwhere=" $wherecategory  state=1 AND  `viewtime`>$timedaystart AND `viewtime`<$timeend  ";
					$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic where $lastwhere order by views desc LIMIT $start,$limit" );
				} else {
					
					// 看这一周是否超过10条
					$weekrownum = returnarraynum ( $this->db->query ( getwheresql ( 'topic', " $wherecategory state=1 AND  `viewtime`>$timeweekstart AND `viewtime`<$timeend ", $this->db->dbprefix ) )->row_array () );
					if ($weekrownum >= 10) {
						$lastwhere=" $wherecategory state=1 AND  `viewtime`>$timeweekstart AND `viewtime`<$timeend  ";
						$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic where $lastwhere order by views desc LIMIT $start,$limit" );
					} else {
						// 看这一月是否超过10条
						$monthrownum = returnarraynum ( $this->db->query ( getwheresql ( 'topic', " $wherecategory state=1 AND  `viewtime`>$timemonthstart AND `viewtime`<$timeend ", $this->db->dbprefix ) )->row_array () );
						
						if ($monthrownum >= 10) {
							$lastwhere=" $wherecategory state=1 AND  `viewtime`>$timemonthstart AND `viewtime`<$timeend ";
							$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic where $lastwhere  order by views desc LIMIT $start,$limit" );
						} else {
							$lastwhere=" $wherecategory state=1 AND  `viewtime`>$timeyearstart AND `viewtime`<$timeend  ";
							$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic where $lastwhere order by views desc LIMIT $start,$limit" );
						}
					}
				}
				
				break;
			case 'hotlist' :
				$lastwhere=" $wherecategory ispc=1 and state=1 ";
				$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic where $lastwhere order by viewtime desc LIMIT $start,$limit" );
				break;
			case 'money' :
				$lastwhere=" $wherecategory readmode=3 and state=1 ";
				$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic where $lastwhere order by viewtime desc LIMIT $start,$limit" );
				
				break;
			case 'credit' :
				$lastwhere=" $wherecategory readmode=2 and state=1 ";
				$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic where $lastwhere order by viewtime desc LIMIT $start,$limit" );
				
				break;
			default :
				$lastwhere="  $wherecategory state=1  ";
				$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic where $lastwhere order by viewtime desc LIMIT $start,$limit" );
				
				break;
		}
		
	
		foreach ( $query->result_array () as $topic ) {
			
			$topic ['title'] = checkwordsglobal ( $topic ['title'] );
			$topic ['avatar'] = get_avatar_dir ( $topic ['authorid'] );
			
			if ($topic ['price'] > 0) {
				$topic ['describtion'] = "付费阅读";
				$topic ['description'] = "付费阅读";
			} else {
				$topic ['images'] = getfirstimgs ( $topic ['describtion'] );
				$topic ['describtion'] = cutstr ( str_replace ( '&nbsp;', '', checkwordsglobal ( strip_tags ( html_entity_decode ( $topic ['describtion'] ) ) ) ), 240, '...' );
				$topic ['description'] = cutstr ( checkwordsglobal ( strip_tags ( html_entity_decode ( $topic ['describtion'] ) ) ), 240, '...' );
			}
			if (isset ( $this->base->category [$topic ['articleclassid']] )) {
				$topic ['category_name'] = $this->base->category [$topic ['articleclassid']] ['name'];
			}
			$topic ['author_has_vertify'] = get_vertify_info ( $topic ['authorid'] ); // 用户是否认证
			$topic ['articleid'] = $topic ['id'];
			$topic ['answers'] = $topic ['articles'];
			$topic ['format_time'] = tdate ( $topic ['viewtime'] );
			$topic ['viewtime'] = tdate ( $topic ['viewtime'] );
			$topic ['attentions'] = $topic ['likes'];
			$topiclist [] = $topic;
		}
		$alltopiclist = array ();
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'topic', $lastwhere, $this->db->dbprefix ) )->row_array () );
		$alltopiclist['list']=$topiclist;
		$alltopiclist['allnum']=$rownum;
		return $alltopiclist;
	}
	
	

	
	
}

?>
