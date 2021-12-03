<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Admin_topic extends ADMIN_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->model ( "topic_model" );
		$this->load->model ( "topic_tag_model" );
		$this->load->model ( "category_model" );
	}
	function index($msg = '', $ty = '') {
		$catetree = $this->category_model->get_categrory_tree ( 2 );
		if ($_POST ['submit']) {
			$this->uri->rsegments [6] = 1;
		}
		@$page = max ( 1, intval ( $this->uri->rsegments [6] ) );
		
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		
		if ($this->uri->rsegments [3] != '' && $this->uri->rsegments [3] != '0') {
			$srchtitle = trim ( urldecode ( $this->uri->rsegments [3] ) );
		} else {
			$srchtitle = trim ( $this->input->post ( 'srchtitle' ) );
		}
		
		if ($this->uri->rsegments [4] != '' && $this->uri->rsegments [4] != '0') {
			$srchauthor = trim ( urldecode ( $this->uri->rsegments [4] ) );
		} else {
			$srchauthor = trim ( $this->input->post ( 'srchauthor' ) );
		}
		
		if ($this->uri->rsegments [5] != '' && $this->uri->rsegments [5] != '0') {
			$srchcategory = trim ( urldecode ( $this->uri->rsegments [5] ) );
		} else {
			$srchcategory = $this->input->post ( 'srchcategory' );
		}
		
		$topiclist = $this->topic_model->list_by_search ( addslashes ( $srchtitle ), addslashes ( $srchauthor ), addslashes ( $srchcategory ), $startindex, $pagesize );
		
		$rownum = $this->topic_model->rownum_by_search ( addslashes ( $srchtitle ), addslashes ( $srchauthor ), addslashes ( $srchcategory ) );
		if (! $srchtitle) {
			$srchtitle = 0;
		}
		if (! $srchauthor) {
			$srchauthor = 0;
		}
		if (! $srchcategory) {
			$srchcategory = 0;
		}
		$departstr = page ( $rownum, $pagesize, $page, "admin_topic/index/$srchtitle/$srchauthor/$srchcategory" );
		if (! $srchtitle) {
			$srchtitle = '';
		}
		if (! $srchauthor) {
			$srchauthor = '';
		}
		if (! $srchcategory) {
			$srchcategory = '';
		}
		$msg && $message = $msg;
		$ty && $type = $ty;
		
		include template ( "topiclist", 'admin' );
	}
	function shenhe($msg = '', $ty = '') {
		$catetree = $this->category_model->get_categrory_tree ( $this->category_model->get_list () );
		if ($_POST ['submit']) {
			$this->uri->rsegments [6] = 1;
		}
		@$page = max ( 1, intval ( $this->uri->rsegments [6] ) );
		
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		
		if ($this->uri->rsegments [3] != '' && $this->uri->rsegments [3] != '0') {
			$srchtitle = trim ( urldecode ( $this->uri->rsegments [3] ) );
		} else {
			$srchtitle = trim ( $this->input->post ( 'srchtitle' ) );
		}
		
		if ($this->uri->rsegments [4] != '' && $this->uri->rsegments [4] != '0') {
			$srchauthor = trim ( urldecode ( $this->uri->rsegments [4] ) );
		} else {
			$srchauthor = trim ( $this->input->post ( 'srchauthor' ) );
		}
		
		if ($this->uri->rsegments [5] != '' && $this->uri->rsegments [5] != '0') {
			$srchcategory = trim ( urldecode ( $this->uri->rsegments [5] ) );
		} else {
			$srchcategory = $this->input->post ( 'srchcategory' );
		}
		
		$topiclist = $this->topic_model->list_by_searchshenhe ( $srchtitle, $srchauthor, $srchcategory, $startindex, $pagesize );
		
		$rownum = $this->topic_model->rownum_by_searchshenhe ( $srchtitle, $srchauthor, $srchcategory );
		if (! $srchtitle) {
			$srchtitle = 0;
		}
		if (! $srchauthor) {
			$srchauthor = 0;
		}
		if (! $srchcategory) {
			$srchcategory = 0;
		}
		$departstr = page ( $rownum, $pagesize, $page, "admin_topic/shenhe/$srchtitle/$srchauthor/$srchcategory" );
		if (! $srchtitle) {
			$srchtitle = '';
		}
		if (! $srchauthor) {
			$srchauthor = '';
		}
		if (! $srchcategory) {
			$srchcategory = '';
		}
		$msg && $message = $msg;
		$ty && $type = $ty;
		
		include template ( "topicshenhelist", 'admin' );
	}
	function vertifycomments($msg = '') {
		$this->load->model ( "articlecomment_model" );
		$msg && $message = $msg;
		@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = 20;
		$startindex = ($page - 1) * $pagesize;
		$commentlist = $this->articlecomment_model->list_by_state ( 0, $startindex, $pagesize );
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'articlecomment', ' `state`=0', $this->db->dbprefix ) )->row_array () );
		$departstr = page ( $rownum, $pagesize, $page, "admin_topic/vertifycomments" );
		include template ( "verifyarticlecomments", "admin" );
	}
	function add() {
		if (null !== $this->input->post ( 'submit' )) {
			$title = $this->input->post ( 'title' );
			$desrc = htmlspecialchars ( $_POST ['content'] );
			$isphone = $this->input->post ( 'isphone' );
			$topic_tag = $this->input->post ( 'topic_tag' );
			$taglist = explode ( ",", $topic_tag );
			if ($isphone == 'on') {
				$isphone = 1;
			} else {
				$isphone = 0;
			}
			$acid = $this->input->post ( 'topicclass' );
			
			if ($acid == null)
				$acid = 1;
			$imgname = strtolower ( $_FILES ['image'] ['name'] );
			if ('' == $title || '' == $desrc) {
				$this->index ( '请完整填写专题相关参数!', 'errormsg' );
				exit ();
			}
			$type = substr ( strrchr ( $imgname, '.' ), 1 );
			if (! isimage ( $type )) {
				$this->index ( '当前图片图片格式不支持，目前仅支持jpg、gif、png格式！', 'errormsg' );
				exit ();
			}
			$upload_tmp_file = FCPATH . '/data/tmp/topic_' . random ( 6, 0 ) . '.' . $type;
			
			$filepath = '/data/attach/topic/topic' . random ( 6, 0 ) . '.' . $type;
			forcemkdir ( FCPATH . '/data/attach/topic' );
			if (move_uploaded_file ( $_FILES ['image'] ['tmp_name'], $upload_tmp_file )) {
				image_resize ( $upload_tmp_file, FCPATH . $filepath, 270, 220 );
				
				$this->topic_model->add ( $title, $desrc, $filepath, $isphone, '1', $acid );
				$this->index ( '添加成功！' );
			} else {
				$this->index ( '服务器忙，请稍后再试！' );
			}
		} else {
			include template ( "addtopic", 'admin' );
		}
	}
	/**
	 *
	 * 设置推荐
	 *
	 * @date: 2020年10月23日 下午3:05:41
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function recommend() {
		if (null !== $this->input->post ( 'tid' )) {
			foreach ( $this->input->post ( 'tid' ) as $tid ) {
				$tid = intval ( $tid );
				$topic = $this->db->get_where ( 'topic', array (
						'id' => $tid 
				) )->row_array ();
				if ($topic ['ispc'] == 1) {
					$this->db->where ( array (
							'id' => $tid 
					) )->update ( 'topic', array (
							'ispc' => 0 
					) );
				} else {
					$this->db->where ( array (
							'id' => $tid 
					) )->update ( 'topic', array (
							'ispc' => 1 
					) );
				}
			}
			$this->message ( "设置完成" );
		} else {
			$this->message ( "暂无推荐文章设置" );
			exit ();
		}
	}
	/**
	
	* 顶置文章
	
	* @date: 2020年10月23日 下午3:13:15
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function settop(){
		$this->load->model("topdata_model");
		if (null !== $this->input->post ( 'tid' )) {
			foreach ( $this->input->post ( 'tid' ) as $tid ) {
				$tid = intval ( $tid );
				$topic = $this->db->get_where ( 'topdata', array (
						'typeid' => $tid,
						'type'=>'topic'
				) )->row_array ();
				if ($topic) {
					$this->topdata_model->remove($tid,"topic");
				} else {
					$this->topdata_model->add($tid,"topic");
					
				}
			}
			$this->message ( "设置完成" );
		} else {
			$this->message ( "暂无顶置文章设置" );
			exit ();
		}
	}
	/* 百度推送 */
	function baidutui() {
		$urls = array ();
		$suffix = '?';
		if ($this->setting ['seo_on']) {
			$suffix = '';
		}
		$fix = $this->setting ['seo_suffix'];
		if (null !== $this->input->post ( 'tid' )) {
			// SITE_URL.$suffix."q-$item[id]$fix
			$tids = $this->input->post ( 'tid' );
			$q_size = count ( $tids );
			for($i = 0; $i < $q_size; $i ++) {
				array_push ( $urls, SITE_URL . $suffix . "article-" . $tids [$i] . $fix );
			}
		} else {
			$this->index ( '您还没选择推送文章!' );
		}
		if (trim ( $this->setting ['baidu_api'] ) != '' && $this->setting ['baidu_api'] != null) {
			
			$api = $this->setting ['baidu_api'];
			$result = baidusend ( $api, $urls );
			$this->index ( '文章推送成功!' );
		} else {
			$this->index ( '文章推送不成功，您还没设置百度推送的api地址，前往系统设置--seo设置里配置!' );
		}
	}
	/**
	 * 后台修改专题
	 */
	function edit() {
		if ($this->user ['uid'] == 0) {
			header ( "Location:" . url ( 'user/login' ) );
		}
		if (is_mobile ()) {
			$catetree = $this->category_model->get_categrory_tree ( 2 );
		}
		session_start ();
		$this->load->model ( "tag_model" );
		$this->load->model ( "topic_tag_model" );
		$tid = intval ( $this->uri->segment ( 3 ) ) > 0 ? intval ( $this->uri->segment ( 3 ) ) : intval ( $this->input->post ( 'id' ) );
		
		$topic = $this->topic_model->get ( intval ( $tid ) );
		
		// 判断当前用户是不是超级管理员
		$candone = false;
		if ($this->user ['groupid'] == 1 || $this->user ['groupid'] == 2) {
			$candone = true;
		} else {
			// 判断当前用户是不是回答者本人
			
			if ($this->user ['uid'] == $topic ['authorid']) {
				$candone = true;
			}
		}
		
		if ($candone == false) {
			$this->message ( "非法操作,您的ip已被系统记录！", "STOP" );
		}
		if ($_POST) {
			$username = $this->input->post ( 'pubauthor' );
			$user = $this->db->get_where ( 'user', array (
					'username' => $username 
			) )->row_array ();
			if (! $user) {
				$this->message ( "发布作者不存在" );
				exit ();
			}
			$tid = intval ( $this->input->post ( 'id' ) );
			
			if ($topic ['authorid'] != $this->user ['uid'] && $candone == false) {
				$this->message ( '非法操作，你的ip已被记录' );
			}
			
			$title = $this->input->post ( 'title' );
			
			$topic_price = intval ( $this->input->post ( 'topic_price' ) );
			
			$readmode = intval ( $this->input->post ( 'readmode' ) );
			if ($readmode != '1' && $topic_price <= 0) {
				
				$this->message ( '付费模式下设置围观值必须大于零!' );
				
				exit ();
			}
			$topic_tag = $this->input->post ( 'topic_tag' );
			$taglist = explode ( ",", $topic_tag );
			$desrc = trim ( htmlspecialchars ( $_POST ['articlecontent'] ) );
			$freeconent = trim ( $this->input->post ( 'articlefreecontent' ) );
			$outimgurl = $this->input->post ( 'outimgurl' );
			$upimg = $this->input->post ( 'upimg' );
			$views = $this->input->post ( 'views' );
			$isphone = $this->input->post ( 'isphone' );
			if ($isphone == 'on') {
				$isphone = 1;
			} else {
				$isphone = 0;
			}
			$acid = $this->input->post ( 'topicclass' );
			if ($acid == null)
				$acid = 1;
			$imgname = strtolower ( $_FILES ['image'] ['name'] );
			if ('' == $title || '' == $desrc) {
				$this->message ( '请完整填写专题相关参数!', 'BACK' );
				exit ();
			}
			// print_r($tagarr);
			// exit();
			if ($imgname) {
				$type = substr ( strrchr ( $imgname, '.' ), 1 );
				if (! isimage ( $type )) {
					$this->message ( '当前图片图片格式不支持，目前仅支持jpg、gif、png格式！', 'errormsg' );
					exit ();
				}
				$filepath = '/data/attach/topic/topic' . random ( 6, 0 ) . '.' . $type;
				$upload_tmp_file = FCPATH . 'data/tmp/topic_' . random ( 6, 0 ) . '.' . $type;
				forcemkdir ( FCPATH . 'data/attach/topic' );
				if (move_uploaded_file ( $_FILES ['image'] ['tmp_name'], $upload_tmp_file )) {
					image_resize ( $upload_tmp_file, FCPATH . $filepath, 300, 240 );
					$filepath = SITE_URL . $filepath;
					$ispc = $topic ['ispc'];
					
					$this->topic_model->updatetopic ( $tid, $title, $desrc, $filepath, $isphone, $views, $acid, $ispc, $topic_price );
					// 更新发布作者，阅读模式，阅读内容
					$this->db->where ( array (
							'id' => $tid 
					) )->update ( 'topic', array (
							'price' => $topic_price,
							'author' => $user ['username'],
							'authorid' => $user ['uid'],
							'readmode' => $readmode,
							'freeconent' => $freeconent 
					) );
					$taglist && $this->tag_model->multi_addarticle ( array_unique ( $taglist ), $tid, $acid, $this->user ['uid'] );
					
					$state = 1;
					if ($this->setting ['publisharticlecheck']) {
						$state = intval ( $this->setting ['publisharticlecheck'] ) > 0 ? 0 : 1;
					}
					if ($state) {
						$this->message ( '文章修改成功！', "admin_topic/default" );
					} else {
						$this->message ( "文章在审核中", "admin_topic/default" );
					}
				} else {
					$this->message ( '服务器忙，请稍后再试！' );
				}
			} else {
				if (trim ( $outimgurl ) == '') {
					$this->message ( '封面图不能为空！', "BACK" );
				}
				// if($outimgurl!=$upimg&&trim($upimg)!=''){
				$upimg = $outimgurl;
				$filepath = 'data/attach/topic/topic' . random ( 6, 0 ) . '.jpg';
				
				image_resize ( $outimgurl, FCPATH . $filepath, 300, 240 );
				
				$upimg = SITE_URL . $filepath;
				// }
				$ispc = $topic ['ispc'];
				$this->topic_model->updatetopic ( $tid, $title, $desrc, $upimg, $isphone, $views, $acid, $ispc, $topic_price );
				// 更新发布作者，阅读模式，阅读内容
				$this->db->where ( array (
						'id' => $tid 
				) )->update ( 'topic', array (
						'price' => $topic_price,
						'author' => $user ['username'],
						'authorid' => $user ['uid'],
						'readmode' => $readmode,
						'freeconent' => $freeconent 
				) );
				
				$taglist && $this->tag_model->multi_addarticle ( array_unique ( $taglist ), $tid, $acid, $this->user ['uid'] );
				$state = 1;
				if ($this->setting ['publisharticlecheck'] && $this->user ['groupid'] >= 6) {
					$state = intval ( $this->setting ['publisharticlecheck'] ) > 0 ? 0 : 1;
				}
				if ($state) {
					$this->message ( '文章修改成功！', "admin_topic/default" );
				} else {
					$this->message ( "文章在审核中", "admin_topic/default" );
				}
			}
		} else {
			
			$topic ['tags'] = $this->tag_model->gettaglistbytypeid ( $topic ['id'], 'article' );
			$tagstr = '';
			foreach ( $topic ['tags'] as $tag ) {
				$tagstr .= $tag ['id'] . ",";
			}
			$topic ['topic_tag'] = trim ( $tagstr, ',' );
			
			$_SESSION ["userid"] = getRandChar ( 56 );
			$catmodel = $this->category_model->get ( $topic ['articleclassid'] );
			$categoryjs = $this->category_model->get_js ( 0, 2 );
			
			include template ( 'editxinzhi', 'admin' );
		}
	}
	function view() {
		if (null !== $this->input->post ( 'submit' )) {
			
			$title = $this->input->post ( 'title' );
			$topic_tag = $this->input->post ( 'topic_tag' );
			$taglist = explode ( ",", $topic_tag );
			$desrc = htmlspecialchars ( $_POST ['content'] );
			$tid = intval ( $this->input->post ( 'id' ) );
			$upimg = $this->input->post ( 'upimg' );
			$views = $this->input->post ( 'views' );
			$isphone = $this->input->post ( 'isphone' );
			$ispc = $this->input->post ( 'ispc' );
			if ($isphone == 'on') {
				$isphone = 1;
			} else {
				$isphone = 0;
			}
			if ($ispc == 'on') {
				$ispc = 1;
			} else {
				$ispc = 0;
			}
			$acid = $this->input->post ( 'topicclass' );
			
			if ($acid == null)
				$acid = 1;
			$imgname = strtolower ( $_FILES ['image'] ['name'] );
			if ('' == $title || '' == $desrc) {
				$this->index ( '请完整填写专题相关参数!', 'errormsg' );
				exit ();
			}
			$topic = $this->topic_model->get ( $tid );
			$filepath = $topic ['image'];
			if ($imgname) {
				$type = substr ( strrchr ( $imgname, '.' ), 1 );
				if (! isimage ( $type )) {
					$this->index ( '当前图片图片格式不支持，目前仅支持jpg、gif、png格式！', 'errormsg' );
					exit ();
				}
				$filepath = '/data/attach/topic/topic' . random ( 6, 0 ) . '.' . $type;
				$upload_tmp_file = FCPATH . '/data/tmp/topic_' . random ( 6, 0 ) . '.' . $type;
				forcemkdir ( FCPATH . '/data/attach/topic' );
				if (move_uploaded_file ( $_FILES ['image'] ['tmp_name'], $upload_tmp_file )) {
					image_resize ( $upload_tmp_file, FCPATH . $filepath, 270, 220 );
					$this->topic_model->updatetopic ( $tid, $title, $desrc, $filepath, $isphone, $views, $acid, $ispc, $topic ['price'] );
					$taglist && $this->topic_tag_model->multi_add ( array_unique ( $taglist ), $tid );
					$viewhref = urlmap ( 'admin_topic/index', 1 );
					$url = SITE_URL . $this->setting ['seo_prefix'] . $viewhref . $this->setting ['seo_suffix'];
					header ( "Location:$url" );
				} else {
					$this->index ( '服务器忙，请稍后再试！' );
				}
			} else {
				
				$this->topic_model->updatetopic ( $tid, $title, $desrc, $filepath, $isphone, $views, $acid, $ispc, $topic ['price'] );
				$taglist && $this->topic_tag_model->multi_add ( array_unique ( $taglist ), $tid );
				$this->index ( '专题修改成功！' );
			}
		} else {
			$topic = $this->topic_model->get ( intval ( $this->uri->segment ( 3 ) ) );
			
			$tagmodel = $this->topic_tag_model->get_by_aid ( $topic ['id'] );
			
			$topic ['topic_tag'] = implode ( ',', $tagmodel );
			
			$catmodel = $this->category_model->get ( $topic ['articleclassid'] );
			$categoryjs = $this->category_model->get_js ();
			include template ( "topicshenhe", 'admin' );
		}
	}
	// 审核通过
	function vertify() {
		if (null !== $this->input->post ( 'tid' )) {
			$this->load->model ( "doing_model" );
			if (is_array ( $this->input->post ( 'tid' ) )) {
				$tids = implode ( ',', $this->input->post ( 'tid' ) );
				$this->topic_model->vertify ( $tids );
				
				// 审核通过插入动态
				foreach ( $this->input->post ( 'tid' ) as $tid ) {
					$topic = $this->topic_model->get ( intval ( $tid ) );
					$this->doing_model->add ( $topic ['authorid'], $topic ['author'], 9, $tid, $topic ['title'] );
				}
			} else {
				$this->topic_model->vertify ( $this->input->post ( 'tid' ) );
				// 审核通过插入动态
				$topic = $this->topic_model->get ( intval ( $this->input->post ( 'tid' ) ) );
				$this->doing_model->add ( $topic ['authorid'], $topic ['author'], 9, $tid, $topic ['title'] );
			}
			if (null !== $this->input->post ( 'viewtid' )) {
				$this->message ( '文章审核通过！' );
			} else {
				$this->message ( '文章审核通过！' );
			}
		}
	}
	// 文章删除
	function remove() {
		if (null !== $this->input->post ( 'tid' )) {
			if (is_array ( $this->input->post ( 'tid' ) )) {
				$tids = implode ( ",", $this->input->post ( 'tid' ) );
				foreach ( $this->input->post ( 'tid' ) as $tid ) {
					$topic = $this->topic_model->get ( $tid );
					$this->load->model ( 'topdata_model' );
					$this->topdata_model->remove ( $topic ['id'], 'topic' );
					$uid = $topic ['authorid'];
					$this->load->model ( "doing_model" );
					$this->doing_model->deletedoing ( $uid, 9, $topic ['id'] ); // 删除动态
					                                                            
					// 删除文章，扣减财富值
					$touser = $this->user_model->get_by_uid ( $uid );
					$koujiancredit1 = intval ( $this->setting ['credit1_article'] );
					if ($touser ['credit1'] < $koujiancredit1) {
						$koujiancredit1 = $touser ['credit1'] >= 0 ? $touser ['credit1'] : 0;
					}
					
					$koujiancredit2 = intval ( $this->setting ['credit2_article'] );
					if ($touser ['credit2'] < $koujiancredit2) {
						$koujiancredit2 = $touser ['credit2'] >= 0 ? $touser ['credit2'] : 0;
					}
					
					$this->credit ( $uid, - $koujiancredit1, - $koujiancredit2, 0, 'delarticle' );
				}
				$this->topic_model->remove ( $tids );
			} else {
				$topic = $this->topic_model->get ( $this->input->post ( 'tid' ) );
				$this->load->model ( 'topdata_model' );
				$this->topdata_model->remove ( $topic ['id'], 'topic' );
				$uid = $topic ['authorid'];
				$this->load->model ( "doing_model" );
				$this->doing_model->deletedoing ( $uid, 9, $topic ['id'] ); // 删除动态
				                                                            
				// 删除文章，扣减财富值
				$touser = $this->user_model->get_by_uid ( $uid );
				$koujiancredit1 = intval ( $this->setting ['credit1_article'] );
				if ($touser ['credit1'] < $koujiancredit1) {
					$koujiancredit1 = $touser ['credit1'] >= 0 ? $touser ['credit1'] : 0;
				}
				
				$koujiancredit2 = intval ( $this->setting ['credit2_article'] );
				if ($touser ['credit2'] < $koujiancredit2) {
					$koujiancredit2 = $touser ['credit2'] >= 0 ? $touser ['credit2'] : 0;
				}
				
				$this->credit ( $uid, - $koujiancredit1, - $koujiancredit2, 0, 'delarticle' );
				
				$this->topic_model->remove ( $this->input->post ( 'tid' ) );
			}
			if (null !== $this->input->post ( 'viewtid' )) {
				$this->message ( '文章删除成功！' );
			} else {
				$this->message ( '文章删除成功！' );
			}
		}
	}
	
	// 审核文章评论
	function verifycomment() {
		$this->load->model ( "articlecomment_model" );
		if (null !== $this->input->post ( 'aid' )) {
			if (is_array ( $this->input->post ( 'aid' ) )) {
				$aids = implode ( ",", $this->input->post ( 'aid' ) );
				$this->articlecomment_model->pass ( $aids );
			} else {
				$this->articlecomment_model->pass ( $this->input->post ( 'aid' ) );
			}
			
			$this->vertifycomments ( '文章评论审核成功!' );
			exit ();
		}
	}
	// 文章评论删除
	function deletecomment() {
		$this->load->model ( "articlecomment_model" );
		if (null !== $this->input->post ( 'aid' )) {
			if (is_array ( $this->input->post ( 'aid' ) )) {
				$aids = implode ( ",", $this->input->post ( 'aid' ) );
				$this->articlecomment_model->remove ( $aids );
			} else {
				$this->articlecomment_model->remove ( $this->input->post ( 'aid' ) );
			}
			
			$this->vertifycomments ( '删除文章评论成功!' );
			exit ();
		}
	}
	/* 后台分类排序 */
	function reorder() {
		$orders = explode ( ",", $this->input->post ( 'order' ) );
		foreach ( $orders as $order => $tid ) {
			$this->topic_model->order_topic ( intval ( $tid ), $order );
		}
		$this->cache->remove ( 'topic' );
	}
	function ajaxgetselect() {
		echo $this->topic_model->get_select ();
		exit ();
	}
	function makeindex() {
		$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = 1000;
		$startindex = ($page - 1) * $pagesize;
		ignore_user_abort ();
		set_time_limit ( 0 );
		$this->topic_model->makeindex ( $startindex, $pagesize );
		echo 'ok';
		exit ();
	}
	/**
	 *
	 * 获取顶置内容列表
	 *
	 * @date: 2018年11月9日 下午4:51:35
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function topicdatalist() {
		$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$this->load->model ( 'topdata_model' );
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'topdata', ' 1=1', $this->db->dbprefix ) )->row_array () );
		
		$topicdatalist = $this->topdata_model->get_list ( $startindex, $pagesize );
		$departstr = page ( $rownum, $pagesize, $page, "admin_topic/topicdatalist" );
		include template ( "topicdatalist", 'admin' );
	}
	/**
	 *
	 * 取消顶置内容
	 *
	 * @date: 2018年11月9日 下午6:10:30
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function canceltopdata() {
		$this->load->model ( 'topdata_model' );
		if (null !== $this->input->post ( 'tid' )) {
			if (is_array ( $this->input->post ( 'tid' ) )) {
				$tids = implode ( ",", $this->input->post ( 'tid' ) );
				
				$this->topdata_model->remove_by_id ( $tids );
			} else {
				
				$this->topdata_model->remove ( $this->input->post ( 'tid' ) );
			}
			$this->message ( "取消顶置成功" );
		}
	}
	/**
	 *
	 * 重新排序
	 *
	 * @date: 2018年11月9日 下午6:14:15
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function reordertopdata() {
		$this->load->model ( 'topdata_model' );
		if (null !== $this->input->post ( 'tid' )) {
			$cids = implode ( ",", $this->input->post ( 'tid' ) );
			
			$orders = $this->input->post ( 'corder' );
			// var_dump($orders);exit();
			
			foreach ( $this->input->post ( 'tid' ) as $val ) {
				
				$orderval = $this->input->post ( 'corder' . $val );
				// echo $val.'--'.$orderval."<br>";
				$this->topdata_model->order_topdata ( intval ( $val ), intval ( $orderval ) );
			}
			
			$this->message ( "更新排序成功" );
		}
	}
	/**
	 *
	 * 推荐文章管理
	 *
	 * @date: 2018年11月9日 下午6:40:31
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function topichotlist() {
		// get_hotlist
		@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'topic', ' ispc=1 and state=1 ', $this->db->dbprefix ) )->row_array () );
		
		$topiclist = $this->topic_model->get_hotlist ( 1, $startindex, $pagesize, 12 );
		$departstr = page ( $rownum, $pagesize, $page, "admin_topic/topichotlist" );
		include template ( "topichotlist", 'admin' );
	}
	/**
	 *
	 * 取消热文推荐
	 *
	 * @date: 2018年11月9日 下午6:47:26
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function cancelhottopic() {
		$this->load->model ( 'topdata_model' );
		if (null !== $this->input->post ( 'tid' )) {
			foreach ( $this->input->post ( 'tid' ) as $val ) {
				
				$this->topic_model->updatetopichot ( $val, '0' );
			}
			$this->message ( "取消推荐成功" );
		}
	}
}

?>