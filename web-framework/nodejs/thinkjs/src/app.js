const os = require('os');
const path = require('path');
const Application = require('thinkjs');
const Loader = require('thinkjs/lib/loader');

const instance = new Application({
  ROOT_PATH: __dirname,
  APP_PATH: path.join(__dirname, 'src'),
  RUNTIME_PATH: path.join(os.tmpdir(), 'runtime'),
  proxy: true, // use proxy
  env: 'thinkjs-runtime'
});
const loader = new Loader(instance.options);
loader.loadAll('worker');

module.exports = async (req, res, context) => {
  await think.beforeStartServer().catch(err => think.logger.error(err));
  await instance._getWorkerInstance(instance.parseArgv());
  think.app.emit('appReady');
  think.app.callback()(req, res, context);
};
