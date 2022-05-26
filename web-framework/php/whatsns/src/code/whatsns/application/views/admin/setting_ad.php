<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="admin.php?mod=index&amp;code=home"><b>控制面板首页</b></a>&nbsp;»&nbsp;广告管理</div>
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
        <tr class="header">
            <td><div style="float:left; margin-left:0px; padding-top:8px"> <a onclick="collapse_change('tip')" href="#">技巧提示</a></div>
                <div style="float:right; margin-right:4px; padding-bottom:9px"> </div></td>
        </tr>
    </tbody>
    <tbody>
        <tr>
            <td><ul>
                    <li><b>强烈建议</b>：在搜索引擎未收录网站前，不要添加广告，否则影响收录；</li>
                    <li>系统主要是在问题、分类查看页面添加了广告模块，其他页面如果也需添加可以自己仿照模板源文件添加即可。</li>
                    <li>广告代码支持html代码（包括JS代码）。比如，要加入图片广告的话，填入的代码一般为&lt;a href="xxx"&gt;&lt;img src="http://xxx.com/xxx.gif"&gt;&lt;/a&gt;</li>
                    <li style="color:green;">对于各页面广告位不清楚的可以直接点击右上角的查看广告位布局</li>
                    <li>如果想禁用某个位置的广告只需，广告设置的时候留空就行了</li>
                    <li>广告位设置根据目标来定，不应用到模板每个位置</li>
                </ul></td>
        </tr>
    </tbody></table>
<br>
<form enctype="multipart/form-data" action="index.php?admin_setting/ad{$setting['seo_suffix']}" method="post">
    <br>
    <table class="table">
        <tbody>
            <tr class="header">
                <td colspan="2"><span class="smalltxt"><a href="{SITE_URL}static/css/admin/index_ad.jpg" style="float:right;margin-top:10px;color:green" target="_blank">查看广告位布局</a></span>网站首页</td>
            </tr>
            <tr align="center">
                <td class="altbg2">中间-广告位1<br>
                    (最大宽度:469px)<br>
                <td class="altbg1"><textarea id="index_middle1" position="header" cols="100" rows="5" name="ad[index][middle1]">{if isset($adlist['index']['middle1'])}$adlist['index']['middle1']{/if}</textarea>
                </td>
            </tr>
            <tr align="center">
                <td class="altbg2">中间-广告位2<br>
                    (最大宽度:469px)<br>
                <td class="altbg1"><textarea id="index_middle2" position="middle_right" cols="100" rows="5" name="ad[index][middle2]">{if isset($adlist['index']['middle2'])}$adlist['index']['middle2']{/if}</textarea>
                </td>
            </tr>
            <tr align="center">
                <td class="altbg2">右边-广告位3<br>
                    (最大宽度:250px)<br>
                <td class="altbg1"><textarea id="index_right1" position="footer" cols="100" rows="5" name="ad[index][right1]">{if isset($adlist['index']['right1'])}$adlist['index']['right1']{/if}</textarea>
                </td>
            </tr>
            <tr align="center">
                <td class="altbg2">右边-广告位4<br>
                    (最大宽度:250px)<br>
                <td class="altbg1"><textarea id="index_right2" position="footer" cols="100" rows="5" name="ad[index][right2]">{if isset($adlist['index']['right2'])}$adlist['index']['right2']{/if}</textarea>
                </td>
            </tr>
        </tbody>
    </table>
    <center>
        <input type="submit" value="提 交" name="submit" class="button">
    </center>
    <br>
    <table class="table">
        <tbody>
            <tr class="header">
                <td colspan="2"><span class="smalltxt"><a href="{SITE_URL}static/css/admin/question_view.jpg" style="float:right;margin-top:10px;color:green" target="_blank">查看广告位布局</a></span>问题查看页（待解决、已解决、已关闭）</td>
            </tr>
            <tr align="center">
                <td class="altbg2">问题里面-广告位1<br>
                <td class="altbg1"><textarea id="question_view_inner1" position="header" cols="100" rows="5" name="ad[question_view][inner1]">{if isset($adlist['question_view']['inner1'])}$adlist['question_view']['inner1']{/if}</textarea>
                </td>
            </tr>
            <tr align="center">
                <td class="altbg2">左边-广告位2<br>
                <td class="altbg1"><textarea id="question_view_left1" position="middle_right" cols="100" rows="5" name="ad[question_view][left1]">{if isset($adlist['question_view']['left1'])}$adlist['question_view']['left1']{/if}</textarea>
                </td>
            </tr>
            <tr align="center">
                <td class="altbg2">左边-广告位3<br>
                <td class="altbg1"><textarea id="question_view_left2" position="footer" cols="100" rows="5" name="ad[question_view][left2]">{if isset($adlist['question_view']['left2'])}$adlist['question_view']['left2']{/if}</textarea>
                </td>
            </tr>
            <tr align="center">
                <td class="altbg2">右边-广告位4<br>
                <td class="altbg1"><textarea id="question_view_right1" position="footer" cols="100" rows="5" name="ad[question_view][right1]">{if isset($adlist['question_view']['right1'])}$adlist['question_view']['right1']{/if}</textarea>
                </td>
            </tr>
            <tr align="center">
                <td class="altbg2">右边-广告位5<br>
                <td class="altbg1"><textarea id="question_view_right2" position="footer" cols="100" rows="5" name="ad[question_view][right2]">{if isset($adlist['question_view']['right2'])}$adlist['question_view']['right2']{/if}</textarea>
                </td>
            </tr>
        </tbody>
    </table>
    <center>
        <input type="submit" value="提 交" name="submit" class="button">
    </center>
    <br>
    <table class="table">
        <tbody>
            <tr class="header">
                <td colspan="2"><span class="smalltxt"><a href="{SITE_URL}static/css/admin/category.jpg" style="float:right;margin-top:10px;color:green" target="_blank">查看广告位布局</a></span>分类浏览页</td>
            </tr>
            <tr align="center">
                <td class="altbg2">左边-广告位1<br>
                <td class="altbg1"><textarea id="category_left1" position="header" cols="100" rows="5" name="ad[category][left1]">{if isset($adlist['category']['left1'])}$adlist['category']['left1']{/if}</textarea>
                </td>
            </tr>
            <tr align="center">
                <td class="altbg2">右边-广告位1<br>
                <td class="altbg1"><textarea id="category_right1" position="middle_right" cols="100" rows="5" name="ad[category][right1]">{if isset($adlist['category']['right1'])}$adlist['category']['right1']{/if}</textarea>
                </td>
            </tr>
        </tbody>
    </table>
    <center>
        <input type="submit" value="提 交" name="submit" class="button">
    </center>

</form>
<!--{template footer}-->