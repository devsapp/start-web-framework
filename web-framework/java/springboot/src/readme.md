# Springboot 框架

> 快速部署和体验Serverless架构下的Springboot项目

- [Springboot 框架](#springboot-框架)
  - [体验前准备](#体验前准备)
  - [代码与预览](#代码与预览)
  - [快速部署和体验](#快速部署和体验)
    - [在线快速体验](#在线快速体验)
    - [在本地部署体验](#在本地部署体验)
  - [应用详情](#应用详情)

## 体验前准备

该应用案例，需要您开通[阿里云函数计算](https://fcnext.console.aliyun.com/) 产品；并建议您当前的账号有一下权限存在`FCDefaultRole`。

## 代码与预览

- [:octocat: 源代码](https://github.com/devsapp/start-web-framework/tree/master/web-framework/java/springboot/src)
- [:earth_africa: 效果预览](https://img.alicdn.com/imgextra/i3/O1CN01jLfCaE1amQGuXQI8Q_!!6000000003372-2-tps-2594-1558.png)

## 快速部署和体验
### 在线快速体验

- 通过阿里云 **Serverless 应用中心**： 可以点击 [【🚀 部署】](https://fcnext.console.aliyun.com/applications/create?template=start-springboot) ，按照引导填入参数，快速进行部署和体验。

### 在本地部署体验

1. 下载安装 Serverless Devs：`npm install @serverless-devs/s` 
    > 详细文档可以参考 [Serverless Devs 安装文档](https://github.com/Serverless-Devs/Serverless-Devs/blob/master/docs/zh/install.md)
2. 配置密钥信息：`s config add`
    > 详细文档可以参考 [阿里云密钥配置文档](https://github.com/devsapp/fc/blob/main/docs/zh/config.md)
3. 初始化项目：`s init start-springboot -d start-springboot`
4. 进入项目并部署：`cd start-springboot && s deploy`

> 在本地使用该项目时，不仅可以部署，还可以进行更多的操作，例如查看日志，查看指标，进行多种模式的调试等，这些操作详情可以参考[函数计算组件命令文档](https://github.com/devsapp/fc#%E6%96%87%E6%A1%A3%E7%9B%B8%E5%85%B3) ;


## 应用详情

本项目是将 Springboot 项目部署到阿里云 Serverless 平台（函数计算 FC）。

通过 Serverless Devs 开发者工具，您只需要几步，就可以体验 Serverless 架构，带来的降本提效的技术红利。

部署完成之后，您可以看到系统返回给您的案例地址，例如：

![图片alt](https://img.alicdn.com/imgextra/i4/O1CN01Tcewz51vRS4HsahtZ_!!6000000006169-2-tps-2554-918.png)

此时，打开案例地址，就可以进入 Springboot 项目首页：

![图片alt](https://img.alicdn.com/imgextra/i3/O1CN01jLfCaE1amQGuXQI8Q_!!6000000003372-2-tps-2594-1558.png)

> 注意: 如果您这边部署的 Springboot 项目的 jar 包很大， 超过了函数计算最大的 100M 限制，可以参考[函数计算大代码包部署的实践](https://github.com/awesome-fc/fc-faq/blob/main/docs/%E5%A4%A7%E4%BB%A3%E7%A0%81%E5%8C%85%E9%83%A8%E7%BD%B2%E7%9A%84%E5%AE%9E%E8%B7%B5%E6%A1%88%E4%BE%8B.md)

-----

> - Serverless Devs 项目：https://www.github.com/serverless-devs/serverless-devs   
> - Serverless Devs 文档：https://www.github.com/serverless-devs/docs   
> - Serverless Devs 钉钉交流群：33947367    