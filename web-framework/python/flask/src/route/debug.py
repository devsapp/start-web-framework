from logger.config import logger
import os

from flask import Blueprint, jsonify, request

debug_bp = Blueprint('debug', __name__, url_prefix='/debug')


@debug_bp.route('/displayHttpContext', methods=['GET', 'POST', 'PUT', 'DELETE'])
def echo():
    # 构建响应数据
    env = dict(os.environ)
    if 'ALIBABA_CLOUD_ACCESS_KEY_ID' in env:
        env['ALIBABA_CLOUD_ACCESS_KEY_ID'] = 'encrypted'
    if 'ALIBABA_CLOUD_ACCESS_KEY_SECRET' in env:
        env['ALIBABA_CLOUD_ACCESS_KEY_SECRET'] = 'encrypted'
    if 'ALIBABA_CLOUD_SECURITY_TOKEN' in env:
        env['ALIBABA_CLOUD_SECURITY_TOKEN'] = 'encrypted'

    result = {
        'path': request.path,
        'body': request.get_data(as_text=True),
        'method': request.method,
        'queries': request.args,
        'headers': dict(request.headers),
        'env': env,
    }

    # 记录日志信息
    logger.info('receive request: %s', result)

    # 返回 JSON 响应
    return jsonify(result)
