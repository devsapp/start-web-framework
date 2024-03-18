# coding=utf-8

import os

os.system("s registry login --token {}".format(os.environ["REGISTRY_TOKEN"]))


def search_publish_yaml(directory):
    success_app_list = []
    for root, dirs, files in os.walk(directory):
        if "publish.yaml" in files:
            d = os.path.join(os.getcwd(), root)
            print("try publish dir = {}".format(d))
            try:
                os.system("cd {} && s registry publish".format(d))
                success_app_list.append(d)
            except Exception as e:
                print(str(e))

    print("\n\n*****************\n")
    for item in success_app_list:
        print("{} published success".format(item))


# 在当前目录递归搜索
search_publish_yaml(".")
