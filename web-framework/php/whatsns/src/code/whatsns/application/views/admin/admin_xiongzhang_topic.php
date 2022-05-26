<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;文章管理</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->

<div class="alert alert-success">{$message}</div>
<!--{/if}-->
<a href="{SITE_URL}index.php?admin_xiongzhang/index{$setting['seo_suffix']}" class="btn btn-danger">问题熊掌号推送</a>
&nbsp;&nbsp;<a href="{SITE_URL}index.php?admin_xiongzhang/topiclist{$setting['seo_suffix']}" class="btn btn-danger">文章熊掌号推送</a>
&nbsp;&nbsp;<a href="{SITE_URL}index.php?admin_xiongzhang/taglist{$setting['seo_suffix']}" class="btn btn-danger">标签熊掌号推送</a>

<form action="index.php?admin_xiongzhang/apiset{$setting['seo_suffix']}" method="post">
    <table class="table">
        <tbody>
            <tr class="header" ><td colspan="4"><h1>api推送配置</h1></td></tr>
                <tr><td colspan="4">
            <a class="btn" target="_blank" style="background:#3280fc " href="https://www.ask2.cn/article-15516.html">点击查看熊掌号参数配置教程（详情）</a>
            
            </td></tr>
            <tr class="altbg1"><td colspan="4">配置最新和历史推送api</td></tr>
            <tr>
               <td  width="200" class="altbg2">APPID:<input class="txt form-control" placeholder="搜索结果出图中的APPID" name="xiongzhang_appid" value="{$setting['xiongzhang_appid']}" ></td>
              
                <td width="200"  class="altbg2">新增内容接口:<input class="txt form-control" placeholder="新增内容接口不能为空" name="newcontent" value="{$setting['xiongzhang_settingnewapi']}" ></td>
                <td  width="200" class="altbg2">历史内容接口:<input class="txt form-control" placeholder="历史内容接口不能为空" name="historycontent" value="{$setting['xiongzhang_settinghistoryapi']}" ></td>
                <td  width="200" class="altbg2">每页推送数量设置:<input class="txt form-control" placeholder="推送列表页面数量" name="xiongzhang_tuisongnum" value="{$setting['xiongzhang_tuisongnum']}" ></td>
              

            </tr>
          
            <tr>
              <td  rowspan="2" class="altbg2"><input name="submit" class="btn btn-info" type="submit" value="应用配置"></td>
              </tr>
        </tbody>
    </table>
</form>
[共 <font color="green">{$rownum}</font> 个文章]
<form name="queslist" method="POST">
    <table class="table">
        <tr class="altbg1">
            <td colspan="9">
             <input name="ctrlcase" class="btn" type="button" onClick="buttoncontrol(1);" value="新增内容推送">&nbsp;&nbsp;&nbsp;
                <input name="ctrlcase" class="btn" type="button" onClick="buttoncontrol(2);" value="历史内容推送">&nbsp;&nbsp;&nbsp;
            
            </td>
        </tr>
             <tr class="smalltxt">
            <td class="altbg2" colspan="9" align="right"><div class="pages">{$departstr}</div></td>
        </tr>
        
        <tr class="header">
            <td width="5%"><input class="checkbox" value="chkall" id="chkall" onclick="checkall('qid[]')" type="checkbox" name="chkall"><label for="chkall">全选</label></td>
          <td  width="10%">博客作者</td>

            <td width="20%">博客名称</td>

       <td width="10%">访问量</td>
        </tr>
        <!--{loop $topiclist $topic}-->
        <tr  class="smalltxt">

                         <td class="altbg2">
                <input class="checkbox" type="checkbox" value="{$topic['id']}" name="qid[]" >
            </td>
                                      <td width="10%" class="altbg2">
                                      <strong>{$topic['author']}</strong></td>

                    <td width="20%" class="altbg2"><input name="order[]" type="hidden" value="{$topic['id']}"/><strong><a target="_blank" href="{url topic/getone/$topic['id']}">
                    {if $topic['state']==0}<label class="label label-warning">等待审核</label>{/if}{$topic['title']}
                    </a></strong></td>
 <td width="10%">{$topic['views']}次</td>
                      
                </tr>
         
  
        <!--{/loop}-->
 

        <tr class="smalltxt">
            <td class="altbg2" colspan="9" align="right"><div class="pages">{$departstr}</div></td>
        </tr>

        <tr class="altbg1">
            <td colspan="9">
             <input name="ctrlcase" class="btn" type="button" onClick="buttoncontrol(1);" value="新增内容推送">&nbsp;&nbsp;&nbsp;
                <input name="ctrlcase" class="btn" type="button" onClick="buttoncontrol(2);" value="历史内容推送">&nbsp;&nbsp;&nbsp;
            
            </td>
        </tr>
    </table>
</form>
<div class="alert  alert-warning">推送前请先配置好推送接口，网站域名和熊掌号绑定域名一致，否则推送无效</div>
、

<script type="text/javascript">

    function buttoncontrol(num) {
        if ($("input[name='qid[]']:checked").length == 0) {
            alert('你没有选择任何要操作的文章！');
            return false;
        } else {
            switch (num) {
            case 1:
        

         
            		 document.queslist.action = "index.php?admin_xiongzhang/topicnewtui{$setting['seo_suffix']}";
                     document.queslist.submit();
           

                break;
            case 2:
                

                
       		 document.queslist.action = "index.php?admin_xiongzhang/topichistorytui{$setting['seo_suffix']}";
                document.queslist.submit();
      

           break; 
            }
        }
    }
    

</script>

<!--{template footer}-->
