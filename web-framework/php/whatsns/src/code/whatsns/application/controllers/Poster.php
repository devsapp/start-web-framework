<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Poster extends CI_Controller {
	var $whitelist;
	function __construct() {
		$this->whitelist = "ajaxmake";
		parent::__construct ();
		$this->load->model ( 'topic_model' );
	}
	/**
	 *
	 * 生成海报
	 *
	 * @date: 2020年3月18日 上午10:02:31
	 *
	 * @author : 61703
	 *
	 * @param
	 *        	: variable
	 *
	 * @return :
	 *
	 */
	function ajaxmake($type,$id,$style=0) {
		$type = addslashes ( clearhtml ( strip_tags ( $type) ) );
		$typeid = intval ( $id );
		$style = intval ($style);
		switch ($type) {
			case 'article' :
				$article = $this->db->get_where('topic',array('id'=>$typeid))->row_array();
				//echo strip_tags($article ['describtion']);exit();
				$article ['describtion'] = preg_replace('~<([a-z]+?)\s+?.*?>~i','<$1>',$article ['describtion']);  
			
				$article ['describtion']=htmlspecialchars_decode(htmlspecialchars_decode($article ['describtion']));
				$article ['timespan']=$article ['viewtime'];
				switch ($style){
					case 1:
						$this->copypost( $article ['image'], clearhtml ( $article ['title'], 120 ), clearhtml ( $article ['describtion'], 60 ), url ( 'topic/getone/' . $typeid ), date ( 'Y/n/d', $article ['timespan'] ) );
						
						break;
					default:
						$cid = $article['articleclassid'];
						$category = $this->category [$cid]; // 得到分类信息
						$this->wenzhanghaibao2 ( $article ['image'], clearhtml ( $article ['title'], 120 ), clearhtml ( $article ['describtion'], 120 ), url ( 'topic/getone/' . $typeid ), date ( 'Y/n/d', $article ['timespan'] ) ,$article ['author'],$category['name'], date ( 'd', $article ['timespan'] ), date ( 'Y/m', $article ['timespan'] ));
						
						break;
				}
				
				break;
			case 'invate':
				$this->ajaxinvate();
				break;
		}
	}
	/**
	
	* 邀请注册
	
	* @date: 2020年3月19日 上午10:14:28
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function ajaxinvate(){
		if(!$this->user['uid']){
			exit("请先登录");
		}
		$bgimg="https://upload-images.jianshu.io/upload_images/4098897-815c9e19f766bae2.png";
		$im = imagecreatetruecolor ( 440, 700 ) or die ( "不能初始化新的 GD 图像流" ); // 创建一张空白图像
		$_bg_color = imagecolorallocate ( $im, 255, 255, 255 ); // 创建颜色，返回颜色标识符
		imagefill ( $im, 0, 0, $_bg_color ); // 初始化图像背景为$_bg_color
		$bg = imagecreatefromstring ( file_get_contents ( $bgimg ) ); // 获取网络图片
		$src_info = getimagesize ( $bgimg ); // 得到图片大小
		$bgsf = imagecreatetruecolor ( 440, 700 ); // 创建一个画布
		imagecopyresampled ( $bgsf, $bg, 0, 0, 0, 0, 440, 700, $src_info [0], $src_info [1] ); // 缩放图像
		
		imagecopymerge ( $im, $bgsf, 0, 0, 0, 0, 440, 700, 100 ); // 复制合成
		
		
		//生成logo
		$logo=$this->setting['site_logo'];
		
		$logoimg = imagecreatefromstring ( file_get_contents ( $logo ) ); // 获取网络图片
		$logo_info = getimagesize ( $logo ); // 得到图片大小
		//imagecopymerge ( $im, $logoimg, 40, 40, 0, 0, $logo_info [0], $logo_info [1], 100 ); // 复制合成
		imagecopy($im, $logoimg,  20, 20, 0, 0, $logo_info [0], $logo_info [1]);
		
		//生成头像
		$avatar=$this->user['avatar'];
		$avatarwidth=60;//头像宽度
		$avatarheight=60;//头像高度
		$avatar_info = getimagesize ( $avatar ); // 得到图片大小
		$bgsf1 = imagecreatetruecolor ( $avatarwidth, $avatarheight ); // 创建一个画布
		$avatar1 = imagecreatefromstring ( file_get_contents ( $avatar ) ); // 获取网络图片
		imagecopyresampled ( $bgsf1, $avatar1, 0, 0, 0, 0, $avatarwidth, $avatarheight, $avatar_info [0], $avatar_info [1] ); // 缩放图像
		//imagecopy($im, $bgsf1,  180, 180, 0, 0, $avatarwidth,$avatarheight);
		//imagecopymerge ( $im, $bgsf1,180, 180, 0, 0, $avatarwidth, $avatarheight, 100 );
		$im=$this->radius_img_bg($im, 185, 180, $bgsf1, $avatarwidth,$avatarheight, 0);
		$_text_color = imagecolorallocate ( $im, 0, 0, 0 ); // 文字颜色 黑色
		
		$fontpath = FCPATH . 'static/js/neweditor/wt.ttf'; // 字体文件路径
		//生成作者名字
		$author=$this->user['username']."邀请您一起加入";
		$im = $this->textcl ( $im, $_text_color, $author, 12, $fontpath, 270, '',1,0 );
		
		$url=url("user/register/".$this->user['invatecode']);
		$ewm = SITE_URL . "lib/getqrcode.php?data=$url&&size=2";
		$_text_color2 = imagecolorallocate ( $im, 99, 99, 99 ); // 文字颜色 灰色
		$sitename = clearhtml($this->setting['site_name'],20);
		$sitedesc=clearhtml($this->setting ['seo_index_description'] ,150);
		$im = $this->textcl ( $im, $_text_color, $sitename, 20, $fontpath, 400, '',1,0 );
		
		$im = $this->textcl ( $im, $_text_color2, $sitedesc, 13, $fontpath, 460, '',1,0 );
		
		$qecode = imagecreatefromstring ( file_get_contents ( $ewm ) ); // 获取网络图片
		$ewm_info = getimagesize ( $ewm ); // 得到图片大小
		imagecopymerge ( $im, $qecode, 175, 560, 0, 0, $ewm_info [0], $ewm_info [1], 100 ); // 复制合成
		$im = $this->textcl ( $im, $_text_color2, "【 扫码加入 】", 13, $fontpath, 670, '',1,0 );
		
	
		header ( "Content-type: image/png" ); // 以图像类型输出
		imagepng ( $im ); // 展示图像
		imagedestroy ( $im ); // 销毁图像，释放资源
	}
	/**
	 *
	 * 文章海报2
	 *
	 * @date: 2020年3月18日 下午3:51:23
	 *
	 * @author : 61703
	 *
	 * @param
	 *        	: variable
	 *
	 * @return :
	 *
	 */
	function wenzhanghaibao2($imgthumb, $title, $articledescription, $url, $time,$author,$categoryname,$day,$date) {
		$bigImgPath = $imgthumb;
		$str = $title;//标题
		$description = $articledescription;
		$ewm = SITE_URL . "lib/getqrcode.php?data=$url&&size=2";
		$datestr = "发布于 " . $time;
		$sitename = clearhtml($this->setting['site_name'],20);
		$sitedesc=clearhtml($this->setting ['seo_index_description'] ,50);
		$fontSize = 28;
		$desfontSize = 22;
		$datefontsize = 22;
		$im = imagecreatetruecolor ( 750, 1334 ) or die ( "不能初始化新的 GD 图像流" ); // 创建一张空白图像
		$_bg_color = imagecolorallocate ( $im, 255, 255, 255 ); // 创建颜色，返回颜色标识符
		imagefill ( $im, 0, 0, $_bg_color ); // 初始化图像背景为$_bg_color
		$bg = imagecreatefromstring ( file_get_contents ( $bigImgPath ) ); // 获取网络图片
		$src_info = getimagesize ( $bigImgPath ); // 得到图片大小
		$bgsf = imagecreatetruecolor ( 750, 480 ); // 创建一个画布
		imagecopyresampled ( $bgsf, $bg, 0, 0, 0, 0, 750, 480, $src_info [0], $src_info [1] ); // 缩放图像
		imagecopymerge ( $im, $bgsf, 0, 0, 0, 0, 750, 480, 100 ); // 复制合成
		
		$_text_colorbai = imagecolorallocate ( $im, 255, 255, 255 ); // 文字颜色 白色
		$_text_color = imagecolorallocate ( $im, 0, 0, 0 ); // 文字颜色 黑色
		$_text_color2 = imagecolorallocate ( $im, 99, 99, 99 ); // 文字颜色 灰色
		$fontpath = FCPATH . 'static/js/neweditor/wt.ttf'; // 字体文件路径
		imagettftext ( $im, 50, 0, 65, 400, $_text_colorbai, $fontpath, $day );
		imagettftext ( $im, 50, 0, 66, 400, $_text_colorbai, $fontpath, $day);
		imagettftext ( $im, 15, 0, 40, 415, $_text_colorbai, $fontpath, '——————' );
		imagettftext ( $im, 15, 0, 40, 416, $_text_colorbai, $fontpath, '——————' );
		imagettftext ( $im, 20, 0, 45, 435, $_text_colorbai, $fontpath, $date );
		imagettftext ( $im, 20, 0, 46, 435, $_text_colorbai, $fontpath,$date );
		$im = $this->textcl ( $im, $_text_color, $str, $fontSize, $fontpath, 570, '' ); // 处理多行文字
		$im = $this->textcl ( $im, $_text_color2, $description, $desfontSize, $fontpath, 690, '      ' );
		
		imagettftext ( $im, $datefontsize, 0, 40, 990, $_text_color2, $fontpath, "作者：$author 发布在 [ $categoryname ]" ); // 文字转图片
		
		imagettftext ( $im, 12, 0, 0, 1120, $_text_color, $fontpath, '---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------' );
		
		$qecode = imagecreatefromstring ( file_get_contents ( $ewm ) ); // 获取网络图片
		$ewm_info = getimagesize ( $ewm ); // 得到图片大小
		imagecopymerge ( $im, $qecode, 600, 1210, 0, 0, $ewm_info [0], $ewm_info [1], 100 ); // 复制合成
		$dateimg = imagecreatetruecolor ( 700, 400 ); // 创建一个画布
		imagefill ( $dateimg, 0, 0, $_bg_color ); // 填充颜色
		imagettftext ( $dateimg, 28, 0, 40, 50, $_text_color, $fontpath, $sitename ); // 文字转图片
		$this->textcl ( $dateimg, $_text_color2, $sitedesc, 15, $fontpath, 100, '',0 );
		
		//imagettftext ( $dateimg, 15, 0, 40,100, $_text_color2, $fontpath, $sitedesc );
		imagecopymerge ( $im, $dateimg, 20,1180, 0, 0, 520, 400, 100 ); // 复制合成
		header ( "Content-type: image/png" ); // 以图像类型输出
		imagepng ( $im ); // 展示图像
		imagedestroy ( $im ); // 销毁图像，释放资源
		
	}
	/**
	 *
	 * 海报格式一
	 *
	 * @date: 2020年3月18日 下午3:48:21
	 *
	 * @author : 61703
	 *
	 * @param
	 *        	: variable
	 *
	 * @return :
	 *
	 */
	function copypost($imgthumb, $title, $articledescription, $url, $time) {
		$bigImgPath = $imgthumb;
		$str = $title;
		$description = $articledescription;
		$ewm = SITE_URL . "lib/getqrcode.php?data=$url&&size=3.5";
		$datestr = "发布于 " . $time;
		$domain = $_SERVER ['HTTP_HOST'];
		$fontSize = 18;
		$desfontSize = 14;
		$datefontsize = 14;
		$im = imagecreatetruecolor ( 440, 700 ) or die ( "不能初始化新的 GD 图像流" ); // 创建一张空白图像
		$_bg_color = imagecolorallocate ( $im, 255, 255, 255 ); // 创建颜色，返回颜色标识符
		imagefill ( $im, 0, 0, $_bg_color ); // 初始化图像背景为$_bg_color
		$bg = imagecreatefromstring ( file_get_contents ( $bigImgPath ) ); // 获取网络图片
		$src_info = getimagesize ( $bigImgPath ); // 得到图片大小
		$bgsf = imagecreatetruecolor ( 440, 300 ); // 创建一个画布
		imagecopyresampled ( $bgsf, $bg, 0, 0, 0, 0, 440, 300, $src_info [0], $src_info [1] ); // 缩放图像
		imagecopymerge ( $im, $bgsf, 0, 0, 0, 0, 440, 300, 100 ); // 复制合成
		$_text_color = imagecolorallocate ( $im, 0, 0, 0 ); // 文字颜色
		$fontpath = FCPATH . 'static/js/neweditor/wt.ttf'; // 字体文件路径
		$im = $this->textcl ( $im, $_text_color, $str, $fontSize, $fontpath, 330, '',1,0 ); // 处理多行文字
		$im = $this->textcl ( $im, $_text_color, $description, $desfontSize, $fontpath, 410, '      ',1,0);
		$qecode = imagecreatefromstring ( file_get_contents ( $ewm ) ); // 获取网络图片
		$ewm_info = getimagesize ( $ewm ); // 得到图片大小
		imagecopymerge ( $im, $qecode, 10, 520, 0, 0, $ewm_info [0], $ewm_info [1], 100 ); // 复制合成
		$dateimg = imagecreatetruecolor ( 200, 200 ); // 创建一个画布
		imagefill ( $dateimg, 0, 0, $_bg_color ); // 填充颜色
		imagettftext ( $dateimg, $datefontsize, 0, 0, 50, $_text_color, $fontpath, $domain ); // 文字转图片
		imagettftext ( $dateimg, $desfontSize, 0, 0, 90, $_text_color, $fontpath, '————————————————————————' );
		imagettftext ( $dateimg, $desfontSize, 0, 0, 120, $_text_color, $fontpath, $datestr );
		imagecopymerge ( $im, $dateimg, 200, 520, 0, 0, 200, 200, 100 ); // 复制合成
		header ( "Content-type: image/png" ); // 以图像类型输出
		imagepng ( $im ); // 展示图像
		imagedestroy ( $im ); // 销毁图像，释放资源
	}
	function textcl($img, $_text_color, $str, $fontSize, $fontpath, $Y, $before,$mk=1,$type=1) {
		for($i = 0; $i < mb_strlen ( $str ); $i ++) {
			$letter [] = mb_substr ( $str, $i, 1, 'utf-8' );
		}
		$maxwidth=700;
		$maxftwidth=750;
		if($mk==0){
			$maxwidth=480;
		}
		if($type==0){
			$maxwidth=400;
			$maxftwidth=440;
		}
		$content = $before;
		foreach ( $letter as $l ) {
			$teststr = $content . " " . $l;
			$fontBox = imagettfbbox ( $fontSize, 0, $fontpath, $teststr );
			if (($fontBox [2] > $maxwidth) && ($content !== "")) {
				$content .= "\n";
			}
			$content .= $l;
		}
		imagettftext ( $img, $fontSize, 0,$mk==0? 40: ceil ( ($maxftwidth - $fontBox [2]) / 2 ), $Y, $_text_color, $fontpath, $content );
		return $img;
	}
	/**
	 * 直接把圆角图片画在背景图片上
	 * @param $bg_img 背景图片
	 * @param $x 背景图片位置
	 * @param $y 背景图片位置
	 * @param $src_img 要画的圆角的图片
	 * @param $width 圆角图片的尺寸
	 * @param $height 圆角图片的尺寸
	 * @param int $radius 圆角尺寸
	 * @return resource
	 */
	public static function radius_img_bg($bg_img, $x, $y, $src_img, $width,$height, $radius = 15) {
		$ob_x = $x;
		$ob_y = $y;
		$max_x  = $ob_x + $width;
		$max_y  = $ob_y + $height;
		$start_y = $y;
		$radius = $radius == 0 ? (min($width, $height) / 2) : $radius;
		$r = $radius; //圆 角半径
		for ($x; $x < $max_x; $x++) {
			for ($y=$start_y; $y < $max_y; $y++) {
				$rgbColor = imagecolorat($src_img, $x-$ob_x, $y-$ob_y);
				if (
						($x >= $ob_x + $radius && $x <= ($max_x - $radius)) ||
						($y >= $ob_y + $radius && $y <= ($max_y - $radius))
						) {
							//不在四角的范围内,直接画
							imagesetpixel($bg_img, $x, $y, $rgbColor);
						} else {
							//在四角的范围内选择画
							//上左
							$y_x = $ob_x + $r; //圆心X坐标
							$y_y = $ob_y + $r; //圆心Y坐标
							if ((pow($x - $y_x, 2) + pow($y - $y_y, 2) <= pow($r,2))) {
								imagesetpixel($bg_img, $x, $y, $rgbColor);
							}
							//上右
							$y_x = $max_x - $r; //圆心X坐标
							$y_y = $ob_y + $r; //圆心Y坐标
							if ((pow($x - $y_x, 2) + pow($y -$y_y, 2) <= pow($r,2))) {
								imagesetpixel($bg_img, $x, $y, $rgbColor);
							}
							//下左
							$y_x = $ob_x + $r; //圆心X坐标
							$y_y = $max_y - $r; //圆心Y坐标
							if (pow($x - $y_x,2) + pow($y - $y_y,2) <= pow($r, 2)) {
								imagesetpixel($bg_img, $x, $y, $rgbColor);
							}
							//下右
							$y_x = $max_x - $r; //圆心X坐标
							$y_y = $max_y - $r; //圆心Y坐标
							if (pow($x - $y_x,2) + pow($y - $y_y,2) <= pow($r, 2)) {
								imagesetpixel($bg_img, $x, $y, $rgbColor);
							}
						}
			}
		}
		return $bg_img;
	}
	
}