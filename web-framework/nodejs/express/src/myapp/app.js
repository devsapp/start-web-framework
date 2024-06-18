const createError = require('http-errors');
const express = require('express');
const path = require('path');
const cookieParser = require('cookie-parser');
const {v4: uuidv4} = require('uuid');
const {logger, requestContext} = require('./logger/config')

const welcomeRouter = require('./routes/welcome')
const ossRouter = require('./routes/oss')
const debugRouter = require('./routes/debug')

const app = express();

// view engine setup
app.set('views', path.join(__dirname, 'views'));
app.set('view engine', 'pug');


function requestIdMiddleware(req, res, next) {
    let requestId = req.headers['x-fc-request-id'] || 'unknown-request-id';
    requestContext.run(() => {
        requestContext.set('requestId', requestId);
        next();
    });
}

app.use(requestIdMiddleware);
app.use(express.json());
app.use(express.urlencoded({extended: false}));
app.use(cookieParser());
app.use(express.static(path.join(__dirname, 'public')));

app.use('/', welcomeRouter);
app.use('/oss', ossRouter);
app.use('/debug', debugRouter)

// catch 404 and forward to error handler
app.use(function (req, res, next) {
    next(createError(404));
});

// error handler
app.use(function (err, req, res, next) {
    // set locals, only providing error in development
    res.locals.message = err.message;
    res.locals.error = req.app.get('env') === 'development' ? err : {};

    // render the error page
    res.status(err.status || 500);
    res.render('error');
});

module.exports = app;
