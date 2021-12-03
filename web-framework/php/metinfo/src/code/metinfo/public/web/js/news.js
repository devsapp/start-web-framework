/*!
 * 新闻模块
 * 米拓企业建站系统 Copyright (C) 长沙米拓信息技术有限公司 (https://www.metinfo.cn). All rights reserved.
 */
(function(){
    $(function(){
        // 文章列表页新闻头条（需调用slick插件）
        var $news_headlines=$('.news-headlines-slick');
        if($news_headlines.length){
            // 新闻头条轮播
            if($news_headlines.find('.slick-slide').length>1){
                var headllines_swipe=true;
                if(M.device_type=='d' && !Breakpoints.is('xs')) headllines_swipe=false;
                $news_headlines.slick({
                    autoplay:true,
                    dots:true,
                    autoplaySpeed:4000,
                    speed:500,
                    swipe:headllines_swipe,
                    prevArrow:met_prevarrow,
                    nextArrow:met_nextarrow,
                    lazyloadPrevNext:true
                });
            }
        }
    });
})();