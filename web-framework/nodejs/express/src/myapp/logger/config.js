const winston = require('winston');
const { createNamespace } = require('cls-hooked');
const requestContext = createNamespace('requestContext');

// 设置 winston logger 实例
const logger = winston.createLogger({
    level: 'info',
    transports: [
        new winston.transports.Console({
            format: winston.format.combine(
                winston.format.colorize(),
                winston.format.timestamp({ format: 'YYYY-MM-DD HH:mm:ss' }),
                winston.format.printf((info) => {
                    const requestId = requestContext.get('requestId') || 'N/A';
                    return `${info.timestamp} [${requestId}] ${info.level}: ${info.message}`;
                    //const requestId = info.meta && info.meta.req && info.meta.req.headers && info.meta.req.headers['x-fc-request-id']  ? info.meta.req.headers.headers['x-fc-request-id'] : 'N/A';
                    return `${info.timestamp} - ${info.level} - ${requestId}: ${info.message}`;
                })
            ),
        })
    ]
});

module.exports = {
    logger,
    requestContext,
};