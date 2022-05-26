<if value="$lang['tagshow_1']">
<section class="met-crumbs hidden-sm-down" m-id='met_position' m-type='nocontent'>
    <div class="container">
        <div class="row">
            <div class="border-bottom clearfix">
                <ol class="breadcrumb m-b-0 subcolumn-crumbs breadcrumb-arrow">
                    <li class='breadcrumb-item'>
                        {$lang.position_text}
                    </li>
                    <li class='breadcrumb-item'>
                        <a href="{$c.met_weburl}" title="{$word.home}" class='icon wb-home'>{$word.home}</a>
                    </li>
                    <location>
                    <if value="$v">
                        <li class='breadcrumb-item'>
                            <a href="{$v.url}" title="{$v.name}" class='{$v.class}'>{$v.name}</a>
                        </li>
                    </if>
                    </location>
                </ol>
            </div>
        </div>
    </div>
</section>
</if>