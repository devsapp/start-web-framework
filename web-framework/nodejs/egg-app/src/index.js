const { Application } = require('egg');
const serverless = require('@serverless-devs/fc-http');

const app = new Application({
  env: 'prod',
});

exports.handler = serverless(app);
