
> 注：当前项目为 Serverless Devs 应用，由于应用中会存在需要初始化才可运行的变量（例如应用部署地区、函数名等等），所以**不推荐**直接 Clone 本仓库到本地进行部署或直接复制 s.yaml 使用，**强烈推荐**通过 `s init ${模版名称}` 的方法或应用中心进行初始化，详情可参考[部署 & 体验](#部署--体验) 。

# start-beego-cap 帮助文档

<description>

本案例展示了如何将 Beego —— 一款高效的Go语言Web框架，无缝部署至云原生应用开发平台，实现快速构建云原生应用的实践。Beego以其对Go特性的深度整合、简洁的MVC设计模式以及高性能著称，广泛应用于各类Web开发场景中。

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
   
- :fire: 通过 [云原生应用开发平台 CAP](https://cap.console.aliyun.com/template-detail?template=start-beego-cap) ，[![Deploy with Severless Devs](https://img.alicdn.com/imgextra/i1/O1CN01w5RFbX1v45s8TIXPz_!!6000000006118-55-tps-95-28.svg)](https://cap.console.aliyun.com/template-detail?template=start-beego-cap) 该应用。
   
</appcenter>
<deploy>
    
   
</deploy>

## 案例介绍

<appdetail id="flushContent">

本案例是将 Beego ，这一快速开发Go应用的 web 框架，快速搭建部署到云原生应用开发平台 CAP。

Beego是一个快速开发Go应用的http框架，它旨在简化Web应用、API以及后端服务的开发过程。这个框架的主要设计灵感来源于tornado、sinatra和flask，同时结合了Go语言本身的一些特性，如interface和struct继承等。

Beego的流行程度在Go语言的Web开发领域中是相当高的。作为一款基于Go语言的高性能Web应用框架，Beego因其简单易用、功能丰富以及性能优越等特点而备受欢迎。它在社区中的活跃度和开发者支持度都很高，这使得Beego成为许多Go语言开发者的首选框架之一。

Beego具有广泛的应用范围。它适用于构建各种类型的Web应用，包括企业级应用、电商网站、博客系统、RESTful API等。Beego的MVC模式使得代码结构清晰，易于维护和扩展，这对于大型项目的开发尤为重要。同时，Beego也支持构建微服务架构的Web应用，通过拆分功能模块为独立的服务，实现高内聚、低耦合的架构设计。

通过云原生应用开发平台 CAP，您只需要几步，就可以体验 Beego 框架，并享受 Serverless 架构带来的降本提效的技术红利。

</appdetail>







## 使用流程

<usedetail id="flushContent">

### 查看部署的案例

本项目案例是 Beego 部署到云原生应用开发平台 CAP，部署完成之后，您可以看到系统返回给您的案例地址，例如：

![图片alt](https://img.alicdn.com/imgextra/i3/O1CN01UdFyDQ1D6XB9YqkXo_!!6000000000167-0-tps-1331-153.jpg)

此时，打开案例地址，就可以进入 Beego 默认的首页：

![](https://img.alicdn.com/imgextra/i3/O1CN012UO6hK1zErpTfg0vY_!!6000000006683-0-tps-2546-1390.jpg)

</usedetail>

## 二次开发指南

<development id="flushContent">
</development>






