<?
$API_KEY =
"Ta6sT%2BivsJ1PVZrsEg4KJQ1A35VgZcgnO1lMFHw0YueFyfqn6Gi0Csllevy1veAryofhGi2SPe1Tp0H4IVvccg%3D%3D";

$ch = curl_init();
$url = 'http://apis.data.go.kr/1471000/DrbEasyDrugInfoService/getDrbEasyDrugList'; /*URL*/
$queryParams = '?' . urlencode('serviceKey') . $API_KEY; /*Service Key*/
$queryParams .= '&' . urlencode('pageNo') . '=' . urlencode('1'); /**/
$queryParams .= '&' . urlencode('numOfRows') . '=' . urlencode('3'); /**/
$queryParams .= '&' . urlencode('entpName') . '=' . urlencode('한미약품(주)'); /**/
$queryParams .= '&' . urlencode('itemName') . '=' . urlencode('한미아스피린장용정100밀리그램'); /**/
$queryParams .= '&' . urlencode('itemSeq') . '=' . urlencode('200003092'); /**/
$queryParams .= '&' . urlencode('efcyQesitm') . '=' . urlencode('이 약은 심근경색, 뇌경색, 불안정형 협심증에서 혈전 생성 억제와...'); /**/
$queryParams .= '&' . urlencode('useMethodQesitm') . '=' . urlencode('성인은 1회 1정, 1일 1회 복용합니다..'); /**/
$queryParams .= '&' . urlencode('atpnWarnQesitm') . '=' . urlencode('매일 세잔 이상 정기적 음주자가 이 약 또는 다른 해열진통제를 복용할 때는...'); /**/
$queryParams .= '&' . urlencode('atpnQesitm') . '=' . urlencode('이 약 또는 다른 살리실산제제, 진통제, 소염제, 항류마티스제에 대한 과민증 환자...'); /**/
$queryParams .= '&' . urlencode('intrcQesitm') . '=' . urlencode('다른 비스테로이드성 소염진통제 및 살리실산 제제, 일주일 동안 메토트렉세이트 15밀리그람...'); /**/
$queryParams .= '&' . urlencode('seQesitm') . '=' . urlencode('쇽 증상(예: 호흡곤란, 전신조홍, 혈관부종, 두드러기), 천식발작, 과민증(홍반)...'); /**/
$queryParams .= '&' . urlencode('depositMethodQesitm') . '=' . urlencode('습기를 피해 실온에서 보관하십시오.'); /**/
$queryParams .= '&' . urlencode('openDe') . '=' . urlencode('20200901'); /**/
$queryParams .= '&' . urlencode('updateDe') . '=' . urlencode('20200905'); /**/
$queryParams .= '&' . urlencode('type') . '=' . urlencode('xml'); /**/

curl_setopt($ch, CURLOPT_URL, $url . $queryParams); //파싱 대상 설정
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); //파싱한 결과를 string 형식으로 반환하도록 설정
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
$response = curl_exec ($ch);
  $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  echo "status code: ".$status_code."";
 
  curl_close ($ch);
  if($status_code == 200) { //정상
    echo $response;
  }
  
  else {
    echo "Error 내용: ".$response;
  }


$object = simplexml_load_string($response);
$items = $object->body->items->item;
var_dump($items); //string 형식으로 가져온 xml 파일을 object 라는 변수에 구조체 형식으로 담아줌

// var_dump($response);
?>