<?php
    $API_KEY = "Ta6sT%2BivsJ1PVZrsEg4KJQ1A35VgZcgnO1lMFHw0YueFyfqn6Gi0Csllevy1veAryofhGi2SPe1Tp0H4IVvccg%3D%3D";
    $ch = curl_init();
    $url = "http://apis.data.go.kr/B551182/hospInfoService1/getHospBasisList1?ServiceKey=".$API_KEY;
    
    curl_setopt($ch, CURLOPT_URL, $url); //파싱 대상 설정
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

    //74781개
    $page = 1;
    while($page<7479){
        $url = "http://apis.data.go.kr/B551182/hospInfoService1/getHospBasisList1?ServiceKey=".$API_KEY;
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
            echo $page;
        }
        
        else {
            echo "Error 내용: ".$response;
        }
    
        $object = simplexml_load_string($response);
        $items = $object->body->items->item;
        
        for($i=0; $i<10; $i++){
            $info = $items[$i];
            sendQuery($info);
            echo($info->entpName);
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
        $check = mysqli_query($connect, "SELECT 1 FROM 'hospital' LIMIT 1");
        if($check == false) {
            //yadmNm 병원명
            //clCd 종별코드
            //clCdNm 종별코드명
            //sidoCd 시도코드 
            //sidoCdNm 시도명
            //sgguCd 시군구 코드
            //sgguCdNm 시군구 명
            //emdongNm 읍면동명
            //postNo 우편번호
            //addr 주소
            //telno 전화번호
            //hospUrl 홈페이지
            //drTotCnt 의사총수
            //mdeptGdrCnt 외과 일반의 일반 수 
            //mdeptSdrCnt 의과 전문의 일반 수
            //detyGdrCnt 치과 일반의 일반 수 
            //detySdrCnt 치과 전문의 일반 수
            //cmdcGdrCnt 한방 일반의 일반 수 
            //cmdcSdrCnt 한방 전문의 일반 수 
            //XPos x좌표
            //YPos y좌표
            //distance 거리
            $create_table_query = "CREATE TABLE IF NOT EXISTS hospital (
                    id MEDIUMINT NOT NULL AUTO_INCREMENT,
                    yadmNm TEXT,
                    clCd int(5),
                    clCdNm varchar(20),
                    sidoCd char(10),
                    sidoCdNm varchar(20),
                    sgguCd char(10),
                    sgguCdNm varchar(20),
                    emdongNm char(10),
                    postNo char(10),
                    addr TEXT,
                    telno TEXT,
                    hospUrl TEXT,
                    drTotCnt BIGINT,
                    mdeptGdrCnt int(200),
                    mdeptSdrCnt int(200),
                    detyGdrCnt int(200),
                    detySdrCnt int(200),
                    cmdcGdrCnt int(200),
                    cmdcSdrCnt int(200),
                    XPos FLOAT,
                    YPos FLOAT,
                    distance varchar(20),
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
        $insert_query = "INSERT INTO hospital (yadmNm, clCd, clCdNm, sidoCd, sidoCdNm, sgguCd, sgguCdNm, emdongNm,postNo, addr, telno,
        hospUrl,drTotCnt,mdeptGdrCnt,mdeptSdrCnt,detyGdrCnt,detySdrCnt,cmdcGdrCnt,cmdcSdrCnt,XPos,YPos,distance)";
        $insert_query = $insert_query . "VALUES ('" 
                                .$info->yadmNm."','".$info->clCd."','". $info->clCdNm ."','". $info->sidoCd."','".
                                $info->sidoCdNm."','". $info->sgguCd."','". $info->sgguCdNm. "','".$info->emdongNm.
                                "','".$info->postNo."','".$info->addr."','".$info->telno."','".$info->hospUrl.
                                "','".$info->drTotCnt."','".$info->mdeptGdrCnt."','".$info->mdeptSdrCnt."','".$info->detyGdrCnt.
                                "','".$info->detySdrCnt."','".$info->cmdcGdrCnt."','".$info->cmdcSdrCnt."','".$info->XPos.
                                "','".$info->YPos."','".$info->distance."')";
        
        if ($connect->query($insert_query) === TRUE) {
            // echo "New record created successfully";
        } else {
            echo "Error: " . $insert_query . "<br>" . $connect->error;
        }
        return $insert_query;
    }
?>