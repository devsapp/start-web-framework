<!--{template header}-->
<div id="append">
</div>
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;审核文章评论</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<div class="alert alert-warning">{$message}</div>
<!--{/if}-->
   <a class="btn write-btn btn-success" href="{url admin_topic}">
            返回文章列表
        </a>
                <a class="btn write-btn btn-success"  href="{url admin_topic/shenhe}">
            <i class="fa fa-check"></i>文章审核
        </a>
            <a class="btn write-btn btn-success"  href="{url admin_topic/vertifycomments}">
            <i class="fa fa-check"></i>文章评论审核
        </a>
        <br>
<div class="alert alert-success" style="margin-top:20px">[共 <b color="red">{$rownum}</b> 个文章评论]</div>
<form name="answerlist" method="post">
    <table class="table">
        <tr class="header">
            <td width="5%"><input class="checkbox" value="chkall" id="chkall" onclick="checkall('aid[]')" type="checkbox" name="chkall"><label for="chkall">全选</label></td>
            <td  width="90%" style="text-align:center;">内容</td>
        </tr>
        <!--{loop $commentlist $comment}-->
        <tr>
            <td class="altbg2"><input class="checkbox" type="checkbox" value="{$comment['id']}" name="aid[]"></td>
            <td class="altbg2" id="title_{$comment['id']}">
                <a  href="index.php?topic/getone/{$comment['tid']}{$setting['seo_suffix']}" target="_blank"><strong>{$comment['title']}</strong></a>
                <div>评论人：<a href="index.php?user/space/$comment['authorid']" target="_blank">{$comment['author']}</a>&nbsp;&nbsp;时间：{$comment['time']}&nbsp;&nbsp;IP:{$comment['ip']}</div>
                <div style= "OVERFLOW-Y:auto;max-height:100px;">{$comment['content']}</div></td>
        </tr>
        <!--{/loop}-->
        <!--{if $departstr}-->
        <tr class="smalltxt">
            <td class="altbg1" colspan="6" align="right"><div class="scott">{$departstr}</div></td>
        </tr>
        <!--{/if}-->
        <tr>
            <td colspan="6" class="altbg1"><input class="btn btn-success" type="button" value="通过" onclick="verify()"/>&nbsp;&nbsp;&nbsp;<input class="btn btn-success" type="button" name="delete" value="删除" onclick="deletecomment();" /></td>
        </tr>
    </table>
</form>
<!--{template footer}-->
<script type="text/javascript">
    function deletecomment(){
        if($("input[name='aid[]']:checked").length == 0){
            alert('你没有选择任何文章评论');
            return false;
        }
        if(confirm('确定删除评论?')==false){
            return false;
        }
        document.answerlist.action="index.php?admin_topic/deletecomment{$setting['seo_suffix']}";
        document.answerlist.submit();
    }

    function verify(){
        if($("input[name='aid[]']:checked").length == 0){
            alert('你没有选择任何文章评论');
            return false;
        }
        document.answerlist.action="index.php?admin_topic/verifycomment{$setting['seo_suffix']}";
        document.answerlist.submit();
    }
</script>


