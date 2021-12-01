<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;首页设置</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<div class="alert  alert-warning">{$message}</div>
<!--{/if}-->
<table class="table">
    <tbody><tr class="header"><td>设置说明</td></tr>
        <tr class="altbg1"><td>首页的每个区块显示数可以在这里设置，其它列表页包括分类列表，搜索结果等。</td></tr>
    </tbody></table>
<br />
<form action="index.php?admin_setting/clist{$setting['seo_suffix']}" method="post">
    <a name="基本设置"></a>
    <table class="table">
        <tr class="header">
            <td colspan="2">参数设置</td>
        </tr>
    
          <tr>
            <td class="altbg1" width="45%"><b>是否开启首页热文:</b><br><span class="smalltxt">默认不开启。</span></td>
            <td class="altbg2">
                <input class="radio inline"  type="radio"  {if 1==$setting['hot_on'] }checked{/if}  value="1" name="hot_on"><label for="yes">是</label>&nbsp;&nbsp;&nbsp;
                <input class="radio inline"  type="radio"  {if 0==$setting['hot_on'] }checked{/if} value="0" name="hot_on"><label for="no">否</label>
            </td>
        </tr>
        <tr>
            <td class="altbg1" width="45%"><b>首页推荐文章个数:</b><br><span class="smalltxt">首页精彩推荐列表显示个数，推荐6个</span></td>
            <td class="altbg2"><input class="form-control shortinput" value="{$setting['list_indexcommend']}" name="list_indexcommend"></td>
        </tr>
            <tr>
            <td class="altbg1" width="45%"><b>首页推荐课程个数:</b><br><span class="smalltxt">首页推荐显示个数，默认推荐4个</span></td>
            <td class="altbg2"><input class="form-control shortinput" value="{$setting['list_indexcourse']}" name="list_indexcourse"></td>
        </tr>
            <tr>
            <td class="altbg1" width="45%"><b>首页推荐话题个数:</b><br><span class="smalltxt">首页精彩推荐列表显示个数，推荐6个</span></td>
            <td class="altbg2"><input class="form-control shortinput" value="{$setting['list_indextopiccat']}" name="list_indextopiccat"></td>
        </tr>
        <tr>
            <td class="altbg1" width="45%"><b>首页待解决、已解决问题:</b><br><span class="smalltxt">首页待解决问题、已解决问题列表显示数目</span></td>
            <td class="altbg2"><input class="form-control shortinput" value="{$setting['list_indexnosolve']}" name="list_indexnosolve"></td>
        </tr>
        <tr>
            <td class="altbg1" width="45%"><b>首页赏金求答案:</b><br><span class="smalltxt">首页悬赏求答案问题列表显示数目</span></td>
            <td class="altbg2"><input class="form-control shortinput" value="{$setting['list_indexreward']}" name="list_indexreward"></td>
        </tr>
        <tr>
            <td class="altbg1" width="45%"><b>首页推荐专家:</b><br><span class="smalltxt">首页专家显示数目</span></td>
            <td class="altbg2"><input class="form-control shortinput" value="{$setting['list_indexexpert']}" name="list_indexexpert"></td>
        </tr>

        <tr>
            <td class="altbg1" width="45%"><b>首页热门标签:</b><br><span class="smalltxt">首页热门标签显示个数</span></td>
            <td class="altbg2"><input class="form-control shortinput" value="{$setting['list_indexhottag']}" name="list_indexhottag"></td>
        </tr>
        <tr>
            <td class="altbg1" width="45%"><b>热点关键词:</b><br><span class="smalltxt">热点关键词设置，设置说明:关键词设置一行一个</span></td>
            <td class="altbg2"><textarea class="form-control " style="height: 200px; width: 200px;"  name="list_hot_words" class="area">{$setting['list_hot_words']}</textarea></td>
        </tr>
    </table>
    <br>
    <center><input type="submit" class="btn btn-info" name="submit" value="提 交"></center><br>
</form>
<br>
<!--{template footer}-->