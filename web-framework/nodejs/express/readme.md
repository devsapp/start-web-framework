
> 注：当前项目为 Serverless Devs 应用，由于应用中会存在需要初始化才可运行的变量（例如应用部署地区、函数名等等），所以**不推荐**直接 Clone 本仓库到本地进行部署或直接复制 s.yaml 使用，**强烈推荐**通过 `s init ${模版名称}` 的方法或应用中心进行初始化，详情可参考[部署 & 体验](#部署--体验) 。

# start-express-cap 帮助文档

<description>

本案例展示了如何将 Express，一款基于 Node.js 平台的极简且灵活的 Web 应用开发框架，快速创建并部署到云原生应用开发平台 CAP。Express 框架其强大的特性、路由管理、中间件支持和模板引擎，广泛应用于 Web 和移动应用开发。

</description>


## 资源准备

使用该项目，您需要有开通以下服务并拥有对应权限：

<service>



| 服务/业务 |  权限  | 相关文档 |
| --- |  --- | --- |
| 函数计算 |  AliyunFCFullAccess | [帮助文档](https://help.aliyun.com/product/2508973.html) [计费文档](https://help.aliyun.com/document_detail/2512928.html) |
| 日志服务 |  AliyunFCServerlessDevsRolePolicy | [帮助文档](https://help.aliyun.com/zh/sls) [计费文档](https://help.aliyun.com/zh/sls/product-overview/billing) |
| 对象存储 |  AliyunOSSFullAccess | [帮助文档](https://help.aliyun.com/zh/oss) [计费文档](https://help.aliyun.com/zh/oss/product-overview/billing) |

</service>

<remark>



</remark>

<disclaimers>



</disclaimers>

## 部署 & 体验

<appcenter>
   
- :fire: 通过 [云原生应用开发平台 CAP](https://cap.console.aliyun.com/template-detail?template=start-express-cap) ，[![Deploy with Severless Devs](https://img.alicdn.com/imgextra/i1/O1CN01w5RFbX1v45s8TIXPz_!!6000000006118-55-tps-95-28.svg)](https://cap.console.aliyun.com/template-detail?template=start-express-cap) 该应用。
   
</appcenter>
<deploy>
    
   
</deploy>

## 案例介绍

<appdetail id="flushContent">

本案例是将 Express 框架，这一基于 Node.js 平台的极简且灵活的 web 应用开发框架，快速创建并部署到云原生应用开发平台 CAP。

Express 提供了一系列强大的特性用于开发 web 和移动应用。Express 框架遵循了 MVC（模型-视图-控制器）架构模式，使得开发过程更加清晰和易于管理。

Express 框架具有许多优点，提供了路由管理、中间件支持、模板引擎，是一个高度可扩展的框架，开发者可以通过添加第三方中间件和库来扩展其功能，使得 Express 可以适应各种复杂的 web 应用需求。

由于 Express 是基于 Node.js 的，因此它可以充分利用 Node.js 的非阻塞 I/O 模型和事件驱动机制，实现高性能的 web 应用。

通过云原生应用开发平台 CAP，您只需要几步，就可以体验 Express 框架，并享受 Serverless 架构带来的降本提效的技术红利。

</appdetail>







## 使用流程

<usedetail id="flushContent">

### 查看部署的案例

部署完成之后，您可以看到系统返回给您的案例地址,    此时，打开案例地址：

![图片alt](https://img.alicdn.com/imgextra/i3/O1CN01AutMV11svHIvSinKW_!!6000000005828-0-tps-1192-720.jpg)

</usedetail>

## 二次开发指南

<development id="flushContent">

本项目可以用于二次开发。

初始化项目时，需要绑定代码仓库，CAP平台会自动配置代码仓库的Webhook。当仓库对应的分支有任何提交时，CAP平台会收到Webhook推送，并自动完成构建与部署。

代码中演示了进行前、后端开发以及访问云产品，用户可以仿造演示代码开发任何自己想要的功能。

</development>






