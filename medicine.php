<?php
$API_KEY =
"Ta6sT%2BivsJ1PVZrsEg4KJQ1A35VgZcgnO1lMFHw0YueFyfqn6Gi0Csllevy1veAryofhGi2SPe1Tp0H4IVvccg%3D%3D";
$medicineNumber = 10;

$ch = curl_init();
$url = "http://apis.data.go.kr/1471000/DrbEasyDrugInfoService/getDrbEasyDrugList?serviceKey=Ta6sT%2BivsJ1PVZrsEg4KJQ1A35VgZcgnO1lMFHw0YueFyfqn6Gi0Csllevy1veAryofhGi2SPe1Tp0H4IVvccg%3D%3D";

$queryParams = '&' . urlencode('pageNo') . '=' . urlencode('1'); /**/
// $queryParams .= '&' . urlencode('numOfRows') . '=' . urlencode('3'); /**/
// $queryParams .= '&' . urlencode('entpName') . '=' . urlencode('한미약품(주)'); /**/
// $queryParams .= '&' . urlencode('itemName') . '=' . urlencode('한미아스피린장용정100밀리그램'); /**/
// $queryParams .= '&' . urlencode('itemSeq') . '=' . urlencode('200003092'); /**/
// $queryParams .= '&' . urlencode('efcyQesitm') . '=' . urlencode('이 약은 심근경색, 뇌경색, 불안정형 협심증에서 혈전 생성 억제와...'); /**/
// $queryParams .= '&' . urlencode('useMethodQesitm') . '=' . urlencode('성인은 1회 1정, 1일 1회 복용합니다..'); /**/
// $queryParams .= '&' . urlencode('atpnWarnQesitm') . '=' . urlencode('매일 세잔 이상 정기적 음주자가 이 약 또는 다른 해열진통제를 복용할 때는...'); /**/
// $queryParams .= '&' . urlencode('atpnQesitm') . '=' . urlencode('이 약 또는 다른 살리실산제제, 진통제, 소염제, 항류마티스제에 대한 과민증 환자...'); /**/
// $queryParams .= '&' . urlencode('intrcQesitm') . '=' . urlencode('다른 비스테로이드성 소염진통제 및 살리실산 제제, 일주일 동안 메토트렉세이트 15밀리그람...'); /**/
// $queryParams .= '&' . urlencode('seQesitm') . '=' . urlencode('쇽 증상(예: 호흡곤란, 전신조홍, 혈관부종, 두드러기), 천식발작, 과민증(홍반)...'); /**/
// $queryParams .= '&' . urlencode('depositMethodQesitm') . '=' . urlencode('습기를 피해 실온에서 보관하십시오.'); /**/
// $queryParams .= '&' . urlencode('openDe') . '=' . urlencode('20200901'); /**/
// $queryParams .= '&' . urlencode('updateDe') . '=' . urlencode('20200905'); /**/
// $queryParams .= '&' . urlencode('type') . '=' . urlencode('xml'); /**/

curl_setopt($ch, CURLOPT_URL, $url . $queryParams); //파싱 대상 설정
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); //파싱한 결과를 string 형식으로 반환하도록 설정
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
$response = curl_exec ($ch);
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
echo "status code: ".$status_code."";
 
  curl_close ($ch);
  if($status_code == 200) { //정상
    echo $status_code;
  }
  
  else {
    echo "Error 내용: ".$response;
  }

$object = simplexml_load_string($response);
$items = $object->body->items->item;

//4485 
$page = 1;
while($page<450){
    $url = "http://apis.data.go.kr/1471000/DrbEasyDrugInfoService/getDrbEasyDrugList?serviceKey=Ta6sT%2BivsJ1PVZrsEg4KJQ1A35VgZcgnO1lMFHw0YueFyfqn6Gi0Csllevy1veAryofhGi2SPe1Tp0H4IVvccg%3D%3D";
    $queryParams = '&' . urlencode('pageNo') . '=' . urlencode($page); /**/

    curl_setopt($ch, CURLOPT_URL, $url . $queryParams); //파싱 대상 설정
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); //파싱한 결과를 string 형식으로 반환하도록 설정
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    $response = curl_exec ($ch);
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    echo "status code: ".$status_code."";
    
    curl_close ($ch);
    if($status_code == 200) { //정상
        echo $status_code;
    }
    
    else {
        echo "Error 내용: ".$response;
    }

    $object = simplexml_load_string($response);
    $items = $object->body->items->item;
    
    for($i=0; $i<10; $i++){
        $info = $items[$i];
        print($items[$i]->entpName) . "<br>";
        sendQuery(($items[$i]));
        // print($items[$i]->itemName) . "<br>";
        // print($items[$i]->itemSeq) . "<br>";
        // print($items[$i]->efcyQesitm) . "<br>";
        // print($items[$i]->atpnQesitm) . "<br>";
        // print($items[$i]->intrcQesitm) . "<br>";
        // print($items[$i]->seQesitm) . "<br>";
        // print($items[$i]->depositMethodQesitm) . "<br>";
    }
    $page++;
}
function sendQuery($info) {

    //디비 연결
    // Initialize Database
    $connect = mysqli_connect("localhost", "root", "cscscs");
    if($connect -> connect_errno) {
        die("Cannot connect! " . $connect -> connect_error);
    }

    // Make database the current database
    $db_medicine= mysqli_select_db($connect, 'medicine');
    if(!$db_medicine) {
        $create_db_query = "CREATE DATABASE newsinformation";
        if(mysqli_query($connect, $create_db_query)) {
            echo "Success to Create Databases :: newsinformation<br>";
        } else {
            echo "Failed to Create Databases :: newsinformation<br>";
            return;
        }
    }

    //table 존재 확인하고 없으면 생성
    $check = mysqli_query($connect, "SELECT 1 FROM 'info' LIMIT 1");
    if($check == false) {
        $create_table_query = "CREATE TABLE IF NOT EXISTS info (
                id MEDIUMINT NOT NULL AUTO_INCREMENT,
                entpName varchar(20),
                itemName TEXT,
                itemSeq int(13),
                efcyQesitm TEXT,
                atpnQesitm TEXT,
                intrcQesitm TEXT,
                seQesitm TEXT,
                depositMethodQesitm TEXT,
                PRIMARY KEY (id)
                )";
        $results = $connect->query($create_table_query);
        if($results == false) {
            echo "Error: " . $create_table_query . "<br>" . $connect->error;
        }
    } else {
        // echo "check true";
    }

    //query 날리기
    $insert_query = "INSERT INTO info (entpName, itemName, itemSeq, efcyQesitm, atpnQesitm, intrcQesitm, seQesitm, depositMethodQesitm)";
    $insert_query = $insert_query . "VALUES ('" 
                            .$info->entpName."','".$info->itemName."','". $info->itemSeq."','". $info->efcyQesitm."','".
                            $info->atpnQesitm."','". $info->intrcQesitm."','". $info->seQesitm. "','".$info->depositMethodQesitm."')";
    
                        // ON DUPLICATE KEY UPDATE word_count=word_count+1";
    // while(count($words) > 0) {
    //     $insert_query = $insert_query . ",('" . array_pop($words) . "', 1)";
    // }
    // $insert_query = $insert_query . " ON DUPLICATE KEY UPDATE word_count=word_count+1";
    if ($connect->query($insert_query) === TRUE) {
        // echo "New record created successfully";
    } else {
        echo "Error: " . $insert_query . "<br>" . $connect->error;
    }
    return $insert_query;
}
?>