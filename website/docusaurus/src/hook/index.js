async function preInit(inputObj) {
    console.log(`\n  ____                                                  
 |  _ \\  ___   ___ _   _ ___  __ _ _   _ _ __ _   _ ___ 
 | | | |/ _ \\ / __| | | / __|/ _\` | | | | '__| | | / __|
 | |_| | (_) | (__| |_| \\__ \\ (_| | |_| | |  | |_| \\__ \\
 |____/ \\___/ \\___|\\__,_|___/\\__,_|\\__,_|_|   \\__,_|___/

     
                                      `)
}

async function postInit(inputObj) {

    console.log(`\n    Welcome to the website static application
     This application requires to open these services: 
         OSS : https://oss.console.aliyun.com/
         CDN : https://cdn.console.aliyun.com/

     * 部署前执行：npm install --production
       如果遇到npm命令找不到等问题，可以适当进行手动项目构建，并根据需要取消actions内容 
     * 项目初始化完成，您可以直接进入项目目录下，并使用 s deploy 进行项目部署\n`)
}

module.exports = {
    postInit,
    preInit
}
