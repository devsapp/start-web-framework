
> 注：当前项目为 Serverless Devs 应用，由于应用中会存在需要初始化才可运行的变量（例如应用部署地区、函数名等等），所以**不推荐**直接 Clone 本仓库到本地进行部署或直接复制 s.yaml 使用，**强烈推荐**通过 `s init ${模版名称}` 的方法或应用中心进行初始化，详情可参考[部署 & 体验](#部署--体验) 。

# start-next-cap 帮助文档

<description>

本案例展示如何将 Next.js，一款功能强大的 React 框架，快速创建并部署到云原生应用开发平台 CAP。Next.js 专为开发高性能页面和应用而设计，提供流畅的浏览体验和高度优化的解决方案。

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
   
- :fire: 通过 [云原生应用开发平台 CAP](https://cap.console.aliyun.com/template-detail?template=start-next-cap) ，[![Deploy with Severless Devs](https://img.alicdn.com/imgextra/i1/O1CN01w5RFbX1v45s8TIXPz_!!6000000006118-55-tps-95-28.svg)](https://cap.console.aliyun.com/template-detail?template=start-next-cap) 该应用。
   
</appcenter>
<deploy>
    
   
</deploy>

## 案例介绍

<appdetail id="flushContent">

本案例将 Next.js ，这一功能强大的 React 框架，快速创建并部署到云原生应用开发平台 CAP。

Next.js 是一个功能强大的 React 框架，专为开发高性能页面和应用而设计。通过集成了服务器端渲染（SSR）和静态站点生成（SSG），Next.js 能够提高首屏加载速度，优化搜索引擎可见性，从而为用户提供更加流畅的浏览体验。同时，它保持了React开发的灵活性和组件化的优势，使得开发者能够快速构建丰富的交互式用户界面。

在GitHub上，Next.js 凭借它直观的页面路由系统、自动的代码拆分、内置的CSS支持，以及对API路由的原生支持等特点，赢得了大量的 stars 和开发者社区的广泛支持。许多初创公司和大型企业都选择Next.js来构建他们的前端项目，因为它提供了快速开发、高度优化和易于部署的解决方案。

Next.js 的设计理念之一是“约定优于配置”，这意味着开发者可以通过简单的文件和目录结构来设置路由，而无需复杂的路由配置。此外，Next.js 的 API 路由功能允许开发者轻松创建无服务器函数，为应用程序提供后端逻辑和API端点。

通过云原生应用开发平台 CAP，您只需要几步，就可以体验 Next 框架，并享受 Serverless 架构带来的降本提效的技术红利。

</appdetail>







## 使用流程

<usedetail id="flushContent">

### 查看部署的应用
本项目案例是 next 部署到云原生应用开发平台 CAP，部署完成之后，您可以看到系统返回给您的案例地址，例如：

![图片alt](https://img.alicdn.com/imgextra/i2/O1CN01XJsH6f1IQkk8yRa8b_!!6000000000888-0-tps-1325-127.jpg)

此时，打开案例地址，就可以进入 next 默认的首页：

![图片alt](https://img.alicdn.com/imgextra/i1/O1CN01PYytWv1Duud5spdd5_!!6000000000277-0-tps-2552-1422.jpg)

</usedetail>

## 二次开发指南

<development id="flushContent">
</development>






