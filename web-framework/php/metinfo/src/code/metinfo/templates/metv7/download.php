<?php defined('IN_MET') or exit('No permission'); ?>
<include file="head.php" />
<section class="met-download animsition">
    <div class="container">
        <div class="row">
            <div class="col-md-9 met-download-body">
                <div class="row">
                    <div class="met-download-list">
                        <tag action='download.list' num="$c['met_download_list']"></tag>
                        <if value="$sub">
                        <ul class="ulstyle met-pager-ajax imagesize" data-scale='1' m-id='met_download'>
                            <include file='ajax/download'/>
                        </ul>
                        <else/>
                        <div class='h-100 text-xs-center font-size-20 vertical-align' m-id='met_download'>{$c.met_data_null}</div>
                        </if>
                        <div class='m-t-20 text-xs-center hidden-sm-down' m-type="nosysdata">
                            <pager/>
                        </div>
                        <div class="met-pager-ajax-link hidden-md-up" data-plugin="appear" m-type="nosysdata" data-animate="slide-bottom" data-repeat="false">
                            <button type="button" class="btn btn-primary btn-block btn-squared ladda-button" id="met-pager-btn" data-plugin="ladda" data-style="slide-left" data-url="" data-page="1">
                                <i class="icon wb-chevron-down m-r-5" aria-hidden="true"></i>
                                {$lang.page_ajax_next}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3" m-id="downlaod_bar" m-type="nocontent">
                <div class="row">
                    <div class="met-bar">
                        <if value="$lang['downloadsidebar_column_ok']">
                        <ul class="column list-icons p-l-0">
                            <tag action='category' cid="$data['class1']" class='active'>
                            <li>
                                <a href="{$m.url}" title="{$m.name}" class="{$m.class}" target='_self'><h3>{$m.name}</h3></a>
                            </li>
                            <tag action='category' cid="$m['id']" type='son' class='active'>
                            <li>
                                <if value="$m['sub'] && $lang['download_column3_ok']">
                                <a href="javascript:;" title="{$m.name}" class='{$m.class}' data-toggle="collapse" data-target=".sidebar-column3-{$m._index}">{$m.name}<i class="wb-chevron-right-mini"></i></a>
                                <div class="sidebar-column3-{$m._index} collapse" aria-expanded="false">
                                    <ul class="m-t-5 p-l-20">
                                        <li><a href="{$m.url}" title="{$lang.all}" class="{$m.class}">{$lang.all}</a></li>
                                        <tag action='category' cid="$m['id']" type='son' class='active'>
                                        <li><a href="{$m.url}" title="{$m.name}" class='{$m.class}'>{$m.name}</a></li>
                                        </tag>
                                    </ul>
                                </div>
                                <else/>
                                <a href="{$m.url}" title="{$m.name}" class='{$m.class}'>{$m.name}</a>
                                </if>
                            </li>
                            </tag>
                            </tag>
                        </ul>
                        </if>
                        <if value="$lang['sidebar_downloadlist_ok']">
                        <div class="sidebar-news-list recommend">
                            <h3 class='m-0'>{$lang.download_bar_list_title}</h3>
                            <ul class="list-group list-group-bordered m-t-10 m-b-0">
                                <tag action='list' cid="$data['class1']" num="$lang['sidebar_downloadlist_num']" type="$lang['download_bar_list_type']">
                                <li class="list-group-item">
                                    <a href="{$v.url}" title="{$v.title}" target='_self'>{$v.title}</a>
                                </li>
                                </tag>
                            </ul>
                        </div>
                        </if>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<include file="foot.php" />