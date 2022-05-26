<!--{template header}-->

          <TABLE class="table" >
              <TBODY>
	              <TR>
	                <TD style="PADDING-LEFT: 20px">第一次使用：请看&nbsp;&nbsp;[&nbsp;<A style="COLOR: red" target="_blank" href="http://www.ask2.cn/note/view/8.html"><U>新手上路向导</U></A>&nbsp;]</TD>
	                <TD>程序版本：ask2{ASK2_VERSION} Release {ASK2_RELEASE}[<A target="_blank"  href="http://www.ask2.cn/note/list.html"><B>检查更新</B></A>]</TD>
	              </TR>
	              <TR>
	                <TD style="PADDING-LEFT: 20px">操作系统及 PHP:{$serverinfo}</TD>
	                <TD>服务器软件:{$_SERVER['SERVER_SOFTWARE']}</TD>
	              </TR>
	              <TR>
	                <TD style="PADDING-LEFT: 20px">MySQL 版本:{$dbversion}</TD>
	                <TD>上传许可:{$fileupload}</TD>
	              </TR>
	              <TR>
	                <TD style="PADDING-LEFT: 20px">当前数据库尺寸:{$dbsize}</TD>
	                <TD>主机名:$_SERVER['SERVER_NAME'] ($_SERVER['SERVER_ADDR']:$_SERVER['SERVER_PORT']) </TD>
	              </TR>
	              <TR>
	                <TD style="PADDING-LEFT: 20px">magic_quote_gpc:{$magic_quote_gpc}</TD>
	                <TD>allow_url_fopen:{$allow_url_fopen} </TD>
	              </TR>
	              </TBODY>
            </TABLE>
            <!--{if $verifyquestions||$verifyanswers }-->
            <h3 style="color:#E14300;">待处理事项:&nbsp;&nbsp;
            <span style="font-size:12px;font-weight:normal">
            <a href="index.php?admin_question/examine{$setting['seo_suffix']}">等待审核的问题数：(<font color="red">{$verifyquestions}</font>)</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="index.php?admin_question/examineanswer{$setting['seo_suffix']}">等待审核的回答数：(<font color="red">{$verifyanswers}</font>)</a>
            </span>
            </h3>
            <!--{/if}-->
            <!--最新动态-->
            <TABLE class="table" >
              <TBODY>
              <TR class="header"><TD colSpan="12"> <DIV class="NavaL ndt">开发团队</DIV></TD></TR>
              <TR class="altbg2"><TD>版权所有:<a href="http://www.ask2.cn/" target="_blank">ask2问答系统</a></TD></TR>
              <TR class="altbg2"><TD>总策划兼项目经理:<a href="mailto:617035918@qq.com" target="_blank">小米</a></TD></TR>
              <TR class="altbg2"><TD>开发团队:<a href="mailto:vip_ask2@163.com" target="_blank">小米工作室</a></TD></TR>
              <TR class="altbg2"><TD>官方网站:<a href="http://www.ask2.cn/" target="_blank">http://www.ask2.cn/</a></TD></TR>
             </TBODY>
            </TABLE>
            <DIV class="c"></DIV>
            <TABLE class="table" >
              <TBODY>
              <TR class="header">
                <TD colSpan="3">ask2问答系统官方链接</TD></TR>
              <TR class="altbg2">
                <TD><A href="http://www.ask2.cn" target="_blank">问题求助</A></TD>
                <TD><A href="http://www.ask2.cn/download.html" target="_blank">源码下载</A></TD>
                <TD><A href="http://www.ask2.cn/buy.html" target="_blank">我要购买企业版</A></TD>
              </TR>
              </TBODY>
            </TABLE>
<!--{template footer}-->