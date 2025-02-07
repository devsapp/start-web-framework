import logging

from flask import g


class RequestIdFilter(logging.Filter):
    def filter(self, record):
        record.request_id = getattr(g, 'request_id', '')
        return True


# 配置日志记录器
handler = logging.StreamHandler()
handler.setLevel(logging.INFO)
fmt = '%(asctime)s - %(name)s - %(levelname)s - %(request_id)s - %(message)s'
formatter = logging.Formatter(fmt=fmt, datefmt='%Y-%m-%d %H:%M:%S')
handler.setFormatter(formatter)

logger = logging.getLogger(__name__)
logger.setLevel(logging.INFO)
logger.addHandler(handler)
logger.addFilter(RequestIdFilter())
