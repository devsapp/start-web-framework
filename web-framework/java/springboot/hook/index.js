async function preInit(inputObj) {
    console.log(`\n      _________            .__              ___.                  __   
     /   _____/____________|__| ____    ____\\_ |__   ____   _____/  |_ 
     \\_____  \\\\____ \\_  __ \\  |/    \\  / ___\\| __ \\ /  _ \\ /  _ \\   __\\
     /        \\  |_> >  | \\/  |   |  \\/ /_/  > \\_\\ (  <_> |  <_> )  |  
    /_______  /   __/|__|  |__|___|  /\\___  /|___  /\\____/ \\____/|__|  
            \\/|__|                 \\//_____/     \\/                    `)
}

async function postInit(inputObj) {
    console.log(`\n    Welcome to the start-connect application
     This application requires to open these services: 
         FC : https://fc.console.aliyun.com/
     
     * 额外说明：s.yaml中声明了actions：
        部署前执行：mvn package
       如果遇到mvn命令找不到等问题，可以适当进行手动项目构建，并根据需要取消actions内容 
     * 项目初始化完成，您可以直接进入项目目录下，并使用 s deploy 进行项目部署\n`)
}

module.exports = {
    postInit,
    preInit
}

