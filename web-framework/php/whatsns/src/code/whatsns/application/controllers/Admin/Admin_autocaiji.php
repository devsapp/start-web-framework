<?php
ini_set ( 'user_agent', 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; Win64; x64; .NET CLR 2.0.50727; SLCC1; Media Center PC 5.0; .NET CLR 3.0.30618; .NET CLR 3.5.30729)' );
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Admin_autocaiji extends ADMIN_Controller {
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
		$this->load->model ( "tag_model" );
		$this->load->model ( "topic_model" );
		$this->load->model ( "question_model" );
		$this->load->model ( "doing_model" );
		$this->load->model ( "category_model" );
		$this->load->model ( 'answer_model' );
		$this->load->model ( 'answer_comment_model' );
	}
	/**
	
	* 用户管理列表中上传头像
	
	* @date: 2020年10月6日 下午9:21:36
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function updateuseravatar(){
		if($_FILES['file']){
			$uid = intval ( $_POST['uid'] );
			
			$avatardir = "/data/avatar/";
			$extname = extname ( $_FILES ["file"] ["name"] );
			if (! isimage ( $extname )){
				$message['code']=400;
				$message['msg']=$extname."图片后缀不支持";
				echo json_encode($message);
				exit();
			}
			
				$upload_tmp_file = FCPATH . 'data/tmp/user_avatar_' . $uid . '.' . $extname;
				$uid = abs ( $uid );
				$uid = sprintf ( "%09d", $uid );
				$dir1 = $avatardir . substr ( $uid, 0, 3 );
				$dir2 = $dir1 . '/' . substr ( $uid, 3, 2 );
				$dir3 = $dir2 . '/' . substr ( $uid, 5, 2 );
				(! is_dir ( FCPATH . $dir1 )) && forcemkdir ( FCPATH . $dir1 );
				(! is_dir ( FCPATH . $dir2 )) && forcemkdir ( FCPATH . $dir2 );
				(! is_dir ( FCPATH . $dir3 )) && forcemkdir ( FCPATH . $dir3 );
				$smallimg = $dir3 . "/small_" . $uid . '.' . $extname;
				if (move_uploaded_file ( $_FILES ["file"] ["tmp_name"], $upload_tmp_file )) {
					$avatar_dir = glob ( FCPATH . $dir3 . "/small_{$uid}.*" );
					foreach ( $avatar_dir as $imgfile ) {
						if (strtolower ( $extname ) != extname ( $imgfile ))
							unlink ( $imgfile );
					}
					image_resize ( $upload_tmp_file, FCPATH . $smallimg, 200, 200, 1 );
					$message['code']=200;
					$message['uid']=$uid;
					$message['src']=get_avatar_dir($uid)."?rand=".rand(1,100);
					$message['msg']="上传成功";
					echo json_encode($message);
					exit();
				}
		}else{
			$message['code']=400;
			$message['msg']="未添加上传图片";
			echo json_encode($message);
			exit();
		}
		
	}
	/**
	
	* 前端提交头像处理
	
	* @date: 2020年10月6日 下午1:43:00
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function makeavatar(){
		$avatarurl=trim($_POST['url']);
		if(empty($avatarurl)||$avatarurl==''){
			$message['code']=400;
			$message['msg']="生成头像地址为空";
			echo json_encode($message);
			exit();
		}
		$majia=$this->db->get_where('user',array("fromsite"=>1,"majiahasavatar"=>0))->row_array();
		if(!$majia){
			$message['code']=400;
			$message['msg']="当前没有需要生成的马甲了";
			echo json_encode($message);
			exit();
		}
		//如果有需要处理的马甲
		$uid=$majia['uid'];
		$this->setAvatar($avatarurl,$uid);
		$message['avatar']=$avatarurl;
		$message['uid']=$majia['uid'];
		$message['spaceurl']=url("user/space/".$majia['uid']);
		$message['username']=$majia['username'];
		
		$tmpfile = get_avatar_dir ($uid );
		//如果已经生成生成更新用户表头像索引
		if (strpos ( $tmpfile, 'gif' ) <= 0) {
			//更新马甲头像索引
			$this->db->where(array('uid'=>$uid,'fromsite'=>1))->update('user',array('majiahasavatar'=>1));
			$message['code']=200;
			$message['msg']=$majia['username']."--马甲头像更新成功";
			echo json_encode($message);
			exit();
		}else{
			$message['code']=400;
			$message['msg']=$majia['user']."--马甲头像更新失败";
			echo json_encode($message);
			exit();
		}
	}
	/**
	 *
	 * 设置马甲头像
	 *
	 * @date: 2019年7月2日 上午10:07:45
	 *
	 * @author : 61703
	 *
	 * @param
	 *        	: variable
	 *
	 * @return :
	 *
	 */
	function avatarset() {
		//	$this->setAvatar("https://ss1.bdstatic.com/70cFvXSh_Q1YnxGkpoWK1HF6hhy/it/u=3822091633,4134064486&fm=26&gp=0.jpg",162409);
		
		//	exit();
		$avatarlist=array();
		$avataruserlist=array();
		if($_POST['keyword']){
			$kname=trim($_POST['keyword']);
			if($kname==''||empty($kname)){
				$this->message("请输入关键词+头像 搜索,如：美女头像");
				exit();
			}
			$setmode=intval($_POST['setmode']);
			if(!strstr($kname,"头像")){
				$kname=$kname."头像";
			}
			$strjosn= file_get_contents("https://image.baidu.com/search/acjson?tn=resultjson_com&logid=10695385866081272703&ipn=rj&ct=201326592&is=&fp=result&queryWord=$kname&cl=&lm=&ie=utf-8&oe=utf-8&adpicid=&st=&z=&ic=&hd=&latest=&copyright=&word=$kname&s=&se=&tab=&width=&height=&face=&istype=&qc=&nc=&fr=&expermode=&force=&cg=head&pn=0&rn=120&gsm=168&1601953239748=");
			if($strjosn){
				$jsonarr=json_decode($strjosn,true);
				foreach ($jsonarr['data'] as $avataritem){
					if($avataritem['middleURL']){
						//$this->setAvatar("https://ss1.bdstatic.com/70cFvXSh_Q1YnxGkpoWK1HF6hhy/it/u=3822091633,4134064486&fm=26&gp=0.jpg",3);
						array_push($avatarlist, $avataritem['middleURL']);
						
					}
				}
				
				
			}
			$strjosn1= file_get_contents("https://image.baidu.com/search/acjson?tn=resultjson_com&logid=10695385866081272703&ipn=rj&ct=201326592&is=&fp=result&queryWord=$kname&cl=&lm=&ie=utf-8&oe=utf-8&adpicid=&st=&z=&ic=&hd=&latest=&copyright=&word=$kname&s=&se=&tab=&width=&height=&face=&istype=&qc=&nc=&fr=&expermode=&force=&cg=head&pn=60&rn=120&gsm=168&1601953239748=");
			if($strjosn1){
				$jsonarr=json_decode($strjosn1,true);
				foreach ($jsonarr['data'] as $avataritem){
					if($avataritem['middleURL']){
						//$this->setAvatar("https://ss1.bdstatic.com/70cFvXSh_Q1YnxGkpoWK1HF6hhy/it/u=3822091633,4134064486&fm=26&gp=0.jpg",3);
						array_push($avatarlist, $avataritem['middleURL']);
					}
				}
			}
			//根据头像长度输出等比例马甲
			$pagesize=count($avatarlist);
			if($pagesize){
				
				if($setmode){
					//如果设置成直接抓取并生成，则直接生成马甲头像
					$query = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "user where fromsite=1 and majiahasavatar=0  LIMIT 0,$pagesize" );
					$majialuser=array();
					$i=0;
					foreach ( $query->result_array () as $user ) {
						$this->setAvatar($avatarlist[$i],$user['uid']);
						$majialuser['avatar']=$avatarlist[$i];
						$majialuser['uid']=$user['uid'];
						$majialuser['username']=$user['username'];
						array_push($avataruserlist, $majialuser);
						$tmpfile = get_avatar_dir ( $user['uid'] );
						//如果已经生成生成更新用户表头像索引
						if (strpos ( $tmpfile, 'gif' ) <= 0) {
							//更新马甲头像索引
							$this->db->where(array('uid'=> $user['uid'],'fromsite'=>1))->update('user',array('majiahasavatar'=>1));
						}
						$i++;
					}
				}
			}
			
			
		}else{
			$sql = "alter table " . $this->db->dbprefix . "user add COLUMN majiahasavatar int(2)  DEFAULT 0;";
			$this->db->query($sql);
			$sql="ALTER  TABLE  `" . $this->db->dbprefix . "user`  ADD  INDEX majiahasavatar  (  `majiahasavatar`  )";
			$this->db->query($sql);
			
		}
		//查询未生成头像马甲个数
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'user', " fromsite=1 and majiahasavatar=0 ", $this->db->dbprefix ) )->row_array () );
		
		include template ( "autoplusmajia_avatar", "admin" );
	}
	function setAvatar($upload_tmp_file,$uid) {
		
		$uid = intval ( $uid );
		$tmpfile = get_avatar_dir ( $uid );
		if (strpos ( $tmpfile, 'gif' ) <= 0) {
			return;
		}
		$avatardir = "/data/avatar/";
		$extname = "jpg";
		$uid = abs ( $uid );
		$uid = sprintf ( "%09d", $uid );
		$dir1 = $avatardir . substr ( $uid, 0, 3 );
		$dir2 = $dir1 . '/' . substr ( $uid, 3, 2 );
		$dir3 = $dir2 . '/' . substr ( $uid, 5, 2 );
		(! is_dir ( FCPATH . $dir1 )) && forcemkdir ( FCPATH . $dir1 );
		(! is_dir ( FCPATH . $dir2 )) && forcemkdir ( FCPATH . $dir2 );
		(! is_dir ( FCPATH . $dir3 )) && forcemkdir ( FCPATH . $dir3 );
		$smallimg = $dir3 . "/small_" . $uid . '.' . $extname;
		
		$avatar_dir = glob ( FCPATH . $dir3 . "/small_{$uid}.*" );
		foreach ( $avatar_dir as $imgfile ) {
			if (strtolower ( $extname ) != extname ( $imgfile ))
				unlink ( $imgfile );
		}
		
		image_resize ( $upload_tmp_file, FCPATH . $smallimg, 200, 200, 1 );
		
	}
	function getavatarfolders() {
		$file = array ();
		$file_dir = FCPATH . "data/majia_avatar";
		$shili = $file_dir;
		if (! file_exists ( $shili )) {
			return '0';
		} else {
			$i = 0;
			if (is_dir ( $shili )) { // 检测是否是合法目录
				if ($shi = opendir ( $shili )) { // 打开目录
					while ( $li = readdir ( $shi ) ) { // 读取目录
						if (strpos ( $li, 'jpg' ) > 0 || strpos ( $li, 'png' ) > 0 || strpos ( $li, 'jpeg' ) > 0)
							array_push ( $file, $li );
					}
				}
			} // 输出目录中的内容
			closedir ( $shi );
			return $file;
		}
	}
	function addtest() {
		// $sql = "INSERT INTO `" . $this->db->dbprefix . "autocaiji` ( `caiji_url`, `tiwenshijian`, `huidashijian`, `caiji_prefix`, `category1`, `category2`, `category3`, `cid`, `ckabox`, `imgckabox`, `bianma`, `guize`, `daanyuming`, `daandesc`, `caiji_best`, `caiji_hdusername`, `caiji_hdusertx`, `source`) VALUES
		// ( 'http://wenda.so.com/c/', 1, 20, '.question-list .qus-title a[href*=''/q/'']', 1, 0, 0, 1, 1, 0, 'utf-8', '.other-ans-cnt', 'http://wenda.so.com', '.q-cnt', '.resolved-cnt', '.answers > .ask-author', ' .answers >.pic >img', '360问答全部分类页面')";
		$sql = "INSERT INTO `" . $this->db->dbprefix . "autocaiji` VALUES (16,'http://wenda.so.com/c/',1,20,'.question-list .qus-title a[href*=\'/q/\']',1,0,0,1,0,0,'utf-8','.other-ans-cnt','http://wenda.so.com','.q-cnt','.resolved-cnt','.answers > .ask-author',' .answers >.pic >img','360问答全部分类页面',NULL,NULL,NULL,NULL,0,NULL),(17,'http://www.sporttery.cn/zixun/index.html',1,20,'.ul-com a[href*=\'/football/\']',1,0,0,1,1,0,'utf-8','h1','','.jc-article','','','','竞彩资讯_竞彩网',NULL,NULL,NULL,NULL,0,1),(20,'http://society.sohu.com/',1,20,'.news-box h4 a',1,0,0,1,0,0,'utf-8','h1','http:','.article','','','','搜狐-社会',NULL,NULL,NULL,NULL,0,1)";
		$this->db->query ( $sql );
		echo "测试规则添加成功";
		exit ();
	}
	function initautosql() {
		try {
			$sql = "
CREATE TABLE IF NOT EXISTS `" . $this->db->dbprefix . "autocaiji` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `caiji_url` varchar(100) NOT NULL COMMENT '采集网址',
  `tiwenshijian` int(11) NOT NULL COMMENT '提问时间',
  `huidashijian` int(11) NOT NULL COMMENT '回答时间',
  `caiji_prefix` varchar(100) NOT NULL COMMENT '采集列表规则',
  `category1` int(11) NOT NULL COMMENT '一级分类',
  `category2` int(11) NOT NULL COMMENT '2级分类',
  `category3` int(11) NOT NULL COMMENT '3级分类',
  `cid` int(11) NOT NULL COMMENT '当前选择的分类id',
  `ckabox` int(11) NOT NULL COMMENT '过滤回答超链接',
  `imgckabox` int(11) NOT NULL COMMENT '过滤图片',
  `bianma` varchar(100) NOT NULL COMMENT '网页编码',
  `guize` varchar(100) NOT NULL COMMENT '其它回答',
  `daanyuming` varchar(100) NOT NULL COMMENT '域名',
  `daandesc` varchar(100) NOT NULL COMMENT '描述',
  `caiji_best` varchar(100) NOT NULL COMMENT '最佳答案',
  `caiji_hdusername` varchar(100) NOT NULL COMMENT '采集用户名',
  `caiji_hdusertx` varchar(100) NOT NULL COMMENT '采集头像',
  `source` varchar(100) NOT NULL COMMENT '采集来源',
     `biaotiguolv` text NOT NULL COMMENT '标题过滤',
      `miaosuguolv` text NOT NULL COMMENT '问题描述过滤',
        `neirongguolv` text NOT NULL COMMENT '问题回答过滤',
        `usernameguolv` text NOT NULL COMMENT '用户名过滤',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
    	";
			$this->db->query ( $sql );
			$sql_bankcard = "alter table " . $this->db->dbprefix . "autocaiji add COLUMN caijitype int(10) DEFAULT 0;";
			$this->db->query ( $sql_bankcard );
			$this->db->query ( $sql );
			$sql_bankcard = "alter table " . $this->db->dbprefix . "autocaiji add COLUMN atitle int(10) DEFAULT 0;";
			$this->db->query ( $sql_bankcard );
			$this->db->query ( $sql );
			$sql_bankcard = "alter table " . $this->db->dbprefix . "autocaiji add COLUMN biaotiguolv text DEFAULT NULL;";
			$this->db->query ( $sql_bankcard );
			$sql_bankcard = "alter table " . $this->db->dbprefix . "autocaiji add COLUMN miaosuguolv text DEFAULT NULL;";
			$this->db->query ( $sql_bankcard );
			$sql_bankcard = "alter table " . $this->db->dbprefix . "autocaiji add COLUMN neirongguolv text DEFAULT NULL;";
			$this->db->query ( $sql_bankcard );
			$sql_bankcard = "alter table " . $this->db->dbprefix . "autocaiji add COLUMN usernameguolv text DEFAULT NULL;";
			$this->db->query ( $sql_bankcard );
		} catch ( Exception $e ) {
		}
	}
	function index() {
		$this->db->query ( "delete from " . $this->db->dbprefix . "autocaiji where id<=14" );
		@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = 100;
		$startindex = ($page - 1) * $pagesize;
		$caijilist = array ();
		$query = $this->db->query ( "select * from " . $this->db->dbprefix . "autocaiji order by id desc limit $startindex,$pagesize" );
		foreach ( $query->result_array () as $caiji ) {
			$cid = $caiji ['cid'];
			$category = $this->category [$cid]; // 得到分类信息
			$caiji ['categoryname'] = $category ['name'];
			$caijilist [] = $caiji;
		}
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( "autocaiji", "1=1", $this->db->dbprefix ) )->row_array () );
		$departstr = page ( $rownum, $pagesize, $page, "admin_autocaiji/default" );
		include template ( "autocaiji", "admin" );
	}
	function add() {
		$categoryjs = $this->category_model->get_js ();
		include template ( "autocaiji_add", "admin" );
	}
	function addwenzhang() {
		$categoryjs = $this->category_model->get_js ();
		include template ( "autocaiji_addwenzhang", "admin" );
	}
	function edit() {
		$categoryjs = $this->category_model->get_js ();
		$id = intval ( $this->uri->segment ( 3 ) );
		$caiji = $this->db->query ( "SELECT * FROM " . $this->db->dbprefix . "autocaiji WHERE id='$id'" )->row_array ();
		
		if ($caiji ['caijitype'] == 1) {
			include template ( "autocaiji_editwenzhang", "admin" );
		} else {
			include template ( "autocaiji_edit", "admin" );
		}
	}
	function del() {
		$message = array ();
		$id = intval ( $this->input->post ( 'id' ) );
		$did = $this->db->query ( "DELETE FROM " . $this->db->dbprefix . "autocaiji WHERE id='$id'" );
		$message ['msg'] = 'ok';
		echo json_encode ( $message );
	}
	// 采集列表
	function ajaxpostpage() {
		require 'simple_html_dom.php';
		// include 'lib/simple_html_dom.php';
		
		$caiji_url = $this->input->post ( "caiji_url" );
		$caiji_prefix = $this->input->post ( "caiji_prefix" );
		$bianma = $this->input->post ( 'bianma' );
		$ckbox = $this->input->post ( 'ckbox' );
		
		$html = file_get_html ( $caiji_url );
		
		$type_fill = $html->find ( $caiji_prefix );
		// echo $type_fill[0]->plaintext;
		
		// echo count($type_fill);
		$caijilist = array ();
		$count1 = 0;
		
		foreach ( $type_fill as $r ) {
			// echo $r->plaintext ;
			// break;
			$caijilist [$count1] ['num'] = $count1;
			if ($bianma == 'gb2312') {
				$caijilist [$count1] ['title'] = iconv ( 'gb2312', 'utf-8', $ckbox != 'true' ? $r->plaintext : $r->title );
			} else {
				$caijilist [$count1] ['title'] = $ckbox != 'true' ? $r->plaintext : $r->title;
			}
			$caijilist [$count1] ['href'] = $r->href;
			$count1 ++;
		}
		if (count ( $caijilist ) == 0) {
			$caijilist = null;
		}
		$html->clear ();
		echo json_encode ( $caijilist );
		exit ();
	}
	// 关注问题
	function attention_question($qid, $user_uid, $user_username) {
		$uid = $user_uid;
		$username = $user_username;
		$is_followed = $this->question_model->is_followed ( $qid, $uid );
		if ($is_followed) {
			$this->user_model->unfollow ( $qid, $uid );
		} else {
			$this->user_model->follow ( $qid, $uid, $username );
		}
	}
	function rand_time($a, $b) {
		$a = strtotime ( $a );
		$b = strtotime ( $b );
		return date ( "Y-m-d H:m:s", mt_rand ( $a, $b ) );
	}
	function fillter($str) {
		// $str=preg_replace("/\s+/", " ", $str); //过滤多余回车
		// $str=preg_replace("/<[ ]+/si","<",$str); //过滤<__("<"号后面带空格)
		// $str=preg_replace("/<\!–.*?–>/si","",$str); //注释
		$str = preg_replace ( "/<(\!.*?)>/si", "", $str ); // 过滤DOCTYPE
		$str = preg_replace ( "/<(\/?html.*?)>/si", "", $str ); // 过滤html标签
		$str = preg_replace ( "/<(\/?br.*?)>/si", "", $str ); // 过滤br标签
		$str = preg_replace ( "/<(\/?head.*?)>/si", "", $str ); // 过滤head标签
		$str = preg_replace ( "/<(\/?meta.*?)>/si", "", $str ); // 过滤meta标签
		$str = preg_replace ( "/<(\/?body.*?)>/si", "", $str ); // 过滤body标签
		$str = preg_replace ( "/<(\/?link.*?)>/si", "", $str ); // 过滤link标签
		$str = preg_replace ( "/<(\/?form.*?)>/si", "", $str ); // 过滤form标签
		$str = preg_replace ( "/cookie/si", "COOKIE", $str ); // 过滤COOKIE标签
		$str = preg_replace ( "/<(applet.*?)>(.*?)<(\/applet.*?)>/si", "", $str ); // 过滤applet标签
		$str = preg_replace ( "/<(\/?applet.*?)>/si", "", $str ); // 过滤applet标签
		$str = preg_replace ( "/<(style.*?)>(.*?)<(\/style.*?)>/si", "", $str ); // 过滤style标签
		$str = preg_replace ( "/<(\/?style.*?)>/si", "", $str ); // 过滤style标签
		$str = preg_replace ( "/<(title.*?)>(.*?)<(\/title.*?)>/si", "", $str ); // 过滤title标签
		$str = preg_replace ( "/<(\/?title.*?)>/si", "", $str ); // 过滤title标签
		$str = preg_replace ( "/<(object.*?)>(.*?)<(\/object.*?)>/si", "", $str ); // 过滤object标签
		$str = preg_replace ( "/<(\/?objec.*?)>/si", "", $str ); // 过滤object标签
		$str = preg_replace ( "/<(noframes.*?)>(.*?)<(\/noframes.*?)>/si", "", $str ); // 过滤noframes标签
		$str = preg_replace ( "/<(\/?noframes.*?)>/si", "", $str ); // 过滤noframes标签
		$str = preg_replace ( "/<(i?frame.*?)>(.*?)<(\/i?frame.*?)>/si", "", $str ); // 过滤frame标签
		$str = preg_replace ( "/<(\/?i?frame.*?)>/si", "", $str ); // 过滤frame标签
		$str = preg_replace ( "/<(script.*?)>(.*?)<(\/script.*?)>/si", "", $str ); // 过滤script标签
		$str = preg_replace ( "/<(\/?script.*?)>/si", "", $str ); // 过滤script标签
		$str = preg_replace ( "/javascript/si", "Javascript", $str ); // 过滤script标签
		$str = preg_replace ( "/vbscript/si", "Vbscript", $str ); // 过滤script标签
		$str = preg_replace ( "/on([a-z]+)\s*=/si", "On\\1=", $str ); // 过滤script标签
		$str = preg_replace ( "/&#/si", "&＃", $str ); // 过滤script标签，
		
		$str = preg_replace ( "@<script(.*?)</script>@is", "", $str ); // 过滤script代码
		$str = preg_replace ( "@<iframe(.*?)</iframe>@is", "", $str );
		$str = preg_replace ( "@<style(.*?)</style>@is", "", $str );
		$str = preg_replace ( "@<(.*?)>@is", "", $str );
		return $str;
	}
	function getarticle() {
		$result = array ();
		require 'simple_html_dom.php';
		
		$caiji_url = $this->input->post ( "daanurl" ); // 采集文章详情url
		$caiji_prefix = $this->input->post ( "guize" ); // 文章标题
		$caiji_desc = $this->input->post ( "daandesc" ); // 文章详情
		
		$bianma = $this->input->post ( "bianma" ); // 采集编码
		$ckabox = $this->input->post ( "ckabox" ); // 采集过滤超链接
		$imgckabox = $this->input->post ( "imgckabox" ); // 超级过滤图片
		
		$result ['ckabox'] = $ckabox;
		$result ['imgckabox'] = $imgckabox;
		$html = file_get_html ( $caiji_url );
		
		try {
			$title = '';
			if ($caiji_prefix != '') {
				$witle = $html->find ( $caiji_prefix );
				
				$title = $witle [0]->plaintext; // 获取文章标题
				$result ['title'] = $title;
			}
			
			$desc = '';
			if ($caiji_desc != '') {
				$wtdesc = $html->find ( $caiji_desc );
				
				$desc = $wtdesc [0]->outertext; // 获取文章详情
				$suffer = substr ( $desc, 0, 4 );
				if ($suffer == '<pre') {
					$desc = $wtdesc [0]->plaintext;
				}
			}
			
			$result ['neirong'] = $this->fillter ( $desc );
			echo json_encode ( $result );
		} catch ( Exception $err ) {
		}
	}
	function getoncaiji() {
		$result = array ();
		require 'simple_html_dom.php';
		$title = strip_tags ( $this->input->post ( "title" ) ); // $_POST["title"];
		$caiji_url = $this->input->post ( "daanurl" );
		$caiji_prefix = $this->input->post ( "guize" );
		$caiji_desc = $this->input->post ( "daandesc" );
		$caiji_best = $this->input->post ( "daanbest" );
		$caiji_hdusertx = $this->input->post ( "caiji_hdusertx" );
		$caiji_hdusername = $this->input->post ( "caiji_hdusername" );
		$bianma = $this->input->post ( "bianma" );
		$ckabox = $this->input->post ( "ckabox" );
		$imgckabox = $this->input->post ( "imgckabox" );
		
		$result ['ckabox'] = $ckabox;
		$result ['imgckabox'] = $imgckabox;
		$html = file_get_html ( $caiji_url );
		
		try {
			$desc = '';
			if ($caiji_desc != '') {
				$wtdesc = $html->find ( $caiji_desc );
				if (isset ( $wtdesc [0] )) {
					$desc = $wtdesc [0]->outertext;
				}
				
				$suffer = substr ( $desc, 0, 4 );
				if ($suffer == '<pre') {
					$desc = $wtdesc [0]->plaintext;
				}
			}
			
			// $q = $this->question_model->get_by_title ( htmlspecialchars ( $title ) );
			// if ($q != null) {
			// $result ['result'] = '1';
			// } else {
			// $result ['result'] = '0';
			// }
			
			// $desc=htmlspecialchars($desc);
			
			$desc = str_replace ( '<img class=">ͼ"', '', $desc );
			$desc = str_replace ( '<img class=">图" class="ikqb_img_alink', '', $desc );
			
			// if($ckabox=='true'||$ckabox=='on'){
			// $desc=filter_outer($desc);
			// }
			// if($imgckabox=='true'||$imgckabox=='on'){
			// $desc=filter_imgouter($desc);
			// }
			
			$result ['miaosu'] = $desc; // 问题描述
			
			$wtbest = $html->find ( $caiji_best );
			$atest = $wtbest [0]->outertext;
			
			if ($ckabox == 'true' || $ckabox == 'on') {
				
				$atest = preg_replace ( "#<a[^>]*>(.*?)</a>#is", "$1", $atest );
			}
			if ($imgckabox == 'true' || $imgckabox == 'on') {
				
				$atest = preg_replace ( '/<img[^>]+>/i', '', $atest );
			}
			$result ['bestanswer'] = $atest; // 最佳答案
			
			if ($imgckabox == 'true' || $imgckabox == 'on') {
				
				$result ['guolvtupuan'] = '过滤图片'; // 过滤图片
			}
			// 其它回答
			$type_fill = $html->find ( $caiji_prefix );
			$result ['otherlist'] = array ();
			$count1 = 0;
			foreach ( $type_fill as $r ) {
				if ($bianma == 'gb2312') {
					$caijilist [$count1] ['title'] = iconv ( 'gb2312', 'utf-8', $r->outertext );
				} else {
					$str = $r->outertext;
					$str = str_replace ( "'", "", $str );
					$str = str_replace ( '<pre style="font-family:微软雅黑;">', "", $str );
					$str = str_replace ( '</pre>', "", $str );
					
					$caijilist [$count1] ['title'] = $str;
					
					// $caijilist[$count1]['title']= $r->outertext ;
				}
				if ($ckabox == 'true' || $ckabox == 'on') {
					// $caijilist[$count1]['title']=filter_outer($caijilist[$count1]['title']);
					$caijilist [$count1] ['title'] = preg_replace ( "#<a[^>]*>(.*?)</a>#is", "$1", $caijilist [$count1] ['title'] );
				}
				if ($imgckabox == 'true' || $imgckabox == 'on') {
					$caijilist [$count1] ['title'] = preg_replace ( '/<img[^>]+>/i', '', $caijilist [$count1] ['title'] );
					
					// $caijilist[$count1]['title']=filter_imgouter($caijilist[$count1]['title']);
				}
				$caijilist [$count1] ['title'] = preg_replace ( '/<p class="tr">.*?<\/p>/is', '', $caijilist [$count1] ['title'] );
				array_push ( $result ['otherlist'], $caijilist [$count1] ['title'] );
				$count1 ++;
			}
		} catch ( Exception $err ) {
		}
		
		$html->clear ();
		
		echo json_encode ( $result );
		exit ();
	}
	function getfolders() {
		$file = array ();
		$file_dir = "static/caijiimage";
		$shili = $file_dir;
		if (! file_exists ( $shili )) {
			return '0';
		} else {
			$i = 0;
			
			if (is_dir ( $shili )) { // 检测是否是合法目录
				if ($shi = opendir ( $shili )) { // 打开目录
					while ( $li = readdir ( $shi ) ) { // 读取目录
						
						if (strpos ( $li, 'jpg' ) > 0 || strpos ( $li, 'png' ) > 0)
							array_push ( $file, $li );
					}
				}
			} // 输出目录中的内容
			
			closedir ( $shi );
			return $file;
		}
	}
	// 插入文章
	function ajaxcaijiwz() {
		$result = array ();
		require 'simple_html_dom.php';
		
		$caiji_url = $this->input->post ( "daanurl" ); // 采集文章详情url
		$caiji_prefix = $this->input->post ( "guize" ); // 文章标题
		$caiji_desc = $this->input->post ( "daandesc" ); // 文章详情
		
		$bianma = $this->input->post ( "bianma" ); // 采集编码
		$ckabox = $this->input->post ( "ckabox" ); // 采集过滤超链接
		$imgckabox = $this->input->post ( "imgckabox" ); // 超级过滤图片
		
		$result ['ckabox'] = $ckabox;
		$result ['imgckabox'] = $imgckabox;
		$cid = $this->input->post ( "cid" );
		$cid1 = $this->input->post ( "cid1" );
		$cid2 = $this->input->post ( "cid2" );
		$cid3 = $this->input->post ( "cid3" );
		$html = file_get_html ( $caiji_url );
		
		try {
			$title = '';
			if ($caiji_prefix != '') {
				$witle = $html->find ( $caiji_prefix );
				
				$title = $witle [0]->plaintext; // 获取文章标题
				$result ['title'] = $title;
			}
			
			$desc = '';
			if ($caiji_desc != '') {
				$wtdesc = $html->find ( $caiji_desc );
				
				$desc = $wtdesc [0]->outertext; // 获取文章详情
				$suffer = substr ( $desc, 0, 4 );
				if ($suffer == '<pre') {
					$desc = $wtdesc [0]->plaintext;
				}
			}
			
			$content = $this->fillter ( $desc );
			$article = $this->topic_model->get_byname ( $title );
			
			if ($article != null) {
				
				echo $title . '文章已存在，发布时间为' . $article ['viewtime'];
				exit ();
			} else {
				$userlist = $this->user_model->get_caiji_list ( 0, 100 );
				$mwtuid = array_rand ( $userlist, 1 );
				$uid = $userlist [$mwtuid] ['uid'];
				$username = $userlist [$mwtuid] ['username'];
				$file = $this->getfolders ();
				
				$url = 'http://www.ask2.cn/data/attach/topic/topic6DYxVY.jpg';
				$img_url = getfirstimg ( $content );
			}
			if ($file != '0') {
				$mwtfid = array_rand ( $file, 1 );
				
				$url = SITE_URL . 'static/caijiimage/' . $file [$mwtfid];
			}
			if ($img_url == "") {
				$img_url = $url;
			}
			if (ckabox == 'true' || ckabox == 'on') {
				$content = filter_outer ( $content );
			}
			if (trim ( $content ) != '') {
				$desc = preg_replace ( "#<a[^>]*>(.*?)</a>#is", "$1", $content );
				if ($imgckabox == 'true' || $imgckabox == 'on') {
					
					$desc = preg_replace ( '/<img[^>]+>/i', '', $desc );
				}
				$desc = str_replace ( "'", '"', $desc );
				$desc = preg_replace ( "@<iframe(.*?)</iframe>@is", "", $desc );
				$aid = $this->topic_model->addtopic ( $title, $desc, $img_url, $username, $uid, rand ( 1, 30 ), $cid );
				if ($aid > 0) {
					
					$taglist = dz_segment ( htmlspecialchars ( $title ) );
					$taglist && $this->tag_model->multi_add ( array_unique ( $taglist ), $aid );
					$this->doing_model->add ( $uid, $username, 9, $aid, $title );
					echo $title . '发布成功';
				} else {
					
					echo $title . "发布失败";
				}
			} else {
				echo $title . "发布失败,内容不能为空" . $caiji_desc;
			}
		} catch ( Exception $err ) {
		}
	}
	/* ajax插入数据 */
	function ajaxcaiji() {
		$title = strip_tags ( $this->input->post ( "title" ) ); // $_POST["title");
		$tiwentime = strip_tags ( $this->input->post ( "tiwentime" ) ); // $_POST["title");
		$huidatime = strip_tags ( $this->input->post ( "huidatime" ) ); // $_POST["title");
		$randclass = $this->input->post ( "randclass" );
		$cid = $this->input->post ( "cid" );
		
		$caiji_beginnum = $this->input->post ( "caiji_beginnum" );
		$caiji_endnum = $this->input->post ( "caiji_endnum" );
		
		$cid1 = $this->input->post ( "cid1" );
		$cid2 = $this->input->post ( "cid2" );
		$cid3 = $this->input->post ( "cid3" );
		if ($cid3 == null) {
			$cid3 = 0;
		}
		if ($cid2 == null) {
			$cid2 = 0;
		}
		// $catlist=$_ENV['category']->list_by_pid($catmodel['pid']);
		
		$uid = $this->input->post ( "uid" );
		$ckbox = $this->input->post ( "ckbox" );
		$username = $this->input->post ( "username" );
		
		$userlist = $this->user_model->get_caiji_list ( 0, 200 );
		$mwtuid = array_rand ( $userlist, 1 );
		$uid = $userlist [$mwtuid] ['uid'];
		$username = $userlist [$mwtuid] ['username'];
		// unset($userlist[array_search($username,$userlist)]);
		$nowtime = date ( "Y-m-d H:i:s" );
		$tiwentime = $tiwentime * 60;
		$randtime = rand ( 1, $tiwentime );
		
		$t1 = date ( 'Y-m-d H:i:s', strtotime ( "-$randtime minute" ) ); // "2015-1-29 08:43:21";
		
		$mtime = strtotime ( $t1 );
		// include 'lib/simple_html_dom.php';
		require 'simple_html_dom.php';
		$caiji_url = $this->input->post ( "daanurl" );
		$caiji_prefix = $this->input->post ( "guize" );
		$caiji_desc = $this->input->post ( "daandesc" );
		$caiji_best = $this->input->post ( "daanbest" );
		$caiji_hdusertx = $this->input->post ( "caiji_hdusertx" );
		$caiji_hdusername = $this->input->post ( "caiji_hdusername" );
		$bianma = $this->input->post ( "bianma" );
		$ckabox = $this->input->post ( "ckabox" );
		$imgckabox = $this->input->post ( "imgckabox" );
		$html = file_get_html ( $caiji_url );
		//
		$res = "";
		try {
			
			$desc = '';
			if ($caiji_desc != '') {
				$wtdesc = $html->find ( $caiji_desc );
				
				$desc = $wtdesc [0]->outertext;
				$suffer = substr ( $desc, 0, 4 );
				if ($suffer == '<pre') {
					$desc = $wtdesc [0]->plaintext;
				}
			}
			
			if ($title == "" || $title == null) {
				
				return false;
			}
			$q = $this->question_model->get_by_title ( htmlspecialchars ( $title ) );
			if ($q != null)
				return false;
				
				// $desc=htmlspecialchars($desc);
				
				if ($ckabox == 'true' || $ckabox == 'on') {
					
					$desc = preg_replace ( "#<a[^>]*>(.*?)</a>#is", "$1", $desc );
				}
				if ($imgckabox == 'true' || $imgckabox == 'on') {
					
					$desc = preg_replace ( '/<img[^>]+>/i', '', $desc );
				}
				$desc = str_replace ( "'", '"', $desc );
				$desc = preg_replace ( "@<iframe(.*?)</iframe>@is", "", $desc );
				$qid = $this->question_model->add_seo ( htmlspecialchars ( $title ), $uid, $username, $desc, 0, rand ( 0, 100 ), $cid, $cid1, $cid2, $cid3, 1, rand ( 10, 200 ), $mtime );
				if ($qid == 0) {
					exit ();
				}
				$numuser = rand ( 3, 5 );
				for($i = 0; $i <= $numuser; $i ++) {
					$auid = array_rand ( $userlist, 1 );
					$_uid = $userlist [$auid] ['uid'];
					$_username = $userlist [$auid] ['username'];
					$this->attention_question ( $qid, $_uid, $_username );
				}
				
				// $taglist=dz_segment(htmlspecialchars($title));
				// $taglist && $_ENV['tag']->multi_add(array_unique($taglist), $qid);
				
				$this->doing_model->add ( $uid, $username, 1, $qid, '' );
		} catch ( Exception $err ) {
			$res = 'dddd'; // $err->getMessage();
			// print $err->getMessage();
		}
		$wtbest = $html->find ( $caiji_best );
		$atest = $wtbest [0]->outertext;
		$type_fill = $html->find ( $caiji_prefix );
		
		if (isset ( $wtbest ) && $wtbest != "" && $wtbest != null)
			$type_fill = array_merge ( $wtbest, $type_fill );
			
			//
			// //print_r($type_fill);
			
			$caijilist = array ();
			$count1 = 0;
			$commentarr = array (
					'真给力',
					"谢谢你",
					'非常感谢你',
					'你真是个大好人',
					'你真的帮了我大忙',
					'高手留个联系方式吧',
					'大神......'
			);
			$comment = $commentarr [array_rand ( $commentarr, 1 )];
			$countarr = count ( $type_fill );
			$rand = rand ( 1, $countarr );
			$num = 1;
			$aid = 0;
			$answer_adopt_num = rand ( 1, 10 ) % 2;
			foreach ( $type_fill as $r ) {
				
				$randtime = rand ( 1, $huidatime );
				$t2 = date ( 'Y-m-d H:i:s', strtotime ( "+$randtime minute" ) );
				
				$mtime = strtotime ( $t2 );
				$caijilist [$count1] ['num'] = $count1;
				
				if ($bianma == 'gb2312') {
					$caijilist [$count1] ['title'] = iconv ( 'gb2312', 'utf-8', $r->outertext );
				} else {
					$str = $r->outertext;
					$str = str_replace ( "'", "", $str );
					$str = str_replace ( '<pre style="font-family:微软雅黑;">', "", $str );
					$str = str_replace ( '</pre>', "", $str );
					$caijilist [$count1] ['title'] = $str;
					
					// $caijilist[$count1]['title']= $r->outertext ;
				}
				if (strstr ( $caijilist [$count1] ['title'], '<span>热心卡友</span>' )) {
					continue;
				}
				if (strstr ( $caijilist [$count1] ['title'], '回复时间' )) {
					continue;
				}
				if (count ( $userlist ) > 0) {
					$quid = array_rand ( $userlist, 1 );
					$wdusername = $html->find ( $caiji_hdusername );
					$wendausername = $wdusername [$count1]->plaintext;
					$wduserimage = $html->find ( $caiji_hdusertx );
					
					$wendauserimg = $wduserimage [$count1]->src;
					// print_r($wendauserimg) ;
					$user = $this->user_model->get_by_username ( $wendausername );
					if (! $user) {
						// ucenter注册。
						if ($this->setting ["ucenter_open"]) {
							$this->load->model ( 'ucenter_model' );
							$msg = $this->ucenter_model->ajaxregister ( $username, '123456', rand ( 1111111, 99999999 ) . "@qq.com", '', 0 );
							if ($msg == 'ok') {
								// $uid = $_ENV['user']->adduserapi($username, $password, $email,$groupid);//插入model/user.class.php里adduserapi函数里
								$user = $this->user_model->get_by_username ( $username );
								$uid = $user ['uid'];
								
								$sitename = $this->setting ['site_name'];
								$this->load->model ( "doing_model" );
								$this->doing_model->add ( $uid, $username, 12, $uid, "欢迎您注册了$sitename" );
								$this->credit ( $uid, $this->setting ['credit1_register'], $this->setting ['credit2_register'] ); // 注册增加积分
							} else {
								$hduid = $this->user_model->caijiadd ( $wendausername, '123456', rand ( 1111111, 99999999 ) . "@qq.com" );
							}
						}
						
						$hduid = intval ( $hduid );
						$avatardir = "/data/avatar/";
						$extname = substr ( strrchr ( $wendauserimg, '.' ), 1 );
						$upload_tmp_file = FCPATH . '/data/tmp/user_avatar_' . $hduid . '.' . $extname;
						$hduid = abs ( $hduid );
						$hduid = sprintf ( "%09d", $hduid );
						$dir1 = $avatardir . substr ( $hduid, 0, 3 );
						$dir2 = $dir1 . '/' . substr ( $hduid, 3, 2 );
						$dir3 = $dir2 . '/' . substr ( $hduid, 5, 2 );
						(! is_dir ( FCPATH . $dir1 )) && forcemkdir ( FCPATH . $dir1 );
						(! is_dir ( FCPATH . $dir2 )) && forcemkdir ( FCPATH . $dir2 );
						(! is_dir ( FCPATH . $dir3 )) && forcemkdir ( FCPATH . $dir3 );
						
						$smallimg = $dir3 . "/small_" . $hduid . '.' . $extname;
						$smallimgdir = $dir3 . "/";
						$this->getImage ( $wendauserimg, "small_" . $hduid . '.' . $extname, FCPATH . $smallimgdir, array (
								'jpg',
								'jpeg',
								'png',
								'gif'
						) );
					} else {
						$hduid = $user ['uid'];
					}
					if ($wendausername == '') {
						$hduid = $userlist [$quid] ['uid'];
						$wendausername = $userlist [$quid] ['username'];
					}
					$answer_content = $caijilist [$count1] ['title'];
					
					// $img_arr=getfirstimgs($answer_content);
					// if($img_arr[1]!=null){
					// for($i=0;$i<count($img_arr[1]);$i++){
					// $img_url=getImageFile($img_arr[1][$i],rand(100000, 99999999).".jpg","upload/",1);
					// $answer_content=str_replace($img_arr[1][$i],SITE_URL.$img_url, $answer_content);
					// }
					// }
					
					if ($ckabox == '1' || $ckabox == 'on') {
						
						$answer_content = preg_replace ( "#<a[^>]*>(.*?)</a>#is", "$1", $answer_content );
					}
					if ($imgckabox == '1' || $imgckabox == 'on') {
						
						$answer_content = preg_replace ( '/<img[^>]+>/i', '', $answer_content );
					}
					$answer_content = str_replace ( "'", '"', $answer_content );
					$answer_content = preg_replace ( '/<p class="tr">.*?<\/p>/is', '', $answer_content );
					$answer_content = preg_replace ( '/<div class="time">.*?<\/div>/is', '', $answer_content );
					$answer_content = preg_replace ( "@<iframe(.*?)</iframe>@is", "", $answer_content );
					$aid = $this->answer_model->add_seo ( $qid, $title, $answer_content, $hduid, $wendausername, 1, rand ( 20, 80 ), $mtime );
					
					unset ( $userlist [array_search ( $wendausername, $userlist )] );
					// $_ENV['answer_comment']->add($aid, $comment, $uid, $username);
					// $_ENV['doing']->add($uid, $username, 8, $qid, $comment, $aid, $userlist[$quid]['uid'], $caijilist[$count1]['title']);
					
					if ($answer_adopt_num == 0) {
						$answer = $this->answer_model->get ( $aid );
						
						if ($countarr == 1) {
							
							$ret = $this->answer_model->adopt ( $qid, $answer );
							if ($ret) {
								$this->answer_comment_model->add ( $aid, $comment, $uid, $username );
								$this->doing_model->add ( $uid, $username, 8, $qid, $comment, $aid, $hduid, $caijilist [$count1] ['title'] );
							}
						} else {
							if ($rand == $num) {
								$ret = $this->answer_model->adopt ( $qid, $answer );
								if ($ret) {
									$this->answer_comment_model->add ( $aid, $comment, $uid, $username );
									$this->doing_model->add ( $uid, $username, 8, $qid, $comment, $aid, $hduid, $caijilist [$count1] ['title'] );
								}
							}
						}
					}
				} else {
					
					$answer_content = $caijilist [$count1] ['title'];
					
					// $img_arr=getfirstimgs($answer_content);
					// if($img_arr[1]!=null){
					// for($i=0;$i<count($img_arr[1]);$i++){
					// $img_url=getImageFile($img_arr[1][$i],rand(100000, 99999999).".jpg","upload/",1);
					// $answer_content=str_replace($img_arr[1][$i],SITE_URL.$img_url, $answer_content);
					// }
					// }
					
					if ($ckabox == 'true' || $ckabox == 'on') {
						
						$answer_content = preg_replace ( "#<a[^>]*>(.*?)</a>#is", "$1", $answer_content );
					}
					if ($imgckabox == 'true' || $imgckabox == 'on') {
						
						$answer_content = preg_replace ( '/<img[^>]+>/i', '', $answer_content );
					}
					
					$answer_content = str_replace ( "'", '"', $answer_content );
					$answer_content = preg_replace ( "@<iframe(.*?)</iframe>@is", "", $answer_content );
					$aid = $this->answer_model->add_seo ( $qid, $title, $answer_content, 0, '游客', 1, rand ( 20, 80 ), $mtime );
					if ($answer_adopt_num == 0) {
						$answer = $this->answer_model->get ( $aid );
						if ($countarr == 1) {
							$ret = $this->answer_model->adopt ( $qid, $answer );
							if ($ret) {
								$this->answer_comment_model->add ( $aid, $comment, $uid, $username );
								$this->doing_model->add ( $uid, $username, 8, $qid, $comment, $aid, 0, $caijilist [$count1] ['title'] );
							}
						} else {
							
							if ($rand == $num) {
								$ret = $this->answer_model->adopt ( $qid, $answer );
								if ($ret) {
									$this->answer_comment_model->add ( $aid, $comment, $uid, $username );
									$this->doing_model->add ( $uid, $username, 8, $qid, $comment, $aid, $userlist [$quid] ['uid'], $caijilist [$count1] ['title'] );
								}
							}
						}
					}
				}
				$count1 ++;
				$num ++;
			}
			
			$html->clear ();
			
			echo 'success:' . $title;
	}
	function getImage($url, $filename = '', $dirName, $fileType, $type = 0) {
		if ($url == '') {
			return false;
		}
		// 获取文件原文件名
		$defaultFileName = basename ( $url );
		// 获取文件类型
		$suffix = substr ( strrchr ( $url, '.' ), 1 );
		if (! in_array ( $suffix, $fileType )) {
			return false;
		}
		// 设置保存后的文件名
		// $filename = $filename == '' ? time().rand(0,9).'.'.$suffix : $defaultFileName;
		
		// 获取远程文件资源
		if ($type) {
			$ch = curl_init ();
			$timeout = 5;
			curl_setopt ( $ch, CURLOPT_URL, $url );
			curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
			$file = curl_exec ( $ch );
			curl_close ( $ch );
		} else {
			ob_start ();
			readfile ( $url );
			$file = ob_get_contents ();
			ob_end_clean ();
		}
		// 设置文件保存路径
		// $dirName = $dirName.'/'.date('Y', time()).'/'.date('m', time()).'/'.date('d',time()).'/';
		if (! file_exists ( $dirName )) {
			mkdir ( $dirName, 0777, true );
		}
		// 保存文件
		$res = fopen ( $dirName . $filename, 'a' );
		fwrite ( $res, $file );
		fclose ( $res );
		return "{'fileName':$filename, 'saveDir':$dirName}";
	}
	function posteditguize() {
		$message = array ();
		$id = $_POST ['id'];
		$caiji_url = $_POST ['caiji_url'];
		$tiwenshijian = $_POST ['tiwentime'];
		$huidashijian = $_POST ['huidatime'];
		$caiji_prefix = $_POST ['caiji_prefix'];
		$category1 = $_POST ['value1'];
		$category2 = $_POST ['value2'];
		$category3 = $_POST ['value3'];
		$cid = $_POST ['value'];
		$caijitype = $_POST ['caijitype'];
		$ckabox = $_POST ['ckabox'];
		$atitle = $_POST ['atitle'];
		$imgckabox = $_POST ['imgckabox'];
		$bianma = $_POST ['bianma'];
		$guize = $_POST ['guize'];
		$daanyuming = $_POST ['daanyuming'];
		$daandesc = $_POST ['daandesc'];
		$caiji_best = $_POST ['daanbest'];
		$caiji_hdusername = $_POST ['caiji_hdusername'];
		$caiji_hdusertx = $_POST ['caiji_hdusertx'];
		$source = $_POST ['source'];
		// 插入数据库
		$data = array (
				'caiji_url' => $caiji_url,
				'atitle' => $atitle,
				'tiwenshijian' => $tiwenshijian,
				'huidashijian' => $huidashijian,
				'caiji_prefix' => $caiji_prefix,
				'category1' => $category1,
				'category2' => $category2,
				'category3' => $category3,
				'cid' => $cid,
				'ckabox' => $ckabox,
				'caijitype' => $caijitype,
				'imgckabox' => $imgckabox,
				'bianma' => $bianma,
				'guize' => $guize,
				'daanyuming' => $daanyuming,
				'daandesc' => $daandesc,
				'caiji_best' => $caiji_best,
				'caiji_hdusername' => $caiji_hdusername,
				'caiji_hdusertx' => $caiji_hdusertx,
				'source' => $source
		);
		$this->db->set ( $data )->where ( array (
				'id' => $id
		) )->update ( 'autocaiji' );
		
		$message ['msg'] = "ok";
		
		echo json_encode ( $message );
	}
	function postguize() {
		$message = array ();
		
		$caiji_url = $_POST ['caiji_url'];
		$tiwenshijian = $_POST ['tiwentime'];
		$huidashijian = $_POST ['huidatime'];
		$caiji_prefix = $_POST ['caiji_prefix'];
		$category1 = $_POST ['value1'];
		$category2 = $_POST ['value2'];
		$category3 = $_POST ['value3'];
		$cid = $_POST ['value'];
		$caijitype = intval ( $_POST ['caijitype'] );
		$ckabox = $_POST ['ckabox'];
		$atitle = $_POST ['atitle'];
		$imgckabox = $_POST ['imgckabox'];
		$bianma = $_POST ['bianma'];
		$guize = $_POST ['guize'];
		$daanyuming = $_POST ['daanyuming'];
		$daandesc = $_POST ['daandesc'];
		$caiji_best = $_POST ['daanbest'];
		$caiji_hdusername = $_POST ['caiji_hdusername'];
		$caiji_hdusertx = $_POST ['caiji_hdusertx'];
		$source = $_POST ['source'];
		// 插入数据库
		$vaules = "'$caiji_url','$tiwenshijian','$huidashijian','$caiji_prefix','$category1','$category2','$category3','$cid',";
		$vaules = $vaules . "'$ckabox','$imgckabox','$bianma','$guize','$daanyuming','$daandesc','$caiji_best','$caiji_hdusername','$caiji_hdusertx','$source','$atitle','$caijitype'";
		$data = array (
				'caiji_url' => $caiji_url,
				'atitle' => $atitle,
				'tiwenshijian' => $tiwenshijian,
				'huidashijian' => $huidashijian,
				'caiji_prefix' => $caiji_prefix,
				'category1' => $category1,
				'category2' => $category2,
				'category3' => $category3,
				'cid' => $cid,
				'ckabox' => $ckabox,
				'caijitype' => $caijitype,
				'imgckabox' => $imgckabox,
				'bianma' => $bianma,
				'guize' => $guize,
				'daanyuming' => $daanyuming,
				'daandesc' => $daandesc,
				'caiji_best' => $caiji_best,
				'caiji_hdusername' => $caiji_hdusername,
				'caiji_hdusertx' => $caiji_hdusertx,
				'source' => $source
		);
		$this->db->insert ( 'autocaiji', $data );
		
		// runlog('sql','INSERT INTO ' . $this->db->dbprefix . "autocaiji(caiji_url,tiwenshijian,huidashijian,caiji_prefix,category1,category2,category3,cid,ckabox,imgckabox,bianma,guize,daanyuming,daandesc,caiji_best,caiji_hdusername,caiji_hdusertx) values ($vaules)");
		// $this->db->query ( 'INSERT INTO ' . $this->db->dbprefix . "autocaiji(caiji_url,tiwenshijian,huidashijian,caiji_prefix,category1,category2,category3,cid,ckabox,imgckabox,bianma,guize,daanyuming,daandesc,caiji_best,caiji_hdusername,caiji_hdusertx,source,atitle,caijitype) values ($vaules)" );
		$id = $this->db->insert_id ();
		if ($id > 0) {
			$message ['msg'] = 'ok';
		} else {
			$message ['msg'] = 'error';
		}
		
		echo json_encode ( $message );
	}
	function postanswer() {
		$message = array ();
		if (null !== $this->input->post ( 'submit' )) {
			
			$title = strip_tags ( $_POST ['title'] );
			$miaosu = $_POST ['q_miaosu_eidtor_content'];
			$zuijiadaan = $_POST ['q_best_eidtor_content'];
			$qtime = strtotime ( $_POST ['qtime'] );
			$qbesttime = $_POST ['qbesttime'];
			if ($zuijiadaan != '') {
				$qbesttime = strtotime ( $qbesttime );
			}
			$views = $this->input->post ( 'views' );
			$cid = $this->input->post ( 'cid' );
			$cid1 = $this->input->post ( 'cid1' );
			$cid2 = $this->input->post ( 'cid2' );
			$cid3 = $this->input->post ( 'cid3' );
			$userlist = $this->user_model->get_caiji_list ( 0, 30 );
			if (count ( $userlist ) <= 0) {
				$message ['msg'] = '没有可用的马甲用户，先去用户管理设置马甲';
				echo json_encode ( $message );
				exit ();
			}
			
			$mwtuid = array_rand ( $userlist, 1 );
			$q_uid = $userlist [$mwtuid] ['uid'];
			$q_username = $userlist [$mwtuid] ['username'];
			
			$qid = $this->addquestion ( $title, $miaosu, $zuijiadaan, $cid, $qtime, $views, $q_uid, $q_username, $cid1, $cid2, $cid3 );
			
			if ($qid <= 0) {
				$message ['msg'] = '提交问题失败';
				echo json_encode ( $message );
				exit ();
			} else {
				$mwtuid = array_rand ( $userlist, 1 );
				$b_uid = $userlist [$mwtuid] ['uid'];
				$b_username = $userlist [$mwtuid] ['username'];
				
				$this->addanswer ( $qid, $title, $zuijiadaan, $qbesttime, $b_uid, $b_username );
				$message ['msg'] = 'ok';
				echo json_encode ( $message );
				exit ();
			}
		} else {
			$message ['msg'] = '非法提交表单';
			echo json_encode ( $message );
			exit ();
		}
	}
	/* 插入问题到question表 */
	function addquestion($title, $description, $zuijiadaan, $cid, $qtime, $views, $uid, $username, $cid1 = 0, $cid2 = 0, $cid3 = 0, $status = 1, $shangjin = 0, $askfromuid = 0) {
		$overdue_days = intval ( $this->setting ['overdue_days'] );
		$creattime = $qtime;
		$hidanswer = 0;
		$price = 0;
		$answers = 0;
		if ($zuijiadaan != '') {
			$answers = 1;
		}
		$endtime = $this->time + $overdue_days * 86400;
		
		(! strip_tags ( $description, '<img>' )) && $description = '';
		$dataquestion = array (
				'views' => $views,
				'cid' => $cid,
				'cid1' => $cid1,
				'cid2' => cid2,
				'cid3' => $cid3,
				'askuid' => $askfromuid,
				'authorid' => $uid,
				'shangjin' => $shangjin,
				'author' => $username,
				'title' => $title,
				'description' => $description,
				'price' => $price,
				'time' => $creattime,
				'endtime' => $endtime,
				'hidden' => $hidanswer,
				'status' => $status,
				'ip' => getip ()
		);
		$this->db->insert ( 'question', $dataquestion );
		/* 分词索引 */
		// $this->db->query ( "INSERT INTO " . $this->db->dbprefix . "question SET views='$views',cid='$cid',cid1='$cid1',cid2='$cid2',cid3='$cid3',askuid='$askfromuid',authorid='$uid',shangjin='$shangjin',author='$username',title='$title',description='$description',price='$price',time='$creattime',endtime='$endtime',hidden='$hidanswer',status='$status',ip='{$this->base->ip}'" );
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
		
		$this->db->query ( "INSERT INTO " . $this->db->dbprefix . "answer SET qid='$qid',title='$title',author='$username',authorid='$uid',time='$qbesttime',content='$content',reward=$chakanjine,status=$status,ip='{$this->ip}'" );
		$this->db->query ( "UPDATE " . $this->db->dbprefix . "question SET  answers=answers+1  WHERE id=" . $qid );
		$this->db->query ( "UPDATE " . $this->db->dbprefix . "user SET answers=answers+1 WHERE  uid =$uid" );
		$aid = $this->db->insert_id ();
	}
}
