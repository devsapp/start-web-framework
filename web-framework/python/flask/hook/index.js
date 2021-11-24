async function preInit(inputObj) {

}

async function postInit(inputObj) {
    console.log(`\n    ______ _           _    
    |  ___| |         | |   
    | |_  | | __ _ ___| | __
    |  _| | |/ _\` / __| |/ /
    | |   | | (_| \\__ \\   < 
    \\_|   |_|\\__,_|___/_|\\_\\          
                                        `)
    console.log(`\n    Welcome to the start-flask application
     This application requires to open these services: 
         FC : https://fc.console.aliyun.com/
     This application can help you quickly deploy the Flask project:
         Full yaml configuration : https://github.com/devsapp/fc/blob/main/docs/zh/yaml.md
         Flask development docs : https://dormousehole.readthedocs.io/en/latest/
     This application homepage: https://github.com/devsapp/start-web-framework\n`)
}

module.exports = {
    postInit,
    preInit
}
