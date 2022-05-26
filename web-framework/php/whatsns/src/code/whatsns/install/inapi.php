<?php
ini_set("display_errors", 0);
header("Content-type: text/html; charset=utf-8");
error_reporting(E_ALL ^ E_NOTICE);
error_reporting(E_ALL ^ E_WARNING);
ini_set ( 'date.timezone', 'Asia/Shanghai' );
define('WHATSNS_ROOT', dirname(__FILE__).'/../');
define('WHATSNS_VERSION', '5.0');
define('WHATSNS_RELEASE', '2020-11-14');
define('APPPATH', WHATSNS_ROOT.'./application/');
define('CHARSET', 'UTF-8');
define('DBCHARSET', 'utf8');
define('BASEPATH', TRUE);
set_time_limit(0);
class Install  {
	var $whitelist;
	function __construct() {
	}
	/**
	
	* 添加网站信息
	
	* @date: 2019年2月16日 下午4:54:32
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function createsiteinfo(){
		$data = json_decode ( urldecode ( $_POST ['ajax'] ), TRUE );
		$message=array();	
		
		$sitename=trim($data['sitename']);
		$description=trim($data['description']);
		$keywordinfo=trim($data['keywordinfo']);
		$sitealias=strip_tags(trim($data['sitealias']));	
		$file=APPPATH . 'config' . DIRECTORY_SEPARATOR . 'database.php';
		$baseurl=trim($data['baseurl']);
		$dirName=trim($data['dirname']);
		$this->configdomain($baseurl,$dirName);
		if(!file_exists($file)){
			$message['code']=201;
			$message['msg']="数据库配置文件不存在";
			echo json_encode($message);
			exit();
			
		}
		
		if(!$_SESSION){
			session_start();
		}
		
		$dbpre=$_SESSION['db_pre'];
		
		$con=mysqli_connect($_SESSION['db_host'], $_SESSION['db_user'], $_SESSION['db_pwd']);
		mysqli_set_charset($con, "utf8");
		mysqli_select_db($con,$_SESSION['db_name']);
		mysqli_query($con,"set names utf8");

		mysqli_query($con,"DELETE FROM `".$dbpre."setting` WHERE `k`='seo_index_description'");
		mysqli_query($con,"INSERT INTO `".$dbpre."setting` SET `k`='seo_index_description',`v`='".$description."'");
		mysqli_query($con,"DELETE FROM  `".$dbpre."setting` WHERE `k`='seo_index_keywords'");
		mysqli_query($con,"INSERT INTO `".$dbpre."setting` SET `k`='seo_index_keywords',`v`='".$keywordinfo."'");
		mysqli_query($con,"DELETE FROM `".$dbpre."setting` WHERE `k`='site_name'");
		
		mysqli_query($con,"INSERT INTO `".$dbpre."setting` SET `k`='site_name',`v`='".$sitename."'");
		mysqli_query($con,"DELETE FROM `".$dbpre."setting` WHERE `k`='site_alias'");
		
		mysqli_query($con,"INSERT INTO `".$dbpre."setting` SET `k`='site_alias',`v`='".$sitealias."'");
		
		mysqli_query($con,"DELETE FROM `".$dbpre."setting` WHERE `k`='tpl_wapdir'");
		
		mysqli_query($con,"INSERT INTO `".$dbpre."setting` SET `k`='tpl_wapdir',`v`='fronzewap'");
		
		mysqli_query($con,"DELETE FROM `".$dbpre."setting` WHERE `k`='tpl_dir'");
		
		mysqli_query($con,"INSERT INTO `".$dbpre."setting` SET `k`='tpl_dir',`v`='responsive_fly'");
		
		
		mysqli_query($con,"DELETE FROM `".$dbpre."setting` WHERE `k`='seo_index_title'");
		
		mysqli_query($con,"INSERT INTO `".$dbpre."setting` SET `k`='seo_index_title',`v`='".$sitealias."'");
		
		
		
		mysqli_close($con);
		$localfile=WHATSNS_ROOT."data/install.lock";
		if(!file_exists(!$localfile)){
			@touch($localfile);
		}
		
	
		$message['code']=200;
		$message['msg']="站点信息创建成功";
		echo json_encode($message);
		
		$this->dir_clear(WHATSNS_ROOT.'data/cache');//clear up the old data cathe
		
		$this->dir_clear(WHATSNS_ROOT.'data/view');//clear up the old data cathe
		unlink(WHATSNS_ROOT."install/index.php");
		unlink(WHATSNS_ROOT."install/inapi.php");
		unlink(WHATSNS_ROOT."install/whatsns.sql");
		exit();
		
	}
	/**
	
	* 创建超级管理员
	
	* @date: 2019年2月16日 下午2:39:14
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function createuser(){
		$data = json_decode ( urldecode ( $_POST ['ajax'] ), TRUE );
		$message=array();
		

		$username=addslashes(trim($data['username']));
		$password=trim($data['password']);
		$email=addslashes(trim($data['email']));
		$signature=addslashes(strip_tags(trim($data['signature'])));
		$introduction=addslashes(strip_tags(trim($data['introduction'])));
		$file=APPPATH . 'config' . DIRECTORY_SEPARATOR . 'database.php';

		if(!file_exists($file)){
			$message['code']=201;
			$message['msg']="数据库配置文件不存在";
			echo json_encode($message);
			exit();
			
		}else{
			
		}

		if(!$_SESSION){
			session_start();
		}
		
		$dbpre=$_SESSION['db_pre'];
		
		$con=mysqli_connect($_SESSION['db_host'], $_SESSION['db_user'], $_SESSION['db_pwd']);
	mysqli_set_charset($con, "utf8");
	mysqli_select_db($con,$_SESSION['db_name']);
		mysqli_query($con,"set names utf8");

		mysqli_query($con,"DELETE FROM `".$dbpre."user` WHERE `uid`=1");
		
		mysqli_query($con,"INSERT INTO `".$dbpre."user` SET `uid`=1,`introduction`='".$introduction."',`signature`='".$signature."',`username`='".$username."', `password`='".md5($password)."',`email`='".$email."',`groupid`=1,`credits`=200,`credit1`=100,`credit2`=100,`regip`='".$_SERVER["REMOTE_ADDR"]."'" );
		
		mysqli_query($con,"DELETE FROM `".$dbpre."setting` WHERE `k`='auth_key'");
		
		mysqli_query($con,"INSERT INTO `".$dbpre."setting` SET `k`='auth_key',`v`='".$this->generate_key()."'");
		
		mysqli_close($con);
		$message['code']=200;
		$message['msg']="超级管理员创建成功";
		echo json_encode($message);
		exit();
		
	
	}
	//执行sql更新
	function exutesql($tablepre, $ip, $dbuser, $dbpwd,$dbname){
		
		$con=mysqli_connect($ip, $dbuser, $dbpwd);
		mysqli_select_db($con,$dbname);
		$sql_class1 = "alter table " .$tablepre. "usergroup add COLUMN canfreereadansser int(10) DEFAULT 0;";
		mysqli_query($con,$sql_class1 );
		//echo ' 更新成功:更新usergroup表，增加canfreereadansser字段<br>';
		
		//新增用户通知表
		
		$sql="CREATE TABLE IF NOT EXISTS `" . $tablepre . "user_notify` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL COMMENT '用户uid',
  `inbox_permission` int(2) DEFAULT 0 COMMENT '0 全部站内用户 1 关注我的',
  `invite_permission` int(2) DEFAULT 0 COMMENT '0所有人 1关注我的',
  `follow_after_answer` int(2) DEFAULT 1 COMMENT '1自动关注 0 不关注',
    `article` int(2) DEFAULT 1 COMMENT '1通知 0不通知',
    `like_object` int(2) DEFAULT 1 COMMENT '1通知 0不通知',
 `bookmark_object` int(2) DEFAULT 1 COMMENT '1通知 0不通知',
 `follow_object` int(2) DEFAULT 1 COMMENT '1通知 0不通知',
 `answer` int(2) DEFAULT 1 COMMENT '1通知 0不通知',
 `comment` int(2) DEFAULT 1 COMMENT '1通知 0不通知',
 `content_handled` int(2) DEFAULT 1 COMMENT '1通知 0不通知',
 `comment_reply` int(2) DEFAULT 1 COMMENT '1通知 0不通知',
 `invite` int(2) DEFAULT 1 COMMENT '1通知 0不通知',
 `message` int(2) DEFAULT 1 COMMENT '1通知 0不通知',
 `weekly` int(2) DEFAULT 1 COMMENT '1通知 0不通知',
 `feature_news` int(2) DEFAULT 1 COMMENT '1通知 0不通知',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户通知表';
		";
		if(mysqli_query($con,$sql )){
			//echo ' 更新成功:新增user_notify用户通知表<br>';
		}
		
		
		//---微信开放平台登录wechatopenid
		//-----
		$sql_class1 = "alter table " . $tablepre . "user add COLUMN wechatopenid VARCHAR(200)  DEFAULT '';";
		mysqli_query($con,$sql_class1 );
		//echo ' 更新成功:更新user表，增加wechatopenid邀请码字段<br>';
		//---真实姓名
		//-----
		$sql_class1 = "alter table " . $tablepre . "user add COLUMN conpanyname VARCHAR(100)  DEFAULT '';";
		mysqli_query($con,$sql_class1 );
		//echo ' 更新成功:更新user表，增加conpanyname公司名称字段<br>';
		
		//---真实姓名
		//-----
		$sql_class1 = "alter table " . $tablepre . "user add COLUMN truename VARCHAR(50)  DEFAULT '';";
		mysqli_query($con,$sql_class1 );
		//echo ' 更新成功:更新user表，增加truename真实姓名字段<br>';
		//---用户邀请码
		//-----
		$sql_class1 = "alter table " . $tablepre . "user add COLUMN invatecode VARCHAR(200)  DEFAULT NULL;";
		mysqli_query($con,$sql_class1 );
		//echo ' 更新成功:更新user表，增加invatecode邀请码字段<br>';
		//---邀请人的邀请码
		//-----
		$sql_class1 = "alter table " . $tablepre . "user add COLUMN frominvatecode VARCHAR(200)  DEFAULT NULL;";
		mysqli_query($con,$sql_class1 );
		//echo ' 更新成功:更新user表，增加frominvatecode邀请码字段<br>';
		//---用户邀请人数
		//-----
		$sql_class1 = "alter table " . $tablepre . "user add COLUMN invateusers int(10)  DEFAULT 0;";
		mysqli_query($con,$sql_class1 );
		//echo ' 更新成功:更新user表，增加invateusers邀请码字段<br>';
		
		
		//更新用户表--增加registrationid字段
		$sql= "alter table " .$tablepre. "user add COLUMN registrationid varchar(200)  DEFAULT null;";
		mysqli_query($con,$sql );
		//echo ' 更新成功:更新用户表，增加registrationid极光设备号id<br>';
		//更新文章--增加发布状态字段
		$sql= "alter table " .$tablepre. "topic add COLUMN yuyin int(5)  DEFAULT 0;";
		mysqli_query($con,$sql );
		//echo ' 更新成功:更新文章表，增加yuyin是否存在语音文件，默认0，0表示没有<br>';
		//更新文章--增加发布状态字段
		$sql= "alter table " .$tablepre. "topic add COLUMN state int(5)  DEFAULT 1;";
		mysqli_query($con,$sql );
		//echo ' 更新成功:更新文章表，增加state发布状态，默认直接发布1，0表示审核<br>';
		//更新文章评论--增加发布状态字段
		$sql = "alter table " .$tablepre. "article_comment add COLUMN state int(5)  DEFAULT 1;";
		mysqli_query($con,$sql );
		//echo ' 更新成功:更新文章评论表，增加state发布状态，默认直接发布1，0表示审核<br>';
		//更新文章评论回复表--增加发布状态字段
		$sql = "alter table " .$tablepre. "articlecomment add COLUMN state int(5)  DEFAULT 1;";
		mysqli_query($con,$sql );
		//echo ' 更新成功:更新文章评论回复表，增加state发布状态，默认直接发布1，0表示审核<br>';
		//增加文章阅读模式
		$sql = "alter table " .$tablepre. "topic add COLUMN readmode int(5)  DEFAULT 1;";
		mysqli_query($con,$sql );
		//echo ' 更新成功:更新文章表，增加readmode阅读模式，1免费阅读 ，2积分阅读，3 付费阅读<br>';
		//更新文章带积分的
		$sql = "update  `" . $tablepre . "topic` SET `readmode` = '2' WHERE price>0 and readmode!=3";
		mysqli_query($con,$sql );
		
		//设置模板为default
		$sql = "update  `" . $tablepre . "setting` SET `v` = 'default' WHERE k='tpl_dir'";
		//echo $sql;exit();
		mysqli_query($con,$sql );
		//echo ' 更新成功:更新设置表，重置模板PC模板<br>';
		
		//增加付费阅读简介
		$sql = "alter table " .$tablepre. "topic add COLUMN freeconent varchar(500)  DEFAULT null;";
		mysqli_query($con,$sql );
		//echo ' 更新成功:更新文章表，增加freeconent试看内容<br>';
		$sql="ALTER  TABLE  `" . $tablepre . "tag_item`  ADD  INDEX typeid (  `typeid`  )";
		mysqli_query($con,$sql );
		$sql="ALTER  TABLE  `" . $tablepre . "tag_item`  ADD  INDEX itemtype (  `itemtype`  )";
		mysqli_query($con,$sql );
		$sql="ALTER  TABLE  `" . $tablepre . "topic`  ADD  INDEX index (  `state`,  `yuyin`,  `readmode`  )";
		mysqli_query($con,$sql );
		$sql="ALTER  TABLE  `" . $tablepre . "topic`  ADD  INDEX state (  `state`  )";
		mysqli_query($con,$sql );
		$sql="ALTER  TABLE  `" . $tablepre . "topic`  ADD  INDEX yuyin (  `yuyin`  )";
		mysqli_query($con,$sql );
		$sql="ALTER  TABLE  `" . $tablepre . "topic`  ADD  INDEX readmode (  `readmode`  )";
		mysqli_query($con,$sql );
		$sql="ALTER  TABLE  `" . $tablepre . "articlecomment`  ADD  INDEX state (  `state`  )";
		mysqli_query($con,$sql );
		$sql="ALTER  TABLE  `" . $tablepre . "article_comment`  ADD  INDEX state (  `state`  )";
		mysqli_query($con,$sql );
		$sql="ALTER  TABLE  `" . $tablepre . "answer`  ADD  INDEX status (  `status`  )";
		mysqli_query($con,$sql );
		$sql="ALTER  TABLE  `" . $tablepre . "question`  ADD  INDEX status (  `status`  )";
		mysqli_query($con,$sql );
		$sql="ALTER  TABLE  `" . $tablepre . "user`  ADD  INDEX openid (  `openid`  )";
		mysqli_query($con,$sql );
		$sql="ALTER  TABLE  `" . $tablepre . "user`  ADD  INDEX wechatopenid (  `wechatopenid`  )";
		mysqli_query($con,$sql );
		$sql="ALTER  TABLE  `" . $tablepre . "user`  ADD  INDEX mypay (  `mypay`  )";
		mysqli_query($con,$sql );
		$sql="ALTER  TABLE  `" . $tablepre . "user`  ADD  INDEX active (  `active`  )";
		mysqli_query($con,$sql );
		$sql="ALTER  TABLE  `" . $tablepre . "user`  ADD  INDEX hasvertify (  `hasvertify`  )";
		mysqli_query($con,$sql );
		$sql="ALTER  TABLE  `" . $tablepre . "doing`  ADD  INDEX questionid (  `questionid`  )";
		mysqli_query($con,$sql );
		$sql="ALTER  TABLE  `" . $tablepre . "doing`  ADD  INDEX action (  `action`  )";
		mysqli_query($con,$sql );
		
		$sql="ALTER  TABLE  `" . $tablepre . "user`  modify introduction varchar(500)";
		mysqli_query($con,$sql );
		
		$sql="ALTER  TABLE  `" . $tablepre . "question`  modify title varchar(200)";
		mysqli_query($con,$sql );
		
		
	}
	/**
	
	* 初始化数据库
	
	* @date: 2019年2月15日 下午3:14:05
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function initdb(){
		
		$data = json_decode ( urldecode ( $_POST ['ajax'] ), TRUE );
		$message=array();
		$ip=trim($data['ip']);
		$dbname=trim($data['dbname']);
		$dbuser=trim($data['dbuser']);
		$dbpwd=trim($data['dbpwd']);
		$dbpre=trim($data['dbpre']);
		if(empty($ip)||$ip==''){
			$message['code']=201;
			$message['msg']="数据库服务器地址不能为空";
			echo json_encode($message);
			exit();
		}
		if(empty($dbname)||$dbname==''){
			$message['code']=201;
			$message['msg']="数据库名称不能为空";
			echo json_encode($message);
			exit();
		}
		if(empty($dbuser)||$dbuser==''){
			$message['code']=201;
			$message['msg']="数据库用户名不能为空";
			echo json_encode($message);
			exit();
		}
		if(empty($dbpwd)||$dbpwd==''){
			$message['code']=201;
			$message['msg']="数据库密码不能为空";
			echo json_encode($message);
			exit();
		}
		if(empty($dbpre)||$dbpre==''){
			$message['code']=201;
			$message['msg']="数据库表前缀不能为空";
			echo json_encode($message);
			exit();
		}

		$dbhost=$ip;
		$tablepre=$dbpre;
		
		//执行数据库初始化操作
		
		$forceinstall = isset($_POST['dbinfo']['forceinstall']) ? $_POST['dbinfo']['forceinstall'] : '';
		$dbname_not_exists = true;
		if(!empty($dbhost) && empty($forceinstall)) {
			$dbname_not_exists = $this->check_db($dbhost, $dbuser, $dbpwd, $dbname, $dbpre);
			if(!$dbname_not_exists) {
				$message['code']=2001;
				$message['msg']="数据库不为空，必须删除原来数据库才能操作";
				echo json_encode($message);
				exit();
			}
		}
		
		$con=mysqli_connect($ip, $dbuser, $dbpwd);
		if(!@$con) {
			
			$errno = mysqli_errno();
			$error = mysqli_error();
			if($errno == 1045) {
				$message['code']=201;
				$message['msg']="无法连接数据库，请检查数据库用户名或者密码是否正确";
				echo json_encode($message);
				exit();
				
			} elseif($errno == 2003) {
				$message['code']=201;
				$message['msg']="无法连接数据库，请检查数据库是否启动，数据库服务器地址是否正确";
				echo json_encode($message);
				exit();
			} elseif($errno == 1044) {
				$message['code']=201;
				$message['msg']="无法创建新的数据库，请检查数据库名称填写是否正确或者该用户是否具备创建数据库权限";
				echo json_encode($message);
				exit();
			}else {
				$message['code']=201;
				$message['msg']="无法连接数据库";
				echo json_encode($message);
				exit();
			}
		}
		
		$sqlver=mysqli_get_server_info($con);
		if($sqlver> '4.1') {
			if($sqlver< '5.5') {
				$message['code']=201;
				$message['msg']="数据库版本太低，mysql版本5.5-5.7最佳";
				echo json_encode($message);
				exit();
			}
			
			mysqli_query($con,"CREATE DATABASE IF NOT EXISTS `$dbname` DEFAULT CHARACTER SET ".DBCHARSET);
		} else {
	
			mysqli_query($con,"CREATE DATABASE IF NOT EXISTS `$dbname`");
		}
		
		if(mysqli_errno($con)) {
			$message['code']=201;
			$message['msg']="无法创建新的数据库，请检查数据库名称填写是否正确或者该用户是否具备创建数据库权限";
			echo json_encode($message);
			exit();
		}
		mysqli_close($con);

		$this->config_edit($dbhost,$dbuser,$dbpwd,$dbname,$tablepre);

		require WHATSNS_ROOT.'./lib/db_mysqli.php';
		$db=new db();
		$config=array();
		$config['hostname']=$dbhost;
		$config['username']=$dbuser;
		$config['password']=$dbpwd;
		$config['database']=$dbname;
		$config['charset']=DBCHARSET;
		// $config['autoconnect']=1;
		// $config['dbport']=3306;
		// $config['debug']=true;
			
	

		$sqlfile = WHATSNS_ROOT.'install/whatsns.sql';
		$sql = file_get_contents($sqlfile);
		$sql = str_replace("\r\n", "\n", $sql);	

		
		$returnmsg=$this->runquery($sql,$tablepre, $ip, $dbuser, $dbpwd,$dbname);
		$this->exutesql($tablepre, $ip, $dbuser, $dbpwd,$dbname);
	    if(!$_SESSION){
	    	session_start();
	    }
	    $_SESSION['db_host']=$ip;
	    $_SESSION['db_pre']=$tablepre;
	    $_SESSION['db_user']=$dbuser;
	    $_SESSION['db_pwd']=$dbpwd;
	    $_SESSION['db_name']=$dbname;
		$message['code']=200;
		$message['msg']='';
		echo json_encode($message);
		exit();
	}
	/**
	
	* 检测文件权限
	
	* @date: 2019年2月15日 上午11:50:55
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function getfileenv(){
		$dirfile_items = array
		(
				'webconfig' => array('type' => 'file', 'path' => './application/config/webconfig.php'),
				'databaseconfig' => array('type' => 'file', 'path' => './application/config/database.php'),
				'data' => array('type' => 'dir', 'path' => './data'),
				'category' => array('type' => 'dir', 'path' => './data/category'),
				'cache' => array('type' => 'dir', 'path' => './data/cache'),
				'view' => array('type' => 'dir', 'path' => './data/view'),
				'avatar' => array('type' => 'dir', 'path' => './data/avatar'),
				'logs' => array('type' => 'dir', 'path' => './data/logs'),
				'backup' => array('type' => 'dir', 'path' => './data/backup'),
				'attach' => array('type' => 'dir', 'path' => './data/attach'),
				'logo' => array('type' => 'dir', 'path' => './data/attach/logo'),
				'banner' => array('type' => 'dir', 'path' => './data/attach/banner'),
				'topic' => array('type' => 'dir', 'path' => './data/attach/topic'),
				'upload' => array('type' => 'dir', 'path' => './data/upload'),
				'ueditor' => array('type' => 'dir', 'path' => './data/ueditor'),
				'tmp' => array('type' => 'dir', 'path' => './data/tmp'),
				'qqconfig' => array('type' => 'dir', 'path' => './plugin/qqlogin/API/comm'),
				'sinaconfig' => array('type' => 'dir', 'path' => './plugin/sinalogin'),
				'views' => array('type' => 'dir', 'path' => './application/views')
				
		);
		
		$this->dirfile_check($dirfile_items);
	
		echo json_encode($dirfile_items);
		exit();
	}

	/**
	
	* 检测运行环境
	
	* @date: 2019年2月15日 上午10:02:25
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function getenv() {

       //web服务器类型
		if(strstr($_SERVER['SERVER_SOFTWARE'],'iis')){
			$msg="[IIS不推荐]";
			$pass=1;
		}else{
			$msg="[环境支持]";
			$pass=1;
		}
		$webserver=array('web服务器环境','apache/nginx,不推荐IIS',$_SERVER['SERVER_SOFTWARE'].$msg,$pass);
       //PHP类型
		if(PHP_VERSION<5.4){
			$msg="[版本太低]";
			$pass=0;
		}else{
			$msg="[环境支持]";
			$pass=1;
		}
		$phpserver=array('PHP版本','PHP5.4+',PHP_VERSION.$msg,$pass);
       //GD类型
       $gd = function_exists('gd_info') ? gd_info() : array();
       if(empty($gd['GD Version'])){
       	$msg="[服务器端没安装GD]";
       	$pass=0;
       }else{
       	$numv=str_replace('bundled (', '', $gd['GD Version']);
       	
       	$numv=str_replace('compatible)', '',$numv);
       	if(doubleval($numv)>=2){
       		$msg="[环境支持]";
       		$pass=1;
       	}else{
       		$msg="[gd版本太低]";
       		$pass=0;
       	}
       
       
       }
       $gdversion=array('GD图形库版本','2.0或更高',empty($gd['GD Version']) ? '服务器端没安装GD' : $gd['GD Version'].$msg,$pass);
     
       //sesstion检测
       $views=require('count.php');
       $views1=require('count.php');
       if(trim($views1)>=2){
       	$msg="[环境支持]";
       	$pass=1;
       }else{
       	$msg="[环境不支持，sesstion写入权限不够--$views1]";
       	$pass=0;
       }
       $sesstionmsg=array('SESSTION支持','需支持读写权限',$msg,$pass);
       $message=array($webserver,$phpserver,$gdversion,$sesstionmsg);
       //函数检测
       $funarr=array("mysqli_connect","fsockopen","gethostbyname","file_get_contents","xml_parser_create");
       foreach ($funarr as $item){
       	if(function_exists($item)){
       		$tmp=array($item."函数",'支持',"[环境支持]",1);
       	}else{
       		$tmp=array($item."函数",'支持',"[环境不支持]",0);
       	}
       	array_push($message,$tmp);
       }
    
       
   
       
       echo json_encode($message);
       exit();
	}
	
	
	function dirfile_check(&$dirfile_items) {
		foreach($dirfile_items as $key => $item) {
			$item_path = $item['path'];
			if($item['type'] == 'dir') {
				
				if(!$this->dir_writeable(WHATSNS_ROOT.$item_path)) {
					
					if(is_dir(WHATSNS_ROOT.$item_path)) {
						$dirfile_items[$key]['status'] = 0;
						$dirfile_items[$key]['current'] = '只读';
					} else {
						$dirfile_items[$key]['status'] = -1;
						$dirfile_items[$key]['current'] = '不是目录,或者目录不存在请先创建';
					}
				} else {
					
					$dirfile_items[$key]['status'] = 1;
					$dirfile_items[$key]['current'] = '可读可写';
					
				}
			} else {
				if(file_exists(WHATSNS_ROOT.$item_path)) {
					
					if(is_writable(WHATSNS_ROOT.$item_path)) {
						
						$dirfile_items[$key]['status'] = 1;
						
						$dirfile_items[$key]['current'] = '可读可写';
						
					} else {
						$dirfile_items[$key]['status'] = 0;
						$dirfile_items[$key]['current'] = '只读';
					}
				} else {
					if($this->dir_writeable(dirname(WHATSNS_ROOT.$item_path))) {
						$dirfile_items[$key]['status'] = 1;
						$dirfile_items[$key]['current'] = '可读可写';
					} else {
						$dirfile_items[$key]['status'] = -1;
						$dirfile_items[$key]['current'] = '没有文件，请先创建空文件';
					}
				}
			}
		}
	}
	function dir_writeable($dir) {
		$writeable = 0;
		if(!is_dir($dir)) {
			@mkdir($dir, 0777);
		}
		if(is_dir($dir)) {
			if($fp = @fopen("$dir/test.txt", 'w')) {
				@fclose($fp);
				@unlink("$dir/test.txt");
				$writeable = 1;
			} else {
				$writeable = 0;
			}
		}
		return $writeable;
	}
	
	function dir_clear($dir) {
		global $lang;
		$directory = dir($dir);
		while($entry = $directory->read()) {
			$filename = $dir.'/'.$entry;
			if(is_file($filename)) {
				@unlink($filename);
			}
		}
		$directory->close();
		@touch($dir.'/index.htm');
	}
	function file_put_contents(){
		if(!function_exists('file_put_contents')) {
			function file_put_contents($filename, $s) {
				$fp = @fopen($filename, 'w');
				@fwrite($fp, $s);
				@fclose($fp);
				return TRUE;
			}
		}
	}
	function random($length) {
		$hash = '';
		$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
		$max = strlen($chars) - 1;
		PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
		for($i = 0; $i < $length; $i++) {
			$hash .= $chars[mt_rand(0, $max)];
		}
		return $hash;
	}
	function generate_key() {
		
		$random = $this->random(32);
	
		$info = md5($random.time());
			
		$return = '';
		for($i=0; $i<64; $i++) {
			$p = intval($i/2);
			$return[$i] = $i % 2 ? $random[$p] : $info[$p];
		}
		return implode('', $return);
	}
	function check_db($dbhost, $dbuser, $dbpw, $dbname, $tablepre) {
		if(!function_exists('mysqli_connect')) {
			$message['code']=201;
			$message['msg']="mysqli_connect不存在，请确认php.ini是否开启mysqli";
			echo json_encode($message);
			exit();
		}
		$con=mysqli_connect($dbhost, $dbuser, $dbpw);
		if(!@$con) {
			$errno = mysqli_errno();
			$error = mysqli_error();
			if($errno == 1045) {
				$message['code']=201;
				$message['msg']="无法连接数据库，请检查数据库用户名或者密码是否正确";
				echo json_encode($message);
				exit();
				
			} elseif($errno == 2003) {
				$message['code']=201;
				$message['msg']="无法连接数据库，请检查数据库是否启动，数据库服务器地址是否正确";
				echo json_encode($message);
				exit();
			} elseif($errno == 1044) {
				$message['code']=201;
				$message['msg']="无法创建新的数据库，请检查数据库名称填写是否正确或者该用户是否具备创建数据库权限";
				echo json_encode($message);
				exit();
			}else {
				$message['code']=201;
				$message['msg']="无法连接数据库";
				echo json_encode($message);
				exit();
			}
		} else {
			if($query = mysqli_query($con,"SHOW TABLES FROM $dbname")) {
				while($row = mysqli_fetch_row($query)) {
					if(preg_match("/^$tablepre/", $row[0])) {
						return false;
					}
				}
			}
		}
		return true;
	}
	
	
	function runquery($sql,$tablepre,  $ip, $dbuser, $dbpwd,$dbname) {
		
		if(!isset($sql) || empty($sql)) return;
		$con=mysqli_connect($ip, $dbuser, $dbpwd);
		mysqli_set_charset($con, "utf8");
				mysqli_select_db($con,$dbname);
		mysqli_query($con,"set names utf8");

		$sql = str_replace("\r", "\n", str_replace("`whatsns_", "`$tablepre", $sql));
		$ret = array();
		$num = 0;
		
		foreach(explode(";\n", trim($sql)) as $query) {
			$ret[$num] = '';
			$queries = explode("\n", trim($query));
			foreach($queries as $query) {
				
				$ret[$num] .= (isset($query[0]) && $query[0] == '#') || (isset($query[1]) && isset($query[1]) && $query[0].$query[1] == '--') ? '' : $query;
			
			}
			$num++;
		}
		unset($sql);
	
		$msg='';
		foreach($ret as $query) {
			$query = trim($query);
			if($query) {
				
				if(substr($query, 0, 12) == 'CREATE TABLE') {
					
					//$name1 = preg_replace("/^CREATE TABLE \`(.*?)\`/", "\\1", $query);
					//$name2 = preg_replace("/^CREATE TABLE \`(.*?)\`/", "\\2", $query);
					//$name= str_replace($name2, '', $name1);
					
					//$msg.='<p>数据库表:'.' '.$name.' ... '.'创建成功</p><br>';
					mysqli_query($con,$query);
					
					//$db->query($query);
				} else {
					mysqli_query($con,$query);
					//$db->query($query);
				}
				
			}
		}
		mysqli_close($con);
		return $msg;
		
	}
	function configdomain($url,$dirname){
		$config['base_url'] =$url ; //后续修改成https后还需将https切换成https
		$webconfig = "<?php \r\n";
		$webconfig .="$"."config['base_url']='".  "$url';//默认网站配置\r\n";
		$webconfig .="$"."config['dir_name']='".  "$dirname';//如果是二级目录安装，这里是二级目录名称\r\n";
			$webconfig .="$"."config['course_url']='".  "$url/course/';//默认网站配置\r\n";
		$webstrdata = $webconfig ."$"."config['mobile_domain']='"."';//移动端网站可配置,/结尾\r\n?>";
		$fp = fopen(APPPATH . 'config/webconfig.php', 'w');
		fwrite($fp, $webstrdata);
		fclose($fp);
	}

	function config_edit($dbhost,$dbuser,$dbpwd,$dbname,$tablepre) {
		extract($GLOBALS, EXTR_SKIP);
		
		
		//保存数据库信息
		$version = WHATSNS_VERSION;
		$versiondate = date ( "Ymd" );
		$config = "<?php \r\n";
		$config .= "defined('BASEPATH') OR exit('No direct script access allowed');\r\n";
		$config .= '$active_group' . " = 'default';\r\n";
		$config .= '$query_builder' . "  = TRUE;\r\n";
		$config .= "defined('ASK2_CHARSET') OR define('ASK2_CHARSET', 'UTF-8');\r\n";
		$config .= "defined('ASK2_VERSION') OR define('ASK2_VERSION', '$version');\r\n";
		$config .= "defined('ASK2_RELEASE') OR define('ASK2_RELEASE', '$versiondate');\r\n";
		
		if (! file_exists (  $file_path = APPPATH . 'config' . DIRECTORY_SEPARATOR . 'database.php' )) {
			$message['code']=201;
			$message['msg']=APPPATH . 'config' . DIRECTORY_SEPARATOR . 'database.php文件不存在';
			echo json_encode($message);
			exit();
		}
	//	if(strstr($_SERVER['SERVER_SOFTWARE'],'IIS')){
		//	$file_path="../application/config/database.php";
			
	//	}

		include $file_path;
		

		$database=$db[$active_group];

		$database['hostname']=$dbhost;
		$database['username']=$dbuser;
		$database['password']=$dbpwd;
		$database['database']=$dbname;
		$database['char_set']=DBCHARSET;
		$database['dbprefix']=$tablepre;
		$strdata = $config . "$" . "db['default'] =" . var_export ( $database, true ) . ";\n?>";
	
		$fp = fopen(APPPATH . 'config/database.php', 'w');
		fwrite($fp, $strdata);
		fclose($fp);
		
	}
	function deleteDir($dir)
	{
		if (!$handle = @opendir($dir)) {
			return false;
		}
		while (false !== ($file = readdir($handle))) {
			if ($file !== "." && $file !== "..") {       //排除当前目录与父级目录
				$file = $dir . '/' . $file;
				if (is_dir($file)) {
					deleteDir($file);
				} else {
					@unlink($file);
				}
			}
			
		}
		@rmdir($dir);
	}
}
$localfile=WHATSNS_ROOT."data/install.lock";
if(file_exists($localfile)){
	$message['code']=2001;
	$message['msg']="网站已经安装过了";
	echo json_encode($message);
	exit();
}

$type=$_GET['type'];
switch ($type){
	case 'getenv':
		$install=new Install();
		$install->getenv();
		break;
	case 'getfileenv':
		$install=new Install();
		$install->getfileenv();
		break;
	case 'initdb':
		$install=new Install();
		$install->initdb();
		break;
	case 'inituser':
		$install=new Install();
		$install->createuser();
		break;
	case 'createsiteinfo':
		$install=new Install();
		$install->createsiteinfo();
		break;
}