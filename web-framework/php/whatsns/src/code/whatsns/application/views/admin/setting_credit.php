<!--{template header}-->

<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;积分设置</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table class="table">
    <tr>
        <td class="{$type}">{$message}</td>
    </tr>
</table>
<!--{/if}-->
<table width="100%" cellspacing="1" cellpadding="4" align="center" class="tableborder">
    <tbody><tr class="header"><td>友情链接列表</td></tr>
        <tr class="altbg1"><td>经验和金币都可以设置为负数，0，或者正数，负数表示扣分。</td></tr>
    </tbody>
</table>
<form action="index.php?admin_setting/settingcredit{$setting['seo_suffix']}" method="post">
    <table class="table">
        <tr class="header" align="center">
            <td width="30%">参数名称</td>
            <td  width="35%">经验值</td>
            <td  width="35%">财富值</td>
        </tr>
        <tr class="smalltxt" align="center">
            <td  width="30%"  class="altbg1">用户注册获得:</td>
            <td  width="35%" class="altbg2"><input value="{$setting['credit1_register']}" type="text" name="credit1_register"></td>
            <td  width="35%" class="altbg1"><input value="{$setting['credit2_register']}" type="text" name="credit2_register"></td>
        </tr>
        <tr class="smalltxt" align="center">
            <td  width="30%" class="altbg1">每日登录系统获得:</td>
            <td  width="35%" class="altbg2"><input value="{$setting['credit1_login']}" name="credit1_login" type="text" ></td>
            <td  width="35%" class="altbg1"><input value="{$setting['credit2_login']}" name="credit2_login" type="text"></td>
        </tr>
        <tr class="smalltxt" align="center">
            <td  width="30%" class="altbg1">提出问题获得:</td>
            <td  width="35%" class="altbg2"><input value="{$setting['credit1_ask']}" name="credit1_ask" type="text" ></td>
            <td  width="35%" class="altbg1"><input value="{$setting['credit2_ask']}" name="credit2_ask" type="text"></td>
        </tr>
        <tr class="smalltxt" align="center">
            <td  width="30%" class="altbg1">回答问题获得:</td>
            <td  width="35%" class="altbg2"><input value="{$setting['credit1_answer']}" name="credit1_answer" type="text" ></td>
            <td  width="35%" class="altbg1"><input value="{$setting['credit2_answer']}" name="credit2_answer" type="text"></td>
        </tr>
        <tr class="smalltxt" align="center">
            <td  width="30%" class="altbg1">回答被采纳:</td>
            <td  width="35%" class="altbg2"><input value="{$setting['credit1_adopt']}" name="credit1_adopt" type="text" ></td>
            <td  width="35%" class="altbg1"><input value="{$setting['credit2_adopt']}" name="credit2_adopt" type="text"></td>
        </tr>
        <tr class="smalltxt" align="center">
            <td  width="30%" class="altbg1">发短消息获得:</td>
            <td  width="35%" class="altbg2"><input value="{$setting['credit1_message']}" name="credit1_message" type="text" ></td>
            <td  width="35%" class="altbg1"><input value="{$setting['credit2_message']}" name="credit2_message" type="text"></td>
        </tr>
          <tr class="smalltxt" align="center">
            <td  width="30%" class="altbg1">发布文章获得:</td>
            <td  width="35%" class="altbg2"><input value="{$setting['credit1_article']}" name="credit1_article" type="text" ></td>
            <td  width="35%" class="altbg1"><input value="{$setting['credit2_article']}" name="credit2_article" type="text"></td>
        </tr>
          <tr class="smalltxt" align="center">
            <td  width="30%" class="altbg1">邀请注册获得:</td>
            <td  width="35%" class="altbg2"><input value="{$setting['credit1_invate']}" name="credit1_invate" type="text" ></td>
            <td  width="35%" class="altbg1"><input value="{$setting['credit2_invate']}" name="credit2_invate" type="text"></td>
        </tr>
    </table>
    <br />
    <center><input type="submit" class="btn btn-success" name="submit" value="提 交"></center><br>
</form>
<br />
<!--{template footer}-->