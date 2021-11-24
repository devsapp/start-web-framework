async function preInit(inputObj) {

}

async function postInit(inputObj) {
    console.log(`\n     _   _             _ 
    | | | |           (_)
    | |_| | __ _ _ __  _ 
    |  _  |/ _\` | '_ \\| |
    | | | | (_| | |_) | |
    \\_| |_/\\__,_| .__/|_|
                | |      
                |_|      
                                        `)
    console.log(`\n    Welcome to the start-hapi application
     This application requires to open these services: 
         FC : https://fc.console.aliyun.com/
     This application can help you quickly deploy the Hapi project:
         Full yaml configuration : https://github.com/devsapp/fc/blob/main/docs/zh/yaml.md
         Hapi development docs: https://hapi.dev/api
     This application homepage: https://github.com/devsapp/start-web-framework\n`)
}

module.exports = {
    postInit,
    preInit
}
