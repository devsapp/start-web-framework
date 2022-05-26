<section class="ui-container search-panel">
  <section id="searchbar">


<form action="" onsubmit="return checksearch()" class="am-form am-form-inline"  id="searchForm" name="searchform"   method="post">
                <div  class="ui-searchbar-wrap ui-border-b">

                    <div class="ui-searchbar ui-border-radius">
                        <i class="ui-icon-search"></i>
                        <div class="ui-searchbar-text">输入关键词即可</div>
                        <div class="ui-searchbar-input">
                        <input  onpropertychange="handle();" oninput="handle();" tabindex="1" name="word" id="search-kw" value="{$word}"  type="text" placeholder="输入关键词即可" autocapitalize="off">
                        </div>
                        <i class="ui-icon-close"></i>
                    </div>
                    <button type="submit" id="search_btn" class="ui-searchbar-cancel">取消</button>

                </div>

                <script type="text/javascript">
                    $('.ui-searchbar').tap(function(){
                        $('.ui-searchbar-wrap').addClass('focus');
                        $('.ui-searchbar-input input').focus();
                    });

                    function checksearch(){

                    	if($.trim( $("#search-kw").val())==''){
                    		return false;
                    	}
                    	tijiao();
                    }
                    document.getElementById("search_btn").addEventListener("click",cancel,false);
                    //当状态改变的时候执行的函数
                    function handle()
                    {



                        if( $("#search-kw").val()!=''){
                            $("#search_btn").html("检索");
                            document.getElementById("search_btn").removeEventListener("click",cancel,false);


                        }else{
                            $("#search_btn").html("取消");

                            document.getElementById("search_btn").addEventListener("click",cancel,false);
                        }


                    }
                    function tijiao(){


                        document.searchform.action ="{url question/search}";
                        document.searchform.submit();


                    }
                    function cancel(){

                    	$('.ui-searchbar-wrap').removeClass('focus');
                    }
                </script>

 </form>
    </section>