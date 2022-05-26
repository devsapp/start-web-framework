<!--{template header}-->
<script type="text/javascript">g_site_url='{SITE_URL}';g_prefix='{$setting['seo_prefix']}';g_suffix='{$setting['seo_suffix']}';</script>
<script type="text/javascript" src="{SITE_URL}static/js/neweditor/ueditor.config.js"></script>
<script type="text/javascript" src="{SITE_URL}static/js/neweditor/ueditor.all.min.js"></script>
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;添加礼品</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table class="table table-striped">
    <tr>
        <td class="{$type}">{$message}</td>
    </tr>
</table>
<!--{/if}-->
<form {if isset($gift)}action="index.php?admin_gift/edit{$setting['seo_suffix']}"{else}action="index.php?admin_gift/add{$setting['seo_suffix']}"{/if}  method="post" enctype="multipart/form-data">
    <table class="table table-striped">
        <tr class="header"><td colspan="2">参数设置</td></tr>
        <tr>
            <td class="altbg1" width="45%"><b>礼品图片:</b><br><span class="smalltxt">礼品图片请选jpg、gif、png格式</span></td>
            <td class="altbg2"><!--{if isset($gift['image'])}--><img src="{SITE_URL}{$gift['image']}" width="80" height="80"/>&nbsp;&nbsp;&nbsp;<!--{/if}--><input type="file" size="30" name="imgurl" /></td>
        </tr>
        <tr>
            <td class="altbg1" width="45%"><b>礼品名称:</b><br><span class="smalltxt">礼品名称</span></td>
            <td class="altbg2"><input class="txt"  name="giftname" {if isset($gift['title'])} value="{$gift['title']}" {/if} /></td>
        </tr>
        <tr>
            <td class="altbg1" width="45%"><b>需要的财富值:</b><br><span class="smalltxt">兑换该礼品所需要的财富值</span></td>
            <td class="altbg2"><input class="txt" {if isset($gift['credit'])} value="{$gift['credit']}" {/if} name="giftprice" /></td>
        </tr>
        <tr>
            <td class="altbg1" width="45%"><b>礼品描述:</b><br><span class="smalltxt">对于该礼品的简短说明</span></td>
            <td class="altbg2">
                <script type="text/plain" id="mycontent" name="giftdesrc" style="width:610px;height:300px;">{if isset($gift['description'])}$gift['description']{/if}</script>
                <script type="text/javascript">UE.getEditor('mycontent');</script>
            </td>
        </tr>
    </table>
    <br />
    {if isset($gift['id'])}
    <input type="hidden" value="{$gift['id']}" name="id" />
    <input type="hidden" value="{$gift['image']}" name="imgpath" />
    {/if}
    <center><input type="submit" class="button" name="submit" value="提 交"></center><br>
</form>
<br />
<!--{template footer}-->