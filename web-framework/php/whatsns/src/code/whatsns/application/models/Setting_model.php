<?php

class Setting_model  extends CI_Model {

	function __construct() {
		parent::__construct ();
		$this->load->database ();
	}

    function update($setting) {
        foreach($setting as $key=>$value) {
           if ('editor' == substr($key, 0, 6)) {
                   $value =addslashes($value);

                }
            $this->db->query("REPLACE INTO ".$this->db->dbprefix."setting (k,v) VALUES ('$key','$value')");
        }
       cleardir ( FCPATH . '/data/cache' ); //清除缓存文件
    }

    /*读取views文件夹，获取模板的选项*/
    function tpl_list() {
        $tpllist=array();
        $filedir=APPPATH.'/views';
        $handle=opendir($filedir);
        while($filename=readdir($handle)) {
            if (is_dir($filedir.'/'.$filename) && '.'!=$filename{0} && 'admin'!=$filename&& 'errors'!=$filename) {
            	if(strpos($filename, 'wap')===false){

                	$tpllist[]=$filename;

            	}
            }
        }
        closedir($handle);
        return $tpllist;
    }
    /*读取views文件夹，获取模板的选项*/
    function apptpl_list() {
    	$tpllist=array();
    	$filedir=APPPATH.'/views';
    	$handle=opendir($filedir);
    	while($filename=readdir($handle)) {
    		if (is_dir($filedir.'/'.$filename) && '.'!=$filename{0} && 'admin'!=$filename&& 'errors'!=$filename) {
    			if(strpos($filename, 'wap')===false&&strpos($filename, 'app')!==false){
    				
    				$tpllist[]=$filename;
    				
    			}
    		}
    	}
    	closedir($handle);
    	return $tpllist;
    }
  /*读取theme文件夹，获取模板主题的选项*/
    function tpl_themelist() {
        $tpllist=array();
        $filedir=STATICPATH.'theme/';
        $handle=opendir($filedir);
        while($filename=readdir($handle)) {
            if (is_dir($filedir.'/'.$filename) ) {


            	if($filename!='.'&&$filename!='..'){
            		$tpllist[]=$filename;
            	}



            }
        }
        closedir($handle);
        return $tpllist;
    }
 /*读取view文件夹手机版，获取模板的选项*/
    function tpl_waplist() {
        $tpllist=array();
        $filedir=APPPATH.'/views';
        $handle=opendir($filedir);
        while($filename=readdir($handle)) {
            if (is_dir($filedir.'/'.$filename) && '.'!=$filename{0} && 'admin'!=$filename&& 'default'!=$filename&& 'sowenda'!=$filename&& 'errors'!=$filename) {

            	$last_fix=substr($filename,-3,3 );

            	if($last_fix=='wap'){
            		$tpllist[]=$filename;
            	}
            }
        }
        closedir($handle);
        return $tpllist;
    }
    /**
     * 分类问题数目校正
     */
    function regulate_category() {
        $query = $this->db->query("SELECT * FROM ".$this->db->dbprefix."category");
        foreach ( $query->result_array () as $category ) {
        	$q1=$this->db->query("select count(*) as num from ".$this->db->dbprefix."question where cid1=".$category['id'])->row_array();
        	$q2=$this->db->query("select count(*) as num from ".$this->db->dbprefix."question where cid2=".$category['id'])->row_array();
        	$q3=$this->db->query("select count(*) as num from ".$this->db->dbprefix."question where cid3=".$category['id'])->row_array();



            $questions=$q1['num']+$q2['num']+$q3['num'];
            $this->db->query("UPDATE ".$this->db->dbprefix."category set questions=$questions where id=".$category['id']);
        }
    }


    function get_hot_words($hot_words) {
        $lines = explode("\n",$hot_words);
        $wordslist = array();
        foreach ($lines as $line){
            $words = explode(str_replace("，",",","，"),$line);
            if(is_array($words)){
                $word['w']=$words[0];
                $word['qid']=intval($words[1]);
                $wordslist[] = $word;
            }

        }

        return serialize($wordslist);
    }


}

?>