<html>
    <div class="container">
    <link href="hospital.css" rel="stylesheet"/>
    <div class="topBar">
      <img class="logo" onclick="goIndex()" src="../assets/logo.png" style="width: 60px;"></img>
      <nav class="navBar">
        <a id="hospital" onclick="goHospital()">병원</a>
        <a id="pharmacy" onclick="goPharmacy()">약국</a>
        <a id="medicine" onclick="goMedicine()">약</a>
        <a id="store" onclick="goRecord()">기록</a>
      </nav>
    </div>
    <div class="hospitalContainer">
      <div class="where">
        <h2>❓현재 위치를 알려주세요!</h2>
        <div id="map" style="width:500px;height:400px;"></div>
      </div>
      <div id="hospital">
          <h2>🏥근처 병원을 찾아보세요!</h2>
          <button id="find-hospital">근처 병원 찾기</button>
          <ol id="hospital-list"></ol>
        </div>
      </div>
      <div id="hospital-map" style="max-width: 500px; height: 400px"></div>
  </div>
  <script type="text/javascript" src="./script.js"></script> 
  <script src="https://developers.kakao.com/sdk/js/kakao.js"></script>
  <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=8be14ebb15975289754d69e11dec6463"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
</html>
<script>
// 지도 만들기 
var container = document.getElementById("map");
var options = {
    center: new kakao.maps.LatLng(127.0264647, 37.5755913 ),
    level: 3
};

var map = new kakao.maps.Map(container, options);
var gps_use = null; //gps의 사용가능 여부
var gps_lat = null; // 위도
var gps_lng = null; // 경도
var gps_position; // gps 위치 객체

gps_check();
// gps가 이용가능한지 체크하는 함수이며, 이용가능하다면 show location 함수를 불러온다.
// 만약 작동되지 않는다면 경고창을 띄우고, 에러가 있다면 errorHandler 함수를 불러온다.
// timeout을 통해 시간제한을 둔다.
function gps_check(){
    if (navigator.geolocation) {
        var options = {timeout:60000};
        navigator.geolocation.getCurrentPosition(showLocation, errorHandler, options);
    } else {
        alert("GPS_추적이 불가합니다.");
        gps_use = false;
    }
}

// gps 이용 가능 시, 위도와 경도를 반환하는 showlocation함수.
function showLocation(position) {
    console.log("mhere");
    gps_use = true;
    gps_lat = position.coords.latitude;
    gps_lng = position.coords.longitude;
    
    markerPosition = new kakao.maps.LatLng(gps_lat, gps_lng);
    var marker = new kakao.maps.Marker({
        position: markerPosition,
    });
    map.setCenter(markerPosition);
    marker.setMap(map);
    localStorage.clear(); 
    localStorage.setItem('posX', gps_lat);
    localStorage.setItem('posY', gps_lng);
    console.log(gps_lat, gps_lng);
}
function errorHandler(error) {
    if(error.code == 1) {
        alert("접근차단");
    } else if( err.code == 2) {
        alert("위치를 반환할 수 없습니다.");
    }
    gps_use = false;
} 
</script>
<?php

    $connect = mysqli_connect("localhost", "root", "cscscs", "medicine");
    if($connect -> connect_errno) {
        die("Cannot connect! " . $connect -> connect_error);
    }
    $posX = "<script>document.write(localStorage.getItem('posX'));</script>"; //37..ss..
    $posY = "<script>document.write(localStorage.getItem('posY'));</script>"; //127..d...
    $sql = "SELECT * FROM hospital";
    $result = mysqli_query($connect, $sql);
    if (mysqli_num_rows($result) > 0) {
        // while($row = mysqli_fetch_assoc($result)) {
            for($i=0; $i<5; $i++){
                $row = mysqli_fetch_assoc($result);
                $rowX = $row["XPos"]."1111";
                // echo (double)$rowX . "<br>";
                echo $posX . "<br>";
                echo gettype((float)($posX));

                // echo (double)$rowX - $posX . "<br>";
            }
            // if ((int)($row["XPos"] - (int)$posX < 0.000000005 )&&((int)($row["YPos"] - (int)$posY < 0.000000005))){
            //     echo "아이디: " . $row["id"]. " 병원이름:" . $row["yadmNm"]. "<br>";
            //     // echo $searchItem . "FIND"; 
            //     // $searchResult = $row;
            // }   
        // }
    }else{
    echo "테이블에 데이터가 없습니다.";
    }
    mysqli_close($connect); // 디비 접속 닫기
?>

