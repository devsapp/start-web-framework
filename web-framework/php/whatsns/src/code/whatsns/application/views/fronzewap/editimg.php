<!--{template header}-->
<section class="ui-container">
<!--{template user_title}-->
<div style="margin:5px;">
    <!--{if isset($imgstr)}-->
                {$imgstr}
                <!--{else}-->
                <p> <b>说明：</b></p>
                <p>1、支持jpg、gif、png、jpeg四种格式图片上传</p>
                <p>2、图片大小不能超过2M;</p>
                <p>3、图片长宽大于200*200px时系统将自动压缩</p>
        
 <form class="form-horizontal"  action="{url user/editimg/$user['uid']}" method="post"  enctype="multipart/form-data">
  <div class="form-group">
          
          <div class="col-md-24 mar-t-1">
      
           <img class="avatar" alt="{$user['username']}" src="{$user['avatar']}"  style="width:80px;height:80px;border-radius:80px;margin:10px auto;"/>
        
                          <input accept="image/*" style="clear:both;display:block;margin:0 auto;"  id="file_upload" name="userimage" type="file"/>
                        
          </div>
            <div class="col-md-24 mar-t-1" style="clear:both;text-align:left;">
   
                            <button type="submit" name="uploadavatar" id="uploadavatar" style="margin:30px auto;display:block;width:100%;height:40px;" class="ui-btn ui-btn-success " >
                            上传头像 </button>
                           
          </div>
        </div>
 </form>
                 <!--{/if}-->
                 </div>
</section>
 
<!--{template footer}-->

