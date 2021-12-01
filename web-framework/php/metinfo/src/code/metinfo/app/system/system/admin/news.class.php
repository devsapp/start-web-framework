<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.

defined('IN_MET') or exit('No permission');

load::sys_class('admin');
load::sys_func('news');

class news extends admin
{

    function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取官网最新推荐消息并记录
     * @return [type] [description]
     */
    public function docurlnews()
    {
        global $_M;
        if ($_M['config']['met_agents_metmsg'] == 1) {
            $curl = load::sys_class('curl', 'new');
            $curl->set('host', 'www.metinfo.cn');
            $curl->set('file', 'metv6news.php');
            $curl->set('ssl', 1);
            $query = "SELECT * FROM {$_M['table']['infoprompt']} where type='metinfo' ORDER BY time DESC limit 0,1";
            $result = DB::get_one($query);
            $post = array(
                'lang' => 'cn',
                'lasttime' => $result['time'],
            );
            $jsons = json_decode($curl->curl_post($post), 1);
            foreach ($jsons as $key => $val) {
                obtain(0, $val['title'], '', $val['url'], '', 'metinfo', 'metinfo', $val['time']);
            }
            $query = "SELECT * FROM {$_M['table']['infoprompt']} where type='metinfo' and see_ok='0'";
            $news = DB::get_all($query);
        }
        $count = is_array($news) ? count($news) : 0;
        $this->success(array('num' => $count));
    }

    /**
     * 消息列表
     * @return [type] [description]
     */
    public function donews_list()
    {
        global $_M;
        $table = load::sys_class('tabledata', 'new'); //加载表格数据获取类
        $where = "(lang='{$_M['lang']}' or lang='metinfo') and (see_ok!='2')";   //整理查询条件
        $order = "time DESC"; //排序方式
        $array = $table->getdata($_M['table']['infoprompt'], '*', $where, $order);
        foreach ($array as $key => $val) {
            $list = $val;
            $list['time'] = date("Y-m-d H:i:s", $val['time']);
            $rarray[] = $list;
        }
        $table->rdata($rarray);
    }

    /**
     * 标记已读
     * @return [type] [description]
     */
    public function donews_seeok()
    {
        global $_M;
        $id = $_M['form']['id'];
        $query = "update {$_M[table][infoprompt]} set see_ok='1' where id='{$id}'";
        DB::query($query);
    }

    /**
     * 全部清空（只隐藏）
     * @return [type] [description]
     */
    public function donews_del()
    {
        global $_M;
        // $query = "delete from {$_M['table']['infoprompt']}";
        $query = "update {$_M[table][infoprompt]} set see_ok='2'";
        DB::query($query);
        $this->ajaxReturn(array('status' => 1, 'msg' => $_M['word']['jsok']));
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>