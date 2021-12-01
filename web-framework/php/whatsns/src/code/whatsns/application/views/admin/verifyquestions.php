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
        <tr class="header"><td colspan="7">问题审核&nbsp;&nbsp;&nbsp;<input type="button" value="回答审核" onclick="document.location.href='index.php?admin_question/examineanswer.html'" style="cursor:pointer"></td></tr>
        <tr class="altbg1"><td colspan="7">问题通过审核之后才会显示在问答系统前台</td></tr>
    </tbody>
</table>
[共 <font color="green">{$rownum}</font> 个问题]
<form name="questionlist" method="post">
    <table class="table">
        <tr class="header">
            <td width="5%"><input class="checkbox" value="chkall" id="chkall" onclick="checkall('qid[]')" type="checkbox" name="chkall"><label for="chkall">全选</label></td>
            <td  width="90%" style="text-align:center;">内容</td>
        </tr>
        <!--{loop $questionlist $question}-->
        <tr>
            <td class="altbg2"><input class="checkbox" type="checkbox" value="{$question['id']}" name="qid[]"></td>
            <td class="altbg2">
                <a  href="index.php?question/view/{$question['id']}{$setting['seo_suffix']}" target="_blank"><strong>{$question['title']}</strong></a>
                <div>作者：<a href="index.php?user/space/$question['authorid']" target="_blank">{$question['author']}</a>&nbsp;&nbsp;时间：{$question['format_time']}&nbsp;&nbsp;IP:{$question['ip']}</div>
                <div style= "OVERFLOW-Y:auto;max-height:100px;">{$question['description']}</div>
            </td>
        </tr>
        <!--{/loop}-->
      <!--{if $departstr}-->
        <tr class="smalltxt">
            <td class="altbg2" colspan="6" align="right"><div class="scott">{$departstr}</div></td>
        </tr>
        <!--{/if}-->
        <tr>
            <td colspan="6" class="altbg1"><input class="btn btn-success" type="button" value="通过" onclick="verify()"/>&nbsp;&nbsp;&nbsp;<input class="btn" type="button" name="delete" value="删除" onclick="deleteanswer();" /></td>
        </tr>
    </table>
</form>
<!--{template footer}-->
<script type="text/javascript">
    function deleteanswer(){
        if($("input[name='qid[]']:checked").length == 0){
            alert('你没有选择任何问题');
            return false;
        }
        if(confirm('确定删除问题?')==false){
            return false;
        }
        document.questionlist.action="index.php?admin_question/delete{$setting['seo_suffix']}";
        document.questionlist.submit();
    }

    function verify(){
        if($("input[name='qid[]']:checked").length == 0){
            alert('你没有选择任何问题');
            return false;
        }
        document.questionlist.action="index.php?admin_question/verify{$setting['seo_suffix']}";
        document.questionlist.submit();
    }
</script>


