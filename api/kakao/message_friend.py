# 라이브러리 호출
import requests
import json

# 카카오톡 메시지
#ACCESS_TOKEN = "B2~~~~~"이자 친구목록토큰의 'access_token'
url= "https://kapi.kakao.com/v1/api/talk/friends/message/default/send"
headers = {"Authorization": 'Bearer ' + "icU_8YrPqMaLaK0maBZ6y3-pRxpTLypU7KY-HAo9dNsAAAF8_TAOlA"}

data={
    #지함이의 uuid
    'receiver_uuids': '["c0F4TXlPfERzX2lab1prU2JTf0l8RHdBdxs"]',
    "template_object": json.dumps({
        "object_type":"text",
        "text":"지함아 반가워",
        "link":{
            "web_url" : "https://www.google.co.kr/search?q=deep+learning&source=lnms&tbm=nws",
            "mobile_web_url" : "https://www.google.co.kr/search?q=deep+learning&source=lnms&tbm=nws"
        },
        "button_title": "뉴스 보기"
    })
}

response = requests.post(url, headers=headers, data=data)
print(response.status_code)
if response.json().get('result_code') == 0:
    print('메시지를 성공적으로 보냈습니다.')
else:
    print('메시지를 성공적으로 보내지 못했습니다. 오류메시지 : ' + str(response.json()))