const path = require('path');
module.exports = function () {
  const pwd = process.env.PWD;
  const config = {
    proxy: 'localhost/ecshop/',
    src: 'src/',
    dist: 'admin/'
  };
  Object.assign(config, {
    scss: `${config.src}admin/scss/`,
    img: `${config.src}admin/images/`,
    css: `${config.dist}styles/`,
    js: `${config.dist}js/`,
    images: `${config.dist}images/`,
  });

  return config;
};
