<?php

$ch = curl_init();

//23852
$page = 1;
while($page<2386){
    $url = "http://apis.data.go.kr/B551182/pharmacyInfoService/getParmacyBasisList?serviceKey=Ta6sT%2BivsJ1PVZrsEg4KJQ1A35VgZcgnO1lMFHw0YueFyfqn6Gi0Csllevy1veAryofhGi2SPe1Tp0H4IVvccg%3D%3D";
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
    // print_r($items->addr);
  
    
    for($i=0; $i<10; $i++){
        $info = $items[$i];
        // print($items[$i]) . "<br>";
        print($items[$i]->yadmNm) . "<br>";
        // print($items[$i]->addr) . "<br>";
        // print($items[$i]->emdongNm) . "<br>";
        // print($items[$i]->sgguCd) . "<br>";
        // print($items[$i]->sgguCdNm) . "<br>";
        // print($items[$i]->sidoCd) . "<br>";
        // print($items[$i]->sidoCdNm) . "<br>";
        // print($items[$i]->telno) . "<br>";
        // print($items[$i]->XPos) . "<br>";
        // print($items[$i]->YPos) . "<br>";
        sendQuery($info);
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
        $create_db_query = "CREATE DATABASE medicine";
        if(mysqli_query($connect, $create_db_query)) {
            echo "Success to Create Databases :: medicine<br>";
        } else {
            echo "Failed to Create Databases :: medicine<br>";
            return;
        }
    }

    //table 존재 확인하고 없으면 생성
    $check = mysqli_query($connect, "SELECT 1 FROM 'pharamacy' LIMIT 1");
    if($check == false) {
        $create_table_query = "CREATE TABLE IF NOT EXISTS pharamacy (
                    id MEDIUMINT NOT NULL AUTO_INCREMENT,
                    yadmNm TEXT,
                    addr TEXT,
                    emdongNm char(10),
                    sgguCd char(10),
                    sgguCdNm varchar(20),
                    sidoCd char(10),
                    sidoCdNm varchar(20),
                    clCd int(5),
                    clCdNm varchar(20),
                    telno TEXT,
                    XPos FLOAT,
                    YPos FLOAT,
                    PRIMARY KEY (id)
                    )";
        $results = $connect->query($create_table_query);
        if($results == false) {
            echo "Error: " . $create_table_query . "<br>" . $connect->error;
        }
    } else {
        echo "check true";
    }

    //query 날리기
    $insert_query = "INSERT INTO pharamacy (yadmNm, addr, emdongNm, sgguCd, sgguCdNm, sidoCd, sidoCdNm, clCd, clCdNm, telno, XPos, YPos)";
    $insert_query = $insert_query . "VALUES ('" 
                            .$info->yadmNm."','".$info->addr."','". $info->emdongNm."','". $info->sgguCd."','".
                            $info->sgguCdNm."','". $info->sidoCd."','". $info->sidoCdNm. "','".$info->clCd."','".
                            $info->clCdNm."','".$info->telno."','".$info->XPos."','".$info->YPos."')";
    
                        // ON DUPLICATE KEY UPDATE word_count=word_count+1";
    // while(count($words) > 0) {
    //     $insert_query = $insert_query . ",('" . array_pop($words) . "', 1)";
    // }
    // $insert_query = $insert_query . " ON DUPLICATE KEY UPDATE word_count=word_count+1";
    if ($connect->query($insert_query) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $insert_query . "<br>" . $connect->error;
    }
    return $insert_query;
}
?>