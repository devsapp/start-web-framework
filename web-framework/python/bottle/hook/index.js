async function preInit(inputObj) {

}

async function postInit(inputObj) {
    console.log(`\n     ______            _     _   __         
    |_   _ \\          / |_  / |_[  |        
      | |_) |   .--. \`| |-'\`| |-'| | .---.  
      |  __'. / .'\`\\ \\| |   | |  | |/ /__\\\\ 
     _| |__) || \\__. || |,  | |, | || \\__., 
    |_______/  '.__.' \\__/  \\__/[___]'.__.' 
                                        `)
    console.log(`\n    Welcome to the start-bottle application
     This application requires to open these services: 
         FC : https://fc.console.aliyun.com/
     This application can help you quickly deploy the Bottle project:
         Full yaml configuration : https://github.com/devsapp/fc/blob/jiangyu-docs/docs/zh/yaml.md
         Bottle development docs: http://www.bottlepy.com/docs/dev/
     This application homepage: https://github.com/devsapp/start-web-framework\n`)
}

module.exports = {
    postInit,
    preInit
}
