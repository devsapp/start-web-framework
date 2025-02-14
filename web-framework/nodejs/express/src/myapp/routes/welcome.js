const express = require('express');
const router = express.Router();
const {logger} = require('../logger/config')

/* GET home page. */
router.get('/', function(req, res) {
    logger.info('welcome page');
    res.render('index', { group: 'Devsapp' });
});

module.exports = router;
