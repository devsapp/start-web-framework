<!--{template header}-->
<div id="append">
</div>
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;礼品列表</div>
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
    <tbody>
        <tr class="header" ><td>礼品列表</td></tr>
        <tr class="altbg1"><td>通过设为可用、设为过期来让礼品生效或者失效</td></tr>
    </tbody>
</table>
[共 <font color="green">{$giftnum}</font> 个礼品]
<form action="index.php?admin_gift/search{$setting['seo_suffix']}" name="giftform" method="post">
    <table class="table">
        <tr class="header">
            <td width="10%"><input class="checkbox" value="chkall" id="chkall" onclick="checkall('gid[]')" type="checkbox" name="chkall"><label for="chkall">全选</label></td>
            <td  width="20%">礼品图片</td>
            <td  width="15%">礼品名称</td>
            <td  width="10%">所需金币</td>
            <td  width="20%">礼品描述</td>
            <td  width="10%">更新时间</td>
            <td  width="5%">过期</td>
            <td  width="10%">操作</td>
        </tr>
        <!--{loop $giftlist $gift}-->
        <tr>
            <td class="altbg2"><input class="checkbox" type="checkbox" value="{$gift['id']}" name="gid[]"></td>
            <td class="altbg2"><img src="{SITE_URL}{$gift['image']}" width="80" height="80"/></td>
            <td class="altbg2"><strong>{$gift['title']}</strong></td>
            <td class="altbg2">{$gift['credit']}</td>
            <td class="altbg2">{eval echo cutstr(strip_tags($gift['description']),40,'')}</td>
            <td class="altbg2">{$gift['time']}</td>
            <td class="altbg2">{if !$gift['available']}<font color="Red">是</font>{else}否{/if}</td>
            <td class="altbg2"><a href="index.php?admin_gift/edit/$gift['id']{$setting['seo_suffix']}">编辑</a></td>
        </tr>
        <!--{/loop}-->
      <!--{if $departstr}-->
        <tr class="smalltxt">
            <td class="altbg2" colspan="8" align="right"><div class="scott">{$departstr}</div></td>
        </tr>
        <!--{/if}-->
        <tr>
            <td colspan="8" class="altbg1"><input class="btn" type="button" name="available" onclick="onavailable(0);" value="设为过期" />&nbsp;&nbsp;<input class="btn" type="button" name="available" onclick="onavailable(1);" value="设为可用" />&nbsp;&nbsp;<input class="btn" type="button" name="delete" onclick="ondelete();" value="删除" /></td>
        </tr>
    </table>
</form>
<!--{template footer}-->
<script type="text/javascript">
    function onavailable(type){
        if($("input[name='gid[]']:checked").length == 0){
            alert('你没有选择任何礼品！');
            return false;
        }
        document.giftform.action="index.php?admin_gift/available/"+type+"{$setting['seo_suffix']}";
        document.giftform.submit();
    }
    function ondelete(){
        if($("input[name='gid[]']:checked").length == 0){
            alert('你没有选择任何礼品!');
            return false;
        }
        if(confirm('确认删除该礼品?此操作不可恢复!')==false){
            return false;
        }
        document.giftform.action="index.php?admin_gift/remove{$setting['seo_suffix']}";
        document.giftform.submit();
    }
</script>