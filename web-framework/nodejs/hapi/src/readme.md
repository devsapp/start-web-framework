
> 注：当前项目为 Serverless Devs 应用，由于应用中会存在需要初始化才可运行的变量（例如应用部署地区、函数名等等），所以**不推荐**直接 Clone 本仓库到本地进行部署或直接复制 s.yaml 使用，**强烈推荐**通过 `s init ${模版名称}` 的方法或应用中心进行初始化，详情可参考[部署 & 体验](#部署--体验) 。

# start-hapi-cap 帮助文档

<description>

本案例展示了如何将 hapi.js，一款功能齐全的 Node.js 框架，快速创建并部署到云原生应用开发平台 CAP。hapi.js其内置的输入验证、缓存、身份验证、错误处理和强大的插件系统，广泛应用于构建可扩展和健壮的服务器端应用程序和服务。

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
   
- :fire: 通过 [云原生应用开发平台 CAP](https://cap.console.aliyun.com/template-detail?template=start-hapi-cap) ，[![Deploy with Severless Devs](https://img.alicdn.com/imgextra/i1/O1CN01w5RFbX1v45s8TIXPz_!!6000000006118-55-tps-95-28.svg)](https://cap.console.aliyun.com/template-detail?template=start-hapi-cap) 该应用。
   
</appcenter>
<deploy>
    
   
</deploy>

## 案例介绍

<appdetail id="flushContent">

本案例将 hapi.js ，这一功能齐全的 Node.js 框架，快速创建并部署到云原生应用开发平台 CAP。

hapi.js 为开发者提供了一套工具来构建可扩展和健壮的服务器端应用程序和服务。hapi的核心特点包括内置的输入验证、缓存、身份验证、错误处理和更多。它以插件系统为基础，允许开发者通过模块化的方式扩展应用功能，同时保持代码的组织性和可测试性。

这个框架的设计原则之一是"配置即代码"，这意味着大部分功能通过配置对象而非编写大量代码来实现。这种方法简化了复杂功能的集成，并促进了代码的清晰和易管理。hapi在GitHub上有着良好的用户基础和活跃的社区，被多家知名企业和组织采纳，这证明了其作为构建企业级应用的可靠性和有效性。

通过使用hapi.js，开发人员可以构建从简单的API到复杂的单页应用程序的服务器端逻辑。它的插件生态系统和可组合的架构使得添加新功能变得简单，并且在需要时可以轻松地进行升级或替换组件。

结合云原生应用开发平台 CAP，hapi.js可以实现更有效的资源利用和自动扩缩能力，无需管理底层服务器。借助云原生应用开发平台 CAP，hapi应用可以自动扩展以适应流量变化，同时减少未使用资源的浪费。这意味着开发者可以更专注于业务逻辑的创造，而将运维的复杂性和规模化问题交给云平台管理。

</appdetail>







## 使用流程

<usedetail id="flushContent">

本项目案例是将 hapi 部署到云原生应用开发平台 CAP 。部署完成之后，您可以看到系统返回给您的案例地址, 如图:

![图片alt](https://img.alicdn.com/imgextra/i4/O1CN01dig9VC1nIjtyIEYmi_!!6000000005067-0-tps-1304-133.jpg)

此时，打开案例地址，就可以进入 hapi 默认的首页：

![图片alt](https://img.alicdn.com/imgextra/i1/O1CN019eIc1K1w9sfJirPVk_!!6000000006266-0-tps-2738-1418.jpg)

</usedetail>

## 二次开发指南

<development id="flushContent">

本项目可以用于二次开发。

初始化项目时，需要绑定代码仓库，CAP平台会自动配置代码仓库的Webhook。当仓库对应的分支有任何提交时，CAP平台会收到Webhook推送，并自动完成构建与部署。

</development>






