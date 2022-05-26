<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;消息模板</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table class="table">
    <tr>
        <td class="{$type}">{$message}</td>
    </tr>
</table>
<!--{/if}-->

<form action="index.php?admin_setting/msgtpl{$setting['seo_suffix']}" method="post">
    <a name="基本设置"></a>
    <table class="table">
        <tr class="header">
            <td colspan="2">消息模板设置</td>
        </tr>
        <tr>
            <td colspan="2">
                消息模板设置规则：<br />
                1、网站名称:{wzmc}（应用范围：所有消息模板）<br />
                2、问题标题:{wtbt}（应用范围：所有消息模板）<br />
                3、问题描述:{wtms}（应用范围：所有消息模板）<br />
                4、回答内容:{hdnr}（应用范围：仅回答评分模板有效）<br />
                5、以上标签（必须包含大括号"{}"）可以通过添加在下面来配置消息模板，每个消息结束部分系统会自动加上问题查看链接。
            </td>
        </tr>
        <tr class="header">
            <td colspan="2">问题收到新的回答</td>
        </tr>
        <tr>
            <td width="45%"><b>邮件（消息）标题：</b><br><span class="smalltxt">站内消息或者邮件的标题</span></td>
            <td><input  type="text" {if isset($msgtpl[0]['title'])}value="{$msgtpl[0]['title']}"{/if} style="width:300px;" name="title1"></td>
        </tr>
        <tr>
            <td width="45%"><b>消息内容:</b><br><span class="smalltxt">站内消息或者邮件的内容</span></td>
            <td><textarea class="area" name="content1"  style="height:100px;width:300px;">{if isset($msgtpl[0]['content'])}{$msgtpl[0]['content']}{/if}</textarea></td>
        </tr>
        <tr class="header">
            <td colspan="2">回答被采纳</td>
        </tr>
        <tr>
            <td width="45%"><b>邮件（消息）标题：</b><br><span class="smalltxt">站内消息或者邮件的标题</span></td>
            <td><input  type="text" {if isset($msgtpl[1]['title'])}value="{$msgtpl[1]['title']}"{/if} style="width:300px;" name="title2"></td>
        </tr>
        <tr>
            <td width="45%"><b>消息内容:</b><br><span class="smalltxt">站内消息或者邮件的内容</span></td>
            <td><textarea class="area" name="content2"  style="height:100px;width:300px;">{if isset($msgtpl[1]['content'])}{$msgtpl[1]['content']}{/if}</textarea></td>
        </tr>
        <tr class="header">
            <td colspan="2">问题过期关闭</td>
        </tr>
        <tr>
            <td width="45%"><b>邮件（消息）标题：</b><br><span class="smalltxt">站内消息或者邮件的标题</span></td>
            <td><input  type="text" {if isset($msgtpl[2]['title'])}value="{$msgtpl[2]['title']}"{/if} style="width:300px;" name="title3"></td>
        </tr>
        <tr>
            <td width="45%"><b>消息内容:</b><br><span class="smalltxt">站内消息或者邮件的内容</span></td>
            <td><textarea class="area" name="content3"  style="height:100px;width:300px;">{if isset($msgtpl[2]['content'])}{$msgtpl[2]['content']}{/if}</textarea></td>
        </tr>
        <tr class="header">
            <td colspan="2">回答被评分</td>
        </tr>
        <tr>
            <td width="45%"><b>邮件（消息）标题：</b><br><span class="smalltxt">站内消息或者邮件的标题</span></td>
            <td><input  type="text" {if isset($msgtpl[3]['title'])}value="{$msgtpl[3]['title']}"{/if} style="width:300px;" name="title4"></td>
        </tr>
        <tr>
            <td width="45%"><b>消息内容:</b><br><span class="smalltxt">站内消息或者邮件的内容</span></td>
            <td><textarea class="area" name="content4"  style="height:100px;width:300px;">{if isset($msgtpl[3]['content'])}{$msgtpl[3]['content']}{/if}</textarea></td>
        </tr>
    </table>
    <br>
    <center><input type="submit" class="btn btn-success" name="submit" value="提 交"></center><br>
</form>
<br>
<!--{template footer}-->