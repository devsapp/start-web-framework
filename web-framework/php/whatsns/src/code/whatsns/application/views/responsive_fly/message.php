<!--{template header}-->

<div class="layui-container fly-marginTop fly-user-main">
{template user_menu}
 <div class="fly-panel fly-panel-user" pad20>
{template message_nav}
	  <div class="layui-tab layui-tab-brief" lay-filter="user" id="LAY_msg" style="margin-top: 15px;">
	   <a onclick="if(confirm('是否清空？') window.location.href='{url message/updateunread}';" class="layui-btn layui-btn-danger" id="LAY_delallmsg">清空全部消息</a>
	    <a href="{url message/sendmessage}" class="layui-btn">写信息</a>
	    <div  id="LAY_minemsg" style="margin-top: 10px;">
        <!--<div class="fly-none">您暂时没有最新消息</div>-->
        <ul class="mine-msg">
              <!--{loop $messagelist $message}-->
          <li data-id="{$message['id']}">
          <div class="mar-b10"><span class="layui-badge layui-bg-blue">{$message['text']}</span><!--{if $message['new']==1}-->
                                       <span class="layui-badge">新</span>
                                                <!--{/if}--></div>
            <blockquote class="layui-elem-quote">
      {$message['content']}
            </blockquote>
            <p><span>{$message['format_time']}</span>{if $type!='system'}<a href="{url message/view/$type/$message[fromuid]/$message['id']}" class="layui-btn   layui-btn-sm">查看详情</a>{/if} <div href="javascript:;" class="" style="height:20px;"></div></p>
          </li>
      	  <!--{/loop}-->
        </ul>
        {template page}
      </div>
	  </div>
	</div>

</div>
<!--{template footer}-->