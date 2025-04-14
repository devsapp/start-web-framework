
> 注：当前项目为 Serverless Devs 应用，由于应用中会存在需要初始化才可运行的变量（例如应用部署地区、函数名等等），所以**不推荐**直接 Clone 本仓库到本地进行部署或直接复制 s.yaml 使用，**强烈推荐**通过 `s init ${模版名称}` 的方法或应用中心进行初始化，详情可参考[部署 & 体验](#部署--体验) 。

# start-springaialibaba-hk-cap 帮助文档

<description>

本案例提供了一个基于 Spring AI Alibaba 框架开发的 AI 智能机票助手，您可以将应用部署到阿里云函数计算 FC 上快速体验运行效果。

</description>


## 前期准备

使用该项目，您需要有开通以下服务并拥有对应权限：

<service>



| 服务/业务 |  权限  | 相关文档 |
| --- |  --- | --- |
| 函数计算 |  AliyunFCFullAccess | [帮助文档](https://help.aliyun.com/product/2508973.html) [计费文档](https://help.aliyun.com/document_detail/2512928.html) |

</service>

<remark>



</remark>

<disclaimers>



</disclaimers>

## 部署 & 体验

<appcenter>
   
- :fire: 通过 [云原生应用开发平台 CAP](https://devs.console.aliyun.com/applications/create?template=start-springaialibaba-hk-cap) ，[![Deploy with Severless Devs](https://img.alicdn.com/imgextra/i1/O1CN01w5RFbX1v45s8TIXPz_!!6000000006118-55-tps-95-28.svg)](https://devs.console.aliyun.com/applications/create?template=start-springaialibaba-hk-cap) 该应用。
   
</appcenter>
<deploy>
    
   
</deploy>

## 案例介绍

<appdetail id="flushContent">

本案例提供了一个基于 <a href="https://github.com/alibaba/spring-ai-alibaba" target="_blank">Spring AI Alibaba</a> 框架开发的 AI 智能机票助手，您可以与智能助手聊天，进行机票预定、改期、退票、咨询等服务。应用底层使用阿里云通义模型服务，是一个综合使用了 RAG、Function Calling、ChatMemory 等核心能力的智能体应用，支持多轮聊天会话。

Spring AI Alibaba 开源项目基于 Spring AI 构建，是阿里云通义系列模型及服务在 Java AI 应用开发领域的最佳实践，提供高层次的 AI API 抽象与云原生基础设施集成方案，旨在帮助开发者快速构建 AI 应用。使用 Spring AI Alibaba 开发应用与使用普通 Spring Boot 没有什么区别，只需要增加 `spring-ai-alibaba-starter` 依赖，将 `ChatClient` Bean 注入就可以实现与模型聊天了。


</appdetail>

## 使用流程

<usedetail id="flushContent">

1. 部署完成之后，您可以看到系统返回给您的案例地址并打开示例系统。

![图片alt](https://foruda.gitee.com/images/1726642642471571516/24ab8578_1689212.png)

2. 与智能助手开始聊天，以自然语言对话的方式说出您想要的咨询的问题或要办理的业务，并等待助手回复。


</usedetail>

## 注意事项

<matters id="flushContent">

这是一个示例应用，并无法处理真正的机票业务

</matters>
