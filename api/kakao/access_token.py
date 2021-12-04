import requests
import json

url = "https://kauth.kakao.com/oauth/token"

data = {
    "grant_type" : "authorization_code",
    "client_id" : "7f11095a1868d7db073d251cb3e25b18",
    "redirect_uri" : "https://example.com/oauth",
    "code"         : "bpCeb9c-eQy9ipFVm-CLKaIitRyMu70ugtPHDeeKvpIGpzjQpqJQ_oAC3P9yfGB6uxDL4wo9dZsAAAF9hB-8iQ"
    
}
response = requests.post(url, data=data)

tokens = response.json()

print(tokens)

with open("kakao_token.json", "w") as fp: #kakao_token.py를 작성
    json.dump(tokens, fp)