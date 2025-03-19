
> 注：当前项目为 Serverless Devs 应用，由于应用中会存在需要初始化才可运行的变量（例如应用部署地区、函数名等等），所以**不推荐**直接 Clone 本仓库到本地进行部署或直接复制 s.yaml 使用，**强烈推荐**通过 `s init ${模版名称}` 的方法或应用中心进行初始化，详情可参考[部署 & 体验](#部署--体验) 。

# start-egg-cap 帮助文档

<description>

本案例展示了如何将 Egg.js，一款被开发者广泛使用的企业级 Node.js 框架，快速创建并部署到云原生应用开发平台 CAP。Egg.js其约定优于配置的设计哲学、高度扩展性和完善的文档。

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
   
- :fire: 通过 [云原生应用开发平台 CAP](https://cap.console.aliyun.com/template-detail?template=start-egg-cap) ，[![Deploy with Severless Devs](https://img.alicdn.com/imgextra/i1/O1CN01w5RFbX1v45s8TIXPz_!!6000000006118-55-tps-95-28.svg)](https://cap.console.aliyun.com/template-detail?template=start-egg-cap) 该应用。
   
</appcenter>
<deploy>
    
   
</deploy>

## 案例介绍

<appdetail id="flushContent">

本案例将Egg.js，这一被开发者广泛使用的企业级 Node.js 框架，快速创建并部署到云原生应用开发平台 CAP。

Egg.js 的设计哲学强调约定优于配置，以及一致的开发规范，从而使得团队协作变得更加顺畅。它的插件体系和完善的文档允许开发者快速构建 RESTful API、Web 应用服务器、微服务架构，以及处理各种网络协议的后端服务。Egg.js 的高度扩展性还意味着它可以与现代前端技术栈无缝集成，比如 React、Vue、Angular 等。

该框架在业界获得了显著的认可，其 GitHub 仓库拥有 18.8k star，得到了包括阿里巴巴、腾讯等知名企业的青睐和采用。凭借 Egg.js，开发者可以专注于业务逻辑的实现，而将安全性、稳定性和可维护性交由框架来保障。

利用 Egg.js 构建的服务端应用，当部署在云原生应用开发平台 CAP上时，将能够享受到更高效的资源利用率和弹性伸缩的能力。Serverless 架构可以极大地减少运维负担，开发者无需担心底层服务器的配置和管理，能够迅速响应市场需求，推出新功能。Egg.js 与云原生应用开发平台 CAP的结合，为企业带来了敏捷开发的同时，也保证了长期的项目可维护性和稳定性。

</appdetail>







## 使用流程

<usedetail id="flushContent">

### 查看部署的应用
本项目案例是 egg 部署到云原生应用开发平台 CAP，部署完成之后，您可以看到系统返回给您的案例地址，例如：

![图片alt](https://img.alicdn.com/imgextra/i3/O1CN019zedRH20L6xPGld7m_!!6000000006832-0-tps-1301-130.jpg)

此时，打开案例地址，就可以看到测试的应用详情：

![图片alt](https://img.alicdn.com/imgextra/i1/O1CN01D62QIp1pzRxBLab8V_!!6000000005431-0-tps-2526-1502.jpg)

</usedetail>

## 二次开发指南

<development id="flushContent">

本项目可以用于二次开发。

初始化项目时，需要绑定代码仓库，CAP平台会自动配置代码仓库的Webhook。当仓库对应的分支有任何提交时，CAP平台会收到Webhook推送，并自动完成构建与部署。

</development>






