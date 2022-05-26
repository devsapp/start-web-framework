<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
  <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;PC模板在线编辑</div>
</div>
<style>
.nav-primary>li.active>a, .nav-primary>li.active>a:focus, .nav-primary>li.active>a:hover {
    color: #fff;
    background-color: #3280fc;
    border-color: #3280fc;
}
.tpldir{
	margin-top:10px;
}
</style>
<table class="table"  align="left" >
    <tr class="tp_tr">
        <td valign="top" class="tp_td1" width="150px" >

               <h3>wap模板列表</h3>
               <ul class="nav nav-primary nav-stacked tpldir">

               </ul>



        </td>
        <td class="tpl_td" valign="top" >
<table    class="table table-hover  tplist">
    <thead >
   <th>模板序号</th>
    <th>模板文件</th>
    <th>模板文件备注</th>
    <th>操作</th>

    </thead>
   <tbody class="tpbody">


   </tbody>

</table>
        </td>
    </tr>
</table>
<script>
    var selectdir="";
    var fileurl=g_site_url+"index.php?admin_template/getwapdir{$setting['seo_suffix']}";
    $.ajax({
        url: fileurl,
        dataType: 'text',
        success: function(data2) {

            var temps=data2.split(',');
            if(temps.length>0){
                $(".tpldir").html("");

                for(var tp=0;tp<temps.length;tp++){
                    if(temps[tp]!=''){
                        var val_file=temps[tp].replace(/(^\s*)|(\s*$)/g,'');

                        var  lifile="<li class='urlcollect hand' ><a style='cursor:pointer'>val</a></li>";

                        //lifile=lifile.replace("fileid",val_file);
                        lifile=lifile.replace("val",val_file);

                        $(".tpldir").prepend(lifile);

                    }
                }
                $(".tpldir li").addClass("hand").css("position","relative").css("left",'-30px').css("text-align","center");
                $(".tpldir li:first-child").addClass("active");

                gettplist($(".tpldir li:first-child a").html());
                $(".urlcollect a").click(function() {

                    $(".tpldir li").removeClass("active");
                    $(this).parent().addClass("active");
                    var namestr=$(this).html();
                    gettplist(namestr);
                });

            }


        }
    });
    function gettplist(dirname){
        var dirfileurl=g_site_url+"index.php?admin_template/getpcdirfile{$setting['seo_suffix']}";

        selectdir=dirname;
        $.ajax({
            type: 'POST',
            url:dirfileurl,
            dataType: 'json',
            data:{"dirname":dirname},
            success: function (data1) {
                     console.log("getone....");
                $(".tpbody").html("");
                var ix=1;
                $.each(data1,function(name,value) {
                    var editfileurl=g_site_url+"index.php?admin_template/editdirfile/"+dirname+"/";
                    var name_str=name.split('.');
                    editfileurl=editfileurl+name_str[0];

                    var tr="<tr align='left'>"+"<td align='left'>"+ix+"</td><td align='left'>"+name+"</td>"+"<td align='left'>"+value+"</td>"+"<td align='left'><a href='"+editfileurl+"'>编辑</a></td></tr>";
                    $(".tpbody").append(tr);
                });
                $(".tpbody td").css("text-align","left");
            }

        });
    }
</script>
<!--{template footer}-->