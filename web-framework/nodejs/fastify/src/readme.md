
> 注：当前项目为 Serverless Devs 应用，由于应用中会存在需要初始化才可运行的变量（例如应用部署地区、函数名等等），所以**不推荐**直接 Clone 本仓库到本地进行部署或直接复制 s.yaml 使用，**强烈推荐**通过 `s init ${模版名称}` 的方法或应用中心进行初始化，详情可参考[部署 & 体验](#部署--体验) 。

# start-fastify-cap 帮助文档

<description>

本案例展示了如何将 Fastify，一款基于 Node.js 平台的极简且灵活的 Web 应用开发框架，快速创建并部署到云原生应用开发平台 CAP。Fastify其高效的性能、最少的开销和强大的插件结构，是速度最快的 Web 框架之一。

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
   
- :fire: 通过 [云原生应用开发平台 CAP](https://cap.console.aliyun.com/template-detail?template=start-fastify-cap) ，[![Deploy with Severless Devs](https://img.alicdn.com/imgextra/i1/O1CN01w5RFbX1v45s8TIXPz_!!6000000006118-55-tps-95-28.svg)](https://cap.console.aliyun.com/template-detail?template=start-fastify-cap) 该应用。
   
</appcenter>
<deploy>
    
   
</deploy>

## 案例介绍

<appdetail id="flushContent">

本案例是将 Fastify 框架，这一基于 Node.js 平台的极简且灵活的 web 应用开发框架，快速创建并部署到云原生应用开发平台 CAP。

高效的服务器意味着更低的基础设施成本、更好的负载响应能力和用户满意度。 在不牺牲安全验证和便捷开发的前提下，如何知道服务器正在处理尽可能多的请求，又如何有效地处理服务器资源？

用 Fastify 吧。Fastify 是一个 web 开发框架，其设计灵感来自 Hapi 和 Express，致力于以最少的开销和强大的插件结构提供最佳的开发体验。据我们所知，它是这个领域里速度最快的 web 框架之一。

</appdetail>







## 使用流程

<usedetail id="flushContent">

本项目案例是 Fastify 部署到云原生应用开发平台 CAP，部署完成之后，您可以看到系统返回给您的案例地址，例如：

![图片alt](https://img.alicdn.com/imgextra/i3/O1CN01D4gm6N1MmW1dn6cz7_!!6000000001477-0-tps-1316-132.jpg)

此时，打开案例地址，就可以看到测试的应用详情：

![图片alt](https://img.alicdn.com/imgextra/i3/O1CN01WgV9KE1I0eAPuTgZJ_!!6000000000831-0-tps-916-580.jpg)

</usedetail>

## 二次开发指南

<development id="flushContent">

本项目可以用于二次开发。

初始化项目时，需要绑定代码仓库，CAP平台会自动配置代码仓库的Webhook。当仓库对应的分支有任何提交时，CAP平台会收到Webhook推送，并自动完成构建与部署。

</development>






