async function preInit(inputObj) {
    console.log(`
  Serverless Devs Application Case
    
    Cloud services required：
    - FC : https://fc.console.aliyun.com/
    
    Tips：
    - FC Component: https://www.serverless-devs.com/fc/readme`)

}

async function postInit(inputObj) {
    console.log(`
    * Before using, please check whether the actions command in Yaml file is available
    * Carefully reading the notes in s.yaml is helpful for the use of the tool
    * Recommended Python version: python3.7;
      * If the version is over 3.7, the following error may be prompted:
         Operation error: ImportError: cannot import name 'metadata' from 'importlib'
         You can refer to the documentation at this point: https://stackoverflow.com/questions/59216175/importerror-cannot-import-name-metadata-from-importlib
      * Default information for this project:
         * Django management background: /admin
         * Default user: django
         * Default password: djangoblog
    * If need help in the use process, please apply to join the Dingtalk Group: 33947367
    `)
}

module.exports = {
    postInit,
    preInit
}