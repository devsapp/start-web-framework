<?php
class Topic_model extends CI_Model {
	var $index;
	var $search;
	function __construct() {
		parent::__construct ();
		$this->load->database ();
		if ($this->base->setting ['xunsearch_open']) {
			require_once $this->base->setting ['xunsearch_sdk_file'];
			$xs = new XS ( XUNSEARCH_ARTICLEFILENAME );
			$this->search = $xs->search;
			$this->index = $xs->index;
		}
	}
	
	/* 获取某个文章信息 */
	function get($id) {
		$id = intval ( $id );
		$topic = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic WHERE id='$id'" )->row_array ();
		
		if ($topic) {
			$topic ['author_has_vertify'] = get_vertify_info ( $topic ['authorid'] ); // 用户是否认证
			$topic ['timespan'] = $topic ['viewtime'];
			$topic ['viewtime'] = tdate ( $topic ['viewtime'] );
			$topic ['title'] = checkwordsglobal ( $topic ['title'] );
			$src = '';
			
			preg_match_all ( '/<img .*?src=[\"|\'](.+?)[\"|\'].*?>/', $topic ['describtion'], $strResult, PREG_PATTERN_ORDER );
			$n = count ( $strResult [1] );
			if ($n >= 3) {
				$img1 = strstr ( $strResult [1] [0], 'http' ) ? $strResult [1] [0] : SITE_URL . substr ( $strResult [1] [0], 1 );
				$img2 = strstr ( $strResult [1] [1], 'http' ) ? $strResult [1] [1] : SITE_URL . substr ( $strResult [1] [1], 1 );
				$img3 = strstr ( $strResult [1] [2], 'http' ) ? $strResult [1] [2] : SITE_URL . substr ( $strResult [1] [2], 1 );
				
				$src = $img1 . '","' . $img2 . '","' . $img3;
			} elseif ($n >= 1) {
				$src = strstr ( $strResult [1] [0], 'http' ) ? $strResult [1] [0] : SITE_URL . substr ( $strResult [1] [0], 1 );
			}
			if ($src) {
				$topic ['xzsrc'] = $src;
			}
			$topic ['artlen'] = strlen ( strip_tags ( html_entity_decode($topic ['describtion']) ) );
			$topic ['describtion'] = checkwordsglobal (htmlspecialchars_decode($topic ['describtion']) );
			//echo $topic ['describtion'];exit();
		
		}
		return $topic;
	}
	/* 获取某个文章信息 */
	function getcomment($id) {
		$id = intval ( $id );
		$commenttopic = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "articlecomment WHERE id='$id'" )->row_array ();
		
		return $commenttopic;
	}
	// 删除文章评论
	function remove_by_tid($id, $tid) {
		$tid = intval ( $tid );
		$id = intval ( $id );
		$this->db->query ( "DELETE FROM `" . $this->db->dbprefix . "articlecomment` WHERE `id`=$id" );
		$one = $this->get ( $tid );
		if ($one) {
			if (intval ( $one ['articles'] ) > 0) {
				$this->db->query ( "UPDATE `" . $this->db->dbprefix . "topic` SET articles=articles-1 WHERE `id`=$tid" );
			} else {
				$this->db->query ( "UPDATE `" . $this->db->dbprefix . "topic` SET articles=0 WHERE `id`=$tid" );
			}
		}
	}
	// 查看已经付费阅读的人
	function getreaduser($uid, $tid) {
		$uid = intval ( $uid );
		$tid = intval ( $tid );
		$topic = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic_viewhistory WHERE uid=$uid and tid=$tid " )->row_array ();
		return $topic;
	}
	// 获取点赞人数
	function get_support_by_sid_aid($sid, $aid) {
		$sid = addslashes ( $sid );
		$aid = intval ( $aid );
		$query = $this->db->query ( "select count(*) as num from " . $this->db->dbprefix . "article_support where sid='$sid' AND aid=$aid " );
		$m = $query->row_array ();
		return $m ['num'];
	}
	function add_support($sid, $aid, $authorid) {
		$sid = addslashes ( $sid );
		$aid = intval ( $aid );
		$authorid = intval ( $authorid );
		$this->db->query ( "REPLACE INTO " . $this->db->dbprefix . "article_support(sid,aid,time) VALUES ('$sid',$aid,{$this->base->time})" );
		$this->db->query ( "UPDATE `" . $this->db->dbprefix . "articlecomment` SET `supports`=supports+1 WHERE `id`=$aid" );
		$this->db->query ( "UPDATE `" . $this->db->dbprefix . "user` SET `supports`=supports+1 WHERE `uid`=$authorid" );
	}
	function get_byname($title) {
		$title = addslashes ( $title );
		$topic = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic WHERE title='$title'" )->row_array ();
		
		if ($topic) {
			
			$topic ['viewtime'] = tdate ( $topic ['viewtime'] );
			$topic ['title'] = checkwordsglobal ( $topic ['title'] );
			$topic ['describtion'] = checkwordsglobal ( html_entity_decode ( $topic ['describtion'] ) );
			$topic ['author_has_vertify'] = get_vertify_info ( $topic ['authorid'] ); // 用户是否认证
		}
		return $topic;
	}
	function get_bylikename1($word, $start = 0, $limit = 6) {
		$word = addslashes ( $word );
		$topiclist = array ();
		if ($this->base->setting ['xunsearch_open']) {
			
			$result = $this->search->setFuzzy()->setAutoSynonyms()->setQuery ( $word )->setLimit ( $limit, $start )->search ();
			foreach ( $result as $doc ) {
				var_dump ( $doc );
				exit ();
				$topic = array ();
				$topic ['id'] = $doc->id;
				$topic ['author_has_vertify'] = get_vertify_info ( $topic ['authorid'] ); // 用户是否认证
				$topic ['author'] = $doc->author;
				$topic ['authorid'] = $doc->authorid;
				$topic ['image'] = $topic->image;
				$topic ['articleclassid'] = $doc->articleclassid;
				$topic ['title'] = $this->search->highlight ( $doc->title );
				$topic ['s_content'] = $doc->describtion;
				$topic ['describtion'] = $this->search->highlight ( $doc->describtion );
				$topic ['category_name'] = $this->base->category [$doc->articleclassid] ['name'];
				$topic ['describtion'] = highlight ( cutstr ( checkwordsglobal ( strip_tags ( html_entity_decode($topic ['describtion']) ) ), 240, '...' ), $word );
				$topic ['format_time'] = tdate ( $topic ['viewtime'] );
				$topic ['avatar'] = get_avatar_dir ( $topic ['authorid'] );
				$topic ['views'] = $doc->views;
				$topic ['articles'] = $doc->articles;
				$topic ['likes'] = $doc->likes;
				$topic ['viewtime'] = tdate ( $doc->viewtime );
				$topiclist [] = $topic;
			}
			if (count ( $topiclist ) == 0) {
				$topiclist = $this->get_by_likename ( $word, $start, $limit );
			}
		} else {
			
			$query = $this->db->order_by ( '  id desc ' )->get_where ( 'topic', "concat(`title`,`describtion`) like '%$word%' ", $limit, $start );
			
			foreach ( $query->result_array () as $topic ) {
				$topic ['title'] = checkwordsglobal ( $topic ['title'] );
				$topic ['describtion'] = checkwordsglobal ( html_entity_decode ( $topic ['describtion'] ) );
				$topic ['title'] = highlight ( $topic ['title'], $word );
				$topic ['author_has_vertify'] = get_vertify_info ( $topic ['authorid'] ); // 用户是否认证
				if (isset ( $this->base->category [$topic ['articleclassid']] )) {
					$topic ['category_name'] = $this->base->category [$topic ['articleclassid']] ['name'];
				} else {
					$topic ['category_name'] = '';
				}
				
				$topic ['describtion'] = highlight ( cutstr ( checkwordsglobal ( strip_tags ( html_entity_decode($topic ['describtion']) ) ), 240, '...' ), $word );
				$topic ['format_time'] = tdate ( $topic ['viewtime'] );
				$topic ['avatar'] = get_avatar_dir ( $topic ['authorid'] );
				$topic ['viewtime'] = tdate ( $topic ['viewtime'] );
				$topiclist [] = $topic;
			}
		}
		
		return $topiclist;
	}
	function get_bylikename($word, $start = 0, $limit = 6) {
		$word = addslashes ( $word );
		$topiclist = array ();
		if ($this->base->setting ['xunsearch_open']) {			
			$result = $this->search->setCollapse ( 'id' )->setFuzzy()->setAutoSynonyms()->setQuery ( $word )->setLimit ( $limit, $start )->search ();
			foreach ( $result as $doc ) {
				$topic = array ();
				$topic ['id'] = $doc->id;
				$topic ['author_has_vertify'] = get_vertify_info ( $topic ['authorid'] ); // 用户是否认证
				$topic ['author'] = $doc->author;
				$topic ['authorid'] = $doc->authorid;
				$topic ['image'] = $topic->image;
				$topic ['articleclassid'] = $doc->articleclassid;
				$topic ['title'] = $this->search->highlight ( $doc->title );
				$topic ['describtion'] = $this->search->highlight ( $doc->describtion );
				$topic ['category_name'] = $this->base->category [$doc->articleclassid] ['name'];
				$topic ['describtion'] = highlight ( cutstr ( checkwordsglobal ( strip_tags ( html_entity_decode($topic ['describtion']) ) ), 240, '...' ), $word );
				$topic ['format_time'] = tdate ( $topic ['viewtime'] );
				$topic ['avatar'] = get_avatar_dir ( $topic ['authorid'] );
				$topic ['views'] = $doc->views;
				$topic ['articles'] = $doc->articles;
				$topic ['likes'] = $doc->likes;
				$topic ['viewtime'] = tdate ( $doc->viewtime );
				$topiclist [] = $topic;
			}
			if (count ( $topiclist ) == 0) {
				$topiclist = $this->get_by_likename ( $word, $start, $limit );
			}
		} else {
			
			$query = $this->db->order_by ( '  id desc ' )->get_where ( 'topic', "concat(`title`,`describtion`) like '%$word%' ", $limit, $start );
			
			foreach ( $query->result_array () as $topic ) {
				$topic ['title'] = checkwordsglobal ( $topic ['title'] );
				$topic ['describtion'] = checkwordsglobal ( html_entity_decode ( $topic ['describtion'] ) );
				$topic ['title'] = highlight ( $topic ['title'], $word );
				$topic ['author_has_vertify'] = get_vertify_info ( $topic ['authorid'] ); // 用户是否认证
				if (isset ( $this->base->category [$topic ['articleclassid']] )) {
					$topic ['category_name'] = $this->base->category [$topic ['articleclassid']] ['name'];
				} else {
					$topic ['category_name'] = '';
				}
				
				$topic ['describtion'] = highlight ( cutstr ( checkwordsglobal ( strip_tags ( html_entity_decode($topic ['describtion']) ) ), 240, '...' ), $word );
				$topic ['format_time'] = tdate ( $topic ['viewtime'] );
				$topic ['avatar'] = get_avatar_dir ( $topic ['authorid'] );
				$topic ['viewtime'] = tdate ( $topic ['viewtime'] );
				$topiclist [] = $topic;
			}
		}
		
		return $topiclist;
	}
	function get_by_likename($word, $start = 0, $limit = 6) {
		$topiclist = array ();
		
		$word = addslashes ( $word );
		$query = $this->db->order_by ( ' id desc' )->get_where ( 'topic', "concat(`title`,`describtion`) like '%$word%' ", $limit, $start );
		
		foreach ( $query->result_array () as $topic ) {
			$topic ['title'] = checkwordsglobal ( $topic ['title'] );
			$topic ['describtion'] = checkwordsglobal ( html_entity_decode ( $topic ['describtion'] ) );
			$topic ['title'] = highlight ( $topic ['title'], $word );
			$topic ['author_has_vertify'] = get_vertify_info ( $topic ['authorid'] ); // 用户是否认证
			$topic ['category_name'] = $this->base->category [$topic ['articleclassid']] ['name'];
			$topic ['describtion'] = highlight ( cutstr ( checkwordsglobal ( strip_tags ( html_entity_decode($topic ['describtion']) ) ), 240, '...' ), $word );
			$topic ['format_time'] = tdate ( $topic ['viewtime'] );
			$topic ['avatar'] = get_avatar_dir ( $topic ['authorid'] );
			$topic ['viewtime'] = tdate ( $topic ['viewtime'] );
			
			$topiclist [] = $topic;
		}
		
		return $topiclist;
	}
	function rownum_by_user_article() {
		$sql = "SELECT COUNT(wz.authorid) as num FROM `" . $this->db->dbprefix . "user` as u ," . $this->db->dbprefix . "topic as wz where u.uid=wz.authorid group by u.uid ORDER BY num DESC ";
		$m = $this->db->query ( $sql )->row_array ();
		return $m ['num'];
	}
	
	/* 后台文章数目 */
	function rownum_by_search($title = '', $author = '', $cid = 0) {
		
		// if ($this->base->setting ['xunsearch_open']) {
		// $rownum = $this->search->getLastCount ();
		
		// return $rownum;
		// } else {
		$condition = " 1=1 ";
		$title && ($condition .= " AND `title` like '$title%' ");
		$author && ($condition .= " AND `author`='$author'");
		
		if ($cid) {
			$category = $this->base->category [$cid];
			$condition .= " AND `articleclassid" . "`= $cid ";
		}
		$query = $this->db->query ( "select count(*) as num from " . $this->db->dbprefix . "topic where $condition " );
		$m = $query->row_array ();
		return $m ['num'];
		
		// }
	}
	function rownum_by_searchshenhe($title = '', $author = '', $cid = 0) {
		$title = addslashes ( $title );
		$author = addslashes ( $author );
		$cid = intval ( $cid );
		// if ($this->base->setting ['xunsearch_open']) {
		// $rownum = $this->search->getLastCount ();
		
		// return $rownum;
		// } else {
		$condition = " 1=1 and state=0 ";
		$title && ($condition .= " AND `title` like '$title%' ");
		$author && ($condition .= " AND `author`='$author'");
		
		if ($cid) {
			$category = $this->base->category [$cid];
			$condition .= " AND `articleclassid" . "`= $cid ";
		}
		$query = $this->db->query ( "select count(*) as num from " . $this->db->dbprefix . "topic where $condition " );
		$m = $query->row_array ();
		return $m ['num'];
		
		// }
	}
	function get_user_articles($start = 0, $limit = 8) {
		$sql = "SELECT u.articles as num, u.uid,u.username,u.signature,u.followers,u.answers FROM `" . $this->db->dbprefix . "user` as u   order by  answers desc LIMIT $start,$limit";
		$modellist = array ();
		$query = $this->db->query ( $sql );
		foreach ( $query->result_array () as $model ) {
			$model ['author_has_vertify'] = get_vertify_info ( $model ['uid'] ); // 用户是否认证
			$model ['avatar'] = get_avatar_dir ( $model ['uid'] );
			$is_followed = $this->is_followed ( $model ['uid'], $this->base->user ['uid'] );
			$model ['hasfollower'] = $is_followed == 0 ? "0" : "1";
			$modellist [] = $model;
		}
		return $modellist;
	}
	/* 是否关注问题 */
	function is_followed($uid, $followerid) {
		$uid = intval ( $uid );
		$followerid = intval ( $followerid );
		$m = $this->db->query ( "SELECT COUNT(*) as num FROM " . $this->db->dbprefix . "user_attention WHERE uid=$uid AND followerid=$followerid" )->row_array ();
		return $m ['num'];
	}
	function get_article_by_uid($uid) {
		$uid = intval ( $uid );
		$sql = "SELECT COUNT(t.id) as num ,c.name ,c.id ,t.authorid,u.username FROM `" . $this->db->dbprefix . "topic` as t ," . $this->db->dbprefix . "category as c," . $this->db->dbprefix . "user as u where c.id=t.articleclassid and t.authorid=$uid and t.authorid=u.uid GROUP BY t.articleclassid HAVING COUNT(t.id)>0 ORDER BY num DESC LIMIT 0,15";
		$modellist = array ();
		$query = $this->db->query ( $sql );
		foreach ( $query->result_array () as $model ) {
			
			$model ['author_has_vertify'] = get_vertify_info ( $model ['authorid'] ); // 用户是否认证
			
			$modellist [] = $model;
		}
		return $modellist;
	}
	function get_bycatid($catid, $start = 0, $limit = 6, $questionsize = 10) {

		$topiclist = array ();
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic where articleclassid in($catid) and state=1  order by viewtime desc LIMIT $start,$limit" );
		foreach ( $query->result_array () as $topic ) {
			
			$topic ['title'] = checkwordsglobal ( $topic ['title'] );
			$topic ['avatar'] = get_avatar_dir ( $topic ['authorid'] );
			
			if ($topic ['price'] > 0) {
				$topic ['describtion'] = "付费阅读";
				$topic ['description'] = "付费阅读";
			} else {
				$topic ['images'] = getfirstimgs ( $topic ['describtion'] );
				$topic ['describtion'] = cutstr ( str_replace ( '&nbsp;', '', checkwordsglobal ( strip_tags ( html_entity_decode($topic ['describtion']) ) ) ), 240, '...' );
				$topic ['description'] = cutstr ( checkwordsglobal ( strip_tags ( html_entity_decode($topic ['describtion']) ) ), 240, '...' );
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
		return $topiclist;
	}
	function get_list($showquestion = 0, $start = 0, $limit = 6, $questionsize = 10) {
		$topiclist = array ();
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic where state=1 order by viewtime desc LIMIT $start,$limit" );
		foreach ( $query->result_array () as $topic ) {
			if ($topic ['articleclassid'] > 0) {
				($showquestion == 1) && $topic ['questionlist'] = $this->get_questions ( $topic ['id'], 0, $questionsize ); // 首页专题掉用
				($showquestion == 2) && $topic ['questionlist'] = $this->get_questions ( $topic ['id'] ); // 专题列表页掉用
				$topic ['sortime'] = $topic ['viewtime']; // 用于排序
				$topic ['format_time'] = tdate ( $topic ['viewtime'] );
				$topic ['viewtime'] = tdate ( $topic ['viewtime'] );
				$topic ['author_has_vertify'] = get_vertify_info ( $topic ['authorid'] ); // 用户是否认证
				$topic ['title'] = checkwordsglobal ( $topic ['title'] );
				if (isset ( $this->base->category [$topic ['articleclassid']] )) {
					$topic ['category_name'] = $this->base->category [$topic ['articleclassid']] ['name'];
				}
				
				if ($topic ['price'] > 0) {
					$topic ['describtion'] = "付费后阅读";
					$topic ['description'] = "付费后阅读";
				} else {
					$topic ['images'] = getfirstimgs ( $topic ['describtion'] );
					$topic ['describtion'] = clearhtml ( html_entity_decode ( $topic ['describtion'] ) );
					$topic ['description'] = $topic ['describtion'];
				}
				
				$topic ['answers'] = $topic ['articles'];
				$topic ['attentions'] = $topic ['likes'];
				$topic ['avatar'] = get_avatar_dir ( $topic ['authorid'] );
				$topiclist [] = $topic;
			}
		}
		return $topiclist;
	}
	function get_weeklist($start = 0, $limit = 6) {
		$topiclist = array ();
		$timeweekstart = $this->base->time - 7 * 24 * 3600;
		$timedaystart = $this->base->time - 1 * 24 * 3600;
		$timemonthstart = $this->base->time - 30 * 24 * 3600;
		$timeyearstart = $this->base->time - 365 * 24 * 3600;
		$timeend = $this->base->time;
		$query = null;
		// 先看一天内文章是否超过10条
		$dayrownum = returnarraynum ( $this->db->query ( getwheresql ( 'topic', " state=1 AND  `viewtime`>$timedaystart AND `viewtime`<$timeend ", $this->db->dbprefix ) )->row_array () );
		if ($dayrownum >= 10) {
			$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic where  state=1 AND  `viewtime`>$timedaystart AND `viewtime`<$timeend  order by views desc LIMIT $start,$limit" );
		} else {
			
			// 看这一周是否超过10条
			$weekrownum = returnarraynum ( $this->db->query ( getwheresql ( 'topic', " state=1 AND  `viewtime`>$timeweekstart AND `viewtime`<$timeend ", $this->db->dbprefix ) )->row_array () );
			if ($weekrownum >= 10) {
				$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic where  state=1 AND  `viewtime`>$timeweekstart AND `viewtime`<$timeend  order by views desc LIMIT $start,$limit" );
			} else {
				// 看这一月是否超过10条
				$monthrownum = returnarraynum ( $this->db->query ( getwheresql ( 'topic', " state=1 AND  `viewtime`>$timemonthstart AND `viewtime`<$timeend ", $this->db->dbprefix ) )->row_array () );
				if ($monthrownum >= 10) {
					$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic where  state=1 AND  `viewtime`>$timemonthstart AND `viewtime`<$timeend  order by views desc LIMIT $start,$limit" );
				} else {
					
					$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic where  state=1 AND  `viewtime`>$timeyearstart AND `viewtime`<$timeend  order by views desc LIMIT $start,$limit" );
				}
			}
		}
		if ($query) {
			foreach ( $query->result_array () as $topic ) {
				
				$topic ['sortime'] = $topic ['viewtime']; // 用于排序
				$topic ['format_time'] = tdate ( $topic ['viewtime'] );
				$topic ['author_has_vertify'] = get_vertify_info ( $topic ['authorid'] ); // 用户是否认证
				$topic ['viewtime'] = tdate ( $topic ['viewtime'] );
				$topic ['title'] = checkwordsglobal ( $topic ['title'] );
				if (isset ( $this->base->category [$topic ['articleclassid']] )) {
					$topic ['category_name'] = $this->base->category [$topic ['articleclassid']] ['name'];
				}
				$topic ['images'] = getfirstimgs ( $topic ['describtion'] );
				if ($topic ['price'] > 0) {
					$topic ['describtion'] = "付费后阅读";
				} else {
					$topic ['describtion'] = clearhtml ( html_entity_decode ( $topic ['describtion'] ) );
					$topic ['description'] = $topic ['describtion'];
				}
				
				$topic ['avatar'] = get_avatar_dir ( $topic ['authorid'] );
				$topiclist [] = $topic;
			}
		}
		return $topiclist;
	}
	function get_paylist($start = 0, $limit = 6, $readmode) {
		$topiclist = array ();
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic where readmode=$readmode and state=1 order by viewtime desc LIMIT $start,$limit" );
		
		foreach ( $query->result_array () as $topic ) {
			
			$topic ['sortime'] = $topic ['viewtime']; // 用于排序
			$topic ['format_time'] = tdate ( $topic ['viewtime'] );
			$topic ['author_has_vertify'] = get_vertify_info ( $topic ['authorid'] ); // 用户是否认证
			$topic ['viewtime'] = tdate ( $topic ['viewtime'] );
			$topic ['title'] = checkwordsglobal ( $topic ['title'] );
			if (isset ( $this->base->category [$topic ['articleclassid']] )) {
				$topic ['category_name'] = $this->base->category [$topic ['articleclassid']] ['name'];
			}
			$topic ['images'] = getfirstimgs ( $topic ['describtion'] );
			if ($topic ['price'] > 0) {
				$topic ['describtion'] = "付费后阅读";
			} else {
				$topic ['describtion'] = clearhtml ( html_entity_decode ( $topic ['describtion'] ) );
				$topic ['description'] = $topic ['describtion'];
			}
			
			$topic ['avatar'] = get_avatar_dir ( $topic ['authorid'] );
			$topiclist [] = $topic;
		}
		return $topiclist;
	}
	function get_hotlist($showquestion = 0, $start = 0, $limit = 6, $questionsize = 10) {
		$topiclist = array ();
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic where ispc=1 and state=1 order by viewtime desc LIMIT $start,$limit" );
		foreach ( $query->result_array () as $topic ) {
			($showquestion == 1) && $topic ['questionlist'] = $this->get_questions ( $topic ['id'], 0, $questionsize ); // 首页专题掉用
			($showquestion == 2) && $topic ['questionlist'] = $this->get_questions ( $topic ['id'] ); // 专题列表页掉用
			$topic ['sortime'] = $topic ['viewtime']; // 用于排序
			$topic ['format_time'] = tdate ( $topic ['viewtime'] );
			$topic ['author_has_vertify'] = get_vertify_info ( $topic ['authorid'] ); // 用户是否认证
			$topic ['viewtime'] = tdate ( $topic ['viewtime'] );
			$topic ['title'] = checkwordsglobal ( $topic ['title'] );
			if (isset ( $this->base->category [$topic ['articleclassid']] )) {
				$topic ['category_name'] = $this->base->category [$topic ['articleclassid']] ['name'];
			}
			$topic ['images'] = getfirstimgs ( $topic ['describtion'] );
			if ($topic ['price'] > 0) {
				$topic ['describtion'] = "付费后阅读";
			} else {
				$topic ['describtion'] = clearhtml ( html_entity_decode ( $topic ['describtion'] ) );
				$topic ['description'] = $topic ['describtion'];
			}
			
			$topic ['avatar'] = get_avatar_dir ( $topic ['authorid'] );
			$topiclist [] = $topic;
		}
		return $topiclist;
	}
	function rownum_by_tag($name) {
		$name = addslashes ( $name );
		$query = $this->db->query ( "SELECT * FROM `" . $this->db->dbprefix . "topic` AS q," . $this->db->dbprefix . "topic_tag AS t WHERE q.id=t.aid AND t.name='$name' ORDER BY q.views DESC" );
		return $this->db->num_rows ( $query );
	}
	function rownum_by_title($word) {
		$word = addslashes ( $word );
		if ($this->base->setting ['xunsearch_open']) {
			$rownum = $this->search->getLastCount ();
		} else {
			
			$query = $this->db->select ( 'count(id) AS total' )->get_where ( 'topic', "concat(`title`,`describtion`) like '%$word%' " );
			
			if ($query) {
				$rownum = $query->row ()->total;
			} else {
				$rownum = 0;
			}
		}
		return $rownum;
	}
	function list_by_tag($name, $start = 0, $limit = 20) {
		$toipiclist = array ();
		$name = addslashes ( $name );
		$query = $this->db->query ( "SELECT * FROM `" . $this->db->dbprefix . "topic` AS q," . $this->db->dbprefix . "topic_tag AS t WHERE q.id=t.aid AND t.name='$name' AND t.state=1  ORDER BY q.views  DESC LIMIT $start,$limit" );
		foreach ( $query->result_array () as $topic ) {
			$topic ['category_name'] = $this->base->category [$topic ['articleclassid']] ['name'];
			$topic ['format_time'] = tdate ( $topic ['viewtime'] );
			$topic ['author_has_vertify'] = get_vertify_info ( $topic ['authorid'] ); // 用户是否认证
			if ($topic ['price'] > 0) {
				$topic ['describtion'] = "付费后阅读";
			} else {
				$topic ['describtion'] = clearhtml ( html_entity_decode ( $topic ['describtion'] ) );
			}
			$topic ['title'] = highlight ( checkwordsglobal ( $topic ['title'] ), $name );
			$topic ['describtion'] = highlight ( $topic ['describtion'], $name );
			$toipiclist [] = $topic;
		}
		return $toipiclist;
	}
	function get_list_byuid($uid, $start = 0, $limit = 6, $questionsize = 10) {
		$uid = intval ( $uid );
		$topiclist = array ();
		$mywhere = '';
		if ($this->user ['uid'] != $uid) {
			$mywhere = " and state=1 ";
		}
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic where authorid=$uid $mywhere order by viewtime desc LIMIT $start,$limit" );
		foreach ( $query->result_array () as $topic ) {
			// $topic['describtion']= cutstr(strip_tags(str_replace('&nbsp;','',$topic['describtion'])),110,'...');
			$topic ['questionlist'] = $this->get_questions ( $topic ['id'] ); // 专题列表页掉用
			$topic ['format_time'] = tdate ( $topic ['viewtime'] );
			$topic ['viewtime'] = tdate ( $topic ['viewtime'] );
			$topic ['images'] = getfirstimgs ( $topic ['describtion'] );
			$topic ['author_has_vertify'] = get_vertify_info ( $topic ['authorid'] ); // 用户是否认证
			                                                                          // $topic['image']=getfirstimg($topic['description']);
			$topic ['avatar'] = get_avatar_dir ( $topic ['authorid'] );
			if ($topic ['price'] > 0) {
				$topic ['describtion'] = "付费后阅读";
			} else {
				$topic ['describtion'] = clearhtml ( html_entity_decode ( $topic ['describtion'] ) );
			}
			$topiclist [] = $topic;
		}
		return $topiclist;
	}
	/* 后台文章搜索 */
	function list_by_search($title = '', $author = '', $cid = 0, $start = 0, $limit = 10) {
		$title = addslashes ( $title );
		$author = addslashes ( $author );
		$cid = intval ( $cid );
		$sql = "SELECT * FROM `" . $this->db->dbprefix . "topic` WHERE 1=1 ";
		$title && ($sql .= " AND `title` like '%$title%' ");
		$author && ($sql .= " AND `author`='$author'");
		
		if ($cid) {
			$category = $this->base->category [$cid];
			$sql .= " AND `articleclassid" . "`= $cid ";
		}
		
		$sql .= " ORDER BY `viewtime` DESC LIMIT $start,$limit";
		$topiclist = array ();
		
		$query = $this->db->query ( $sql );
		foreach ( $query->result_array () as $topic ) {
			if ($topic ['price'] > 0) {
				$topic ['describtion'] = "付费后阅读";
			} else {
				$topic ['describtion'] = clearhtml ( html_entity_decode ( $topic ['describtion'] ) );
			}
			$topic ['questionlist'] = $this->get_questions ( $topic ['id'] ); // 专题列表页掉用
			$topic ['viewtime'] = tdate ( $topic ['viewtime'] );
			$topic ['author_has_vertify'] = get_vertify_info ( $topic ['authorid'] ); // 用户是否认证
			$topiclist [] = $topic;
		}
		
		return $topiclist;
	}
	function list_by_searchshenhe($title = '', $author = '', $cid = 0, $start = 0, $limit = 10) {
		$title = addslashes ( $title );
		$author = addslashes ( $author );
		$cid = intval ( $cid );
		$sql = "SELECT * FROM `" . $this->db->dbprefix . "topic` WHERE 1=1 and state=0 ";
		$title && ($sql .= " AND `title` like '%$title%' ");
		$author && ($sql .= " AND `author`='$author'");
		
		if ($cid) {
			$category = $this->base->category [$cid];
			$sql .= " AND `articleclassid" . "`= $cid ";
		}
		
		$sql .= " ORDER BY `viewtime` DESC LIMIT $start,$limit";
		$topiclist = array ();
		
		$query = $this->db->query ( $sql );
		foreach ( $query->result_array () as $topic ) {
			if ($topic ['price'] > 0) {
				$topic ['describtion'] = "付费后阅读";
			} else {
				$topic ['describtion'] = clearhtml ( html_entity_decode ( $topic ['describtion'] ) );
			}
			$topic ['questionlist'] = $this->get_questions ( $topic ['id'] ); // 专题列表页掉用
			$topic ['viewtime'] = tdate ( $topic ['viewtime'] );
			$topic ['author_has_vertify'] = get_vertify_info ( $topic ['authorid'] ); // 用户是否认证
			$topiclist [] = $topic;
		}
		
		return $topiclist;
	}
	function list_by_search2($title = '', $author = '', $cid = 0, $start = 0, $limit = 10) {
		$title = addslashes ( $title );
		$author = addslashes ( $author );
		$cid = intval ( $cid );
		$sql = "SELECT * FROM `" . $this->db->dbprefix . "topic` WHERE 1=1 ";
		$title && ($sql .= " AND `title` like '%$title%' ");
		$author && ($sql .= " AND `author`='$author'");
		
		if ($cid) {
			$category = $this->base->category [$cid];
			$sql .= " AND `articleclassid" . "`= $cid ";
		}
		
		$sql .= " ORDER BY `viewtime` DESC LIMIT $start,$limit";
		$topiclist = array ();
		
		$query = $this->db->query ( $sql );
		foreach ( $query->result_array () as $topic ) {
			if ($topic ['price'] > 0) {
				$topic ['describtion'] = "付费后阅读";
			} else {
				$topic ['describtion'] = clearhtml ( html_entity_decode ( $topic ['describtion'] ) );
			}
			$topic ['questionlist'] = $this->get_questions ( $topic ['id'] ); // 专题列表页掉用
			$topic ['viewtime'] = tdate ( $topic ['viewtime'] );
			$topic ['author_has_vertify'] = get_vertify_info ( $topic ['authorid'] ); // 用户是否认证
			$topiclist [] = $topic;
		}
		
		return $topiclist;
	}
	function get_list_bycidanduid($cid, $uid, $start = 0, $limit = 6) {
		$cid = intval ( $cid );
		$uid = intval ( $uid );
		$topiclist = array ();
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic where authorid=$uid and articleclassid=$cid order by viewtime  desc LIMIT $start,$limit" );
		foreach ( $query->result_array () as $topic ) {
			$topic ['images'] = getfirstimgs ( $topic ['describtion'] );
			if ($topic ['price'] > 0) {
				$topic ['describtion'] = "付费后阅读";
			} else {
				$topic ['describtion'] = clearhtml ( html_entity_decode ( $topic ['describtion'] ) );
			}
			$topic ['viewtime'] = tdate ( $topic ['viewtime'] );
			$topic ['author_has_vertify'] = get_vertify_info ( $topic ['authorid'] ); // 用户是否认证
			$topiclist [] = $topic;
		}
		return $topiclist;
	}
	function get_questions($id, $start = 0, $limit = 5) {
		$id = intval ( $id );
		$questionlist = array ();
		$query = $this->db->query ( "SELECT q.title,q.id FROM " . $this->db->dbprefix . "tid_qid as t," . $this->db->dbprefix . "question as q WHERE t.qid=q.id AND t.tid=$id LIMIT $start,$limit" );
		foreach ( $query->result_array () as $question ) {
			$question ['title'] = checkwordsglobal ( $question ['title'] );
			
			$questionlist [] = $question;
		}
		return $questionlist;
	}
	function get_list_bywhere($showquestion, $questionsize) {
		$topiclist = array ();
		$questionsize = intval ( $questionsize );
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic where isphone='1' and state=1 order by displayorder asc " );
		foreach ( $query->result_array () as $topic ) {
			($showquestion == 1) && $topic ['questionlist'] = $this->get_questions ( $topic ['id'], 0, $questionsize ); // 首页专题掉用
			($showquestion == 2) && $topic ['questionlist'] = $this->get_questions ( $topic ['id'] ); // 专题列表页掉用
			$topic ['viewtime'] = tdate ( $topic ['viewtime'] );
			$topic ['title'] = checkwordsglobal ( $topic ['title'] );
			$topic ['images'] = getfirstimgs ( $topic ['describtion'] );
			$topic ['author_has_vertify'] = get_vertify_info ( $topic ['authorid'] ); // 用户是否认证
			if ($topic ['price'] > 0) {
				$topic ['describtion'] = "付费后阅读";
			} else {
				$topic ['describtion'] = clearhtml ( html_entity_decode ( $topic ['describtion'] ) );
			}
			$topiclist [] = $topic;
		}
		return $topiclist;
	}
	function get_select() {
		$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic   LIMIT 0,50" );
		$select = '<select name="topiclist">';
		foreach ( $query->result_array () as $topic ) {
			$select .= '<option value="' . $topic ['id'] . '">' . $topic ['title'] . '</option>';
		}
		$select .= '</select>';
		return $select;
	}
	
	/* 后台管理编辑专题 */
	function update($id, $title, $desrc, $filepath = '') {
		$id = intval ( $id );
		$title = addslashes ( $title );
		$desrc = addslashes ( $desrc );
		$filepath = addslashes ( $filepath );
		if ($filepath)
			$this->db->query ( "UPDATE `" . $this->db->dbprefix . "topic` SET  `isupdatexunsearch`=0 ,`title`='$title' ,`describtion`='$desrc' , `image`='$filepath'  WHERE `id`=$id" );
		else
			$this->db->query ( "UPDATE `" . $this->db->dbprefix . "topic` SET `isupdatexunsearch`=0 , `title`='$title' ,`describtion`='$desrc'  WHERE `id`=$id" );
		if ($this->base->setting ['xunsearch_open']) {
			$topic = array ();
			$topic ['id'] = $id;
			
			$topic ['image'] = $filepath;
			$topic ['title'] = $title;
			$topic ['describtion'] = $desrc;
			$doc = new XSDocument ();
			$doc->setFields ( $topic );
			
			$this->index->openBuffer ();
			$this->index->update ( $doc )->flushIndex ();
			$this->index->closeBuffer ();
		}
	}
	function updatetopic($id, $title, $desrc, $filepath = '', $isphone = '', $views = '', $cid, $ispc = 0, $price) {
		$id = intval ( $id );
	
		global $setting;
	
		$state = 1;
		if ($setting ['publisharticlecheck'] && $this->user ['groupid'] >= 6) {
			$state = intval ( $setting ['publisharticlecheck'] ) > 0 ? 0 : 1;
		}
		if ($filepath) {
			$data = array (
					'state' => $state,
					'title' => $title,
					'price' => $price,
					'describtion' => $desrc,
					'image' => $filepath,
					'isphone' => $isphone,
					'isupdatexunsearch' => 0,
					'ispc' => $ispc,
					'views' => $views,
					'articleclassid' => $cid 
			);
			$this->db->where ( array (
					'id' => $id 
			) )->update ( 'topic', $data );
		} else {
			$data = array (
					'state' => $state,
					'title' => $title,
					'price' => $price,
					'describtion' => $desrc,
					'isphone' => $isphone,
					'isupdatexunsearch' => 0,
					'ispc' => $ispc,
					'views' => $views,
					'articleclassid' => $cid 
			);
			$this->db->where ( array (
					'id' => $id 
			) )->update ( 'topic', $data );
		}
	
		if ($this->base->setting ['xunsearch_open']) {
			$topic = array ();
			$topic ['id'] = $id;
			$topic ['views'] = $views;
			$topic ['articleclassid'] = $cid;
			
			if ($filepath) {
				$topic ['image'] = $filepath;
			}
			
			$topic ['title'] = $title;
			$topic ['describtion'] = $desrc;
			$doc = new XSDocument ();
			$doc->setFields ( $topic );
			
			$this->index->openBuffer ();
			$this->index->update ( $doc )->flushIndex ();
			$this->index->closeBuffer ();
		}
	}
	function updatetopichot($id, $ispc = 0) {
		$id = intval ( $id );
		$ispc = intval ( $ispc );
		$this->db->query ( "UPDATE `" . $this->db->dbprefix . "topic` SET  `ispc`='$ispc' WHERE `id`=$id" );
	}
	function updatetopicviews($id, $views = 0) {
		$views = intval ( $views );
		$id = intval ( $id );
		$this->db->query ( "UPDATE `" . $this->db->dbprefix . "topic` SET  `views`='$views' WHERE `id`=$id" );
	}
	function addtopicviewhistory($uid, $username, $tid) {
		$id = intval ( $id );
		$tid = intval ( $tid );
		$username = addslashes ( $username );
		$creattime = $this->base->time;
		$this->db->query ( "INSERT INTO `" . $this->db->dbprefix . "topic_viewhistory`(`uid`,`username`,`tid`,`time`) VALUES ('$uid','$username','$tid',$creattime)" );
		$id = $this->db->insert_id ();
		
		return $id;
	}
	/* 后台添加专题 */
	function add($title, $desc, $image, $isphone = '0', $views = '1', $cid = 1) {
		$creattime = $this->base->time;
		$author = $this->base->user ['username'];
		$authorid = $this->base->user ['uid'];
		$data = array (
				'title' => $title,
				'describtion' => $desc,
				'image' => $image,
				'author' => $author,
				'authorid' => $authorid,
				'views' => $views,
				'articleclassid' => $cid,
				'viewtime' => $creattime,
				'isphone' => $isphone 
		);
		$this->db->insert ( 'topic', $data );
		$aid = $this->db->insert_id ();
		if ($this->base->setting ['xunsearch_open'] && $aid) {
			$topic = array ();
			$topic ['id'] = $aid;
			$topic ['views'] = $views;
			$topic ['articles'] = 0;
			$topic ['likes'] = 0;
			$topic ['articleclassid'] = $cid;
			$topic ['title'] = checkwordsglobal ( $title );
			$topic ['describtion'] = checkwordsglobal ( $desc );
			$topic ['author'] = $author;
			$topic ['authorid'] = $authorid;
			$topic ['viewtime'] = $creattime;
			
			$doc = new XSDocument ();
			$doc->setFields ( $topic );
			$this->index->openBuffer ();
			$this->index->update ( $doc )->flushIndex ();
			$this->index->closeBuffer ();
		}
		return $aid;
	}
	function addtopic($title, $desc, $image, $author, $authorid, $views, $articleclassid, $price = 0, $readmode = 1, $freeconent = '') {
		global $setting;
		$creattime = $this->base->time;
		if ($setting ['loaclimage']) {
			$desc = replace_imgouter ( $desc );
			$desc = filter_otherimgouter ( $desc );
			$_image = getfirstimg ( $desc );
		}
		$state = 1;
		// 如果后台开启审核并且角色等级值游客和用户组均需要判断是否发布文章需要审核
		if ($setting ['publisharticlecheck'] && $this->user ['groupid'] >= 6) {
			$state = intval ( $setting ['publisharticlecheck'] ) > 0 ? 0 : 1;
		}
		
		$data = array (
				'readmode' => $readmode,
				'freeconent' => $freeconent,
				'title' => $title,
				'describtion' => $desc,
				'image' => $image,
				'author' => $author,
				'authorid' => $authorid,
				'views' => $views,
				'state' => $state,
				'articleclassid' => $articleclassid,
				'viewtime' => $creattime,
				'price' => $price 
		);
		$this->db->insert ( 'topic', $data );
		
		$aid = $this->db->insert_id ();
		if ($this->base->setting ['xunsearch_open'] && $aid) {
			$topic = array ();
			$topic ['id'] = $aid;
			$topic ['views'] = $views;
			$topic ['readmode'] = $readmode;
			$topic ['freeconent'] = $freeconent;
			$topic ['price'] = $price;
			$topic ['articles'] = 0;
			$topic ['likes'] = 0;
			$topic ['articleclassid'] = $articleclassid;
			$topic ['title'] = checkwordsglobal ( $title );
			$topic ['describtion'] = checkwordsglobal ( $desc );
			$topic ['author'] = $author;
			
			$topic ['authorid'] = $authorid;
			$topic ['viewtime'] = $creattime;
			
			$doc = new XSDocument ();
			$doc->setFields ( $topic );
			
			$this->index->openBuffer ();
			$this->index->update ( $doc )->flushIndex ();
			$this->index->closeBuffer ();
		}
		return $aid;
	}
	function addtotopic($qids, $tid) {
		$qidlist = explode ( ",", $qids );
		$sql = "INSERT INTO " . $this->db->dbprefix . "tid_qid (`tid`,`qid`) VALUES ";
		foreach ( $qidlist as $qid ) {
			$sql .= " (intval($tid),intval($qid)),";
		}
		$this->db->query ( substr ( $sql, 0, - 1 ) );
	}
	
	/* 后台管理删除文章 */
	function remove($tids) {
		$tids = explode ( ',', $tids );
		$this->db->where_in ( 'id', $tids )->delete ( 'topic' );
		$this->db->where_in ( 'tid', $tids )->delete ( 'tid_qid' );
		$this->db->where_in ( 'typeid', $tids )->where ( array (
				'itemtype' => 'article' 
		) )->delete ( 'tag_item' );
		$this->db->where_in ( 'id', $tids )->delete ( 'articlecomment' );
		$this->db->where_in ( 'questionid', $tids )->where ( 'action', "9,13,14,15" )->delete ( 'doing' );
		
		if ($this->base->setting ['xunsearch_open']) {
			$this->index->openBuffer ();
			$this->index->del ( explode ( ",", $tids ) )->flushIndex ();
			$this->index->closeBuffer ();
		}
	}
	/* 后台管理审核文章 */
	function vertify($tids) {
		$this->db->where_in ( 'id', explode ( ',', $tids ) )->update ( 'topic', array (
				'state' => 1 
		) );
	}
	/* 后台管理移动分类顺序 */
	function order_topic($id, $order) {
		$this->db->where_in ( 'id', $id )->update ( 'topic', array (
				'displayorder' => $order 
		) );
	}
	
	/* 创建文章索引 */
	function makeindex($startindex, $pagesize) {
		if ($this->base->setting ['xunsearch_open']) {
			$this->index->openBuffer ();
			$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "topic where state!=0 and isupdatexunsearch=0  order by viewtime desc limit $startindex, $pagesize" );
			foreach ( $query->result_array () as $topic ) {
				
				$data = array ();
				$data ['id'] = $topic ['id'];
				$data ['articleclassid'] = $topic ['articleclassid'];
				$data ['image'] = $topic ['image'];
				$data ['author'] = $topic ['author'];
				$data ['authorid'] = $topic ['authorid'];
				$data ['views'] = $topic ['views'];
				$data ['articles'] = $topic ['articles'];
				$data ['likes'] = $topic ['likes'];
				$data ['viewtime'] = $topic ['viewtime'];
				$data ['readmode'] = $topic ['readmode'];
				$data ['freeconent'] = $topic ['freeconent'];
				;
				$data ['price'] = $topic ['price'];
				;
				$data ['title'] = $topic ['title'];
				$data ['describtion'] = $topic ['describtion'];
				$doc = new XSDocument ();
				$doc->setFields ( $data );
				$this->index->update ( $doc )->flushIndex ();
				$this->db->where(array('id'=>$topic['id']))->update('topic',array('isupdatexunsearch'=>1));
			}
			$this->index->closeBuffer ();
		}
	}
}

?>
