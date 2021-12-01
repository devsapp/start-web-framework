<!DOCTYPE html>
<html>
<head>
{eval $user=$this->user; $setting=$this->setting;}
    <meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>


     <title>Ask2后台管理系统</title>

    <!-- zui -->
    <link href="{SITE_URL}static/css/dist/css/zui.min.css" rel="stylesheet">


    <!--[if lt IE 9]>
    <script src="{SITE_URL}static/css/dist/lib/ieonly/html5shiv.js"></script>
    <script src="{SITE_URL}static/css/dist/lib/ieonly/respond.js"></script>
    <![endif]-->

      <script src="{SITE_URL}static/js/jquery-1.11.3.min.js"></script>
    <!-- ZUI Javascript组件 -->
    <script src="{SITE_URL}static/css/dist/js/zui.min.js"></script>

     <link href="{SITE_URL}static/css/static/css/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{SITE_URL}static/css/static/css/icheck/all.css" rel="stylesheet" type="text/css" />
    <link href="{SITE_URL}static/css/static/js/scojs/sco.message.css" rel="stylesheet" type="text/css" />
    <link href="{SITE_URL}static/css/static/js/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="{SITE_URL}static/css/static/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

      <!-- Theme style -->
    <link href="{SITE_URL}static/css/admin/admin.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link href="{SITE_URL}static/css/admin/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
        <link href="{SITE_URL}static/css/dist/css/custom.css" rel="stylesheet">

 <script type="text/javascript">var g_site_url = "{SITE_URL}";
            var g_site_name = "{$setting['site_name']}";
            var g_prefix = "{$setting['seo_prefix']}";
            var g_suffix = "{$setting['seo_suffix']}";
            var query = '?';
            var g_uid = {$user['uid']};


            $("input[type=radio]").css("display","inline-block");
            $("input[type=checkbox]").css("display","inline-block");
            $("td input[type=text],textarea,select").addClass('form-control').css("width","auto").css("display","inline-block");

            function checkall(checkname) {
                var chkall = $("#chkall:checked").val();
                if (chkall && (chkall === 'chkall')) {
                    $("input[name^='" + checkname + "']").each(function() {
                        $(this).prop("checked", "checked");
                    });
                } else {
                    $("input[name^='" + checkname + "']").each(function() {
                        $(this).removeProp("checked");
                    });
                }
            }
            </script>

</head>
<body class="skin-blue sidebar-mini ">
<div class="wrapper">
    <header class="main-header">
        <!-- Logo -->

        <div class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>A</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg text-center">
                <a class="navbar-brand admin_logo"  href="{SITE_URL}"></a>
            </span>

        </div>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" id="sliderbar_control"  data-toggle="offcanvas" role="button">
                <span class="sr-only">切换导航</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Notifications: style can be found in dropdown.less -->
                    <li class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                           <!--{if $verifyquestions||$verifyanswers }-->
                            <span class="label label-warning">{eval echo ($verifyquestions+$verifyanswers);}</span>
                               <!--{/if}-->
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">共有 {eval echo ($verifyquestions+$verifyanswers);} 个待处理事项</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                {if $num>0}
                                <ul class="menu">
                                    {if $verifyquestions>0}
                                    <li>
                                        <a href="index.php?admin_question/examine{$setting['seo_suffix']}">
                                            <i class="fa fa-question-circle text-yellow"></i> {$verifyquestions} 个问题需要审核
                                        </a>
                                    </li>
                                    {/if}
                                    {if $verifyanswers>0}
                                    <li>
                                        <a href="index.php?admin_question/examineanswer{$setting['seo_suffix']}">
                                            <i class="fa fa-comment-o text-yellow"></i> {$verifyanswers} 个回答需要审核
                                        </a>
                                    </li>
                                  {/if}

                                </ul>
                               {/if}
                            </li>
                        </ul>
                    </li>
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                     <span class="hidden-xs">{$user['username']}<i class="icon icon-chevron-down mar-l-05"></i></span>
                        </a>
                        <ul class="dropdown-menu admin-menu ">

                            <!-- Menu footer}-->
                            <li class="b-b-line">

                                   <a href="index.php?admin_user/edit/ {$user['uid']}{$setting['seo_suffix']}" ><i class="icon icon-edit mar-r-05"></i>修改密码</a>

                            </li>
                               <li >

                                          <a href="index.php?admin_main/logout{$setting['seo_suffix']}"><i class="fa fa-power-off mar-r-05"></i>退出登录</a>




                            </li>

                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!--{template public_menu-->
        </section>
        <!-- /.sidebar -->



    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

       <IFRAME style="OVERFLOW: visible" name="main" src="index.php?admin_main/stat{$setting['seo_suffix']}" frameBorder=0 width="100%" scrolling="yes" height="900px;"></IFRAME>






    <!--{template footer}-->
