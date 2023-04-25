"use strict"
const { CLI, checkUpdate } = require('@midwayjs/cli/dist');

const dotenv = require('dotenv');
dotenv.config();

const cli = new CLI({
  _: [ 'dev' ],
  ts: true,
  npm: 'pnpm --registry=https://registry.npmmirror.com/'
});
  cli
    .start()
    .then(() => {
      process.exit();
    })
    .catch(e => {
      console.log('\n\n\n');
      console.log(
        'Error! You can try adding the -V parameter for more information output.'
      );
      console.log('\n\n\n');
      console.error(e);
      process.exitCode = 1;
      process.exit(1);
    });

