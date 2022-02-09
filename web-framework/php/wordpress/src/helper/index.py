# coding=utf-8

import requests
import os


def handler(event, context):
    url = os.environ['WP_URL']
    res = requests.get(url)
    print(res.status_code)
