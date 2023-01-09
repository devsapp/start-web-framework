/* eslint valid-jsdoc: "off" */

'use strict';
const path = require('path');

/**
 * @param {Egg.EggAppInfo} appInfo app info
 */
module.exports = appInfo => {
  /**
   * built-in config
   * @type {Egg.EggAppConfig}
   **/
  const config = exports = {};

  // use for cookie sign key, should change to your own and keep security
  config.keys = appInfo.name + '_1586592205046_9870';

  config.cluster = {
    listen: {
      path: '',
      port: 9000,
      hostname: '0.0.0.0',
    }
};

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
