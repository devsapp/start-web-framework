<?php defined('IN_MET') or exit('No permission'); ?>
<tag action='job.list' num="$c['met_job_list']" cid="$data['classnow']"></tag>
<list data="$result" num="$c['met_job_list']" name="$v">
<div class="card card-shadow">
	<h4 class='card-title p-0 font-size-24'><if value="$v['_position']">{$v._position}<else/>{$v.position}</if></h4>
	<p class="card-metas font-size-12 blue-grey-400">
		<span class='m-r-10'>{$v.addtime}</span>
		<span class='m-r-10'>
			<i class="icon wb-map m-r-5" aria-hidden="true"></i>
			{$v.place}
		</span>
		<span class='m-r-10'>
			<i class="icon wb-user m-r-5" aria-hidden="true"></i>
			{$v.count}
		</span>
		<span>
			<i class="icon wb-payment m-r-5" aria-hidden="true"></i>
			{$v.deal}
		</span>
	</p>
	<hr>
	<div class="met-editor clearfix">
		{$v.content}
	</div>
	<hr>
	<div class="card-body-footer m-t-0">
		<a class="btn btn-outline btn-squared btn-primary met-job-cvbtn" href="javascript:;" data-toggle="modal" data-target="#met-job-cv{$v._index}" data-jobid="{$v.id}" data-cvurl="cv.php?lang=cn&selected">{$ui.cvtitle}</a>
	</div>
	<div class="modal fade modal-primary" id="met-job-cv{$v._index}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">{$ui.cvtitle}</h4>
                </div>
                <div class="modal-body">
                    <tag action='job.form' cid="$v['id']"></tag>
                </div>
            </div>
        </div>
    </div>
</div>
</list>