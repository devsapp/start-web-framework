
> 注：当前项目为 Serverless Devs 应用，由于应用中会存在需要初始化才可运行的变量（例如应用部署地区、函数名等等），所以**不推荐**直接 Clone 本仓库到本地进行部署或直接复制 s.yaml 使用，**强烈推荐**通过 `s init ${模版名称}` 的方法或应用中心进行初始化，详情可参考[部署 & 体验](#部署--体验) 。

# start-laravel-v3 帮助文档
<p align="center" class="flex justify-center">
    <a href="https://www.serverless-devs.com" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-laravel-v3&type=packageType">
  </a>
  <a href="http://www.devsapp.cn/details.html?name=start-laravel-v3" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-laravel-v3&type=packageVersion">
  </a>
  <a href="http://www.devsapp.cn/details.html?name=start-laravel-v3" class="ml-1">
    <img src="http://editor.devsapp.cn/icon?package=start-laravel-v3&type=packageDownload">
  </a>
</p>

<description>

本案例是将非常流行的基于PHP编程语言的开发框架 Laravel 快速部署到阿里云函数计算 FC。

</description>

<codeUrl>



</codeUrl>
<preview>



</preview>


## 前期准备

使用该项目，您需要有开通以下服务并拥有对应权限：

<service>



| 服务/业务 |  权限  | 相关文档 |
| --- |  --- | --- |
| 函数计算 |  AliyunFCFullAccess | [帮助文档](https://help.aliyun.com/product/2508973.html) [计费文档](https://help.aliyun.com/document_detail/2512928.html) |

</service>

<remark>



</remark>

<disclaimers>



</disclaimers>

## 部署 & 体验

<appcenter>
   
- :fire: 通过 [Serverless 应用中心](https://fcnext.console.aliyun.com/applications/create?template=start-laravel-v3) ，
  [![Deploy with Severless Devs](https://img.alicdn.com/imgextra/i1/O1CN01w5RFbX1v45s8TIXPz_!!6000000006118-55-tps-95-28.svg)](https://fcnext.console.aliyun.com/applications/create?template=start-laravel-v3) 该应用。
   
</appcenter>
<deploy>
    
- 通过 [Serverless Devs Cli](https://www.serverless-devs.com/serverless-devs/install) 进行部署：
  - [安装 Serverless Devs Cli 开发者工具](https://www.serverless-devs.com/serverless-devs/install) ，并进行[授权信息配置](https://docs.serverless-devs.com/fc/config) ；
  - 初始化项目：`s init start-laravel-v3 -d start-laravel-v3`
  - 进入项目，并进行项目部署：`cd start-laravel-v3 && s deploy -y`
   
</deploy>

## 案例介绍

<appdetail id="flushContent">

本案例是将非常流行的基于PHP编程语言的开发框架 Laravel 快速部署到阿里云函数计算 FC。

Laravel框架是一种基于PHP编程语言开发的开源web应用框架。该框架自2011年由Taylor Otwell创建以来，已经发展成为PHP社区中最知名的框架之一，并由一支大约50名核心成员维护和发展。Laravel框架采用了Model-View-Controller（MVC）软件设计模式，使得在构建web应用程序方面非常强大和灵活。具有富有表现力、优雅的语法，提供了一套全面而先进的工具和功能，旨在简化和加速开发过程。这些工具和功能包括面向对象的代码结构、强大的路由和请求处理能力等。

此外，Laravel还提供了多种不同的数据库支持，包括MySQL、PostgreSQL、SQLite和SQL Server。还包括了多种用于生成HTML、CSS和JavaScript的工具和库，以及内置的用户管理、角色管理、菜单管理、职级管理、岗位管理、部门管理、操作日志、登录日志、字典管理、配置管理、城市管理、个人中心、广告管理和站点栏目等模块，这些模块能够帮助开发者更加高效地构建和管理web应用程序。Laravel框架为开发者提供了一个强大而灵活的工具集，使得开发web应用程序变得更加简单和高效。

通过 Serverless 开发平台，您只需要几步，就可以体验 Laravel 框架，并享受Serverless 架构带来的降本提效的技术红利。


</appdetail>

## 使用流程

<usedetail id="flushContent">

### 查看部署的案例
部署完成之后，您可以看到系统返回给您的案例地址，打开案例地址，就可以进入 Laravel 首页：

![](https://img.alicdn.com/imgextra/i4/O1CN01zFNnFg24O5t2dI6V9_!!6000000007380-0-tps-2708-1300.jpg)

### 二次开发

您可以通过云端控制台的开发功能进行二次开发。如果您之前是在本地创建的项目案例，也可以在本地项目目录`start-laravel-v3`文件夹下，对项目进行二次开发。开发完成后，可以通过`s deploy`进行快速部署。

</usedetail>

## 注意事项

<matters id="flushContent">
</matters>


<devgroup>


## 开发者社区

您如果有关于错误的反馈或者未来的期待，您可以在 [Serverless Devs repo Issues](https://github.com/serverless-devs/serverless-devs/issues) 中进行反馈和交流。如果您想要加入我们的讨论组或者了解 FC 组件的最新动态，您可以通过以下渠道进行：

<p align="center">  

| <img src="https://serverless-article-picture.oss-cn-hangzhou.aliyuncs.com/1635407298906_20211028074819117230.png" width="130px" > | <img src="https://serverless-article-picture.oss-cn-hangzhou.aliyuncs.com/1635407044136_20211028074404326599.png" width="130px" > | <img src="https://serverless-article-picture.oss-cn-hangzhou.aliyuncs.com/1635407252200_20211028074732517533.png" width="130px" > |
| --------------------------------------------------------------------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------- |
| <center>微信公众号：`serverless`</center>                                                                                         | <center>微信小助手：`xiaojiangwh`</center>                                                                                        | <center>钉钉交流群：`33947367`</center>                                                                                           |
</p>
</devgroup>
