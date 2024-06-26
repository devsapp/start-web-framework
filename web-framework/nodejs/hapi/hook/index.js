const path = require('path');

async function preInit(inputObj) {
    console.log(`
  Serverless Devs Application Case
    
    Cloud services required：
    - FC : https://fc.console.aliyun.com/
    
    Tips：
    - FC3 Component: https://docs.serverless-devs.com/user-guide/aliyun/#fc3`)

}

async function postInit(inputObj) {
    await inputObj.downloadRequest("https://serverless-devs-app-pkg.oss-cn-beijing.aliyuncs.com/node16.zip", 
        path.join(inputObj.targetPath, 'code/bin'), {  extract: true, strip: 1 }
    );

    console.log(`
    * Before using, please check whether the actions command in Yaml file is available
    * Carefully reading the notes in s.yaml is helpful for the use of the tool
    * If need help in the use process, please apply to join the Dingtalk Group: 33947367
    `)
}

module.exports = {
    postInit,
    preInit
}