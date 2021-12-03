<?php
# MetInfo Enterprise Content Management System
# Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved.
echo <<<EOT
-->
<div class="container my-5 py-5 text-center">
	<h1>欢迎使用米拓企业建站系统</h1>
	<div class="row mt-5">
		<div class="col-lg-6 px-lg-5">
			<div class="card shadow">
				<div class="card-body py-5">
					<p class="text-success h6">使用SQLite数据库，无需安装，简单方便！</p>
					<div class="text-left mt-4">
						<div class="form-group row mb-0">
							<label class="col-sm-5 col-form-label text-sm-right text-muted">网站后台地址</label>
							<div class="col-sm-7">
								<span class="col-form-label d-block">{$siteurl}admin/</span>
							</div>
						</div>
						<div class="form-group row mb-0">
							<label class="col-sm-5 col-form-label text-sm-right text-muted">后台登录账号</label>
							<div class="col-sm-7">
								<span class="col-form-label d-block">admin</span>
							</div>
						</div>
						<div class="form-group row mb-0">
							<label class="col-sm-5 col-form-label text-sm-right text-muted">后台登录密码</label>
							<div class="col-sm-7">
								<span class="col-form-label d-block">admin</span>
							</div>
						</div>
					</div>
					<a href="index.php?action=skipInstall" class="btn btn-lg btn-success mt-4">直接使用</a>
				</div>
			</div>
		</div>
		<div class="col-lg-6 px-lg-5 mt-4 mt-lg-0">
			<div class="card shadow h-100">
				<div class="card-body py-5 d-flex flex-column">
					<div class="h6 text-primary media-body d-flex mb-0 align-items-center">
						<div class="w-100">
							使用MySQL数据库，高效稳定！<b class="text-danger">推荐使用！</b><br><br>安装过程可自行设置管理员账号密码
						</div>
					</div>
					<div class="mt-4">
						<a href="index.php?action=inspect" class="btn btn-lg btn-primary">传统安装</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--
EOT;
?>