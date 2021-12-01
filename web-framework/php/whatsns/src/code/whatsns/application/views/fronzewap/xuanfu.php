
<section class="sec-xuanfu ">

      <div class="xuanfu ">
          
          <i class="ui-icon-add"></i>
      </div>
      <div class="icon-nav ui-badge-wrap">
         
          <a href="{url question/searchkey}"><i class="ui-icon-search pingyi"></i></a>
          {if $user['uid']!=0}
          <a href="{url user/default}">

              <i class="ui-icon-personal pingyi"></i>
          </a>
          {else}
          <a href="{url user/login}">

              <i class="ui-icon-personal pingyi"></i>
          </a>
          {/if}
          
              <a href="{SITE_URL}"> <i class="ui-icon-home pingyi"></i></a>
      </div>

<script>

$(".xuanfu").bind("click",function(){
    var target=$(this);
    target.addClass("xuanzhuan");
    if(target.find("i").hasClass("ui-icon-add")){
        $(".xuanfu .ui-badge-cornernum").hide();
        $(".icon-nav i").addClass("pingyi-search");
        $(".icon-nav .label-num").css({"opacity":"1"});
        target.find("i").removeClass("ui-icon-add").addClass("ui-icon-close-page");
    }else{
        $(".icon-nav .label-num").css({"opacity":"0"});
        $(".icon-nav i").removeClass("pingyi-search");
        target.find("i").addClass("ui-icon-add").removeClass("ui-icon-close-page");
    }

    setTimeout(function(){
        target.removeClass("xuanzhuan");

    },500);
})
</script>
</section>
