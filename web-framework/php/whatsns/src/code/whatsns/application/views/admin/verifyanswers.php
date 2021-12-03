<!--{template header}-->
<div id="append">
</div>
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;审核问题</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table class="table">
    <tr>
        <td class="{$type}">{$message}</td>
    </tr>
</table>
<!--{/if}-->
<table class="table">
    <tbody>
        <tr class="header"><td colspan="7"><input type="button" value="问题审核" onclick="document.location.href='index.php?admin_question/examine{$setting['seo_suffix']}'" style="cursor:pointer">&nbsp;&nbsp;&nbsp;回答审核</td></tr>
        <tr class="altbg1"><td colspan="7">回答通过审核之后才会显示前台问题中</td></tr>
    </tbody>
</table>
[共 <font color="green">{$rownum}</font> 个回答]
<form name="answerlist" method="post">
    <table class="table">
        <tr class="header">
            <td width="5%"><input class="checkbox" value="chkall" id="chkall" onclick="checkall('aid[]')" type="checkbox" name="chkall"><label for="chkall">全选</label></td>
            <td  width="90%" style="text-align:center;">内容</td>
        </tr>
        <!--{loop $answerlist $answer}-->
        <tr>
            <td class="altbg2"><input class="checkbox" type="checkbox" value="{$answer['id']}" name="aid[]"></td>
            <td class="altbg2" id="title_{$answer['id']}">
                <a  href="index.php?question/view/{$answer['qid']}{$setting['seo_suffix']}" target="_blank"><strong>{$answer['title']}</strong></a>
                <div>作者：<a href="index.php?user/space/$question['authorid']" target="_blank">{$answer['author']}</a>&nbsp;&nbsp;时间：{$answer['time']}&nbsp;&nbsp;IP:{$answer['ip']}</div>
                <div style= "OVERFLOW-Y:auto;max-height:100px;">{$answer['content']}</div></td>
        </tr>
        <!--{/loop}-->
        <!--{if $departstr}-->
        <tr class="smalltxt">
            <td class="altbg1" colspan="6" align="right"><div class="scott">{$departstr}</div></td>
        </tr>
        <!--{/if}-->
        <tr>
            <td colspan="6" class="altbg1"><input class="btn btn-success" type="button" value="通过" onclick="verify()"/>&nbsp;&nbsp;&nbsp;<input class="btn btn-success" type="button" name="delete" value="删除" onclick="deleteanswer();" /></td>
        </tr>
    </table>
</form>
<!--{template footer}-->
<script type="text/javascript">
    function deleteanswer(){
        if($("input[name='aid[]']:checked").length == 0){
            alert('你没有选择任何问题');
            return false;
        }
        if(confirm('确定删除问题?')==false){
            return false;
        }
        document.answerlist.action="index.php?admin_question/deleteanswer{$setting['seo_suffix']}";
        document.answerlist.submit();
    }

    function verify(){
        if($("input[name='aid[]']:checked").length == 0){
            alert('你没有选择任何问题');
            return false;
        }
        document.answerlist.action="index.php?admin_question/verifyanswer{$setting['seo_suffix']}";
        document.answerlist.submit();
    }
</script>


