<!--{template header}-->
{eval $this->load->model ( "category_model" );}
	{eval	$categoryjs = $this->category_model->get_js ();}
	{eval	$qqlogin = $this->user_model->get_login_auth ( $user ['uid'], 'qq' );}
		{eval $sinalogin = $this->user_model->get_login_auth ( $user['uid'], 'sina' );}
		{eval $wxlogin = $user['openid'] ? 1 : 0;}
<div class="layui-container fly-marginTop fly-user-main">
{template user_menu}

  
  <div class="fly-panel fly-panel-user" pad20>
    <div class="layui-tab layui-tab-brief" lay-filter="user">
      <ul class="layui-tab-title" id="LAY_mine">
        <li class="layui-this" lay-id="info">我的资料</li>
        <li lay-id="avatar">头像</li>
        <li lay-id="pass">密码</li>
        <li lay-id="bind">帐号绑定</li>
           <li lay-id="vertify">认证信息</li>
            <li lay-id="email">激活邮箱</li>
               <li lay-id="phone">激活手机号</li>
        <li lay-id="setcat" style="display:none;">擅长分类</li>
      </ul>
      <div class="layui-tab-content" style="padding: 20px 0;">
        <div class="layui-form layui-form-pane layui-tab-item layui-show">
          <form method="post">
          
            <div class="layui-form-item">
              <label for="L_username" class="layui-form-label">真实姓名</label>
              <div class="layui-input-inline">
                <input type="text" name="truename" id="truename"  value="{$user['truename']}"  required lay-verify="required" autocomplete="off" class="layui-input">
              </div>
              <div class="layui-inline">
                <div class="layui-input-inline">
                  <input type="radio"  name="gender" value="1" <!--{if (1 == $user['gender'])}--> checked <!--{/if}--> title="男">
                  <input type="radio" name="gender" value="0" <!--{if (0 == $user['gender'])}--> checked <!--{/if}--> title="女">
                </div>
              </div>
            </div>
            <div class="layui-form-item">
              <label for="L_city" class="layui-form-label">工作单位</label>
              <div class="layui-input-inline">
                <input type="text" name="conpanyname" id="conpanyname"  value="{$user['conpanyname']}" autocomplete="off" value="" class="layui-input">
              </div>
            </div>
      
             <div class="layui-form-item">
              <label for="L_username" class="layui-form-label">消息设置</label>
             
             
                <div class="layui-input-block">
             
      <input type="checkbox" name="messagenotify" value="1" title="站内消息" <!--{if 1 & $user['isnotify']}-->checked<!--{/if}--> >
      <input type="checkbox" name="mailnotify"  value="2" title="邮件通知" <!--{if 2 & $user['isnotify']}-->checked<!--{/if}-->>
                </div>
              
            </div>
            <div class="layui-form-item">
    <label class="layui-form-label">生日</label>
    <div class="layui-input-inline">
       <!--{eval $bdate=explode("-",$user['bday']);}-->
                        <select id="birthyear" name="birthyear" onchange="showbirthday();" class="normal_select">
                            <!--{eval $curyear=date("Y");}-->
                            <!--{eval $yearlist = range(1911,$curyear);}-->
                            <!--{loop $yearlist $year}-->
                            <option value="{$year}" <!--{if $bdate[0]==$year}-->selected<!--{/if}--> >{$year}</option>
                            <!--{/loop}-->
                        </select> 
                  
    </div>
        <div class="layui-input-inline">
          <select id="birthmonth" name="birthmonth" onchange="showbirthday();" class="normal_select">
                            {eval $monthlist = range(1,12);}
                            <!--{loop $monthlist $month}-->
                            <option value="{$month}" <!--{if $bdate[1]==$month}-->selected<!--{/if}-->>{$month}</option>
                            <!--{/loop}-->
                        </select> 
                          </div>
                           <div class="layui-input-inline">
                        <select id="birthday" name="birthday" class="normal_select">
                            {eval $dayhlist = range(1,31);}
                            <!--{loop $dayhlist $day}-->
                            <option  value="{$day}" <!--{if $bdate[2]==$day}-->selected<!--{/if}-->>{$day}</option>
                            <!--{/loop}-->
                        </select>
                         </div>
  </div>
    
     
              <div class="layui-form-item">
              <label for="L_city" class="layui-form-label">QQ</label>
              <div class="layui-input-inline">
                <input type="text"  name="qq" id="qq"   value="{$user['qq']}"  autocomplete="off" value="" class="layui-input">
              </div>
            </div>
              <div class="layui-form-item">
              <label for="L_city" class="layui-form-label">MSN</label>
              <div class="layui-input-inline">
                <input type="text" name="msn" id="msn"  value="{$user['msn']}"  autocomplete="off" value="" class="layui-input">
              </div>
            </div>
              <div class="layui-form-item">
              <label for="L_city" class="layui-form-label">个人签名</label>
              <div class="layui-input-inline">
                <input type="text" name="signature" id="signature" maxlength="15" value="{$user['signature']}"  autocomplete="off" value="" class="layui-input">
              </div>
            </div>
            <div class="layui-form-item layui-form-text">
              <label for="L_sign" class="layui-form-label">身份介绍</label>
              <div class="layui-input-block">
                <textarea placeholder="个人介绍500字内" name="introduction" id="introduction"  autocomplete="off" class="layui-textarea" style="height: 80px;">{$user['introduction']}</textarea>
              </div>
            </div>
            <div class="layui-form-item">
              <button class="layui-btn" id="submit" name="submit"  type="submit">确认修改</button>
            </div>
            </form>
          </div>
          
          <div class="layui-form layui-form-pane layui-tab-item">
              <!--{if isset($imgstr)}-->
                {$imgstr}
                <!--{else}-->
           <form class="form-horizontal"  action="{url user/editimg/$user['uid']}" method="post"  enctype="multipart/form-data">
            <div class="layui-form-item">
          
              <div class="avatar-add">
              
             <div class="text-center"> 
             <input id="file_upload" name="userimage" class=" mar-t10" style="margin:0 auto;margin-top:15px;" type="file"/>
             
                  <button type="submit" name="uploadavatar" id="uploadavatar" class="layui-btn mar-t10" >
                 
                             <i class="layui-icon">&#xe67c;</i>上传头像 </button>
                             </div>
                               <div class="mar-t10 text-color-hui font12 text-center">建议尺寸165*165px，支持jpg、png、gif，最大不能超过2M</div>
                <img alt="{$user['username']}" src="{$user['avatar']}">
                <span class="loading"></span>
              </div>
            </div>
            </form>
              <!--{/if}-->
          </div>
          
          <div class="layui-form layui-form-pane layui-tab-item">
            <form action="{url user/uppass}"  method="post">
              <div class="layui-form-item">
                <label for="L_nowpass" class="layui-form-label">当前密码</label>
                <div class="layui-input-inline">
                  <input type="password" id="oldpwd" name="oldpwd" required lay-verify="required" autocomplete="off" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item">
                <label for="L_pass" class="layui-form-label">新密码</label>
                <div class="layui-input-inline">
                  <input type="password" id="newpwd"  name="newpwd" maxlength="20" required lay-verify="required" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">6到20个字符</div>
              </div>
              <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">确认密码</label>
                <div class="layui-input-inline">
                  <input type="password" id="confirmpwd"  name="confirmpwd"  required lay-verify="required" autocomplete="off" class="layui-input">
                </div>
              </div>
              {template code}
              <div class="layui-form-item">
                <button class="layui-btn" type="submit" name="submit" id="submit">确认修改</button>
              </div>
            </form>
          </div>
          
          <div class="layui-form layui-form-pane layui-tab-item">
            <ul class="app-bind">
                <!--{if $qqlogin}-->
                  <li class="fly-msg app-havebind">
                <i class="iconfont icon-qq"></i>
                <span>已成功绑定，您可以使用QQ帐号直接登录{$setting['name']}，当然，您也可以</span>
                <a href="{url user/unchainauth/qq}" class="acc-unbind" type="qq_id">解除绑定</a>
             
              </li>
                  <!--{else}-->
                       <li class="fly-msg app-havebind">
                        <i class="iconfont icon-qq"></i>
                <a href="{SITE_URL}plugin/qqlogin/index.php" class="acc-bind" type="qq_id">立即绑定</a>
                <span>，即可使用QQ帐号登录{$setting['name']}</span> 
                 </li>
                   <!--{/if}-->
             <!--{if !$sinalogin}-->
              <li class="fly-msg">
                <i class="iconfont icon-weibo"></i>
              
                <a href="{SITE_URL}plugin/sinalogin/index.php" class="acc-weibo" type="weibo_id"   >立即绑定</a>
                <span>，即可使用微博帐号登录{$setting['name']}</span>
              </li>
               <!--{else}-->
               <li class="fly-msg">
                <i class="iconfont icon-weibo"></i>
              
                 <span>已成功绑定，您可以使用微博直接登录{$setting['name']}，当然，您也可以</span>
                <a href="{url user/unchainauth/sina}" class="acc-unbind" type="weibo_id">解除绑定</a> 
                 </li>
               <!--{/if}-->
             
            </ul>
          </div>
           <div class="layui-form layui-form-pane layui-tab-item">
      {if !$vertify}
      {eval $this->load->model ( "vertify_model" );}
      {eval $vertify = $this->vertify_model->get_by_uid ( $user['uid'] );}
      {if $vertify['status']==null}
      {eval $vertify ['status'] = - 1;}
      {/if}
      {/if}
        <div class="layui-form layui-form-pane layui-tab-item layui-show">
          <form method="post" id="vertify_form">
            <div class="layui-form-item">
    <label class="layui-form-label">当前状态</label>
    <div class="layui-input-block">
       {if !isset($vertify['msg'])}
                    <div class="layui-badge layui-bg-green mar-l10 mar-t10">未认证</div>
          {else}
          <span class="layui-badge layui-bg-blue mar-l10 mar-t10">{$vertify['msg']}</span>
          {/if}
          {if $vertify['status']==2}
          <div style="color:#777" class="mar-t10  mar-l10"> 驳回原因:{$vertify['shibaiyuanyin']}</div>
          {/if}
    </div>
  </div>
            <div class="layui-form-item">
    <label class="layui-form-label">擅长领域</label>
    <div class="layui-input-inline">
  <select lay-verify="required" name="vertifycategory"  {if $vertify['status']==0}disabled{/if}  id="vertifycategory"	lay-filter="vertifycategory"> 
  <option value="0">请选择</option>
											{eval $this->load->model ("category_model" );} 
											{eval	$categorylist=$this->category_model->get_categrory_tree(1,0);echo $categorylist;}

										</select>
    </div>
    <div class="layui-form-mid layui-word-aux unittext">
      {eval if ($setting['cansetcatnum']==null||trim($setting['cansetcatnum'])=='')$setting['cansetcatnum']='1';}
         擅长领域(最多{$setting['cansetcatnum']}个)
    </div>
  
           <input type="hidden" value="" name="cids" id="cate_value" />
           
  <ul id="cate_view" class=" ">
                                <!--{loop $user['category'] $category}-->
                                <li class="item" id="{$category['cid']}">
                                <span class="layui-badge layui-bg-green mar-t10">{$category['categoryname']}</span>
                                 {if $vertify['status']!=0}
                                <i title="删除" class="layui-icon layui-icon-close-fill hand mar-t10"></i>
                                {/if}
                                </li>
                                <!--{/loop}-->
                            </ul>
   
  </div>
            <div class="layui-form-item">
    <label class="layui-form-label">认证类型</label>
    <div class="layui-input-block">
     {eval if ($setting['vertify_gerentip']==null||trim($setting['vertify_gerentip'])=='')$setting['vertify_gerentip']='个人';}
      <input class="vertify_type" lay-filter="vertify_type" type="radio" name="type" value="0"  {if $vertify['status']==0}disabled{/if} title="{$setting['vertify_gerentip']}" <!--{if isset($vertify['type'])&&(0 == $vertify['type'])}--> checked <!--{/if}-->>
       {eval if ($setting['vertify_qiyetip']==null||trim($setting['vertify_qiyetip'])=='')$setting['vertify_qiyetip']='企业';}
      <input class="vertify_type" lay-filter="vertify_type" type="radio" name="type" value="1" {if $vertify['status']==0}disabled{/if} title="{$setting['vertify_qiyetip']}" <!--{if isset($vertify['type'])&&(1 == $vertify['type'])}--> checked <!--{/if}-->>
      
  
    </div>
  </div>
          <div class="layui-form-item">
    <label class="layui-form-label change_name">真实姓名</label>
    <div class="layui-input-block">
      <input type="text" name="name" id="name" {if $vertify['status']==0}disabled{/if} value="{if isset($vertify['name'])}$vertify['name']{/if}"  required  lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
    </div>
  </div>
      <div class="layui-form-item">
    <label class="layui-form-label change_idcode">身份证号</label>
    <div class="layui-input-block">
      <input type="text" name="id_code" id="id_code"  {if $vertify['status']==0}disabled{/if} value="{if isset($vertify['id_code'])}$vertify['id_code']{/if}"  required  lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
    </div>
  </div>
    <div class="layui-form-item layui-form-text">
    <label class="layui-form-label">认证介绍</label>
    <div class="layui-input-block">
      <textarea name="jieshao" id="jieshao"  {if $vertify['status']==0}disabled{/if}  placeholder="将展示在认证资料中" class="layui-textarea">{if isset($vertify['jieshao'])}$vertify['jieshao']{/if}</textarea>
    </div>
  </div>
      <div class="layui-form-item">
  
    <div class="layui-input-block" style="margin-left: 0px;">
    <div class="layui-btn">	<input  {if $vertify['status']==0}disabled{/if} name="attach1" id="upimgfile"  type="file" class="fujianfule  collapse" accept="image/*" onchange="uploadvertify(this)">
					  </div>
    <p class="text-color-hui mar-t10 mar-b10">请提交对应的身份证或者营业执照证件扫描<span style="color:#FF5722">（必须上传）</span></p>
     <img src='{if isset($vertify['zhaopian1'])}{$vertify['zhaopian1']}{/if}' id="vertify_img1" class="vertify_img {if isset($vertify['zhaopian1'])&&$vertify['zhaopian1']==''}hide{/if}"/>
          
    </div>
  
  </div>
    <hr class="layui-bg-green">
         <div class="layui-form-item">
  
    <div class="layui-input-block" style="margin-left: 0px;">
    <div class="layui-btn layui-btn-normal">
   	<input  {if $vertify['status']==0}disabled{/if} name="attach2" type="file" id="upimgfile2"  class="fujianfule  collapse"  accept="image/*" onchange="uploadvertify2(this)">
					   
					  </div>
    <p class="text-color-hui mar-t10 mar-b10">其它证明材料,格式jpg,png,jpeg。<span style="color:#1E9FFF!important">（非必需）</span></p>
    	  <img src='{if isset($vertify['zhaopian2'])}{$vertify['zhaopian2']}{/if}' id="vertify_img2"  class="vertify_img {if isset($vertify['zhaopian2'])&&$vertify['zhaopian2']==''}hide{/if}"/>
            
    </div>
  
  </div>
  {if $vertify['status']!=0}
    <div class="layui-form-item">
    <div class="layui-input-block" style="margin-left: 0px;">
        {if $vertify['status']==2}
          <button type="button" id="submit" name="submit" onclick="submitvertify()" class="layui-btn" >
          重新提交
          </button>
          {else}
          <button type="button" id="submit" name="submit" onclick="submitvertify()" class="layui-btn" >
提交{eval $needpay=intval($setting['vertifyjine']); if ($needpay>0&&$vertify['status']!=1) echo "[付费".$needpay."元]";}
          </button>
          {/if}
    </div>
  </div>
   {/if}
          </form>
          </div>
      {if $vertify&&$vertify['status']!=0}
      <script type="text/javascript">
      layui.use(['jquery', 'layer','form'], function(){
    	  var $ = layui.$ //重点处
    	  ,layer = layui.layer;
          form=layui.form;
          var catsetnum={$setting['cansetcatnum']};
          
          form.on('radio(vertify_type)', function(data){   
		      var val=data.value;
		  	switch(val){
    		case '0':
    			$(".change_name").html("真实姓名");
    			$(".change_idcode").html("身份证号");
    			break;
    		case '1':
    			$(".change_name").html("企业名称");
    			$(".change_idcode").html("营业执照号");
    			break;
    		}
          });
          form.on('select(vertifycategory)', function(data){   
    	      var val=data.value;
    	    var obj = $("#vertifycategory").find("option:selected");
    	    var _currentval=obj.val();
    	    var _currentgrade=obj.attr("grade");
    	    var _currentpid=obj.attr("pid");
    	    var _mytext='<span class="layui-badge layui-bg-green mar-t10">'+obj.html().replace(/\|/g, '').replace(/-/g, '')+"</span>";
    	       if ($('#cate_view li').size() >= catsetnum) {
        	       
    	             layer.msg("最多选择"+catsetnum+"个")
    	                  return false;
    	              }else{
    	                  var selected_cid = _currentval;
    	    	            
        	              if (selected_cid > 0) {
        	            	  $("#cate_view").append('<li class="item" id="'+_currentval+'">' + _mytext + '<i title="删除" class="layui-icon layui-icon-close-fill hand mar-t10"></i></li>');
        	                  
        	                  $.post("{url user/ajaxcategory}", {cid: selected_cid});
        	              }
        	             
        	              $("#cate_view .layui-icon").click(function() {
        	                  var cid = $(this).parent().attr("id");

        	                  $.post("{url user/ajaxdeletecategory}", {cid: cid});

        	                  $(this).parent().remove();

        	               

        	              });
        	              if ($('#cate_view li').size() >= catsetnum) {
        	            	  layer.msg("最多选择"+catsetnum+"个")
        	                  return false;

        	              }
    	              }
    	      
    	   
               });
          
          $("#cate_view .layui-icon").click(function() {
              var cid = $(this).parent().attr("id");

              $.post("{url user/ajaxdeletecategory}", {cid: cid});

              $(this).parent().remove();

           

          });
    	//提交资料
    	window.submitvertify=function (){
    		//认证类型
    		var _type=$.trim($("input[name='type']:checked").val());
    		//用户名
    		var _name=$.trim($("#vertify_form #name").val());
    		//身份证号码
    		var _idcode=$.trim($("#vertify_form #id_code").val());
    		//认证介绍
    		var _jieshao=$.trim($("#vertify_form #jieshao").val());
    		//认证附件图片
    		var _vertifyimgfile=$.trim($("#vertify_img1").attr("src"));
    		switch(_type){
    		case '0':
    			if(_name==''){
    				layer.msg("真实姓名不能为空");
    				return false;
    			}
    			if(_idcode==''){
    				layer.msg("身份证号码不能为空");
    				return false;
    			}
    			break;
    		case '1':
    			if(_name==''){
    				layer.msg("企业名称不能为空");
    				return false;
    			}
    			if(_idcode==''){
    				layer.msg("营业执照号不能为空");
    				return false;
    			}
    			break;
    		}
    		if(_jieshao==''){
    			layer.msg("认证介绍不能为空");
    			return false;
    		}

    		if(_vertifyimgfile==''){
    			layer.msg("附件一认证材料不能为空");
    			return false;
    		}
    		//认证附件图片2
    		var _vertifyimgfile2=$.trim($("#vertify_img2").attr("src"));

    		var data={
    				type:_type,
    				name:_name,
    				idcode:_idcode,
    				jieshao:_jieshao,
    				zhaopian1:_vertifyimgfile,
    				zhaopian2:_vertifyimgfile2
    		}
    		function success(data){
    			layer.msg(data.result);
    			if(data.code=='200'){
    				setTimeout(function(){
    					window.location.reload();
    				},1000);

    			}
    		}
    		var _posturl="{url user/ajaxvertify}";
    		ajaxpost(_posturl,data,success);
    	}
    	//图片大小验证
    	 window.verificationPicFile=function (file){
    	
    	    var fileSize = 0;
    	    var fileMaxSize = 1024*3;//3M
    	    var filePath = file.value;
    	    if(filePath){
    	        fileSize =file.files[0].size;
    	        var size = fileSize / 1024;
    	        if (size > fileMaxSize) {
    	            alert("文件大小不能大于3M！");
    	            file.value = "";
    	            return false;
    	        }else if (size <= 0) {
    	            alert("文件大小不能为0M！");
    	            file.value = "";
    	            return false;
    	        }
    	    }else{
    	        return false;
    	    }
    	}
    	 window.uploadvertify=function (file){

 	    	
    	   	 if (file.files && file.files[0])
    	        {
    	   		verificationPicFile(file);
    	   	     $(".upimgtip").html("图片上传中....");
    	   		 $("#upimgfile").attr("disabled","disabled");
    	   		  var type = "wangEditorMobileFile";
    	   		  var ischeck=0;
    	   		
    	   		    var formData = new FormData();
    	   		    formData.append(type, $("#upimgfile")[0].files[0]);
    	   		 formData.append("addimg",0);
    		
    	   	  
    	   		    $.ajax({
    	   		        type: "POST",
    	   		        url: '{url attach/upimg}',
    	   		        data: formData,
    	   		        processData: false,
    	   		        contentType: false,
    	   		        //返回数据的格式
    	   	            datatype: "text",//"xml", "html", "script", "json", "jsonp", "text".
    	   	            beforeSend: function () {

    	   	             
    	   	             },
    	   		        success: function (data) {
    	   		         $("#upimgfile").removeAttr("disabled");
    	   		     if(data.indexOf('error')==0){
    	   		    	
                       alert(data.replace('error|',''));
                       return false;
    	   		     }else{
    	   		    	$("#vertify_img1").attr("src",data).removeClass("hide");
    	   		     }
    	   		         
    	   		        
    	   		          
    	   		        },
    	   	             complete: function () {
    	   	            	 $(".upimgtip").html("");
    	   	            	 $("#upimgfile").removeAttr("disabled");
    	   	               
    	   	              },
    	   	             //调用出错执行的函数
    	   	             error: function(){
    	   	           
    	   	            	 $("#upimgfile").removeAttr("disabled");
    	   	                 //请求出错处理
    	   	            	 alert("上传出错");
    	   	             }
    	   		    });
    	        }
    	   }
    	 window.uploadvertify2=function (file){
    
    	
      	 if (file.files && file.files[0])
           {
      		verificationPicFile(file);
      	     $(".upimgtip2").html("图片上传中....");
      		 $("#upimgfile2").attr("disabled","disabled");
      		  var type = "wangEditorMobileFile";
      		  var ischeck=0;
      		
      		    var formData = new FormData();
      		    formData.append(type, $("#upimgfile2")[0].files[0]);
      		 formData.append("addimg",0);
    	
      	  
      		    $.ajax({
      		        type: "POST",
      		        url: '{url attach/upimg}',
      		        data: formData,
      		        processData: false,
      		        contentType: false,
      		        //返回数据的格式
      	            datatype: "text",//"xml", "html", "script", "json", "jsonp", "text".
      	            beforeSend: function () {

      	         
      	             },
      		        success: function (data) {
      		         $("#upimgfile2").removeAttr("disabled");
      		     if(data.indexOf('error')==0){
      		    	
                  alert(data.replace('error|',''));
                  return false;
      		     }else{
      		    	$("#vertify_img2").attr("src",data).removeClass("hide");
      		     }
      		         
      		        
      		          
      		        },
      	             complete: function () {
      	            	 $(".upimgtip2").html("");
      	            	 $("#upimgfile2").removeAttr("disabled");
      	           
      	              },
      	             //调用出错执行的函数
      	             error: function(){
      	          
      	            	 $("#upimgfile2").removeAttr("disabled");
      	                 //请求出错处理
      	            	 alert("上传出错");
      	             }
      		    });
           }
      }
    	//图片上传预览    IE是用了滤镜。
    	window.previewImage=function (file)
    	{
    	  var MAXWIDTH  = 260;
    	  var MAXHEIGHT = 180;

    	  if (file.files && file.files[0])
    	  {


    	      var reader = new FileReader();
    	      reader.onload = function(evt){

    	    	  var canvas=document.createElement("canvas");
    	          var ctx=canvas.getContext("2d");
    	          var image=new Image();
    	          image.src=evt.target.result;
    	          image.onload=function(){
    	              var cw=image.width;
    	              var ch=image.height;
    	              var w=image.width;
    	              var h=image.height;
    	              canvas.width=w;
    	              canvas.height=h;
    	              if(cw>800&&cw>ch){
    	                  w=800;
    	                  h=(800*ch)/cw;
    	                  canvas.width=w;
    	                  canvas.height=h;
    	              }
    	              if(ch>800&&ch>cw){
    	                  h=800;
    	                  w=(800*cw)/ch;
    	                  canvas.width=w;
    	                  canvas.height=h;

    	              }

    	              ctx.drawImage(image,0,0,w,h);
    	              var _src=canvas.toDataURL("image/png",1);
    	              console.log(_src);

    	    	 $("#vertify_img1").attr("src",_src).removeClass("hide");


    	      }
    	      }
    	      reader.readAsDataURL(file.files[0]);
    	  }


    	}
    	//图片上传预览    IE是用了滤镜。
    	window.previewImage1=function (file)
    	{
    	  var MAXWIDTH  = 260;
    	  var MAXHEIGHT = 180;

    	  if (file.files && file.files[0])
    	  {


    	      var reader = new FileReader();
    	      reader.onload = function(evt){

    	    	  var canvas=document.createElement("canvas");
    	          var ctx=canvas.getContext("2d");
    	          var image=new Image();
    	          image.src=evt.target.result;
    	          image.onload=function(){
    	              var cw=image.width;
    	              var ch=image.height;
    	              var w=image.width;
    	              var h=image.height;
    	              canvas.width=w;
    	              canvas.height=h;
    	              if(cw>800&&cw>ch){
    	                  w=800;
    	                  h=(800*ch)/cw;
    	                  canvas.width=w;
    	                  canvas.height=h;
    	              }
    	              if(ch>800&&ch>cw){
    	                  h=800;
    	                  w=(800*cw)/ch;
    	                  canvas.width=w;
    	                  canvas.height=h;

    	              }

    	              ctx.drawImage(image,0,0,w,h);
    	              var _src=canvas.toDataURL("image/png",1);
    	              console.log(_src);

    	    	 $("#vertify_img2").attr("src",_src).removeClass("hide");


    	      }
    	      }
    	      reader.readAsDataURL(file.files[0]);
    	  }


    	}
      });
      </script>
      {/if}
           </div>
            <div class="layui-form layui-form-pane layui-tab-item">
              {if $user['active']==0}
    <div class="fly-msg" style="margin-bottom:15px;">
      您的邮箱尚未验证，这比较影响您的帐号安全。
    </div>
  {/if}
  <form class="layui-form" name="vertifyemailform"  action="{url user/editemail}" method="post">
 
    <div class="layui-form-item">
    <label class="layui-form-label">邮箱</label>
    <div class="layui-input-inline">
      <input type="text" name="email" id="myemail"  required  value="{$user['email']}"  lay-verify="required" placeholder="修改邮箱，激活后可以接收网站信息" autocomplete="off" class="layui-input">
   
    </div>
    <div class="layui-form-mid layui-word-aux">
        {if $user['active']==0}
        
             <div  id="sendvertifile"  class="layui-btn layui-btn-sm  layui-btn-normal">激活当前邮箱</div>
         
            {/if}
    </div>
  </div>
  
   <!--{template code}-->
     <div class="layui-form-item">
    <div class="layui-input-block">
      {if $user['active']==0}
      <button class="layui-btn" type="submit" name="submit"  value="1" onclick="checkmeialform()" id="submitemail">保存并激活</button>
          {else}
   <button class="layui-btn" type="submit" name="submit" value="1" onclick="checkmeialform()" id="submitemail">修改并重新激活</button>
   {/if}
    </div>
  </div>
   
  </form>
  {if $user['active']==0}
<script>
layui.use(['jquery', 'layer'], function(){
	  var $ = layui.$ //重点处
	  ,layer = layui.layer;
	  window.checkmeialform=function(){
		  document.vertifyemailform.action="{url user/editemail}";
document.vertifyemailform.submit();
	  }
	  $("#sendvertifile").click(function(){
            
		   var _formkey=$("#formkey").val();
		   var email='{$user['email']}';
		   if($.trim(email)==''||$.trim(email)=='null'||email=='undefined'){
			   layer.msg("您还没设置过邮箱，请先点击保存按钮保存邮箱");
			   return false;
		   }
		   if($("#myemail").val()!=email){
			   layer.msg("您已经修改过邮箱，请点击按钮'保存并激活'");
			   return false;
		   }
		   if(confirm("您将要激活{$user['email']},如果不想激活当前邮箱，请先修改保存在激活，系统将会发送激活邮件")){
		    $.ajax({
		        //提交数据的类型 POST GET
		        type:"POST",
		        //提交的网址
		        url:'{url user/sendcheckmail}',
		        data:{formkey:_formkey},
		        //返回数据的格式
		        datatype: "text",//"xml", "html", "script", "json", "jsonp", "text".

		        //成功返回之后调用的函数
		        success:function(data){
		        	$(".messagetip").html(data);
		        	layer.msg("激活信息已发送到当前邮箱");

		        }   ,

		        //调用出错执行的函数
		        error: function(){
		        	layer.msg("激活异常");
		            //请求出错处理
		        }
		    });
		   }
		})
});

</script>
{/if}
           </div>
            <div class="layui-form layui-form-pane layui-tab-item">
           {if $user['phoneactive']==0}
    <div class="fly-msg" style="margin-bottom:15px;">
      您的手机号尚未验证，这比较影响您的帐号安全。
    </div>
  {/if}
    <form class="layui-form" name="vertifyemailform"  action="{url user/editphone}" method="post">
 
    <div class="layui-form-item">
    <label class="layui-form-label">手机号</label>
    <div class="layui-input-inline">
      <input type="text" name="userphone" id="userphone"  required  value="{$user['phone']}"  lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
   
    </div>
    <div class="layui-form-mid layui-word-aux">
        {if $user['phoneactive']==0}
        
             <div    id="sendphonecode" class="layui-btn layui-btn-sm  layui-btn-normal">发送验证码</div>
         
            {/if}
    </div>
  </div>
    <div class="layui-form-item">
    <label class="layui-form-label">验证码</label>
    <div class="layui-input-inline">
      <input type="text" name="code" id="code" required lay-verify="required" placeholder="请输入接收到的短信验证码" autocomplete="off" class="layui-input">
    </div>
    <div class="layui-form-mid layui-word-aux">接收到的短信验证码</div>
  </div>
     <div class="layui-form-item">
    <div class="layui-input-block">
      {if $user['phoneactive']==0}
      <button class="layui-btn" type="submit" name="submit"  value="1" id="submitsms">保存并激活</button>
          {else}
   <button class="layui-btn" type="submit" name="submit" value="1"  id="submitsms">修改并重新激活</button>
   {/if}
    </div>
  </div>
   
  </form>
           </div>
           <div class="layui-form layui-form-pane layui-tab-item">
  



          
        </div>

      </div>
    </div>
</div>
</div>

<!--{template footer}-->