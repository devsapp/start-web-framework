async function preInit(inputObj) {
    console.log(`\n     ______       ___  _______  __    _  _______  _______  _______  ___      _______  _______ 
    |      |     |   ||   _   ||  |  | ||       ||       ||  _    ||   |    |       ||       |
    |  _    |    |   ||  |_|  ||   |_| ||    ___||   _   || |_|   ||   |    |   _   ||    ___|
    | | |   |    |   ||       ||       ||   | __ |  | |  ||       ||   |    |  | |  ||   | __ 
    | |_|   | ___|   ||       ||  _    ||   ||  ||  |_|  ||  _   | |   |___ |  |_|  ||   ||  |
    |       ||       ||   _   || | |   ||   |_| ||       || |_|   ||       ||       ||   |_| |
    |______| |_______||__| |__||_|  |__||_______||_______||_______||_______||_______||_______|`)
}

async function postInit(inputObj) {
    console.log(`\n    Welcome to the django-blog application
     This application requires to open these services: 
         FC : https://fc.console.aliyun.com/
         NAS: https://nas.console.aliyun.com/
     The application can help you quickly deploy the django-blog project
     
      * Recommended Python version: python3.7;
      * If the version is over 3.7, the following error may be prompted:
         Operation error: ImportError: cannot import name 'metadata' from 'importlib'
         You can refer to the documentation at this point: https://stackoverflow.com/questions/59216175/importerror-cannot-import-name-metadata-from-importlib
      * Default information for this project:
         * Django management background: /admin
         * Default user: django
         * Default password: djangoblog
      * Additional note: actions are declared in s.yaml:
         Execute before deployment: pip3 install -r requirements.txt -t .
         Execute after deployment: s nas upload ./db.sqlite3 /mnt/auto
        If you encounter problems such as npm command cannot be found, you can manually build the project appropriately, and cancel the content of actions as needed
      * After the project is initialized, you can directly enter the project directory and use s deploy to deploy the project
     \n`)
}

module.exports = {
    postInit,
    preInit
}
