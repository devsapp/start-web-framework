<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 

defined('IN_MET') or exit('No permission');

//记录消息内容
function obtain($news_id,$newstitle,$content,$url,$member,$type,$lang,$time) {
	global $_M;
	if(!$time){
		$time = time();
	}
	$query = "INSERT INTO {$_M['table']['infoprompt']} SET news_id='{$news_id}',newstitle='{$newstitle}',content='{$content}',url='{$url}',member='{$member}',type='{$type}',time='{$time}',lang='{$lang}'";
	$result = DB::query($query);
	
}

//查询消息内容
function news_search($id) {
	global $_M;
	$query = "SELECT * FROM {$_M['table']['infoprompt']} where id='{$id}'";
	$result = DB::get_one($query);
	return $result;
}



//修改消息内容
function news_dell($id) {
	global $_M;
	$query = "UPDATE {$_M['table']['infoprompt']} SET see_ok='1' where id='{$id}'";
	$result = DB::query($query);

}


# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>