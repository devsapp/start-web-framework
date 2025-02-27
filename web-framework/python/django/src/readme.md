
> 注：当前项目为 Serverless Devs 应用，由于应用中会存在需要初始化才可运行的变量（例如应用部署地区、函数名等等），所以**不推荐**直接 Clone 本仓库到本地进行部署或直接复制 s.yaml 使用，**强烈推荐**通过 `s init ${模版名称}` 的方法或应用中心进行初始化，详情可参考[部署 & 体验](#部署--体验) 。

# start-django-cap 帮助文档

<description>

本案例展示了如何将 Django，一款非常受欢迎的 Web 框架，快速创建并部署到云原生应用开发平台 CAP。Django 以其强大的功能、易用性、完善的生态系统和长期的社区支持，广泛应用于 Web 应用开发、API 以及后台管理系统等多种场景。

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
   
- :fire: 通过 [云原生应用开发平台 CAP](https://cap.console.aliyun.com/template-detail?template=start-django-cap) ，[![Deploy with Severless Devs](https://img.alicdn.com/imgextra/i1/O1CN01w5RFbX1v45s8TIXPz_!!6000000006118-55-tps-95-28.svg)](https://cap.console.aliyun.com/template-detail?template=start-django-cap) 该应用。
   
</appcenter>
<deploy>
    
   
</deploy>

## 案例介绍

<appdetail id="flushContent">

本案例是将 Python Web 框架中，非常受欢迎的 Django 框架，快速创建并部署到云原生应用开发平台 CAP。

Django是一个开放源代码的Web应用框架，由Python写成。采用了MTV的框架模式，即模型M，视图V和模版T。它最初是被开发来用于管理劳伦斯出版集团旗下的一些以新闻内容为主的网站的，即是CMS（内容管理系统）软件。并于2005年7月在BSD许可证下发布。这套框架是以比利时的吉普赛爵士吉他手Django Reinhardt来命名的。

Django凭借其强大的功能和易用性，赢得了全球大量开发者的青睐。其优势包括开发效率高、生态完善，并且有官方社区长期支持。Django不仅适合大型公司使用，也适合个人开发者进行项目开发，因此它在各种规模和类型的项目中都有广泛的应用。主要适用于Web应用开发、API服务、数据分析平台、以及后台管理系统等。

Django还具有高度的安全性，包括防止常见的Web攻击、CSRF保护、XSS预防等，有助于开发相对安全的Web应用。同时，其可扩展性也支持模块化开发和可插拔的应用，使得系统易于扩展和维护。

通过云原生应用开发平台 CAP，您只需要几步，就可以体验 Django 框架，并享受Serverless 架构带来的降本提效的技术红利。

</appdetail>







## 使用流程

<usedetail id="flushContent">

### 查看部署的案例
部署完成之后，您可以看到系统返回给您的案例地址,  打开案例地址，就可以看到如下图：

![图片alt](https://img.alicdn.com/imgextra/i1/O1CN01FlMugC1k8FwHLLTYb_!!6000000004638-0-tps-1574-644.jpg)

</usedetail>

## 二次开发指南

<development id="flushContent">
</development>






