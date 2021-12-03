<!--{template header}-->


<!--用户中心-->


    <div class="container person">

   
              <div class="row " style="margin-top: 20px;">
        <div class="col-md-6">
         <!--{template side_useritem}-->
        </div>
           <div class="col-md-16">
               <h4>修改头像</h4>
     <hr>
  <!--{if isset($imgstr)}-->
                {$imgstr}
                <!--{else}-->
                <p> 说明：</p>
                <ul class="nav">
                <li>
                  1、支持jpg、gif、png、jpeg四种格式图片上传
                </li>
                 <li>
                   2、图片大小不能超过2M;
                </li>
                 <li>
                3、图片长宽大于165*165px时系统将自动压缩
                </li>
                </ul>

 <form class="form-horizontal"  action="{url user/editimg/$user['uid']}" method="post"  enctype="multipart/form-data">
  <div class="form-group">

          <div class="col-md-24 mar-t-1">
              <img class="avatar" alt="{$user['username']}" src="{$user['avatar']}" style="width: 45px;height:45px;" />
          </div>
            <div class="col-md-24 mar-t-1">
             <input id="file_upload" name="userimage" type="file"/>
                            <button type="submit" name="uploadavatar" id="uploadavatar" class="btn btn-success mar-t-1" >
                            上&nbsp;传 </button>
          </div>
        </div>
 </form>
                 <!--{/if}-->
           </div>
           

            </div>

        </div>





<!--{template footer}-->