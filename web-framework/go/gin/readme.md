
> 注：当前项目为 Serverless Devs 应用，由于应用中会存在需要初始化才可运行的变量（例如应用部署地区、函数名等等），所以**不推荐**直接 Clone 本仓库到本地进行部署或直接复制 s.yaml 使用，**强烈推荐**通过 `s init ${模版名称}` 的方法或应用中心进行初始化，详情可参考[部署 & 体验](#部署--体验) 。

# start-gin-cap 帮助文档

<description>

本案例展示了如何将 Gin，Go 语言社区中倍受追捧的轻量级 Web 框架，迅速构建并部署至云原生应用开发平台（CAP）。Gin 凭借其高效的处理能力、极简设计及高度灵活性，赢得了众多 Go 开发者的芳心，成为快速开发高质量 Web 应用和服务的首选武器。

</description>


## 资源准备

使用该项目，您需要有开通以下服务并拥有对应权限：

<service>



| 服务/业务 |  权限  | 相关文档 |
| --- |  --- | --- |
| 函数计算 |  AliyunFCFullAccess | [帮助文档](https://help.aliyun.com/product/2508973.html) [计费文档](https://help.aliyun.com/document_detail/2512928.html) |
| 日志服务 |  AliyunFCServerlessDevsRolePolicy | [帮助文档](https://help.aliyun.com/zh/sls) [计费文档](https://help.aliyun.com/zh/sls/product-overview/billing) |
| 对象存储服务 |  AliyunOSSFullAccess | [帮助文档](undefined) [计费文档](undefined) |

</service>

<remark>



</remark>

<disclaimers>



</disclaimers>

## 部署 & 体验

<appcenter>
   
- :fire: 通过 [云原生应用开发平台 CAP](https://cap.console.aliyun.com/template-detail?template=start-gin-cap) ，[![Deploy with Severless Devs](https://img.alicdn.com/imgextra/i1/O1CN01w5RFbX1v45s8TIXPz_!!6000000006118-55-tps-95-28.svg)](https://cap.console.aliyun.com/template-detail?template=start-gin-cap) 该应用。
   
</appcenter>
<deploy>
    
   
</deploy>

## 案例介绍

<appdetail id="flushContent">

本案例是将 Gin ，这一非常受欢迎的 web 框架，快速创建并部署到云原生应用开发平台 CAP ，并详细演示了前、后端开发，以及如何免AK配置控制云产品。

Gin在Go语言的Web开发社区中非常受欢迎，并且拥有大量的用户和贡献者。它的简洁性、性能和灵活性使得它成为许多Go语言开发者的首选框架。Gin在GitHub等代码托管平台上的star数和fork数都很高，这表明了它的广泛使用和影响力。

Gin框架的应用场景非常广泛，如：RESTful API开发、Web服务开发、微服务架构、实时通信等。它的高性能、简洁易用和灵活扩展等特点使得它成为Go语言开发者的优选之一。

通过云原生应用开发平台 CAP，您只需要几步，就可以体验 Gin 框架，并享受 Serverless 架构带来的降本提效的技术红利。

</appdetail>







## 使用流程

<usedetail id="flushContent">

### 查看部署的案例

通过本案例，您可以部署一个 Gin 框架web应用,  项目部署完成会出现系统分配的域名地址，该域名地址可作为 API 地址。

此时，使用浏览器或者 curl 工具， 就可以对测试域名进行请求：

![](https://img.alicdn.com/imgextra/i4/O1CN01RVe9KX1r4JtLpB1AZ_!!6000000005577-0-tps-1678-746.jpg)

</usedetail>

## 二次开发指南

<development id="flushContent">

本项目可以用于二次开发。

初始化项目时，需要绑定代码仓库，CAP平台会自动配置代码仓库的Webhook。当仓库对应的分支有任何提交时，CAP平台会收到Webhook推送，并自动完成构建与部署。

代码中演示了进行前、后端开发以及访问云产品，用户可以仿造演示代码开发任何自己想要的功能。

</development>






