document.oncontextmenu=new Function("event.returnValue=false;");
document.onselectstart=new Function("event.returnValue=false;");
//禁止ctrl复制
document.onkeydown=function(){
    if((event.ctrlKey) && (window.event.keycode==67)){
          event.returnValue=false;
         alert("网址禁止复制");
         return false;
    }
}
document.onmousedown=function(){
    if(event.button==2){
        event.returnValue=false;
        alert("网址禁止右键");
        return false;
    }
}