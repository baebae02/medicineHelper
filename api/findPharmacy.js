function findPharmacy() {
  const PHARMACY_API_KEY =
    "Ta6sT%2BivsJ1PVZrsEg4KJQ1A35VgZcgnO1lMFHw0YueFyfqn6Gi0Csllevy1veAryofhGi2SPe1Tp0H4IVvccg%3D%3D";
  const latitude = document.querySelector("#latitude").innerText;
  const longitude = document.querySelector("#longitude").innerText;
  const pharmacyNumber = 5;
  const radius = 2000;
  const handlingCORS = "https://cors-anywhere.herokuapp.com/";

  const pharmacyList = [];

  if (latitude == "" || longitude == "") {
    alert("먼저 현재 위치를 찾으세요!");
    return;
  }

  $.ajax({
    url: `${handlingCORS}http://apis.data.go.kr/B551182/pharmacyInfoService/getParmacyBasisList?numOfRows=${pharmacyNumber}&xPos=${longitude}&yPos=${latitude}&radius=${radius}&ServiceKey=${PHARMACY_API_KEY}`,
    type: "GET",
    dataType: "json",
    success: function (data) {
      console.log("Ajax 요청 성공");

      //약국 5개 찾기
      for (let i = 0; i < pharmacyNumber; i++) {
        const pharmacyName = data.response.body.items.item[i].yadmNm;
        const pharmacyAddr = data.response.body.items.item[i].addr;
        const pharmacyLng = data.response.body.items.item[i].XPos;
        const pharmacyLat = data.response.body.items.item[i].YPos;

        //pharmacyList에 병원 추가
        const tmp = {};
        tmp.name = pharmacyName;
        tmp.addr = pharmacyAddr;
        tmp.longitude = pharmacyLng;
        tmp.latitude = pharmacyLat;
        pharmacyList[i] = tmp;

        $("#pharmacy-list").append(
          "<li><div>" +
            pharmacyName +
            "</div><div>" +
            pharmacyAddr +
            "</div></li>"
        );
      }

      console.log(pharmacyList);

      //지도에 병원 5개 표시
      var mapContainer = document.getElementById("pharmacy-map");
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

      for (let i = 0; i < pharmacyNumber; i++) {
        var imageSize = new kakao.maps.Size(24, 35);
        var markerImage = new kakao.maps.MarkerImage(imageSrc, imageSize);
        var marker = new kakao.maps.Marker({
          map: map,
          position: new kakao.maps.LatLng(
            pharmacyList[i].latitude,
            pharmacyList[i].longitude
          ),
          title: pharmacyList[i].name,
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
  .querySelector("#find-pharmacy")
  .addEventListener("click", findPharmacy);
