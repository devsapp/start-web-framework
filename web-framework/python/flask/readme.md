
> 注：当前项目为 Serverless Devs 应用，由于应用中会存在需要初始化才可运行的变量（例如应用部署地区、函数名等等），所以**不推荐**直接 Clone 本仓库到本地进行部署或直接复制 s.yaml 使用，**强烈推荐**通过 `s init ${模版名称}` 的方法或应用中心进行初始化，详情可参考[部署 & 体验](#部署--体验) 。

# start-flask-cap 帮助文档

<description>

本案例展示了如何将 Flask，一款非常受欢迎的 Web 框架，快捷创建并部署到云原生应用开发平台 CAP。Flask 以其轻量级、简洁性和易用性著称，特别适用于小型、简单的 Web 应用或 API 开发。

</description>


## 资源准备

使用该项目，您需要有开通以下服务并拥有对应权限：

<service>



| 服务/业务 |  权限  | 相关文档 |
| --- |  --- | --- |
| 函数计算 |  AliyunFCFullAccess | [帮助文档](https://help.aliyun.com/product/2508973.html) [计费文档](https://help.aliyun.com/document_detail/2512928.html) |
| 日志服务 |  AliyunFCServerlessDevsRolePolicy | [帮助文档](https://help.aliyun.com/zh/sls) [计费文档](https://help.aliyun.com/zh/sls/product-overview/billing) |
| 对象存储 |  AliyunOSSFullAccess | [帮助文档](https://help.aliyun.com/zh/oss) [计费文档](https://help.aliyun.com/zh/oss/product-overview/billing) |

</service>

<remark>



</remark>

<disclaimers>



</disclaimers>

## 部署 & 体验

<appcenter>
   
- :fire: 通过 [云原生应用开发平台 CAP](https://cap.console.aliyun.com/template-detail?template=start-flask-cap) ，[![Deploy with Severless Devs](https://img.alicdn.com/imgextra/i1/O1CN01w5RFbX1v45s8TIXPz_!!6000000006118-55-tps-95-28.svg)](https://cap.console.aliyun.com/template-detail?template=start-flask-cap) 该应用。
   
</appcenter>
<deploy>
    
   
</deploy>

## 案例介绍

<appdetail id="flushContent">

本案例将Flask框架，这一非常受欢迎的Python Web框架，快捷创建并部署到云原生应用开发平台 CAP。

Flask是一个使用 Python 编写的轻量级 Web 应用框架。其 WSGI 工具箱采用 Werkzeug ，模板引擎则使用 Jinja2 。Flask使用 BSD 授权。

该框架全网下载量超过四千万次，在github上获得了超过6w star，是最为主流的Python Web应用框架之一。

该框架特别适用于小型、简单的Web应用或API开发。对于这类项目，Flask的简洁性和易用性使得开发过程更加高效和快速。开发者可以利用Flask的核心组件快速搭建起项目的基本框架，并通过扩展库来增加额外的功能。

通过云原生应用开发平台 CAP，您只需要几步，就可以体验 Flask 框架，并享受Serverless 架构带来的降本提效的技术红利。

</appdetail>







## 使用流程

<usedetail id="flushContent">

### 查看部署的案例
本案例应用是一个非常简单的 Hello World 案例，部署完成之后，您可以看到系统返回给您的案例地址, 打开案例地址，就可以进入基于 flask 设置的首页：

![图片alt](https://img.alicdn.com/imgextra/i4/O1CN01MxcrbG1iCGDXzevkm_!!6000000004376-0-tps-1184-736.jpg)

</usedetail>

## 二次开发指南

<development id="flushContent">

本项目可以用于二次开发。

初始化项目时，需要绑定代码仓库，CAP平台会自动配置代码仓库的Webhook。当仓库对应的分支有任何提交时，CAP平台会收到Webhook推送，并自动完成构建与部署。

代码中演示了进行前、后端开发以及访问云产品，用户可以仿造演示代码开发任何自己想要的功能。

</development>






