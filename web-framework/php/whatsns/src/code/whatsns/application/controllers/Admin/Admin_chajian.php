<?php
set_time_limit(0);
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Admin_chajian extends ADMIN_Controller {
	var $search;
	var $index;
	function __construct() {
		parent::__construct ();
		if ($this->setting ['xunsearch_open']) {
			require_once $this->setting ['xunsearch_sdk_file'];
			$xs = new XS ( 'question' );
			$this->search = $xs->search;
			$this->index = $xs->index;
		}
		$this->load->model ( 'setting_model' );
		$this->load->model ( 'question_model' );
		$this->load->model ( 'answer_model' );
		$this->load->model ( 'doing_model' );
		$this->load->model ( 'category_model' );
	}

	/**
	
	* 发布文章--马甲
	
	* @date: 2019年1月18日 下午4:57:45
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function addarticle(){
		if ($this->user ['uid'] == 0) {
			header ( "Location:" . url ( 'user/login' ) );
		}
		$this->load->model ( "topic_model" );
		$this->load->model ( "topic_tag_model" );
		$this->load->model ( "category_model" );
		$navtitle = "添加文章";
		if (is_mobile ()) {
			
			$catetree = $this->category_model->get_categrory_tree ( 2 );
		}
		$canpublish = intval ( $this->setting ['publisharticleforexpert'] );
		
	
	
	
		if ($_POST) {
			
			$username=$this->input->post('pubauthor');
			$user=$this->db->get_where('user',array('username'=>$username))->row_array();
			if(!$user){
				$this->message ("发布作者不存在");
				exit();
			}
			$uid =$user['uid'];
			$username = $user['username'];
			
			$this->load->model ( "tag_model" );
			
			$title = $this->input->post ( 'title' );
			$topic_price = intval ( $this->input->post ( 'topic_price' ) ); // 付费阅读值
			$readmode = intval ( $this->input->post ( 'readmode' ) );
			if ($readmode != '1' && $topic_price < 0) {
			
					$this->message ( '付费阅读值不能小于0!');
					
					exit ();
			}
			
			if ($readmode == '1') { // 如果是免费阅读将付费阅读值设置为0
				$topic_price = 0;
			}
			$freeconent = $this->input->post ( 'articlefreecontent' );
			$topic_tag = $this->input->post ( 'topic_tag' );
			$ataglist = explode ( ",", str_replace ( '，', ',', $topic_tag ) );
			$desrc = htmlspecialchars($_POST['articlecontent']);
			$outimgurl = $this->input->post ( 'outimgurl' );
			
			$acid = $this->input->post ( 'topicclass' );
			$views=intval($this->input->post ( 'views' ));
		
			
			if ($acid == null)
				$acid = 1;
				
				if ('' == $title || '' == strip_tags ( $desrc )) {
					$this->message ( '文章标题或者内容不能为空!' );
					
					exit ();
				}
				if ($_FILES ['image'] ['name'] == null && trim ( $outimgurl ) == '') {
					$this->message ( '封面图和外部图片至少填写一个!');
					
					exit ();
				}
				if ($_FILES ['image'] ['name'] != null) {
					
					$imgname = strtolower ( $_FILES ['image'] ['name'] );
					$type = substr ( strrchr ( $imgname, '.' ), 1 );
					if (! isimage ( $type )) {
						$this->message ( '当前图片图片格式不支持，目前仅支持jpg、gif、png格式！' );
						
						exit ();
					}
					$upload_tmp_file = FCPATH . 'data/tmp/topic_' . random ( 6, 0 ) . '.' . $type;
					
					$filepath = '/data/attach/topic/topic' . random ( 6, 0 ) . '.' . $type;
					forcemkdir ( FCPATH . 'data/attach/topic' );
					if (move_uploaded_file ( $_FILES ['image'] ['tmp_name'], $upload_tmp_file )) {
						image_resize ( $upload_tmp_file, FCPATH . $filepath, 300, 240, 1 );
						
						$filepath = SITE_URL . $filepath;
					} else {
						
						$this->message ( '服务器忙，请稍后再试！' );
					}
				}
				if (trim ( $outimgurl ) != '' && $_FILES ['image'] ['name'] == null) {
					if(strstr($outimgurl,'/default.jpg')){
						$filepath=$outimgurl;
					}else{
						$filepath = '/data/attach/topic/topic' . random ( 6, 0 ) . '.jpg';
						image_resize ( $outimgurl, FCPATH . $filepath, 300, 240 );
						
						if (! file_exists ( FCPATH . $filepath )) {
							$filepath = $outimgurl;
						} else {
							$filepath = SITE_URL . $filepath;
						}
					}
					
				}
				
				$aid = $this->topic_model->addtopic ( $title, $desrc, $filepath, $username, $uid, $views, $acid, $topic_price, $readmode, $freeconent );
				$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET articles=articles+1 WHERE  uid =" . $uid );
				// 发布文章，添加积分
				$this->credit ( $uid, $this->setting ['credit1_article'], $this->setting ['credit2_article'], 0, 'addarticle' );
				
				$ataglist && $this->tag_model->multi_addarticle ( array_unique ( $ataglist ), $aid, $acid, $uid);
				
				$this->load->model ( "doing_model" );
				$this->doing_model->add ($uid, $username, 9, $aid, $title );
				$state = 1;
				if ($this->setting ['publisharticlecheck']&&$this->user['groupid']>=6) {
					$state = intval ( $this->setting ['publisharticlecheck'] ) > 0 ? 0 : 1;
				}
				if ($state) {
					$this->message ( '添加成功！' );
				} else {
					$this->message ( "文章在审核中" );
				}
		} else {			
			$categoryjs = $this->category_model->get_js ( 0, 2 );
			include template ( 'addxinzhi' ,'admin');
		}
	}
	/**
	
	* 获取用户是否存在
	
	* @date: 2020年10月22日 下午5:30:04
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function getuser(){
		$username=$this->input->post('username');
		$user=$this->db->get_where('user',array('username'=>$username))->row_array();
		if($user){
			$message['code']=200;
			$message['msg']="存在改用户";
		}else{
			$message['code']=201;
			$message['msg']="用户不存在";
		}
		echo json_encode($message);
		exit();
	}
	function autoasnwer() {

		$categoryjs = $this->category_model->get_js ();
		include template ( "autoanswer", "admin" );
	}

	function postanswer() {
		$message = array ();
			if (null !== $this->input->post ( 'submit' )) {

			$title = strip_tags ( $this->input->post ('title') );
			$miaosu = $this->input->post ('q_miaosu_eidtor_content');
			$zuijiadaan =trim(strip_tags( $this->input->post ('q_best_eidtor_content')));
			$qtime = strtotime ( $this->input->post ('qtime') );
			$qbesttime = $this->input->post ('qbesttime');
			if ($zuijiadaan != '') {
				$qbesttime = strtotime ( $qbesttime );
			}
			$shangjin = doubleval($this->input->post ('shangjin'));
			$price = doubleval($this->input->post ('price'));
			$views = $this->input->post ('views');
			$cid = $this->input->post ('cid');
			$cid1 = $this->input->post ('cid1');
			$cid2 = $this->input->post ('cid2');
			$cid3 = $this->input->post ('cid3');
			$userlist = $this->user_model->get_caiji_list ( 0, 200 );
			if (count ( $userlist ) <= 0) {
				$message ['msg'] = '没有可用的马甲用户，先去用户管理设置马甲';
				echo json_encode ( $message );
				exit ();
			}

			$mwtuid = array_rand ( $userlist, 1 );
			$q_uid = $userlist [$mwtuid] ['uid'];
			$q_username = $userlist [$mwtuid] ['username'];
			$q = $this->question_model->get_by_title ( htmlspecialchars ( $title ) );
			if ($q != null)
			{
				$message ['msg'] = '已存在重复标题';
				echo json_encode ( $message );
				exit ();
			}
			$qid = $this->add ( $title, $miaosu, $zuijiadaan, $cid, $qtime, $views, $q_uid, $q_username, $cid1, $cid2, $cid3,1,$shangjin );

			if ($qid <= 0) {
				$message ['msg'] = '提交问题失败';
				echo json_encode ( $message );
				exit ();
			} else {
				$this->load->model ( 'doing_model' );
				$this->doing_model->add ($q_uid, $q_username, 1, $qid, $miaosu );
				if ($zuijiadaan != '') {
					
				
				
				$mwtuid = array_rand ( $userlist, 1 );
				$b_uid = $userlist [$mwtuid] ['uid'];
				$b_username = $userlist [$mwtuid] ['username'];

				$aid = $this->addanswer ( $qid, $title, $this->input->post ('q_best_eidtor_content'), $qbesttime, $b_uid, $b_username,1,$price );

				$numuser = rand ( 3, 20 );
				for($i = 0; $i <= $numuser; $i ++) {
					$auid = array_rand ( $userlist, 1 );
					$_uid = $userlist [$auid] ['uid'];
					$_username = $userlist [$auid] ['username'];
					$this->attention_question ( $qid, $_uid, $_username );
				}

				$question = $this->question_model->get ( $qid );

				$answer = $this->answer_model->get ( $aid );

				$ret = $this->answer_model->adopt ( $qid, $answer );

				if ($ret) {
					$this->load->model ( "answer_comment_model" );
					$this->answer_comment_model->add ( $aid, '非常感谢', $question ['authorid'], $question ['author'] );

					$this->credit ( $answer ['authorid'], $this->setting ['credit1_adopt'], intval ( $question ['price'] + $this->setting ['credit2_adopt'] ), 0, 'adopt' );

					$viewurl = urlmap ( 'question/view/' . $qid, 2 );

		//$_ENV['doing']->add($question['authorid'], $question['author'], 8, $qid, '非常感谢', $answer['id'], $answer['authorid'], $answer['content']);
				}
				
				}else{
					
				}
				$message ['msg'] = 'ok';
				$message ['data'] = "-----$zuijiadaan";
				echo json_encode ( $message );
				exit ();
			}

		} else {
			$message ['msg'] = '非法提交表单';
			echo json_encode ( $message );
			exit ();
		}
	}
	//关注问题
	function attention_question($qid, $user_uid, $user_username) {
		$uid = $user_uid;
		$username = $user_username;
		$is_followed = $this->question_model->is_followed ( $qid, $uid );
		if ($is_followed) {
			$this->user_model->unfollow ( $qid, $uid );
		} else {
			$this->user_model->follow ( $qid, $uid, $username );

			$this->doing_model->add ( $uid, $username, 4, $qid );
		}
	}
	/* 插入问题到question表 */

	function add($title, $description, $zuijiadaan, $cid, $qtime, $views, $uid, $username, $cid1 = 0, $cid2 = 0, $cid3 = 0, $status = 1, $shangjin = 0, $askfromuid = 0) {
		$overdue_days = intval ( $this->setting ['overdue_days'] );
		$creattime = $qtime;
		$hidanswer = 0;
		$price = 0;
		$answers = 0;
		if ($zuijiadaan != '') {
			$answers = 1;
		}
		$endtime = $this->time + $overdue_days * 86400;

		//(! strip_tags ( $description, '<img>' )) && $description = '';
		$description = replace_imgouter ( $description );
		$description = filter_otherimgouter ( $description );
		
		$data=array('views'=>$views,'cid'=>$cid,'cid1'=>$cid1,'cid2'=>$cid2,'cid3'=>$cid3,'askuid'=>$askfromuid,'authorid'=>$uid,'shangjin'=>$shangjin,'author'=>$username,'title'=>$title,'description'=>$description,'price'=>$price,'time'=>$creattime,'endtime'=>$endtime,'hidden'=>$hidanswer,'status'=>$status,'ip'=>getip());
		$this->db->insert('question',$data);
		/* 分词索引 */
		$qid = $this->db->insert_id ();
		if ($this->setting ['xunsearch_open'] && $qid) {
			$question = array ();
			$question ['id'] = $qid;
			$question ['cid'] = $cid;
			$question ['cid1'] = $cid1;
			$question ['cid2'] = $cid2;
			$question ['cid3'] = $cid3;
			$question ['author'] = $username;
			$question ['authorid'] = $uid;
			$question ['answers'] = $answers;
			$question ['price'] = $price;
			$question ['attentions'] = 1;
			$question ['shangjin'] = $shangjin;
			$question ['status'] = $status;
			$question ['views'] = $views;
			$question ['time'] = $creattime;
			$question ['title'] = checkwordsglobal ( $title );
			$question ['description'] = checkwordsglobal ( $description );
			$doc = new XSDocument ();
			$doc->setFields ( $question );
			$this->index->add ( $doc );
		}
		$cid1 = intval ( $cid1 );
		$cid2 = intval ( $cid2 );
		$cid3 = intval ( $cid3 );
		$this->db->query ( "UPDATE " . $this->db->dbprefix . "category SET questions=questions+1 WHERE  id IN ($cid1,$cid2,$cid3) " );
		$uid && $this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET questions=questions+1 WHERE  uid =$uid" );
		return $qid;
	}
	/* 添加答案 */

	function addanswer($qid, $title, $content, $qbesttime, $uid, $username, $status = 1, $chakanjine = 0) {
		$content = checkwordsglobal ( $content );
		$supports = rand ( 20, 100 );
		$content = replace_imgouter ( $content );
		$content = filter_otherimgouter ( $content );
	    $data=array('qid'=>$qid,'title'=>$title,'supports'=>$supports,'author'=>$username,'authorid'=>$uid,'time'=>$qbesttime,'content'=>$content,'reward'=>$chakanjine,'status'=>$status,'ip'=>getip());
	    $this->db->insert('answer',$data);
		$aid = $this->db->insert_id ();
		$this->db->query ( "UPDATE " . $this->db->dbprefix . "question SET  answers=answers+1  WHERE id=" . $qid );
		$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET answers=answers+1 WHERE  uid =$uid" );
		return $aid;
	}

}
