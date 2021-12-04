#!/usr/bin/env python
# -*- coding: utf-8 -*-
import json
import sys
import requests

def send(text, link):
    url = "https://kapi.kakao.com/v2/api/talk/memo/default/send"
    # 용자토큰
    headers = {
        "Authorization": "Bearer " + "o-bi2d8CDualtG05I2kCVkBa-6ZGj4ZzWPeFdQorDNQAAAF9hCFQLQ"
    }
    data = {
        "template_object" : json.dumps({ "object_type" : "text",
                                        "text" : text,
                                        "link" : {
                                                    "web_url" : link
                                                }
        })
    }
    response = requests.post(url, headers=headers, data=data)
    print(response.status_code)
    if response.json().get('result_code') == 0:
        print('메시지를 성공적으로 보냈습니다.')
    else:
        print('메시지를 성공적으로 보내지 못했습니다. 오류메시지 : ' + str(response.json()))
    


send(sys.argv[1], sys.argv[2])