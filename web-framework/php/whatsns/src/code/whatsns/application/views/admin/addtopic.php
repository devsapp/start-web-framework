<!--{template header}-->
<script type="text/javascript">g_site_url='{SITE_URL}';g_prefix='{$setting['seo_prefix']}';g_suffix='{$setting['seo_suffix']}';</script>
<script type="text/javascript" src="{SITE_URL}static/js/neweditor/ueditor.config.js"></script>
<script type="text/javascript" src="{SITE_URL}static/js/neweditor/ueditor.all.min.js"></script>
<script src="{SITE_URL}static/js/common.js" type="text/javascript"></script>
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;{if isset($topic)}编辑专题{else}添加专题{/if}</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table  class="table">
    <tr>
        <td class="{$type}">{$message}</td>
    </tr>
</table>
<!--{/if}-->
<form {if isset($topic)}action="index.php?admin_topic/edit{$setting['seo_suffix']}"{else}action="index.php?admin_topic/add{$setting['seo_suffix']}"{/if}  method="post" enctype="multipart/form-data">
    <table  class="table">
        <tr class="header"><td colspan="2">参数设置</td></tr>
        <tr>
            <td class="altbg1" width="45%"><b>博客标题:</b><br></td>
            <td class="altbg2"><input class="txt"  name="title" value="{$topic['title']}" size="50"/><span style="position: relative;bottom: -4px;padding-left: 6px;color:red;">  <input type="checkbox" class="txt" <!--{if $topic['ispc']=='1'}-->checked="true"<!--{/if}-->   name="ispc"  />PC显示博客</span><span style="position: relative;bottom: -4px;padding-left: 6px;color:red;">  <input type="checkbox" class="txt" <!--{if $topic['isphone']=='1'}-->checked="true"<!--{/if}-->   name="isphone"  />手机端显示博客</span></td>
        </tr>
        <tr>
        <td>
        选择分类:
        </td>
        <td>

                        <span id="selectedcate" class="selectedcate">$catmodel['name']</span>
                        <span><a id="changecategory" href="javascript:void(0)">选择分类</a>




        </td>
        </tr>
       <tr>
       <td>

  文章标签,多个用英文逗号隔开,最多5个:




       </td>
       <td>
        <input class="input_title" style="height:20px;"  name="topic_tag" value="{$topic['topic_tag']}" />
       </td>
       </tr>
        <tr>
            <td class="altbg1" width="45%"><b>专题简介:</b></td>
            <td class="altbg2">


              <script type="text/plain" id="mycontent" name="content" style="width:610px;height:300px;">{$topic['describtion']}</script>
                                                <script type="text/javascript">UE.getEditor('mycontent');</script>
           </td>
        </tr>
        <tr>
            <td class="altbg1" width="45%"><b>专题图片:</b><br><span class="smalltxt">专题图片，大小建议270px*220px</span></td>
            <td class="altbg2">
              <input type="hidden" name="topicclass" value="{$topic['articleclassid']}" id="topicclass"/>
            <input type="hidden" name="upimg" value="{$topic['image']}"/>
             <input type="hidden" name="views" value="{$topic['views']}"/>
            <!--{if isset($topic['image'])}-->

             {eval $index=strstr($topic['image'],'http');}
                       {if $index }

                             <img src="{$topic['image']}" width="80" height="80" />
                            {else}
                           <img src="{SITE_URL}{$topic['image']}" width="80" height="80" />

                            {/if}



            &nbsp;&nbsp;&nbsp;<!--{/if}--><input type="file" size="30" name="image" /></td>
        </tr>

    </table>
    <br />
    {if isset($topic['id'])}
    <input type="hidden" value="{$topic['id']}" name="id" />
    <input type="hidden" value="{$topic['image']}" name="image" />
    {/if}
    <center><input type="submit" class="button" name="submit" value="提 交"></center><br>
</form>
<br />
  <script type="text/javascript" src="{SITE_URL}static/js/jquery.js"></script>
 <script type="text/javascript" src="{SITE_URL}static/js/jquery-ui/jquery-ui.js"></script>

   <div id="catedialog" title="选择分类" style="display: none">
    <div id="dialogcate">
        <table class="table" border="0" cellpadding="0" cellspacing="0" width="460px">
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
            <tr>
                <td colspan="5"><span >
                <button type="button" hidefocus="" id="layer-submit" class="catgorybtn" style="width:80px;height:30px;line-height:30px;" onclick="selectcate();">确定</button>

                </span></td>
            </tr>
        </table>
    </div>
</div>

<script type="text/javascript">
    var category1 = {$categoryjs[category1]};
    var category2 = {$categoryjs[category2]};
    var category3 = {$categoryjs[category3]};



        initcategory(category1);

      //问题分类选择函数
        function initcategory(category1) {
            var selectedcid1 = $("#selectcid1").val();
            $("#category1").html('');
            for (var i = 0; i < category1.length; i++) {
                var selected = '';
                if (selectedcid1 === category1[i][0]) {
                    selected = ' selected';
                }
                $("#category1").append("<option value='" + category1[i][0] + "' " + selected + ">" + category1[i][1] + "</option>");

            }

        }



        function selectcate() {
            var selectedcatestr = '';
            var category1 = $("#category1 option:selected").val();
            var category2 = $("#category2 option:selected").val();
            var category3 = $("#category3 option:selected").val();
            if (category1 > 0) {
                selectedcatestr = $("#category1 option:selected").html();
                $("#topicclass").val(category1);

            }
            if (category2 > 0) {
                selectedcatestr += " > " + $("#category2 option:selected").html();
                $("#topicclass").val(category2);

            }
            if (category3 > 0) {
                selectedcatestr += " > " + $("#category3 option:selected").html();
                $("#topicclass").val(category3);

            }
            $("#selectedcate").html(selectedcatestr);
            $("#changecategory").html("更改");
            $("#catedialog").dialog("close");
        }
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
        $("#changecategory").click(function() {
            if (!$(this).hasClass("btn-disabled-1")){
            	 $("#catedialog").dialog({
                     autoOpen: false,
                     width: 480,
                     modal: true,
                     resizable: false
                 });
            	  $("#catedialog").dialog("open");
            }


        });
        function fillcategory(category2, value1, cateid) {
            var optionhtml = '<option value="0">不选择</option>';
            var selectedcid = 0;
            if (cateid === "category2") {
                selectedcid = $("#selectcid2").val();
            } else if (cateid === "category3") {
                selectedcid = $("#selectcid3").val();
            }
            $("#" + cateid).html("");
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
<!--{template footer}-->