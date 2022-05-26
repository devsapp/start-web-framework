<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;CMS系统整合</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<table class="table">
    <tr>
        <td class="{$type}">{$message}</td>
    </tr>
</table>
<!--{/if}-->
<table width="100%" cellspacing="1" cellpadding="4" align="center" class="tableborder">
    <tbody><tr class="header"><td>设置说明</td></tr>
        <tr class="altbg1"><td>CMS系统整合主要是从数据库层面进行内容整合，在问答页面展示文章内容。<br />cms系统配置完成后生成的配置文件放在在ask2/data/cms.config.ini中，也可以自行修改配置</td></tr>
    </tbody></table>
<br />
<form action="index.php?admin_cms/setting{$setting['seo_suffix']}" method="post">
    <a name="基本设置"></a>
    <table class="table">
        <tr class="header">
            <td colspan="2">数据库配置</td>
        </tr>
        <tr>
            <td class="altbg1" width="45%"><b>CMS系统整合:</b><br><span class="smalltxt">关闭后设置还会保留。</span></td>
            <td class="altbg2">
                <input class="radio"  type="radio"  {if 1==$setting['cms_open'] }checked{/if}  value="1" name="cms_open" ><label for="yes">开启</label>&nbsp;&nbsp;
                <input class="radio"  type="radio"  {if 0==$setting['cms_open'] }checked{/if} value="0" name="cms_open" ><label for="no">关闭</label>
            </td>
        </tr>
        <tr>
            <td class="altbg1" width="45%"><b>CMS系统数据库配置:</b><br><span class="smalltxt">请根据实际配置来填写数据库配置信息，建议使用只读访问用户.</span></td>
            <td class="altbg2">
                <textarea name="cms_db_config" style="width:650px;height:80px;">
define("CMS_DB_SERVER","127.0.0.1:3306");//数据库地址端口
define("CMS_DB_NAME","wordpress");//数据库名
define("CMS_DB_USER","root");//数据库管理用户名
define("CMS_DB_PASSWORD","");//数据库管理用户密码</textarea>
            </td>
        </tr>
        <tr>
            <td class="altbg1" width="45%"><b>cms系统文章表配置</b><br><span class="smalltxt">cms系统文章表相关字段配置</span></td>
            <td class="altbg2">
                <textarea name="cms_db_article" style="width:650px;height:100px;">

define("CMS_DB_ARTICLE_TBNAME","pre_portal_article_title");//文章表名
define("CMS_DB_ARTICLE_FIELD","title");//文章标题
define("CMS_DB_ARTICLE_PRIMARY","aid");//文章的主键ID
define("CMS_DB_ARTICLE_SORT","  ORDER BY dateline DESC LIMIT 0,10 ");//文章排序过滤条件
define("CMS_ARTICLE_URL","http://www.3798.com/article-[articleid]-1.html");//文章查看地址[articleid]会动态替换为真实文章主键aid
</textarea>
            </td>
        </tr>
    </table>
    <br />
    <center><input type="submit" class="button" name="submit" value="提 交"></center><br>

    <table class="table">
        <tr class="header">
            <td colspan="2">分类映射设置</td>
        </tr>
        <tr>
            <td class="altbg2" colspan="2">设置分类映射后，问题页面推荐文章可根据文章分类进行动态筛选，免费本暂不支持该功能!</td>
        </tr>
    </table>
    <br>
</form>
<br>
<!--{template footer}-->