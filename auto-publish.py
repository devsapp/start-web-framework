# coding=utf-8

import os

os.system("s registry login --token {}".format(os.environ["REGISTRY_TOKEN"]))


def search_publish_yaml(directory):
    all_app_list = []
    fail_app_list = []
    for root, dirs, files in os.walk(directory):
        if "publish.yaml" in files:
            d = os.path.join(os.getcwd(), root)
            # print("try publish dir = {}".format(d))
            all_app_list.append(d)
            try:
                os.system("cd {} && s registry publish".format(d))
            except Exception as e:
                print("publish {} error: {}".format(d, str(e)))
                fail_app_list.append(d)

    print("\n\n*****************\n")
    for item in all_app_list:
        if item not in fail_app_list:
            print("{} published success".format(item))
    print("\n\n#################\n")


# 在当前目录递归搜索
search_publish_yaml(".")
