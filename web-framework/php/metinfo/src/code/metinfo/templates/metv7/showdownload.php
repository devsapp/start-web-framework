<?php defined('IN_MET') or exit('No permission'); ?>
<include file="head.php" />
<section class="met-showdownload animsition">
    <div class="container">
        <div class="row">
            <div class="col-md-9 met-showdownload-body" m-id='noset' >
                <div class="row">
                    <section class="details-title">
                        <h1 class='m-t-10 m-b-5'>{$data.title}</h1>
                        <div class="info">
                            <span>{$data.updatetime}</span>
                            <span>{$data.issue}</span>
                            <span>
                                <i class="icon wb-eye m-r-5" aria-hidden="true"></i>
                                {$data.hits}
                            </span>
                        </div>
                    </section>
                    <section class="download-paralist">
                        <if value="$data['para']">
                            <list data="$data['para']" name="$s">
                            <dl class="dl-horizontal clearfix blocks font-size-16">
                                <dt class='font-weight-300'><span>{$s.name}</span> :<span class="p-x-10">{$s.value}</span></dt>
                            </dl>
                            </list>
                        </if>
                        <a class="btn btn-outline btn-primary btn-squared met-showdownload-btn m-t-20" href="{$data.downloadurl}" title="{$data.title}">{$lang.download}</a>
                    </section>
                    <section class="met-editor clearfix">
                        {$data.content}
                    </section>
                   <if value="$data['taglist']">
                   <div class="tag-border">
                        <div class="detail_tag font-size-14">
                            <span>{$data.tagname}</span>
                            <list data="$data['taglist']" name="$tag">
                                <a href="{$tag.url}" {$g.urlnew} title="{$tag.name}">{$tag.name}</a>
                            </list>
                        </div>
                        <if value="$data['tag_relations']">
                        <div class="met-relevant">
                            <ul class='blocks-100 blocks-md-2'>
                                <list data="$data['tag_relations']" name="$rel">
                                    <li>
                                        <h4 class='m-y-0'>
                                            <a href='{$rel.url}' title='{$rel.title}' {$g.urlnew}>{$rel.title}[{$rel.updatetime}]</a>
                                        </h4>
                                    </li>
                                </list>
                            </ul>
                        </div>
                        </if>
                    </div>
                    </if>
                </div>
            </div>
            <div class="col-md-3" m-id="downlaod_bar" m-type="nocontent">
                <div class="row">
                    <div class="met-bar">
                        <if value="$lang['downloadsidebar_column_ok']">
                        <ul class="column list-icons p-l-0">
                            <tag action='category' cid="$data['class1']" class='active'>
                            <li>
                                <a href="{$m.url}" title="{$m.name}" class="{$m.class}" {$m.urlnew}><h3>{$m.name}</h3></a>
                            </li>
                            <tag action='category' cid="$m['id']" type='son' class='active'>
                            <li>
                                <if value="$m['sub'] && $lang['download_column3_ok']">
                                <a href="javascript:;" title="{$m.name}" class='{$m.class}' data-toggle="collapse" data-target=".sidebar-column3-{$m._index}">{$m.name}<i class="wb-chevron-right-mini"></i></a>
                                <div class="sidebar-column3-{$m._index} collapse <if value='$m["id"] eq $data["class2"]'>in</if>" aria-expanded="false">
                                    <ul class="m-t-5 p-l-20">
                                        <li><a href="{$m.url}" title="{$lang.all}" {$m.urlnew} class="<if value='$m["id"] eq $data["classnow"]'>active</if>">{$lang.all}</a></li>
                                        <tag action='category' cid="$m['id']" type='son' class='active'>
                                        <li><a href="{$m.url}" title="{$m.name}" {$m.urlnew} class='{$m.class}'>{$m.name}</a></li>
                                        </tag>
                                    </ul>
                                </div>
                                <else/>
                                <a href="{$m.url}" title="{$m.name}" {$m.urlnew} class='{$m.class}'>{$m.name}</a>
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
                                    <a href="{$v.url}" title="{$v.title}" {$g.urlnew}>{$v.title}</a>
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