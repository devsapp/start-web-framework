# Web Framework application case

![picture alt](https://serverless-article-picture.oss-cn-hangzhou.aliyuncs.com/1638188430695_20211129122031251935.png)

<p align="center"><b> <a href="./readme.md"> 中文 </a> | English </b></p>

There are many ways to deploy a traditional framework to the Alibaba Cloud serverless platform. You can choose Custom, Custom Container, and the runtime of the native programming language. Among them, the Custom and native language runtime solutions are not very different except for the different startup commands/entry functions. They can be implemented according to their own needs. The Custom Container solution is relatively simple, but the cold start speed of the image is relatively high. and native language runtime is slower.

At present, this case repository contains the deployment cases of the following common frameworks:

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
<td align="center">:fire:<a href="./web-framework/nodejs/express/src">Express [custom]</a></td>
<td align="center">:fire::fire:<a href="./web-framework/python/flask/src">Flask [python3]</a></td>
<td align="center"><a href="./web-framework/php/thinkphp/src">Think PHP [custom]</a></td>
<td align="center"><a href="https://github.com/devsapp/start-web-framework/tree/master/web-framework/go/beego/src">BeeGo  [custom]</a></td>
<td align="center">Tomcat/Jetty</td>
<td align="center">Gatsby</td>
</tr>
<tr>
<td align="center">2</td>
<td align="center"><a href="./web-framework/nodejs/egg/src">Egg [custom]</a></td>
<td align="center"><a href="./web-framework/python/tornado/src">Tornado [custom]</a></td>
<td align="center"><a href="./web-framework/php/laravel/src">laravel [custom]</a></td>
<td align="center"><a href="https://github.com/devsapp/start-web-framework/tree/master/web-framework/go/gin/src">Gin [custom]</a></td>
    <td align="center"><a href="./web-framework/java/springboot">SpringBoot [custom]</a></td>
    <td align="center"><a href="https://github.com/liufangchen/start-hugo">Hugo [custom]</a></td>
</tr>
<tr>
<td align="center">3</td>
<td align="center"><a href="./web-framework/nodejs/next/src">Nextjs [custom]</a></td>
<td align="center"><a href="./web-framework/python/bottle/src">Bottle [python3]</a></td>
    <td align="center"><a href="./web-framework/php/discuz/src">Discuz [custom]</a></td><td></td><td align=" center">Quarkus</td>
<td align="center"></td>
</tr>
<tr>
<td align="center">4</td>
<td align="center"><a href="./web-framework/nodejs/nuxt-ssr/src">Nuxtjs [custom]</a></td>
<td align="center"><a href="./web-framework/python/webpy/src">Web.py [python3]</a></td>
<td align="center"> :fire::fire::fire: <a href="./web-framework/php/wordpress/src" >WordPress [custom]</a></td><td> </td><td></td>
<td align="center"></td>
</tr>
<tr>
<td align="center">5</td>
<td align="center">5</td>
<td align="center"> :fire::fire::fire: <a href="./web-framework/nodejs/hapi/src" >Hapi [custom]</a></td>
<td align="center"><a href="./web-framework/python/django/src" >Django [python3]</a></td>
<td align="center"> :fire::fire::fire: <a href="./web-framework/php/zblog/src" >Zblog [custom]</a></td><td> </td><td></td>
<td align="center"></td>
</tr>
<tr>
<td align="center">6</td>
<td align="center"><a href="./web-framework/nodejs/koa/src">Koa [custom]</a></td>
<td align="center"><a href="./web-framework/python/fastapi/src" >FastAPI [custom]</a></td>
<td align="center"><a href="./web-framework/php/ecshop/src" >Ecshop [custom]</a></td><td></td><td></ td><td></td>
</tr>
<tr>
<td align="center">7</td>
<td align="center"><a href="./web-framework/nodejs/nest/src">Nest [custom]</a></td>
<td align="center">Web2py</td>
<td align="center"><a href="./web-framework/php/metinfo/src" >Metinfo [custom]</a></td>
<td></td><td></td><td></td>
</tr>
<tr>
<td align="center">8</td>
<td align="center"> :fire: <a href="./web-framework/nodejs/midway-koa/src">Midway-koa [custom]</a></td>
<td align="center"><a href="./web-framework/python/pyramid/src" >Pyramid [python3]</a></td>
<td align="center"><a href="./web-framework/php/whatsns/src" >Whatsns [custom]</a></td><td></td><td></ td><td></td>
</tr>
<tr>
<td align="center">9</td>
<td align="center"><a href="https://github.com/zjy2414/start-vue3">Vue.js [custom]</a></td>
<td align="center"></td>
<td align="center"><a href="./web-framework/php/typecho/src" >Typecho [custom]</a></td><td></td><td></ td><td></td>
</tr>
</table>

> In addition to the above cases, two simple practical applications are provided:
>
> - [Express framework based todoList app](./example/todolist-app/src): `s init todolist-app`
> - [Django framework based blog application](./example/django-blog/src): `s init django-blog`

> SSR frameworks
>
> - [nuxt-ssr](./web-framework/nodejs/nuxt-ssr/src): `s init start-nuxt-ssr`

> Nginx：
>
> - [nginx](./web-framework/nginx/src): `s init start-nginx`
