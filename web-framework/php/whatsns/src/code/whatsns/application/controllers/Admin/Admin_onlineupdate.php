<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Admin_onlineupdate extends ADMIN_Controller {
	function __construct() {
		parent::__construct ();
	}
	function index() {
		$navtitle="在线更新";
		$timedir = date ( 'Ymd' );
		
		if (! is_dir ( FCPATH . 'data/dir_backup' )) {
			mkdir ( FCPATH . 'data/dir_backup' );
		}
		
	
		$msg='';
		$leveltext='您当前域名未提供whatsns官方授权，默认只能更新免费版文件,如果授权域名不对可联系官方qq：617035918，变更授权。';
		//获取可更新的列表
		$navtitle="我的更新记录";
		$token=getAccessToken();
		if(is_array($token)){
			$msg.=$token['msg'];
		}else{
			$result=curl_post(config_item("getupdatelist"),array('accesstoken'=>$token,'pageindex'=>1));
			$filelist=null;
			
			if($result['code']==200){
				$filelist=$result['data']['data'];
		
				$leveltext=$result['data']['leveltext'];
			}else{
				$msg.=$result['msg'];
					$leveltext=$result['data']['leveltext'];
			}
		}
		$dirlocation=FCPATH."data/dir_backup/webupdate";
		include template('onlineupdate/updatelist','admin');
	}
	/**
	
	* 增加文件对比
	
	* @date: 2020年12月3日 下午5:53:28
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function duibi(){
		$fileid=intval($_POST['fileid']);
		$dirlocation=FCPATH."data/dir_backup/webupdate";
		$currentdir=$dirlocation."/zip_".$fileid;//获取当前下载目录
		$oldbackdir=$currentdir."/backup";//覆盖之前的目录
		$webdir=FCPATH;//当前站点下的目录
		//判断目录是否存在
		if($this->dir_is_empty($currentdir)){
			$message['code']=201;
			$message['msg']="请先点击'下载并更新'";
			echo json_encode($message);
			exit();
		}
		//获取下载目录下全部文件夹和文件
		$this->load->helper ( 'file' );
		$files = get_filenames ( $currentdir, true );
		$fileslist = array ();
		//定义一个备份数组
		$backlist=array();
		//定义可以对比前的页面
		$urllist=array();
		//定义可以对比后的页面
		$urllist2=array();
		// 禁止上传的文件后缀，触发就删掉
		$file_exts = array (
				'.exe',
				
				'.rar',
				'.bat',
				'.sh',
				'.md'
		);

		foreach ( $files as $file ) {
			$current_type = strtolower ( strrchr ( $file, '.' ) );
			$_file = get_file_info ( $file );
			if (in_array ( $current_type, $file_exts ) ) {
				unlink ( $file );
			} else {
				$filetmp=$file;
				if (strtoupper ( substr ( PHP_OS, 0, 3 ) ) === 'WIN') {
					$filetmp=str_replace ( '/', '\\', $filetmp );
					$oldbackdir=str_replace ( '/', '\\', $oldbackdir );
				}
				if(!strstr($filetmp,$oldbackdir)){
					if (strtoupper ( substr ( PHP_OS, 0, 3 ) ) === 'WIN') {
						$_file = str_replace ( str_replace ( '/', '\\', $currentdir ), '', $file );
						$oldbackdir=str_replace ( '/', '\\', $oldbackdir );
					} else {
						$_file = str_replace ( $currentdir, '', $file );
					}
					$_thisfile=str_replace ( $currentdir, '', $_file ) ;
					//判断备份文件是否存在
					if(file_exists($oldbackdir.$_thisfile)){
						array_push ( $backlist, 1);	
						array_push($urllist, url('admin_onlineupdate/compare/'.$fileid."/".base64_encode($_thisfile)));
						array_push($urllist2, url('admin_onlineupdate/compareafter/'.$fileid."/".base64_encode($_thisfile)));
						
					}else{
						array_push ( $backlist, 0);	
						array_push($urllist,'');
						if(!file_exists(FCPATH.$_thisfile)){
							array_push($urllist2,0);
						}else{
							array_push($urllist2, url('admin_onlineupdate/compareafter/'.$fileid."/".base64_encode($_thisfile)));
							
						}
						
					}
					array_push ( $fileslist, $_thisfile);		
				}
																							
			}
		}
	
		if(!empty($fileslist)){
			
			//如果更新文件列表不为空
			if (strtoupper ( substr ( PHP_OS, 0, 3 ) ) === 'WIN') {
				
				$currentdir=str_replace ( '/', '\\', $currentdir );
			}
			$message['code']=200;
			$message['packagedir']=$currentdir;
			$message['backlist']=$backlist;
			$message['urllist']=$urllist;
			$message['urllist2']=$urllist2;
			$message['data']=$fileslist;
			$message['msg']="获取更新文件成功";
			echo json_encode($message);
			exit();
		}else{
			$message['code']=201;
			$message['msg']="没找到更新包下的文件";
			echo json_encode($message);
			exit();
		}
	}
	/**
	
	* 对比更新前后新旧文件
	
	* @date: 2020年12月4日 下午2:03:01
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function compare(){
		ini_set('memory_limit','64M');
		$fileid=intval( $this->uri->rsegments [3]);
		$file= base64_decode( $this->uri->rsegments [4] ); // 接收编码后的文件
		if($file==''||empty($file)){
			exit("需要对比文件不存在");
		}
		
		$dirlocation=FCPATH."data/dir_backup/webupdate";
		$currentdir=$dirlocation."/zip_".$fileid;//获取当前下载目录
		$oldbackdir=$currentdir."/backup";//覆盖之前的目录
		$webdir=FCPATH;//当前站点下的目录
		//判断目录是否存在
		if($this->dir_is_empty($currentdir)){
			exit("站点下更新包不存在，请先下载更新后对比");
		}
	
		require_once 'duibifile.php';
		echo "<h2>左侧为更新包中的文件，右侧为更新前备份路径（$oldbackdir.$file)下文件</h2><br>";
	
		$diff = Diff::compareFiles($currentdir.$file,$oldbackdir.$file);
		
		echo Diff::toTable($diff);
		echo "<style>
    .diff td{
        vertical-align : top;
        white-space    : pre;
        white-space    : pre-wrap;
        font-family    : monospace;
    }
    .diff td.diffDeleted{
        background:#FFE0E0;
    }
    .diff td.diffInserted{
        background:#E0FFE0;
    }
</style>";
	}
	/**
	
	* 对比更新后的文件
	
	* @date: 2020年12月4日 下午2:10:10
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function compareafter(){
		ini_set('memory_limit','64M');
		$fileid=intval( $this->uri->rsegments [3]);
		$file= base64_decode( $this->uri->rsegments [4] ); // 接收编码后的文件
		if($file==''||empty($file)){
			exit("需要对比文件不存在");
		}
		
		$dirlocation=FCPATH."data/dir_backup/webupdate";
		$currentdir=$dirlocation."/zip_".$fileid;//获取当前下载目录
		$oldbackdir=$currentdir."/backup";//覆盖之前的目录
		$webdir=FCPATH;//当前站点下的目录
		//判断目录是否存在
		if($this->dir_is_empty($currentdir)){
			exit("站点下更新包不存在，请先下载更新后对比");
		}
		
		require_once 'duibifile.php';
		echo "<h2>左侧为更新包中的文件，右侧为当前站点对应路径（$file)下文件</h2><br>";
		echo "左侧为更新包中文件 修改日期为：",date("Y-m-d H:i:s",filemtime($currentdir.$file))."<br>";
		echo "右侧为当前站点路径文件 修改日期为：",date("Y-m-d H:i:s",filemtime($webdir.$file))."<br>";
		$diff = Diff::compareFiles($currentdir.$file,$webdir.$file);
		
		echo Diff::toTable($diff);
		echo "<style>
    .diff td{
        vertical-align : top;
        white-space    : pre;
        white-space    : pre-wrap;
        font-family    : monospace;
    }
    .diff td.diffDeleted{
        background:#FFE0E0;
    }
    .diff td.diffInserted{
        background:#E0FFE0;
    }
</style>";
	}
	/**
	
	* 恢复此节点的文件
	
	* @date: 2020年11月13日 下午1:46:34
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function backupsource(){
		$fileid=intval($this->input->post('fileid'));
		if($fileid==0){
			$message['code']=201;
			$message['msg']="当前下载文件id不存在";
			echo json_encode($message);
			exit();
		}
		$backupdir=FCPATH."data/dir_backup/webupdate/zip_".$fileid."/backup";
		if(!is_dir($backupdir)){
			$message['code']=201;
			$message['msg']="备份目录不存在";
			echo json_encode($message);
			exit();
		}
		if($this->dir_is_empty($backupdir)){
			$message['code']=201;
			$message['msg']="备份目录没有可备份的文件";
			echo json_encode($message);
			exit();
		}
		$files = $this->getpathlist ( $backupdir, FCPATH."data/dir_backup/webupdate/zip_".$fileid."/zip_".$fileid.".zip" );		
		// 拷贝文件
		$this->MoveFiles ( $backupdir, $files );
		$message['code']=200;
		$message['msg']="恢复成功";
		echo json_encode($message);
		exit();
	}
	/**
	
	* 下载并更新
	
	* @date: 2020年11月13日 上午10:53:15
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function updatefile(){
		$fileid=intval($this->input->post('fileid'));
		if($fileid==0){
			$message['code']=201;
			$message['msg']="当前下载文件id不存在";
			echo json_encode($message);
			exit();
		}
		$token=getAccessToken();
		if(is_array($token)){
			echo json_encode($token);
			exit();
		}else{
		
			$result=curl_post(config_item("getupdatebyfileid"),array('accesstoken'=>$token,'fileid'=>$fileid));
			if($result['code']!=200){
				echo json_encode($result);
				exit();
			}
			
			//获取下载文件
			$fileurl=$result['data']['data']['fileurl'];
			$version=$result['data']['data']['version'];
			$versiondate=date('Y-m-d H:i:s',$result['data']['data']['updatetime']);
			$this->webuploadpackage($fileurl,$fileid,$version,$versiondate);
			//执行下载
			exit();
		}
		
		
	}
	/**
	
	* 执行远程下载
	
	* @date: 2020年11月13日 上午11:45:08
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function webuploadpackage($fileurl,$fileid,$version,$versiondate) {
	
		if ($fileurl == '' || empty ( $fileurl )) {
		
			$message['code']=201;
			$message['msg']="更新文件不存在";
			echo json_encode($message);
			exit();
		}
		$ext = pathinfo ( $fileurl ) ['extension'];
		if ($ext == 'zip') {
			$timedir = date ( 'Ymd' );
			$config = array (
					"uploadPath" => "data/dir_backup/webupdate/"
			);
			
			
			if (! is_dir ( FCPATH . 'data/dir_backup' )) {
				mkdir ( FCPATH . 'data/dir_backup' );
			}
			
			$dir_application_filedir = FCPATH . 'data/dir_backup/' ;
			if (! is_dir ( $dir_application_filedir )) {
				mkdir ( $dir_application_filedir );
			}
			
			$zipname = "zip_" . $fileid;
			
			forcemkdir ( FCPATH . $config ['uploadPath'] );
			$currentzipdir = FCPATH . $config ['uploadPath'] . $zipname . "/";
			forcemkdir ( $currentzipdir );
			// 判断目录是否存在
			if (! is_dir ( FCPATH . $config ['uploadPath'] )) {
				$message['code']=201;
				$message['msg']=$config ['uploadPath'] . "目录不存在";
				echo json_encode($message);
				exit();
				
			}
			
			if (! is_dir ( $currentzipdir )) {
				$message['code']=201;
				$message['msg']= $currentzipdir . "目录不存在" ;
				echo json_encode($message);
				exit();				
			}
			// 当前上传的zip文件
			$upload_tmp_file = $currentzipdir . $zipname . ".zip";
			//执行下载
			$this->downfile($fileurl,$upload_tmp_file);
		
			// 判断文件是否存在
			if (! file_exists ( $upload_tmp_file )) {
				$message['code']=201;
				$message['msg']= "上传文件失败，无法将文件上传到目录:" . $currentzipdir ;
				echo json_encode($message);
				exit();	
				
			}
			if (! file_exists ( $upload_tmp_file )) {
				
				$message['code']=201;
				$message['msg']= "压缩包文件不存在";
				echo json_encode($message);
				exit();	
			}
			//如果存在执行文件就删除
			$filesql=FCPATH.'updatetable.sql';
			if(file_exists($filesql)){
				unlink($filesql);
			}
			
			// 解压文件到指定目录
			$this->UnzipFile ( $upload_tmp_file, $currentzipdir );
			if ($this->dir_is_empty( $currentzipdir )) {
				$message['code']=201;
				$message['msg']= "解压失败文件：【".$upload_tmp_file."】失败" ;
				echo json_encode($message);
				exit();	
				
			}
		
			$files = $this->getpathlist ( $currentzipdir, $upload_tmp_file );
			$backupdir = $currentzipdir . "backup/";
			forcemkdir ( $backupdir );
			// 如果备份目录为空就备份
			if ($this->dir_is_empty ( $backupdir )) {
				// 备份文件
				$this->BackFiles ( $currentzipdir, $files );
			}
			
		

			// 拷贝文件
			$this->MoveFiles ( $currentzipdir, $files );
			$this->config_edit($version,$versiondate);
			if(file_exists($upload_tmp_file)){
				//更新完成删除更新zip文件
				unlink($upload_tmp_file);
			}
		    //判断是否有更新文件
		    if(file_exists($filesql)){
		    	//如果存在需要执行的sql就更新
		    	$sql = file_get_contents($filesql);
		    	$sql = str_replace("\r\n", "\n", $sql);
		    	
		    	
		    	$returnmsg=$this->runquery($sql);
		    }
			$message['code']=200;
			$message['msg']= "更新成功" ;
			echo json_encode($message);
			exit();	
		} else {
			
			$message['code']=200;
			$message['msg']= "更新包文件只能是zip格式" ;
			echo json_encode($message);
			exit();	
		}
	}
	function runquery($sql) {
		
		if(!isset($sql) || empty($sql)) return 0;

		$tablepre=$this->db->dbprefix;
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
		
		foreach($ret as $query) {
			$query = trim($query);
			if($query) {
				
				$this->db->query($query);
				
			}
		}
		
		return 1;
		
	}
	/**
	 *
	 * 移动文件到指定地方
	 *
	 * @date: 2020年11月2日 下午6:17:14
	 *
	 * @author : 61703
	 *
	 * @param
	 *        	: variable
	 *
	 * @return :
	 *
	 */
	function MoveFiles($currentzipdir, $files) {
		foreach ( $files as $file ) {
			$path_parts = pathinfo ( $file );
			if ($path_parts ['dirname'] != ".") {
				forcemkdir ( FCPATH . $path_parts ['dirname'] );
			}
			$current_type = strtolower ( strrchr ( $file, '.' ) );
			//不移动zip文件
			if($current_type!='.zip'){
				copy ( $currentzipdir . $file, FCPATH . $file );
			}
			
		}
	}
	/**
	 *
	 * 压缩备份指定文件夹
	 *
	 * @date: 2020年11月3日 上午9:52:38
	 *
	 * @author : 61703
	 *
	 * @param
	 *        	: variable
	 *
	 * @return :
	 *
	 */
	function ZipDir($dir) {
		$this->load->library ( 'zip' );
		$this->zip->clear_data ();
		$this->zip->read_dir ( $dir, false );
		$this->zip->archive ( $dir . 'backup.zip' );
	}
	/**
	 *
	 * 备份指定文件
	 *
	 * @date: 2020年11月2日 下午7:53:13
	 *
	 * @author : 61703
	 *
	 * @param
	 *        	: variable
	 *
	 * @return :
	 *
	 */
	function BackFiles($currentzipdir, $files) {
		$backupdir = $currentzipdir . "backup/";
		forcemkdir ( $backupdir );
		if (! is_dir ( $backupdir )) {
			$this->message ( $backupdir . "目录不存在" );
			exit ();
		}
		// 移动文件到指定目录下
		foreach ( $files as $file ) {
			if (file_exists ( FCPATH . $file )) {
				// 如果指定文件存在就备份到指定文件夹下
				$path_parts = pathinfo ( $file );
				if ($path_parts ['dirname'] != ".") {
					forcemkdir ( $backupdir . $path_parts ['dirname'] );
				}
				copy ( FCPATH . $file, $backupdir . $file );
			} else {
			}
		}
	
		// 如果备份目录不为空就备份zip
		if (! $this->dir_is_empty ( $backupdir )) {
			$this->ZipDir ( $backupdir );
		}
	}
	/**
	 *
	 * 获取当前目录下全部文件和文件夹下的文件
	 *
	 * @date: 2020年11月2日 下午3:21:46
	 *
	 * @author : 61703
	 *
	 * @param
	 *        	: variable
	 *
	 * @return :
	 *
	 */
	function getpathlist($dir, $zipfile) {
		$this->load->helper ( 'file' );
		$files = get_filenames ( $dir, true );
		$fileslist = array ();
		// 禁止上传的文件后缀，触发就删掉
		$file_exts = array (
				'.exe',
				'.zip',
				'.rar',
				'.bat',
				'.sh',
				'.md'
		);
		$_zipfile = get_file_info ( $zipfile );
		foreach ( $files as $file ) {
			$current_type = strtolower ( strrchr ( $file, '.' ) );
			$_file = get_file_info ( $file );
			if (in_array ( $current_type, $file_exts ) && $_file ['name'] != $_zipfile ['name']) {
				unlink ( $file );
			} else {
				if ($zipfile != $file) {
					if (strtoupper ( substr ( PHP_OS, 0, 3 ) ) === 'WIN') {
						$_file = str_replace ( str_replace ( '/', '\\', $dir ), '', $file );
					} else {
						$_file = str_replace ( $dir, '', $file );
					}
					array_push ( $fileslist, str_replace ( $dir, '', $_file ) );
				}
			}
		}
		return $fileslist;
	}
	/**
	 *
	 * 判断目录是否为空
	 *
	 * @date: 2020年11月3日 上午10:04:09
	 *
	 * @author : 61703
	 *
	 * @param
	 *        	: variable
	 *
	 * @return :
	 *
	 */
	function dir_is_empty($dir) {
		$handle = opendir ( $dir );
		while ( false !== ($entry = readdir ( $handle )) ) {
			if ($entry != "." && $entry != "..") {
				return FALSE;
			}
		}
		return TRUE;
	}
	/**
	 *
	 * 解压zip文件
	 *
	 * @date: 2020年11月2日 下午6:06:57
	 *
	 * @author : 61703
	 *
	 * @param
	 *        	: variable
	 *
	 * @return :
	 *
	 */
	function UnzipFile($upload_tmp_file, $currentzipdir) {
		try {
			// 解压文件到data/tmp临时文件夹
			$zip = new ZipArchive ();
			if ($zip->open ( $upload_tmp_file ) === true) {
				$zip->extractTo ( $currentzipdir );
				$zip->close ();
			} else {
				$message['code']=201;
				$message['msg']= "文件解压失败";
				echo json_encode($message);
				exit();	
				
			}
		} catch ( Exception $e ) {
			$message['code']=201;
			$message['msg']= "文件解压失败";
			echo json_encode($message);
			exit();
		
		}
	}
	/**
	
	* 更新版本信息
	
	* @date: 2020年11月12日 下午3:33:28
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function config_edit($versionnum,$versiondate) {
		extract($GLOBALS, EXTR_SKIP);
		
		
		//保存数据库信息
		$version = $versionnum;
		$config = "<?php \r\n";
		$config .= "defined('BASEPATH') OR exit('No direct script access allowed');\r\n";
		$config .= '$active_group' . " = 'default';\r\n";
		$config .= '$query_builder' . "  = TRUE;\r\n";
		$config .= "define('ASK2_CHARSET', 'UTF-8');\r\n";
		$config .= "define('ASK2_VERSION', '$version');\r\n";
		$config .= "define('ASK2_RELEASE', '$versiondate');\r\n";
		
		if (! file_exists (  $file_path = APPPATH . 'config' . DIRECTORY_SEPARATOR . 'database.php' )) {
			$message['code']=201;
			$message['msg']=APPPATH . 'config' . DIRECTORY_SEPARATOR . 'database.php文件不存在';
			echo json_encode($message);
			exit();
		}
		
		
		include ($file_path);
		
		$database=$db[$active_group];
		$strdata = $config . "$" . "db['default'] =" . var_export ( $database, true ) . ";\n?>";
		
		$fp = fopen(APPPATH . 'config/database.php', 'w');
		fwrite($fp, $strdata);
		fclose($fp);
		
	}
	/**
	
	* 远程下载附件
	
	* @date: 2020年10月5日 上午8:26:02
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/

	function downfile($url, $file="",$timeout=60){
		$file = empty($file) ? pathinfo($url,PATHINFO_BASENAME) : $file;
		$dir = pathinfo($file,PATHINFO_DIRNAME);
		!is_dir($dir) && @mkdir($dir,0755,true);
		$url = str_replace(" ","%20",$url);
		$contextOptions = [
				'ssl' => [
						'verify_host' => false,
						'verify_peer' => false,
						'verify_peer_name' => false
				]
		];//参数不验证远程主机
		$context = stream_context_create($contextOptions);
		if(@copy($url, $file, $context)) {
			//下载成功
		} else {
			return false;
		}
		
	}
	/**
	
	* 压缩文件夹
	
	* @date: 2020年10月5日 上午8:25:50
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function addFileToZip($path, $zip,$outdir='') {
		$handler = opendir ( $path ); // 打开当前文件夹由$path指定。
		/*
		 * 循环的读取文件夹下的所有文件和文件夹
		 * 其中$filename = readdir($handler)是每次循环的时候将读取的文件名赋值给$filename，
		 * 为了不陷于死循环，所以还要让$filename !== false。
		 * 一定要用!==，因为如果某个文件名如果叫'0'，或者某些被系统认为是代表false，用!=就会停止循环
		 */
		while ( ($filename = readdir ( $handler )) !== false ) {
			if ($filename != "." && $filename != "..") { // 文件夹文件名字为'.'和‘..’，不要对他们进行操作
				if (is_dir ( $path . "/" . $filename )) { // 如果读取的某个对象是文件夹，则递归
					$this->addFileToZip ( $path . "/" . $filename, $zip ,$outdir);
				} else { // 将文件加入zip对象
					$zip->addFile ( $path . "/" . $filename );
				}
			}
		}
		@closedir ( $path );
	}
}