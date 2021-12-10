async function preInit(inputObj) {
    console.log(`\n     ______       ___  _______  __    _  _______  _______  _______  ___      _______  _______ 
    |      |     |   ||   _   ||  |  | ||       ||       ||  _    ||   |    |       ||       |
    |  _    |    |   ||  |_|  ||   |_| ||    ___||   _   || |_|   ||   |    |   _   ||    ___|
    | | |   |    |   ||       ||       ||   | __ |  | |  ||       ||   |    |  | |  ||   | __ 
    | |_|   | ___|   ||       ||  _    ||   ||  ||  |_|  ||  _   | |   |___ |  |_|  ||   ||  |
    |       ||       ||   _   || | |   ||   |_| ||       || |_|   ||       ||       ||   |_| |
    |______| |_______||__| |__||_|  |__||_______||_______||_______||_______||_______||_______|`)
}

async function postInit(inputObj) {
    console.log(`\n    Welcome to the django-blog application
     This application requires to open these services: 
         FC : https://fc.console.aliyun.com/
         NAS: https://nas.console.aliyun.com/
     The application can help you quickly deploy the django-blog project
     
     * 推荐Python版本：python3.7;
     * 如果版本超过3.7，可能会提示以下错误：
        Operation error: ImportError: cannot import name 'metadata' from 'importlib'
        此时可以参考文档：https://stackoverflow.com/questions/59216175/importerror-cannot-import-name-metadata-from-importlib
     * 本项目默认的信息:
        * Django管理后台：/admin
        * 默认用户：django
        * 默认密码：djangoblog   
     * 额外说明：s.yaml中声明了actions：
        部署前执行：pip3 install -r requirements.txt -t .
        部署后执行：s nas upload ./db.sqlite3 /mnt/auto
       如果遇到npm命令找不到等问题，可以适当进行手动项目构建，并根据需要取消actions内容 
     * 项目初始化完成，您可以直接使用 s deploy 进行项目部署
     \n`)
}

module.exports = {
    postInit,
    preInit
}
