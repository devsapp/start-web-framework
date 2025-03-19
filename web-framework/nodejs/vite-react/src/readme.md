
> 注：当前项目为 Serverless Devs 应用，由于应用中会存在需要初始化才可运行的变量（例如应用部署地区、函数名等等），所以**不推荐**直接 Clone 本仓库到本地进行部署或直接复制 s.yaml 使用，**强烈推荐**通过 `s init ${模版名称}` 的方法或应用中心进行初始化，详情可参考[部署 & 体验](#部署--体验) 。

# start-vite-react-cap 帮助文档

<description>

基于 React 的可扩展企业级前端应用框架快速创建并部署到云原生应用开发平台 CAP 。

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
   
- :fire: 通过 [云原生应用开发平台 CAP](https://cap.console.aliyun.com/template-detail?template=start-vite-react-cap) ，[![Deploy with Severless Devs](https://img.alicdn.com/imgextra/i1/O1CN01w5RFbX1v45s8TIXPz_!!6000000006118-55-tps-95-28.svg)](https://cap.console.aliyun.com/template-detail?template=start-vite-react-cap) 该应用。
   
</appcenter>
<deploy>
    
   
</deploy>

## 案例介绍

<appdetail id="flushContent">

### Vite + React 开发优势

 Vite + React 提供了一种更快速、更轻量、更简单的开发方式，相比于传统的 React 开发方式（如 Create React App 或 Webpack），具有以下优势：

#### 1. 更快的开发体验
- **冷启动快**：Vite 的冷启动速度比 Webpack 快得多，尤其是在大型项目中。
- **热更新快**：Vite 的热模块替换（HMR）速度更快，修改代码后几乎可以立即看到更新。

#### 2. 更轻量的依赖
- Vite 的依赖更少，构建工具本身更轻量。
- 相比之下，Create React App 依赖于 Webpack 和 Babel，配置复杂且依赖较多。

#### 3. 更简单的配置
- Vite 的配置非常简单，开箱即用。
- 相比之下，Webpack 的配置复杂，尤其是在需要自定义构建流程时。

#### 4. 更好的开发体验
- Vite 提供了更友好的错误提示和调试信息。
- 开发服务器支持按需编译，减少了初始加载时间。

#### 5. 更高效的生产构建
- Vite 使用 Rollup 进行生产构建，生成的代码更小、更高效。
- 相比之下，Webpack 的生产构建速度较慢，生成的代码体积较大。

#### 6. 更好的 TypeScript 支持
- Vite 内置了对 TypeScript 的支持，无需额外配置。
- 相比之下，Create React App 需要手动配置 TypeScript。

#### 7. 更灵活的插件系统

- Vite 的插件系统非常灵活，允许开发者轻松扩展功能。
- 相比之下，Webpack 的插件系统复杂且配置繁琐。

</appdetail>







## 使用流程

<usedetail id="flushContent">

本项目案例是 vite + React 部署到云原生应用开发平台 CAP，部署完成之后，您可以看到系统返回给您的案例地址。
![](https://img.alicdn.com/imgextra/i3/O1CN01AKcN1x1pyXHCoRmX6_!!6000000005429-0-tps-1333-138.jpg)
此时，打开案例地址，就可以进入 React 默认的首页。
![](https://img.alicdn.com/imgextra/i3/O1CN01vBEJ7d1R0wyDXtMvc_!!6000000002050-0-tps-1881-946.jpg)

</usedetail>

## 二次开发指南

<development id="flushContent">

本项目可以用于二次开发。

初始化项目时，需要绑定代码仓库，CAP平台会自动配置代码仓库的 Webhook。当仓库对应的分支有任何提交时，CAP平台会收到 Webhook 推送，并自动完成构建与部署。

</development>






