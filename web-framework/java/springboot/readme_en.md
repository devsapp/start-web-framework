# SpringBoot case

<toc>

<p align="center"><b> <a href="./readme.md"> 中文 </a> | English </b></p>

- [Quick start](#Quick-start)
    - [Deploy via command line tool](#Deploy-via-command-line-tools)
- [Application details](#Application-details)
- [About Us](#About-Us)

</toc>

# Quick start

- [:octocat: source](https://github.com/devsapp/start-web-framework/tree/master/web-framework/java/springboot/src)
- [:earth_africa: Effect Preview](http://springboot.web-framework.1583208943291465.cn-shenzhen.fc.devsapp.net/)

## Deploy via command line tools

> Before starting, you need to install the Serverless Devs developer tools: `npm install @serverless-devs/s -g`, for more installation methods, please refer to [Serverless Devs Installation Documentation](https://www.serverless-devs.com/serverless-devs/install) , you also need to configure key information for Alibaba Cloud. For the method of configuring key information, please refer to [Alibaba Cloud Key Configuration Document](https://www.serverless-devs.com/fc/config)
- Initialize the project: `s init start-springboot -d start-springboot`
    > It involves determining the selection of the key, the determination of the service name, the determination of the function name, and the determination of the container image
- Enter the project: `cd start-springboot`
- Deploy the project: `s deploy -y`
- Invoke： According to the returned `url` information, you can make a request in the browser

# Application details
This project is to deploy the Springboot project to Aliyun Serverless platform (Function Compute FC).

By Serverless Devs developer tools, you only need a few steps to experience the technical bonus of reducing costs and improving efficiency brought by Serverless architecture.

After the deployment is complete, you can see the case address returned to you by the system, for example:

![Picture alt](https://img.alicdn.com/imgextra/i4/O1CN01Tcewz51vRS4HsahtZ_!!6000000006169-2-tps-2554-918.png)

At this time, open the case address and enter the home page of the Springboot project:

![Picture alt](https://img.alicdn.com/imgextra/i3/O1CN01jLfCaE1amQGuXQI8Q_!!6000000003372-2-tps-2594-1558.png)

> note: if the jar package of the Springboot project deployed here is very large and exceeds the maximum limit of 100M for function calculation, please refer to [practice of deploying large code packages for function calculation](https://github.com/awesome-fc/fc-faq/blob/main/docs/大代码包部署的实践案例.md)


# About Us
- Serverless Devs Tools:
    - Repository: [https://www.github.com/serverless-devs/serverless-devs](https://www.github.com/serverless-devs/serverless-devs)
      > Welcome to add a :star2:
    - Official website: [https://www.serverless-devs.com/](https://www.serverless-devs.com/)
- Alibaba Cloud Function Compute components:
    - Repository: [https://github.com/devsapp/fc](https://github.com/devsapp/fc)
    - Help document: [https://www.serverless-devs.com/fc/readme](https://www.serverless-devs.com/fc/readme)
- Dingding communication group: 33947367