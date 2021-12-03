<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | WhatSNS最新版火车头采集插件                                          |
// +----------------------------------------------------------------------+
// | 2018.10.11                               							  |
// +----------------------------------------------------------------------+
// | 1、增加采集评论的功能       										  |
// | 2、增加采集关键词功能      										  |
// | 3、增加采集描述功能										          |
// | https://ask.dobunkan.com            			                      |
// +----------------------------------------------------------------------+
// | Authors: Original Author <jspsql@qq.com>                     		  |
// |          Your Name <jspsql@qq.com>                            		  |
// +----------------------------------------------------------------------+

defined('BASEPATH') or exit('No direct script access allowed');
class Pccaiji_catgory extends CI_Controller {
    var $whitelist;
    function __construct() {
        $this->whitelist = "index,clist";
        parent::__construct();
        $this->load->model('category_model');
        $this->load->model('topic_model');
        $this->load->model('user_model');
    }
    function index() {
        $file = $this->getfolders();
    }
    function getfolders() {
        $file = array();
        $file_dir = "caijiimage";
        $shili = $file_dir;
        if (!file_exists($shili)) {
            return '0';
        } else {
            $i = 0;
            if (is_dir($shili)) { // 检测是否是合法目录
                if ($shi = opendir($shili)) { // 打开目录
                    while ($li = readdir($shi)) { // 读取目录
                        if (strpos($li, 'jpg') > 0 || strpos($li, 'png') > 0) array_push($file, $li);
                    }
                }
            } // 输出目录中的内容
            closedir($shi);
            return $file;
        }
    }
    function removeLinks($str) {
        if (empty($str)) return '';
        $str = preg_replace('/(http)(.)*([a-z0-9\-\.\_])+/i', '', $str);
        return $str;
    }
    function addtopic() {
        $code = $this->setting['hct_logincode'] != null ? $this->setting['hct_logincode'] : rand(111111, 9999999);
        if ($this->input->post('title') != null) {
            $article = $this->topic_model->get_byname($this->input->post('title')); //查询是否重复
            $classid = $this->input->post('classid'); //文章分类
            $title = $this->input->post('title'); //文章标题
            $content = $_POST['content']; //文章内容
            $answercontent = $_POST['answercontent']; //文章评论-new
            $guanjianci = $_POST['guanjianci']; //关键词-new
            $splitname = $_POST['splitname']; //评论分隔符-new
            if ($splitname == '') {
                echo "分隔字符串不能为空";
                exit();
            }
            $answercontentarr = array(); //分割评论
            if ($answercontent != '') {
                $answercontentarr = explode($splitname, $answercontent);
            }
            $guanjiancikey = array(); //分割关键词
            if ($guanjianci != '') {
                $guanjiancikey = explode($splitname, $guanjianci);
            }
            if ($code != $this->input->post('articlevalue')) {
                echo '没有发布权限!';
                exit();
            }
            if ($article != null) {
                echo '文章已存在，发布时间为' . $article['viewtime'];
                exit();
            } else {
                $content = preg_replace("#<a[^>]*>(.*?)</a>#is", "$1", $content);
                $userlist = $this->user_model->get_caiji_list(0, 40);
                $mwtuid = array_rand($userlist, 1);
                $uid = $userlist[$mwtuid]['uid'];
                $username = $userlist[$mwtuid]['username'];
                $file = $this->getfolders();
                // for($i=1;$i<=60;$i++){
                // array_push($classarr, $i);
                // }
                $url = 'https://ask.dobunkan.com/data/attach/topic/topic6DYxVY.jpg';
                $img_url = getfirstimg($content);
                if ($file != '0') {
                    $mwtfid = array_rand($file, 1);
                    $url = SITE_URL . 'static/caijiimage/' . $file[$mwtfid];
                }
                if ($img_url == "") {
                    $img_url = $url;
                }
                if (ckabox == 'true' || ckabox == 'on') {
                    $content = filter_outer($content);
                }
                if (trim($content) != '') {
                    $views = rand(100, 500); //阅读数--随机100-500
                    $randnum = rand(10, 70); //发布时间 随机10-70分钟前发布
                    $viewtime = strtotime("-$randnum minute");
                    $aid = $this->addtopicwenzhang($title, $content, $img_url, $username, $uid, $views, $classid, $viewtime);
                    //关键词插入开始
                    $guanjiancicount = count($guanjiancikey);
                    if ($guanjiancicount == 1) {
                    	$num=rand(10-60);
                    	
                    	$keytime = strtotime("+$num minute");
                        $this->addguanjianci($aid, $guanjiancikey[0], $keytime, '',$classid,$uid);
                        exit();
                    } elseif ($guanjiancicount > 1) {
                        for ($i = 0; $i < $guanjiancicount; $i++) {
                        	$num=rand(10-60);
                        	
                        	$keytime = strtotime("+$num minute");
                            $this->addguanjianci($aid, $guanjiancikey[$i], $keytime, '',$classid,$uid);
                        }
                    }
                    //文章评论开始
                    $answercount = count($answercontentarr); //评论长度
                    if ($answercount == 1) {
                        $answers = 1;
                        $mwtuid = array_rand($userlist, 1);
                        $b_uid = $userlist[$mwtuid]['uid'];
                        $b_username = $userlist[$mwtuid]['username'];
                        $randnum = rand(3, 30); //随机3-30分钟前回答问题
                        $qbesttime = strtotime("-$randnum minute");
                        $this->addanswer($aid, $title, $answercontentarr[0], $qbesttime, $b_uid, $b_username, $answers);
                        echo '发布成功';
                        exit();
                    } elseif ($answercount > 1) {
                        for ($i = 0; $i < $answercount; $i++) {
                            $mwtuid = array_rand($userlist, 1);
                            $answers = $i + 1;
                            $b_uid = $userlist[$mwtuid]['uid'];
                            $b_username = $userlist[$mwtuid]['username'];
                            $randnum = rand(3, 30); //随机3-30分钟前回答问题
                            $qbesttime = strtotime("-$randnum minute");
                            $this->addanswer($aid, $title, $answercontentarr[$i], $qbesttime, $b_uid, $b_username, $answers);
                        }
                        //添加评论结束
                        
                    } else {
                        echo "发布失败-----异常";
                    }
                } else {
                    echo "发布失败,内容不能为空";
                }
            }
        } else {
            echo '标题不能为空';
        }
    }
	
    //添加文章
    function addtopicwenzhang($title, $desc, $image, $author, $authorid, $views, $articleclassid, $viewtime = 0) {
        $data = array(
            'title' => $title,
            'describtion' => $desc,
            'image' => $image,
            'author' => $author,
            'authorid' => $authorid,
            'views' => $views,
            'articleclassid' => $articleclassid,
            'viewtime' => $viewtime
        );
        $this->db->insert('topic', $data);
        runlog('querylog', $this->db->last_query());
        $aid = $this->db->insert_id();
        return $aid;
    }
	
    //添加评论
    function addanswer($aid, $title, $content, $qbesttime, $uid, $username, $answers, $status = 1, $chakanjine = 0) {
        $dianzan = rand(3, 66);
        $this->db->query("INSERT INTO " . $this->db->dbprefix . "articlecomment SET tid='$aid',title='$title',author='$username',authorid='$uid',time='$qbesttime',content='$content',reward=$chakanjine,status=$status, ip='{$this->ip}', supports=$dianzan");
        $this->db->query("UPDATE " . $this->db->dbprefix . "topic SET  articles=$answers  WHERE id=" . $aid);
        $aid = $this->db->insert_id();
    }
	
    //添加关键词
    function addguanjianci($aid, $name, $keytime, $pinyin='',$cid=0,$authorid=0) {
    	$tagalias=$this->getPinyin($name);
    	
    	$tagalias = preg_replace ( '# #', '',$tagalias ); // 标签别名
    	//查看是否存在该标签
    	$tag = $this->db->query ( "SELECT * FROM `" . $this->db->dbprefix . "tag` WHERE tagname='$name'" )->row_array ();
    	
    	if($tag){
    		$id=$tag['id'];
    	}else{
    		$data=array('tagfisrtchar'=>$this->getfirstchar($tagalias),'time'=>$keytime,'tagimage'=>'','tagname'=>$name,'tagalias'=>$tagalias,'title'=>$name,'keywords'=>$name,'description'=>'');
    		$this->db->insert ( 'tag', $data );
    		$id = $this->db->insert_id ();
    	}
   
    	$data=array(
    			'tagid' => $id,
    			'typeid' => $aid ,
    			'cid' =>$cid,
    			'itemtype'=>'article',
    			'time'=>time(),
    			'uid'=>$authorid
    	);
    	$this->db->insert ( 'tag_item', $data );
    	$tagitemid = $this->db->insert_id ();
    	
        //$this->db->query("INSERT INTO " . $this->db->dbprefix . "topic_tag SET aid='$aid',name='$name',time='$keytime',pinyin='' ");
        //$aid = $this->db->insert_id();
    }
	
    function clist() {
        $cid = intval($this->uri->segment(3)) ? $this->uri->segment(3) : 'all';
        $navlist = $this->category_model->list_by_pid(0); // 获取导航
        $cat_string = '';
        foreach ($navlist as $nav) {
            $cat_string = $cat_string . ',' . $nav['name'] . '|' . $nav['id'];
        }
        echo $cat_string;
    }
	
    function selectlist() {
        echo ("<select>");
        $cid = intval($this->uri->segment(3)) ? $this->uri->segment(3) : 'all';
        $navlist = $this->list_by_grade(); // 获取导航
        $cat_string = '';
        foreach ($navlist as $nav) {
            echo "<option value='" . $nav['id'] . "'>" . $nav['name'] . "</option>";
            if ($nav['sublist'] != null) {
                foreach ($nav['sublist'] as $nav1) {
                    echo "<option value='" . $nav1['id'] . "'>--" . $nav1['name'] . "</option>";
                }
            }
        }
        echo ("</select>");
    }
	
    function list_by_grade($grade = 1) {
        $categorylist = array();
        $query = $this->db->query("select id,name,questions,grade,image,miaosu,followers from " . $this->db->dbprefix . "category where grade=1 and isusearticle=1 order by displayorder asc,id asc");
        foreach ($query->result_array() as $category1) {
            $query2 = $this->db->query("select id,name,questions,miaosu,followers from " . $this->db->dbprefix . "category where pid=$category1[id] and grade=2 order by displayorder asc,id asc");
            $category1['sublist'] = array();
            foreach ($query2->result_array() as $category2) {
                $category1['sublist'][] = $category2;
            }
            $categorylist[] = $category1;
        }
        return $categorylist;
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