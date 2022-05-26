<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;编辑器设置&nbsp;&raquo;&nbsp;全局设置</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table class="table">
	<tr>
		<td class="{$type}">{$message}</td>
	</tr>
</table>
<!--{/if}-->
<form action="index.php?admin_editor/setting{$setting['seo_suffix']}" method="post">
	<table class="table">
		<tr class="header">
			<td colspan="2">
				UEditor全局设置&nbsp;&nbsp;&nbsp;

			</td>
		</tr>

		<tr>
			<td class="altbg1" width="45%"><b>编辑器功能定义：</b><br><span class="smalltxt">在编辑器功能管理可以手动调整， 'fullscreen', 'source', '|', 'undo', 'redo', '|',
            'bold', 'italic', 'underline', 'fontborder', 'strikethrough',  'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
            'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
            'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
             'indent', '|',
            'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|',
            'link', 'unlink', 'anchor',  '|',
            'simpleupload', 'insertimage', 'scrawl', 'insertvideo', 'attachment', 'map', 'insertcode',    '|',
            'horizontal',   '|',

            'preview', 'searchreplace', 'drafts'</span></td>
			<td class="altbg2"><textarea class="area" name="editor_toolbars"  style="height:200px;width:500px;">{$setting['editor_toolbars']}</textarea></td>
		</tr>
	</table>
	<br>
		<table class="table">
		<tr class="header">
			<td colspan="2">
				WangEditor全局设置&nbsp;&nbsp;&nbsp;

			</td>
		</tr>

		<tr>
			<td class="altbg1" width="45%"><b>编辑器功能定义：</b><br><span class="smalltxt">在编辑器功能管理可以手动调整，  'source',
        '|',
        'bold',
        'underline',
        'italic',
        'strikethrough',
        'eraser',
        'forecolor',
        'bgcolor',
        '|',
        'quote',
        'fontfamily',
        'fontsize',
        'head',
        'unorderlist',
        'orderlist',
        'alignleft',
        'aligncenter',
        'alignright',
        '|',
        'link',
        'unlink',
        'table',
        'emotion',
        '|',
        'img',
        'video',
        'location',
        'insertcode',
        '|',
        'undo',
        'redo',
        'fullscreen'</span></td>
			<td class="altbg2"><textarea class="area" name="editor_wtoolbars"  style="height:200px;width:500px;">{$setting['editor_wtoolbars']}</textarea></td>
		</tr>
			<tr>
					<td class="altbg1" width="45%"><b>PC端编辑器选择配置:</b><br><span class="smalltxt">根据需要选择合适的编辑器</span></td>
					<td class="altbg2">
						<input class="radio"   type="radio"  {if $setting['editor_choose']}checked{/if} value="1" name="editor_choose"><label for="blackyes">Ueditor</label>&nbsp;&nbsp;&nbsp;
						<input class="radio"   type="radio" {if !$setting['editor_choose']}checked{/if} value="0" name="editor_choose"><label for="blackno">WangEditor</label>
					</td>
				</tr>

	</table>
	<br>
	<center><input type="submit" class="button" name="submit" value="提 交"></center><br>
</form>
<fileset>
        <legend>UEditor-COMMAND列表</legend>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>命令</th>
                    <th>描述</th>
                </tr>
            </thead>
            <tbody>




                <tr>
                    <td>1</td>
                    <td><a href="#COMMAND::anchor">anchor</a></td>
                    <td>
                        插入锚点
                    </td>
                </tr>



                <tr>
                    <td>2</td>
                    <td><a href="#COMMAND::autosubmit">autosubmit</a></td>
                    <td>
                        提交表单
                    </td>
                </tr>



                <tr>
                    <td>3</td>
                    <td><a href="#COMMAND::autotypeset">autotypeset</a></td>
                    <td>
                        对当前编辑器的内容执行自动排版， 排版的行为根据config配置文件里的“autotypeset”选项进行控制。
                    </td>
                </tr>



                <tr>
                    <td>4</td>
                    <td><a href="#COMMAND::bold">bold</a></td>
                    <td>
                        字体加粗
                    </td>
                </tr>



                <tr>
                    <td>5</td>
                    <td><a href="#COMMAND::italic">italic</a></td>
                    <td>
                        字体倾斜
                    </td>
                </tr>



                <tr>
                    <td>6</td>
                    <td><a href="#COMMAND::subscript">subscript</a></td>
                    <td>
                        下标文本，与“superscript”命令互斥
                    </td>
                </tr>



                <tr>
                    <td>7</td>
                    <td><a href="#COMMAND::superscript">superscript</a></td>
                    <td>
                        上标文本，与“subscript”命令互斥
                    </td>
                </tr>



                <tr>
                    <td>8</td>
                    <td><a href="#COMMAND::blockquote">blockquote</a></td>
                    <td>
                        添加引用
                    </td>
                </tr>



                <tr>
                    <td>9</td>
                    <td><a href="#COMMAND::cleardoc">cleardoc</a></td>
                    <td>
                        清空文档
                    </td>
                </tr>



                <tr>
                    <td>10</td>
                    <td><a href="#COMMAND::touppercase">touppercase</a></td>
                    <td>
                        把选区内文本变大写，与“tolowercase”命令互斥
                    </td>
                </tr>



                <tr>
                    <td>11</td>
                    <td><a href="#COMMAND::tolowercase">tolowercase</a></td>
                    <td>
                        把选区内文本变小写，与“touppercase”命令互斥
                    </td>
                </tr>



                <tr>
                    <td>12</td>
                    <td><a href="#COMMAND::customstyle">customstyle</a></td>
                    <td>
                        根据config配置文件里“customstyle”选项的值对匹配的标签执行样式替换。
                    </td>
                </tr>



                <tr>
                    <td>13</td>
                    <td><a href="#COMMAND::directionality">directionality</a></td>
                    <td>
                        文字输入方向
                    </td>
                </tr>



                <tr>
                    <td>14</td>
                    <td><a href="#COMMAND::forecolor">forecolor</a></td>
                    <td>
                        字体颜色
                    </td>
                </tr>



                <tr>
                    <td>15</td>
                    <td><a href="#COMMAND::backcolor">backcolor</a></td>
                    <td>
                        字体背景颜色
                    </td>
                </tr>



                <tr>
                    <td>16</td>
                    <td><a href="#COMMAND::fontsize">fontsize</a></td>
                    <td>
                        字体大小
                    </td>
                </tr>



                <tr>
                    <td>17</td>
                    <td><a href="#COMMAND::fontfamily">fontfamily</a></td>
                    <td>
                        字体样式
                    </td>
                </tr>



                <tr>
                    <td>18</td>
                    <td><a href="#COMMAND::underline">underline</a></td>
                    <td>
                        字体下划线,与删除线互斥
                    </td>
                </tr>



                <tr>
                    <td>19</td>
                    <td><a href="#COMMAND::strikethrough">strikethrough</a></td>
                    <td>
                        字体删除线,与下划线互斥
                    </td>
                </tr>



                <tr>
                    <td>20</td>
                    <td><a href="#COMMAND::fontborder">fontborder</a></td>
                    <td>
                        字体边框
                    </td>
                </tr>



                <tr>
                    <td>21</td>
                    <td><a href="#COMMAND::formatmatch">formatmatch</a></td>
                    <td>
                        格式刷
                    </td>
                </tr>



                <tr>
                    <td>22</td>
                    <td><a href="#COMMAND::horizontal">horizontal</a></td>
                    <td>
                        插入分割线
                    </td>
                </tr>



                <tr>
                    <td>23</td>
                    <td><a href="#COMMAND::imagefloat">imagefloat</a></td>
                    <td>
                        图片对齐方式
                    </td>
                </tr>



                <tr>
                    <td>24</td>
                    <td><a href="#COMMAND::insertimage">insertimage</a></td>
                    <td>
                        插入图片
                    </td>
                </tr>



                <tr>
                    <td>25</td>
                    <td><a href="#COMMAND::indent">indent</a></td>
                    <td>
                        缩进
                    </td>
                </tr>



                <tr>
                    <td>26</td>
                    <td><a href="#COMMAND::insertcode">insertcode</a></td>
                    <td>
                        插入代码
                    </td>
                </tr>



                <tr>
                    <td>27</td>
                    <td><a href="#COMMAND::inserthtml">inserthtml</a></td>
                    <td>
                        插入html代码
                    </td>
                </tr>



                <tr>
                    <td>28</td>
                    <td><a href="#COMMAND::insertparagraph">insertparagraph</a></td>
                    <td>
                        插入段落
                    </td>
                </tr>



                <tr>
                    <td>29</td>
                    <td><a href="#COMMAND::justify">justify</a></td>
                    <td>
                        段落对齐方式
                    </td>
                </tr>



                <tr>
                    <td>30</td>
                    <td><a href="#COMMAND::lineheight">lineheight</a></td>
                    <td>
                        行距
                    </td>
                </tr>



                <tr>
                    <td>31</td>
                    <td><a href="#COMMAND::link">link</a></td>
                    <td>
                        插入超链接
                    </td>
                </tr>



                <tr>
                    <td>32</td>
                    <td><a href="#COMMAND::unlink">unlink</a></td>
                    <td>
                        取消超链接
                    </td>
                </tr>



                <tr>
                    <td>33</td>
                    <td><a href="#COMMAND::insertorderedlist">insertorderedlist</a></td>
                    <td>
                        有序列表，与“insertunorderedlist”命令互斥
                    </td>
                </tr>



                <tr>
                    <td>34</td>
                    <td><a href="#COMMAND::insertunorderedlist">insertunorderedlist</a></td>
                    <td>
                        无序列表，与“insertorderedlist”命令互斥
                    </td>
                </tr>



                <tr>
                    <td>35</td>
                    <td><a href="#COMMAND::music">music</a></td>
                    <td>
                        插入音乐
                    </td>
                </tr>



                <tr>
                    <td>36</td>
                    <td><a href="#COMMAND::pagebreak">pagebreak</a></td>
                    <td>
                        插入分页符
                    </td>
                </tr>



                <tr>
                    <td>37</td>
                    <td><a href="#COMMAND::paragraph">paragraph</a></td>
                    <td>
                        段落格式
                    </td>
                </tr>



                <tr>
                    <td>38</td>
                    <td><a href="#COMMAND::preview">preview</a></td>
                    <td>
                        预览
                    </td>
                </tr>



                <tr>
                    <td>39</td>
                    <td><a href="#COMMAND::print">print</a></td>
                    <td>
                        打印
                    </td>
                </tr>



                <tr>
                    <td>40</td>
                    <td><a href="#COMMAND::pasteplain">pasteplain</a></td>
                    <td>
                        启用或取消纯文本粘贴模式
                    </td>
                </tr>



                <tr>
                    <td>41</td>
                    <td><a href="#COMMAND::removeformat">removeformat</a></td>
                    <td>
                        清除文字样式
                    </td>
                </tr>



                <tr>
                    <td>42</td>
                    <td><a href="#COMMAND::rowspacing">rowspacing</a></td>
                    <td>
                        设置段间距
                    </td>
                </tr>



                <tr>
                    <td>43</td>
                    <td><a href="#COMMAND::selectall">selectall</a></td>
                    <td>
                        选中所有内容
                    </td>
                </tr>



                <tr>
                    <td>44</td>
                    <td><a href="#COMMAND::source">source</a></td>
                    <td>
                        切换源码模式和编辑模式
                    </td>
                </tr>



                <tr>
                    <td>45</td>
                    <td><a href="#COMMAND::time">time</a></td>
                    <td>
                        插入时间，默认格式：12:59:59
                    </td>
                </tr>



                <tr>
                    <td>46</td>
                    <td><a href="#COMMAND::date">date</a></td>
                    <td>
                        插入日期，默认格式：2013-08-30
                    </td>
                </tr>



                <tr>
                    <td>47</td>
                    <td><a href="#COMMAND::undo">undo</a></td>
                    <td>
                        撤销上一次执行的命令
                    </td>
                </tr>



                <tr>
                    <td>48</td>
                    <td><a href="#COMMAND::redo">redo</a></td>
                    <td>
                        重做上一次执行的命令
                    </td>
                </tr>



                <tr>
                    <td>49</td>
                    <td><a href="#COMMAND::insertvideo">insertvideo</a></td>
                    <td>
                        插入视频
                    </td>
                </tr>



                <tr>
                    <td>50</td>
                    <td><a href="#COMMAND::webapp">webapp</a></td>
                    <td>
                        插入百度应用
                    </td>
                </tr>

            </tbody>
        </table>
    </fileset>
<br>
<!--{template footer}-->