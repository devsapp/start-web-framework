
> 注：当前项目为 Serverless Devs 应用，由于应用中会存在需要初始化才可运行的变量（例如应用部署地区、函数名等等），所以**不推荐**直接 Clone 本仓库到本地进行部署或直接复制 s.yaml 使用，**强烈推荐**通过 `s init ${模版名称}` 的方法或应用中心进行初始化，详情可参考[部署 & 体验](#部署--体验) 。

# start-tornado-cap 帮助文档

<description>

本案例展示了如何将 Tornado，一款优秀的 Web 框架，快速搭建并部署到云原生应用开发平台 CAP。Tornado 以其优异的性能和灵活的设计著称，广泛应用于构建高性能的 Web 应用程序、实时 Web 服务、长连接的实时通信以及网络爬虫等领域。

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
   
- :fire: 通过 [云原生应用开发平台 CAP](https://cap.console.aliyun.com/template-detail?template=start-tornado-cap) ，[![Deploy with Severless Devs](https://img.alicdn.com/imgextra/i1/O1CN01w5RFbX1v45s8TIXPz_!!6000000006118-55-tps-95-28.svg)](https://cap.console.aliyun.com/template-detail?template=start-tornado-cap) 该应用。
   
</appcenter>
<deploy>
    
   
</deploy>

## 案例介绍

<appdetail id="flushContent">

本案例将 tornado ，这一优秀的python Web框架，快速搭建并部署到云原生应用开发平台 CAP。

Tornado是一个Python Web框架和异步网络库，最初是在FriendFeed开发的。它以其优异的性能和灵活的设计而著称，被广泛应用于构建高性能的Web应用程序、实时Web服务、长连接的实时通信以及网络爬虫等领域。

Tornado使用非阻塞的I/O模型，通过异步编程技术，能够处理大量并发连接而不会阻塞线程，从而提高系统的并发处理能力。它经过精心优化，具有出色的性能表现。在处理并发连接和请求时，它能够提供高吞吐量和低延迟的响应。代码库相对较小，易于理解和维护。它提供了核心的功能，同时也可以通过使用扩展模块来满足更复杂的需求。

Tornado特别适合用于处理实时应用程序，如聊天室、推送服务等；也适合用于处理高并发的Web应用，因为Tornado的协程模型可以让单线程同时处理多个请求。此外，Tornado的异步编程模型还能轻松实现异步任务的处理和调度，如异步爬虫、异步消息队列等。

通过云原生应用开发平台 CAP，您只需要几步，就可以体验 Tornado 框架，并享受 Serverless 架构带来的降本提效的技术红利。

</appdetail>







## 使用流程

<usedetail id="flushContent">

### 查看部署的案例

部署完成之后，您可以看到系统返回给您的案例地址,进入 Tornado 默认的首页，如图:

![](https://img.alicdn.com/imgextra/i2/O1CN01Lr2pOA1MqdUX5buXH_!!6000000001486-0-tps-1202-956.jpg)

</usedetail>

## 二次开发指南

<development id="flushContent">
</development>






