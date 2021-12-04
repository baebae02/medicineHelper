<?php
require('kakaoService.php');
class KakaoAPIService extends KakaoService{
    public function __construct($return_type="")
    {
        parent::__construct($return_type);
    }
    public function getToken()
    {
        $code = $_GET["code"]; // 서버로 부터 토큰을 발급받을 수 있는 코드를 받아옵니다.
        $callUrl = "https://kauth.kakao.com/oauth/token?grant_type=authorization_code&client_id=" . $this->REST_API_KEY . "&redirect_uri=" . $this->REDIRECT_URI . "&code=" . $code . "&client_secret=" . $this->CLIENT_SECRET;
        return $this->excuteCurl($callUrl, "POST", array(),"accessToken");
    }

    public function getProfile()
    {
        $callUrl = "https://kapi.kakao.com/v2/user/me";
        $headers[] = "Authorization: Bearer " . $_SESSION["accessToken"];
        return $this->excuteCurl($callUrl, "POST", $headers, "profile");;
    }    
    public function getAccessTokenInfo()
    {
        $callUrl = "https://kapi.kakao.com/v1/user/access_token_info";
        $headers[] = "Authorization: Bearer " . $_SESSION["accessToken"];
        return $this->excuteCurl($callUrl, "GET", $headers);
    }

    public function setTokenRefresh()
    {
        $callUrl = "https://kauth.kakao.com/oauth/token?grant_type=refresh_token&client_id=" . $this->REST_API_KEY . "&refresh_token=" . $_SESSION["refreshToken"] . "&client_secret=" . $this->CLIENT_SECRET;
        return $this->excuteCurl($callUrl, "POST");
    }

    //Message
    public function sendMessage($data)
    {
        $callUrl = "https://kapi.kakao.com/v2/api/talk/memo/default/send";
        $headers = array('Content-type:application/x-www-form-urlencoded;charset=utf-8');
        $headers[] = "Authorization: Bearer " . $_SESSION["accessToken"];
        return $this->excuteCurl($callUrl, "POST", $headers, $data);
    }    

    public function sendScrap($request_url)
    {
        $callUrl = "https://kapi.kakao.com/v2/api/talk/memo/scrap/send";
        $headers = array('Content-type:application/x-www-form-urlencoded;charset=utf-8');
        $data = 'request_url='.urlencode($request_url);
        $headers[] = "Authorization: Bearer " . $_SESSION["accessToken"];
        return $this->excuteCurl($callUrl, "POST", $headers, $data);
    }       
    
    public function sendCustomTemplate($template_id)
    {
        $callUrl = "https://kapi.kakao.com/v2/api/talk/memo/send?template_id=".$template_id;
        $headers = array('Content-type:application/x-www-form-urlencoded;charset=utf-8');
        $headers[] = "Authorization: Bearer " . $_SESSION["accessToken"];
        return $this->excuteCurl($callUrl, "POST", $headers);
    }        

    public function sendMessageForFriend($receiver_uuids, $message)
    {
        $callUrl = "https://kapi.kakao.com/v2/api/talk/memo/default/send";
        $headers = array('Content-type:application/x-www-form-urlencoded;charset=utf-8');
        $headers[] = "Authorization: Bearer " . $_SESSION["accessToken"];
        $data = array($receiver_uuids);
        $data[] = $message;
        return $this->excuteCurl($callUrl, "POST", $headers, $data);
    }    
}

$data = 'template_object={
    "object_type": "text",
    "text": "텍스트 영역입니다. 최대 200자 표시 가능합니다.",
    "link": {
            "web_url": "https://developers.kakao.com",
            "mobile_web_url": "https://developers.kakao.com"
    },
    "button_title": "바로 확인"
}';
$res = $KakaoAPIService->sendMessage($data);
echo($res->result_code);

?>                   
