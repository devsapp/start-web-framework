<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>管理员后台登陆</title>

    <!-- zui -->
    <link href="{SITE_URL}static/css/dist/css/zui.min.css" rel="stylesheet">
  <!-- Font Awesome Icons -->
    <link href="{SITE_URL}static/css/static/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />


        <link href="{SITE_URL}static/css/admin/mishen.css" rel="stylesheet" type="text/css" />
    <!--[if lt IE 9]>
    <script src="{SITE_URL}static/css/dist/lib/ieonly/html5shiv.js"></script>
    <script src="{SITE_URL}static/css/dist/lib/ieonly/respond.js"></script>
    <![endif]-->
<style>

.form-control-feedback {
    position: absolute;
    top: 0;
    right: 0;
    z-index: 2;
    display: block;
    width: 34px;
    height: 34px;
    line-height: 34px;
    text-align: center;
    pointer-events: none;
}
</style>
</head>
<body class="login-page" >
<!--[if lt IE 8]>
<div class="alert alert-danger">您正在使用 <strong>过时的</strong> 浏览器. 是时候 <a href="http://browsehappy.com/">更换一个更好的浏览器</a> 来提升用户体验.</div>
<![endif]-->
<div class="login-box">
    <div class="login-box-body">
        <p class="login-box-msg">管理员 管理后台</p>
        <form class="form-horizontal slideInLeft animated " role="form" id="logindev" action="index.php?admin_main/login" method="post">

            <div class="form-group has-feedback ">
                <input type="text" id="username" name="username"   AUTOCOMPLETE="OFF" class="form-control" placeholder="用户名" value="" >
                <span class="fa fa-user form-control-feedback"></span>
                <i class=""></i>
            </div>

            <div class="form-group has-feedback ">
                <input type="password" name="password"  AUTOCOMPLETE="OFF" class="form-control" placeholder="密码">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                            </div>


            <div class="form-group has-feedback">
                <button  type="submit" name="submit" id="submit" class="btn bg-olive btn-block btn-flat">登录</button>
            </div>
        </form>
    </div><!-- /.login-box-body -->
</div>


</body>
</html>