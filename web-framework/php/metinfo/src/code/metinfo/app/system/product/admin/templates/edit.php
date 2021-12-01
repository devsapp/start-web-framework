<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');
?>
<include file="pub/content_details/head"/>
<input type="hidden" name="imgurl_l" value="{$data.list.imgurl}">
<if value="$data['displayimgs']"></div></if>
<?php
$upload = array(
    'title' => $word['displayimg'],
    'name' => 'imgurl',
    'value' => $data['list']['imgurl_all'],
    'multiple' => 1,
    'tips' => $word['tips11_v6'],
    'size' => 1,
    'delimiter' => '|'
);
?>
<include file="pub/content_details/upload"/>
<if value="$data['displayimgs']"><div hidden></if>
<include file="pub/content_details/paraset"/>
<include file="pub/content_details/content_seo_other"/>
<if value="$data['displayimgs']"></div></if>
</div>
</form>