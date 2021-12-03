<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Admin_emailpush extends ADMIN_Controller {

  	function __construct() {
		parent::__construct ();
        
    }
    function index($msg = ''){
    	$msg && $message = $msg;
    	$upagesize = 2;
    	$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'user', " 1=1 and fromsite=0 and email!='10000000@qq.com' ", $this->db->dbprefix ) )->row_array () );
    	$userpages = @ceil ( $rownum / $upagesize );
    	include template('admin_emailpushindex', 'admin');
    }
    function newfunpush($msg = ''){
    	$msg && $message = $msg;
    	$upagesize = 2;
    	$rownum = returnarraynum ( $this->db->query ( getwheresql ( 'user', " 1=1 and fromsite=0 and email!='10000000@qq.com' ", $this->db->dbprefix ) )->row_array () );
    	$userpages = @ceil ( $rownum / $upagesize );
    	include template('admin_emailpushnewfun', 'admin');
    }
    function emailfunsend(){
    	$emails=array();
    	$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
    	$pagesize = 2;
    	$startindex = ($page - 1) * $pagesize;
    	$query = $this->db->query ( "SELECT uid,email,username FROM " . $this->db->dbprefix . "user where fromsite=0 and email!='10000000@qq.com'  LIMIT $startindex,$pagesize" );
    	foreach ( $query->result_array () as $user ) {
    		//获取回答者通知情况
    		$myquser=$this->user_model->get_by_uid($user['uid']);
    		
    		if($myquser['fromsite']!=1&&$myquser['notify']['weekly']==1){
    			
    			array_push($emails, $myquser['email']);
    		}
    	}
    	$subject=$_POST['subject'];
    $message=$_POST['content'];
    sendmutiemail($emails, $subject, $message);
    exit("ok");
    }
    function emailsend(){
    	$emails=array();
    	$page = max ( 1, intval ( $this->uri->segment ( 3 ) ) );
    	$pagesize = 2;
    	$startindex = ($page - 1) * $pagesize;
    	$query = $this->db->query ( "SELECT uid,email,username FROM " . $this->db->dbprefix . "user where fromsite=0 and email!='10000000@qq.com'  LIMIT $startindex,$pagesize" );
    	foreach ( $query->result_array () as $user ) {
    		//获取回答者通知情况
    		$myquser=$this->user_model->get_by_uid($user['uid']);
    		
    		if($myquser['fromsite']!=1&&$myquser['notify']['weekly']==1){
    			
    			array_push($emails, $myquser['email']);
    		}
    	}
    	
    	$content='
<table class="edm__main" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f6f6f6;" bgcolor="#f6f6f6">
    <tbody>
    <tr style="border-collapse: collapse;">
        <td align="center" bgcolor="#f6f6f6" style="border-collapse: collapse; font-family: Helvetica, Arial, sans-serif;">
            <table class="w640" style="margin: 0 10px;" width="640" cellpadding="0" cellspacing="0" border="0"><tbody>
            <tr style="border-collapse: collapse;">
                <td class="w640" width="640" height="5" style="border-collapse: collapse; background-color: #009A61;" bgcolor="#009A61"></td>
            </tr><tr style="border-collapse: collapse;"><td id="header" class="w640" width="640" align="center" bgcolor="#FFFFFF" style="border-collapse: collapse; font-family: Helvetica, Arial, sans-serif;">
                <div align="center" style="width:640px;text-align: center;">
                    <a href="'.SITE_URL.'" rel="noopener" target="_blank">
                        <img id="customHeaderImage" label="Header Image" editable="true" width="230" src="https://www.ask2.cn/images/jx.png" class="w640" border="0" align="top" style="display: inline; outline: none; text-decoration: none; padding: 30px 0;">
                    </a>
                </div>
            </td></tr><tr class="banner" style="border-collapse: collapse;background:#fff;"><td>
                <a href="'.SITE_URL.'" rel="noopener" target="_blank">
                    <img style="width: 100%;max-width: 100%;" src="https://www.ask2.cn/images/bannerbg.png">
                </a>
            </td></tr>
            <tr id="simple-content-row" style="border-collapse: collapse;">
                <td class="w640" width="640" bgcolor="#ffffff" style="border-collapse: collapse; font-family: Helvetica, Arial, sans-serif;">
                    <table class="w640" width="640" cellpadding="0" cellspacing="0" border="0"><tbody><tr style="border-collapse: collapse;">
                        <td class="w30" width="30" style="padding-left:15px;border-collapse: collapse; font-family: Helvetica, Arial, sans-serif;"></td>
                        <td class="w580" width="580" style="border-collapse: collapse; font-family: Helvetica, Arial, sans-serif;">
                            <repeater><layout label="Text only">
                                <table class="w580" width="580" cellpadding="0" cellspacing="0" border="0"><tbody>
                                <tr style="border-collapse: collapse;">
                                    <td class="w580" width="580" style="border-collapse: collapse; font-family: Helvetica, Arial, sans-serif;"><br><br>
                		
                                        <p align="left" class="article-title" style="font-size: 14px; line-height: 1; color: #222222; font-weight: bold; margin-top: 0px; margin-bottom: 18px; font-family: Helvetica, Arial, sans-serif;">
                                            <singleline label="Title">热门文章</singleline></p>
                                        <div align="left" class="article-content" style="font-size: 13px; line-height: 20px; color: #444444; margin-top: 0px; margin-bottom: 18px; font-family: Helvetica, Arial, sans-serif;">
                                            <multiline label="Description">
                                                <table>
                                                    <tbody>';
    	$weektopiclist = $this->fromcache("weektopiclist");
    	$wenzhang='';   	
    	foreach ($weektopiclist as $weektopic){
    		$tid=$weektopic['id'];
    		$categoryname= $this->category [$weektopic['articleclassid']]['name'];;
    		$wenzhang.='      <tr style="border-collapse: collapse;">
                                                        <td class="q-item" style="border-collapse: collapse; font-family: Helvetica, Arial, sans-serif; font-size: 12px; line-height: 20px; padding: 0 0 15px 0;">
                                                            <a href="'.url("topic/getone/$tid").'" class="q-title" style="color: #009a61; font-weight: bold; text-decoration: none; font-size: 14px;" rel="noopener" target="_blank">
                                                                <strong>'.$weektopic['title'].'</strong></a>
                                                            <br>
                                                            <p style="margin: 0;font-family: Source Code Pro,Consolas,Menlo,Monaco,Courier New,monospace;color: #666; "><span>▲ '.$weektopic['views'].'</span><span style="color: #dddddd;">&nbsp; |&nbsp; </span>
                                                                <span>'.$weektopic['author'].'&nbsp; '.$categoryname.'&nbsp; </span></p>
                                                        </td>
                                                    </tr>';
    	}
    	
    	$attentionlist = $this->fromcache("attentionlist");
    	$content2='   </tbody></table>
    			
                                            </multiline>
                                        </div>
                                        <div style="border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color: #EEE; margin-bottom: 30px;"></div><p align="left" class="article-title" style="font-size: 14px; line-height: 1px; color: #222222; font-weight: bold; margin-top: 0px; margin-bottom: 18px; font-family: Helvetica, Arial, sans-serif;"><singleline label="Title">热门问答</singleline></p><div align="left" class="article-content" style="font-size: 13px; line-height: 20px; color: #444444; margin-top: 0px; margin-bottom: 18px; font-family: Helvetica, Arial, sans-serif;"><multiline label="Description">
                                            <table>
                                                <tbody>
                                           ';
    	$q_str='';
    	if(!$attentionlist){
    		$this->load->model('question_model');
    		$questionlist = $this->question_model->list_by_cfield_cvalue_status ( '', 'all', 'all', 0, 10, 0 ); //问题列表数据
    		
    	}else{
    		$questionlist=$attentionlist;
    	}
    	foreach ($questionlist as $question){
    		$id=$question['id'];
    		$categoryname= $this->category [$question['cid']]['name'];;
    		$q_str.='     <tr style="border-collapse: collapse;">
                                                    <td class="q-item" style="border-collapse: collapse; font-family: Helvetica, Arial, sans-serif; font-size: 12px; line-height: 20px; padding: 0 0 15px 0;">
                                                        <a href="'.url("question/view/$id").'" class="q-title" style="color: #009a61; font-weight: bold; text-decoration: none; font-size: 14px;" rel="noopener" target="_blank">
                                                            <strong>'.$question['title'].'</strong></a>
                                                        <br><p style="margin: 0;font-family: Source Code Pro,Consolas,Menlo,Monaco,Courier New,monospace;color: #666; ">
                                                        <span>✐ '.$question['answers'].'</span><span style="color: #dddddd;">&nbsp; |&nbsp; </span><span>'.$categoryname.'&nbsp; </span></p>
                                                    </td>
                                                </tr>';
    	}
    	$content3=' </tbody></table></multiline>
                                        </div>
                                        <div style="border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color: #EEE; margin-bottom: 30px;"></div>
                                        <p align="left" class="article-title" style="font-size: 14px; line-height: 1; color: #222222; font-weight: bold; margin-top: 0px; margin-bottom: 18px; font-family: Helvetica, Arial, sans-serif;">
                                            <singleline label="Title">热门用户</singleline></p>
                                        <div align="left" class="article-content" style="font-size: 13px; line-height: 20px; color: #444444; margin-top: 0px; margin-bottom: 18px; font-family: Helvetica, Arial, sans-serif;">
                                            <multiline label="Description">
                                                <table>
                                                    <tbody>
';
    	$userarticle=$this->fromcache('userauthorlist');
    	$userstr='';
    	
    	foreach ($userarticle as $user){
    		$uid=$user['uid'];
    		$userstr.='<tr style="border-collapse: collapse;">';
    		
    		$userstr.='
    				
<td width="32" valign="top" style="border-collapse: collapse; font-family: Helvetica, Arial, sans-serif;">
                                                        <img width="32" height="32" src="'.$user['avatar'].'" style="border-radius:50%;outline: none; text-decoration: none; display: block;">
                                                    </td>
                                                        <td width="150" class="q-item" style="width:640px;border-collapse: collapse; font-family: Helvetica, Arial, sans-serif; font-size: 12px; line-height: 20px; padding: 0 0 15px 10px;">
                                                            <a href="'.url("user/space/$uid").'" class="q-title" style="color: #009a61; font-weight: bold; text-decoration: none; font-size: 14px;" rel="noopener" target="_blank"><strong>'.$user['username'].'</strong></a><br style="line-height: 100%;"><span class="q-meta" style="font-family: Source Code Pro,Consolas,Menlo,Monaco,Courier New,monospace;color: #666; margin: 0 0 5px;">'.$user['answers'].'回答&nbsp;'.$user['num'].'文章&nbsp;'.$user['followers'].'关注&nbsp; </span>
                                                        </td>';
    		
    		
    		
    		$userstr.=' </tr>';
    		
    		
    	}
    	
    	$this->setting ['seo_index_title'] && $seo_title = str_replace ( "{wzmc}", $this->setting ['site_name'], $this->setting ['seo_index_title'] );
    	$content4='</tbody></table></multiline></div><tr style="border-collapse: collapse;"><td class="w640" width="640" style="border-collapse: collapse; font-family: Helvetica, Arial, sans-serif;"><table id="footer" class="w640" width="640" cellpadding="0" cellspacing="0" border="0" bgcolor="#5E6E68" style="-webkit-font-smoothing: antialiased; height: 95px;color: #C1D2CB; background-color: #5E6E68;"><tbody><tr style="border-collapse: collapse;"><td class="w30" width="30" style="border-collapse: collapse; font-family: Helvetica, Arial, sans-serif;"></td><td class="w580" width="580" valign="top" style="border-collapse: collapse;font-family: Helvetica, Arial, sans-serif;"><div style="font-size:13px;color:#ffffff;margin-bottom: 7px;margin-top:25px;"><span>'.$seo_title.'</span></div><div id="permission-reminder" align="left" class="footer-content-left" style="-webkit-text-size-adjust: none; -ms-text-size-adjust: none; font-size: 12px; line-height: 15px; color: #C1D2CB; margin-top: 0px; margin-bottom: 25px; white-space: normal;"><span><a href="'.SITE_URL.'" style="color: #C1D2CB;text-decoration: none" rel="noopener" target="_blank">'.SITE_URL.'</a>
                                &nbsp; <span style="color: #C1D2CB;">|</span>&nbsp;
                                                                                                    <a href="'.SITE_URL.'" style="color: #C1D2CB;text-decoration: none" rel="noopener" target="_blank">WHATSNS</a> &nbsp;
                                                                                                    <span style="color: #C1D2CB;">|</span>&nbsp;
                                                                                                    <a href="'.url("user/notify").'" style="color: #C1D2CB;text-decoration: none" rel="noopener" target="_blank">退订邮件</a></span></div></td><td class="w30" width="30" style="border-collapse: collapse; font-family: Helvetica, Arial, sans-serif;"></td></tr></tbody></table></td></tr><tr style="border-collapse: collapse;"><td class="w640" width="640" height="60" style="border-collapse: collapse; font-family: Helvetica, Arial, sans-serif;"></td></tr></tbody></table></td></tr></tbody></table>
';
    	if($weektopiclist){
    		$subject="每周精选|".$weektopiclist[0]['title'];  
    	}else if($questionlist){
    		$subject="每周精选|".$questionlist[0]['title'];  
    	}else{
    		$subject="每周精选";
    	}
    	
    	$message=$content.$wenzhang.$content2.$q_str.$content3.$userstr.$content4;
    	sendmutiemail($emails, $subject, $message);
    	exit("ok");
   
    }


}
