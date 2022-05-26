<?php defined('IN_MET') or exit('No permission'); ?>
<include file="head.php" />
<main class="met-shownews animsition">
    <div class="container">
        <div class="row">
        <div class="clearfix">
            <div class="col-md-9 met-shownews-body" m-id="noset">
                <div class="row">
                    <section class="details-title">
                        <h1 class='m-t-10 m-b-5'>{$data.title}</h1>
                        <div class="info font-weight-300">
                            <span>{$data.updatetime}</span>
                            <span>{$data.issue}</span>
                            <span>
                                <i class="icon wb-eye m-r-5" aria-hidden="true"></i>
                                {$data.hits}
                            </span>
                        </div>
                    </section>
                    <section class="met-editor clearfix">
                        {$data.content}
                    </section>
                    <list data="$data['taglist']" name="$tag"></list>
                    <if value="$sub">
                        <div class="tag-border">
                            <if value="$data['taglist']">
                                <div class="detail_tag font-size-14">
                                    <span>{$data.tagname}</span>
                                    <list data="$data['taglist']" name="$tag">
                                        <a href="{$tag.url}" {$g.urlnew} title="{$tag.name}">{$tag.name}</a>
                                    </list>
                                </div>
                            </if>
                            <list data="$data['tag_relations']" name="$rel"></list>
                            <if value="$sub">
                                <div class="met-relevant">
                                    <ul class='blocks-100 blocks-md-2'>
                                        <list data="$data['tag_relations']" name="$rel">
                                            <li class=''>
                                                <h4 class='m-t-0 m-b-0 text-left-center'>
                                                    <a href='{$rel.url}' title='{$rel.title}' {$g.urlnew}>{$rel.title}[{$rel.updatetime}]</a>
                                                </h4>
                                            </li>
                                        </list>
                                    </ul>
                                </div>
                            </if>
                        </div>
                    </if>
                    <div class='met-page met-shownews-footer border-top1' >
                        <ul class="pagination block blocks-2 p-t-20">
                            <li class='page-item m-b-0 {$data.preinfo.disable}'>
                                <a href='<if value="$data['preinfo']['url']">{$data.preinfo.url}<else/>javascript:;</if>' {$g.urlnew} title="{$data.preinfo.title}" class='page-link text-truncate'>
                                    {$word.Previous_news}
                                    <span aria-hidden="true" class='hidden-xs-down'>: <if value="$data['preinfo']['title']">{$data.preinfo.title}<else/>{$word.Noinfo}</if></span>
                                </a>
                            </li>
                            <li class='page-item m-b-0 {$data.nextinfo.disable}'>
                                <a href='<if value="$data['nextinfo']['url']">{$data.nextinfo.url}<else/>javascript:;</if>' title="{$data.nextinfo.title}" {$g.urlnew} class='page-link pull-xs-right text-truncate'>
                                    {$word.Next_news}
                                    <span aria-hidden="true" class='hidden-xs-down'>: <if value="$data['nextinfo']['title']">{$data.nextinfo.title}<else/>{$word.Noinfo}</if></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="row">
                    <div class="met-bar" m-id="news_bar" m-type="nocontent">
                        <if value="$lang['imgbar_column_open']">
                            <ul class="column list-icons">
                                <tag action='category' cid="$data['class1']" class='active'>
                                    <li>
                                        <a href="{$m.url}" title="{$m.name}" class="{$m.class}" {$m.urlnew}><h3 class="font-weight-300">{$m.name}</h3></a>
                                    </li>
                                    <tag action='category' cid="$m['id']" type='son' class='active'>
                                        <li class="met-bar-son">
                                            <if value="$m['sub']&& $lang['bar_column3_open']">
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
                                            <a href="{$m.url}" title="{$m.name}" class='{$m.class}' {$m.urlnew}>{$m.name}</a>
                                            </if>
                                        </li>
                                    </tag>
                                </tag>
                            </ul>
                        </if>
                        <if value="$lang['news_bar_list_open']">
                            <div class="sidebar-news-list recommend">
                                <h3 class=' font-weight-300 m-0'>{$lang.img_bar_list_title}</h3>
                                <ul class="list-group list-group-bordered m-t-10 m-b-0">
                                    <tag action='list' cid="$data['class1']" num="$lang['img_bar_list_num']" type="$lang['img_bar_list_type']">
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
    </div>
</main>
<include file="foot.php" />