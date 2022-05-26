<!--{template header}-->
<div id="append">
</div>
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;回答管理</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table cellspacing="1" cellpadding="4" width="100%" align="center" class="tableborder">
    <tr>
        <td class="{$type}">{$message}</td>
    </tr>
</table>
<!--{/if}-->
<form action="index.php?admin_question/searchanswer{$setting['seo_suffix']}" method="post">
    <table class="table">
        <tbody>
            <tr class="header" ><td colspan="4">回答搜索</td></tr>
            <tr class="altbg1"><td colspan="4">可以通过如下搜索条件，检索问题回答</td></tr>
            <tr>
                <td width="200"  class="altbg2">标题:<input class="form-control shortinput" type="text" name="srchtitle" value="{$srchtitle}"   data-toggle="tooltip" data-placement="top" title="" data-original-title="关键词就行，没必要精确输入"/></td>
                <td  width="200" class="altbg2">回答者:<input  class="form-control shortinput"  type="text" name="srchauthor" value="{$srchauthor}"/></td>
                <td  width="250" class="altbg2">关键字:	<input  class="form-control shortinput"  type="text" name="keywords" size="30" maxlength="50" value="{$keywords}"/></td>

            </tr>
            <tr>




             <td width="20%" ><label >
 注册日期:</label>
             <div class="input-group date form-date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
            <input class="form-control" size="16" id="timestart" name="srchdatestart" value="{$srchdatestart}"  readonly="">
            <span class="input-group-addon"><span class="icon-remove"></span></span>
            <span class="input-group-addon"><span class="icon-calendar"></span></span>
          </div>
             </td>
              <td width="20%" >
               <label>
  到</label>
               <div class="input-group date form-date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
            <input class="form-control" size="16"  id="timeend" name="srchdateend" value="{$srchdateend}" readonly="">
            <span class="input-group-addon"><span class="icon-remove"></span></span>
            <span class="input-group-addon"><span class="icon-calendar"></span></span>
          </div>
              </td>


            </tr>
            <tr>
             <td rowspan="3" class="altbg2"><br><input class="btn" type="submit" value="提 交"></td>
            </tr>
        </tbody>
    </table>
</form>
[共 <font color="green">{$rownum}</font> 条回答]
<form name="answerlist" method="post">
    <table class="table">
        <tr class="header">
            <td width="7%"><input class="checkbox" value="chkall" id="chkall" onclick="checkall('aid[]')" type="checkbox" name="chkall"><label for="chkall">全选</label></td>
            <td  width="40%">回答内容</td>
            <td  width="10%">回答人</td>
            <td  width="13%">回答时间</td>
            <td  width="14%">IP</td>
            <td  width="6%">已采纳</td>
              <td  width="6%">编辑</td>
        </tr>
        <!--{if isset($answerlist)} {loop $answerlist $answer}-->
        <tr>
            <!--{eval $content=htmlspecialchars($answer['content']);}-->
            <td class="altbg2"><input class="checkbox" type="checkbox" value="{$answer['id']}" name="aid[]"></td>
            <td class="altbg2" id="title_{$answer['id']}">
                <a  href="{url question/view/$answer['qid']}" target="_blank"><strong>{$answer['title']}{if !empty($answer['isimg'])&&$answer['isimg']!=''}<label class="label label-success">$answer['isimg']</label>{/if}</strong></a>
                <div style= "WIDTH:550px;OVERFLOW-Y:auto;height:100px"> {eval echo clearhtml($answer['content'],200);}</div>
            </td>
            <td class="altbg2"><a href="{user/space/$answer['authorid']}" target="_blank">{$answer['author']}</a></td>
            <td class="altbg2">{$answer['time']}</td>
            <td class="altbg2">{$answer['ip']}</td>
           
            <td class="altbg2">{if $answer['adopttime']}<img title="已被采纳为最佳答案" src="{SITE_URL}static/css/admin/icn_2.gif">{else}否{/if}</td>
        <td class="altbg2"><a target="_blank" href="{url question/editanswer/$answer['id']}">编辑回答</a></td>
        </tr>
        <!--{/loop} {/if}-->
           <!--{if $departstr}-->
        <tr class="smalltxt">
            <td class="altbg2" colspan="9" align="right"><div class="pages">{$departstr}</div></td>
        </tr>
        <!--{/if}-->
        <tr>
            <td colspan="6" class="altbg1"><input class="btn" type="button" name="delete" value="删除" onclick="deleteanswer();" /></td>
        </tr>
    </table>
</form>

  <link href="{SITE_URL}static/css/dist/lib/datetimepicker/datetimepicker.min.css" rel="stylesheet">
  <script src="{SITE_URL}static/css/dist/lib/datetimepicker/datetimepicker.min.js"></script>
<script type="text/javascript">
$(".form-date").datetimepicker(
	    {
	        language:  "zh-CN",
	        weekStart: 1,
	        todayBtn:  1,
	        autoclose: 1,
	        todayHighlight: 1,
	        startView: 2,
	        minView: 2,
	        forceParse: 0,
	        format: "yyyy-mm-dd"
	    });
    function deleteanswer(){
        if($("input[name='aid[]']:checked").length == 0){
            alert('你没有选择任何回答');
            return false;
        }
        if(confirm('确定删除回答?')==false){
            return false;
        }
        document.answerlist.action="index.php?admin_question/deleteanswer{$setting['seo_suffix']}";
        document.answerlist.submit();
    }
</script>
<!--{template footer}-->


