async function preInit(inputObj) {

}

async function postInit(inputObj) {
    console.log(`\n    ______                          _     _ 
    | ___ \\                        (_)   | |
    | |_/ /   _ _ __ __ _ _ __ ___  _  __| |
    |  __/ | | | '__/ _\` | '_ \` _ \\| |/ _\` |
    | |  | |_| | | | (_| | | | | | | | (_| |
    \\_|   \\__, |_|  \\__,_|_| |_| |_|_|\\__,_|
           __/ |                            
          |___/                             
                                        `)
    console.log(`\n    Welcome to the start-pyramid application
     This application requires to open these services: 
         FC : https://fc.console.aliyun.com/
     This application can help you quickly deploy the Pyramid project:
         Full yaml configuration : https://github.com/devsapp/fc/blob/main/docs/zh/yaml.md
         Pyramid development docs: https://trypyramid.com/documentation.html
     This application homepage: https://github.com/devsapp/start-web-framework\n`)
}

module.exports = {
    postInit,
    preInit
}
