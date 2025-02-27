
> 注：当前项目为 Serverless Devs 应用，由于应用中会存在需要初始化才可运行的变量（例如应用部署地区、函数名等等），所以**不推荐**直接 Clone 本仓库到本地进行部署或直接复制 s.yaml 使用，**强烈推荐**通过 `s init ${模版名称}` 的方法或应用中心进行初始化，详情可参考[部署 & 体验](#部署--体验) 。

# start-laravel-cap 帮助文档

<description>

本案例展示了如何将 Laravel，一款基于 PHP 编程语言的流行 Web 应用框架，快速部署到云原生应用开发平台 CAP，实现快速构建云原生应用的实践。Laravel 以其简洁优雅的语法、全面而先进的工具和功能著称，广泛应用于 Web 应用程序开发。

</description>


## 资源准备

使用该项目，您需要有开通以下服务并拥有对应权限：

<service>



| 服务/业务 |  权限  | 相关文档 |
| --- |  --- | --- |
| 函数计算 |  AliyunFCFullAccess | [帮助文档](https://help.aliyun.com/product/2508973.html) [计费文档](https://help.aliyun.com/document_detail/2512928.html) |
| 日志服务 |  AliyunFCServerlessDevsRolePolicy | [帮助文档](https://help.aliyun.com/zh/sls) [计费文档](https://help.aliyun.com/zh/sls/product-overview/billing) |

</service>

<remark>



</remark>

<disclaimers>



</disclaimers>

## 部署 & 体验

<appcenter>
   
- :fire: 通过 [云原生应用开发平台 CAP](https://cap.console.aliyun.com/template-detail?template=start-laravel-cap) ，[![Deploy with Severless Devs](https://img.alicdn.com/imgextra/i1/O1CN01w5RFbX1v45s8TIXPz_!!6000000006118-55-tps-95-28.svg)](https://cap.console.aliyun.com/template-detail?template=start-laravel-cap) 该应用。
   
</appcenter>
<deploy>
    
   
</deploy>

## 案例介绍

<appdetail id="flushContent">

本案例是将非常流行的基于PHP编程语言的开发框架 Laravel 快速部署到云原生应用开发平台 CAP。

Laravel框架是一种基于PHP编程语言开发的开源web应用框架。该框架自2011年由Taylor Otwell创建以来，已经发展成为PHP社区中最知名的框架之一，并由一支大约50名核心成员维护和发展。Laravel框架采用了Model-View-Controller（MVC）软件设计模式，使得在构建web应用程序方面非常强大和灵活。具有富有表现力、优雅的语法，提供了一套全面而先进的工具和功能，旨在简化和加速开发过程。这些工具和功能包括面向对象的代码结构、强大的路由和请求处理能力等。

此外，Laravel还提供了多种不同的数据库支持，包括MySQL、PostgreSQL、SQLite和SQL Server。还包括了多种用于生成HTML、CSS和JavaScript的工具和库，以及内置的用户管理、角色管理、菜单管理、职级管理、岗位管理、部门管理、操作日志、登录日志、字典管理、配置管理、城市管理、个人中心、广告管理和站点栏目等模块，这些模块能够帮助开发者更加高效地构建和管理web应用程序。Laravel框架为开发者提供了一个强大而灵活的工具集，使得开发web应用程序变得更加简单和高效。

通过云原生应用开发平台 CAP，您只需要几步，就可以体验 Laravel 框架，并享受Serverless 架构带来的降本提效的技术红利。

</appdetail>







## 使用流程

<usedetail id="flushContent">

### 查看部署的案例
部署完成之后，您可以看到系统返回给您的案例地址，打开案例地址，就可以进入 Laravel 首页：

![](https://img.alicdn.com/imgextra/i4/O1CN01zFNnFg24O5t2dI6V9_!!6000000007380-0-tps-2708-1300.jpg)

</usedetail>

## 二次开发指南

<development id="flushContent">
</development>






