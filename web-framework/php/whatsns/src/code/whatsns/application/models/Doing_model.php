<?php
class Doing_model extends CI_Model {
	var $actiontable = array (
			'1' => '提出了问题',
			'2' => '回答了该问题',
			'3' => '评论该回答',
			'4' => '关注了该问题',
			'5' => '赞同了该回答',
			'6' => '对该回答进行了追问',
			'7' => '继续回答了该问题',
			'8' => '采纳了回答',
			'9' => '发布了文章',
			'10' => '关注了专题',
			'11' => '关注了用户',
			'12' => '注册了网站',
			'13' => '收藏了文章',
			'14' => '评论了文章',
			'15' => '付费阅读了文章' 
	);
	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}
	function add($authorid, $author, $action, $qid, $content = '', $referid = 0, $refer_authorid = 0, $refer_content = '') {
		$this->deletedoing ( $authorid, $action, $qid );
		$content && $content = strip_tags ( $content );
		$refer_content && $refer_content = strip_tags ( $refer_content );
		$data = array (
				'doingid' => NULL,
				'authorid' => $authorid,
				'author' => $author,
				'action' => $action,
				'questionid' => $qid,
				'content' => $content,
				'referid' => $referid,
				'refer_authorid' => $refer_authorid,
				'refer_content' => $refer_content,
				'createtime' => time () 
		);
		$this->db->insert ( 'doing', $data );
	}
	function get_by_uid($uid, $loginstatus = 1) {
		global $user;
		$loginstatus = intval ( $loginstatus );
		$uid = intval ( $uid );
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user WHERE uid='$uid'" );
		$usermodel = $query->row_array ();
		$usermodel ['avatar'] = get_avatar_dir ( $uid );
		$usermodel ['register_time'] = tdate ( $usermodel ['regtime'] );
		$usermodel ['lastlogin'] = tdate ( $usermodel ['lastlogin'] );
		$is_followed = $this->is_followeduser ( $usermodel ['uid'], $user ['uid'] );
		$usermodel ['hasfollower'] = $is_followed == 0 ? "0" : "1";
		
		return $usermodel;
	}
	
	/* 是否关注用户 */
	function is_followeduser($uid, $followerid) {
		$followerid = intval ( $followerid );
		$uid = intval ( $uid );
		$query = $this->db->query ( "SELECT COUNT(*) FROM " . $this->db->dbprefix . "user_attention WHERE uid=$uid AND followerid=$followerid" );
		$m = $query->row_array ();
		return $m;
	}
	/* 是否关注分类 */
	function is_followedcid($cid, $uid) {
		$cid = intval ( $cid );
		$uid = intval ( $uid );
		$query = $this->db->query ( "SELECT COUNT(*) FROM " . $this->db->dbprefix . "categotry_follower WHERE uid=$uid AND cid=$cid" );
		$m = $query->row_array ();
		return $m;
	}
	function gettopic($id) {
		$id = intval ( $id );
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic WHERE id='$id'" );
		$topic = $query->row_array ();
		return $topic;
	}
	function get_cat_bycid($id) {
		global $user;
		$id = intval ( $id );
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "category WHERE id='$id'" );
		$category = $query->row_array ();
		$category ['image'] = get_cid_dir ( $category ['id'], 'small' );
		$category ['follow'] = $this->is_followedcid ( $category ['id'], $user ['uid'] );
		$category ['miaosu'] = cutstr ( checkwordsglobal ( strip_tags ( $category ['miaosu'] ) ), 140, '...' );
		$category ['bigimage'] = get_cid_dir ( $category ['id'], 'big' );
		return $category;
	}
	function list_by_type($searchtype = 'all', $uid = 0, $start = 0, $limit = 20) {
		$doinglist = array ();
		$sql = "";
		$uid = intval ( $uid );
		switch ($searchtype) {
			case 'all' :
				$sql .= "select * from " . $this->db->dbprefix . "doing where action in(1,2,3,6,9,11)";
				break;
			case 'my' :
				$sql .= "select * from " . $this->db->dbprefix . "doing where authorid=$uid ";
				break;
			case 'atentto' :
				
				$sql .= "select d.* from " . $this->db->dbprefix . "doing as d," . $this->db->dbprefix . "user_attention as u where d.authorid=u.uid and u.followerid=$uid and action in(1,2,3,6,9,11)";
				break;
		}
		
		$sql .= " ORDER BY createtime DESC LIMIT $start,$limit";
		$query = $this->db->query ( $sql );
		foreach ( $query->result_array () as $doing ) {
			$doing ['doing_time'] = tdate ( $doing ['createtime'] );
			$doing ['user'] = $this->get_by_uid ( $doing ['authorid'] );
			$doing ['avatar'] = get_avatar_dir ( $doing ['authorid'] );
			$doing ['actiondesc'] = $this->actiontable [$doing ['action']];
			$doing ['followerlist'] = $this->get_follower ( $doing ['questionid'] );
			if ($doing ['refer_authorid']) {
				$doing ['refer_avatar'] = get_avatar_dir ( $doing ['refer_authorid'] );
			}
			
			// var $actiontable = array(
			// '1' => '提出了问题',
			// '2' => '回答了该问题',
			// '3' => '评论该回答',
			// '4' => '关注了该问题',
			// '5' => '赞同了该回答',
			// '6' => '对该回答进行了追问',
			// '7' => '继续回答了该问题',
			// '8' => '采纳了回答',
			// '9' => '发布了文章',
			// '10' => '关注了专题',
			// '11' => '关注了用户',
			// '12' => '注册了网站'
			// );
			switch ($doing ['action']) {
				case '1' : // 提出了问题
					$doing ['question'] = $this->getquestionbyqid ( $doing ['questionid'] );
					$doing ['category'] = $this->get_cat_bycid ( $doing ['question'] ['cid'] );
					$doing ['categoryname'] = $doing ['category'] ['name'];
					$doing ['cid'] = $doing ['category'] ['id'];
					$doing ['title'] = $doing ['question'] ['title'];
					$doing ['hidden'] = $doing ['question'] ['hidden'];
					$doing ['views'] = $doing ['question'] ['views'];
					$doing ['answers'] = $doing ['question'] ['answers'];
					$doing ['attentions'] = $doing ['question'] ['attentions'];
					$doing ['content'] = $doing ['question'] ['title'];
					$doing ['image'] = getfirstimg ( $doing ['question'] ['description'] );
					$doing ['description'] = clearhtml(checkwordsglobal ( strip_tags (htmlspecialchars_decode($doing ['question'] ['description']  ))));
					$doing ['url'] = urlmap ( 'question/view/' . $doing ['questionid'], 2 );
					break;
				case '2' : // 回答问题
					$doing ['question'] = $this->getquestionbyqid ( $doing ['questionid'] );
					$doing ['category'] = $this->get_cat_bycid ( $doing ['question'] ['cid'] );
					$doing ['categoryname'] = $doing ['category'] ['name'];
					$doing ['cid'] = $doing ['category'] ['id'];
					$doing ['hidden'] = $doing ['question'] ['hidden'];
					$doing ['title'] = $doing ['question'] ['title'];
					$doing ['views'] = $doing ['question'] ['views'];
					$doing ['answers'] = $doing ['question'] ['answers'];
					$doing ['attentions'] = $doing ['question'] ['attentions'];
					$doing ['content'] = $doing ['question'] ['title'];
					$doing ['description'] =  clearhtml(checkwordsglobal ( strip_tags (htmlspecialchars_decode($doing ['question'] ['description'] ))));
					$doing ['url'] = urlmap ( 'question/view/' . $doing ['questionid'], 2 );
					break;
				case '3' : // /评论该回答
					$doing ['question'] = $this->getquestionbyqid ( $doing ['questionid'] );
					$doing ['hidden'] = $doing ['question'] ['hidden'];
					$doing ['title'] = $doing ['question'] ['title'];
					$doing ['category'] = $this->get_cat_bycid ( $doing ['question'] ['cid'] );
					$doing ['categoryname'] = $doing ['category'] ['name'];
					$doing ['cid'] = $doing ['category'] ['id'];
					$doing ['views'] = $doing ['question'] ['views'];
					$doing ['answers'] = $doing ['question'] ['answers'];
					$doing ['attentions'] = $doing ['question'] ['attentions'];
					$doing ['content'] = $doing ['question'] ['title'];
					$doing ['description'] =  clearhtml(checkwordsglobal ( strip_tags (htmlspecialchars_decode( $doing ['question'] ['description']  ))));
					$doing ['url'] = urlmap ( 'question/view/' . $doing ['questionid'], 2 );
					break;
				case '4' : // 关注了该问题
					$doing ['question'] = $this->getquestionbyqid ( $doing ['questionid'] );
					$doing ['hidden'] = $doing ['question'] ['hidden'];
					$doing ['title'] = $doing ['question'] ['title'];
					$doing ['category'] = $this->get_cat_bycid ( $doing ['question'] ['cid'] );
					$doing ['categoryname'] = $doing ['category'] ['name'];
					$doing ['cid'] = $doing ['category'] ['id'];
					$doing ['views'] = $doing ['question'] ['views'];
					$doing ['answers'] = $doing ['question'] ['answers'];
					$doing ['attentions'] = $doing ['question'] ['attentions'];
					$doing ['content'] = $doing ['question'] ['title'];
					$doing ['description'] =  clearhtml(checkwordsglobal ( strip_tags (htmlspecialchars_decode( $doing ['question'] ['description']  ))));
					$doing ['url'] = urlmap ( 'question/view/' . $doing ['questionid'], 2 );
					if ($doing ['question'] == null) {
						$doing ['content'] = "该问题已被作者和管理员删除";
						$doing ['url'] = urlmap ( 'category/viewtopic/hot', 2 );
					}
					break;
				case '5' : // 赞同了该回答
					$doing ['question'] = $this->getquestionbyqid ( $doing ['questionid'] );
					$doing ['hidden'] = $doing ['question'] ['hidden'];
					$doing ['title'] = $doing ['question'] ['title'];
					$doing ['views'] = $doing ['question'] ['views'];
					$doing ['category'] = $this->get_cat_bycid ( $doing ['question'] ['cid'] );
					$doing ['categoryname'] = $doing ['category'] ['name'];
					$doing ['cid'] = $doing ['category'] ['id'];
					$doing ['answers'] = $doing ['question'] ['answers'];
					$doing ['attentions'] = $doing ['question'] ['attentions'];
					$doing ['content'] = $doing ['question'] ['title'];
					$doing ['description'] =  clearhtml(checkwordsglobal ( strip_tags (htmlspecialchars_decode( $doing ['question'] ['description']  ))));
					$doing ['url'] = urlmap ( 'question/view/' . $doing ['questionid'], 2 );
					break;
				case '6' : // 对回答进行了追问
					$doing ['question'] = $this->getquestionbyqid ( $doing ['questionid'] );
					$doing ['hidden'] = $doing ['question'] ['hidden'];
					$doing ['title'] = $doing ['question'] ['title'];
					$doing ['category'] = $this->get_cat_bycid ( $doing ['question'] ['cid'] );
					$doing ['categoryname'] = $doing ['category'] ['name'];
					$doing ['cid'] = $doing ['category'] ['id'];
					$doing ['views'] = $doing ['question'] ['views'];
					$doing ['answers'] = $doing ['question'] ['answers'];
					$doing ['attentions'] = $doing ['question'] ['attentions'];
					$doing ['content'] = $doing ['question'] ['title'];
					$doing ['description'] =  clearhtml(checkwordsglobal ( strip_tags (htmlspecialchars_decode( $doing ['question'] ['description'] ) )));
					$doing ['url'] = urlmap ( 'question/view/' . $doing ['questionid'], 2 );
					break;
				case '7' : // 继续回答了该问题
					$doing ['question'] = $this->getquestionbyqid ( $doing ['questionid'] );
					$doing ['title'] = $doing ['question'] ['title'];
					$doing ['hidden'] = $doing ['question'] ['hidden'];
					$doing ['category'] = $this->get_cat_bycid ( $doing ['question'] ['cid'] );
					$doing ['categoryname'] = $doing ['category'] ['name'];
					$doing ['cid'] = $doing ['category'] ['id'];
					$doing ['views'] = $doing ['question'] ['views'];
					$doing ['answers'] = $doing ['question'] ['answers'];
					$doing ['attentions'] = $doing ['question'] ['attentions'];
					$doing ['content'] = $doing ['question'] ['title'];
					$doing ['description'] =  clearhtml(checkwordsglobal ( strip_tags (htmlspecialchars_decode($doing ['question'] ['description']  ))));
					$doing ['url'] = urlmap ( 'question/view/' . $doing ['questionid'], 2 );
					break;
				case '8' : // 采纳了该回答
					$doing ['question'] = $this->getquestionbyqid ( $doing ['questionid'] );
					$doing ['title'] = $doing ['question'] ['title'];
					$doing ['hidden'] = $doing ['question'] ['hidden'];
					$doing ['views'] = $doing ['question'] ['views'];
					$doing ['category'] = $this->get_cat_bycid ( $doing ['question'] ['cid'] );
					$doing ['categoryname'] = $doing ['category'] ['name'];
					$doing ['cid'] = $doing ['category'] ['id'];
					$doing ['answers'] = $doing ['question'] ['answers'];
					$doing ['attentions'] = $doing ['question'] ['attentions'];
					$doing ['content'] = $doing ['question'] ['title'];
					$doing ['description'] =  clearhtml(checkwordsglobal ( strip_tags (htmlspecialchars_decode( $doing ['question'] ['description'] ))));
					$doing ['url'] = urlmap ( 'question/view/' . $doing ['questionid'], 2 );
					break;
				case '9' : // 发布了文章
					
					$doing ['topic'] = $this->gettopic ( $doing ['questionid'] );
                	
					$doing ['content'] = $doing ['topic'] ['title'];
					$doing ['title'] = $doing ['topic'] ['title'];
					$doing ['hidden'] = 0;
					$doing ['category'] = $this->get_cat_bycid ( $doing ['topic'] ['articleclassid'] );
					$doing ['categoryname'] = $doing ['category'] ['name'];
					$doing ['cid'] = $doing ['category'] ['id'];
					$doing ['views'] = $doing ['topic'] ['views'];
					$doing ['answers'] = $doing ['topic'] ['articles'];
					$doing ['attentions'] = $doing ['topic'] ['likes'];
					$doing ['image'] = $doing ['topic'] ['image'];
					$doing ['description'] = cutstr ( checkwordsglobal ( strip_tags ( html_entity_decode($doing ['topic'] ['describtion'] ))), 240, '...' );
					$doing ['url'] = urlmap ( 'topic/getone/' . $doing ['questionid'], 2 );
					
					break;
				case '10' : //
					$doing ['category'] = $this->get_cat_bycid ( $doing ['questionid'] );
					$doing ['url'] = urlmap ( 'category/view/' . $doing ['questionid'], 2 );
					$doing ['title'] = $doing ['category'] ['name'];
					$doing ['hidden'] = 0;
					$doing ['views'] = isset ( $doing ['category'] ['views'] ) && $doing ['category'] ['views'];
					$doing ['answers'] = $doing ['category'] ['questions'];
					$doing ['attentions'] = $doing ['category'] ['followers'];
					break;
				case '11' : //
					$doing ['spaceuser'] = $this->get_by_uid ( $doing ['questionid'] );
					$doing ['hidden'] = 0;
					$doing ['title'] = $doing ['spaceuser'] ['username'];
					$doing ['url'] = urlmap ( 'user/space/' . $doing ['questionid'], 2 );
					break;
				case '12' : //
					$doing ['url'] = urlmap ( 'index', 2 );
					break;
				case '13' : //
					
					$doing ['topic'] = $this->gettopic ( $doing ['questionid'] );
					$doing ['title'] = $doing ['topic'] ['title'];
					$doing ['hidden'] = 0;
					$doing ['category'] = $this->get_cat_bycid ( $doing ['topic'] ['articleclassid'] );
					$doing ['categoryname'] = $doing ['category'] ['name'];
					$doing ['cid'] = $doing ['category'] ['id'];
					$doing ['views'] = $doing ['topic'] ['views'];
					$doing ['answers'] = $doing ['topic'] ['articles'];
					$doing ['attentions'] = $doing ['topic'] ['likes'];
					$doing ['content'] = $doing ['topic'] ['title'];
					$doing ['image'] = $doing ['topic'] ['image'];
					$doing ['description'] = cutstr ( checkwordsglobal ( strip_tags ( html_entity_decode($doing ['topic'] ['describtion'] ))), 240, '...' );
					$doing ['url'] = urlmap ( 'topic/getone/' . $doing ['questionid'], 2 );
					break;
				case '14' : //
					
					$doing ['topic'] = $this->gettopic ( $doing ['questionid'] );
					$doing ['title'] = $doing ['topic'] ['title'];
					$doing ['hidden'] = 0;
					$doing ['category'] = $this->get_cat_bycid ( $doing ['topic'] ['articleclassid'] );
					$doing ['categoryname'] = $doing ['category'] ['name'];
					$doing ['cid'] = $doing ['category'] ['id'];
					$doing ['views'] = $doing ['topic'] ['views'];
					$doing ['answers'] = $doing ['topic'] ['articles'];
					$doing ['attentions'] = $doing ['topic'] ['likes'];
					$doing ['content'] = $doing ['topic'] ['title'];
					$doing ['image'] = $doing ['topic'] ['image'];
					$doing ['description'] = cutstr ( checkwordsglobal ( strip_tags ( html_entity_decode($doing ['topic'] ['describtion'] )) ), 240, '...' );
					$doing ['url'] = urlmap ( 'topic/getone/' . $doing ['questionid'], 2 );
					break;
				case '15' : //
					
					$doing ['topic'] = $this->gettopic ( $doing ['questionid'] );
					$doing ['title'] = $doing ['topic'] ['title'];
					$doing ['hidden'] = 0;
					$doing ['category'] = $this->get_cat_bycid ( $doing ['topic'] ['articleclassid'] );
					$doing ['categoryname'] = $doing ['category'] ['name'];
					$doing ['cid'] = $doing ['category'] ['id'];
					$doing ['views'] = $doing ['topic'] ['views'];
					$doing ['answers'] = $doing ['topic'] ['articles'];
					$doing ['attentions'] = $doing ['topic'] ['likes'];
					$doing ['content'] = $doing ['topic'] ['title'];
					$doing ['image'] = $doing ['topic'] ['image'];
					$doing ['description'] = cutstr ( checkwordsglobal ( strip_tags ( $doing ['topic'] ['describtion'] ) ), 240, '...' );
					$doing ['url'] = urlmap ( 'topic/getone/' . $doing ['questionid'], 2 );
					break;
				default :
					$doing ['url'] = urlmap ( 'index', 2 );
					break;
			}
			$doing ['url'] = url ( $doing ['url'] );
			
			if ($doing ['question']) {
				if ($doing ['question'] ['status'] != 0) {
					if ($doing ['hidden'] != 1) {
						$doinglist [] = $doing;
					}
				}
			} else {
				if ($doing ['topic']) {
					if ($doing ['topic'] ['state'] == 1) {
						$doinglist [] = $doing;
					}
				} else {
					$doinglist [] = $doing;
				}
			}
		}
		return $doinglist;
	}
	function list_by_type_andquestionorartilce_cache_num($searchtype='all'){
		$sql = "";
		$uid = $this->user ['uid'] > 0 ? $this->user ['uid'] : 0;
		
		switch ($searchtype) {
			case 'all' :
				$sql .= "select count(doingid) as num from " . $this->db->dbprefix . "doing where action in(1,9)";
				break;
			case 'atentto' :
				
				$sql .= "select count(d.doingid) as num  from " . $this->db->dbprefix . "doing as d," . $this->db->dbprefix . "user_attention as u where d.authorid=u.uid and u.followerid=$uid and d.action in(1,9)";
				break;
		}
		
		$mynum = $this->db->query ( $sql )->row_array ();
		if($mynum){
			return $mynum['num'];
		}else{
			return 0;
		}
	}
	function list_by_type_andquestionorartilce_cache($start = 0, $limit = 20,$searchtype='all') {
		$sql = "";
		$uid = $this->user ['uid'] > 0 ? $this->user ['uid'] : 0;

		switch ($searchtype) {
			case 'all' :
				$sql .= "select * from " . $this->db->dbprefix . "doing where action in(1,9)";
				break;
			case 'atentto' :
				
				$sql .= "select d.* from " . $this->db->dbprefix . "doing as d," . $this->db->dbprefix . "user_attention as u where d.authorid=u.uid and u.followerid=$uid and d.action in(1,2,3,6,9)";
				break;
		}
		
		$sql .= " ORDER BY createtime DESC LIMIT $start,$limit";
		$query = $this->db->query ( $sql );
		foreach ( $query->result_array () as $doing ) {
			
			$doing ['doing_time'] = tdate ( $doing ['createtime'] );
		
			$doing ['avatar'] = get_avatar_dir ( $doing ['authorid'] );
			$doing ['actiondesc'] = $this->actiontable [$doing ['action']];
		
			
			// var $actiontable = array(
			// '1' => '提出了问题',
			// '2' => '回答了该问题',
			// '3' => '评论该回答',
			// '4' => '关注了该问题',
			// '5' => '赞同了该回答',
			// '6' => '对该回答进行了追问',
			// '7' => '继续回答了该问题',
			// '8' => '采纳了回答',
			// '9' => '发布了文章',
			// '10' => '关注了专题',
			// '11' => '关注了用户',
			// '12' => '注册了网站'
			// );
			// $question['url'] = url('question/view/' . $question['id'], $question['url']);
			switch ($doing ['action']) {
				case '1' : // 提出了问题
					$doing ['question'] = $this->getquestionbyqid ( $doing ['questionid'] );
					$doing ['category'] = $this->get_cat_bycid ( $doing ['question'] ['cid'] );
					$doing ['categoryname'] = $doing ['category'] ['name'];
					$doing ['cid'] = $doing ['category'] ['id'];
					$doing ['title'] = $doing ['question'] ['title'];
					$doing ['hidden'] = $doing ['question'] ['hidden'];
					$doing ['views'] = $doing ['question'] ['views'];
					$doing ['answers'] = $doing ['question'] ['answers'];
					$doing ['attentions'] = $doing ['question'] ['attentions'];
					$doing ['content'] = $doing ['question'] ['title'];
					$doing ['image'] = getfirstimg ( htmlspecialchars_decode($doing['question']['description'] ));
// 					if ($doing ['image']) {
// 						$source_info = getimagesize ( $doing ['image'] ); // 图片信息
// 						$source_w = $source_info[0]; // 图片宽度
// 						$source_h = $source_info[1]; // 图片高度
// 						if ($source_w < 160 || $source_h < 120) {
// 							$doing ['image'] = null;
// 						}
// 					}
					
					$doing ['description'] =  clearhtml(checkwordsglobal ( strip_tags (htmlspecialchars_decode( $doing ['question'] ['description']  ))));
					$doing ['url'] = urlmap ( 'question/view/' . $doing ['questionid'], 2 );
					break;
				
				case '9' : // 发布了文章
					
					$doing ['topic'] = $this->gettopic ( $doing ['questionid'] );
					$doing ['title'] = $doing ['topic'] ['title'];
					$doing ['hidden'] = 0;
					$doing ['category'] = $this->get_cat_bycid ( $doing ['topic'] ['articleclassid'] );
					$doing ['categoryname'] = $doing ['category'] ['name'];
					$doing ['cid'] = $doing ['category'] ['id'];
					$doing ['views'] = $doing ['topic'] ['views'];
					$doing ['answers'] = $doing ['topic'] ['articles'];
					$doing ['attentions'] = $doing ['topic'] ['likes'];
					$doing ['image'] = $doing ['topic'] ['image'];
					$doing['content']=$doing ['title'] ;
					$tmp= getfirstimg ( $doing ['topic'] ['describtion'] );
					if($tmp){
						$doing ['image'] =$tmp;
					}
					if( $doing ['topic'] ['readmode']!=1){
						$doing ['description'] = clearhtml ( checkwordsglobal ( strip_tags ( html_entity_decode($doing ['topic'] ['freeconent'] ) )), 120 );
						
					}else{
						$doing ['description'] = clearhtml ( checkwordsglobal ( strip_tags ( html_entity_decode( $doing ['topic'] ['describtion'] )) ), 120 );
						
					}
				
					$doing ['url'] = urlmap ( 'topic/getone/' . $doing ['questionid'], 2 );
					
					break;
				
				default :
					$doing ['url'] = urlmap ( 'index', 2 );
					break;
			}
			$doing ['url'] = url ( $doing ['url'] );
			if ($doing ['question']) {
				if ($doing ['question'] ['status'] != 0) {
					if($doing['hidden']==1){
						$doing['avatar']=SITE_URL."static/css/default/avatar.gif";
						$doing['author']="匿名用户";
					}
					$doinglist [] = $doing;
					
				}
			} else {
				if ($doing ['topic']) {
					if ($doing ['topic'] ['state'] == 1) {
						$doinglist [] = $doing;
					}
				} else {
					$doinglist [] = $doing;
				}
			}
		}
		return $doinglist;
	}
	function list_by_type_cache($searchtype = 'all', $uid = 0, $start = 0, $limit = 20) {
		$sql = "";
		$uid = intval ( $uid );
		switch ($searchtype) {
			case 'all' :
				$sql .= "select * from " . $this->db->dbprefix . "doing where  action in(1,2,3,6,9,11)";
				break;
			case 'my' :
				$sql .= "select * from " . $this->db->dbprefix . "doing where authorid=$uid ";
				break;
			case 'attento' :
				$sql .= "select d.* from " . $this->db->dbprefix . "doing as d," . $this->db->dbprefix . "user_attention as u where d.authorid=u.followerid and u.uid=$uid and action in(1,2,3,6,9,11) ";
				break;
		}
		
		$sql .= " ORDER BY createtime DESC LIMIT $start,$limit";
		
		$query = $this->db->query ( $sql );
		foreach ( $query->result_array () as $doing ) {
			
			$doing ['doing_time'] = tdate ( $doing ['createtime'] );
			$doing ['user'] = $this->get_by_uid ( $doing ['authorid'] );
			$doing ['avatar'] = get_avatar_dir ( $doing ['authorid'] );
			$doing ['actiondesc'] = $this->actiontable [$doing ['action']];
			$doing ['followerlist'] = $this->get_follower ( $doing ['questionid'] );
			if ($doing ['refer_authorid']) {
				$doing ['refer_avatar'] = get_avatar_dir ( $doing ['refer_authorid'] );
			}
			
			// var $actiontable = array(
			// '1' => '提出了问题',
			// '2' => '回答了该问题',
			// '3' => '评论该回答',
			// '4' => '关注了该问题',
			// '5' => '赞同了该回答',
			// '6' => '对该回答进行了追问',
			// '7' => '继续回答了该问题',
			// '8' => '采纳了回答',
			// '9' => '发布了文章',
			// '10' => '关注了专题',
			// '11' => '关注了用户',
			// '12' => '注册了网站'
			// );
			// $question['url'] = url('question/view/' . $question['id'], $question['url']);
			switch ($doing ['action']) {
				case '1' : // 提出了问题
					$doing ['question'] = $this->getquestionbyqid ( $doing ['questionid'] );
					$doing ['content'] = $doing ['question'] ['title'];
					$doing ['description'] = clearhtml(checkwordsglobal ( strip_tags (htmlspecialchars_decode( $doing ['question'] ['description'] ) )));
					$doing ['url'] = urlmap ( 'question/view/' . $doing ['questionid'], 2 );
					break;
				case '2' : //
					$doing ['question'] = $this->getquestionbyqid ( $doing ['questionid'] );
					$doing ['content'] = $doing ['question'] ['title'];
					$doing ['description'] =  clearhtml(checkwordsglobal ( strip_tags (htmlspecialchars_decode( $doing ['question'] ['description'] ) )));
					$doing ['url'] = urlmap ( 'question/view/' . $doing ['questionid'], 2 );
					break;
				case '3' : // /
					$doing ['question'] = $this->getquestionbyqid ( $doing ['questionid'] );
					$doing ['content'] = $doing ['question'] ['title'];
					$doing ['description'] =  clearhtml(checkwordsglobal ( strip_tags (htmlspecialchars_decode($doing ['question'] ['description'] ) )));
					$doing ['url'] = urlmap ( 'question/view/' . $doing ['questionid'], 2 );
					break;
				case '4' : //
					$doing ['question'] = $this->getquestionbyqid ( $doing ['questionid'] );
					$doing ['content'] = $doing ['question'] ['title'];
					$doing ['description'] = clearhtml(checkwordsglobal ( strip_tags (htmlspecialchars_decode($doing ['question'] ['description'] ) )));
					$doing ['url'] = urlmap ( 'question/view/' . $doing ['questionid'], 2 );
					break;
				case '5' : //
					$doing ['question'] = $this->getquestionbyqid ( $doing ['questionid'] );
					$doing ['content'] = $doing ['question'] ['title'];
					$doing ['description'] =  clearhtml(checkwordsglobal ( strip_tags (htmlspecialchars_decode( $doing ['question'] ['description'] ) )));
					$doing ['url'] = urlmap ( 'question/view/' . $doing ['questionid'], 2 );
					break;
				case '6' : //
					$doing ['question'] = $this->getquestionbyqid ( $doing ['questionid'] );
					$doing ['content'] = $doing ['question'] ['title'];
					$doing ['description'] =  clearhtml(checkwordsglobal ( strip_tags (htmlspecialchars_decode($doing ['question'] ['description'] ) )));
					$doing ['url'] = urlmap ( 'question/view/' . $doing ['questionid'], 2 );
					break;
				case '7' : //
					$doing ['question'] = $this->getquestionbyqid ( $doing ['questionid'] );
					$doing ['content'] = $doing ['question'] ['title'];
					$doing ['description'] = clearhtml(checkwordsglobal ( strip_tags (htmlspecialchars_decode($doing ['question'] ['description'] ) )));
					$doing ['url'] = urlmap ( 'question/view/' . $doing ['questionid'], 2 );
					break;
				case '8' : //
					$doing ['question'] = $this->getquestionbyqid ( $doing ['questionid'] );
					$doing ['content'] = $doing ['question'] ['title'];
					$doing ['description'] = clearhtml(checkwordsglobal ( strip_tags (htmlspecialchars_decode( $doing ['question'] ['description'] ) )));
					$doing ['url'] = urlmap ( 'question/view/' . $doing ['questionid'], 2 );
					break;
				case '9' : //
					$doing ['topic'] = $this->gettopic ( $doing ['questionid'] );

						$doing ['title'] = $doing ['topic'] ['title'];
					$doing ['views'] = $doing ['topic'] ['views'];
					$doing ['answers'] = $doing ['topic'] ['articles'];
					$doing ['attentions'] = $doing ['topic'] ['likes'];
					$doing ['content'] = $doing ['topic'] ['title'];
					$doing ['image'] = getfirstimg ( $doing ['topic'] ['describtion'] );
					$doing ['description'] = cutstr ( checkwordsglobal ( strip_tags ( html_entity_decode($doing ['topic'] ['describtion']) ) ), 240, '...' );
					$doing ['url'] = urlmap ( 'topic/getone/' . $doing ['questionid'], 2 );
					break;
				case '10' : //
					$doing ['url'] = urlmap ( 'category/view/' . $doing ['questionid'], 2 );
					break;
				case '11' : //
					$doing ['spaceuser'] = $this->get_by_uid ( $doing ['questionid'] );
					$doing ['url'] = urlmap ( 'user/space/' . $doing ['questionid'], 2 );
					break;
				case '12' : //
					$doing ['url'] = urlmap ( 'index', 2 );
					break;
				case '13' : //
					
					$doing ['topic'] = $this->gettopic ( $doing ['questionid'] );
					$doing ['title'] = $doing ['topic'] ['title'];
					$doing ['views'] = $doing ['topic'] ['views'];
					$doing ['answers'] = $doing ['topic'] ['articles'];
					$doing ['attentions'] = $doing ['topic'] ['likes'];
					$doing ['content'] = $doing ['topic'] ['title'];
					$doing ['image'] = getfirstimg ( $doing ['topic'] ['describtion'] );
					$doing ['description'] = cutstr ( checkwordsglobal ( strip_tags (html_entity_decode($doing ['topic'] ['describtion'] )) ), 240, '...' );
					$doing ['url'] = urlmap ( 'topic/getone/' . $doing ['questionid'], 2 );
					break;
				case '14' : //
					
					$doing ['topic'] = $this->gettopic ( $doing ['questionid'] );
					$doing ['title'] = $doing ['topic'] ['title'];
					$doing ['views'] = $doing ['topic'] ['views'];
					$doing ['answers'] = $doing ['topic'] ['articles'];
					$doing ['attentions'] = $doing ['topic'] ['likes'];
					$doing ['content'] = $doing ['topic'] ['title'];
					$doing ['image'] = getfirstimg ( $doing ['topic'] ['describtion'] );
					$doing ['description'] = cutstr ( checkwordsglobal ( strip_tags ( html_entity_decode($doing ['topic'] ['describtion'] )) ), 240, '...' );
					$doing ['url'] = urlmap ( 'topic/getone/' . $doing ['questionid'], 2 );
					break;
				case '15' : //
					
					$doing ['topic'] = $this->gettopic ( $doing ['questionid'] );
					$doing ['title'] = $doing ['topic'] ['title'];
					$doing ['views'] = $doing ['topic'] ['views'];
					$doing ['answers'] = $doing ['topic'] ['articles'];
					$doing ['attentions'] = $doing ['topic'] ['likes'];
					$doing ['content'] = $doing ['topic'] ['title'];
					$doing ['image'] = getfirstimg ( $doing ['topic'] ['describtion'] );
					$doing ['description'] = cutstr ( checkwordsglobal ( strip_tags ( html_entity_decode($doing ['topic'] ['describtion'] ) )), 240, '...' );
					$doing ['url'] = urlmap ( 'topic/getone/' . $doing ['questionid'], 2 );
					break;
				default :
					$doing ['url'] = urlmap ( 'index', 2 );
					break;
			}
			$doing ['url'] = url ( $doing ['url'] );
			if ($doing ['question']) {
				if ($doing ['question'] ['status'] != 0) {
					if ($doing ['hidden'] != 1) {
						$doinglist [] = $doing;
					}
				}
			} else {
				if ($doing ['topic']) {
					if ($doing ['topic'] ['state'] == 1) {
						$doinglist [] = $doing;
					}
				} else {
					$doinglist [] = $doing;
				}
			}
		}
		return $doinglist;
	}
	// 删除动态
	function deletedoing($uid, $type, $typeid) {
		$this->db->where ( array (
				'authorid' => $uid,
				'action' => $type,
				'questionid' => $typeid 
		) )->delete ( 'doing' );
	}
	/* 获取问题管理者列表信息 */
	function get_follower($qid, $start = 0, $limit = 16) {
		$followerlist = array ();
		$query = $this->db->where ( array (
				'qid' => $qid 
		) )->order_by ( 'time DESC' )->limit ( $limit, $start )->get ( 'question_attention' );
		foreach ( $query->result_array () as $follower ) {
			$follower ['avatar'] = get_avatar_dir ( $follower ['followerid'] );
			;
			$followerlist [] = $follower;
		}
		return $followerlist;
	}
	function rownum_by_type($searchtype = 'all', $uid = 0) {
		$sql = "";
		$uid = intval ( $uid );
		switch ($searchtype) {
			case 'all' :
				$sql .= "select count(questionid) as num from " . $this->db->dbprefix . "doing where action in(1,2,3,6,9,11)";
				break;
			case 'my' :
				$sql .= "select count(questionid)  as num from " . $this->db->dbprefix . "doing where authorid=$uid ";
				break;
			case 'atentto' :
				$sql .= "select count(d.questionid) as num  from " . $this->db->dbprefix . "doing as d," . $this->db->dbprefix . "user_attention as u where d.authorid=u.uid and u.followerid=$uid and action in(1,2,3,6,9,11)";
				break;
			default :
				$sql .= "select count(questionid) as num  from " . $this->db->dbprefix . "doing ";
				break;
		}
		$query = $this->db->query ( $sql );
		$m = $query->row_array ();
		return $m ['num'];
	}
	function getquestionbyqid($id) {
		$id = intval ( $id );
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "question WHERE id='$id'" );
		$question = $query->row_array ();
		return $question;
	}
	/**
	 * 推荐关注用户
	 */
	function recommend_user($limit = 6) {
		$this->load->model ( "user_model" );
		$userlist = array ();
		$usercount = $this->db->count_all ( "user" );
		if ($usercount > 100) {
			$usercount = 101;
		}
		$start = rand ( 0, $usercount - 1 );
		$loginuid = $this->user ['uid'];
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user  WHERE uid<>$loginuid AND uid NOT IN (SELECT uid FROM " . $this->db->dbprefix . "user_attention WHERE followerid=$loginuid)  ORDER BY followers DESC,answers DESC,regtime DESC LIMIT $start,$limit " );
		foreach ( $query->result_array () as $usermodel ) {
			$usermodel ['avatar'] = get_avatar_dir ( $usermodel ['uid'] );
			$usermodel ['is_follow'] = $this->is_followed ( $usermodel ['uid'], $loginuid );
			$usermodel ['category'] = $this->user_model->get_category ( $usermodel ['uid'] );
			$userlist [] = $usermodel;
		}
		return $userlist;
	}
	/* 是否关注问题 */
	function is_followed($uid, $followerid) {
		$uid = intval ( $uid );
		$followerid = intval ( $followerid );
		$query = $this->db->query ( "SELECT COUNT(*) as num FROM " . $this->db->dbprefix . "user_attention WHERE uid=$uid AND followerid=$followerid" );
		$result = $query->row_array ();
		return $result ['num'];
	}
}
