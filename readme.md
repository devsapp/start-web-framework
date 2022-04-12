# Web Framework应用案例

![图片alt](https://serverless-article-picture.oss-cn-hangzhou.aliyuncs.com/1638188430695_20211129122031251935.png)

<p align="center"><b> 中文 | <a href="./README_en.md"> English </a>  </b></p>

将一个传统框架部署到阿里云Serverless平台的方法有很多，可以选择Custom、Custom Container以及原生编程语言的运行时。这其中Custom和原生语言运行时方案，除了启动命令/入口函数不同之外，区别并不是很大，可以根据自己需求进行实现，Custom Container方案相对来说更简单，但是镜像的冷启动速度相对Custom和原生语言运行时比较慢。

目前本案例仓库收录以下常见框架的部署案例：

<table>
<tr>
<th>No.</th>
<th>:fire:Nodejs</th>
<th>Python</th>
<th>PHP</th>
<th>Go</th>
<th>Java</th>
<th>Others</th>
</tr>
<tr>
<td align="center">1</td>
<td align="center">:fire:<a href="./web-framework/nodejs/custom-runtime/express/src">Express [custom]</a></td>
<td align="center">:fire::fire:<a href="./web-framework/python/flask/src">Flask [python3]</a></td>
<td align="center"><a href="./web-framework/php/thinkphp/src">Think PHP [custom]</a></td>
<td align="center">BeeGo</td>
<td align="center">Tomcat/Jetty</td>
<td align="center">Gatsby</td>
</tr>
<tr>
<td align="center">2</td>
<td align="center"><a href="./web-framework/nodejs/custom-runtime/egg/src">Egg [custom]</a></td>
<td align="center"><a href="./web-framework/python/tornado/src">Tornado [custom]</a></td>
<td align="center"><a href="./web-framework/php/laravel/src">laravel [custom]</a></td>
<td align="center">Gin</td>
    <td align="center"><a href="./web-framework/java/springboot">SpringBoot [custom]</a></td><td>Hugo</td>
</tr>
<tr>
<td align="center">3</td>
<td align="center"><a href="./web-framework/nodejs/custom-runtime/next/src">Nextjs [custom]</a></td>
<td align="center"><a href="./web-framework/python/bottle/src">Bottle [python3]</a></td>
    <td align="center"><a href="./web-framework/php/discuz/src">Discuz [custom]</a></td><td></td><td align="center">Quarkus</td>
<td align="center"></td>
</tr>
<tr>
<td align="center">4</td>
<td align="center"><a href="./web-framework/nodejs/custom-runtime/nuxt/src">Nuxtjs [custom]</a></td>
<td align="center"><a href="./web-framework/python/webpy/src">Web.py [python3]</a></td>
<td align="center"> :fire::fire::fire: <a href="./web-framework/php/wordpress/src" >WordPress [custom]</a></td><td></td><td></td>
<td align="center"></td>
</tr>
<tr>
<td align="center">5</td>
<td align="center"> :fire::fire::fire: <a href="./web-framework/nodejs/custom-runtime/hapi/src" >Hapi [custom]</a></td>
<td align="center"><a href="./web-framework/python/django/src" >Django [python3]</a></td>
<td align="center"> :fire::fire::fire: <a href="./web-framework/php/zblog/src" >Zblog [custom]</a></td><td></td><td></td>
<td align="center"></td>
</tr>
<tr>
<td align="center">6</td>
<td align="center"><a href="./web-framework/nodejs/custom-runtime/koa/src">Koa [custom]</a></td>
<td align="center"><a href="./web-framework/python/fastapi/src" >FastAPI [custom]</a></td>
<td align="center"><a href="./web-framework/php/ecshop/src" >Ecshop [custom]</a></td><td></td><td></td><td></td>
</tr>
<tr>
<td align="center">7</td>
<td align="center"><a href="./web-framework/nodejs/nodejs-runtime/nest/src">Nest [nodejs12]</a></td>
<td align="center">Web2py</td>
<td align="center"><a href="./web-framework/php/metinfo/src" >Metinfo [custom]</a></td>
<td></td><td></td><td></td>
</tr>
<tr>
<td align="center">8</td>
<td align="center"> :fire: <a href="./web-framework/nodejs/custom-runtime/midway-koa/src">Midway-koa [custom]</a></td>
<td align="center"><a href="./web-framework/python/pyramid/src" >Pyramid [python3]</a></td>
<td align="center"><a href="./web-framework/php/whatsns/src" >Whatsns [custom]</a></td><td></td><td></td><td></td>
</tr>
<tr>
<td align="center">9</td>
<td align="center"><a href="./web-framework/nodejs/nodejs-runtime/thinkjs/src">Think.js [nodejs12]</a></td>
<td align="center"></td>
<td align="center"><a href="./web-framework/php/typecho/src" >Typecho [custom]</a></td><td></td><td></td><td></td>
</tr>
</table>

> 除了上面的案例之外，还提供了两个简单的实践应用：
> - [基于Express框架的todoList应用](./example/todolist-app/src)：`s init todolist-app`
> - [基于Django框架的博客应用](./example/django-blog/src)：`s init django-blog`    

> SSR 框架：
> - [nuxt-ssr](./web-framework/nodejs/custom-runtime/nuxt-ssr/src): `s init start-nuxt-ssr`

> 为了对比Custom运行时和编程语言原生运行时的框架迁移区别，可以参考以下案例进行自行对比：
>
> | 框架名 | Custom运行时 | Node.js 12运行时 |
> | ----- | ----------- | ----------------|
> | Egg.js | [egg](./web-framework/nodejs/custom-runtime/egg/src) | [egg-app](./web-framework/nodejs/nodejs-runtime/egg/src) |
> | Express.js | [express](./web-framework/nodejs/custom-runtime/express/src) | [express-app](./web-framework/nodejs/nodejs-runtime/express/src) |
> | Koa.js | [koa](./web-framework/nodejs/custom-runtime/koa/src) | [koa-app](./web-framework/nodejs/nodejs-runtime/koa/src) |
> | Hapi.js | [hapi](./web-framework/nodejs/custom-runtime/hapi/src) | [hapi-app](./web-framework/nodejs/nodejs-runtime/hapi/src) |