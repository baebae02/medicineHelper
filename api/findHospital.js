function findHospital() {
  const HOSPITAL_API_KEY =
    "Ta6sT%2BivsJ1PVZrsEg4KJQ1A35VgZcgnO1lMFHw0YueFyfqn6Gi0Csllevy1veAryofhGi2SPe1Tp0H4IVvccg%3D%3D";
  const latitude = document.querySelector("#latitude").innerText;
  const longitude = document.querySelector("#longitude").innerText;
  const hospitalNumber = 5;
  const radius = 2000;

  const handlingCORS = "https://cors-anywhere.herokuapp.com/";
  //const handlingCORS = "https://app.cors.bridged.cc/ko/";
  //const handlingCORS = "https://robwu.nl/cors-anywhere.html/";
  //const handlingCORS = "https://cors-proxy.htmldriven.com/?url=/";

  const hospitalList = [];

  if (latitude == "" || longitude == "") {
    alert("먼저 현재 위치를 찾으세요!");
    return;
  }

  $.ajax({
    url: `${handlingCORS}http://apis.data.go.kr/B551182/hospInfoService1/getHospBasisList1?ServiceKey=${HOSPITAL_API_KEY}&numOfRows=${hospitalNumber}&xPos=${longitude}&yPos=${latitude}&radius=${radius}`,
    type: "GET",
    dataType: "json",
    success: function (data) {
      console.log("Ajax 요청 성공");

      //병원 5개 찾기
      for (let i = 0; i < hospitalNumber; i++) {
        const hospitalName = data.response.body.items.item[i].yadmNm;
        const hospitalAddr = data.response.body.items.item[i].addr;
        const hospitalLng = data.response.body.items.item[i].XPos;
        const hospitalLat = data.response.body.items.item[i].YPos;

        //hospitalList에 병원 추가
        const tmp = {};
        tmp.name = hospitalName;
        tmp.addr = hospitalAddr;
        tmp.longitude = hospitalLng;
        tmp.latitude = hospitalLat;
        hospitalList[i] = tmp;

        $("#hospital-list").append(
          "<li><div>" +
            hospitalName +
            "</div><div>" +
            hospitalAddr +
            "</div></li>"
        );
      }
      console.log(hospitalList);

      //지도에 병원 5개 표시
      var mapContainer = document.getElementById("hospital-map");
      var mapOptions = {
        center: new kakao.maps.LatLng(latitude, longitude),
        level: 6,
      };
      var map = new kakao.maps.Map(mapContainer, mapOptions);
      var imageSrc =
        "https://t1.daumcdn.net/localimg/localimages/07/mapapidoc/markerStar.png";

      var currentMarker = new kakao.maps.Marker({
        map: map,
        position: new kakao.maps.LatLng(latitude, longitude),
        title: "현재 위치",
      });

      for (let i = 0; i < hospitalNumber; i++) {
        var imageSize = new kakao.maps.Size(24, 35);
        var markerImage = new kakao.maps.MarkerImage(imageSrc, imageSize);
        var marker = new kakao.maps.Marker({
          map: map,
          position: new kakao.maps.LatLng(
            hospitalList[i].latitude,
            hospitalList[i].longitude
          ),
          title: hospitalList[i].name,
          image: markerImage,
        });
      }
    },
    error: function (request, status, error) {
      alert("Ajax 요청 실패");
    },
  });
}

document
  .querySelector("#find-hospital")
  .addEventListener("click", findHospital);
