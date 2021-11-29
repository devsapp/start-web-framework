async function preInit(inputObj) {

}

async function postInit(inputObj) {
    console.log(`\n     _    _      _                  
    | |  | |    | |                 
    | |  | | ___| |__   _ __  _   _ 
    | |/\\| |/ _ \\ '_ \\ | '_ \\| | | |
    \\  /\\  /  __/ |_) || |_) | |_| |
     \\/  \\/ \\___|_.__(_) .__/ \\__, |
                       | |     __/ |
                       |_|    |___/ 
                                        `)
    console.log(`\n    Welcome to the start-webpy application
     This application requires to open these services: 
         FC : https://fc.console.aliyun.com/
     This application can help you quickly deploy the WebPy project:
         Full yaml configuration : https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/yaml.md
         Web.py development docs: http://www.webpy.org/
     This application homepage: https://github.com/devsapp/start-web-framework\n`)
}

module.exports = {
    postInit,
    preInit
}
