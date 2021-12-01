<?php

class Question_model extends CI_Model {

	var $search;
	var $index;
	var $statustable = array ('all' => ' AND status in (1,2,6,9) ', '0' => ' AND status=0', '1' => ' AND status=1', '2' => ' AND status=2', '6' => ' AND status=6', '4' => ' AND status=1 AND price>0', '9' => ' AND status=9' );
	var $ordertable = array ('all' => 'AND status in (1,2,6,9) ORDER BY time DESC', '0' => ' AND status=0  ORDER BY time DESC', '1' => ' AND status=1  ORDER BY time DESC', '2' => ' AND status=2  ORDER BY  time DESC', '6' => ' AND status=6  ORDER BY time DESC,shangjin DESC,hasvoice DESC', '4' => ' AND status=1 AND price>0 ORDER BY time DESC, price DESC', '9' => ' AND status=9  ORDER BY time DESC,shangjin DESC,hasvoice DESC' );

	function __construct() {
		parent::__construct ();
		$this->load->database ();

		if ($this->base->setting ['xunsearch_open']) {
			require_once $this->base->setting ['xunsearch_sdk_file'];

			$xs = new XS ( XUNSEARCH_QUESTIONFILE );

			$this->search = $xs->search;

			$this->index = $xs->index;
		}
		
	}
	//设为已解决
	function change_to_solve($qids) {
		$overdue_days = intval ( $this->base->setting ['overdue_days'] );
		$endtime = $this->base->time + $overdue_days * 86400;
		$adoptime = $this->base->time;
		$qids=explode(',', $qids);
		foreach ( $qids as $qid ) {
			
			//先判断是否已经有采纳回答
			$adoptanswer = $this->db->query ( "SELECT id,qid,supports FROM " . $this->db->dbprefix . "answer WHERE qid='$qid' and adopttime>0 order by supports desc " )->row_array ();
			if (!$adoptanswer) {
				$answer = $this->db->query ( "SELECT id,qid,supports FROM " . $this->db->dbprefix . "answer WHERE qid='$qid' order by supports desc " )->row_array ();
				if ($answer) {
					$aid=$answer['id'];
					$this->db->query ( "UPDATE `" . $this->db->dbprefix . "question` set status=2, `endtime`=$endtime WHERE (status=6 OR status=1 OR status=9) AND answers>0 AND `id`=$qid" );
					$this->db->query ( "UPDATE `" . $this->db->dbprefix . "answer` SET `adopttime`=$adoptime WHERE `id`=$aid" );
					
				
				}
				
				}
			}
			
		}
		
	    
		
	
	/* 采纳指定的答案，问题状态变为2 已解决 */

	function adopt($qid, $answer) {
		$time = $this->base->time;
		$ret = $this->db->query ( "UPDATE " . $this->db->dbprefix . "answer SET adopttime='' WHERE  qid=$qid" );
		$ret = $this->db->query ( "UPDATE " . $this->db->dbprefix . "answer SET adopttime='$time' WHERE id=" . $answer ['id'] . " AND qid=$qid" );
		if ($ret) {
			$this->db->query ( "UPDATE " . $this->db->dbprefix . "question SET status=2 ,`endtime`='$time' WHERE id=" . $qid );
			$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET adopts=adopts+1 WHERE  uid=" . $answer ['authorid'] );
		}
		return $ret;
	}
	//设置最佳答案
	function setbestanswer($question) {
		$qid = $question ['id'];
		$time = time ();
		$answer = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "answer WHERE qid=$qid AND status>0 AND adopttime =0  ORDER BY supports DESC,time asc " )->row_array ();
		if ($answer == null) {

			$this->update_status ( $qid, 9 );
			return 0;
		} else {
			$ret = $this->adopt ( $qid, $answer );
			$touid = $answer ['authorid'];
			$quid = $question ['authorid'];

			$cash_fee = intval ( $question ['shangjin'] ) * 100;
			$adoptmoeny = $question ['shangjin'];

			//回答者获得赏金
			//$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET  `jine`=jine+'$cash_fee' WHERE `uid`=$touid" );
			//被采纳获得赏金记录
			//if ($adoptmoeny > 0)
			//	$this->db->query ( "INSERT INTO " . $this->db->dbprefix . "paylog SET type='adoptqid',typeid=$qid,money=$adoptmoeny,openid='',fromuid=$quid,touid=$touid,`time`=$time" ); //增加被采纳记录


			return 1;
		}

	}
	/* 获取问题信息 */

	function get($id) {
		$id=intval($id);
		$query = $this->db->get_where ( 'question', array (
				'id' => $id
		) );
		$question = $query->row_array ();

		if ($question) {
			$question ['format_time'] = tdate ( $question ['time'] );
			$question ['ip'] = formatip ( $question ['ip'] );
			$question ['user'] = $this->get_by_uid ( $question ['authorid'] );
			if ($question ['askuid'] > 0) {
				$question ['askuser'] = $this->get_by_uid ( $question ['askuid'] );
			}
			$question ['author_has_vertify'] = get_vertify_info ( $question ['authorid'] ); //用户是否认证
			$question ['category_name'] = $this->base->category [$question ['cid']] ['name'];
			if ($question ['hidden'] == 1) {
				$question ['author_avartar'] = SITE_URL . 'static/css/default/avatar.gif';
			} else {
				$question ['author_avartar'] = get_avatar_dir ( $question ['authorid'] );
			}
			$question ['title'] = checkwordsglobal ( $question ['title'] );
			$imgs=getfirstimg($question['description']);
			$question ['shortdescription'] =clearhtml(checkwordsglobal ( htmlspecialchars_decode($question ['description'] )),100);
			if(is_array($imgs)&&count($imgs)>=1){
				$question['shortdescription']="[图]".$question ['shortdescription'];
			}
			$question ['artlen']=mb_strlen(strip_tags(checkwordsglobal ( htmlspecialchars_decode($question ['description'] ) )));
			$question ['description'] = checkwordsglobal ($question ['description']  );
		}
		return $question;
	}

	function get_by_title($title) {
		
		$title=addslashes($title);
		$query = $this->db->get_where ( 'question', array (
				'title' => $title
		) );
		$question= $query->row_array ();
		return $question;
		
	}
	function get_by_uid($uid) {
		$uid=intval($uid);
		$query = $this->db->get_where ( 'user', array (
				'uid' => $uid
		) );
		$user= $query->row_array ();
		if($user){
			$user ['avatar'] = get_avatar_dir ( $uid );
			$user ['groupname']=$this->usergroup [$user['groupid']]['grouptitle'];
			return $user;
		}else{
			return null;
		}
		
	
	}
	function get_by_titleanddesc($title, $desc) {
		$title=addslashes($title);
		$desc=addslashes($desc);
		$query = $this->db->get_where ( 'question', array (
				'title' => $title,
				'title' => $title
		) );
		$question= $query->row_array ();
		if($question){
			return $question;
		}else{
			return null;
		}
		
	}
	function get_list($start = 0, $limit = 10) {
		$questionlist = array ();
		$query = $this->db->query ( "SELECT * FROM `" . $this->db->dbprefix . "question` WHERE 1=1 limit $start , $limit" );
		foreach ( $query->result_array () as $question ) {
			$question ['author_has_vertify'] = get_vertify_info ( $question ['authorid'] ); //用户是否认证
			$question ['category_name'] = $this->base->category [$question ['cid']] ['name'];
			$question ['format_time'] = tdate ( $question ['time'] );
			$question ['url'] = url ( 'question/view/' . $question ['id'], $question ['url'] );
			$question ['title'] = checkwordsglobal ( $question ['title'] );
			$question ['description'] = checkwordsglobal ( htmlspecialchars_decode($question ['description'] ) );
			if ($question ['hidden'] == 1) {
				$question ['avatar'] = SITE_URL . 'static/css/default/avatar.gif';
			} else {
				$question ['avatar'] = get_avatar_dir ( $question ['authorid'] );
			}
			$questionlist [] = $question;
		}
		return $questionlist;
	}
	//根据分类获取擅长该话题的人
	function getinvatebycid($cid, $start = 0, $limit = 20) {
		
		$userlist = $this->db->select ( "m.uid,m.username,m.answers,c.name,c.id as cid" )->where ( "c.id", $cid )->from ( 'user m' )->join ( 'user_category as uc', 'uc.uid=m.uid' )->join ( 'category as c', 'c.id=uc.cid' )->order_by ( "m.answers", "desc" )->limit ( $limit, $start )->get ()->result_array ();
		$this->db->distinct ();
		return $userlist;
	}
	//根据分类获取回答过该话题的人
	function getinvatebyanswer($cid, $start = 0, $limit = 20) {
		$userlist = $this->db->select ( "m.uid,m.username,m.answers,c.name,c.id as cid" )->where ( "c.id", $cid )->from ( 'user m' )->join ( 'answer as a', ' a.authorid=m.uid ' )->join ( 'question as q', 'q.id=a.qid' )->join ( 'category as c', 'c.id=q.cid' )->group_by ( "uid" )->limit ( $limit, $start )->get ()->result_array ();

		return $userlist;
	}

	/* 获取问题标签 */

	function get_words($str, $spword = ' ', $strlen = 300) {
		$result = '';
		return $result;
	}

	/* 前台问题搜索 */

	function list_by_condition($condition, $start = 0, $limit = 10) {
		$questionlist = array ();
		$query = $this->db->query ( "SELECT * FROM `" . $this->db->dbprefix . "question` WHERE $condition order by time desc limit $start , $limit" );
		foreach ( $query->result_array () as $question ) {
			$question ['author_has_vertify'] = get_vertify_info ( $question ['authorid'] ); //用户是否认证
			$question ['category_name'] = $this->base->category [$question ['cid']] ['name'];
			$question ['format_time'] = tdate ( $question ['time'] );
			$question ['url'] = url ( 'question/view/' . $question ['id'], $question ['url'] );
			$question ['title'] = checkwordsglobal ( $question ['title'] );
			$question ['description'] = checkwordsglobal (htmlspecialchars_decode($question ['description'] ) );
			if ($question ['hidden'] == 1) {
				$question ['avatar'] = SITE_URL . 'static/css/default/avatar.gif';
			} else {
				$question ['avatar'] = get_avatar_dir ( $question ['authorid'] );
			}
			$questionlist [] = $question;
		}
		return $questionlist;
	}

	function get_hots($start, $limit) {
		$questionlist = array ();
		$timestart = $this->base->time - 7 * 24 * 3600;
		$timeend = $this->base->time;
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "question WHERE status in (1,2) AND  `time`>$timestart AND `time`<$timeend  ORDER BY answers DESC, `time` DESC LIMIT $start,$limit" );
		foreach ( $query->result_array () as $question ) {
			$question ['category_name'] = $this->base->category [$question ['cid']] ['name'];
			$question ['format_time'] = tdate ( $question ['time'] );
			$question ['title'] = checkwordsglobal ( $question ['title'] );
			$question ['description'] = checkwordsglobal ( htmlspecialchars_decode($question ['description'] ) );
			$questionlist [] = $question;
		}
		return $questionlist;
	}
 //统计全部已解决问题
 function getallsolvequestion(){
 	$num=returnarraynum ( $this->db->query ( getwheresql ( 'question', 'status IN (2,6)', $this->db->dbprefix ) )->row_array () );
   return  $num;
 }
 //统计全部待决问题
 function getallnosolvequestion(){
 	$num=returnarraynum ( $this->db->query ( getwheresql ( 'question', 'status in (1) ', $this->db->dbprefix ) )->row_array () );
 	return  $num;
 }
	/* 后台问题数目 */

	function rownum_by_search($title = '', $author = '', $datestart = '', $dateend = '', $status = '', $cid = 0) {
		$title=addslashes($title);
		$author=addslashes($author);
		$datestart=addslashes($datestart);
		$dateend=addslashes($dateend);
		$status=addslashes($status);
		$cid=intval($cid);
		$condition = " 1=1 ";
		$title && ($condition .= " AND `title` like '%$title%' ");
		$author && ($condition .= " AND `author`='$author'");
		$datestart && ($condition .= " AND `time`>= " . strtotime ( $datestart ));
		$dateend && ($condition .= " AND `time`<= " . strtotime ( $dateend ));
		if ($cid) {
			$category = $this->base->category [$cid];
			$condition .= " AND `cid" . $category ['grade'] . "`= $cid ";
		}
		isset ( $this->statustable [$status] ) && $condition .= $this->statustable [$status];
		$query = $this->db->query ( "select count(*) as num from " . $this->db->dbprefix . "question where $condition " );
		$m = $query->row_array ();
		return $m ['num'];

	}

	/* 后台问题搜索 */

	function list_by_search($title = '', $author = '', $datestart = '', $dateend = '', $status = '', $cid = 0, $start = 0, $limit = 10) {
		$title=addslashes($title);
		$author=addslashes($author);
		$datestart=addslashes($datestart);
		$dateend=addslashes($dateend);
		$status=addslashes($status);
		$cid=intval($cid);
		$sql = "SELECT * FROM `" . $this->db->dbprefix . "question` WHERE 1=1 ";
		$title && ($sql .= " AND `title` like '%$title%' ");
		$author && ($sql .= " AND `author`='$author'");
		$datestart && ($sql .= " AND `time` >= " . strtotime ( $datestart ));
		$dateend && ($sql .= " AND `time` <= " . strtotime ( $dateend ));
		if ($cid) {
			$category = $this->base->category [$cid];
			$sql .= " AND `cid" . $category ['grade'] . "`= $cid ";
		}
		isset ( $this->statustable [$status] ) && $sql .= $this->statustable [$status];
		$sql .= " ORDER BY `time` DESC LIMIT $start,$limit";
	
		$questionlist = array ();
		$query = $this->db->query ( $sql );
		foreach ( $query->result_array () as $question ) {
			$question ['author_has_vertify'] = get_vertify_info ( $question ['authorid'] ); //用户是否认证
			$question ['category_name'] = '';
			isset ( $this->base->category [$question ['cid']] ) && $question ['category_name'] = $this->base->category [$question ['cid']] ['name'];
			$question ['format_time'] = tdate ( $question ['time'] );
			$question ['url'] = url ( 'question/view/' . $question ['id'] );
			$question ['title'] = checkwordsglobal ( $question ['title'] );
			$question ['description'] = checkwordsglobal (htmlspecialchars_decode($question ['description'] ) );
			if ($question ['hidden'] == 1) {
				$question ['avatar'] = SITE_URL . 'static/css/default/avatar.gif';
			} else {
				$question ['avatar'] = get_avatar_dir ( $question ['authorid'] );
			}
			$questionlist [] = $question;
		}
		return $questionlist;
	}

	//通过标签获取同类问题
	function list_by_tag($name, $status = '1,2,6', $start = 0, $limit = 20) {
		$name=addslashes($name);
		$questionlist = array ();
		//echo "SELECT * FROM `" . $this->db->dbprefix . "question` AS q," . $this->db->dbprefix . "question_tag AS t WHERE q.id=t.qid AND t.name='$name' AND q.status IN ($status) ORDER BY q.answers DESC,q.time DESC LIMIT $start,$limit";exit();
		$query = $this->db->query ( "SELECT * FROM `" . $this->db->dbprefix . "question` AS q WHERE q.title like '%$name%' and q.status IN ($status) ORDER BY q.answers DESC,q.time DESC LIMIT $start,$limit" );
		foreach ( $query->result_array () as $question ) {
			$question ['category_name'] = $this->base->category [$question ['cid']] ['name'];
			$question ['format_time'] = tdate ( $question ['time'] );

			$question ['avatar'] = get_avatar_dir ( $question ['authorid'] );
			$question ['url'] = url ( 'question/view/' . $question ['id'], $question ['url'] );
			$question ['title'] = checkwordsglobal ( $question ['title'] );
			$question ['image'] = getfirstimg ( htmlspecialchars_decode($question ['description'] ) );
			$question ['description'] = cutstr ( checkwordsglobal ( strip_tags ( htmlspecialchars_decode($question ['description'] ) ) ), 240, '...' );
			$questionlist [] = $question;
		}
		return $questionlist;
	}

	function rownum_by_tag($name, $status = '1,2,6') {
		$name=addslashes($name);
		$m = $this->db->query ( "SELECT count(*) as num FROM `" . $this->db->dbprefix . "question` AS q WHERE q.title like '%$name%' and q.status IN ($status) ORDER BY q.answers DESC" )->row_array ();
		return $m ['num'];
	}

	/* 删除问题和问题的回答 */

	function remove($qids) {
		//删除问题悬赏现金退回用户钱包
		$this->removetuoguan ( $qids );
		$this->db->query ( "DELETE FROM `" . $this->db->dbprefix . "question` WHERE `id` IN ($qids)" );
		$this->db->query ( "DELETE FROM `" . $this->db->dbprefix . "question_tag` WHERE `qid` IN ($qids)" );
		$this->db->query ( "DELETE FROM `" . $this->db->dbprefix . "doing` WHERE `questionid` IN ($qids) and  action in (1,2,3,4,5,6,7,8)" );
		$this->db->query ( "DELETE FROM `" . $this->db->dbprefix . "tag_item` WHERE `typeid` IN ($qids) and itemtype='question'" );
		$this->remove_supply_by_qid ( $qids );
		$this->db->query ( "DELETE FROM `" . $this->db->dbprefix . "answer_comment` WHERE `aid` IN (SELECT id FROM " . $this->db->dbprefix . "answer WHERE `qid` IN($qids))" );
		$this->db->query ( "DELETE FROM `" . $this->db->dbprefix . "answer_support` WHERE `aid` IN (SELECT id FROM " . $this->db->dbprefix . "answer WHERE `qid` IN($qids))" );
		$this->db->query ( "DELETE FROM `" . $this->db->dbprefix . "answer` WHERE `qid` IN ($qids)" );
		$this->db->query ( "DELETE FROM `" . $this->db->dbprefix . "topdata` WHERE `typeid` IN ($qids) and type='qid' " );

		if ($this->base->setting ['xunsearch_open']) {
			$this->index->openBuffer ();
			$this->index->del ( explode ( ",", $qids ) );
			$this->index->closeBuffer ();
		}
	}

	function removetuoguan($qids) {
		$query = $this->db->query ( "SELECT * FROM `" . $this->db->dbprefix . "question` WHERE `id` IN ($qids)" );
		foreach ( $query->result_array () as $question ) {
			$qid = $question ['id'];
			$authorid = $question ['authorid'];
			
			//是否有提问悬赏现金托管
			$model = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user_depositmoney WHERE  type='qid' and typeid=$qid and fromuid=$authorid " )->row_array ();
			
			if ($model) {
				$fromuid = $model ['fromuid'];
				$money = $model ['needpay'] * 100;
				$qtitle="删除问题:".$question['title'];
				$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET  `jine`=jine+'$money' WHERE `uid`=$fromuid" );
				$time = time ();
				$needpay = $model ['needpay'];
				$this->db->query ( "INSERT INTO " . $this->db->dbprefix . "paylog SET type='thqid',typeid=$qid,money=$needpay,beizhu='$qtitle',openid='',fromuid=0,touid=$fromuid,`time`=$time" );
				$this->db->query ( "DELETE FROM `" . $this->db->dbprefix . "user_depositmoney` WHERE fromuid=$fromuid and type='qid' and typeid=$qid" );
			
				$adoptmodel = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "paylog WHERE  type='adoptqid' and typeid=$qid and fromuid=$authorid" )->row_array ();
				if($adoptmodel){
					//如果有采纳，将采纳人的钱也扣了
					$adoptpay=$adoptmodel['money'] * 100;
					$adoptuid=$adoptmodel['touid'];
					$qadoptcontent="扣除问题:".$question['title']."回答作者费用";
					$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET  `jine`=jine-'$adoptpay' WHERE `uid`=$adoptuid" );
				
					$needpay = $adoptmodel['money'] ;
					$this->db->query ( "INSERT INTO " . $this->db->dbprefix . "paylog SET type='thadoptqid',typeid=$qid,money=$needpay,beizhu='$qadoptcontent',openid='',fromuid=0,touid=$adoptuid,`time`=$time" );
				
					
				}
				
			}

			//是否有对专家付费提问
			$model1 = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user_depositmoney WHERE  type='eqid' and typeid=$qid and fromuid=$authorid " )->row_array ();
			if ($model1) {
				$fromuid = $model1 ['fromuid'];
				$money = $model1 ['needpay'] * 100;
				$qtitle="付费咨询问题:".$question['title'];
				$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET  `jine`=jine+'$money' WHERE `uid`=$fromuid" );
				$time = time ();
				$needpay = $model1 ['needpay'];
				$this->db->query ( "INSERT INTO " . $this->db->dbprefix . "paylog SET type='theqid',typeid=$qid,money=$needpay,beizhu='$qtitle',openid='',fromuid=0,touid=$fromuid,`time`=$time" );
				$this->db->query ( "DELETE FROM `" . $this->db->dbprefix . "user_depositmoney` WHERE fromuid=$fromuid and type='eqid' and typeid=$qid" );

			}

		}

	}

	/* 问题列表记录数目 */

	function rownum_by_cfield_cvalue_status($cfield = 'cid1', $cvalue = 0, $status = 0, $paixu = 0) {
         
		$paixuwhrer = '';
		
		switch ($paixu) {
			case 0 : //最新问题
				$paixuwhrer = " ";
				break;
			case 1 : //积分悬赏
				$paixuwhrer = " and price >0  ";
				break;
			case 2 : //现金悬赏
				$status = 'all';
				$paixuwhrer = " and shangjin >0 ";
				break;
			case 3 : //语音回答
				$status = 'all';
				$paixuwhrer = " and hasvoice!=0 ";
				break;
			case 4 : //已解决
				$status = 2;
				$paixuwhrer = " ";
				break;
			case 5: //未解决
				$status = 1;
				$paixuwhrer = "  ";
				break;
			case 6 : //推荐问题
				$status = 6;
				$paixuwhrer = "  ";
				break;
			default :
				$paixuwhrer = " ";
				break;
		}
		$sql = "SELECT count(*) as num FROM " . $this->db->dbprefix . "question WHERE 1=1 and cid!=0   $paixuwhrer ";
		
		($cfield && $cvalue != 'all') && ($sql .= " AND  $cfield=$cvalue ");
		
		isset ( $this->statustable [$status] ) && $sql .= $this->statustable [$status];
		$query = $this->db->query ( $sql );
		$m = $query->row_array ();
		return $m ['num'];

	}

	/* 问题列表，根据指定的分类名称，和分类id，以及status来查询 */

	function list_by_cfield_cvalue_status($cfield = 'cid1', $cvalue = 0, $status = 0, $start = 0, $limit = 10, $paixu = 0) {
	
		$questionlist = array ();
		$paixuwhrer = '';

		switch ($paixu) {
			case 0 : //最新问题
				$paixuwhrer = " ";
				break;
			case 1 : //积分悬赏
				$paixuwhrer = " and price >0  ";
				break;
			case 2 : //现金悬赏
				$status = 'all';
				$paixuwhrer = " and shangjin >0 ";
				break;
			case 3 : //语音回答
				$status = 'all';
				$paixuwhrer = " and hasvoice!=0 ";
				break;
			case 4 : //已解决
				$status = 2;
				$paixuwhrer = " ";
				break;
			case 5: //未解决
				$status = 1;
				$paixuwhrer = "  ";
				break;
			case 6 : //推荐问题
				$status = 6;
				$paixuwhrer = "  ";
				break;
			default :
				$paixuwhrer = " ";
				break;
		}
		$sql = "SELECT * FROM " . $this->db->dbprefix . "question WHERE 1=1 and cid!=0   $paixuwhrer ";

		($cfield && $cvalue != 'all') && ($sql .= " AND  $cfield=$cvalue ");

		isset ( $this->ordertable [$status] ) && $sql .= $this->ordertable [$status];
		$sql .= "  LIMIT $start,$limit";
		

		$query = $this->db->query ( addslashes($sql) );
	
		$qids = $questionTags = [];
		foreach ( $query->result_array () as $question ) {
			if ($question ['cid']) {
				$question ['author_has_vertify'] = get_vertify_info ( $question ['authorid'] ); //用户是否认证
				$question ['category_name'] = $this->base->category [$question ['cid']] ['name'];
				$question ['sortime'] = $question ['time']; //用于排序
				$question ['format_time'] = tdate ( $question ['time'] );
				if ($question ['hidden'] == 1) {
					$question ['avatar'] = SITE_URL . 'static/css/default/avatar.gif';
					$question ['author'] ="匿名用户";
				} else {
					$question ['avatar'] = get_avatar_dir ( $question ['authorid'] );
				
				}
				$question ['questionid'] = $question ['id'];
				$question ['url'] = url ( 'question/view/' . $question ['id'] );
				$question ['title'] = checkwordsglobal ( $question ['title'] );
				$question ['image'] = getfirstimg ( htmlspecialchars_decode($question ['description'] ));
				$question ['images'] = getfirstimgs ( htmlspecialchars_decode($question ['description'] ) );
				$question ['description'] = clearhtml ( htmlspecialchars_decode($question ['description'] ),100 );
				$qids[] = $question['id'];
				$question ['tags'] = [];
				if ($question ['askuid'] > 0) {
					$question ['askuser'] = $this->get_by_uid ( $question ['askuid'] );
				}

				$questionlist [] = $question;
			}
		}
		if (!empty($qids)) {
			$questionTags = $this->get_by_qid_all($qids);
		}
		if (!empty($questionTags)) {
			foreach ($questionTags as $qv) {
				foreach ($questionlist as $key => $qlv) {
					if ($qlv['questionid'] == $qv['typeid']) {
						$questionlist[$key]['tags'][] = $qv;
					}
				}
			}
		}
		return $questionlist;
	}

	/* 问题列表，现金悬赏 */

	function list_by_shangjin($start = 0, $limit = 10) {
		$questionlist = array ();
		$sql = "SELECT * FROM " . $this->db->dbprefix . "question WHERE 1=1 and  shangjin>0 order by time desc";

		$sql .= " LIMIT $start,$limit";
		$query = $this->db->query ( $sql );
		$qids = $questionTags = [];
		foreach ( $query->result_array () as $question ) {
			$question ['author_has_vertify'] = get_vertify_info ( $question ['authorid'] ); //用户是否认证
			$question ['category_name'] = $this->base->category [$question ['cid']] ['name'];
			$question ['format_time'] = tdate ( $question ['time'] );
			$question ['avatar'] = get_avatar_dir ( $question ['authorid'] );
			$question ['url'] = url ( 'question/view/' . $question ['id'] );
			$question ['title'] = checkwordsglobal ( $question ['title'] );
			$qids[] = $question['id'];
			$question ['tags'] = [];
			if ($question ['askuid'] > 0) {
				$question ['askuser'] = $this->get_by_uid ( $question ['askuid'] );
			}

			$question ['description'] = checkwordsglobal ( htmlspecialchars_decode($question ['description'] ) );
			$questionlist [] = $question;
		}
		if (!empty($qids)) {
			$questionTags = $this->get_by_qid_all($qids);
		}
		if (!empty($questionTags)) {
			foreach ($questionTags as $qv) {
				foreach ($questionlist as $key => $qlv) {
					if ($qlv['questionid'] == $qv['typeid']) {
						$questionlist[$key]['tags'][] = $qv;
					}
				}
			}
		}
		return $questionlist;
	}
	/* 问题列表，语音回答 */

	function list_by_yuyin($start = 0, $limit = 10) {
		$questionlist = array ();
		$sql = "SELECT * FROM " . $this->db->dbprefix . "question WHERE 1=1 and  hasvoice>0 order by time desc";

		$sql .= " LIMIT $start,$limit";
		$query = $this->db->query ( $sql );
		$qids = $questionTags = [];
		foreach ( $query->result_array () as $question ) {
			$question ['author_has_vertify'] = get_vertify_info ( $question ['authorid'] ); //用户是否认证
			$question ['category_name'] = $this->base->category [$question ['cid']] ['name'];
			$question ['format_time'] = tdate ( $question ['time'] );
			$question ['avatar'] = get_avatar_dir ( $question ['authorid'] );
			$question ['url'] = url ( 'question/view/' . $question ['id'], $question ['url'] );
			$question ['title'] = checkwordsglobal ( $question ['title'] );
			$qids[] = $question['id'];
			$question ['tags'] = [];
			if ($question ['askuid'] > 0) {
				$question ['askuser'] = $this->get_by_uid ( $question ['askuid'] );
			}

			$question ['description'] = checkwordsglobal ( htmlspecialchars_decode($question ['description'] ));
			$questionlist [] = $question;
		}
		if (!empty($qids)) {
			$questionTags = $this->get_by_qid_all($qids);
		}
		if (!empty($questionTags)) {
			foreach ($questionTags as $qv) {
				foreach ($questionlist as $key => $qlv) {
					if ($qlv['questionid'] == $qv['typeid']) {
						$questionlist[$key]['tags'][] = $qv;
					}
				}
			}
		}
		return $questionlist;
	}
	/* 标签 */
	function get_by_qid($qid) {
		$qid=intval($qid);
		$taglist = array ();

		$query = $this->db->query ( "select at.id,at.tagname,at.tagalias from " . $this->db->dbprefix . "tag as at," . $this->db->dbprefix . "tag_item as ati where ati.tagid=at.id and ati.typeid=$qid and ati.itemtype='question'  LIMIT 0,5" );
		foreach ( $query->result_array () as $tag ) {
			$taglist [] = $tag;
		}
		return $taglist;
	}
	function get_by_qid_all($qids) {
		$taglist = array();
		$c = [];
		if (!empty($qids)) {
			$query = $this->db->query("select at.id,at.tagname,at.tagalias,ati.typeid from " . $this->db->dbprefix . "tag_item as ati left join " . $this->db->dbprefix . "tag as at on ati.tagid=at.id where ati.typeid in (" . implode(',', $qids) . ") and ati.itemtype='question'");
			//            error_log("select at.id,at.tagname,at.tagalias,ati.typeid from " . $this->db->dbprefix . "tag_item as ati left join " . $this->db->dbprefix . "tag as at on ati.tagid=at.id where ati.typeid in (" . implode(',', $qids) . ") and ati.itemtype='question'  LIMIT 0,5\n",3,'/tmp/eask.log');
			foreach ($query->result_array() as $tag) {
				if(!empty($c[$tag['typeid']]) && count($c[$tag['typeid']]) >=5){
					continue;
				}else{
					$c[$tag['typeid']][] = 1;
					$taglist [] = $tag;
				}
			}
		}
		return $taglist;
	}
	/* 我的所有提问，用户中心 */

	function list_by_uid($uid, $status, $start = 0, $limit = 10) {
		$uid=intval($uid);
		$status=addslashes($status);
		$questionlist = array ();
		$where='';
		if($this->user['uid']!=$uid){
			$where=' hidden!=1 and ';
		}
		$sql = 'SELECT * FROM ' . $this->db->dbprefix . 'question WHERE'. $where. '`authorid` = ' . $uid;
		$sql .= $this->statustable [$status] . " ORDER BY `time` DESC LIMIT $start , $limit";
		$query = $this->db->query ( $sql );
		foreach ( $query->result_array () as $question ) {
			$question ['category_name'] = isset ( $this->base->category [$question ['cid']] ) && $this->base->category [$question ['cid']] ['name'];
			if (intval ( $question ['endtime'] )) {
				$question ['format_endtime'] = tdate ( $question ['endtime'] );
			}
			$question ['author_has_vertify'] = get_vertify_info ( $question ['authorid'] ); //用户是否认证
			$question ['format_time'] = tdate ( $question ['time'] );
			$question ['url'] = url ( 'question/view/' . $question ['id'] );
			$question ['title'] = checkwordsglobal ( $question ['title'] );
			$question ['image'] = getfirstimg ( htmlspecialchars_decode($question ['description'] ));
			$question ['avatar'] = get_avatar_dir ( $question ['authorid'] );
			$question ['description'] = cutstr ( checkwordsglobal ( strip_tags ( htmlspecialchars_decode($question ['description'] ) ) ), 240, '...' );
			$questionlist [] = $question;
		}
		return $questionlist;
	}

	/* 插入问题到question表 */

	function add($title, $description, $hidanswer, $price, $cid, $cid1 = 0, $cid2 = 0, $cid3 = 0, $status = 0, $shangjin = 0, $askfromuid = 0) {
		$overdue_days = intval ( $this->base->setting ['overdue_days'] );
		$creattime = $this->base->time;
		$endtime = $this->base->time + $overdue_days * 86400;
		$uid = $this->base->user ['uid'];
		$username = $uid ? $this->base->user ['username'] : $this->base->user ['ip'];
		//(! strip_tags ( $description, '<img>' )) && $description = '';
		/* 分词索引 */
		$data = array ('cid' => $cid, 'cid1' => $cid1, 'cid2' => $cid2, 'cid3' => $cid3, 'askuid' => $askfromuid, 'authorid' => $uid, 'shangjin' => $shangjin, 'author' => $username, 'title' => $title, 'description' => $description, 'price' => $price, 'time' => $creattime, 'endtime' => $endtime, 'hidden' => $hidanswer, 'status' => $status, 'ip' => getip () );
		
		$this->db->insert ( 'question', $data );
		//$this->db->query ( "INSERT INTO " . $this->db->dbprefix . "question SET cid='$cid',cid1='$cid1',cid2='$cid2',cid3='$cid3',askuid='$askfromuid',authorid='$uid',shangjin='$shangjin',author='$username',title='$title',description='$description',price='$price',time='$creattime',endtime='$endtime',hidden='$hidanswer',status='$status',ip='{$this->base->ip}'" );
		$qid = $this->db->insert_id ();
		if ($this->base->setting ['xunsearch_open'] && $qid) {
			$question = array ();
			$question ['id'] = $qid;
			$question ['cid'] = $cid;
			$question ['cid1'] = $cid1;
			$question ['cid2'] = $cid2;
			$question ['cid3'] = $cid3;
			$question ['author'] = $username;
			$question ['authorid'] = $uid;
			$question ['answers'] = 0;
			$question ['price'] = $price;
			$question ['attentions'] = 1;
			$question ['shangjin'] = $shangjin;
			$question ['status'] = $status;
			$question ['time'] = $creattime;
			$question ['title'] = checkwordsglobal ( $title );
			$question ['description'] = checkwordsglobal ( htmlspecialchars_decode($description ) );
			$doc = new XSDocument ();
			$doc->setFields ( $question );
			$this->index->openBuffer ();
			$this->index->update ( $doc )->flushIndex ();
			$this->index->closeBuffer ();
		}
		$cid1 = intval ( $cid1 );
		$cid2 = intval ( $cid2 );
		$cid3 = intval ( $cid3 );
		$this->db->query ( "UPDATE " . $this->db->dbprefix . "category SET questions=questions+1 WHERE  id IN ($cid1,$cid2,$cid3) " );
		$uid && $this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET questions=questions+1 WHERE  uid =$uid" );
		return $qid;
	}
	function addapp($uid1, $username1, $title, $description, $hidanswer, $price, $cid, $devicename = '网站', $cid1 = 0, $cid2 = 0, $cid3 = 0, $status = 0) {
		$overdue_days = intval ( $this->base->setting ['overdue_days'] );
		$creattime = $this->base->time;
		$endtime = $this->base->time + $overdue_days * 86400;
		$uid = $uid1; // $this->base->user['uid'];
		$username = $username1; // $uid ? $this->base->user['username'] : $this->base->user['ip'];
		(! strip_tags ( $description, '<img>' )) && $description = '';
		$inserdata=array(
				'cid'=>$cid,
				'devicename'=>$devicename,
				'cid1'=>$cid1,
				'cid2'=>$cid2,
				'cid3'=>$cid3,
				'authorid'=>$uid,
				'author'=>$username,
				'title'=>$title,
				'description'=>$description,
				'price'=>$price,
				'time'=>$creattime,
				'endtime'=>$endtime,
				'hidden'=>$hidanswer,
				'status'=>$status,
				'ip'=>getip()
		);
		/* 分词索引 */
		$this->db->insert('question',$inserdata);
		$qid = $this->db->insert_id ();
		if ($this->base->setting ['xunsearch_open'] && $qid) {
			$question = array ();
			$question ['id'] = $qid;
			$question ['cid'] = $cid;
			$question ['cid1'] = $cid1;
			$question ['cid2'] = $cid2;
			$question ['cid3'] = $cid3;
			$question ['author'] = $username;
			$question ['devicename'] = $devicename;
			$question ['authorid'] = $uid;
			$question ['answers'] = 0;
			$question ['price'] = $price;
			$question ['attentions'] = 1;
			$question ['shangjin'] = 0;
			$question ['status'] = $status;
			$question ['time'] = $creattime;
			$question ['title'] = $title;
			$question ['description'] = $description;
			$doc = new XSDocument ();
			$doc->setFields ( $question );
			$this->index->openBuffer ();
			$this->index->update ( $doc )->flushIndex ();
			$this->index->closeBuffer ();
		}
		$cid1 = intval ( $cid1 );
		$cid2 = intval ( $cid2 );
		$cid3 = intval ( $cid3 );
		$this->db->query ( "UPDATE " . $this->db->dbprefix . "category SET questions=questions+1 WHERE  id IN ($cid1,$cid2,$cid3) " );
		$uid && $this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET questions=questions+1 WHERE  uid =$uid" );
		return $qid;
	}
	/* 插入问题到question表 */

	function add_seo($title, $uid1, $username1, $description, $hidanswer, $price, $cid, $cid1 = 0, $cid2 = 0, $cid3 = 0, $status = 0, $view = 10, $mtime = 1409637582) {
		$overdue_days = intval ( $this->base->setting ['overdue_days'] );
		$creattime = $mtime; //$this->base->time;
		$endtime = $mtime + $overdue_days * 86400; // $this->base->time + $overdue_days * 86400;
		$uid = $uid1; // $this->base->user['uid'];
		$username = $uid ? $username1 :getip();
		//(!strip_tags($description, '<img>')) && $description = '';
		//  echo "INSERT INTO " . $this->db->dbprefix . "question SET cid='$cid',cid1='$cid1',cid2='$cid2',cid3='$cid3',authorid='$uid',author='$username',title='$title',description='$description',price='$price',time='$creattime',endtime='$endtime',hidden='$hidanswer',views='$view',status='$status',ip='{$this->base->ip}'";
		/* 分词索引 */
		$dataquestion=array('views'=>$view,'cid'=>$cid,'cid1'=>$cid1,'cid2'=>$cid2,'cid3'=>$cid3,'authorid'=>$uid,'author'=>$username,'title'=>$title,'description'=>$description,'price'=>$price,'time'=>$creattime,'endtime'=>$endtime,'hidden'=>$hidanswer,'status'=>$status,'ip'=>getip());
		$this->db->insert('question',$dataquestion);
	
		$qid = $this->db->insert_id ();
		if ($this->base->setting ['xunsearch_open'] && $qid) {
			$question = array ();
			$question ['id'] = $qid;
			$question ['cid'] = $cid;
			$question ['cid1'] = $cid1;
			$question ['cid2'] = $cid2;
			$question ['cid3'] = $cid3;
			$question ['author'] = $username;
			$question ['authorid'] = $uid;
			$question ['answers'] = 0;
			$question ['price'] = $price;
			$question ['attentions'] = 1;
			$question ['shangjin'] = 0;
			$question ['status'] = $status;
			$question ['views'] = $view;
			$question ['time'] = $creattime;
			$question ['title'] = $title;
			$question ['description'] =htmlspecialchars_decode($description ) ;
			$doc = new XSDocument ();
			$doc->setFields ( $question );
			$this->index->openBuffer ();
			$this->index->update ( $doc )->flushIndex ();
			$this->index->closeBuffer ();
		}
		$cid1 = intval ( $cid1 );
		$cid2 = intval ( $cid2 );
		$cid3 = intval ( $cid3 );
		$this->db->query ( "UPDATE " . $this->db->dbprefix . "category SET questions=questions+1 WHERE  id IN ($cid1,$cid2,$cid3) " );
		$uid && $this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET questions=questions+1 WHERE  uid =$uid" );
		return $qid;
	}
	function update($id, $title, $description, $hidanswer, $price, $status, $cid, $cid1 = 0, $cid2 = 0, $cid3 = 0, $time = 0) {
		$overdue_days = intval ( $this->base->setting ['overdue_days'] );
		$asktime = strtotime ( $time );
		$endtime = $asktime + $overdue_days * 86400;
		$updatedata=array(
				'cid'=>$cid,
				'cid1'=>$cid1,
				'cid2'=>$cid2,
				'cid3'=>$cid3,
				'title'=>$title,
				'description'=>$description,
				'price'=>$price,
				'status'=>$status,
				'time'=>$asktime,
				'endtime'=>$endtime,
				'hidden'=>$hidanswer
		);
		$this->db->where(array('id'=>intval($id)))->update('question',$updatedata);
		if ($this->base->setting ['xunsearch_open']) {
			$question = array ();
			$question ['id'] = $id;
			$question ['cid'] = $cid;
			$question ['cid1'] = $cid1;
			$question ['cid2'] = $cid2;
			$question ['cid3'] = $cid3;
			$question ['status'] = $status;
			$question ['price'] = $price;

			$question ['title'] =$title;
			$question ['description'] = htmlspecialchars_decode($description );
			$doc = new XSDocument ();
			$doc->setFields ( $question );
			$this->index->openBuffer ();
			$this->index->update ( $doc )->flushIndex ();
			$this->index->closeBuffer ();
		}
	}

	/* 更新问题状态 */

	function update_status($qid, $status = 9) {
		$qid=intval($qid);
		$question = $this->get ( $qid );
		$qid = $question ['id'];
		$time = time ();
		$answer = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "answer WHERE qid=$qid AND status>0 AND adopttime =0  ORDER BY supports DESC,time asc " )->row_array ();
		if ($question ['shangjin'] > 0 && $status == 9 && $question ['status'] != 9) {
			if ($answer == null) {
				$quid = $question ['authorid'];
				$adoptmoeny = $question ['shangjin'];
				$cash_fee = intval ( $question ['shangjin'] ) * 100;
				$qtitle="关闭问题:".$question['title'];
				//如果没有回答，删除托管记录，零钱回到用户钱包，设置问题关闭
				$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET  `jine`=jine+'$cash_fee' WHERE `uid`=$quid" );
				
				$this->db->query ( "INSERT INTO " . $this->db->dbprefix . "paylog SET type='closeqid',typeid=$qid,money=$adoptmoeny,beizhu='$qtitle',openid='',fromuid=0,touid=$quid,`time`=$time" ); //增加关闭问题记录
			
				$authorid = $question['authorid'];
				
				//是否有提问悬赏现金托管
				$model = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user_depositmoney WHERE  type='qid' and typeid=$qid and fromuid=$authorid and state=0" )->row_array ();
				if ($model) {
					$fromuid = $model['fromuid'];
					$this->db->query ( "DELETE FROM `" . $this->db->dbprefix . "user_depositmoney` WHERE fromuid=$fromuid and type='qid' and typeid=$qid" );
				}
				
				//是否有对专家付费提问
				$model1 = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user_depositmoney WHERE  type='eqid' and typeid=$qid and fromuid=$authorid and state=0" )->row_array ();
				if ($model1) {
					$fromuid = $model1 ['fromuid'];
					$money = $model1 ['needpay'] * 100;
					$qtitle="付费咨询问题:".$question['title'];
					$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET  `jine`=jine+'$money' WHERE `uid`=$fromuid" );
					$time = time ();
					$needpay = $model1 ['needpay'];
					$this->db->query ( "INSERT INTO " . $this->db->dbprefix . "paylog SET type='theqid',typeid=$qid,money=$needpay,beizhu='$qtitle',openid='',fromuid=0,touid=$fromuid,`time`=$time" );
					$this->db->query ( "DELETE FROM `" . $this->db->dbprefix . "user_depositmoney` WHERE fromuid=$fromuid and type='eqid' and typeid=$qid" );
					
				}
				
			}
		}

		$this->db->query ( "UPDATE `" . $this->db->dbprefix . "question` set status=$status  WHERE `id` = $qid" );
	}

	/* 添加问题补充 */

	function add_supply($qid, $supply, $content, $status = 1) {
		$qid=intval($qid);
		$data=array(
				'qid'=>$qid,
				'content'=>$content,
				'time'=>time()
		);
		$this->db->insert('question_supply',$data);
	}

	function get_supply($qid) {
		$qid=intval($qid);
		$supplies = array ();
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "question_supply WHERE `qid`=$qid ORDER BY `time` ASC" );
		foreach ( $query->result_array () as $supply ) {
			$supply ['format_time'] = tdate ( $supply ['time'] );
			$supplies [] = $supply;
		}
		return $supplies;
	}

	function remove_supply_by_qid($qids) {
		$this -> db ->where_in('qid',explode(',', $qids))->delete('question_supply');
		
	}

	//添加查看次数
	function add_views($qid) {
		$qid=intval($qid);
		$this->db->query ( "UPDATE `" . $this->db->dbprefix . "question` SET views=views+1 WHERE `id`=$qid" );
	}
	//添加查看次数
	function pluginadd_views($qid, $views) {
		$views = intval ( $views );
		$qid = intval ( $qid );
		$this->db->query ( "UPDATE `" . $this->db->dbprefix . "question` SET views=$views WHERE `id`=$qid" );
	}
	/* 更新问题顶 */

	function update_goods($qid) {
		$qid=intval($qid);
		$this->db->query ( "UPDATE `" . $this->db->dbprefix . "question` set goods=goods+1  WHERE `id` =$qid" );
	}

	/* 追加问题悬赏 */

	function update_score($qid, $score) {
		$score=doubleval($score);
		$qid=intval($qid);
		if ($score >= 20) {
			$overdue_days = intval ( $this->base->setting ['overdue_days'] );
			$endtime = $this->base->time + $overdue_days * 86400;
			$this->db->query ( "UPDATE `" . $this->db->dbprefix . "question` set price=price+$score ,time={$this->base->time},endtime='$endtime'  WHERE `id` =$qid" );
		} else {
			$threeday = 24 * 3600 * 3;
			$this->db->query ( "UPDATE `" . $this->db->dbprefix . "question` set price=price+$score ,endtime=endtime+$threeday  WHERE `id` =$qid" );
		}
	}

	/* 某人是否已经回答过某问题 */

	function already($qid, $uid) {
		$qid=intval($qid);
		$uid=intval($uid);
		$already = $this->db->query ( "SELECT qid,authorid FROM `" . $this->db->dbprefix . "answer`  WHERE `qid` =$qid and authorid=$uid" )->row_array ();
		return is_array ( $already );
	}

	//问题审核
	function change_to_verify($qids) {
		$data=array('status'=>1);
		$this -> db ->where_in('id',explode(',', $qids))->where(array('status'=>0))->update('question',$data);
		

	}

	//编辑问题标题
	function renametitle($qid, $title) {
		$qid=intval($qid);
		$title=addslashes($title);
		$this->db->query ( "UPDATE `" . $this->db->dbprefix . "question` SET `title`='$title' WHERE `id`=$qid" );
		$this->db->query ( "UPDATE `" . $this->db->dbprefix . "answer` SET `title`='$title' WHERE `qid`=$qid" );
		if ($this->base->setting ['xunsearch_open']) {
			$question = array ();
			$question ['id'] = $qid;
			$question ['title'] = $title;
			$doc = new XSDocument ();
			$doc->setFields ( $question );
			$this->index->openBuffer ();
			$this->index->update ( $doc )->flushIndex ();
			$this->index->closeBuffer ();
		}
	}

	//编辑问题内容
	function update_content($qid, $title, $content) {
		$data = array ('title' => $title, 'description' => $content );
		$this->db->where ( array ('id' => $qid ) )->update ( 'question', $data );
		//$this->db->query ( "UPDATE `" . $this->db->dbprefix . "question` SET `title`='$title',`description`='$content' WHERE `id`=$qid" );
		$this->db->query ( "UPDATE `" . $this->db->dbprefix . "answer` SET `title`='$title' WHERE `qid`=$qid" );
		if ($this->base->setting ['xunsearch_open']) {
			$question = array ();
			$question ['id'] = $qid;
			$question ['title'] = $title;
			$question ['description'] =htmlspecialchars_decode($content ) ;
			$doc = new XSDocument ();
			$doc->setFields ( $question );
			$this->index->openBuffer ();
			$this->index->update ( $doc )->flushIndex ();
			$this->index->closeBuffer ();
		}
	}

	/* 是否关注问题 */

	function is_followed($qid, $uid) {
		$qid=intval($qid);
		$uid=intval($uid);
		$m = $this->db->query ( "SELECT COUNT(*) as num FROM " . $this->db->dbprefix . "question_attention WHERE qid=$qid AND followerid=$uid" )->row_array ();
		return $m ['num'];
	}

	/* 获取问题管理者列表信息 */

	function get_follower($qid, $start = 0, $limit = 16) {
		$qid=intval($qid);
		$followerlist = array ();
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "question_attention WHERE qid=$qid ORDER BY `time` DESC LIMIT $start,$limit" );
		foreach ( $query->result_array () as $follower ) {
			$follower ['avatar'] = get_avatar_dir ( $follower ['followerid'] );
			$follower ['format_time'] = tdate ( $follower ['time'] );
			$followerlist [] = $follower;
		}
		return $followerlist;
	}

	//编辑问题分类
	function update_category($qids, $cid, $cid1, $cid2, $cid3) {
		$data=array(
				'cid'=>$cid,
				'cid1'=>$cid1,
				'cid2'=>$cid2,
				'cid3'=>$cid3,
		);
		$this->db->where_in('id',explode(',', $qids))->update('question',$data);
		
	
		if ($this->base->setting ['xunsearch_open']) {
			foreach ( $qids as $qid ) {
				$question = array ();
				$question ['id'] = $qid;
				$question ['cid'] = $cid;
				$question ['cid1'] = $cid1;
				$question ['cid2'] = $cid2;
				$question ['cid3'] = $cid3;
				$doc = new XSDocument ();
				$doc->setFields ( $question );
				$this->index->openBuffer ();
				$this->index->update ( $doc )->flushIndex ();
				$this->index->closeBuffer ();
			}
		}
	}

	//设为待解决
	function change_to_nosolve($qids) {
		$overdue_days = intval ( $this->base->setting ['overdue_days'] );
		$endtime = $this->base->time + $overdue_days * 86400;
		$this->db->query ( "UPDATE `" . $this->db->dbprefix . "question` set status=1, `endtime`=$endtime WHERE  (status=6 OR status=2 OR status=9) AND `id` in ($qids) and shangjin<=0 " );
		$this->db->query ( "UPDATE `" . $this->db->dbprefix . "answer` SET `adopttime`=0 WHERE `qid` in ($qids)" );
		if ($this->base->setting ['xunsearch_open']) {
			foreach ( $qids as $qid ) {
				$question = array ();
				$question ['status'] = 1;
				$doc = new XSDocument ();
				$doc->setFields ( $question );
				$this->index->openBuffer ();
				$this->index->update ( $doc )->flushIndex ();
				$this->index->closeBuffer ();
			}
		}
	}

	//问题推荐
	function change_recommend($qids, $status1, $status2) {
		$this->db->query ( "UPDATE `" . $this->db->dbprefix . "question` SET `status`=$status1 WHERE `status`=$status2 AND `id` in ($qids)" );
	}

	//根据标题搜索问题的结果数
	function search_title_num($title, $status = '1,2,6') {
		$title=addslashes($title);
		$status=addslashes($status);
	
		$questionnum = 0;
		if ($this->base->setting ['xunsearch_open']) {
			$questionnum = $this->search->getLastCount ();
		} else {
		
			$query=$this->db-> select('count(id) AS total')->where_in('status',explode ( ",", $status ))->like('title',$title)->or_like('description', $title)->get("question");
		
			$questionnum = $query-> row() -> total;
			
		}
		return $questionnum;
	
	}

	//根据标题搜索问题
	function search_title($title, $status = '1,2,6', $addbestanswer = 0, $start = 0, $limit = 20) {
		$title=addslashes($title);
		$status=addslashes($status);
		
		$questionlist = array ();
		if ($this->base->setting ['xunsearch_open']) {
			$statusarr = explode ( ",", $status );
			$size = count ( $statusarr );
			$to = $statusarr [$size - 1];
			$from = $statusarr [0];
			$result = $this->search->setFuzzy()->setAutoSynonyms()->setCollapse('id')->setQuery ( $title )->addRange ( 'status', $from, $to )->setLimit ( $limit, $start )->search ();
			foreach ( $result as $doc ) {
				$question = array ();
				$question ['id'] = $doc->id;
				$question ['cid'] = $doc->cid;
				$question ['category_name'] = $this->base->category [$question ['cid']] ['name'];
				$question ['cid1'] = $doc->cid1;
				$question ['cid2'] = $doc->cid2;
				$question ['cid3'] = $doc->cid3;
				$question ['author'] = $doc->author;
				$question ['authorid'] = $doc->authorid;
				$question ['authoravatar'] = get_avatar_dir ( $doc->authorid );
				$question ['answers'] = $doc->answers;
				$question ['status'] = $doc->status;
				$question ['views'] = $doc->views;
				$question ['format_time'] = tdate ( $doc->time );
				$question ['title'] = $this->search->highlight ( $doc->title );
				$question ['author_has_vertify'] = get_vertify_info ( $question ['authorid'] ); //用户是否认证
				$question ['avatar'] = get_avatar_dir ( $question ['authorid'] );
				$question ['description'] = $this->search->highlight ( cutstr ( checkwordsglobal ( strip_tags (htmlspecialchars_decode( $question ['description'] ) ) ), 240, '...' ) );

				$questionlist [] = $question;
			}
			if (count ( $questionlist ) == 0) {
				$questionlist = $this->get_question_bytitle ( $title, $status, $addbestanswer, $start, $limit );
			}

		} else {
			$query=$this->db->
			where_in('status',explode ( ",", $status ))
			->group_start() //左括号
			->like('title',$title)
			->or_like('description', $title)
			->group_end() //右括号
			->limit($limit, $start)->get('question');
		
			foreach ( $query->result_array () as $question ) {
				$question ['category_name'] = $this->base->category [$question ['cid']] ['name'];
				$question ['format_time'] = tdate ( $question ['time'] );
				$question ['authoravatar'] = get_avatar_dir ( $question ['authorid'] );
				$question ['description'] = strip_tags ( htmlspecialchars_decode( $question ['description'] ) );
				$question ['author_has_vertify'] = get_vertify_info ( $question ['authorid'] ); //用户是否认证
				$question ['title'] = highlight ( $question ['title'], $title );
				$question ['avatar'] = get_avatar_dir ( $question ['authorid'] );
				$question ['description'] = highlight ( cutstr ( checkwordsglobal ( strip_tags ( htmlspecialchars_decode( $question ['description'] )) ), 240, '...' ), $title );
				$questionlist [] = $question;
			}
		}
	
		return $questionlist;
	}
	function get_question_bytitle($title, $status = '1,2,6', $addbestanswer = 0, $start = 0, $limit = 20) {
		$questionlist = array ();
		$query=$this->db->
		where_in('status',explode (",", $status ))
		->group_start() //左括号
		->like('title',$title)
		->or_like('description', $title)
		->group_end() //右括号
		->limit($limit, $start)->get('question');
		
		foreach ( $query->result_array () as $question ) {
			$question ['category_name'] = $this->base->category [$question ['cid']] ['name'];
			$question ['format_time'] = tdate ( $question ['time'] );
			$addbestanswer && $question ['bestanswer'] = $this->db->result_first ( "SELECT content FROM `" . $this->db->dbprefix . "answer` WHERE qid=" . $question ['id'] . " AND adopttime>0 " );
			$question ['avatar'] = get_avatar_dir ( $question ['authorid'] );
			$question ['author_has_vertify'] = get_vertify_info ( $question ['authorid'] ); //用户是否认证
			$question ['description'] = highlight ( cutstr ( checkwordsglobal ( strip_tags ( htmlspecialchars_decode( $question ['description'] )) ), 240, '...' ), $title );
			$questionlist [] = $question;
		}
		return $questionlist;
	}

	/**
	 * 获得相关结果关键词
	 */
	function get_related_words() {
		$words = array ();
		if ($this->base->setting ['xunsearch_open'])
			$words = $this->search->getRelatedQuery ();
		return $words;
	}

	/**
	 * 获得热门搜索词
	 * @param type $size
	 * @return type
	 */
	function get_hot_words($size = 8) {
		$words = array ();
		if ($this->base->setting ['xunsearch_open'])
			$words = array_keys ( $this->search->getHotQuery ( $size, "currnum" ) );
		return $words;
	}

	function get_corrected_word() {
		$words = array ();
		if ($this->base->setting ['xunsearch_open'])
			$words = $this->search->getCorrectedQuery ();
		return $words;
	}

	function removequestionattention($qid,$uid){
		$qid=intval($qid);
		$uid=intval($uid);
		$this->db->query("delete from  `" . $this->db->dbprefix . "question_attention` where qid=$qid and followerid= $uid ");
	}
	/* 防采集 */

	function stopcopy() {
		$ip = $this->base->ip;
		$bengintime = $this->base->time - 60;
		$useragent = isset ( $_SERVER ['HTTP_USER_AGENT'] ) ? $_SERVER ['HTTP_USER_AGENT'] : '';
		$useragent = strtolower ( $useragent );
		$allowagent = explode ( "\n", $this->base->setting ['stopcopy_allowagent'] );
		$allow = false;
		foreach ( $allowagent as $agent ) {
			if (false !== strpos ( $useragent, $agent )) {
				$allow = true;
				break;
			}
		}
		! $allow && exit ( 'access deny' );
		$stopagent = explode ( "\n", $this->base->setting ['stopcopy_stopagent'] );
		foreach ( $stopagent as $agent ) {
			if (false !== strpos ( $useragent, $agent )) {
				exit ( 'access deny' );
			}
		}
		$m = $this->db->query ( "select count(*) as num from " . $this->db->dbprefix . "visit where time>$bengintime AND ip='$ip'" )->row_array ();
		$visits = $m ['num'];
		if ($visits > $this->base->setting ['stopcopy_maxnum']) {
			$userip = explode ( ".", $ip );
			$expiration = 3600 * 24;
			$this->db->query ( "INSERT INTO `" . $this->db->dbprefix . "banned` (`ip1`,`ip2`,`ip3`,`ip4`,`admin`,`time`,`expiration`) VALUES ('{$userip[0]}', '{$userip[1]}', '{$userip[2]}', '{$userip[3]}', 'SYSTEM', '{$this->base->time}', '{$expiration}')" );
			exit ( '你采集的速度太快了吧 : ) ' );
		} else {
			$this->db->query ( "INSERT INTO " . $this->db->dbprefix . "visit (`ip`,`time`) values ('$ip','{$this->base->time}')" ); //加入数据库记录visit表中
		}
	}

	function makeindex($startindex, $pagesize) {
		if ($this->base->setting['xunsearch_open']) {
	
			$this->index->openBuffer ();
		
			$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "question where status!=0 and  isupdatexunsearch=0 order by time desc LIMIT $startindex,$pagesize" );
			foreach ( $query->result_array () as $question ) {
				$data = array ();
				$data ['id'] = $question ['id'];
				$data ['cid'] = $question ['cid'];
				$data ['cid1'] = $question ['cid1'];
				$data ['cid2'] = $question ['cid2'];
				$data ['cid3'] = $question ['cid3'];
				$data ['author'] = $question ['author'];
				$data ['authorid'] = $question ['authorid'];
				$data ['answers'] = $question ['answers'];
				$data ['price'] = $question ['price'];
				$data ['attentions'] = $question ['attentions'];
				$data ['shangjin'] = $question ['shangjin'];
				$data ['status'] = $question ['status'];
				$data ['views'] = $question ['views'];
				$data ['time'] = $question ['time'];
				$data ['title'] = $question ['title'];
				$data ['description'] = $question ['description'];
				$doc = new XSDocument ();
				$doc->setFields ( $data );
				
				$this->index->update ( $doc )->flushIndex ();
				$this->db->where(array('id'=>$question['id']))->update('question',array('isupdatexunsearch'=>1));
			}
	
			$this->index->closeBuffer ();
		}
	}

}

?>
