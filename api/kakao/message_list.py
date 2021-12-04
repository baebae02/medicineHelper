import json
import requests
import schedule
import time
from apscheduler.schedulers.background import BackgroundScheduler
from apscheduler.jobstores.base import JobLookupError
url = "https://kapi.kakao.com/v2/api/talk/memo/default/send"

# 사용자 토큰
#내 access_token. 6P ~~~~. 노션에는 서현이 Token의 access_token으로. 
headers = {
    "Authorization": "Bearer " + "o-bi2d8CDualtG05I2kCVkBa-6ZGj4ZzWPeFdQorDNQAAAF9hCFQLQ"
}

template = {
    "object_type" : "list",
    "header_title" : "병원",
    "header_link" : {
        "web_url" : "http://www.sshosp.co.kr/",
        "mobile_web_url" : "http://www.sshosp.co.kr/"
    },
    "contents" : [
        {
            "title" : "물먹으세용!!!",
            "description" : "물물물물",
            "image_url" : "https://search1.kakaocdn.net/argon/0x200_85_hr/8x5qcdbcQwi",
            "image_width" : 50, "image_height" : 50,
            "link" : {
                "web_url" : "http://www.sshosp.co.kr/",
                "mobile_web_url" : "http://www.sshosp.co.kr/"
            }
        },
        {
            "title" : "약먹으세용!!!",
            "description" : "약약약약!!",
            "image_url" : "https://search2.kakaocdn.net/argon/0x200_85_hr/IjIToH1S7J1",
            "image_width" : 50, "image_height" : 50,
            "link" : {
                "web_url" : "http://anam.kumc.or.kr/main/index.do",
                "mobile_web_url" : "http://anam.kumc.or.kr/main/index.do"
            }
        }
        
    ],
    "buttons" : [
        {
            "title" : "웹으로 이동",
            "link" : {
                "web_url" : "www.naver.com",
                "mobile_web_url" : "www.naver.com"
            }
        }
    ]
    
}

data = {
    "template_object" : json.dumps(template)
}

def send():
    res = requests.post(url, data=data, headers=headers)
    print(res.status_code)
    if res.json().get('result_code') == 0:
        print('메시지를 성공적으로 보냈습니다.')
    else:
        print('메시지를 성공적으로 보내지 못했습니다. 오류메시지 : ' + str(res.json()))
def prints():
    print("hello")



sched = BackgroundScheduler()
sched.start()
sched.add_job(send, 'interval', seconds=3, id="test_2")

count = 0
while True:
    print("Running main process...............")
    time.sleep(1)