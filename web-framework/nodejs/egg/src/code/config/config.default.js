/* eslint valid-jsdoc: "off" */

'use strict';
const os = require('os');
const path = require('path');

const tmpdir = os.tmpdir();

/**
 * @param {Egg.EggAppInfo} appInfo app info
 */
module.exports = appInfo => {
  /**
   * built-in config
   * @type {Egg.EggAppConfig}
   **/
  const config = exports = {
    logger: {
      dir: tmpdir,
    },
    rundir: tmpdir,
  };

  // use for cookie sign key, should change to your own and keep security
  config.keys = appInfo.name + '_1674027067448_8897';

  // add your middleware config here
  config.middleware = [];
  config.view = {
    root: [
      path.join(appInfo.baseDir, 'app/view')
    ].join(','),

    mapping: {
      '.nj': 'nunjucks'
    },

    defaultViewEngine: 'nunjucks',
    defaultExtension: '.nj',
  };

  // add your user config here
  const userConfig = {
    // myAppName: 'egg',
  };

  return {
    ...config,
    ...userConfig,
  };
};
