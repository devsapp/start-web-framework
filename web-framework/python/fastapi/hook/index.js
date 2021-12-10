async function preInit(inputObj) {
    console.log(`\n    ___________                __     _____ __________.___ 
    \\_   _____/____    _______/  |_  /  _  \\\\______   \\   |
     |    __) \\__  \\  /  ___/\\   __\\/  /_\\  \\|     ___/   |
     |     \\   / __ \\_\\___ \\  |  | /    |    \\    |   |   |
     \\___  /  (____  /____  > |__| \\____|__  /____|   |___|
         \\/        \\/     \\/               \\/              `)
}

async function postInit(inputObj) {

    console.log(`\n    Welcome to the start-fasterapi application
     This application requires to open these services: 
         FC : https://fc.console.aliyun.com/
     
     * 额外说明：s.yaml中声明了actions：
        部署前执行：s build --use-docker
       如果已经进行了手动项目构建，可根据需要取消actions内容 
     * 项目初始化完成，您可以直接进入项目目录下，并使用 s deploy 进行项目部署\n`)
}

module.exports = {
    postInit,
    preInit
}
