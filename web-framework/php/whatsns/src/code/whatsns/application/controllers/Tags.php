<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Tags extends CI_Controller {
	function __construct() {
		$this->whitelist = "";
		parent::__construct ();
		$this->load->model ( "tag_model" );
	}
	function index() {
		$navtitle = '标签列表';
		$metakeywords = $navtitle;
		$metadescription = '标签列表';
		
		include template ( 'tag' );
	}
	
	/**
	 *
	 * 标签详情--标签动态
	 *
	 * @date: 2018年11月7日 下午2:11:41
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function view() {
		$tagalias =addslashes(htmlspecialchars ( $this->uri->segments [2] ));
		
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
		$page = max ( 1, intval ( $this->uri->segments [3] ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'tag_item', " tagid=" . $tag ['id'], $this->db->dbprefix ) )->row_array () );
		;
		
		// 获取tag动态列表
		$tagdoinglist = $this->tag_model->getlistbytagid ( $tag ['id'], $startindex, $pagesize );
		
		if ($tagdoinglist) {
			// 获取相关标签
			$relativetags = $this->tag_model->gettaglistbycid ( $tagdoinglist [0] ['cid'] );
		}
		$this->setting ['seo_index_description'] && $_seo_description = str_replace ( "{wzmc}", $this->setting ['site_name'], $this->setting ['seo_index_description'] );
		$this->setting ['seo_index_keywords'] && $_seo_keywords = str_replace ( "{wzmc}", $this->setting ['site_name'], $this->setting ['seo_index_keywords'] );
		
		$departstr = page ( $rownum, $pagesize, $page, "tags/view/$tagalias" );
		$navtitle = $tag ['title'];

		$seo_description = $tag ['description']? $tag ['description']:$navtitle;
		$seo_keywords = $tag ['keywords']? $tag ['keywords']:$tag ['tagname'];
		
		//定义熊掌号推送的url数组
		$tuiurls=array();
		$_url=url("tags/view/$tagalias"); //此标签的url
		array_push($tuiurls, $_url);
		
		//推送给熊掌号
		xiongzhangtuisong($tuiurls);
		
		include template ( 'tagview' );
	}
	/**
	 *
	 * 问答标签
	 *
	 * @date: 2018年11月7日 下午2:12:35
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function question() {
		$tagalias = addslashes(htmlspecialchars ( $this->uri->segments [3] ));
		
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
		$page = max ( 1, intval ( $this->uri->segments [4] ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'tag_item', " tagid=" . $tag ['id'] . " and itemtype='question'", $this->db->dbprefix ) )->row_array () );
		;
		
		// 获取tag动态列表
		$tagdoinglist = $this->tag_model->getlistbytagid ( $tag ['id'], $startindex, $pagesize, 'question' );
		if ($tagdoinglist) {
			// 获取相关标签
			$relativetags = $this->tag_model->gettaglistbycid ( $tagdoinglist [0] ['cid'] );
		}
		
		$departstr = page ( $rownum, $pagesize, $page, "tags/question/$tagalias" );
		$navtitle =  $tag ['tagname'].'相关问题列表-'.$tag ['title'];
		$seo_description = $tag ['description']? $tag ['description']:$navtitle;
		$seo_keywords = $tag ['keywords']? $tag ['keywords']:$tag ['tagname'];
		
		//定义熊掌号推送的url数组
		$tuiurls=array();
		$_url=url("tags/question/$tagalias"); //此标签的url
		array_push($tuiurls, $_url);
		include template ( 'tagview' );
	}
	/**
	 *
	 * 文章标签
	 *
	 * @date: 2018年11月7日 下午2:18:59
	 *
	 * @author : 61703
	 *        
	 * @param
	 *        	: variable
	 *        	
	 * @return :
	 *
	 */
	function article() {
		$tagalias =addslashes( htmlspecialchars ( $this->uri->segments [3] ));
		
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
		$page = max ( 1, intval ( $this->uri->segments [4] ) );
		$pagesize = $this->setting ['list_default'];
		$startindex = ($page - 1) * $pagesize;
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'tag_item', " tagid=" . $tag ['id'] . " and itemtype='article' ", $this->db->dbprefix ) )->row_array () );
		;
		
		// 获取tag动态列表
		$tagdoinglist = $this->tag_model->getlistbytagid ( $tag ['id'], $startindex, $pagesize, 'article' );
		
		if ($tagdoinglist) {
			// 获取相关标签
			$relativetags = $this->tag_model->gettaglistbycid ( $tagdoinglist [0] ['cid'] );
		}
		
		$departstr = page ( $rownum, $pagesize, $page, "tags/article/$tagalias" );
		$navtitle = $tag ['tagname'].'相关文章列表-'.$tag ['title'];
		$seo_description = $tag ['description']? $tag ['description']:$navtitle;
		$seo_keywords = $tag ['keywords']? $tag ['keywords']:$tag ['tagname'];
		
		//定义熊掌号推送的url数组
		$tuiurls=array();
		$_url=url("tags/article/$tagalias"); //此标签的url
		array_push($tuiurls, $_url);
		include template ( 'tagview' );
	}
	function all(){
		$navtitle = '所有标签';
        //查找所有标签
		$page = max ( 1, intval ( $this->uri->segments [3] ) );
		$pagesize = 20;
		$startindex = ($page - 1) * $pagesize;
		$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'tag', " 1=1 ", $this->db->dbprefix ) )->row_array () );
		// 获取tag动态列表
		$taglist = $this->tag_model->getalltaglist( $startindex, $pagesize );
		
		$departstr = page ( $rownum, $pagesize, $page, "tags/all" );
		
		include template ( 'tagall' );
	}
	/**
	
	* ajax获取标签
	
	* @date: 2018年11月7日 下午7:45:18
	
	* @author: 61703
	
	* @param: variable
	
	* @return:
	
	*/
	function ajaxsearch(){
		
		$tagname=addslashes( htmlspecialchars ( trim($this->input->post('tagname'))));
		if(empty($tagname)){
			$message['code']=300;
			$message['taglist']=null;
			$message['tagname']=$tagname;
			
			echo json_encode($message);
			exit();
		}

		// 获取tag动态列表
		$taglist = $this->tag_model->gettalistbytagname($tagname, 0, 5 );
		if(!$taglist){
			$tagname=$this->getPinyin($tagname);
			$taglist = $this->tag_model->gettalistbytagname($tagname, 0, 5 );
		}
		$message['code']=200;
		$message['taglist']=$taglist;
		$message['tagname']=$tagname;
	
		echo json_encode($message);
		exit();
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