<?php defined('IN_MET') or exit('No permission'); ?>
<include file="head.php" />
<main>
    <!-- 产品区块 -->
    <div class="met-index-product met-index-body text-xs-center" m-id="met_index_product">
        <div class="container">
            <if value="$lang['index_product_title']">
            <h2 class="m-t-0 invisible" data-plugin="appear" data-animate="slide-top" data-repeat="false">{$lang.index_product_title}</h2>
            </if>
            <if value="$lang['index_product_desc']">
            <p class="desc m-b-0 invisible" data-plugin="appear" data-animate="fade" data-repeat="false">{$lang.index_product_desc}</p>
            </if>
            <ul class="
                <if value="$lang['index_product_column_xs'] eq 1">
                blocks-100
                <else/>
                blocks-xs-{$lang.index_product_column_xs}
                </if>
                blocks-md-{$lang.index_product_column_md} blocks-lg-{$lang.index_product_column_lg} blocks-xxl-{$lang.index_product_column_xxl} imagesize index-product-list clearfix" data-scale='{$lang.index_product_img_h}X{$lang.index_product_img_w}'>
                <tag action="list" cid="$lang['index_product_id']" num="$lang['index_product_allnum']" type="$lang['index_product_type']">
                    <li class=''>
                        <div class="card card-shadow">
                            <figure class="card-header cover">
                                <a href="{$v.url}" title="{$v.title}" class="block" {$g.urlnew}>
                                    <img class="cover-image lazy" data-original="{$v.imgurl|thumb:$lang['index_product_img_w'],$lang['index_product_img_h']}" alt="{$v.title}" >
                                </a>
                            </figure>
                            <a href="{$v.url}" title="{$v.title}" class="block txt-info" {$g.urlnew}>
                                <h4 class="card-title m-0 p-x-10 text-shadow-none text-truncate">
                                    {$v._title}
                                </h4>
                                <if value="$v['description']">
                                    <p class="m-b-0 text-truncate">{$v.description}</p>
                                </if>
                                <if value="$c['shopv2_open']">
                                    <p class='m-b-0 m-t-5 red-600'>{$v.price_str}</p>
                                </if>
                            </a>
                        </div>
                    </li>
                </tag>
            </ul>
        </div>
    </div>
    <!-- 简介区块 -->
    <div class="met-index-about met-index-body text-xs-center" m-id="met_index_about" m-type="nocontent">
        <div class="container">
            <if value="$lang['home_about_title']">
                <h2 class="m-t-0 invisible" data-plugin="appear" data-animate="slide-top" data-repeat="false">{$lang.home_about_title}</h2>
            </if>
            <if value="$lang['home_about_desc']">
                <p class="desc m-b-0 font-weight-300 invisible" data-plugin="appear" data-animate="fade" data-repeat="false">{$lang.home_about_desc}</p>
            </if>
            <div class="row">
                <div class="text met-editor">
                    {$lang.home_about_content}
                </div>
            </div>
        </div>
    </div>
    <!-- 文章区块 -->
    <div class="met-index-news met-index-body text-xs-center" m-id="met_index_news">
        <div class="container">
            <if value="$lang['index_news_title']">
            <h2 class="m-t-0 invisible" data-plugin="appear" data-animate="slide-top" data-repeat="false">{$lang.index_news_title}</h2>
            </if>
            <if value="$lang['index_news_desc']">
            <p class="desc m-b-0 font-weight-300 invisible" data-plugin="appear" data-animate="fade" data-repeat="false">{$lang.index_news_desc}</p>
            </if>
            <div class="row text-xs-left m-t-30 index-news-list">
                <div class="">
                    <ul class="list-group blocks-lg-2">
                        <tag action="list" cid="$lang['home_news1']" num="$lang['home_news_num']" type="$lang['home_news_type']">
                            <li class="invisible" data-plugin="appear" data-animate="slide-bottom" data-repeat="false">
                                <a class="media media-lg block" href="{$v.url}" title="{$v.title}" {$g.urlnew}>
                                    <if value="$lang['home_news_img_ok']">
                                        <div class="media-left">
                                                <img class="media-object" data-original="{$v.imgurl|thumb:$lang['home_product_img_w'],$lang['home_product_img_h']}" alt="{$v.title}" >
                                        </div>
                                    </if>
                                    <div class="media-body">
                                        <h4 class="media-heading m-b-10"> {$v._title} </h4>
                                        <p class="des m-b-5">{$v.description|met_substr:0,$lang['home_news_img_maxnum']}...</p>
                                        <p class="info m-b-0">
                                            <span>{$v.updatetime}</span>
                                            <span class="m-l-10">{$v.issue}</span>
                                            <span class="m-l-10">
                                                <i class="icon wb-eye m-r-5" aria-hidden="true"></i>
                                                {$v.hits}
                                            </span>
                                        </p>
                                    </div>
                                </a>
                            </li>
                        </tag>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- 图片区块 -->
    <div class="met-index-case met-index-body text-xs-center" m-id="met_index_case">
        <div class="container">
            <if value="$lang['home_case_title']">
                <h2 class="m-t-0 invisible" data-plugin="appear" data-animate="slide-top" data-repeat="false">{$lang.home_case_title}</h2>
            </if>
            <if value="$lang['home_case_desc']">
                <p class="desc m-b-0 font-weight-300 invisible" data-plugin="appear" data-animate="fade" data-repeat="false">{$lang.home_case_desc}</p>
            </if>
            <ul class="ulstyle met-index-list" data-num="{$lang.home_case_num_xxl}|{$lang.home_case_num_lg}|{$lang.home_case_num_md}|{$lang.home_case_num_xs}">
                <tag action="list" cid="$lang['home_case_id']" num="$lang['home_case_num']" type="$lang['home_case_type']">
                    <li class="case-list">
                        <if value="$lang['home_case_linkok']">
                        <a href="{$v.url}" title="{$v.title}" {$g.urlnew}>
                        </if>
                            <img src="{$v.imgurl|thumb:$lang['home_case_imgw'],$lang['home_case_imgh']}" alt="{$v.title}" style="max-width: 100%;" />
                        <if value="$lang['home_case_linkok']">
                        </a>
                        </if>
                    </li>
                </tag>
            </ul>
        </div>
    </div>
</main>
<include file="foot.php" />