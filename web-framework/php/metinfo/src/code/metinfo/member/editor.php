<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. 
require_once 'login_check.php';
$admin_list = $db->get_one("SELECT * FROM $met_admin_table WHERE admin_id='$metinfo_member_name' ");
require_once ROOTPATH.'member/index_member.php';
$query1 = "SELECT * FROM $met_parameter WHERE lang='$lang' and module='10' order by no_order";
$result1 = $db->query($query1);
while($list1 = $db->fetch_array($result1)){
		$para_list[]=$list1;
}
$fdjs="<script language='javascript'>";
	$fdjs.="function isValidEmail(email)
			{
			var result=email.match(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/);
			if(result==null) return false;
			return true;
			}";
	$fdjs=$fdjs."function Checkmember(){ ";
	$fdjs.="if(document.myform.email.value == '') 
         { alert('email{$lang_Empty}');
		   document.myform.email.focus();
		   document.myform.email.select(); 
           return false;
         }";
	$fdjs.="if(!isValidEmail(document.myform.email.value))
         { alert('{$lang_js13}');
           document.myform.email.focus();
		   document.myform.email.select(); 
		   return false;
         }";
foreach($para_list as $key=>$val){
	$paras_name="para".$val[id];
	$paras_name1="para".$val[id].$val[id];
	if($val[type]==1&&$val[wr_ok]==1){
		$fdjs.="if(document.myform.{$paras_name}.value == '') 
         { alert('{$val[name]}{$lang_Empty}');
		   document.myform.{$paras_name}.focus();
		   document.myform.{$paras_name}.select(); 
           return false;
         }";
	}
	if($val[type]==3&&$val[wr_ok]==1){
		$fdjs.="if(document.myform.{$paras_name}.value == '') 
         { alert('{$val[name]}{$lang_Empty}');
		   document.myform.{$paras_name}.focus();
		   document.myform.{$paras_name}.select(); 
           return false;
         }";
	}
	if($val[type]==4&&$val[wr_ok]==1){
		$query2 = "select * from $met_list where lang='$lang' and bigid='$val[id]'";
		$result2 = $db->query($query2);
		while($list2 = $db->fetch_array($result2)){
			$paravalue1[]=$list2;
		}
		$i=1;
		$infos="";
		foreach($paravalue1 as $key=>$val1){
			$lagerinput=$lagerinput."document.myform.para$val[id]_$i.checked ||";
			$i=$i+1;
			}
		$lagerinput=$lagerinput."false\n";
		$fdjs.="if(!($lagerinput)) 
         { alert('{$val[name]}{$paras_Empty[value]}');
           return false;
         }";
		}
	if($val[type]==5&&$val[wr_ok]==1){
		$fdjs.="if(document.myform.{$paras_name1}.value == ''&&document.myform.{$paras_name}.value == '') 
         { alert('{$val[name]}{$lang_Empty}');
		   document.myform.{$paras_name}.focus();
		   document.myform.{$paras_name}.select(); 
           return false;
         }";
	
	}
	
}
$fdjs=$fdjs."}</script>";
$mfname='editor';
include template('member');
footermember();
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.
?>