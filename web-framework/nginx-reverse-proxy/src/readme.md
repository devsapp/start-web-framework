
> 注：当前项目为 Serverless Devs 应用，由于应用中会存在需要初始化才可运行的变量（例如应用部署地区、函数名等等），所以**不推荐**直接 Clone 本仓库到本地进行部署或直接复制 s.yaml 使用，**强烈推荐**通过 `s init ${模版名称}` 的方法或应用中心进行初始化，详情可参考[部署 & 体验](#部署--体验) 。

# nginx-reverse-proxy-cap 帮助文档

<description>

本案例展示了如何将 Nginx，一款高性能的 Web 服务器和反向代理服务器，部署至云原生应用开发平台 CAP。Nginx其高性能、稳定性、丰富的功能和易用性，广泛应用于 Web 服务器、反向代理、CDN、API 网关和实时通信等领域。

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
   
- :fire: 通过 [云原生应用开发平台 CAP](https://cap.console.aliyun.com/template-detail?template=nginx-reverse-proxy-cap) ，[![Deploy with Severless Devs](https://img.alicdn.com/imgextra/i1/O1CN01w5RFbX1v45s8TIXPz_!!6000000006118-55-tps-95-28.svg)](https://cap.console.aliyun.com/template-detail?template=nginx-reverse-proxy-cap) 该应用。
   
</appcenter>
<deploy>
    
   
</deploy>

## 案例介绍

<appdetail id="flushContent">

本案例快速部署一个 Nginx 项目到云原生应用开发平台 CAP。

Nginx的流行程度非常高，是全球范围内广泛使用的Web服务器和反向代理服务器。它的高性能、稳定性、丰富的功能、易用性，使得它在Web开发领域得到了广泛的应用，无论是大型网站还是小型应用，都可以看到Nginx的身影。此外，Nginx还在CDN、API网关、实时通信等领域发挥着重要作用。

Nginx 是一个高性能的HTTP和反向代理服务器，也是一个IMAP/POP3/SMTP代理服务器。最初由俄罗斯人Igor Sysoev开发并公开源代码，供广大用户使用。其特点是占有内存少，并发能力强，事实上nginx的并发能力确实在同类型的网页服务器中表现较好。

通过云原生应用开发平台 CAP，您只需要几步，就可以体验 Nginx，并享受 Serverless 架构带来的降本提效的技术红利。

</appdetail>







## 使用流程

<usedetail id="flushContent">

### 查看部署的案例

部署完成之后，您可以看到系统返回给您的案例地址。

![](https://img.alicdn.com/imgextra/i2/O1CN01g91UY01sAYuPrALbO_!!6000000005726-0-tps-1415-130.jpg)

</usedetail>

## 二次开发指南

<development id="flushContent">
</development>






