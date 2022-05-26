<?php defined('IN_MET') or exit('No permission'); ?>
<include file="head.php" />
<section class="met-sitemap animsition">
    <div class="container">
        <div class="row">
            <div class="met-sitemap-body">
                <ul class="sitemap-list m-0 ulstyle blue-grey-500" m-id='{$ui.mid}'>
                    <tag action='category' type='head'>
                    <li>
                        <a href='{$m.url}' title='{$m.name}' target='_self'>
                            <i class="icon wb-menu m-r-10" aria-hidden="true"></i>
                            {$m.name}
                        </a>
                        <if value="$m['sub']">
                        <ul>
                            <tag action='category' type="son" cid="$m['id']">
                            <li>
                                <a href='{$m.url}' title='{$m.name}' target='_self'>
                                    <i class="icon wb-link pull-xs-right"></i>
                                    <span>{$m.name}</span>
                                </a>
                            </li>
                            <if value="$m['sub']">
                            <ul class="sitemap-list-sub">
                                <tag action='category' type="son" cid="$m['id']">
                                <li>
                                    <a href='{$m.url}' title='{$m.name}' target='_self'>{$m.name}</a>
                                </li>
                                </tag>
                            </ul>
                            </if>
                            </tag>
                        </ul>
                        </if>
                    </li>
                    </tag>
                </ul>
            </div>
        </div>
    </div>
</section>
<include file="foot.php" />