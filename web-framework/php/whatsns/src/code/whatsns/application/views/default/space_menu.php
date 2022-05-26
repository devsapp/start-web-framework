
<style>
<!--
.hotcourselist .cur_img {
    width:100%;
    height: 140px;
    overflow: hidden;
    position: relative;
}
.hotcourselist .main_img {
    display: block;
    width: 100%;
    height: 140px;
    transition: all 0.5s;
    pointer-events: none;
}
.hotcourselist  .cur_img:hover .main_img {
    transform: scale(1.1);
}
.hotcourselist  .cur_img:hover .modal-type {
    opacity: 1;
    filter: alpha(opacity=100);
    z-index: 1;
}
.hotcourselist .modal-type {
    width: 100%;
    height: 40px;
    line-height: 40px;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 10;
    text-align: center;
    transition: all 500ms ease-out;
    -webkit-transition: all 500ms ease-out;
    -moz-transition: all 500ms ease-out;
    opacity: 0;
    filter: alpha(opacity=0);
}
.hotcourselist .main_img_2 {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 140px;
    transition: all 0.5s;
}
.hotcourselist  .skill_msg {

    width:100%;
    height: 100px;
    position: relative;

}
.hotcourselist .skill_msg p {
    padding: 14px 12px 17px 12px;
    font-size: 14px;
    color: #333;
    padding-bottom: 0px;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    height: 40px;
}
.hotcourselist .cur_teach {
    padding-left: 12px;
    margin-top: 12px;
}
.hotcourselist  .skill_msg span {
    font-size: 12px;
    color: #999;
    display: inline-block;
}
.hotcourselist .hotcourseitem{
overflow: hidden;
    background-color: #fff;
    box-shadow: 0px 0px 15px 0px #d9d9d9;
    border-radius: 10px;
        text-align: left;
}

.hotcourselist .hotcourseitem a:hover .cur_tit {
    color: #ff9000 !important;
}
.hotcourselist .hotcourseitem em{

font-style: normal;
    font-weight: 500;
}
.hotcourselist .skill_msg span.lgoumai{
    background: #f66;
    color:#fff;
        border-radius: 20px;
    padding: 3px 10px;
}
.hotcourselist .skill_msg span.lvip{
  background: #ffc500;
    color:#fff;
        border-radius: 20px;
    padding: 3px 10px;
}
.hotcourselist .skill_msg span.lfree{
  background: #80c269;
    color:#fff;
        border-radius: 20px;
    padding: 3px 10px;
}
.red{
color:red;
}
-->
</style>
            {if $member['vertify']['status']==1}
            <div class="recommend bb">
   <div class="title">
     <i class="fa fa-renzheng"></i>
   <span  class="title_text">认证信息</span>

   </div>

  <div class="description">

    <div class="js-intro"  style="color:#908d08">
    {$member['vertify']['jieshao']}
    </div>


  </div>
  </div>
   {/if}

          <div class="recommend bb">
   <div class="title">
     <i class="fa fa-jieshao"></i>
   <span  class="title_text">个人介绍</span>

   </div>

  <div class="description">
    <div class="js-intro">
{if $member['introduction']}{$member['introduction']}{else}暂无介绍{/if}
    </div>


  </div>
  </div>

   </div>

