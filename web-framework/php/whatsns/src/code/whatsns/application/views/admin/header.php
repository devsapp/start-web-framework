<!DOCTYPE html>
<html>
<head>
{eval $user=$this->user; $setting=$this->setting;}

{eval 	$vertifyusers = returnarraynum ( $this->db->query ( getwheresql ( "vertify", "status=0", $this->db->dbprefix ) )->row_array () );$verifyarticlecomments = returnarraynum ( $this->db->query ( getwheresql ( 'articlecomment', '`state`=0', $this->db->dbprefix ) )->row_array () ); $verifyquestions = returnarraynum ( $this->db->query ( getwheresql ( 'question', '`status`=0', $this->db->dbprefix ) )->row_array () );$verifyanswers = returnarraynum ( $this->db->query ( getwheresql ( 'answer', '`status`=0', $this->db->dbprefix ) )->row_array () );$verifyarticles = returnarraynum ( $this->db->query ( getwheresql ( 'topic', '`state`=0', $this->db->dbprefix ) )->row_array () );}
		
    <meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>


     <title>{$setting['site_name']}后台管理系统</title>

    <!-- zui -->
    <link href="{SITE_URL}static/css/dist/css/zui.min.css" rel="stylesheet">



      <script src="{SITE_URL}static/js/jquery-1.11.3.min.js"></script>
    <!-- ZUI Javascript组件 -->
    <script src="{SITE_URL}static/css/dist/js/zui.min.js"></script>
    <!--[if lt IE 9]>
    <script src="{SITE_URL}static/css/dist/lib/ieonly/html5shiv.js"></script>
    <script src="{SITE_URL}static/css/dist/lib/ieonly/respond.js"></script>
    <![endif]-->


    <link href="{SITE_URL}static/css/static/css/icheck/all.css" rel="stylesheet" type="text/css" />
    <link href="{SITE_URL}static/css/static/js/scojs/sco.message.css" rel="stylesheet" type="text/css" />
    <link href="{SITE_URL}static/css/static/js/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="{SITE_URL}static/css/static/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

      <!-- Theme style -->
    <link href="{SITE_URL}static/css/admin/mishen.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link href="{SITE_URL}static/css/admin/skins/skin-blue.min.css" rel="stylesheet" type="text/css" />
        <link href="{SITE_URL}static/css/admin/main.css" rel="stylesheet">
        <link href="{SITE_URL}static/css/dist/css/custom.css" rel="stylesheet">

 <script type="text/javascript">var g_site_url = "{SITE_URL}";
            var g_site_name = "{$setting['site_name']}";
            var g_prefix = "{$setting['seo_prefix']}";
            var g_suffix = "{$setting['seo_suffix']}";
            var query = '?';
            var g_uid = {$user['uid']};


            $("input[type=radio]").css("display","inline-block");
            $("input[type=checkbox]").css("display","inline-block");


            function checkall(checkname) {
                var chkall = $("#chkall:checked").val();
                if (chkall && (chkall === 'chkall')) {
                    $("#btnsetanswertaocan").val("删  除");
                    $("input[name^='" + checkname + "']").each(function() {
                        $(this).prop("checked", "checked");
                    });
                } else {
                    $("#btnsetanswertaocan").val("添  加");
                    $("input[name^='" + checkname + "']").each(function() {
                        $(this).removeProp("checked");
                    });
                }
            }
            </script>

</head>
<body class="skin-blue sidebar-mini " >
<div class="wrapper" >
    <header class="main-header" style="position:fixed;top:0px;left:0px;width:100%;">
        <!-- Logo -->
  {if !is_mobile()}
        <div class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>A</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg text-center">
                <a class="navbar-brand admin_logo"  href="{SITE_URL}index.php?admin_main/stat{$setting['seo_suffix']}"></a>
            </span>

        </div>
 {/if}
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
                           <!--{if isset($vertifyusers)||isset($verifyquestions)||isset($verifyanswers)||isset($verifyarticles)||isset($verifyarticlecomments) }-->
                            <span class="label label-warning">{eval echo ($vertifyusers+$verifyquestions+$verifyanswers+$verifyarticles+$verifyarticlecomments);}</span>
                               <!--{/if}-->
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">共有 {eval echo ($vertifyusers+$verifyquestions+$verifyanswers+$verifyarticles+$verifyarticlecomments);} 个待处理事项</li>
                            <li>
                                <!-- inner menu: contains the actual data -->

                                <ul class="menu">
                                    {if isset($verifyquestions)&&$verifyquestions>0}
                                    <li>
                                        <a href="{SITE_URL}index.php?admin_question/examine{$setting['seo_suffix']}">
                                            <i class="fa fa-question-circle text-yellow"></i> {$verifyquestions} 个问题需要审核
                                        </a>
                                    </li>
                                    {/if}
                                    {if isset($verifyanswers)&&$verifyanswers>0}
                                    <li>
                                        <a href="{SITE_URL}index.php?admin_question/examineanswer{$setting['seo_suffix']}">
                                            <i class="fa fa-comment-o text-yellow"></i> {$verifyanswers} 个回答需要审核
                                        </a>
                                    </li>
                                 {/if}
                                       {if isset($verifyarticles)&&$verifyarticles>0}
                                    <li>
                                        <a href="{SITE_URL}index.php?admin_topic/shenhe{$setting['seo_suffix']}">
                                            <i class="fa fa-comment-o text-yellow"></i> {$verifyarticles} 篇文章需要审核
                                        </a>
                                    </li>
                                 {/if}
                                      {if isset($verifyarticlecomments)&&$verifyarticlecomments>0}
                                    <li>
                                        <a href="{SITE_URL}index.php?admin_topic/vertifycomments{$setting['seo_suffix']}">
                                            <i class="fa fa-comment-o text-yellow"></i> {$verifyarticlecomments} 个文章评论需要审核
                                        </a>
                                    </li>
                                 {/if}
                                      {if isset($vertifyusers)&& $vertifyusers>0}
                                    <li>
                                        <a href="{SITE_URL}index.php?admin_vertifyuser/default{$setting['seo_suffix']}">
                                            <i class="fa fa-comment-o text-yellow"></i> {$vertifyusers} 个认证需要审核
                                        </a>
                                    </li>
                                 {/if}
                               

                                </ul>

                            </li>
                        </ul>
                    </li>
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                     <span class="hidden-xs">{$user['username']}<i class="icon icon-chevron-down mar-l-05"></i></span>
                        </a>
                        <ul class="dropdown-menu admin-menu ">


                            <li class="b-b-line">

                                   <a href="{SITE_URL}index.php?admin_user/edit/{$user['uid']}{$setting['seo_suffix']}" ><i class="icon icon-edit mar-r-05"></i>修改密码</a>

                            </li>
                               <li >

                                          <a href="{SITE_URL}index.php?admin_main/logout{$setting['seo_suffix']}"><i class="fa fa-power-off mar-r-05"></i>退出登录</a>




                            </li>

                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar" style="left:0px;min-height: 100%;width: 230px;">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!--{template public_menu,admin}-->
        </section>
        <!-- /.sidebar -->



    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="margin-top:55px;">




