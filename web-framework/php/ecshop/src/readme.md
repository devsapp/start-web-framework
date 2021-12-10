# 阿里云 Ecshop 框架案例

- [快速体验](#快速体验)
- [相关命令](#相关命令)
- [依赖过大部署方案](#依赖过大部署方案)

## 快速体验

- 初始化项目：`s init start-ecshop`
- 进入项目后部署：`s deploy`
- 部署过程中可能需要阿里云密钥的支持，部署完成之后会获得到临时域名可供测试

> 权限与 Yaml 配置可以参考 [FC Yaml 规范文档](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/yaml.md)

> * 额外说明：为了保证项目可以正常的安装插件、模板，为了保证项目0改造，当前案例实现逻辑：   
>    1. 函数计算仅作为环境执行   
>    2. 业务代码被放到了NAS中   
>    > 所以在Yaml中，存在post-deploy部分，将业务代码上传到NAS，此时需要额外注意：   
>    > - 版本/别名等，可能不会对业务代码生效   
>    > - 在使用同一个NAS前提下，部署其他函数请注意文件夹是否会被覆盖，以免相互影响   
> * 项目初始化完成，您可以直接进入项目目录下，并使用 s deploy 进行项目部署


## 相关命令

由于该框架直接部署在阿里云函数计算平台，所以可以参考函数计算组件相关的命令：

| 构建&部署                                                                                    | 可观测性                                                                                       | 调用&调试                                                                                          | 发布&配置                                                                                        | 其他功能                                                                                       |
| -------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------ | ---------------------------------------------------------------------------------------------- |
| [**部署 deploy**](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/deploy.md) | [指标查询 metrics](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/metrics.md) | [**本地调用 local**](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/local.md)     | [**版本 version**](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/version.md)   | [**硬盘挂载 nas**](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/nas.md)     |
| [**构建 build**](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/build.md)   | [日志查询 logs](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/logs.md)       | [远程调用 invoke](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/invoke.md)       | [**别名 alias**](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/alias.md)       | [计划变更 plan](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/plan.md)       |
| [移除 remove](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/remove.md)     |                                                                                                | [**端云联调 proxied**](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/proxied.md) | [预留 provision](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/provision.md)   | [查看函数 info](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/info.md)       |
|                                                                                              |                                                                                                | [远程调试 remote](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/remote.md)       | [按量资源 ondemand](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/ondemand.md) | [**资源同步 sync**](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/sync.md)   |
|                                                                                              |                                                                                                | [内存&并发度探测 eval](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/eval.md)    | [层 layer](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/layer.md)             | [压测 stress](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/stress.md)       |
|                                                                                              |                                                                                                |                                                                                                    |                                                                                                  | [API 调用 api](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/api.md)         |
|                                                                                              |                                                                                                |                                                                                                    |                                                                                                  | [Fun 项目迁移 fun2s](https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/command/fun2s.md) |

## 依赖过大部署方案

函数计算的接口本身默认只支持 50M 的代码包，如果想要部署超过 50M 的代码包，可以考虑：

1. (50M, 100M] 范围内的代码包，可以：
   - 指定 `s.yml` 中的 `ossBucket` 字段(需要是已存在的 Bucket 并且需要和服务同地域)，此时通过工具进行部署时，工具会把代码压缩上传到这个指定的 Bucket，然后通过 OSS 的配置方式部署函数；
   - 手动将代码压缩上传到对象存储，然后在 `s.yaml` 中指定 `ossBucket` 和 `ossKey` 字段，此时部署函数时，工具会直接通过 OSS 的配置方式部署函数；
2. 大于 100M 的代码包，可以：
   - 将 `nasConfig` 配置为 `auto`，然后基于 nas 指令将大文件（可能是训练集/依赖包）传输到 NAS 指定位置，然后配置相应的环境变量到 `s.yml` 中的函数配置中；
   - 将非 custom-container 的函数转换成 custom-container，这需要对代码进行一定的改造，并新增 dockerfile，然后创建这个函数（此方式冷启动时间相对其他 runtime 会有一点点的延长）；


---

> - Serverless Devs 项目：https://www.github.com/serverless-devs/serverless-devs
> - Serverless Devs 文档：https://www.github.com/serverless-devs/docs
> - Serverless Devs 钉钉交流群：33947367
