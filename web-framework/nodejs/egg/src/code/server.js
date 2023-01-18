process.env.EGG_SERVER_ENV = 'prod';
process.env.NODE_ENV = 'production';

const { Application } = require('egg');

const app = new Application({
  mode: 'single',
  env: 'prod',
});

app.listen(9000, '0.0.0.0', () => {
  console.log('Server start on http://0.0.0.0:9000');
});