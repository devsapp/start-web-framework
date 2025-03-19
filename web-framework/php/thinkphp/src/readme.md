
> 注：当前项目为 Serverless Devs 应用，由于应用中会存在需要初始化才可运行的变量（例如应用部署地区、函数名等等），所以**不推荐**直接 Clone 本仓库到本地进行部署或直接复制 s.yaml 使用，**强烈推荐**通过 `s init ${模版名称}` 的方法或应用中心进行初始化，详情可参考[部署 & 体验](#部署--体验) 。

# start-thinkphp-cap 帮助文档

<description>

本案例展示了如何将 ThinkPHP，一款非常流行的 PHP Web 应用开发框架，快速创建并部署到云原生应用开发平台 CAP。ThinkPHP 以其出色的性能、易用性、丰富的功能和强大的社区支持，广泛应用于各种规模的项目开发，特别是在中大型项目中表现出色。

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
   
- :fire: 通过 [云原生应用开发平台 CAP](https://cap.console.aliyun.com/template-detail?template=start-thinkphp-cap) ，[![Deploy with Severless Devs](https://img.alicdn.com/imgextra/i1/O1CN01w5RFbX1v45s8TIXPz_!!6000000006118-55-tps-95-28.svg)](https://cap.console.aliyun.com/template-detail?template=start-thinkphp-cap) 该应用。
   
</appcenter>
<deploy>
    
   
</deploy>

## 案例介绍

<appdetail id="flushContent">

本案例将 ThinkPHP 框架，这一款非常流行的web应用开发框架，快速创建部署到云原生应用开发平台 CAP。

ThinkPHP是一个使用纯PHP开发，面向对象和面向过程的优秀安全敏捷的web应用框架，旨在简化企业级应用开发和敏捷web应用开发。它遵循MVC分层开发模式和单一入口等简洁规范的思想，并且内置了大量的开发模块和常用功能，以便开发者能够快速构建web应用程序。

ThinkPHP是一个非常流行的PHP开发框架，在web开发领域有着广泛的应用。其流行程度主要得益于其出色的性能、易用性、功能丰富性以及强大的社区支持。

ThinkPHP适用于各种规模的项目开发，特别是中大型项目。由于其具有丰富的功能和易用的操作方法，ThinkPHP特别适合构建需要复杂业务逻辑和数据库操作的应用程序。无论是企业级应用、网站开发还是API接口开发，ThinkPHP都能提供高效、稳定的解决方案。ThinkPHP还具有良好的跨平台性，支持多种服务器环境和数据库，这使得开发者可以根据项目需求灵活选择技术栈。

通过云原生应用开发平台 CAP，您只需要几步，就可以体验 ThinkPHP 框架，并享受 Serverless 架构带来的降本提效的技术红利。

</appdetail>







## 使用流程

<usedetail id="flushContent">

### 查看部署的案例

部署完成之后，您可以看到系统返回给您的案例地址，例如：

![图片alt](https://img.alicdn.com/imgextra/i2/O1CN01u57xeg1wOXSTZk6A6_!!6000000006298-0-tps-1312-127.jpg)

此时，打开案例地址，就可以进入 ThinkPHP 首页：

![图片alt](https://img.alicdn.com/imgextra/i4/O1CN01sJoYbl1gMDSbmIVzC_!!6000000004127-0-tps-1548-934.jpg)

</usedetail>

## 二次开发指南

<development id="flushContent">

本项目可以用于二次开发。

初始化项目时，需要绑定代码仓库，CAP平台会自动配置代码仓库的 Webhook。当仓库对应的分支有任何提交时，CAP平台会收到 Webhook 推送，并自动完成构建与部署。

</development>






