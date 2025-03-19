
> 注：当前项目为 Serverless Devs 应用，由于应用中会存在需要初始化才可运行的变量（例如应用部署地区、函数名等等），所以**不推荐**直接 Clone 本仓库到本地进行部署或直接复制 s.yaml 使用，**强烈推荐**通过 `s init ${模版名称}` 的方法或应用中心进行初始化，详情可参考[部署 & 体验](#部署--体验) 。

# start-nest-cap 帮助文档

<description>

本案例展示了如何将 Nest.js，一款灵活的 Node.js 框架，快速创建并部署到云原生应用开发平台 CAP。Nest.js 使用 TypeScript 作为主要语言，提供了严格的类型检查，采用模块化和面向切面编程的概念，使得代码组织结构清晰且易于测试。

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
   
- :fire: 通过 [云原生应用开发平台 CAP](https://cap.console.aliyun.com/template-detail?template=start-nest-cap) ，[![Deploy with Severless Devs](https://img.alicdn.com/imgextra/i1/O1CN01w5RFbX1v45s8TIXPz_!!6000000006118-55-tps-95-28.svg)](https://cap.console.aliyun.com/template-detail?template=start-nest-cap) 该应用。
   
</appcenter>
<deploy>
    
   
</deploy>

## 案例介绍

<appdetail id="flushContent">

本案例 Nest.js ，这一灵活的 Node.js 框架，快速创建并部署到云原生应用开发平台 CAP。

NestJS 旨在为开发者提供构建高效、可维护和可扩展Web应用程序的工具。使用 TypeScript 作为主要语言，NestJS 提供了严格的类型检查，极大地提高了代码的质量和可维护性。它的架构灵感来源于 Angular，采用了模块化和面向切面编程的概念，从而使得代码组织结构清晰，且易于测试。

在GitHub上，NestJS 凭借其一致性、可扩展性和集成了现代技术的特点，赢得了大量的 stars (63.5k) 和一个活跃的开发社区。世界各地的开发者和许多公司都在采用 NestJS 来构建他们的后端服务，特别是当需要一个结构化、维护性强的解决方案时。

NestJS 的一个突出特点是它的模块化系统，允许将应用程序划分为多个模块，每个模块都专注于特定的任务或功能区域。这有助于保持代码的整洁和组织，同时也方便在团队中协作。框架同时支持依赖注入，这使得每个部分都能够轻松地测试和模拟。

结合云原生应用开发平台 CAP，NestJS 可以在无服务器环境中运行，这让开发者能够专注于编写业务逻辑，而无需处理服务器的配置和管理。云原生应用开发平台 CAP的自动扩展功能意味着应用程序可以根据需求动态调整资源，这为处理不可预见的流量提供了灵活性，并且可能会降低运营成本。

</appdetail>







## 使用流程

<usedetail id="flushContent">

### 查看部署的应用
本项目案例是 nest 部署到云原生应用开发平台 CAP，部署完成之后，您可以看到系统返回给您的案例地址，例如：

![图片alt](https://img.alicdn.com/imgextra/i1/O1CN01TYTDiD21BK6rDrC33_!!6000000006946-0-tps-1331-110.jpg)

此时，打开案例地址，就可以进入 nest 默认的首页：

![图片alt](https://img.alicdn.com/imgextra/i1/O1CN01wCeC0D238EYKSZW3J_!!6000000007210-0-tps-2518-1454.jpg)

</usedetail>

## 二次开发指南

<development id="flushContent">

本项目可以用于二次开发。

初始化项目时，需要绑定代码仓库，CAP平台会自动配置代码仓库的 Webhook。当仓库对应的分支有任何提交时，CAP 平台会收到 Webhook 推送，并自动完成构建与部署。

</development>






