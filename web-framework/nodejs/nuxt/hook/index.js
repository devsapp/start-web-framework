async function preInit(inputObj) {

}

async function postInit(inputObj) {
    console.log(`\n     _   _           _     _     
    | \\ | |         | |   (_)    
    |  \\| | _____  _| |_   _ ___ 
    | . \` |/ _ \\ \\/ / __| | / __|
    | |\\  |  __/>  <| |_ _| \\__ \\
    \\_| \\_/\\___/_/\\_\\\\__(_) |___/
                         _/ |    
                        |__/     
                                        `)
    console.log(`\n    Welcome to the start-nuxt application
     This application requires to open these services: 
         FC : https://fc.console.aliyun.com/
     This application can help you quickly deploy the Nuxt project:
         Full yaml configuration: https://github.com/devsapp/fc/blob/main/docs/zh/yaml.md
     This application homepage: https://github.com/devsapp/start-web-framework\n`)
}

module.exports = {
    postInit,
    preInit
}