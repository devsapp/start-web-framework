
    $(".art-content").find("video").each(function(){
         //console.log($(this).attr("src"));
    	var _mysrc=$(this).attr("src");
    	 var _src='';
    	if(_mysrc.indexOf('http')<0){
    		//如果来源内部网站就添加网址
    		_src=g_site_url+$(this).attr("src");
    	}else{
    		 _src=$(this).attr("src");
    	}
    	
       
        var el=document.createElement("div");
        el.id="video";
        //$(".art-content").append(el);
        $(this).replaceWith(el);
        var flashvars={
            p:0,
            e:1,
            i:'http://www.ask2.cn/data/upload/cqdw.jpg'
        };
        var video=[_src];
        var support=['all'];
        CKobject.embedHTML5(el.id,'ckplayer_a1',600,400,video,flashvars,support);

    });