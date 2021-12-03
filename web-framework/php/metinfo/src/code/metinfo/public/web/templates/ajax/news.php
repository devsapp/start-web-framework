<?php defined('IN_MET') or exit('No permission'); ?>
<if value="$ui['news_headlines'] && $ui['news_listtype'] neq 3">
    <!--头条-->
    <if value="!$data['page'] && !$data['class2']">
        <div class="news-headlines imagesize" data-scale='{$ui.news_headlines_y}x{$ui.news_headlines_x}'>
            <div class="news-headlines-slick cover">
                <list data="$result" name="$v" num="$ui['news_headlines_num']">
                    <div class='slick-slide'>
                        <a href="{$v.url}" title="{$v.title}" {$g.urlnew}>
                            <img class="cover-image" <if value="$v['_index'] gt 0">data-lazy<else/>src</if>="{$v.imgurl|thumb:$ui['news_headlines_x'],$ui['news_headlines_y']}" data-srcset="{$v.imgurl|thumb:450,450*$ui['news_headlines_y']/$ui['news_headlines_x']} 450w,{$v.imgurl|thumb:$ui['news_headlines_x'],$ui['news_headlines_y']}" sizes='(max-width:479px) 450px' alt="{$v.title}">
                            <div class="headlines-text text-xs-center">
                                <h3>{$v._title}</h3>
                            </div>
                        </a>
                    </div>
                </list>
            </div>
        </div>
    </if>
</if>
<list data="$result" num="$c['met_news_list']" name="$v">
    <if value="$ui['news_listtype'] eq 1">
        <!-- 极简模式 -->
        <if value="($ui['news_headlines'] && !$data['page'] && !$data['class2'] && $v['_index'] egt $ui['news_headlines_num']) || ($ui['news_headlines'] && !$data['page'] && $data['class2']) || $data['page'] || !$ui['news_headlines']">
            <li class='border-bottom1'>
                <h4>
                    <a href="{$v.url}" title="{$v.title}" {$g.urlnew}>{$v._title}</a>
                </h4>
                <p class="des font-weight-300">{$v.description}</p>
                <p class="info font-weight-300">
                    <span>{$v.updatetime}</span>
                    <span>{$v.issue}</span>
                    <span><i class="icon wb-eye m-r-5 font-weight-300" aria-hidden="true"></i>{$v.hits}</span>
                </p>
            </li>
        </if>
    </if>
    <if value="$ui['news_listtype'] eq 2">
        <!-- 图文模式 -->
        <if value="($ui['news_headlines'] && !$data['page'] && !$data['class2'] && $v['_index'] egt $ui['news_headlines_num']) || ($ui['news_headlines'] && !$data['page'] && $data['class2']) || $data['page'] || !$ui['news_headlines']">
            <li class="media media-lg border-bottom1">
                <div class="media-left">
                    <a href="{$v.url}" title="{$v.title}" {$g.urlnew}>
                        <img class="media-object" <if value="$v['_index'] gt ($ui['news_headlines']?2+$ui['news_headlines_num']:3) || $data['page'] gt 1">data-original<else/>src</if>="{$v.imgurl|thumb:$c['met_newsimg_x'],$c['met_newsimg_y']}" alt="{$v.title}">
                    </a>
                </div>
                <div class="media-body">
                    <h4>
                        <a href="{$v.url}" title="{$v.title}" {$g.urlnew}>{$v._title}</a>
                    </h4>
                    <p class="des font-weight-300">
                        {$v.description}
                    </p>
                    <p class="info font-weight-300">
                        <span>{$v.updatetime}</span>
                        <span>{$v.issue}</span>
                        <span>
					<i class="icon wb-eye m-r-5 font-weight-300" aria-hidden="true"></i>
					{$v.hits}
				</span>
                    </p>
                </div>
            </li>
        </if>
    </if>
    <if value="$ui['news_listtype'] eq 3">
        <!-- 橱窗模式 -->
        <div class="card card-shadow">
            <div class="card-header p-0">
                <a href="{$v.url}" title="{$v.title}" {$g.urlnew}>
                    <img class="cover-image" <if value="$v['_index'] gt 3 || $data['page'] gt 1">data-original<else/>src</if>="{$v.imgurl|thumb:$ui['news_ccimg_x'],$ui['news_ccimg_y']}" data-srcset='{$v.imgurl|thumb:400} 400w,{$v.imgurl|thumb:$ui['news_ccimg_x'],$ui['news_ccimg_y']}' sizes='(max-width:479px) 400px' alt="{$v.title}">
                </a>
            </div>
            <div class="card-body">
                <h4 class="card-title">
                    <a href="{$v.url}" title="{$v.title}" {$g.urlnew}>{$v._title}</a>
                </h4>
                <p class="card-metas font-size-12 font-weight-300">
                    <span>{$v.updatetime}</span>
                    <span>{$v.issue}</span>
                    <span><i class="icon wb-eye m-r-5 font-weight-300" aria-hidden="true"></i>{$v.hits}</span>
                </p>
                <p class="m-b-0 font-weight-300">{$v.description}</p>
            </div>
        </div>
    </if>
</list>