<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Attach extends CI_Controller {
	var $whitelist;
	function __construct() {
		$this->whitelist = "upimg,markdownimg,uploadvedio";
		parent::__construct ();
		$this->load->model ( 'attach_model' );

	}

	
	function checkattackfile($reqarr, $reqtype = 'post') {
		$filtertable = array ('get' => 'sleep\s*?\(.*\)|\'|(and|or)\\b.+?(>|<|=|in|like)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)', 'post' => 'sleep\s*?\(.*\)|\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)', 'cookie' => 'sleep\s*?\(.*\)|\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)' );

		if (is_array ( $reqarr )) {
			foreach ( $reqarr as $reqkey => $reqvalue ) {

				if (is_array ( $reqvalue )) {

					checkattack ( $reqvalue, $reqtype );
				}

				if (preg_match ( "/" . $filtertable [$reqtype] . "/is", $reqvalue ) == 1 && ! in_array ( $reqkey, array ('content' ) )) {
					return false;
				}
				return true;

			}
		}

	}
	/**
	
	* markdown上传图片
	
	* @date: 2019年4月28日 上午10:45:46
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function markdownimg(){
		if ($this->user ['uid'] <= 0) {
			
			echo 'error|禁止匿名操作';
			exit ();
			
		}
	
		error_reporting(E_ALL & ~E_NOTICE);
		
		$path     ="data/attach/" .  gmdate ( 'ymd', time() );
		$url      =SITE_URL.$path.DIRECTORY_SEPARATOR;
		$savePath = realpath(FCPATH.$path .  gmdate ( 'ymd', time() )) . DIRECTORY_SEPARATOR;
		$saveURL  = $url ;
		
		$formats  = array(
				'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp')
		);
		
		$name = 'editormd-image-file';
	
		if (isset($_FILES[$name]))
		{
			//上传配置
			$config = array ("uploadPath" => "data/attach/", //保存路径
					"fileType" => array (".png", ".jpg", ".jpeg", ".bmp" , ".gif"), "fileSize" => 3 );
			
			if ($_FILES[$name] != null) {
				$iswapeditor = true;
				$file = $_FILES[$name];
			} else {
				$jsonarr['success']=0;
				$jsonarr['message']="上传失败没选择文件";
				$jsonarr['url']="";
				echo json_encode($jsonarr);
				
				exit();
				
			}
			//文件上传状态,当成功时返回SUCCESS，其余值将直接返回对应字符窜并显示在图片预览框，同时可以在前端页面通过回调函数获取对应字符窜
			$state = "SUCCESS";
			//格式验证
			$current_type = strtolower(strrchr($file["name"], '.'));
			if (!in_array($current_type, $config['fileType'])) {
				$state = $current_type;
				
				$jsonarr['success']=0;
				$jsonarr['message']="图片类型不对";
				$jsonarr['url']="";
				echo json_encode($jsonarr);
				
				exit();
			}
			
			
			//大小验证
			$file_size = 1024*1024*$config ['fileSize'];
			if ($file ["size"] > $file_size) {
				$state = "b";
				
				$jsonarr['success']=0;
				$jsonarr['message']='上传图片最大'.$config ['fileSize']."M";
				$jsonarr['url']="";
				echo json_encode($jsonarr);
				
				exit();
			}
			
			if ($this->checkattackfile ( $file ["name"] )) {
				echo 'error|dont sql inject';
				
				$jsonarr['success']=0;
				$jsonarr['message']='dont sql inject';
				$jsonarr['url']="";
				echo json_encode($jsonarr);
				
				exit();
			}
			if (preg_match ( "/[\',:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/", $file ["name"] )) { //不允许特殊字符
				
				$jsonarr['success']=0;
				$jsonarr['message']='文件名不合法';
				$jsonarr['url']="";
				echo json_encode($jsonarr);
				
				exit();
			}
			//保存图片
			if ($state == "SUCCESS") {
				$targetfile = $config ['uploadPath'] . gmdate ( 'ymd', time() ) . '/' . random ( 8 ) . strrchr ( $file ["name"], '.' );
				$result = $this->attach_model->movetmpfile ( $file, $targetfile );
				if (! $result) {
					
					$jsonarr['success']=0;
					$jsonarr['message']='上传失败';
					$jsonarr['url']="";
					echo json_encode($jsonarr);
					
					exit();
				} else {
					$this->attach_model->add ( $file ["name"], $current_type, $file ["size"], $targetfile );
				}
			} else {
			
				$jsonarr['success']=0;
				$jsonarr['message']='图片大小或者类型不对';
				$jsonarr['url']="";
				echo json_encode($jsonarr);
				
				exit();
			}
			$source_info = getimagesize ( FCPATH . '/' . $targetfile ); //图片信息
			$source_w = $source_info [0]; //图片宽度
			if($source_w>1000){
				$this->imageyasuo ( FCPATH . '/' . $targetfile, FCPATH . '/' . $targetfile ,50);
			}
			
			
			if($this->setting['waterset']){
				$this->watermark ( FCPATH . '/' . $targetfile, FCPATH . '/' . $targetfile );
			}
			
			try {
				require_once STATICPATH . 'js/neweditor/php/Config.php';
				if (Config::OPEN_OSS) {
					
					require_once STATICPATH . 'js/neweditor/php/up.php';
					if (Common::getOpenoss () == '1') {
						$diross = $targetfile;
						$tmpfile = $targetfile;
						
						if (substr ( $targetfile, 0, 1 ) == '/') {
							$diross = substr ( $targetfile, 1 );
						}
						$filepath = uploadFile ( Common::getOssClient (), Common::getBucketName (), $diross, FCPATH . $targetfile );
						if ($filepath != 'error') {
						
							$jsonarr['success']=1;
							$jsonarr['message']='上传成功';
							$jsonarr['url']=$filepath;
							echo json_encode($jsonarr);
							
							exit();
							
						}
					}
				} else {
				
					$jsonarr['success']=1;
					$jsonarr['message']='上传成功';
					$jsonarr['url']=SITE_URL . $targetfile;
					echo json_encode($jsonarr);
					
					exit();
				}
			} catch ( Exception $e ) {
				$jsonarr['success']=0;
				$jsonarr['message']='上传异常';
				$jsonarr['url']="";
				echo json_encode($jsonarr);
				
				exit();
			}
			
		}
	}
	/**
	 *
	 * 上传视频
	 *
	 * @date: 2020年2月13日 下午6:22:30
	 *
	 * @author : 61703
	 *
	 * @param
	 *        	: variable
	 *
	 * @return :
	 *
	 */
	function uploadvedio() {
		if(!$this->user['uid']){
			$message['code']=201;
			$message['msg']="请先登录";
			echo json_encode($message);
			exit();
		}
		if (! $_POST) {
			$message['code']=201;
			$message['msg']="请上传mp4文件";
			echo json_encode($message);
			exit();
		}
	
	
		if ($_FILES ["file"]) {
			$extname = strtolower ( extname ( $_FILES ["file"] ["name"] ) );
			if ($extname == 'mp4'||$extname == 'mov') {
				if ($_FILES['file']['error'] > 0) {
					$message['code']=201;
					$message['msg']="请上传mp4/mov文件";
					echo json_encode($message);
					exit();
				}
				
				$path =  "data/upload";
				mkdir($path);
				// 如果是mp4允许上传
				$fileName = date("Ymd")."_".md5 ( uniqid ( microtime ( true ), true ) ) . '.' . $extname;
				$basefile=$path. '/'.$fileName;
				$destName = FCPATH .$path . DIRECTORY_SEPARATOR . $fileName;
				if (! move_uploaded_file ( $_FILES["file"]['tmp_name'], $destName )) {
					$message['code']=201;
					$message['msg']="上传视频失败";
					echo json_encode($message);
					exit();
				}
				$url= SITE_URL."data/upload/".$fileName;
			
					try {
						require_once STATICPATH . 'js/neweditor/php/Config.php';
						if (Config::OPEN_OSS) {
							
							require_once STATICPATH . 'js/neweditor/php/up.php';
							if (Common::getOpenoss () == '1') {
								
								$filepath = uploadFile ( Common::getOssClient (), Common::getBucketName (), $basefile, $destName );
								if ($filepath != 'error') {
								
									
									unlink($destName);
									$message['code']=200;
									$message['msg']="上传视频成功";
									$message['fileurl']=$filepath;
									echo json_encode($message);
									exit();
									
								}else{
									$message['code']=201;
									$message['msg']="上传视频出错";
									$message['fileurl']=$filepath;
									echo json_encode($message);
									exit();
								}
							}
						}
						
					} catch ( Exception $e ) {
						$message['code']=201;
						$message['msg']="上传视频出错";
						$message['fileurl']=$filepath;
						echo json_encode($message);
						exit();
					}
					
			
			
				$message['code']=200;
				$message['msg']="上传视频成功";
				$message['fileurl']=$url;
				echo json_encode($message);
				exit();
				
			} else {
				$message['code']=201;
				$message['msg']=$extname."格式不支持";
			
				echo json_encode($message);
				exit();
			}
		} else {
			$message['code']=201;
			$message['msg']="文件不存在";
		
			echo json_encode($message);
			exit();
		}
	}
	
	/**
	
	* wangeditor上传图片
	
	* @date: 2019年4月28日 上午10:45:12
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function upimg() {
		if ($this->user ['uid'] <= 0) {

			echo 'error|禁止匿名操作';
			exit ();

		}
		//上传配置
		$config = array ("uploadPath" => "data/attach/", //保存路径
				"fileType" => array (".png", ".jpg", ".jpeg", ".bmp" , ".gif"), "fileSize" => 3 );

		if ($_FILES ['wangEditorMobileFile'] != null) {
			$iswapeditor = true;
			$file = $_FILES ['wangEditorMobileFile'];
		} else {
			echo 'error|没上传文件';
			exit ();
		}
		//文件上传状态,当成功时返回SUCCESS，其余值将直接返回对应字符窜并显示在图片预览框，同时可以在前端页面通过回调函数获取对应字符窜
		$state = "SUCCESS";
		//格式验证
		$current_type = strtolower(strrchr($file["name"], '.'));
        if (!in_array($current_type, $config['fileType'])) {
            $state = $current_type;
             echo 'error|图片类型不对'.$_FILES['wangEditorMobileFile'];
               exit();
        }


		//大小验证
		$file_size = 1024*1024*$config ['fileSize'];
		if ($file ["size"] > $file_size) {
			$state = "b";
			echo 'error|上传图片最大'.$config ['fileSize']."M";
			exit ();
		}

		if ($this->checkattackfile ( $file ["name"] )) {
			echo 'error|dont sql inject';
			exit ();
		}
		if (preg_match ( "/[\',:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/", $file ["name"] )) { //不允许特殊字符
			echo 'error|文件名不合法';
			exit ();
		}
		//保存图片
		if ($state == "SUCCESS") {
			$targetfile = $config ['uploadPath'] . gmdate ( 'ymd', time() ) . '/' . random ( 8 ) . strrchr ( $file ["name"], '.' );
			$result = $this->attach_model->movetmpfile ( $file, $targetfile );
			if (! $result) {
				echo 'error|上传失败';
				exit ();
			} else {
				$this->attach_model->add ( $file ["name"], $current_type, $file ["size"], $targetfile );
			}
		} else {
			echo 'error|图片大小或者类型不对';
			exit ();
		}
		$source_info = getimagesize ( FCPATH . '/' . $targetfile ); //图片信息
		$source_w = $source_info [0]; //图片宽度
		if($source_w>1000){
			$this->imageyasuo ( FCPATH . '/' . $targetfile, FCPATH . '/' . $targetfile ,50);
		}


		if($this->setting['waterset']){
			$this->watermark ( FCPATH . '/' . $targetfile, FCPATH . '/' . $targetfile );
		}
		
		try {
			require_once STATICPATH . 'js/neweditor/php/Config.php';
			if (Config::OPEN_OSS) {

				require_once STATICPATH . 'js/neweditor/php/up.php';
				if (Common::getOpenoss () == '1') {
					$diross = $targetfile;
					$tmpfile = $targetfile;

					if (substr ( $targetfile, 0, 1 ) == '/') {
						$diross = substr ( $targetfile, 1 );
					}
					$filepath = uploadFile ( Common::getOssClient (), Common::getBucketName (), $diross, FCPATH . $targetfile );
					if ($filepath != 'error') {
						echo $filepath;
						exit ();

					}
				}
			} else {
				echo SITE_URL . $targetfile;
				exit ();
			}
		} catch ( Exception $e ) {
			print $e->getMessage ();
		}

	}
	public function imageyasuo($source, $target,$w_quality=80){
		$this->w_img = FCPATH . 'static/js/neweditor/marker.png'; //水印图片
		$this->w_pos = 9;
		$this->w_minwidth = 400; //最少宽度
		$this->w_minheight = 200; //最少高度
		$this->w_quality = $w_quality; //图像质量
		$this->w_pct = 85; //透明度
		$w_pos = $w_pos ? $w_pos : $this->w_pos;
		$w_img = $w_img ? $w_img : $this->w_img;
		if (! $this->check ( $source ))
			return false;
			if (! $target)
				$target = $source;
				$source_info = getimagesize ( $source ); //图片信息
				$source_w = $source_info [0]; //图片宽度
				$source_h = $source_info [1]; //图片高度
				if ($source_w < $this->w_minwidth || $source_h < $this->w_minheight)
					return false;
					switch ($source_info [2]) { //图片类型
						case 1 : //GIF格式
							$source_img = imagecreatefromgif ( $source );
							break;
						case 2 : //JPG格式
				
						
							$source_img = imagecreatefromjpeg ( $source );
							break;
						case 3 : //PNG格式
							$source_img = imagecreatefrompng ( $source );
							//imagealphablending($source_img,false); //关闭混色模式
							imagesavealpha ( $source_img, true ); //设置标记以在保存 PNG 图像时保存完整的 alpha 通道信息（与单一透明色相反）
							break;
						default :
							return false;
					}
					
					switch ($source_info [2]) {
						case 1 :
							imagegif ( $source_img, $target );
							//GIF 格式将图像输出到浏览器或文件(欲输出的图像资源, 指定输出图像的文件名)
							break;
						case 2 :
					
							
							imagejpeg ( $source_img, $target, $this->w_quality );
							break;
						case 3 :
						
							imagepng ( $source_img, $target );
							break;
						default :
							return;
					}
				
				
					unset ( $source_info );
					imagedestroy ( $source_img );
					return true;
	}
	public function watermark($source, $target = '', $w_pos = '', $w_img = '', $w_text = 'www.ask2.cn', $w_font = 10, $w_color = '#CC0000') {
		$this->w_img = FCPATH . 'static/js/neweditor/marker.png'; //水印图片
		$this->w_pos = 9;
		$this->w_minwidth = 400; //最少宽度
		$this->w_minheight = 200; //最少高度
		$this->w_quality = 80; //图像质量
		$this->w_pct = 85; //透明度
		$w_pos = $w_pos ? $w_pos : $this->w_pos;
		$w_img = $w_img ? $w_img : $this->w_img;
		if (! $this->check ( $source ))
			return false;
		if (! $target)
			$target = $source;
		$source_info = getimagesize ( $source ); //图片信息
		$source_w = $source_info [0]; //图片宽度
		$source_h = $source_info [1]; //图片高度
		if ($source_w < $this->w_minwidth || $source_h < $this->w_minheight)
			return false;
		switch ($source_info [2]) { //图片类型
			case 1 : //GIF格式
				$source_img = imagecreatefromgif ( $source );
				break;
			case 2 : //JPG格式
				$source_img = imagecreatefromjpeg ( $source );
				break;
			case 3 : //PNG格式
				$source_img = imagecreatefrompng ( $source );
				//imagealphablending($source_img,false); //关闭混色模式
				imagesavealpha ( $source_img, true ); //设置标记以在保存 PNG 图像时保存完整的 alpha 通道信息（与单一透明色相反）
				break;
			default :
				return false;
		}
		if (! empty ( $w_img ) && file_exists ( $w_img )) { //水印图片有效
			$ifwaterimage = 1; //标记
			$water_info = getimagesize ( $w_img );
			$width = $water_info [0];
			$height = $water_info [1];
			switch ($water_info [2]) {
				case 1 :
					$water_img = imagecreatefromgif ( $w_img );
					break;
				case 2 :
					$water_img = imagecreatefromjpeg ( $w_img );
					break;
				case 3 :
					$water_img = imagecreatefrompng ( $w_img );
					imagealphablending ( $water_img, false );
					imagesavealpha ( $water_img, true );
					break;
				default :
					return;
			}
		} else {
			$ifwaterimage = 0;
			$temp = imagettfbbox ( ceil ( $w_font * 2.5 ), 0, '../wt.ttf', $w_text ); //imagettfbbox返回一个含有 8 个单元的数组表示了文本外框的四个角
			$width = $temp [2] - $temp [6];
			$height = $temp [3] - $temp [7];
			unset ( $temp );
		}
		switch ($w_pos) {
			case 1 :
				$wx = 5;
				$wy = 5;
				break;
			case 2 :
				$wx = ($source_w - $width) / 2;
				$wy = 0;
				break;
			case 3 :
				$wx = $source_w - $width;
				$wy = 0;
				break;
			case 4 :
				$wx = 0;
				$wy = ($source_h - $height) / 2;
				break;
			case 5 :
				$wx = ($source_w - $width) / 2;
				$wy = ($source_h - $height) / 2;
				break;
			case 6 :
				$wx = $source_w - $width;
				$wy = ($source_h - $height) / 2;
				break;
			case 7 :
				$wx = 0;
				$wy = $source_h - $height;
				break;
			case 8 :
				$wx = ($source_w - $width) / 2;
				$wy = $source_h - $height;
				break;
			case 9 :
				$wx = $source_w - ($width + 5);
				$wy = $source_h - ($height + 5);
				break;
			case 10 :
				$wx = rand ( 0, ($source_w - $width) );
				$wy = rand ( 0, ($source_h - $height) );
				break;
			default :
				$wx = rand ( 0, ($source_w - $width) );
				$wy = rand ( 0, ($source_h - $height) );
				break;
		}
		if ($ifwaterimage) {
			if ($water_info [2] == 3) {
				imagecopy ( $source_img, $water_img, $wx, $wy, 0, 0, $width, $height );
			} else {
				imagecopymerge ( $source_img, $water_img, $wx, $wy, 0, 0, $width, $height, $this->w_pct );
			}
		} else {
			if (! empty ( $w_color ) && (strlen ( $w_color ) == 7)) {
				$r = hexdec ( substr ( $w_color, 1, 2 ) );
				$g = hexdec ( substr ( $w_color, 3, 2 ) );
				$b = hexdec ( substr ( $w_color, 5 ) );
			} else {
				return;
			}
			imagestring ( $source_img, $w_font, $wx, $wy, $w_text, imagecolorallocate ( $source_img, $r, $g, $b ) );
		}
		switch ($source_info [2]) {
			case 1 :
				imagegif ( $source_img, $target );
				//GIF 格式将图像输出到浏览器或文件(欲输出的图像资源, 指定输出图像的文件名)
				break;
			case 2 :
				imagejpeg ( $source_img, $target, $this->w_quality );
				break;
			case 3 :
				imagepng ( $source_img, $target );
				break;
			default :
				return;
		}
		if (isset ( $water_info )) {
			unset ( $water_info );
		}
		if (isset ( $water_img )) {
			imagedestroy ( $water_img );
		}
		unset ( $source_info );
		imagedestroy ( $source_img );
		return true;
	}
	public function check($image) {
		return extension_loaded ( 'gd' ) && preg_match ( "/\.(jpg|jpeg|gif|png)/i", $image, $m ) && file_exists ( $image ) && function_exists ( 'imagecreatefrom' . ($m [1] == 'jpg' ? 'jpeg' : $m [1]) );
	}
}

?>