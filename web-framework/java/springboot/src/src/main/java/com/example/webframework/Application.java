package com.example.webframework;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;

@SpringBootApplication
public class Application {

    // 正确实践http函数怎么进行bootstrap
    // 事件函数怎么进行initiate?
    public static void main(String[] args) {
        SpringApplication.run(Application.class, args);
    }


    // TODO 事件类型的函数如何正确地写处理？
    // 事件函数与http函数场景，如何获取约定的上下文信息？
    // 常见问题怎么解决，包括

    // TODO 应用SpringBoot + SpringMVC的正确实践，开发RESTful接口
    // TODO SpringBoot + SpringMVC的正确实践，开发前后端一体化的接口
    // 详细程度需要到Action层或Controller层，DAO与Service层属于Spring应用问题
    // 常见问题可以提炼FAQ或者沉淀到工程中

    // TODO 如何正确地推送metrics? @夏莞
    // 可观测的最佳实践也要放进去

    // 产品出了什么新功能，涉及到研发层面的，要在runtime的模板案例里面show出来才对。
    // 旧功能设计的客户体验问题可以自己消化，新功能设计的问题可以自己赋能自己，了解客户的痛苦，进行优化

    // 展示约定的environment变量

    // 展示通过host指定hostname并生效

    // 展示打印日志功能

    //

}
