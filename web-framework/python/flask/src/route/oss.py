from flask import Blueprint, jsonify

from logger.config import logger

from alicloud.oss import oss_client

oss_bp = Blueprint('oss', __name__, url_prefix='/oss')


@oss_bp.route('/listBuckets', methods=['GET'])
def index():
    try:
        resp = oss_client.list_buckets()
        return jsonify(list(map(lambda x : {
            'name': x.name,
            'location': x.location,
            'creation_date': x.creation_date,
            'extranet_endpoint': x.extranet_endpoint,
            'intranet_endpoint': x.intranet_endpoint,
            'storage_class': x.storage_class,
            'region': x.region,
            'resource_group_id': x.resource_group_id
        }, resp.buckets)))
    except Exception as e:
        logger.info('failed to list buckets: %s', e)
        return jsonify(e)
