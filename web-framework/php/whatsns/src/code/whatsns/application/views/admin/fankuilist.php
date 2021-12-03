<!--{template header,admin}-->
<div>
<div style="width:100%; color:#000;margin:0px 0px 10px;">
    <div >
    <ol class="breadcrumb">
  <li><a href="{url admin_main/stat}">后台首页</a></li>
  <li class="active">{$navtitle}</li>
</ol>

</div>
<div style="padding:8px;">
<div class="alert alert-warning">
<p><strong>提示:</strong></p>
<p>后台最多加载最新的50条反馈记录，如需看更多反馈记录去官网(www.whatsns.com)个人中心查看</p>
</div>

<table class="table" >
  <thead>
    <tr>
   
      <th>标题</th>
      <th>反馈时间</th>
      <th>查看详情</th>
    </tr>
  </thead>
  <tbody>
  {loop $questionlist $question}
    <tr>
 <td>{$question['subject']}{if $question['isnew']}<label class="label">新回复</label>{/if}</td>
  <td>{$question['pubtime']}</td>
    <td><a target="_blank" href="{url admin_fankui/view/$question['onlyid']}" class="btn btn-info btn-mini">查看详情</a></td>
</tr>

           {/loop}
       </tbody>      
</table>
<div class="alert">
<p><strong>提示:</strong></p>
<p>您暂无反馈的问题</p>
</div>
 </div>
               
<!--{template footer,admin}-->
    </div>

  </div>


