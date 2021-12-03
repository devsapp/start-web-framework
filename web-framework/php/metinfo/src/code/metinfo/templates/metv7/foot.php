<footer class='met-foot-info border-top1' m-id='met_foot' m-type="foot">
    <div class="met-footnav text-xs-center p-b-20" m-id='noset' m-type='foot_nav'>
    <div class="container">
        <div class="row mob-masonry">
            <tag action='category' type='foot'>
            <if value="$m['_index'] lt 4">
            <div class="col-lg-2 col-md-3 col-xs-6 list masonry-item foot-nav">
                <h4 class='font-size-16 m-t-0'>
                    <a href="{$m.url}" {$m.urlnew}  title="{$m.name}">{$m.name}</a>
                </h4>
                <if value="$m['sub']">
                <ul class='ulstyle m-b-0'>
                    <tag action='category' cid="$m['id']" type='son' num={$lang.num}>
                    <li>
                        <a href="{$m.url}" {$m.urlnew} title="{$m.name}">{$m.name}</a>
                    </li>
                    </tag>
                </ul>
                </if>
            </div>
            </if>
            </tag>
            <div class="col-lg-3 col-md-12 col-xs-12 info masonry-item font-size-20" m-id='met_contact' m-type="nocontent">
                <if value="$lang['footinfo_tel']">
                <p class='font-size-26'>{$lang.footinfo_tel}</p>
                </if>
                <if value="$lang['footinfo_dsc']">
                <p><a href="tel:{$lang.footinfo_dsc}" title="{$lang.footinfo_dsc}">{$lang.footinfo_dsc}</a></p>
                </if>
                <if value="$lang['footinfo_wx_ok']">
                <a class="p-r-5" id="met-weixin" data-plugin="webuiPopover" data-trigger="hover" data-animation="pop" data-placement='top' data-width='155' data-padding='0' data-content="<div class='text-xs-center'>
                    <img src='{$lang.footinfo_wx}' alt='{$c.met_webname}' width='150' height='150' id='met-weixin-img'></div>
                ">
                    <i class="fa fa-weixin light-green-700"></i>
                </a>
                </if>
                <if value="$lang['footinfo_qq_ok']">
                <a
                <if value="$lang['foot_info_qqtype'] eq 1">
                href="http://wpa.qq.com/msgrd?v=3&uin={$lang.footinfo_qq}&site=qq&menu=yes"
                <else/>
                href="http://crm2.qq.com/page/portalpage/wpa.php?uin={{$lang.footinfo_qq}&aty=0&a=0&curl=&ty=1"
                </if>
                rel="nofollow" target="_blank" class="p-r-5">
                    <i class="fa fa-qq"></i>
                </a>
                </if>
                <if value="$lang['footinfo_sina_ok']">
                <a href="{$lang.footinfo_sina}" rel="nofollow" target="_blank" class="p-r-5">
                    <i class="fa fa-weibo red-600"></i>
                </a>
                </if>
                <if value="$lang['footinfo_twitterok']">
                <a href="{$lang.footinfo_twitter}" rel="nofollow" target="_blank" class="p-r-5">
                    <i class="fa fa-twitter red-600"></i>
                </a>
                </if>
                <if value="$lang['footinfo_googleok']">
                <a href="{$lang.footinfo_google}" rel="nofollow" target="_blank" class="p-r-5">
                    <i class="fa fa-google red-600"></i>
                </a>
                </if>
                <if value="$lang['footinfo_facebookok']">
                <a href="{$lang.footinfo_facebook}" rel="nofollow" target="_blank" class="p-r-5">
                    <i class="fa fa-facebook red-600"></i>
                </a>
                </if>
                <if value="$lang['footinfo_emailok']">
                <a href="mailto:{$lang.footinfo_email}" rel="nofollow" target="_blank" class="p-r-5">
                    <i class="fa fa-envelope red-600"></i>
                </a>
                </if>
            </div>
        </div>
    </div>
</div>
    <if value="$lang['link_ok']">
    <tag action='link.list'></tag>
    <if value="$sub">
    <div class="met-link border-top1 text-xs-center p-y-10" m-id='noset' m-type='link'>
        <div class="container">
            <ul class="breadcrumb p-0 link-img m-0">
                <li class='breadcrumb-item'>{$lang.footlink_title} :</li>
                <tag action='link.list'>
                <li class='breadcrumb-item'>
                    <a href="{$v.weburl}" title="{$v.info}" {$v.nofollow} target="_blank">
                        <if value="$v.link_type eq 1">
                            <img data-original="{$v.weblogo}" alt="{$v.info}" height='40'>
                        <else/>
                            <span>{$v.webname}</span>
                        </if>
                    </a>
                </li>
                </tag>
            </ul>
        </div>
    </div>
    </if>
    </if>
    <div class="copy p-y-10 border-top1">
        <div class="container text-xs-center">
            <if value="$c['met_footright'] || $c['met_footstat']">
            <div>{$c.met_footright}</div>
            </if>
            <if value="$c['met_footaddress']">
            <div>{$c.met_footaddress}</div>
            </if>
            <if value="$c['met_foottel']">
            <div>{$c.met_foottel}</div>
            </if>
            <if value="$c['met_footother']">
            <div>{$c.met_footother}</div>
            </if>
            <if value="$c['met_foottext']">
            <div>{$c.met_foottext}</div>
            </if>
            <div class="powered_by_metinfo">{$c.met_agents_copyright_foot}</div>
                <if value="$c['met_ch_lang'] && $lang['cn1_position'] eq 0">
                    <if value="$lang['cn1_ok']">
                    <if value="$data['synchronous'] eq 'cn' || $data['synchronous'] eq 'zh'">
                        <button type="button" class="btn btn-outline btn-default btn-squared btn-lang" id='btn-convert' m-id="lang" m-type="lang">繁体</button>
                    </if>
                    </if>
                </if>
                <if value="$c['met_lang_mark'] && $lang['langlist_position'] eq 0">
                <div class="met-langlist vertical-align" m-id="lang"  m-type="lang">
                    <div class="inline-block dropup">

                        <lang>
                        <if value="$sub gt 1">
                            <if value="$data['lang'] eq $v['mark']">
                            <button type="button" data-toggle="dropdown" class="btn btn-outline btn-default btn-squared dropdown-toggle btn-lang">
                                <if value="$lang['langlist1_icon_ok']">
                                <img src="{$v.flag}" alt="{$v.name}" width="20">
                                </if>
                                <span>{$v.name}</span>
                            </button>
                            </if>
                        <else/>
                            <a href="{$v.met_weburl}" title="{$v.name}" class="btn btn-outline btn-default btn-squared btn-lang" <if value="$v['newwindows'] eq 1">target="_blank"</if>>
                                <if value="$lang['langlist1_icon_ok']">
                                <img src="{$v.flag}" alt="{$v.name}" width="20">
                                </if>
                                {$v.name}
                            </a>
                        </if>
                        </lang>
                        <if value="$sub gt 1">
                            <ul class="dropdown-menu dropdown-menu-right animate animate-reverse" id="met-langlist-dropdown" role="menu">
                                <lang>
                                <a href="{$v.met_weburl}" title="{$v.name}" class='dropdown-item' <if value="$v['newwindows'] eq 1">target="_blank"</if>>
                                    <if value="$lang['langlist1_icon_ok']">
                                    <img src="{$v.flag}" alt="{$v.name}" width="20">
                                    </if>
                                    {$v.name}
                                </a>
                                </lang>
                            </ul>
                        </if>
                    </div>
                </div>
                </if>
            </div>
        </div>
    </div>
</footer>
<div class="met-menu-list text-xs-center <if value="$_M['form']['pageset']">iskeshi</if>" m-id="noset" m-type="menu">
    <div class="main">
        <tag action="menu.list">
            <div style="background-color: {$v.but_color};">
                <a href="{$v.url}" class="item" <if value="$v['target']">target="_blank"</if> style="color: {$v.text_color};">
                    <i class="{$v.icon}"></i>
                    <span>{$v.name}</span>
                </a>
            </div>
        </tag>
    </div>
</div>
<met_foot />