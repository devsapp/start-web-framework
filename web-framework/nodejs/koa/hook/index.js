async function preInit(inputObj) {

}

async function postInit(inputObj) {
    console.log(`\n     _____            
    |  ___|           
    | |__  __ _  __ _ 
    |  __|/ _\` |/ _\` |
    | |__| (_| | (_| |
    \\____/\\__, |\\__, |
           __/ | __/ |
          |___/ |___/ 
                                        `)
    console.log(`\n    Welcome to the start-egg application
     This application requires to open these services: 
         FC : https://fc.console.aliyun.com/
     This application can help you quickly deploy the Egg project:
         Full yaml configuration : https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/yaml.md
         Egg.js development docs: https://eggjs.org/zh-cn/tutorials/index.html
     This application homepage: https://github.com/devsapp/start-web-framework\n`)
}

module.exports = {
    postInit,
    preInit
}
