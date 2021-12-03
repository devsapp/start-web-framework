<?php
ini_set('max_execution_time', '0');
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Admin_tag extends ADMIN_Controller {
	
	function __construct() {
		parent::__construct ();
		$this->load->model ( 'tag_model' );
		
	}
	
	function index($msg = '') {
		
		$msg && $message = $msg;
		@$page = max ( 1, intval ( $this->uri->segment ( 4 ) ) );
		$pagesize = 20;
		$startindex = ($page - 1) * $pagesize;
		$where='';
		
		$srchtitle='';
		if($_POST){
			$srchtitle=trim($this->input->post('srchtitle'));
			
			
		}elseif($this->uri->segments[3]){
			$srchtitle=urldecode($this->uri->segments[3]);
			
		}
		
		if($srchtitle){
			
			$where=" and tagname like '%$srchtitle%' or tagalias like '%$srchtitle%' ";
		}
		
		$taglist = $this->tag_model->getalltaglist ( $startindex, $pagesize,$where );
	
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'tag', " 1=1 $where", $this->db->dbprefix ) )->row_array () );
		$pages = @ceil ( $rownum / $pagesize );
		$rownumtag = returnarraynum ( $this->db->query ( getwheresql ( 'tag', " 1=1 ", $this->db->dbprefix ) )->row_array () );
		$pagestag = @ceil ( $rownumtag / $pagesize );
		if($srchtitle){
			$departstr = page ( $rownum, $pagesize, $page, "admin_tag/index/$srchtitle" );
		}else{
			$departstr = page ( $rownum, $pagesize, $page, "admin_tag/index/0" );
		}
		
		include template ( 'taglist', 'admin' );
	}
	/**
	
	* 同步前2000条问题和文章
	
	* @date: 2018年12月12日 上午11:32:21
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function updatedata(){
		$pagesize=2000;//只同步匹配前200条问题
		$tagalias=$_POST['tagalias'];
		$tag=$this->tag_model->get_by_tagalias($tagalias);
		if(!$tag){
			$message['code']=201;
			
			exit("标签不存在");
		}else{
			//通过标签查询问题
			
			$word=trim($tag['tagname']);
			
			
			$id=$tag['id'];
			$query=$this->db->
			where_in('status',explode ( ",", "1,2,6,9" ))
			->group_start() //左括号
			->like('title',$word)
			->or_like('description', $word)
			->group_end() //右括号
			->order_by("rand()")
			->limit($pagesize, 0)->get('question');
			$questionlist=array();
			if($query){
				$questionlist=$query->result_array () ;
			}
			
			$datas=array();
			foreach ($questionlist as $question ) {
				$qid=$question['id'];
				$data=array(
						'tagid' => $id,
						'typeid' =>$qid ,
						'cid' =>$question['cid'],
						'itemtype'=>'question',
						'time'=>time(),
						'uid'=>$question['authorid']
				);
				$tagquestion = $this->db->query ( "SELECT tagid,itemtype,typeid FROM " . $this->db->dbprefix . "tag_item WHERE tagid=$id and itemtype='question' and typeid=$qid " )->row_array ();
				if (!$tagquestion) {
					array_push($datas,$data);
					
				}
			}
			$this->db->insert_batch ( 'tag_item', $datas );
			
			
			
			
			
			
			$query = $this->db->order_by ( "rand()")->get_where ( 'topic', "concat(`title`,`describtion`) like '%$word%' ", $pagesize, 0 );
			$topiclist=array();
			if($query){
				$topiclist=	$query->result_array () ;
			}
			$datas=array();
			foreach ($topiclist as $topic ) {
				$tid=$topic['id'];
				$data=array(
						'tagid' => $id,
						'typeid' => $topic['id'] ,
						'cid' =>$topic['articleclassid'],
						'itemtype'=>'article',
						'time'=>$topic['viewtime'],
						'uid'=>$topic['authorid']
				);
				$tagtopic= $this->db->query ( "SELECT tagid,itemtype,typeid FROM " . $this->db->dbprefix . "tag_item WHERE tagid=$id and itemtype='article' and typeid=$tid " )->row_array ();
				if (!$tagtopic) {
					array_push($datas,$data);
					
				}
			}
			$this->db->insert_batch ( 'tag_item', $datas );
			
			$qnum=count($questionlist);
			$anum=count($topiclist);
			exit("数据处理成功（问题:$qnum 条,文章：$anum 条），可以在标签详情页面查看到");
		}
	}
	function tongbudatatag(){
		$pagesize=20;
		$pagemaxsize=500;
		//获取站内标签总数
		//$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'tag', " 1=1 ", $this->db->dbprefix ) )->row_array () );
		
		//分页处理标签同步
		//	$pages = @ceil ( $rownum / $pagesize );
		
		
		$startindex = intval($_POST['pageindex']);
		//分页提取标签
		$taglist = $this->tag_model->getalltaglist ( $startindex, $pagesize );
		
		foreach ($taglist as $tag){
			//通过标签查询问题
			
			$word=trim($tag['tagname']);
			
			
			$id=$tag['id'];
			$query=$this->db->
			where_in('status',explode ( ",", "1,2,6,9" ))
			->group_start() //左括号
			->like('title',$word)
			->or_like('description', $word)
			->group_end() //右括号
			->order_by("rand()")
			->limit($pagemaxsize, 0)->get('question');
			$questionlist=array();
			if($query){
				$questionlist=$query->result_array () ;
			}
			$datas=array();
			$dataids=array();
			foreach ($questionlist as $question ) {
				$qid=$question['id'];
				$data=array(
						'tagid' => $id,
						'typeid' =>$qid ,
						'cid' =>$question['cid'],
						'itemtype'=>'question',
						'time'=>time(),
						'uid'=>$question['authorid']
				);
				//array_push($dataids,$id);
				$tagquestion = $this->db->query ( "SELECT tagid,itemtype,typeid FROM " . $this->db->dbprefix . "tag_item WHERE tagid=$id and itemtype='question' and typeid=$qid " )->row_array ();
				if (!$tagquestion) {
					array_push($datas,$data);
					
				}
			}
			//$this->db->where(array('itemtype'=>'question'))->where_in("tagid",$dataids)->delete("tag_item");
			$this->db->insert_batch ( 'tag_item', $datas );
			
			
			
			
			
			
			$query = $this->db->order_by ( "rand()" )->get_where ( 'topic', "concat(`title`,`describtion`) like '%$word%' ", $pagemaxsize, 0 );
			$topiclist=array();
			if($query){
				$topiclist=	$query->result_array () ;
			}
			$datas=array();
			$dataids=array();
			foreach ($topiclist as $topic ) {
				$tid=$topic['id'];
				$data=array(
						'tagid' => $id,
						'typeid' => $topic['id'] ,
						'cid' =>$topic['articleclassid'],
						'itemtype'=>'article',
						'time'=>$topic['viewtime'],
						'uid'=>$topic['authorid']
				);
				//array_push($dataids,$id);
				$tagtopic= $this->db->query ( "SELECT tagid,itemtype,typeid FROM " . $this->db->dbprefix . "tag_item WHERE tagid=$id and itemtype='article' and typeid=$tid " )->row_array ();
				if (!$tagtopic) {
					array_push($datas,$data);
					
				}
			}
			//$this->db->where(array('itemtype'=>'article'))->where_in("tagid",$dataids)->delete("tag_item");
			$this->db->insert_batch ( 'tag_item', $datas );
			
		}
		
		$message['code']=200;
		
		$message['msg']="第".$startindex."页内容同步成功";
		echo json_encode($message);
		exit();
	}
	/**
	
	* 标签同步设置 问题和文章
	
	* @date: 2018年11月9日 上午11:32:54
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function tongbutag(){
		$pagesize=20;
		//获取站内标签总数
		//$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'tag', " 1=1 ", $this->db->dbprefix ) )->row_array () );
		
		//分页处理标签同步
		//	$pages = @ceil ( $rownum / $pagesize );
		$tagstr='';
		
		$startindex =intval($_POST['pageindex']);
		//分页提取标签
		$taglist = $this->tag_model->getalltaglist ( $startindex, $pagesize );
		$tagstr='';
		foreach ($taglist as $tag){
			$tagid=$tag['id'];
			$tagstr=$tagstr.",".$tag['tagname'];
			//获取标签全部问题数据
			$qrownum = returnarraynum ( $this->db->query ( getwheresql ( 'tag_item', " tagid=$tagid and itemtype='question' ", $this->db->dbprefix ) )->row_array () );
			
			//获取标签全部文章数
			$trownum = returnarraynum ( $this->db->query ( getwheresql ( 'tag_item', " tagid=$tagid and itemtype='article' ", $this->db->dbprefix ) )->row_array () );
			if(trim($tag['tagalias'])=='rewriteurl'){
				$tagstr.=$tag['tagalias']."--tagid:$tagid--#$i#---".$qrownum.'----'.$trownum;
			}
			// 标签首字母
			$tagfisrtchar = strtoupper ( preg_replace ( '# #', '', $this->getfirstchar ($tag['tagalias'] ) ) ); // 标签首字母
			
			//更新标签信息
			//$this->db->query ( "UPDATE `" . $this->db->dbprefix . "tag` set tagquestions=$qrownum and tagarticles=$trownum  WHERE `id` =$tagid" );
			$data=array('tagfisrtchar'=>$tagfisrtchar,'tagquestions'=>$qrownum,'tagarticles'=>$trownum);
			$this->db->where ( 'id', $tagid );
			$this->db->update ( 'tag', $data );
		}
		
		$message['code']=200;
		$message['tagstr']=$tagstr;
		
		$message['msg']=$tagstr."标签更新成功";
		echo json_encode($message);
		exit();
	}
	function checktagbyname(){
		$tagname=$this->input->post('tagname');
		$tag=$this->tag_model->get_by_tagname($tagname);
		if($tag){
			echo "1";
		}else{
			echo "0";
		}
		exit();
	}
	function checktagbyalias(){
		$tagalias=$this->input->post('tagalias');
		$tag=$this->tag_model->get_by_tagalias($tagalias);
		if($tag){
			echo "1";
		}else{
			echo "0";
		}
		exit();
	}
	/**
	
	* post提交tag，批量提交tag
	
	* @date: 2018年11月23日 下午2:45:48
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function postmutttag(){
		
		$strresult="";
		
		$tags = explode ( "\n", $this->input->post ( 'txttag' ) );
		foreach ( $tags as $tag ) {
			$tag = str_replace ( array ("\r\n", "\n", "\r" ), '', $tag );
			
			
			
			if (empty ( $tag ))
				continue;
				
				
				
				$tagname='';
				if(strstr($tag,'|')){
					$_tagtmp=explode('|', trim ( $tag ));
					$tagname =$_tagtmp[0] ;
					$tagalias=$_tagtmp[1] ;
				}else{
					$tagname = trim ( $tag );
					$tagalias=$this->getPinyin($tagname);
				}
				
				
				$tagalias = preg_replace ( '# #', '',$tagalias ); // 标签别名
				//通过别名查询标签别名是否重复
				$tag1 = $this->tag_model->get_by_tagalias ( $tagalias );
				if($tag1){
					$strresult.= $tagname."标签别名".$tagalias."已经存在!\r\n";
					$tagalias=$tagalias.time();
					continue;
				}
				
				
				
				//查询标签名是否存在
				$tag2 = $this->tag_model->get_by_tagname ( $tagname );
				if($tag2){
					$strresult.= $tagname."标签名称已经存在!\r\n";
					continue;
				}
				
				
				
				$title=$tagname."标签相关问题和文章知识库列表";
				$description='';
				$keywords=$tagname;
				$tagimage='';
				if($tagalias){
					$firstchar=$this->getfirstchar($tagalias);
				}else{
					$firstchar=$this->getfirstchar($tagname);
				}
				if($tagalias!=''){
					$data=array('time'=>time(),'tagfisrtchar'=>$firstchar,'tagimage'=>$tagimage,'tagname'=>$tagname,'tagalias'=>$tagalias,'title'=>$title,'keywords'=>$keywords,'description'=>$description);
					$id=$this->db->insert ( 'tag', $data );
					$lastsql=$this->db->last_query();
					
					//$id=$this->tag_model->addtag($tagname,$tagalias,$title,$description,$keywords,$tagimage);
					if($id){
						$strresult.= $tagname."标签插入成功!\r\n";
					}else{
						$strresult.= $tagname."标签插入失败!\r\n";
					}
				}else{
					$strresult.= $tagname."标签别名生成失败!\r\n";
				}
				
				
		}
		$message['code']=200;
		$message['message']=$strresult ;
		echo json_encode($message);
		exit();
	}
	/**
	
	* 批量添加标签
	
	* @date: 2018年11月23日 下午2:30:06
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function muttadd(){
		include template ( 'mutttagadd', 'admin' );
	}
	function add(){
		if (null !== $this->input->post ( 'submit' )) {
			$tagname = trim ( $this->input->post ( 'tagname' ) ); //标签名
			$tagalias = trim ( $this->input->post ( 'tagalias' ) ); //标签别名
			$title = trim ( $this->input->post ( 'title' ) ); //标签标题
			$description = trim ( $this->input->post ( 'description' ) ); //标签描述
			$keywords = trim ( $this->input->post ( 'keywords' ) ); //标签关键词
			if($tagname==''){
				$this->message ( "标签名称不能为空!", 'admin_tag/add' );
			}
			if($tagalias==''){
				$this->message ( "标签别名不能为空!", 'admin_tag/add' );
			}
			
			$tagalias=$this->getPinyin($tagalias);
			$tagalias = preg_replace ( '# #', '',$tagalias ); // 标签别名
			
			if($title==''){
				$this->message ( "标签seo标题不能为空!", 'admin_tag/add' );
			}
			$title=str_replace('，', ',', $title); //将中文逗号替换成英文逗号
			
			//通过别名查询标签别名是否重复
			$tag1 = $this->tag_model->get_by_tagalias ( $tagalias );
			if($tag1){
				$this->message ( "标签别名已经存在，请修改!", 'admin_tag/add' );
			}
			
			
			
			//查询标签名是否存在
			$tag2 = $this->tag_model->get_by_tagname ( $tagname );
			if($tag2){
				$this->message ( "标签名称已经存在，请修改!", 'admin_tag/add' );
			}
			
			
			
			$tagimage=null;
			if ($_FILES ["tagimage"]['name'] != '') {
				$uid = time();
				
				$avatardir = "/data/tags/";
				if(!is_dir(FCPATH.$avatardir)){
					forcemkdir($avatardir);
					
				}
				$extname = extname ( $_FILES ["tagimage"] ["name"] );
				
				if (! isimage ( $extname ))
					$this->message ( "图片扩展名不正确!", 'admin_tag/add' );
					$upload_tmp_file = FCPATH . '/data/tmp/tag_' . $uid . '.' . $extname;
					$uid = abs ( $uid );
					$uid = sprintf ( "%09d", $uid );
					$dir1 = $avatardir . substr ( $uid, 0, 3 );
					$dir2 = $dir1 . '/' . substr ( $uid, 3, 2 );
					$dir3 = $dir2 . '/' . substr ( $uid, 5, 2 );
					(! is_dir ( FCPATH . $dir1 )) && forcemkdir ( FCPATH . $dir1 );
					(! is_dir ( FCPATH . $dir2 )) && forcemkdir ( FCPATH . $dir2 );
					(! is_dir ( FCPATH . $dir3 )) && forcemkdir ( FCPATH . $dir3 );
					$bigimg = $dir3 . "/big_" . $uid . '.' . $extname;
					$smallimg = $dir3 . "/small_" . $uid . '.' . $extname;
					
					if (move_uploaded_file ( $_FILES ["tagimage"] ["tmp_name"], $upload_tmp_file )) {
						
						$avatar_dir = glob ( FCPATH . $dir3 . "/small_{$uid}.*" );
						
						foreach ( $avatar_dir as $imgfile ) {
							
							if (strtolower ( $extname ) != extname ( $imgfile ))
								unlink ( $imgfile );
						}
						
						image_resize ( $upload_tmp_file, FCPATH . $bigimg, 195, 195, 1 );
						
						image_resize ( $upload_tmp_file, FCPATH . $smallimg, 32, 32, 1 );
						
					}
					$tagimage=$bigimg;
					
			}
			
			$id=$this->tag_model->addtag($tagname,$tagalias,$title,$description,$keywords,$tagimage);
			if($id>0){
				$this->message ( "标签添加成功!", 'admin_tag' );
			}else{
				$this->message ( "标签添加失败!", 'admin_tag' );
			}
		}
		include template ( 'tagadd', 'admin' );
	}
	/**
	
	* 标签编辑
	
	* @date: 2018年11月7日 下午4:29:55
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function edit(){
		$tagalias =strtolower(trim(htmlspecialchars ( $this->uri->segments [3] )));
		$tagalias=$this->getPinyin($tagalias);
		$tagalias = preg_replace ( '# #', '',$tagalias ); // 标签别名
		// 通过标签别名查询标签
		$tag = $this->tag_model->get_by_tagalias ( $tagalias );
		if(!$tag){
			$url=url("tags");
			header ( 'HTTP/1.1 404 Not Found' );
			header ( "status: 404 Not Found" );
			echo '<!DOCTYPE html><html><head><meta charset=utf-8 /><title>404-您访问的页面不存在</title>';
			echo "<style>body { background-color: #ECECEC; font-family: 'Open Sans', sans-serif;font-size: 14px; color: #3c3c3c;}";
			echo ".nullpage p:first-child {text-align: center; font-size: 150px;  font-weight: bold;  line-height: 100px; letter-spacing: 5px; color: #fff;}";
			echo ".nullpage p:not(:first-child) {text-align: center;color: #666;";
			echo "font-family: cursive;font-size: 20px;text-shadow: 0 1px 0 #fff;  letter-spacing: 1px;line-height: 2em;margin-top: -50px;}";
			echo ".nullpage p a{margin-left:10px;font-size:20px;}";
			echo '</style></head><body> <div class="nullpage"><p><span>4</span><span>0</span><span>4</span></p><p>标签已经被删除！⊂((δ⊥δ))⊃<a href="'.$url.'">返回标签页面</a></p></div></body></html>';
			exit ();
			
		}
		if (null !== $this->input->post ( 'submit' )) {
			$tagname = trim ( $this->input->post ( 'tagname' ) ); //标签名
			$_tagalias = trim ( $this->input->post ( 'tagalias' ) ); //标签别名
			$title = trim ( $this->input->post ( 'title' ) ); //标签标题
			$description = trim ( $this->input->post ( 'description' ) ); //标签描述
			$keywords = trim ( $this->input->post ( 'keywords' ) ); //标签关键词
			if($tagname==''){
				$this->message ( "标签名称不能为空!", 'admin_tag/edit/'.$tagalias );
			}
			if($_tagalias==''){
				$this->message ( "标签别名不能为空!", 'admin_tag/edit/'.$tagalias );
			}
			if($title==''){
				$this->message ( "标签seo标题不能为空!", 'admin_tag/edit/'.$tagalias );
			}
			$title=str_replace('，', ',', $title); //将中文逗号替换成英文逗号
			if($_tagalias!=$tagalias){
				//通过别名查询标签别名是否重复
				$tag1 = $this->tag_model->get_by_tagalias ( $_tagalias );
				if($tag1){
					$this->message ( "标签别名已经存在，请修改!", 'admin_tag/edit/'.$tagalias );
				}
			}
			
			if($tagname!=$tag['tagname']){
				//查询标签名是否存在
				$tag2 = $this->tag_model->get_by_tagname ( $tagname );
				if($tag2){
					$this->message ( "标签名称已经存在，请修改!", 'admin_tag/edit/'.$tagalias );
				}
			}
			
			
			$tagimage=null;
			if ($_FILES ["tagimage"]['name'] != '') {
				$uid = $tag['id'];
				
				$avatardir = "/data/tags/";
				if(!is_dir(FCPATH.$avatardir)){
					forcemkdir($avatardir);
					
				}
				$extname = extname ( $_FILES ["tagimage"] ["name"] );
				
				if (! isimage ( $extname ))
					$this->message ( "图片扩展名不正确!", 'admin_tag/edit/'.$tagalias );
					$upload_tmp_file = FCPATH . '/data/tmp/tag_' . $uid . '.' . $extname;
					$uid = abs ( $uid );
					$uid = sprintf ( "%09d", $uid );
					$dir1 = $avatardir . substr ( $uid, 0, 3 );
					$dir2 = $dir1 . '/' . substr ( $uid, 3, 2 );
					$dir3 = $dir2 . '/' . substr ( $uid, 5, 2 );
					(! is_dir ( FCPATH . $dir1 )) && forcemkdir ( FCPATH . $dir1 );
					(! is_dir ( FCPATH . $dir2 )) && forcemkdir ( FCPATH . $dir2 );
					(! is_dir ( FCPATH . $dir3 )) && forcemkdir ( FCPATH . $dir3 );
					$bigimg = $dir3 . "/big_" . $uid . '.' . $extname;
					$smallimg = $dir3 . "/small_" . $uid . '.' . $extname;
					
					if (move_uploaded_file ( $_FILES ["tagimage"] ["tmp_name"], $upload_tmp_file )) {
						
						$avatar_dir = glob ( FCPATH . $dir3 . "/small_{$uid}.*" );
						
						foreach ( $avatar_dir as $imgfile ) {
							
							if (strtolower ( $extname ) != extname ( $imgfile ))
								unlink ( $imgfile );
						}
						
						image_resize ( $upload_tmp_file, FCPATH . $bigimg, 195, 195, 1 );
						
						image_resize ( $upload_tmp_file, FCPATH . $smallimg, 32, 32, 1 );
						
					}
					$tagimage=$bigimg;
					
			}
			if(!$tagimage){
				$tagimage=$tag['tagimage'];
			}
			
			$this->tag_model->updatetag($tag['id'],$tagname,$_tagalias,$title,$description,$keywords,$tagimage);
			$this->message ( "标签修改成功!", 'admin_tag' );
		}
		include template ( 'tagedit', 'admin' );
	}
	function changepinyin() {
		$names = trim ( $this->input->post ('spname'), ',' );
		$name = trim ( $this->input->post ('name'), ',' );
		$id = trim ( $this->input->post ('id'), ',' );
		$char_split = '';
		$_name_arr = explode ( ',', $names );
		for($i = 0; $i < count ( $_name_arr ); $i ++) {
			$char_split = $char_split . $this->getfirstchar ( $_name_arr [$i] );
			
		}
		
		$pinyin = $char_split;
		
		$pinyin = 'q_' . $pinyin . '_' . $id;
		
		$this->db->query ( "UPDATE " . $this->db->dbprefix . "question_tag SET  `pinyin`='$pinyin' WHERE `name`='$name'" );
		echo $pinyin;
		exit ();
	}
	function delete() {
		$msg = '';
		if (null!== $this->input->post ('delete') ) {
			$this->tag_model->remove_by_id ( $this->input->post ('delete') );
			$message = '标签刪除成功！';
		}
		$this->index ( $message );
	}
	function getfirstchar($s0) {
		$firstchar_ord = ord ( strtoupper ( $s0 {0} ) );
		if (($firstchar_ord >= 65 and $firstchar_ord <= 91) or ($firstchar_ord >= 48 and $firstchar_ord <= 57))
			return $s0 {0};
			$s = iconv ( "UTF-8", "gb2312", $s0 );
			$asc = ord ( $s {0} ) * 256 + ord ( $s {1} ) - 65536;
			if ($asc >= - 20319 and $asc <= - 20284)
				return "a";
				if ($asc >= - 20283 and $asc <= - 19776)
					return "b";
					if ($asc >= - 19775 and $asc <= - 19219)
						return "c";
						if ($asc >= - 19218 and $asc <= - 18711)
							return "d";
							if ($asc >= - 18710 and $asc <= - 18527)
								return "e";
								if ($asc >= - 18526 and $asc <= - 18240)
									return "f";
									if ($asc >= - 18239 and $asc <= - 17923)
										return "g";
										if ($asc >= - 17922 and $asc <= - 17418)
											return "h";
											if ($asc >= - 17417 and $asc <= - 16475)
												return "j";
												if ($asc >= - 16474 and $asc <= - 16213)
													return "k";
													if ($asc >= - 16212 and $asc <= - 15641)
														return "l";
														if ($asc >= - 15640 and $asc <= - 15166)
															return "m";
															if ($asc >= - 15165 and $asc <= - 14923)
																return "m";
																if ($asc >= - 14922 and $asc <= - 14915)
																	return "o";
																	if ($asc >= - 14914 and $asc <= - 14631)
																		return "p";
																		if ($asc >= - 14630 and $asc <= - 14150)
																			return "q";
																			if ($asc >= - 14149 and $asc <= - 14091)
																				return "r";
																				if ($asc >= - 14090 and $asc <= - 13319)
																					return "s";
																					if ($asc >= - 13318 and $asc <= - 12839)
																						return "t";
																						if ($asc >= - 12838 and $asc <= - 12557)
																							return "w";
																							if ($asc >= - 12556 and $asc <= - 11848)
																								return "x";
																								if ($asc >= - 11847 and $asc <= - 11056)
																									return "y";
																									if ($asc >= - 11055 and $asc <= - 10247)
																										return "z";
																										return null;
	}
	private $_outEncoding = "GB2312";
	public function getPinyin($str, $pix = ' ', $code = 'gb2312') {
		$_DataKey = "a|ai|an|ang|ao|ba|bai|ban|bang|bao|bei|ben|beng|bi|bian|biao|bie|bin|bing|bo|bu|ca|cai|can|cang|cao|ce|ceng|cha" . "|chai|chan|chang|chao|che|chen|cheng|chi|chong|chou|chu|chuai|chuan|chuang|chui|chun|chuo|ci|cong|cou|cu|" . "cuan|cui|cun|cuo|da|dai|dan|dang|dao|de|deng|di|dian|diao|die|ding|diu|dong|dou|du|duan|dui|dun|duo|e|en|er" . "|fa|fan|fang|fei|fen|feng|fo|fou|fu|ga|gai|gan|gang|gao|ge|gei|gen|geng|gong|gou|gu|gua|guai|guan|guang|gui" . "|gun|guo|ha|hai|han|hang|hao|he|hei|hen|heng|hong|hou|hu|hua|huai|huan|huang|hui|hun|huo|ji|jia|jian|jiang" . "|jiao|jie|jin|jing|jiong|jiu|ju|juan|jue|jun|ka|kai|kan|kang|kao|ke|ken|keng|kong|kou|ku|kua|kuai|kuan|kuang" . "|kui|kun|kuo|la|lai|lan|lang|lao|le|lei|leng|li|lia|lian|liang|liao|lie|lin|ling|liu|long|lou|lu|lv|luan|lue" . "|lun|luo|ma|mai|man|mang|mao|me|mei|men|meng|mi|mian|miao|mie|min|ming|miu|mo|mou|mu|na|nai|nan|nang|nao|ne" . "|nei|nen|neng|ni|nian|niang|niao|nie|nin|ning|niu|nong|nu|nv|nuan|nue|nuo|o|ou|pa|pai|pan|pang|pao|pei|pen" . "|peng|pi|pian|piao|pie|pin|ping|po|pu|qi|qia|qian|qiang|qiao|qie|qin|qing|qiong|qiu|qu|quan|que|qun|ran|rang" . "|rao|re|ren|reng|ri|rong|rou|ru|ruan|rui|run|ruo|sa|sai|san|sang|sao|se|sen|seng|sha|shai|shan|shang|shao|" . "she|shen|sheng|shi|shou|shu|shua|shuai|shuan|shuang|shui|shun|shuo|si|song|sou|su|suan|sui|sun|suo|ta|tai|" . "tan|tang|tao|te|teng|ti|tian|tiao|tie|ting|tong|tou|tu|tuan|tui|tun|tuo|wa|wai|wan|wang|wei|wen|weng|wo|wu" . "|xi|xia|xian|xiang|xiao|xie|xin|xing|xiong|xiu|xu|xuan|xue|xun|ya|yan|yang|yao|ye|yi|yin|ying|yo|yong|you" . "|yu|yuan|yue|yun|za|zai|zan|zang|zao|ze|zei|zen|zeng|zha|zhai|zhan|zhang|zhao|zhe|zhen|zheng|zhi|zhong|" . "zhou|zhu|zhua|zhuai|zhuan|zhuang|zhui|zhun|zhuo|zi|zong|zou|zu|zuan|zui|zun|zuo";
		$_DataValue = "-20319|-20317|-20304|-20295|-20292|-20283|-20265|-20257|-20242|-20230|-20051|-20036|-20032|-20026|-20002|-19990" . "|-19986|-19982|-19976|-19805|-19784|-19775|-19774|-19763|-19756|-19751|-19746|-19741|-19739|-19728|-19725" . "|-19715|-19540|-19531|-19525|-19515|-19500|-19484|-19479|-19467|-19289|-19288|-19281|-19275|-19270|-19263" . "|-19261|-19249|-19243|-19242|-19238|-19235|-19227|-19224|-19218|-19212|-19038|-19023|-19018|-19006|-19003" . "|-18996|-18977|-18961|-18952|-18783|-18774|-18773|-18763|-18756|-18741|-18735|-18731|-18722|-18710|-18697" . "|-18696|-18526|-18518|-18501|-18490|-18478|-18463|-18448|-18447|-18446|-18239|-18237|-18231|-18220|-18211" . "|-18201|-18184|-18183|-18181|-18012|-17997|-17988|-17970|-17964|-17961|-17950|-17947|-17931|-17928|-17922" . "|-17759|-17752|-17733|-17730|-17721|-17703|-17701|-17697|-17692|-17683|-17676|-17496|-17487|-17482|-17468" . "|-17454|-17433|-17427|-17417|-17202|-17185|-16983|-16970|-16942|-16915|-16733|-16708|-16706|-16689|-16664" . "|-16657|-16647|-16474|-16470|-16465|-16459|-16452|-16448|-16433|-16429|-16427|-16423|-16419|-16412|-16407" . "|-16403|-16401|-16393|-16220|-16216|-16212|-16205|-16202|-16187|-16180|-16171|-16169|-16158|-16155|-15959" . "|-15958|-15944|-15933|-15920|-15915|-15903|-15889|-15878|-15707|-15701|-15681|-15667|-15661|-15659|-15652" . "|-15640|-15631|-15625|-15454|-15448|-15436|-15435|-15419|-15416|-15408|-15394|-15385|-15377|-15375|-15369" . "|-15363|-15362|-15183|-15180|-15165|-15158|-15153|-15150|-15149|-15144|-15143|-15141|-15140|-15139|-15128" . "|-15121|-15119|-15117|-15110|-15109|-14941|-14937|-14933|-14930|-14929|-14928|-14926|-14922|-14921|-14914" . "|-14908|-14902|-14894|-14889|-14882|-14873|-14871|-14857|-14678|-14674|-14670|-14668|-14663|-14654|-14645" . "|-14630|-14594|-14429|-14407|-14399|-14384|-14379|-14368|-14355|-14353|-14345|-14170|-14159|-14151|-14149" . "|-14145|-14140|-14137|-14135|-14125|-14123|-14122|-14112|-14109|-14099|-14097|-14094|-14092|-14090|-14087" . "|-14083|-13917|-13914|-13910|-13907|-13906|-13905|-13896|-13894|-13878|-13870|-13859|-13847|-13831|-13658" . "|-13611|-13601|-13406|-13404|-13400|-13398|-13395|-13391|-13387|-13383|-13367|-13359|-13356|-13343|-13340" . "|-13329|-13326|-13318|-13147|-13138|-13120|-13107|-13096|-13095|-13091|-13076|-13068|-13063|-13060|-12888" . "|-12875|-12871|-12860|-12858|-12852|-12849|-12838|-12831|-12829|-12812|-12802|-12607|-12597|-12594|-12585" . "|-12556|-12359|-12346|-12320|-12300|-12120|-12099|-12089|-12074|-12067|-12058|-12039|-11867|-11861|-11847" . "|-11831|-11798|-11781|-11604|-11589|-11536|-11358|-11340|-11339|-11324|-11303|-11097|-11077|-11067|-11055" . "|-11052|-11045|-11041|-11038|-11024|-11020|-11019|-11018|-11014|-10838|-10832|-10815|-10800|-10790|-10780" . "|-10764|-10587|-10544|-10533|-10519|-10331|-10329|-10328|-10322|-10315|-10309|-10307|-10296|-10281|-10274" . "|-10270|-10262|-10260|-10256|-10254";
		$_TDataKey = explode ( '|', $_DataKey );
		$_TDataValue = explode ( '|', $_DataValue );
		$data = (PHP_VERSION >= '5.0') ? array_combine ( $_TDataKey, $_TDataValue ) : $this->_Array_Combine ( $_TDataKey, $_TDataValue );
		arsort ( $data );
		reset ( $data );
		$str = $this->safe_encoding ( $str );
		$_Res = '';
		for($i = 0; $i < strlen ( $str ); $i ++) {
			$_P = ord ( substr ( $str, $i, 1 ) );
			if ($_P > 160) {
				$_Q = ord ( substr ( $str, ++ $i, 1 ) );
				$_P = $_P * 256 + $_Q - 65536;
			}
			$_Res .= $this->_Pinyin ( $_P, $data ) . $pix;
		}
		return preg_replace ( "/[^a-z0-9" . $pix . "]*/", '', $_Res );
	}
	private function _Pinyin($_Num, $_Data) {
		if ($_Num > 0 && $_Num < 160)
			return chr ( $_Num );
			elseif ($_Num < - 20319 || $_Num > - 10247)
			return '';
			else {
				foreach ( $_Data as $k => $v ) {
					if ($v <= $_Num)
						break;
				}
				return $k;
			}
	}
	function safe_encoding($string) {
		$encoding = "UTF-8";
		for($i = 0; $i < strlen ( $string ); $i ++) {
			if (ord ( $string {$i} ) < 128)
				continue;
				if ((ord ( $string {$i} ) & 224) == 224) { // 第一个字节判断通过
					$char = $string {++ $i};
					if ((ord ( $char ) & 128) == 128) { // 第二个字节判断通过
						$char = $string {++ $i};
						if ((ord ( $char ) & 128) == 128) {
							$encoding = "UTF-8";
							break;
						}
					}
				}
				if ((ord ( $string {$i} ) & 192) == 192) { // 第一个字节判断通过
					$char = $string {++ $i};
					if ((ord ( $char ) & 128) == 128) { // 第二个字节判断通过
						$encoding = "GB2312";
						break;
					}
				}
		}
		if (strtoupper ( $encoding ) == strtoupper ( $this->_outEncoding ))
			return $string;
			else
				return iconv ( $encoding, $this->_outEncoding, $string );
	}
	private function _Array_Combine($_Arr1, $_Arr2) {
		for($i = 0; $i < count ( $_Arr1 ); $i ++)
			$_Res [$_Arr1 [$i]] = $_Arr2 [$i];
			return $_Res;
	}
	
}

?>