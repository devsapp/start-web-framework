# Web Framework application case

![picture alt](https://serverless-article-picture.oss-cn-hangzhou.aliyuncs.com/1638188430695_20211129122031251935.png)

> Please note, if you are using Function Compute 2.0, switch to the V2 branch.

<p align="center"><b> <a href="./readme.md"> 中文 </a> | English </b></p>

There are many ways to deploy a traditional framework to the Alibaba Cloud serverless platform. You can choose Custom, Custom Container, and the runtime of the native programming language. Among them, the Custom and native language runtime solutions are not very different except for the different startup commands/entry functions. They can be implemented according to their own needs. The Custom Container solution is relatively simple, but the cold start speed of the image is relatively high. and native language runtime is slower.

For more details, see the readme.md file under the web-framework directory for each language.