<!--{template header}-->
<script type="text/javascript">
    function checkform() {
        var title = document.askform.title.value;
        if ('' == title) {
            alert('请填写调用名称!');
            return false;
        }
        return true;
    }
</script>
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;添加数据调用</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table class="table">
    <tr>
        <td class="{$type}">{$message}</td>
    </tr>
</table>
<!--{/if}-->
<form name="askform" action="index.php?admin_datacall/edit{$setting['seo_suffix']}" method="post" onsubmit="return checkform();">
    <input type="hidden" name="selectcid1" id="selectcid1" value="{$cid1}" />
    <input type="hidden" name="selectcid2" id="selectcid2" value="{$cid2}" />
    <input type="hidden" name="selectcid3" id="selectcid3" value="{$cid3}" />
    <table class="table">
        <tr>
            <td class="altbg1" width="45%"><b>调用名称:</b><br><span class="smalltxt">数据调用名称</span></td>
            <td class="altbg2"><input name="title" type="text" id="title" value="{$datacall['title']}"/></td>
        </tr>
        <tr>
            <td class="altbg1" width="45%"><b>调用模板:</b><br>
                <span class="smalltxt">
                    问题所在分类名: <a href="###"  onclick="insertunit('[category_name]');">[category_name]</a>
                    问题所在分类id: <a href="###"  onclick="insertunit('[cid]');">[cid]</a><br>
                    问题标题: <a href="###"  onclick="insertunit('[title]');">[title]</a>
                    问题id:  <a href="###"  onclick="insertunit('[qid]');">[qid]</a><br>
                    提问者: <a href="###"  onclick="insertunit('[author]');">[author]</a>
                    提问者uid: <a href="###"  onclick="insertunit('[authorid]');">[authorid]</a><br>
                    提问时间: <a href="###"  onclick="insertunit('[time]');">[time]</a><br>
                    回答数: <a href="###"  onclick="insertunit('[answers]');">[answers]</a>
                    查看数: <a href="###"  onclick="insertunit('[views]');">[views]</a><br>
                </span>
            </td>
            <td class="altbg2"><textarea  id="tpl_textarea" name="tpl"  style="height:100px;width:800px;"> {$tpl} </textarea></td>
        </tr>
        <tr>
            <td class="altbg1" width="45%"><b>问题状态:</b><br><span class="smalltxt">选择要调用的问题状态</span></td>
            <td class="altbg2">
                <select name="status" >
                    <!--{loop $status_list $st}-->
                    <option value="{$st[0]}" {if $expressionarr['status'] == $st[0]}selected{/if}>{$st[1]}</option>
                    <!--{/loop}-->
                </select>
            </td>
        </tr>
        <tr>
            <td class="altbg1" width="45%"><b>问题分类:</b><br><span class="smalltxt">请选择问题的分类</span></td>
            <td class="altbg2">
                <table border="0" cellpadding="0" cellspacing="0" width="460px">
                    <tr valign="top">
                        <td width="125px">
                            <select  id="category1" class="catselect" size="8" name="category1" ></select>
                        </td>
                        <td align="center" valign="middle" width="25px"><div style="display: none;" id="jiantou1">>></div></td>
                        <td width="125px">
                            <select  id="category2"  class="catselect" size="8" name="category2" style="display:none"></select>
                        </td>
                        <td align="center" valign="middle" width="25px"><div style="display: none;" id="jiantou2">>>&nbsp;</div></td>
                        <td width="125px">
                            <select id="category3"  class="catselect" size="8"  name="category3" style="display:none"></select>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="altbg1">起始数据行数:</td>
            <td class="altbg2"><input name="start"  value="{$expressionarr['start']}" ></td>
        </tr>
        <tr>
            <td class="altbg1">显示数据条数:</td>
            <td v><input name="limit"  value="{$expressionarr['limit']}" ></td>
        </tr>
        <tr>
            <td class="altbg1">标题最大字节数:</td>
            <td class="altbg2"><input name="maxbyte"  value="{$expressionarr['maxbyte']}" ></td>
        </tr>
        <tr>
            <td class="altbg1">数据缓存时间(秒):</td>
            <td class="altbg2"><input name="cachelife" value="{$expressionarr['cachelife']}"   ></td>
        </tr>
        <tr>
            <td class="altbg1">&nbsp;</td>
            <td class="altbg2">
                <input type="hidden" value="0" name="cid">
                <input type="hidden" value="{$datacall['id']}" name="id">
                <input class="btn" type="submit" value="&nbsp;提交&nbsp;" name="submit">
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">
    var category1 = {$categoryjs[category1]};
            var category2 = {$categoryjs[category2]};
            var category3 = {$categoryjs[category3]};
    $(document).ready(function() {
        init_category1(category1);
        fill_sub_category(category2, $("#category1 option:selected").val(), "category2");
        //分类选择
        $("#category1").change(function() {
            fillcategory(category2, $("#category1 option:selected").val(), "category2");
            $("#jiantou1").show();
            $("#category2").show();
        });
        $("#category2").change(function() {
            fillcategory(category3, $("#category2 option:selected").val(), "category3");
            $("#jiantou2").show();
            $("#category3").show();
        });
    });
    function init_category1(category1) {
        var selectedcid1 = $("#selectcid1").val();
        $("#category1").append("<option value='0'>不选择</option>");
        for (var i = 0; i < category1.length; i++) {
            var selected = '';
            if (selectedcid1 === category1[i][0]) {
                selected = ' selected';
            }
            $("#category1").append("<option value='" + category1[i][0] + "' " + selected + ">" + category1[i][1] + "</option>");
        }
    }
    function fill_sub_category(category2, value1, cateid) {
        var optionhtml = '<option value="0">父分类</option>';
        var selectedcid = 0;
        if (cateid === "category2") {
            selectedcid = $("#selectcid2").val();
        } else if (cateid === "category3") {
            selectedcid = $("#selectcid3").val();
        }
        for (var i = 0; i < category2.length; i++) {
            if (value1 === category2[i][0]) {
                var selected = '';
                if (selectedcid === category2[i][1]) {
                    selected = ' selected';
                    $("#" + cateid).show();
                }
                optionhtml += "<option value='" + category2[i][1] + "' " + selected + ">" + category2[i][2] + "</option>";
            }
        }
        $("#" + cateid).html(optionhtml);
    }

</script>
</body>

</html>
