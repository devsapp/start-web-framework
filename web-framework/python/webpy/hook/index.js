async function preInit(inputObj) {
    console.log(`\n     _    _      _                  
    | |  | |    | |                 
    | |  | | ___| |__   _ __  _   _ 
    | |/\\| |/ _ \\ '_ \\ | '_ \\| | | |
    \\  /\\  /  __/ |_) || |_) | |_| |
     \\/  \\/ \\___|_.__(_) .__/ \\__, |
                       | |     __/ |
                       |_|    |___/ 
                                        `)
}

async function postInit(inputObj) {

    console.log(`\n    Welcome to the start-webpy application
     This application requires to open these services: 
         FC : https://fc.console.aliyun.com/
     Web.py development docs: http://www.webpy.org/
     
     * 额外说明：s.yaml中声明了actions：
        部署前执行：pip3 install -r requirements.txt -t .
       如果遇到pip3命令找不到等问题，可以适当进行手动项目构建，并根据需要取消actions内容 
     * 项目初始化完成，您可以直接使用 s deploy 进行项目部署\n`)
}

module.exports = {
    postInit,
    preInit
}
