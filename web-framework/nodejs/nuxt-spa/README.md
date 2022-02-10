# nuxt-spa-app

一款基于Node.JS的网页 Nuxt spa 应用

- 初始化项目：`s init nuxt-spa-app`
- 进入项目：`cd nuxt-spa-app`
- 部署项目：`s deploy`

> * 额外说明：s.yaml中声明了actions：   
>    部署前执行：npm install --production   
>   如果遇到npm命令找不到等问题，可以适当进行手动项目构建，并根据需要取消actions内容    
> * 项目初始化完成，您可以直接进入项目目录下，并使用 s deploy 进行项目部署

## 相关命令

由于该框架直接部署在阿里云函数计算平台，所以可以参考函数计算组件相关的命令：

| 构建&部署 | 可观测性 | 调用&调试 |  发布&配置  |  其他功能 |
| --- | --- | --- |--- | --- |
| [**部署 deploy**](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/deploy.md)   | [指标查询 metrics](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/metrics.md) | [**本地调用 local**](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/local.md)      | [**版本 version**](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/version.md)      | [**硬盘挂载 nas**](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/nas.md) | 
| [**构建 build**](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/build.md)     | [日志查询 logs](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/logs.md)       | [远程调用 invoke](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/invoke.md)    | [**别名 alias**](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/alias.md)         | [计划变更 plan](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/plan.md)  | 
| [移除 remove](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/remove.md)   |                                              | [**端云联调 proxied**](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/proxied.md) | [预留 provision](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/provision.md)   | [查看函数 info](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/info.md)  | 
|                                          |                                              | [远程调试 remote](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/remote.md)    | [按量资源 ondemand](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/ondemand.md) |[**资源同步 sync**](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/sync.md)  | 
|                                          |                                              | [内存&并发度探测 eval](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/eval.md)  | [层 layer](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/layer.md) |      [压测 stress](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/stress.md)               | 
|                                          |                                              |   |  | [API调用 api](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/api.md)                     | 
|                                          |                                              |   |  |  [Fun项目迁移 fun2s](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/fun2s.md)                   | 

## 依赖过大部署方案

函数计算的接口本身默认只支持 100M 的代码包，如果想要部署超过 100M 的代码包，可以考虑：

- 将 `nasConfig` 配置为 `auto`，然后基于 nas 指令将大文件（可能是训练集/依赖包）传输到 NAS 指定位置，然后配置相应的环境变量到 `s.yml` 中的函数配置中；
- 将非 custom-container 的函数转换成 custom-container，这需要对代码进行一定的改造，并新增 dockerfile，然后创建这个函数（此方式冷启动时间相对其他 runtime 会有一点点的延长）；
  