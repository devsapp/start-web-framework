<!--{template header}-->
<script type="text/javascript" src="{SITE_URL}static/js/neweditor/ueditor.config.js"></script>
<script type="text/javascript" src="{SITE_URL}static/js/neweditor/ueditor.all.js"></script>
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;编辑分类</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table class="table">
    <tr>
        <td class="{$type}">{$message}</td>
    </tr>
</table>
<!--{/if}-->
<form name="askform" action="index.php?admin_category/edit{$setting['seo_suffix']}" method="post"  enctype="multipart/form-data">
    <input type="hidden" name="id" value="{$category['id']}" />
    <input type="hidden" name="selectcid1" id="selectcid1" value="{if isset($category1)}$category1{/if}" />
    <input type="hidden" name="selectcid2" id="selectcid2" value="{if isset($category2)}$category2{/if}" />
    <table class="table">
        <tr class="header">
            <td colspan="2">父级分类</td>
        </tr>
        <tr>
        <td class="altbg1" width="45%"><b>上一级分类:</b><br><span class="smalltxt">选择上级分类</span></td>
        <td class="altbg1">
            <table cellspacing="0" cellpadding="0" border="0" width="300px">
                <tr valign="top">
                    <td width="125px">
                        <select  id="category1" class="catselect" size="8" name="category1" disabled></select>
                    </td>
                    <td align="center" valign="middle" width="25px"><div style="display: none;" id="jiantou1">>></div></td>
                    <td width="125px">
                        <select  id="category2"  class="catselect" disabled size="8" name="category2" style="display:none"></select>
                    </td>
                </tr>
            </table>
        </td>
        </tr>
        <tr>
            <td class="altbg1"><b>分类名称:</b><br><span class="smalltxt">使用合适的名称作为分类名</span></td>
            <td class="altbg2" colspan="2"><input name="name"  type="text" value="{$category['name']}"></td>
        </tr>
            <tr>
            <td class="altbg1"><b>分类别名:</b><br><span class="smalltxt">别名有利于seo优化</span></td>
            <td class="altbg2" colspan="2"><input name="aliasname" style="width:300px;"  type="text" value="{$category['alias']}"></td>
        </tr>
          <tr>
            <td class="altbg1"><b>分类目录:</b><br><span class="smalltxt">设置后，分类详情url将不在显示id用此设置拼音代替，不得和已有拼音名称冲突，否则解析失败</span></td>
            <td class="altbg2" colspan="2"><input name="dir"  type="text" value="{$category['dir']}"></td>
        </tr>
               <tr>
            <td class="altbg1"><b>专栏描述:</b><br><span class="smalltxt">描述将出现在专栏详情页面简介</span></td>
            <td class="altbg2" colspan="2">
           <script type="text/plain" id="edit_miaosu" name="edit_miaosu" style="height: 200px;width:100%;">{$category['miaosu']}</script>
                         <script type="text/javascript">
            var editor = UE.getEditor('edit_miaosu',{
                //这里可以选择自己需要的工具按钮名称,此处仅选择如下五个
                  toolbars:[[  'link', 'unlink', 'Redo','bold']],


                //关闭字数统计
                wordCount:false,
                //关闭elementPath
                elementPathEnabled:false,

                focus:true
                //更多其他参数，请参考ueditor.config.js中的配置项
                //更多其他参数，请参考ueditor.config.js中的配置项
            });
        </script>
            </td>
        </tr>
         <tr>
            <td class="altbg1"><b>文章分类模板页面:</b><br><span class="smalltxt">这个适合文章专栏分类页面动态配置</span></td>
            <td class="altbg2" colspan="2">
                  <select id="s_tmplist" name="s_tmplist">
                 {loop $catlistfiles  $catfile}
                 {eval $filename=str_replace('.php','',$catfile);};
        <option value="{$filename}" {if $category['template']==$filename }selected{/if}>Application/view/$setting['tpl_dir']/{$catfile}</option>
          {/loop}
      
        </select>
      <h5>说明：</h5>
      <p>catlist.php：文章默认模板，列表由封面图+标题+描述组合，图片靠右边展示-系统模板</p>
       <p>catlist_topic.php：列表由封面图+标题组合，图片靠上展示-系统模板</p>
        <p>catlist_text.php：列表只显示标题-系统模板</p>
        <div style="color:red">
           {if $category['template']==null||$category['template']==''}
                              当前应用模板：Application/view/$setting['tpl_dir']/catlist.php
                          {else}
                                                         当前应用模板：Application/view/$setting['tpl_dir']/$category['template'].php
                           {/if}
        </div>
            </td>
        </tr>
                 <tr>
            <td class="altbg1"><b>文章详情页面:</b><br><span class="smalltxt">配合对应分类将应用对应文章模板</span></td>
            <td class="altbg2" colspan="2">
                  <select id="s_tmplist" name="s_articletmplist">
                 {loop $articlelistfiles  $articlefile}
                 {eval $filename=str_replace('.php','',$articlefile);};
        <option value="{$filename}" {if $category['articletemplate']==$filename }selected{/if}>Application/view/$setting['tpl_dir']/{$articlefile}</option>
          {/loop}
      
        </select>
      <h5>说明：</h5>
      <p>topicone.php：文章详情页面默认模板</p>
  
        <div style="color:red">
           {if $category['articletemplate']==null||$category['articletemplate']==''}
                              当前应用模板：Application/view/$setting['tpl_dir']/topicone.php
                          {else}
                                                         当前应用模板：Application/view/$setting['tpl_dir']/$category['articletemplate'].php
                           {/if}
        </div>
            </td>
        </tr>
        
                <tr>
            <td class="altbg1"><b>分类专栏封面图:</b><br><span class="smalltxt">上传专栏封面图，大小不小于200*200合适</span></td>
            <td class="altbg2" colspan="2">

                        {if $category['image']==""||$category['image']==null}
                         <img src="{SITE_URL}static/images/defaulticon.jpg" style="width:80px;height:80px;">
                         {else}
                             <img src="{$category['image']}" style="width:80px;height:80px;">
                         {/if}



                         </p>
                         <input type="file" id="file_upload" name="catimage">

            </td>
        </tr>

    </table>
    <center><input type="submit" class="button" name="submit" value="提 交"></center>
</form>
<br />

  <script src='{SITE_URL}static/js/common.js' language='javascript'></script>
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
    });
    function init_category1(category1) {
        var selectedcid1 = $("#selectcid1").val();
        $("#category1").append("<option value='0' selected>根分类</option>");
        for (var i = 0; i < category1.length; i++) {
            var selected = '';
            if (selectedcid1 === category1[i][0]) {
                selected = ' selected';
            }
            $("#category1").append("<option value='" + category1[i][0] + "' " + selected + ">" + category1[i][1] + "</option>");
        }
    }
    function fill_sub_category(category2, value1, cateid) {
        var optionhtml = '<option value="0">根分类</option>';
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
<!--{template footer}-->