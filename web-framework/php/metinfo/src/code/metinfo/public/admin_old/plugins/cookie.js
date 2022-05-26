/**
 * jquery cookie插件
 * 使用：
 * $.cookie('key'); //读取Cookie值
 * $.cookie('key', 'value'); // 设置/新建cookie的值
 * $.cookie('key', 'value', {expires: 7, path: '/', domain: 'dh89.com', secure: true});//新建一个cookie 包括有效期(天数) 路径 域名等
 * $.cookie('key', null); //删除一个cookie
 */
define((function(e,i,o){jQuery.cookie=function(e,i,o){if(void 0===i){var n=null;if(document.cookie&&""!=document.cookie)for(var r=document.cookie.split(";"),t=0;t<r.length;t++){var u=jQuery.trim(r[t]);if(u.substring(0,e.length+1)==e+"="){n=decodeURIComponent(u.substring(e.length+1));break}}return n}o=o||{},null===i&&(i="",o.expires=-1);var p,s="";o.expires&&("number"==typeof o.expires||o.expires.toUTCString)&&("number"==typeof o.expires?(p=new Date).setTime(p.getTime()+24*o.expires*60*60*1e3):p=o.expires,s="; expires="+p.toUTCString());var c=o.path?"; path="+o.path:"",m=o.domain?"; domain="+o.domain:"",a=o.secure?"; secure":"";document.cookie=[e,"=",encodeURIComponent(i),s,c,m,a].join("")}}));