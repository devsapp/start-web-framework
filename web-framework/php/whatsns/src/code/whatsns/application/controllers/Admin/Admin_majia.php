<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Admin_majia extends ADMIN_Controller {
	function __construct() {
		parent::__construct ();
	}
	function index($msg = '') {
		$msg && $message = $msg;
		if (null !== $this->input->post ( 'submit' )) {
			
			$tmpassword = $this->input->post ( 'addpassword' );
			$tmpassword1 = $this->input->post ( 'autopwd' );
			$pass = '';
			if ($tmpassword1 == 0) {
				if (trim ( $tmpassword ) == '') {
					echo "自己设置的密码不能为空，因为您没有选择系统自动生成密码";
					exit ();
				} else {
					if (strlen ( $tmpassword ) < 6) {
						echo "自己设置的密码不能小于6位数";
						exit ();
					}
				}
				$pass = $tmpassword;
			} else {
				$pass = random ( 12 );
			}
			
			if (! $_FILES ['txtfile'] ['tmp_name'] || ! $_FILES ['txtfile'] ['name']) {
				
				echo "请选择要上传的文件";
				exit ();
			}
			
			if ((($_FILES ["txtfile"] ["type"] == "text/plain"))) {
				if ($_FILES ["txtfile"] ["error"] > 0) {
					echo "Return Code: " . $_FILES ["txtfile"] ["error"] . "
";
					exit ();
				} else {
					
					$date = date ( "Ymd", time () );
					$dir = FCPATH . "/data/majiauser/" . $date;
					if (is_dir ( $dir )) {
						chmod ( $dir, 0777 ); // 修改文件权限
					}
					
					if (! is_dir ( $dir )) {
						mkdir ( $dir, 0777, true ); // 创建多级目录
					}
					$filename = $dir . '/' . random ( 6 ) . '.txt';
					if (file_exists ( $filename )) {
						$this->index ( "文件已经存在" );
					} else {
						move_uploaded_file ( $_FILES ["txtfile"] ["tmp_name"], $filename );
					}
				}
				if (! file_exists ( $filename )) {
					$this->index ( "文件不存在" );
				} else {
					$file = fopen ( $filename, "r" ) or exit ( "无法打开文件!" );
					header ( "Content-type: text/html; charset=utf-8" );
					$str_result = '';
					while ( ! feof ( $file ) ) {
						$line = fgets ( $file );
						$line = iconv ( 'gb2312', 'utf-8', $line );
						$line = trim ( $line );
						// 如果用户名长度小于30就添加
						if (strlen ( $line ) < 30) {
							
							if (! $this->user_model->get_by_username ( $line )) {
								// ucenter注册。
								$email = strtolower ( random ( 8 ) ) . "@qq.com";
								if ($this->setting ["ucenter_open"]) {
									$this->load->model ( 'ucenter_model' );
									$msg = $this->ucenter_model->ajaxregister ( $line, $pass, $email, '', 0 );
									if ($msg == 'ok') {
										// $uid = $_ENV['user']->adduserapi($username, $password, $email,$groupid);//插入model/user.class.php里adduserapi函数里
										$user = $this->user_model->get_by_username ( $line );
										$uid = $user ['uid'];
										$sitename = $this->setting ['site_name'];
										$this->load->model ( "doing_model" );
										$this->doing_model->add ( $uid, $line, 12, $uid, "欢迎您注册了$sitename" );
										$this->credit ( $uid, $this->setting ['credit1_register'], $this->setting ['credit2_register'] ); // 注册增加积分
										$str_result .= $line . ':添加成功!<br>';
									} else {
										$str_result .= $line . '---' . $email . ':' . $msg . '<br>';
									}
								} else {
									$this->user_model->caijiadd ( $line, $pass, random ( 8 ) . "@163.com", 1 );
									$str_result .= $line . ':添加成功!<br>';
								}
							} else {
								$str_result .= $line . ':已经存在相同的用户名，不会被添加<br>';
							}
						} else {
							$str_result .= $line . ':长度大于30不能被添加,中文一个汉字3个字节<br>';
						}
					}
					fclose ( $file );
					echo $str_result;
					exit ();
				}
			} else {
				echo "无效的文件";
				exit ();
			}
		}
		
		include template ( "automajia", "admin" );
	}
	/**
	 *
	 * 批量导入马甲通过文本框
	 *
	 * @date: 2020年10月29日 上午9:28:30
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function importmajiabytextarea() {
		$navtitle = "批量导入马甲";
		if ($_POST) {
			$str_result = '';
			$usernames = explode ( "\n", $this->input->post ( 'usernames' ) );
			$usersex = intval ( $this->input->post ( 'usersex' ) ); // -1 1,0
			$usersetavatar = intval ( $this->input->post ( 'useravatar' ) ); // 1 ,0
			if ($this->setting ["ucenter_open"]) {
				$this->load->model ( 'ucenter_model' );
			}
			$this->load->model ( "doing_model" );
			if ($usersex == - 1) {
				$usersex = rand ( 0, 1 );
			}
			$avatarlist=array();
			$avatarcount=0;
			if($usersetavatar){
				$avatarlist=$this->getavatarlist($usersex);
				$avatarcount=count($avatarlist);
			}
			foreach ( $usernames as $username ) {
				$username = str_replace ( array (
						"\r\n",
						"\n",
						"\r" 
				), '', $username );
				if (empty ( $username ))
					continue;
				$line = trim ( $username );
				$pass = random ( 12 );
				// 如果用户名长度小于60就添加
				if (strlen ( $line ) < 60) {
					
					if (! $this->user_model->get_by_username ( $line )) {
						// ucenter注册。
						$email = strtolower ( random ( 10 ) ) . "@qq.com";
						if ($this->setting ["ucenter_open"]) {
							$msg = $this->ucenter_model->ajaxregister ( $line, $pass, $email, '', 0 );
							if ($msg == 'ok') {
								
								$user = $this->user_model->get_by_username ( $line );
								$uid = $user ['uid'];
								$sitename = $this->setting ['site_name'];
								$this->doing_model->add ( $uid, $line, 12, $uid, "欢迎您注册了$sitename" );
								$this->credit ( $uid, $this->setting ['credit1_register'], $this->setting ['credit2_register'] ); // 注册增加积分
								$str_result .= $line . ':添加成功!<br>';
							} else {
								$str_result .= $line . '---' . $email . ':' . $msg . '<br>';
							}
						} else {
							$uid = $this->user_model->caijiadd ( $line, $pass, strtolower ( random ( 10 ) ) . "@163.com", 1 );
							if ($uid) {
								$str_result .= $line . ':添加成功!<br>';
							
								
								// 更新性别
								$this->db->where ( array (
										'uid' => $uid 
								) )->update ( 'user', array (
										'gender' => $usersex 
								) );
								
								//更新头像
								if($usersetavatar){
									$avatarindex=rand(0,$avatarcount);
									$avatar=$avatarlist[$avatarindex];
									//更新头像
									$this->setAvatar($avatar, $uid);
								}
							}
						}
					} else {
						$str_result .= $line . ':已经存在相同的用户名，不会被添加<br>';
					}
				} else {
					$str_result .= $line . ':长度大于60不能被添加,中文一个汉字3个字节<br>';
				}
			}
			$message ['code'] = 200;
			$message ['message'] = $str_result;
			echo json_encode ( $message );
			exit ();
		}
		include template ( "plugin/importmajiabytextarea", "admin" );
	}
	/**
	 *
	 * 根据选择的用户生成不同性别头像
	 *
	 * @date: 2020年10月29日 上午11:23:05
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function getavatarlist($gender) {
		$knamelist = array (
				'男生头像',
				'男生帅哥头像',
				'年轻男生头像' 
		);
		switch ($gender) {
			case 1 :
				$knamelist = array (
						'男生头像',
						'男生帅哥头像',
						'年轻男生头像' 
				);
				break;
			case 0 :
				$knamelist = array (
						'女生头像',
						'美女头像',
						'年轻美女头像' 
				);
				break;
			default :
				$knamelist = array (
						'男生头像',
						'男生帅哥头像',
						'年轻男生头像' 
				);
				break;
		}
		$avatarlist = array ();
		$mwtuid = array_rand ( $knamelist, 1 );
		$kname=$knamelist[$mwtuid];
		$strjosn = file_get_contents ( "https://image.baidu.com/search/acjson?tn=resultjson_com&logid=10695385866081272703&ipn=rj&ct=201326592&is=&fp=result&queryWord=$kname&cl=&lm=&ie=utf-8&oe=utf-8&adpicid=&st=&z=&ic=&hd=&latest=&copyright=&word=$kname&s=&se=&tab=&width=&height=&face=&istype=&qc=&nc=&fr=&expermode=&force=&cg=head&pn=0&rn=120&gsm=168&1601953239748=" );
		if ($strjosn) {
			$jsonarr = json_decode ( $strjosn, true );
			foreach ( $jsonarr ['data'] as $avataritem ) {
				if ($avataritem ['middleURL']) {
					// $this->setAvatar("https://ss1.bdstatic.com/70cFvXSh_Q1YnxGkpoWK1HF6hhy/it/u=3822091633,4134064486&fm=26&gp=0.jpg",3);
					array_push ( $avatarlist, $avataritem ['middleURL'] );
				}
			}
		}
		$strjosn1 = file_get_contents ( "https://image.baidu.com/search/acjson?tn=resultjson_com&logid=10695385866081272703&ipn=rj&ct=201326592&is=&fp=result&queryWord=$kname&cl=&lm=&ie=utf-8&oe=utf-8&adpicid=&st=&z=&ic=&hd=&latest=&copyright=&word=$kname&s=&se=&tab=&width=&height=&face=&istype=&qc=&nc=&fr=&expermode=&force=&cg=head&pn=60&rn=120&gsm=168&1601953239748=" );
		if ($strjosn1) {
			$jsonarr = json_decode ( $strjosn1, true );
			foreach ( $jsonarr ['data'] as $avataritem ) {
				if ($avataritem ['middleURL']) {
					// $this->setAvatar("https://ss1.bdstatic.com/70cFvXSh_Q1YnxGkpoWK1HF6hhy/it/u=3822091633,4134064486&fm=26&gp=0.jpg",3);
					array_push ( $avatarlist, $avataritem ['middleURL'] );
				}
			}
		}
		return $avatarlist;
	}
	/**
	
	* 上传头像
	
	* @date: 2020年10月29日 上午11:33:06
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
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
}

?>