<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Admin_myplugin extends ADMIN_Controller {
	function __construct() {
		parent::__construct ();
		$this->load->model('plugin_model');
	}
	/**
	 *
	 * 插件列表
	 *
	 * @date: 2020年11月2日 上午10:36:11
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function clist() {
		$this->createPluginTable();
		$navtitle = "插件列表";
		@$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
		$pagesize = 50;
		$startindex = ($page - 1) * $pagesize;
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( "admin_nav", " pid=1 ", $this->db->dbprefix ) )->row_array () );
		$departstr = page ( $rownum, $pagesize, $page, "admin_myplugin/list" );
		// 读取插件列表
		$pluginlist = $this->db->where(array (
				'pid' => 1
		) )->limit($pagesize, $startindex)->get ( 'admin_nav')->result_array ();
		include template ( "myplugin", "admin" );
	}
	/**
	
	* 插件日志
	
	* @date: 2020年11月3日 下午1:18:13
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function pluginlog($name=''){
		$this->createPluginTable();
		$navtitle = "插件日志列表";
		$pluginname='';
		if(!empty($name)){
			$pluginname=addslashes(strip_tags($name));
		}
		if($pluginname==''&&$_POST){
			$pluginname=addslashes(strip_tags($_POST['pgname']));
		}
		@$page = max ( 1, intval ( $this->uri->segment ( 4 ) ) );
		$pagesize = 50;
		$startindex = ($page - 1) * $pagesize;
		
		$rownum=$this->plugin_model->gettotal($pluginname);
		if($pluginname!=''){
			$url="admin_myplugin/pluginlog/$pluginname";
		}else{
			$url="admin_myplugin/pluginlog";
		}
		$departstr = page ( $rownum, $pagesize, $page, $url );
		$pluginlist=$this->plugin_model->get_list($pluginname,$startindex,$pagesize);
		include template ( "plugin/plugininstalllog", "admin" );
	}
	/**
	 *
	 * web远程下载插件安装
	 *
	 * @date: 2020年11月3日 上午11:53:41
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function webuploadplugin() {
		$downpluginurl = $this->input->post ( 'downpluginurl' );
		if ($downpluginurl == '' || empty ( $downpluginurl )) {
			$this->message ( "web远程插件地址不能为空" );
			exit ();
		}
		$ext = pathinfo ( $downpluginurl ) ['extension'];
		if ($ext == 'zip') {
			$config = array (
					"uploadPath" => "data/dir_backup/zip/"
			);
			//执行下载
			$zipname = "zip_" . time ();
			
			forcemkdir ( FCPATH . $config ['uploadPath'] );
			$currentzipdir = FCPATH . $config ['uploadPath'] . $zipname . "/";
			forcemkdir ( $currentzipdir );
			// 判断目录是否存在
			if (! is_dir ( FCPATH . $config ['uploadPath'] )) {
				$this->message ( $config ['uploadPath'] . "目录不存在" );
				exit ();
			}
			if (! is_dir ( $currentzipdir )) {
				$this->message ( $currentzipdir . "目录不存在" );
				exit ();
			}
			// 当前上传的zip文件
			$upload_tmp_file = $currentzipdir . $zipname . ".zip";
			$this->downfile($downpluginurl,$upload_tmp_file);
			// 判断文件是否存在
			if (! file_exists ( $upload_tmp_file )) {
				$this->message ( "上传文件失败，无法将文件上传到目录:" . $currentzipdir );
				exit ();
			}
			if (! file_exists ( $upload_tmp_file )) {
				$this->message ( "压缩包文件不存在" );
				exit ();
			}
			// 解压文件到指定目录
			$this->UnzipFile ( $upload_tmp_file, $currentzipdir );
			if ($this->dir_is_empty( $currentzipdir )) {
				$this->message ( "解压失败文件：【".$upload_tmp_file."】失败" );
				exit ();
			}
			$files = $this->getpathlist ( $currentzipdir, $upload_tmp_file );
			$fileinstalljson = $currentzipdir . "install.json";
			// 如果插件安装文件不存在
			if (! file_exists ( $fileinstalljson )) {
				// 删除上传的zip和解压的目录
				$this->delete_file_and_dir ( $upload_tmp_file, $currentzipdir );
				$this->message ( $fileinstalljson . "文件不存在，插件安装异常" );
				exit ();
			}
			// 如果存在就读取
			$pluginjson = file_get_contents ( $fileinstalljson );
			$plugin_arr = json_decode ( $pluginjson, true );
			if (is_array ( $plugin_arr )) {
				if (strtoupper ( substr ( PHP_OS, 0, 3 ) ) === 'WIN') {
					$_upfile = str_replace ( str_replace ( '/', '\\', FCPATH ), '', $upload_tmp_file );
				} else {
					$_upfile = str_replace ( FCPATH, '', $upload_tmp_file );
				}
				// 插件访问地址必须要有
				if ($plugin_arr ['manageurl'] == '' || empty ( $plugin_arr ['manageurl'] )) {
					// 删除上传的zip和解压的目录
					$this->delete_file_and_dir ( $upload_tmp_file, $currentzipdir );
					$this->message ( "插件访问地址不存在" );
					exit ();
				}
				$insertdata = array (
						'author' => strip_tags ( $plugin_arr ['author'] ),
						'version' => floatval ( $plugin_arr ['version'] ),
						'name' => strip_tags ( $plugin_arr ['name'] ),
						'englishname' => strip_tags ( $plugin_arr ['englishname'] ),
						'manageurl' => strip_tags ( $plugin_arr ['manageurl'] ),
						'installtime' => time (),
						'filelist' => json_encode ( $files ),
						'lastupdatetime' => time (),
						'uploadfile' => $_upfile
				);
				// 动态创建插件表，如果没有此表
				$this->createPluginTable ();
				if (! file_exists ( $upload_tmp_file )) {
					$this->message ( "压缩包文件不存在" );
					exit ();
				}
				// 备份文件
				$this->BackFiles ( $currentzipdir, $files );
				// 拷贝文件
				$this->MoveFiles ( $currentzipdir, $files );
				// 插入新插件
				$this->DoPlugin ( $insertdata );
			}
			
			$this->message ( "插件安装成功" );
			exit ();
		} else {
			$this->message ( "插件安装包只能是zip格式" );
			exit ();
		}
	}
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
	 *
	 * 本地上传插件
	 *
	 * @date: 2020年11月2日 上午10:36:25
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function localuploadplugin() {
		if ($this->user ['uid'] <= 0) {
			
			$this->message ( "请先登录", 'user/login' );
			exit ();
		}
		// 获取上传文件
		// 上传配置 --最大上传50M
		$config = array (
				"uploadPath" => "data/dir_backup/zip/",
				"fileType" => array (
						".zip" 
				),
				"fileSize" => 50  // 若修改最大插件上传大小请修改此处-默认50M
		);
		if ($_FILES ['uplocalfile'] != null) {
			$file = $_FILES ['uplocalfile'];
		} else {
			$this->message ( "请上传插件zip文件" );
			exit ();
		}
		// 判断上传文件格式
		$current_type = strtolower ( strrchr ( $file ["name"], '.' ) );
		if (! in_array ( $current_type, $config ['fileType'] )) {
			$this->message ( "只允许上传格式：" . trim ( implode ( ',', $config ['fileType'] ), ',' ) );
			exit ();
		}
		
		// 大小验证
		$file_size = 1024 * 1024 * $config ['fileSize'];
		if ($file ["size"] > $file_size) {
			$state = "b";
			$this->message ( "只允许最大上传插件安装包大小：" . $config ['fileSize'] . "M" );
			exit ();
		}
		if (preg_match ( "/[\',:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/", $file ["name"] )) { // 不允许特殊字符
			$this->message ( "文本名不允许包含特殊字符" );
			exit ();
		}
		$zipname = "zip_" . time ();
		
		forcemkdir ( FCPATH . $config ['uploadPath'] );
		$currentzipdir = FCPATH . $config ['uploadPath'] . $zipname . "/";
		forcemkdir ( $currentzipdir );
		// 判断目录是否存在
		if (! is_dir ( FCPATH . $config ['uploadPath'] )) {
			$this->message ( $config ['uploadPath'] . "目录不存在" );
			exit ();
		}
		if (! is_dir ( $currentzipdir )) {
			$this->message ( $currentzipdir . "目录不存在" );
			exit ();
		}
		// 当前上传的zip文件
		$upload_tmp_file = $currentzipdir . $zipname . ".zip";
		if (move_uploaded_file ( $file ['tmp_name'], $upload_tmp_file )) {
			// 判断文件是否存在
			if (! file_exists ( $upload_tmp_file )) {
				$this->message ( "上传文件失败，无法将文件上传到目录:" . $currentzipdir );
				exit ();
			}
			if (! file_exists ( $upload_tmp_file )) {
				$this->message ( "压缩包文件不存在" );
				exit ();
			}
			// 解压文件到指定目录
			$this->UnzipFile ( $upload_tmp_file, $currentzipdir );
			if ($this->dir_is_empty( $currentzipdir )) {
				$this->message ( "解压失败文件：【".$upload_tmp_file."】失败" );
				exit ();
			}
			$files = $this->getpathlist ( $currentzipdir, $upload_tmp_file );
			$fileinstalljson = $currentzipdir . "install.json";
			// 如果插件安装文件不存在
			if (! file_exists ( $fileinstalljson )) {
				// 删除上传的zip和解压的目录
				$this->delete_file_and_dir ( $upload_tmp_file, $currentzipdir );
				$this->message ( $fileinstalljson . "文件不存在，插件安装异常" );
				exit ();
			}
			// 如果存在就读取
			$pluginjson = file_get_contents ( $fileinstalljson );
			$plugin_arr = json_decode ( $pluginjson, true );
			if (is_array ( $plugin_arr )) {
				if (strtoupper ( substr ( PHP_OS, 0, 3 ) ) === 'WIN') {
					$_upfile = str_replace ( str_replace ( '/', '\\', FCPATH ), '', $upload_tmp_file );
				} else {
					$_upfile = str_replace ( FCPATH, '', $upload_tmp_file );
				}
				// 插件访问地址必须要有
				if ($plugin_arr ['manageurl'] == '' || empty ( $plugin_arr ['manageurl'] )) {
					// 删除上传的zip和解压的目录
					$this->delete_file_and_dir ( $upload_tmp_file, $currentzipdir );
					$this->message ( "插件访问地址不存在" );
					exit ();
				}
				$insertdata = array (
						'author' => strip_tags ( $plugin_arr ['author'] ),
						'version' => floatval ( $plugin_arr ['version'] ),
						'name' => strip_tags ( $plugin_arr ['name'] ),
						'englishname' => strip_tags ( $plugin_arr ['englishname'] ),
						'manageurl' => strip_tags ( $plugin_arr ['manageurl'] ),
						'installtime' => time (),
						'filelist' => json_encode ( $files ),
						'lastupdatetime' => time (),
						'uploadfile' => $_upfile 
				);
				// 动态创建插件表，如果没有此表
				$this->createPluginTable ();
				if (! file_exists ( $upload_tmp_file )) {
					$this->message ( "压缩包文件不存在" );
					exit ();
				}
				// 备份文件
				$this->BackFiles ( $currentzipdir, $files );
				// 拷贝文件
				$this->MoveFiles ( $currentzipdir, $files );
				// 插入新插件
				$this->DoPlugin ( $insertdata );
			}
			
			$this->message ( "插件安装成功" );
			exit ();
		} else {
			
			$this->message ( '上传失败，服务器忙，请稍后再试！' );
			exit ();
		}
	}
	
	/**
	 *
	 * 动态创建插件表
	 *
	 * @date: 2020年11月3日 上午10:56:25
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function createPluginTable() {
		$hasplugintable = $this->db->query ( "SELECT table_name FROM information_schema.TABLES WHERE table_name ='" . $this->db->dbprefix . "pluginlist';" )->row_array ();
		if (! $hasplugintable) {
			// 如果不存在就创建
			// 增加 登录日志表
			$sql = "CREATE TABLE `" . $this->db->dbprefix . "pluginlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL DEFAULT '' COMMENT '插件名称',
  `filelist` mediumtext NOT NULL COMMENT '插件文件列表',
  `installtime` int(11) NOT NULL DEFAULT '0' COMMENT '插件上传时间',
  `uploadfile` varchar(200) NOT NULL DEFAULT '' COMMENT '插件上传地址',
  `author` varchar(50) NOT NULL DEFAULT '' COMMENT '插件上传作者',
  `manageurl` varchar(255) NOT NULL DEFAULT '' COMMENT '插件后台管理地址',
  `lastupdatetime` int(11) NOT NULL DEFAULT '0' COMMENT '最后更新时间',
  `version` varchar(50) NOT NULL DEFAULT '' COMMENT '插件版本',
  `englishname` varchar(255) NOT NULL DEFAULT '' COMMENT '插件英文名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='插件列表';
					
";
			$this->db->query ( $sql );
		}
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
		if (file_exists ( $backupdir . "install.json" )) {
			unlink ( $backupdir . "install.json" );
		}
		// 如果备份目录不为空就备份zip
		if (! $this->dir_is_empty ( $backupdir )) {
			$this->ZipDir ( $backupdir );
		}
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
	 * 执行插件安装过程
	 *
	 * @date: 2020年11月2日 下午4:43:21
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function DoPlugin($insertdata) {
		$this->db->insert ( 'pluginlist', $insertdata );
		$id = $this->db->insert_id ();
		if ($id) {
			$adddata = array (
					'name' => $insertdata ['name'],
					'url' => $insertdata ['manageurl'],
					'pid' => 1 
			);
			$hasdata=$this->db->get_where('admin_nav',$adddata)->row_array();
			if(!$hasdata){
				$this->db->insert ( "admin_nav", $adddata );
				$id = $this->db->insert_id ();
				if ($id > 0) {
					// 更新排序
					$this->db->where ( array (
							'id' => $id
					) )->update ( 'admin_nav', array (
							'ordernum' => $id
					) );
					// 更新子导航个数
					$navnums = returnarraynum ( $this->db->query ( getwheresql ( 'admin_nav', "pid=1", $this->db->dbprefix ) )->row_array () );
					
					$this->db->where ( array (
							'id' => 1
					) )->update ( 'admin_nav', array (
							'childs' => $navnums
					) );
				}
			}
		
		}
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
				$this->message ( "文件解压失败" );
				exit ();
			}
		} catch ( Exception $e ) {
			$this->message ( "文件解压失败" );
			exit ();
		}
	}
	/**
	 *
	 * 删除指定目录和文件
	 *
	 * @date: 2020年11月2日 下午12:33:14
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function delete_file_and_dir($file, $dir) {
		// 删除文件
		if ($file != '' && file_exists ( $file )) {
			unlink ( $file );
		}
		// 删除文件夹
		if (is_dir ( $dir )) {
			$this->deleteDir ( $dir );
		}
	}
	/**
	 *
	 * 删除指定文件夹以及文件夹下的所有文件
	 *
	 * @date: 2020年11月2日 下午12:34:41
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function deleteDir($dir) {
		
		// 先删除目录下的文件：
		$dh = opendir ( $dir );
		while ( $file = readdir ( $dh ) ) {
			if ($file != "." && $file != "..") {
				$fullpath = $dir . "/" . $file;
				if (! is_dir ( $fullpath )) {
					unlink ( $fullpath );
				} else {
					$this->deleteDir ( $fullpath );
				}
			}
		}
		
		closedir ( $dh );
		// 删除当前文件夹：
		if (rmdir ( $dir )) {
			return true;
		} else {
			return false;
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
}

?>