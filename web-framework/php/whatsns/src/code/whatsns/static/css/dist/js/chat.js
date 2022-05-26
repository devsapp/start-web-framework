/**
 * Created by Administrator on 2016/7/5.
 */
(function(){
    var key='all',mkey;
    var users={};
    var url='ws://101.200.198.144:8080';
    var so=false,n=false;
    var lus=A.$('us'),lct=A.$('ct');
    $(".qp").click(function(){
$("#ct").html("");
    });
    function st(){
        //n=prompt('请给自己取一个响亮的名字：');
        //n=n.substr(0,16);
        var n=g_username;
        if(!n){
            return ;
        }
        so=new WebSocket(url);
        so.onopen=function(){
            if(so.readyState==1){
                so.send('type=add&ming='+n+"&avatar="+g_uid_avatar+"&uid="+g_uid+"&expert="+isexpert);
            }
        }

        so.onclose=function(){
            so=false;
            lct.appendChild(A.$$('<p class="c2 text-center text-danger">退出聊天室</p>'));
        }

        so.onmessage=function(msg){
            eval('var da='+msg.data);

            $(".lasttime").html(da.time);
            var obj=false,c=false;
             
            if(da.type=='add'){
                var ct_user='<div class="chat-user"> <span class="pull-right label label-primary">在线</span> <img width="36" height="36" class="chat-avatar" src="$avatar" alt=""><div class="chat-user-name"> <a id="$code" >$name</a> &nbsp;&nbsp;<span class="text-danger">$expert</span> </div> </div>';


                 

                var u_name=ct_user.replace('$name',da.name);
               u_name=u_name.replace('$code',da.code);

               u_name=u_name.replace('$avatar',da.avatar);
               if(da.expert=='1'){
            	   u_name=u_name.replace('$expert','<i class="icon icon-star text-danger"></i>专家');
               }else{
            	   u_name=u_name.replace('$expert','');
               }

                var obj=A.$$(u_name);
                lus.appendChild(obj);
                cuser(obj,da.code);
                obj=A.$$('<p class="text-center text-danger"><span>['+da.time+']&nbsp;&nbsp;</span>欢迎<a>'+da.name+'</a>加入</p>');
                c=da.code;
            }else if(da.type=='madd'){
                mkey=da.code;
                da.users.unshift({'code':'all','name':'大家'});
                for(var i=0;i<da.users.length;i++){

                    var ct_user='<div class="chat-user"> <span class="pull-right label label-primary">在线</span> <img  width="36" height="36" class="chat-avatar" src="$avatar" alt=""><div class="chat-user-name"> <a id="$code">$name</a> &nbsp;&nbsp;<span class="text-danger">$expert</span> </div> </div>';




                    var u_name=ct_user.replace('$name',da.users[i].name);
                 u_name=u_name.replace('$code',da.users[i].code);

                 if(da.users[i].code=='all'){
                	 u_name=u_name.replace('$avatar',"http://www.zi-han.net/theme/hplus/img/a2.jpg");
                 }else{
                	 u_name=u_name.replace('$avatar',da.users[i].avatar);
                 }
                    
                 if(da.expert=='1'){
              	   u_name=u_name.replace('$expert','<i class="icon icon-star text-danger"></i>专家');
                 }else{
              	   u_name=u_name.replace('$expert','');
                 }
                    
                   console.log(da.users[i]);
                    var obj=A.$$(u_name);

                    lus.appendChild(obj);
                    if(mkey!=da.users[i].code){
                        cuser(obj,da.users[i].code);
                    }else{
                        obj.className='chat-user my';
                        document.title=da.users[i].name;
                    }
                }
                obj=A.$$('<p class="text-danger text-center"><span>['+da.time+']&nbsp;&nbsp;</span>欢迎'+da.name+'加入</p>');
                users.all.className='chat-user ck';
            }

            if(obj==false){
                if(da.type=='rmove'){
                    console.log(users);
                    console.log("id:"+da.nrong);
                    var obj=A.$$('<p class="c2 text-danger text-center"><span>['+da.time+']&nbsp;&nbsp;</span>'+$("#"+da.nrong).html()+'退出聊天室</p>');
                    lct.appendChild(obj);


                    users[da.nrong].del();
                    delete users[da.nrong];
                }else{
                    da.nrong=da.nrong.replace(/{\\(\d+)}/g,function(a,b){
                        return '<img data-toggle="lightbox"  data-image="'+g_site_url+'/css/images/sk/'+b+'.gif" data-caption="小图看大图" class="img-thumbnail" src="'+g_site_url+'/css/images/sk/'+b+'.gif">';
                    }).replace(/^data\:image\/png;base64\,.{50,}$/i,function(a){
                        return '<img data-toggle="lightbox" data-caption="小图看大图" class="img-thumbnail" data-image="'+a+'" src="'+a+'">';
                    });
                    //da.code 发信息人的code
                    if(da.code1==mkey){
                        var other_user=' <div class="c3 chat-message"> <img class="message-avatar" src="$avatar" alt=""> <div class="message">  <a class="message-author" href="#"> $name</a>  <span class="message-date"> $time </span><span class="message-content">$content     </span>      </div>  </div>';
                        other_user=other_user.replace('$name',$("#"+da.code).html()+'&nbsp;对我说：');
                        other_user=other_user.replace('$time',da.time);
                        other_user=other_user.replace('$avatar',$("#"+da.code).parent().parent().find("img").attr("src"));
                        other_user=other_user.replace('$content',da.nrong);
                        obj=A.$$(other_user);

                        c=da.code;
                    }else if(da.code==mkey){

                        if(da.code1!='all'){
                            var my_message=' <div class="c3 me-chat-message">  <img class="message-avatar" src="$avatar" alt=""> <div class="message"> <a class="message-author" href="#"> $name </a> <span class="message-date">  $time </span> <span class="message-content">$content </span>  </div> </div>';
                            var my_user=my_message.replace('$name','我对'+$("#"+da.code1).html()+'说：');
                            my_user=my_user.replace('$time',da.time);
                            my_user=my_user.replace('$avatar',$("#"+da.code).parent().parent().find("img").attr("src"));
                            my_user=my_user.replace('$content',da.nrong);
                            obj=A.$$(my_user);
                        }else{
                            var my_message=' <div class="me-chat-message">  <img class="message-avatar" src="$avatar" alt=""> <div class="message"> <a class="message-author" href="#"> $name </a> <span class="message-date">  $time </span> <span class="message-content">$content </span>  </div> </div>';
                            var my_user=my_message.replace('$name','我对'+$("#"+da.code1).html()+'说：');
                            my_user=my_user.replace('$time',da.time);
                            my_user=my_user.replace('$avatar',$("#"+da.code).parent().parent().find("img").attr("src"));
                            my_user=my_user.replace('$content',da.nrong);
                            obj=A.$$(my_user);

                        }
                        c=da.code1;



                    }else if(da.code==false){
                        var other_user=' <div class="c3 chat-message"> <img class="message-avatar" src="$avatar" alt=""> <div class="message">  <a class="message-author" href="#"> $name</a>  <span class="message-date"> $time </span><span class="message-content">$content     </span>      </div>  </div>';
                        other_user=other_user.replace('$name','游客说：');
                        other_user=other_user.replace('$time',da.time);
                        other_user=other_user.replace('$avatar',$("#"+da.code).parent().parent().find("img").attr("src"));
                        other_user=other_user.replace('$content',da.nrong);
                        obj=A.$$(other_user);

                    }else if(da.code1){
                        var other_user=' <div class="c3 chat-message"> <img class="message-avatar" src="$avatar" alt=""> <div class="message">  <a class="message-author" href="#"> $name</a>  <span class="message-date"> $time </span><span class="message-content">$content     </span>      </div>  </div>';
                        other_user=other_user.replace('$name',$("#"+da.code).html()+"&nbsp;对&nbsp;"+$("#"+da.code1).html()+'说：');
                        other_user=other_user.replace('$time',da.time);
                        other_user=other_user.replace('$avatar',$("#"+da.code).parent().parent().find("img").attr("src"));
                        other_user=other_user.replace('$content',da.nrong);
                        obj=A.$$(other_user);

                        c=da.code;
                    }
                }
            }
            if(c){
                obj.children[1].onclick=function(){

                    users[c].onclick();
                }
            }
            lct.appendChild(obj);
            lct.scrollTop=Math.max(0,lct.scrollHeight-lct.offsetHeight);
        }
    }
    A.$('sd').onclick=function(){
        if(!so){
            return st();
        }
        var da=A.$('nrong').value.trim();
        if(da==''){
            $(".tipmsg").html("内容不能为空!");
            $("#myModal").modal("show");
            return false;
        }
        A.$('nrong').value='';
        so.send('nr='+esc(da)+'&key='+key);
    }
    A.$('nrong').onkeydown=function(e){
        var e=e||event;
        if(e.keyCode==13){
            A.$('sd').onclick();
        }
    }
    function esc(da){
        da=da.replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/\"/g,'&quot;');
        return encodeURIComponent(da);
    }
    function cuser(t,code){
        users[code]=t;
        t.onclick=function(){
            t.parentNode.children.rcss('ck','');
            t.rcss('','ck');
            key=code;
        }
    }

    st();


    var bq=A.$('imgbq'),ems=A.$('ems');
    var l=30,r=4,c=5,s=1,p=Math.ceil(l/(r*c));
    var pt=g_site_url+'/css/images/sk/';
    bq.onclick=function(e){
        var e=e||event;
        if(!so){
            return st();
        }
        ems.style.display='block';
        document.onclick=function(){
            gb();
        }
        ct();
        try{e.stopPropagation();}catch(o){}
    }

    for(var i=0;i<p;i++){
        var a=A.$$('<a href="javascript:;">'+(i+1)+'</a>');
        ems.children[1].appendChild(a);
        ef(a,i);
    }
    ems.children[1].children[0].className='ck';

    function ct(){
        var wz=bq.weiz();
        with(ems.style){
            top=-'193px';
            left='0px';
        }
    }

    function ef(t,i){
        t.onclick=function(e){
            var e=e||event;
            s=i*r*c;
            ems.children[0].innerHTML='';
            hh();
            this.parentNode.children.rcss('ck','');
            this.rcss('','ck');
            try{e.stopPropagation();}catch(o){}
        }
    }

    function hh(){
        var z=Math.min(l,s+r*c);
        for(var i=s;i<z;i++){
            var a=A.$$('<img src="'+pt+i+'.gif">');
            hh1(a,i);
            ems.children[0].appendChild(a);
        }
        ct();
    }

    function hh1(t,i){
        t.onclick=function(e){
            var e=e||event;
            A.$('nrong').value+='{\\'+i+'}';
            if(!e.ctrlKey){
                gb();
            }
            try{e.stopPropagation();}catch(o){}
        }
    }

    function gb(){
        ems.style.display='';
        A.$('nrong').focus();
        document.onclick='';
    }
    hh();
    A.on(window,'resize',function(){
        A.$('ltian').style.height=(document.documentElement.clientHeight - 70)+'px';
        ct();
    })

    var fimg=A.$('upimg');
    var img=new Image();
    var dw=400,dh=300;
    A.on(fimg,'change',function(ev){
        if(!so){
            st();
            return false;
        }
        if(key=='all'){
            $(".tipmsg").html("由于资源限制 发图只能私聊");
            $("#myModal").modal("show");

            return false;
        }
        var f=ev.target.files[0];
        if(f.type.match('image.*')){
            var r = new FileReader();
            r.onload = function(e){
                img.setAttribute('src',e.target.result);
            };
            r.readAsDataURL(f);
        }
    });
    img.onload=function(){
        ih=img.height,iw=img.width;
        if(iw/ih > dw/dh && iw > dw){
            ih=ih/iw*dw;
            iw=dw;
        }else if(ih > dh){
            iw=iw/ih*dh;
            ih=dh;
        }
        var rc = A.$$('canvas');
        var ct = rc.getContext('2d');
        rc.width=iw;
        rc.height=ih;
        ct.drawImage(img,0,0,iw,ih);
        var da=rc.toDataURL();
        so.send('nr='+esc(da)+'&key='+key);
    }

})();