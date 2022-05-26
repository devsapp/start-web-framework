<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;添加导航</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table  class="table table-striped">
    <tr>
        <td class="{$type}">{$message}</td>
    </tr>
</table>
<!--{/if}-->
<form {if isset($curnav)}action="index.php?admin_nav/edit{$setting['seo_suffix']}"{else}action="index.php?admin_nav/add{$setting['seo_suffix']}"{/if} method="post">
    <table  class="table table-striped">
        <tr>
            <td class="altbg1" width="45%"><b>导航名称:</b><br><span class="smalltxt">导航链接名称</span></td>
            <td class="altbg2"><input class="txt"  name="name" style="width:300px;" {if isset($curnav['name'])}value="{$curnav['name']}"{/if} ></td>
        </tr>
        <tr>
            <td class="altbg1" width="45%"><b>导航说明:</b><br><span class="smalltxt">导航描述、备注</span></td>
            <td class="altbg2"><input class="txt"  name="title" style="width:300px;" {if isset($curnav['title'])}value="{$curnav['title']}" {/if}></td>
        </tr>
        <tr>
            <td class="altbg1" width="45%"><b>链接打开方式:</b><br><span class="smalltxt">导航链接打开方式，主要分为当前窗口和新建窗口打开</span></td>
            <td class="altbg2">
                <div class="col-md-2">
                <input type="radio"  value="0"  class="radio inline" name="target" {if (!isset($curnav['target']) || !$curnav['target'])}checked{/if} /><label>在本窗口打开</label> &nbsp;&nbsp;
                </div>

                <div class="col-md-2">
                <input type="radio" class="radio inline" name="target" value="1" {if isset($curnav['target']) && $curnav['target']}checked{/if}/><label>在新窗口打开</label>
            </div>
            </td>
        </tr>
        <tr>
            <td class="altbg1" width="45%"><b>URL地址:</b><br><span class="smalltxt">导航的链接地址，如果ask2系统外的网址，请输入全网址。如:http://www.ask2.cn</span></td>
            <td class="altbg2"><input class="txt"  name="url" style="width:300px;" {if isset($curnav['url'])}value="{$curnav['url']}" {/if} /></td>
        </tr>
        <tr style="display:none">
            <td class="altbg1" width="45%"><b>导航类型:</b><br><span class="smalltxt">导航的链接地址，如果ask2系统外的网址，请输入全网址。如:http://www.ask2.cn</span></td>
            <td class="altbg2">
                <div class="col-md-2">
                    <input class="radio inline" type="radio" checked value="1" name="type" />&nbsp;<label>站内导航</label>&nbsp;&nbsp;
                </div>
                <div class="col-md-2">
                    <input class="radio inline" type="radio" {if isset($curnav['type'])&&1!=$curnav['type']}checked{/if} value="2" name="type" />&nbsp;<label>站外导航</label>
                    </div>

            </td>
        </tr>
    </table>
    <br />
    <center><input type="submit" class="btn  btn-success" name="submit" value="提 交"></center><br>
    {if isset($curnav)}<input type="hidden" name="nid" value="{$curnav['id']}">{/if}
</form>
<br />
<!--{template footer}-->