import json
import requests
from requests.api import get

def getFriendsList():
    header = {"Authorization": 'Bearer ' + KAKAO_TOKEN}
    url = "https://kapi.kakao.com/v1/api/talk/friends" #친구 정보 요청

    result = json.loads(requests.get(url, headers=header).text)

    friends_list = result.get("elements")
    friends_id = []

    print(requests.get(url, headers=header).text)
    print(friends_list)

    for friend in friends_list:
        friends_id.append(str(friend.get("uuid")))

        print(friends_id)

KAKAO_TOKEN = "icU_8YrPqMaLaK0maBZ6y3-pRxpTLypU7KY-HAo9dNsAAAF8_TAOlA"
getFriendsList()

