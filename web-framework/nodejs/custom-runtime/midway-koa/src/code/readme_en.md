# Egg.js case

<toc>

<p align="center"><b> <a href="./readme.md"> 中文 </a> | English </b></p>

- [Quick start](#Quick-start)
    - [Deploy via command line tool](#Deploy-via-command-line-tools)
- [Application details](#Application-details)
- [About Us](#About-Us)

</toc>

# Quick start

- [:octocat: source](https://github.com/devsapp/start-web-framework/tree/master/web-framework/nodejs/custom-runtime/egg/src)
- [:earth_africa: Effect Preview](http://midway-koa.web-framework.1767215449378635.cn-hangzhou.fc.devsapp.net/)

## Deploy via command line tools

> Before starting, you need to install the Serverless Devs developer tools: `npm install @serverless-devs/s -g`, for more installation methods, please refer to [Serverless Devs Installation Documentation](https://www.serverless-devs.com/serverless-devs/install) , you also need to configure key information for Alibaba Cloud. For the method of configuring key information, please refer to [Alibaba Cloud Key Configuration Document](https://www.serverless-devs.com/fc/config)
- Initialize the project: `s init start-egg -d start-egg`
    > It involves determining the selection of the key, the determination of the service name, the determination of the function name, and the determination of the container image
- Enter the project: `cd start-egg`
- Deploy the project: `s deploy -y`
- Invoke： According to the returned `url` information, you can make a request in the browser

# Application details
Midway is an Alibaba-Taobao front-end architecture team that developed the Node.js framework based on incremental concepts.


Midway is a TypeScript programming paradigm that combines OOP + Class + IoC and FP + Function + Hooks. On top of this, it supports Web/full stack/micro service/RPC/Socket/Serverless and other scenarios, and is committed to providing users with simple, easy-to-use and reliable Node.js server development experience. This application is a ` midway koa ` [Serverless - Devs] (https://www.github.com/serverless-devs/serverless-devs) by applying the deployment to FC function calculation

# About Us
- Serverless Devs Tools:
    - Repository: [https://www.github.com/serverless-devs/serverless-devs](https://www.github.com/serverless-devs/serverless-devs)
      > Welcome to add a :star2:
    - Official website: [https://www.serverless-devs.com/](https://www.serverless-devs.com/)
- Alibaba Cloud Function Compute components:
    - Repository: [https://github.com/devsapp/fc](https://github.com/devsapp/fc)
    - Help document: [https://www.serverless-devs.com/fc/readme](https://www.serverless-devs.com/fc/readme)
- Dingding communication group: 33947367