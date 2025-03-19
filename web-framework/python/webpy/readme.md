
> 注：当前项目为 Serverless Devs 应用，由于应用中会存在需要初始化才可运行的变量（例如应用部署地区、函数名等等），所以**不推荐**直接 Clone 本仓库到本地进行部署或直接复制 s.yaml 使用，**强烈推荐**通过 `s init ${模版名称}` 的方法或应用中心进行初始化，详情可参考[部署 & 体验](#部署--体验) 。

# start-webpy-cap 帮助文档

<description>

本案例展示了如何将 Web.py，一款简单而功能强大的 Web 框架，快速创建并部署到云原生应用开发平台 CAP。Web.py 其轻量级、强大的 URL 路由系统、内置模板引擎和灵活的数据库集成能力，广泛应用于构建 Web 应用程序和 RESTful API。

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
   
- :fire: 通过 [云原生应用开发平台 CAP](https://cap.console.aliyun.com/template-detail?template=start-webpy-cap) ，[![Deploy with Severless Devs](https://img.alicdn.com/imgextra/i1/O1CN01w5RFbX1v45s8TIXPz_!!6000000006118-55-tps-95-28.svg)](https://cap.console.aliyun.com/template-detail?template=start-webpy-cap) 该应用。
   
</appcenter>
<deploy>
    
   
</deploy>

## 案例介绍

<appdetail id="flushContent">

本案例将 Web.py ，这一简单而功能强大的 Python Web 框架，快速创建部署到云原生应用开发平台 CAP 。

web.py是一个轻量级的Python Web框架，并且拥有许多主要功能和特点。首先，它支持简单而强大的URL路由系统，允许开发者将URL映射到视图函数，以处理不同的HTTP请求。其次，开发者可以编写视图函数来处理HTTP请求，并返回相应的HTTP响应，从而构建Web应用程序的功能。

web.py还内置了一个简单但有效的模板引擎，用于生成动态HTML页面。虽然web.py不强制使用特定的数据库访问库，但它提供了轻松与各种数据库（如MySQL、SQLite、PostgreSQL等）集成的能力。web.py还支持会话管理，允许开发者跟踪和存储用户会话数据。此外，开发者可以使用中间件来扩展和自定义应用程序的功能，例如添加身份验证、日志记录等。最后，web.py对构建RESTful API提供了良好的支持，使开发Web服务更加容易。

通过云原生应用开发平台 CAP，您只需要几步，就可以体验 Web.py 框架，并享受 Serverless 架构带来的降本提效的技术红利。

</appdetail>







## 使用流程

<usedetail id="flushContent">

### 查看部署的案例

部署完成之后，您可以看到系统返回给您的案例地址,进入 webpy 默认的首页，如图:

![](https://img.alicdn.com/imgextra/i2/O1CN01oQDlE01HlzOa7INYR_!!6000000000799-0-tps-1282-960.jpg)

</usedetail>

## 二次开发指南

<development id="flushContent">

本项目可以用于二次开发。

初始化项目时，需要绑定代码仓库，CAP平台会自动配置代码仓库的 Webhook。当仓库对应的分支有任何提交时，CAP平台会收到 Webhook 推送，并自动完成构建与部署。

</development>






