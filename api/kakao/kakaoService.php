<?php 
class KakaoService  {
    function  __construct($return_type)
    {   //★ 수정 할 것
        $this->JAVASCRIPT_KEY = "dc33ffce9ab578d749e87ddd4d7c0843"; // https://developers.kakao.com > 내 애플리케이션 > 앱 설정 > 요약 정보
        $this->REST_API_KEY   = "7f11095a1868d7db073d251cb3e25b18"; // https://developers.kakao.com > 내 애플리케이션 > 앱 설정 > 요약 정보
        $this->ADMIN_KEY      = "83cd653ba9753759ea69fe8bc83126a6"; // https://developers.kakao.com > 내 애플리케이션 > 앱 설정 > 요약 정보
        $this->CLIENT_SECRET  = "W0xvJRuvZMf9pHfljeMPuc9mRvysFENn"; // https://developers.kakao.com > 내 애플리케이션 > 제품 설정 > 카카오 로그인 > 보안
        $this->RETURN_TYPE  = $return_type;
    
        $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://");
        $this->REDIRECT_URI          = urlencode($protocol . $_SERVER['HTTP_HOST'] . "/example.com/oauth");  // 내 애플리케이션 > 제품 설정 > 카카오 로그인
        $this->LOGOUT_REDIRECT_URI   = urlencode($protocol . $_SERVER['HTTP_HOST'] . "/example.com/oauth"); // 내 애플리케이션 > 제품 설정 > 카카오 로그인 > 고급 > Logout Redirect URI
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
}


?>

