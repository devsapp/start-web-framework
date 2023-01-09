'use strict';

/**
 * docker 中 node 路径：/var/lang/node12/bin/node
 * NODE_LOG_DIR 是为了改写 egg-scripts 默认 node 写入路径（~/logs）-> /tmp
 * EGG_APP_CONFIG 是为了修改 egg 应有的默认当前目录 -> /tmp
 */

const { Application } = require('egg');

const app = new Application({
  mode: 'single',
});

app.listen(9000, '0.0.0.0', () => {
  console.log('Server start on http://0.0.0.0:9000');
});