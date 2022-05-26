<met_meta page="$met_page" />
<header class='met-head' m-id='met_head' m-type="head_nav">
    <nav class="navbar navbar-default box-shadow-none met-nav">
        <div class="container">
            <div class="row">
                <div class='met-nav-btn'>
                    <if value="$data['classnow'] eq 10001">
                    <h1 hidden>{$c.met_webname}</h1>
                    <else/>
                    <if value="!$data['id'] || $data['module'] eq 1">
                    <h1 hidden>{$data.name}</h1>
                    </if>
                    <h3 hidden>{$c.met_webname}</h3>
                    </if>
                    <div class="navbar-header pull-xs-left">
                        <a href="{$c.index_url}" class="met-logo vertical-align block pull-xs-left" title="{$c.met_logo_keyword}">
                            <div class="vertical-align-middle">
                                <if value="$c['met_mobile_logo']">
                                    <img src="{$c.met_mobile_logo}" alt="{$c.met_logo_keyword}" class="mblogo" />
                                    <img src="{$c.met_logo}" alt="{$c.met_logo_keyword}" class="pclogo" />
                                    <else/>
                                    <img src="{$c.met_logo}" alt="{$c.met_logo_keyword}" class="mblogo" />
                                    <img src="{$c.met_logo}" alt="{$c.met_logo_keyword}" class="pclogo" />
                                </if>
                            </div>
                        </a>
                    </div>
                    <button type="button" class="navbar-toggler hamburger hamburger-close collapsed p-x-5 p-y-0 met-nav-toggler" data-target="#met-nav-collapse" data-toggle="collapse">
                        <span class="sr-only"></span>
                        <span class="hamburger-bar"></span>
                    </button>
                    <if value="$c['met_member_register']">
                    <button type="button" class="navbar-toggler collapsed m-0 p-x-5 p-y-0 met-head-user-toggler" data-target="#met-head-user-collapse" data-toggle="collapse"> <i class="icon wb-user-circle" aria-hidden="true"></i>
                    </button>
                    </if>
                </div>
                <div class="collapse navbar-collapse navbar-collapse-toolbar pull-md-right p-0" id='met-head-user-collapse'>
                    <if value="$c['met_member_register']">
                    <if value="$user">
                    <ul class="navbar-nav pull-md-right vertical-align p-l-0 m-b-0 met-head-user" m-id="member" m-type="member">
                        <li class="dropdown">
                            <a
                                href="javascript:;"
                                class="navbar-avatar dropdown-toggle"
                                data-toggle="dropdown"
                                aria-expanded="false"
                            >
                                <span class="avatar m-r-5"><img src="{$user.head}" alt="{$user.username}"/></span>
                                {$user.username}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right animate animate-reverse">
                                <li class='dropdown-item {$c.own_active.0_1}'>
                                    <a href="{$url.profile}" title='{$word.memberIndex9}'><i class="icon wb-user" aria-hidden="true"></i> {$word.memberIndex9}</a>
                                </li>
                                <li class='dropdown-item {$c.own_active.0_2}'>
                                    <a href="{$url.profile_safety}" title='{$word.accsafe}'><i class="icon wb-lock" aria-hidden="true"></i> {$word.accsafe}</a>
                                </li>
                                <div class="dropdown-divider"></div>
                                <if value="$_M['html']['app_sidebar']">
                                <list data="$_M['html']['app_sidebar']" name="$v">
                                <?php
                                $v['active']=$c['own_active'][$v['no'].'_'.$v['own_order']];
                                $v['target']=$v['target']?' target="_blank"':'';
                                ?>
                                <li class='dropdown-item {$v.active}'>
                                    <a href="{$v.url}" title="{$v.title}"{$v.target}><i class="icon fa-paper-plane" aria-hidden="true"></i> {$v.title}</a>
                                </li>
                                </list>
                                <div class="dropdown-divider"></div>
                                </if>
                                <tag action="app_column" name="$v">
                                <li class='dropdown-item {$v.active}'>
                                    <a href="{$v.url}" title="{$v.title}" {$v.target}><i class="icon fa-paper-plane" aria-hidden="true"></i> {$v.title}</a>
                                </li>
                                <if value="$v['_last']">
                                <div class="dropdown-divider"></div>
                                </if>
                                </tag>
                                <li class='dropdown-item'>
                                    <a href="{$url.login_out}"><i class="icon wb-power"></i> {$word.memberIndex10}</a>
                            </ul>
                        </li>
                    </ul>
                    <else/>
                    <ul class="navbar-nav pull-md-right vertical-align p-l-0 m-b-0 met-head-user no-login text-xs-center" m-id="member" m-type="member">
                        <li class=" text-xs-center vertical-align-middle animation-slide-top">
                            <a href="{$url.login}" class="met_navbtn">{$word.login}</a>
                            <a href="{$url.register}" class="met_navbtn">{$word.register}</a>
                        </li>
                    </ul>
                    </if>
                    </if>
                </div>
                <div class="collapse navbar-collapse navbar-collapse-toolbar pull-md-right p-0" id="met-nav-collapse">
                    <ul class="nav navbar-nav navlist">
                        <li class='nav-item'>
                            <a href="{$c.index_url}" title="{$word.home}" class="nav-link
                            <if value="$data['classnow'] eq 10001">
                            active
                            </if>
                            ">{$word.home}</a>
                        </li>
                        <tag action='category' type='head' class='active'>
                        <if value="$lang['navbarok'] && $m['sub']">
                        <li class="nav-item dropdown m-l-{$lang.nav_ml}">
                            <if value="$lang['navbarok']">
                            <a
                                href="{$m.url}"
                                title="{$m.name}"
                                {$m.urlnew}
                                class="nav-link dropdown-toggle {$m.class}"
                                data-toggle="dropdown" data-hover="dropdown"
                            >
                            <else/>
                            <a
                                href="{$m.url}"
                                {$m.urlnew}
                                title="{$m.name}"
                                class="nav-link dropdown-toggle {$m.class}"
                                data-toggle="dropdown"
                            >
                            </if>
                            {$m._name}<span class="fa fa-angle-down p-l-5"></span></a>
                            <if value="$lang['navbullet_ok']">
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-bullet animate animate-reverse">
                            <else/>
                            <div class="dropdown-menu dropdown-menu-right animate animate-reverse">
                            </if>
                            <if value="$m['module'] neq 1">
                                <a href="{$m.url}" {$m.urlnew}  title="{$lang.all}" class='dropdown-item nav-parent hidden-xl-up {$m.class}'>{$lang.all}</a>
                            </if>
                                <tag action='category' cid="$m['id']" type='son' class='active'>
                                <if value="$m['sub']">
                                <div class="dropdown-submenu">
                                    <a href="{$m.url}" {$m.urlnew} class="dropdown-item {$m.class}">{$m._name}</a>
                                    <div class="dropdown-menu animate animate-reverse">
                                        <tag action='category' cid="$m['id']" type='son' class='active'>
                                            <a href="{$m.url}" {$m.urlnew} class="dropdown-item {$m.class}" >{$m._name}</a>
                                        </tag>
                                    </div>
                                </div>
                                <else/>
                                <a href="{$m.url}" {$m.urlnew} title="{$m.name}" class='dropdown-item {$m.class}'>{$m._name}</a>
                                </if>
                                </tag>
                            </div>
                        </li>
                        <else/>
                        <li class='nav-item m-l-{$lang.nav_ml}'>
                            <a href="{$m.url}" {$m.urlnew} title="{$m.name}" class="nav-link {$m.class}">{$m._name}</a>
                        </li>
                        </if>
                        </tag>
                    </ul>
                    <div class="metlang m-l-15 pull-md-right">
                        <if value="$c['met_ch_lang'] && $lang['cn1_position'] eq 1">
                        <if value="$lang['cn1_ok']">
                        <if value="$data['synchronous'] eq 'cn' || $data['synchronous'] eq 'zh'">
                        <span id='btn-convert' class="met_navbtn" m-id="lang" m-type="lang">繁体</span>
                        </if>
                        </if>
                        </if>
                        <lang></lang>
                        <if value="$c['met_lang_mark'] && $lang['langlist_position'] eq 1 && $sub gt 1">
                        <div class="met-langlist vertical-align" m-type="lang" m-id="lang">
                            <div class="inline-block dropdown">
                                <lang>
                                <if value="($sub gt 2)?($data['lang'] eq $v['mark']):$data['lang'] neq $v['mark']">
                                    <if value="$sub gt 2">
                                    <span data-toggle="dropdown" class="met_navbtn dropdown-toggle">
                                    <else/>
                                    <a href="{$v.met_weburl}" title="{$v.name}" <if value="$v['newwindows']">target="_blank"</if> class="met-lang-other">
                                    </if>
                                        <if value="$lang['langlist1_icon_ok']">
                                        <img src="{$v.flag}" alt="{$v.name}" width="20">
                                        </if>
                                        <span>{$v.name}</span>
                                    <if value="$sub gt 2"></span><else/></a></if>
                                </if>
                                </lang>
                                <if value="$sub gt 2">
                                <ul class="dropdown-menu dropdown-menu-left animate animate-reverse" id="met-langlist-dropdown" role="menu">
                                    <lang>
                                    <if value="$data['lang'] neq $v['mark']">
                                    <a href="{$v.met_weburl}" title="{$v.name}" <if value="$v['newwindows'] eq 1">target="_blank"</if> class='dropdown-item'>
                                        <if value="$lang['langlist1_icon_ok']">
                                        <img src="{$v.flag}" alt="{$v.name}" width="20">
                                        </if>
                                        {$v.name}
                                    </a>
                                    </if>
                                    </lang>
                                </ul>
                                </if>
                            </div>
                        </div>
                        </if>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
<if value="$data['classnow']">
<tag action="banner.list"></tag>
<if value="$sub || $data['classnow'] eq 10001">
<div class="met-banner carousel slide" id="exampleCarouselDefault" data-ride="carousel" m-id='banner'  m-type='banner'>
    <ol class="carousel-indicators carousel-indicators-fall">
        <tag action="banner.list">
            <li data-slide-to="{$v._index}" data-target="#exampleCarouselDefault" class="<if value="$v['_first']">active</if>"></li>
        </tag>
    </ol>
    <if value="$sub">
    <a class="left carousel-control" href="#exampleCarouselDefault" role="button" data-slide="prev">
      <span class="icon" aria-hidden="true"><</span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#exampleCarouselDefault" role="button" data-slide="next">
      <span class="icon" aria-hidden="true">></span>
      <span class="sr-only">Next</span>
    </a>
    </if>
    <div class="carousel-inner <if value="$data['classnow'] eq 10001 && $sub eq 0">met-banner-mh</if>" role="listbox">
        <tag action="banner.list">
            <div class="carousel-item <if value="$v['_first']">active</if>">
                <if value="$v['mobile_img_path']">
                    <img class="w-full mobile_img" src="{$v.mobile_img_path}" srcset='{$v.mobile_img_path} 767w,{$v.mobile_img_path}' sizes="(max-width: 767px) 767px" alt="{$v.img_title_mobile}" pch="{$v.height}" adh="{$v.height_t}" iph="{$v.height_m}">
                    <img class="w-full pc_img" src="{$v.img_path}" srcset='{$v.img_path} 767w,{$v.img_path}' sizes="(max-width: 767px) 767px" alt="{$v.img_title}" pch="{$v.height}" adh="{$v.height_t}" iph="{$v.height_m}">
                    <else/>
                    <img class="w-full mobile_img" src="{$v.img_path}" srcset='{$v.img_path} 767w,{$v.img_path}' sizes="(max-width: 767px) 767px" alt="{$v.img_title}" pch="{$v.height}" adh="{$v.height_t}" iph="{$v.height_m}">
                    <img class="w-full pc_img" src="{$v.img_path}" srcset='{$v.img_path} 767w,{$v.img_path}' sizes="(max-width: 767px) 767px" alt="{$v.img_title}" pch="{$v.height}" adh="{$v.height_t}" iph="{$v.height_m}">
                </if>
                <if value="$v['img_title'] || $v['img_des'] || $v['button'] || $v['img_link']">
                    <div class="met-banner-text pc-content" met-imgmask>
                        <div class='container'>
                            <div class='met-banner-text-con p-{$v.img_text_position}'>
                                <div>
                                    <div>
                                    <if value="$v['img_link']">
                                        <a href="{$v.img_link}" title="{$v.img_des}" class="all-imgmask" <if value="$v['target']">target="_blank"</if>></a>
                                    </if>
                                    <if value="$v['img_title']">
                                    <h3 class="animation-slide-top animation-delay-300 font-weight-500" style="color:{$v.img_title_color};font-size: {$v.img_title_fontsize}px;">{$v.img_title}</h3>
                                    </if>
                                    <if value="$v['img_des']">
                                    <p class="animation-slide-bottom animation-delay-600" style='color:{$v.img_des_color};font-size: {$v.img_des_fontsize}px;'>{$v.img_des}</p>
                                    </if>
                                    <list data="$v['button']" name="$btn">
                                        <a href="{$btn.but_url}" title="{$btn.but_text}" <if value="$btn['target']">target="_blank"</if> class="btn slick-btn <if value="$btn['is_mobile'] eq 1">pc<elseif value="$btn['is_mobile'] eq 2"/>mobile</if>" infoset="{$btn.but_text_size}|{$btn.but_text_color}|{$btn.but_text_hover_color}|{$btn.but_color}|{$btn.but_hover_color}|{$btn.but_x}|{$btn.but_y}">{$btn.but_text}</a>
                                    </list>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </if>
                <if value="$v['img_title_mobile'] || $v['img_des_mobile'] || $v['button'] || $v['img_link']">
                    <div class="met-banner-text mobile-content" met-imgmask>
                        <div class='container'>
                            <div class='met-banner-text-con p-{$v.img_text_position_mobile} '>
                                <div>
                                    <div>
                                    <if value="$v['img_link']">
                                        <a href="{$v.img_link}" title="{$v.img_des}" class="all-imgmask" <if value="$v['target']">target="_blank"</if>></a>
                                    </if>
                                    <if value="$v['img_title_mobile']">
                                    <h3 class="animation-slide-top animation-delay-300 font-weight-500" style="color:{$v.img_title_color_mobile};font-size: {$v.img_title_fontsize_mobile}px;">{$v.img_title_mobile}</h3>
                                    </if>
                                    <if value="$v['img_des_mobile']">
                                    <p class="animation-slide-bottom animation-delay-600" style='color:{$v.img_des_color_mobile};font-size: {$v.img_des_fontsize_mobile}px;'>{$v.img_des_mobile}</p>
                                    </if>
                                    <list data="$v['button']" name="$btn">
                                        <a href="{$btn.but_url}" title="{$btn.but_text}" <if value="$btn['target']">target="_blank"</if> class="btn slick-btn <if value="$btn['is_mobile'] eq 1">pc<elseif value="$btn['is_mobile'] eq 2"/>mobile</if>" infoset="{$btn.but_text_size}|{$btn.but_text_color}|{$btn.but_text_hover_color}|{$btn.but_color}|{$btn.but_hover_color}|{$btn.but_x}|{$btn.but_y}">{$btn.but_text}</a>
                                    </list>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </if>
            </div>
        </tag>
    </div>
</div>
<else if value="$data['classnow'] neq 10001"/>
<tag action='category' type="current" cid="$data['classnow']">
<div class="met-banner-ny vertical-align text-center" m-id="banner">
    <if value="$m['module'] eq 1">
        <h2 class="vertical-align-middle">{$m.name}</h2>
        <else/>
        <h3 class="vertical-align-middle">{$m.name}</h3>
    </if>
</div>
</tag>
</if>
<if value="$data['classnow'] neq 10001"/>
    <if value="$data['name']">
        <include file="subcolumn_nav.php" />
    <else/>
        <include file="position.php" />
    </if>
</if>
</if>