async function preInit(inputObj) {

}

async function postInit(inputObj) {
    console.log(`\n     ______       ___  _______  __    _  _______  _______  _______  ___      _______  _______ 
    |      |     |   ||   _   ||  |  | ||       ||       ||  _    ||   |    |       ||       |
    |  _    |    |   ||  |_|  ||   |_| ||    ___||   _   || |_|   ||   |    |   _   ||    ___|
    | | |   |    |   ||       ||       ||   | __ |  | |  ||       ||   |    |  | |  ||   | __ 
    | |_|   | ___|   ||       ||  _    ||   ||  ||  |_|  ||  _   | |   |___ |  |_|  ||   ||  |
    |       ||       ||   _   || | |   ||   |_| ||       || |_|   ||       ||       ||   |_| |
    |______| |_______||__| |__||_|  |__||_______||_______||_______||_______||_______||_______|
                                        `)
    console.log(`\n    Welcome to the django-blog application
     This application requires to open these services: 
         FC : https://fc.console.aliyun.com/
     This application can help you quickly deploy the django-blog project.
     The application uses Django component：https://github.com/devsapp/django
     The application homepage: https://github.com/devsapp/django-blog
     
     * Python 3.7 is recommended;
     * If the version is greater than Python 3.7: 
        * Operation error: ImportError: cannot import name 'metadata' from 'importlib', you can refer to: https://stackoverflow.com/questions/59216175/importerror-cannot-import-name-metadata-from-importlib
     * Default information:
        * Admin：/admin
        * Default Admin Username: blog
        * Default Admin Password: myblog12345!     
     \n`)
}

module.exports = {
    postInit,
    preInit
}
