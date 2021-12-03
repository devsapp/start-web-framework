<?php
defined('IN_MET') or exit('No permission');
$checkbox_time=time();
$data['columnlist']=$data['handle']['columnlist'];
unset($data['handle']);
$data['link_type']=$data['link_type']?$data['link_type']:0;
$data['show_ok']=isset($data['show_ok'])?$data['show_ok']:1;
if($data['module']){
    $data['module']=implode(',', $data['module']);
}
?>
<form method="POST" action="{$url.own_name}c=link_admin&a=doSaveLink&id={$data.id}" class="link-form" data-submit-ajax="1">
    <div class="metadmin-fmbx">
        <dl>
            <dt>
                <label class="form-control-label">{$word.linkType}</label>
            </dt>
            <dd>
                <div class="form-group clearfix">
                    <div class="custom-control custom-radio ">
                        <input type="radio" name="link_type" value="0" class="custom-control-input" id="link_type-0-{$checkbox_time}" data-checked="{$data.link_type}" />
                        <label class="custom-control-label" for="link_type-0-{$checkbox_time}">{$word.linkType4}</label>
                    </div>
                    <div class="custom-control custom-radio ">
                        <input type="radio" name="link_type" value="1" class="custom-control-input" id="link_type-1-{$checkbox_time}" />
                        <label class="custom-control-label" for="link_type-1-{$checkbox_time}">{$word.linkType5}</label>
                    </div>
                </div>
            </dd>
        </dl>
        <dl>
            <dt>
                <label class="form-control-label">{$word.linkUrl}</label>
            </dt>
            <dd>
                <div class="form-group clearfix">
                    <input type="text" name="weburl" value="{$data.weburl}" class="form-control" required />
                </div>
            </dd>
        </dl>
        <dl>
            <dt>
                <label class="form-control-label">{$word.linkLOGO}</label>
            </dt>
            <dd>
                <div class="form-group">
                    <div class="d-inline-block">
                        <input type="file" name="file" value="{$data.file}" data-plugin="fileinput" accept="image/*" />
                    </div>
                </div>
            </dd>
        </dl>
        <dl>
            <dt>
                <label class="form-control-label">{$word.linkName}</label>
            </dt>
            <dd>
                <div class="form-group clearfix">
                    <input type="text" name="webname" value="{$data.webname}" class="form-control" required />
                </div>
            </dd>
        </dl>
        <dl>
            <dt>
                <label class="form-control-label">{$word.linkKeys}</label>
            </dt>
            <dd>
                <div class="form-group clearfix">
                    <input type="text" name="info" value="{$data.info}" class="form-control" required />
                </div>
            </dd>
        </dl>
        <dl>
            <dt>
                <label class="form-control-label">{$word.sort}</label>
            </dt>
            <dd>
                <div class="form-group clearfix">
                    <input type="text" name="orderno" value="{$data.orderno}" class="form-control" />
                    <span class="text-help ml-2">{$word.linktip1}</span>
                </div>
            </dd>
        </dl>
        <dl>
            <dt>
                <label class="form-control-label">{$word.article1}</label>
            </dt>
            <dd>
                <div class="form-group clearfix">
                    <div class="custom-control custom-checkbox ">
                        <input type="checkbox" name="show_ok" value="1" data-checked="{$data.show_ok}" class="custom-control-input" id="show_ok-{$checkbox_time}" />
                        <label class="custom-control-label" for="show_ok-{$checkbox_time}">{$word.linkPass}</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="com_ok" value="1" data-checked="{$data.com_ok}" class="custom-control-input" id="com_ok-{$checkbox_time}" />
                        <label class="custom-control-label" for="com_ok-{$checkbox_time}">{$word.linkRecommend}</label>
                    </div>
                    <span class="text-help ml-2">{$word.linktip2}</span>
                </div>
            </dd>
        </dl>
        <dl>
            <dt>
                <label class="form-control-label">{$word.columnnofollow}</label>
            </dt>
            <dd>
                <div class="form-group clearfix">
                    <div class="custom-control custom-checkbox ">
                        <input type="checkbox" name="nofollow" value="1" data-checked="{$data.nofollow}" class="custom-control-input" id="nofollow" />
                        <label class="custom-control-label" for="nofollow">{$word.columnnofollowinfo}</label>
                    </div>
                </div>
            </dd>
        </dl>
        <dl>
            <dt>
                <label class="form-control-label">{$word.linkcontact}</label>
            </dt>
            <dd>
                <div class="form-group clearfix">
                    <textarea name="contact" rows="5" class="form-control mr-2">{$data.contact}</textarea>
                </div>
            </dd>
        </dl>
        <dl>
            <dt>
                <label class='form-control-label'>{$word.category}</label>
            </dt>
            <dd class='form-group'>
                <div class="border" data-plugin="checkAll">
                    <div class='px-3'>
                        <div class="custom-control custom-checkbox">
                            <input class="checkall-all custom-control-input" type="checkbox" name="met_clumid_all" value="1" data-checked="{$data.met_clumid_all}" id="met_clumid_all-{$checkbox_time}" >
                            <label class="custom-control-label" for="met_clumid_all-{$checkbox_time}">{$word.allcategory}</label>
                        </div>
                    </div>
                    <hr class="my-1">
                    <div class='px-3 met-scrollbar scrollbar-grey' style="max-height: 300px;">
                        <list data="$data['columnlist']" name="$v" num="1000">
                            <div class="custom-control custom-checkbox">
                                <input class="checkall-item custom-control-input" type="checkbox" name="module" id="module{$v._index}-{$checkbox_time}" value="{$v.id}" <if value="!$v['_index']">data-checked="{$data.module}" required data-fv-notEmpty-message="{$word.js67}"</if> data-delimiter=",">
                                <label class="custom-control-label" for="module{$v._index}-{$checkbox_time}">{$v.name}</label>
                            </div>
                            <if value="$v['subcolumn']">
                            <list data="$v['subcolumn']" name="$a" num="1000">
                                <div class="custom-control custom-checkbox ml-3">
                                    <input class="checkall-item custom-control-input" type="checkbox" name="module" id="module{$v._index}-{$a._index}-{$checkbox_time}" value="{$a.id}" data-delimiter=",">
                                    <label class="custom-control-label" for="module{$v._index}-{$a._index}-{$checkbox_time}">{$a.name}</label>
                                </div>
                                <if value="$a['subcolumn']">
                                <list data="$a['subcolumn']" name="$b" num="1000">
                                    <div class="custom-control custom-checkbox ml-5">
                                        <input class="checkall-item custom-control-input" type="checkbox" name="module" id="module{$v._index}-{$a._index}-{$b._index}-{$checkbox_time}" value="{$b.id}" data-delimiter=",">
                                        <label class="custom-control-label" for="module{$v._index}-{$a._index}-{$b._index}-{$checkbox_time}">{$b.name}</label>
                                    </div>
                                </list>
                                </if>
                            </list>
                            </if>
                        </list>
                    </div>
                </div>
            </dd>
        </dl>
    </div>
</form>