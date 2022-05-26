<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
defined('IN_MET') or exit('No permission');

?>
<div class="met-imgmanage-thumbs">
<include file="pub/head_tab"/>
<form    method="POST" action="{$url.own_name}c=imgmanager&a=doSaveThumbs"  class='imgmanager-form' data-submit-ajax='1'>
  	<div class="metadmin-fmbx">
    <dl>
			<dt>
				<label class='form-control-label'>{$word.upfiletips23}</label>
			</dt>
			<dd>
				<div class='form-group clearfix'>
				<div class="custom-control custom-radio ">
					<input type="radio"  id="met_thumb_kind-1" name="met_thumb_kind" value='1'   class="custom-control-input " />
					<label class="custom-control-label" for="met_thumb_kind-1">{$word.upfiletips20}</label>
				</div>
				<div class="custom-control custom-radio ">
					<input type="radio" id="met_thumb_kind-2" name="met_thumb_kind" value='2' class="custom-control-input "/>
					<label class="custom-control-label" for="met_thumb_kind-2">{$word.upfiletips21}</label>
				</div>
				<div class="custom-control custom-radio ">
					<input type="radio" id="met_thumb_kind-3" name="met_thumb_kind" value='3' class="custom-control-input "/>
					<label class="custom-control-label" for="met_thumb_kind-3">{$word.upfiletips22}</label>
				</div>
				<span class="text-help">{$word.thumbs_tips1_v6}</span>
				</div>
			</dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.mod3}{$word.setskinListPage}</label>
			</dt>
			<dd>
				<div class='form-group clearfix '>
					<input type="text" name="met_productimg_x" class="form-control width-100"  />
					<span class="float-left line-height-35 ml-2 mr-2 ">X</span>
					<input type="text" name="met_productimg_y" class="form-control width-100"  />
					<span class="text-help ml-2">{$word.thumb_tips}</span>
				</div>
			</dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.mod3}{$word.page_for_details}</label>
			</dt>
			<dd>
				<div class='form-group clearfix '>
					<input type="text" name="met_productdetail_x" class="form-control width-100"  />
					<span class="float-left line-height-35 ml-2 mr-2 ">X</span>
					<input type="text" name="met_productdetail_y" class="form-control width-100"  />
					<span class="text-help ml-2">{$word.thumb_tips}</span>
				</div>
			</dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.mod5}{$word.setskinListPage}</label>
			</dt>
			<dd>
				<div class='form-group clearfix '>
					<input type="text" name="met_imgs_x" class="form-control width-100"  />
					<span class="float-left line-height-35 ml-2 mr-2 ">X</span>
					<input type="text" name="met_imgs_y" class="form-control width-100"  />
					<span class="text-help ml-2">{$word.thumb_tips}</span>
				</div>
			</dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.mod5}{$word.page_for_details}</label>
			</dt>
			<dd>
				<div class='form-group clearfix '>
					<input type="text" name="met_imgdetail_x" class="form-control width-100"  />
					<span class="float-left line-height-35 ml-2 mr-2 ">X</span>
					<input type="text" name="met_imgdetail_y" class="form-control width-100"  />
					<span class="text-help ml-2">{$word.thumb_tips}</span>
				</div>
			</dd>
		</dl>
		<dl>
			<dt>
				<label class='form-control-label'>{$word.mod2}{$word.setskinListPage}</label>
			</dt>
			<dd>
				<div class='form-group clearfix '>
					<input type="text" name="met_newsimg_x" class="form-control width-100"  />
					<span class="float-left line-height-35 ml-2 mr-2 ">X</span>
					<input type="text" name="met_newsimg_y" class="form-control width-100"  />
					<span class="text-help ml-2">{$word.thumb_tips}</span>
				</div>
			</dd>
		</dl>
		<dl>
			<dt></dt>
			<dd>
				<button  type="submit"  class='btn btn-primary' id="btn-save" >{$word.Submit}</button>
			</dd>
		</dl>
    </div>
    </form>
		</div>