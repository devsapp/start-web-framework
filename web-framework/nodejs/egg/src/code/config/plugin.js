'use strict';

/** @type Egg.EggPlugin */
module.exports = {
  // had enabled by egg
  nunjucks: {
    enable: true,
    package: 'egg-view-nunjucks',
  },
  static: {
    enable: false,
  },
  i18n: {
    enable: false,
  },
  watcher: {
    enable: false,
  },
  logrotator: {
    enable: false,
  },
  schedule: {
    enable: false,
  },
  development: {
    enable: false,
  },
};
