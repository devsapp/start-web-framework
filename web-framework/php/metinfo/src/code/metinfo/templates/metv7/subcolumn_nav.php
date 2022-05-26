<if value="$lang['tagshow_2']">
<tag action="category" type="current" cid="$data['releclass1']">
<section class="met-column-nav" m-id="subcolumn_nav" m-type="nocontent">
    <div class="container">
        <div class="row">
            <if value="$m['sub']">
                <ul class="clearfix met-column-nav-ul text-xs-center">
                    <tag action='category' cid="$data['releclass1']" type="current" class="active">
                    <if value="$m['module'] neq 1">
                        <li>
                            <a href="{$m.url}" {$m.urlnew} title="{$lang.sub_all}" <if value="$data['classnow'] eq $m['id']">class="active"</if>>{$lang.sub_all}</a>
                        </li>
                        <else/>
                        <if value="$m['isshow']">
                        <li>
                            <a href="{$m.url}" {$m.urlnew} title="{$m.name}" <if value="$data['classnow'] eq $m['id']">class="active"</if>>{$m.name}</a>
                        </li>
                        </if>
                    </if>
                    <tag action='category' cid="$m['id']" type='son' class="active">
                        <if value="$m['sub']">
                            <li class="dropdown">
                                <a href="{$m.url}" title="{$m.name}" class="dropdown-toggle <if value="$data['classnow'] eq $m['id']">active</if>" data-toggle="dropdown">{$m.name}</a>
                                <div class="dropdown-menu animate">
                                    <if value="$m['module'] neq 1">
                                        <a href="{$m.url}" {$m.urlnew} title="{$lang.sub_all}" class='dropdown-item {$m.class}'>{$lang.sub_all}</a>
                                    </if>
                                    <if value="$m['isshow'] && $m['module'] eq 1">
                                        <a href="{$m.url}" {$m.urlnew} title="{$m.name}" class='dropdown-item {$m.class}'>{$m.name}</a>
                                    </if>
                                    <tag action='category' cid="$m['id']" type='son' class="active">
                                    <a href="{$m.url}" {$m.urlnew} title="{$m.name}" class='dropdown-item {$m.class}'>{$m.name}</a>
                                    </tag>
                                </div>
                            </li>
                            <else/>
                            <li>
                                <a href="{$m.url}" {$m.urlnew} title="{$m.name}" class='{$m.class}'>{$m.name}</a>
                            </li>
                        </if>
                    </tag>
                    </tag>
                </ul>
            </if>
            <if value="$data['module'] egt 2 && $data['module'] elt 6">
            <div class="met-col-search">
                <tag action="search.column"></tag>
            </div>
            </if>
        </div>
    </div>
</section>
</tag>
</if>