<?php
    echo "<link rel=stylesheet href='hospital.css' type='text/css'>";
    $itemName = $_POST['itemName']; 
    $efcyQesitm = $_POST['efcyQesitm']; 
    $useMethodQesitm = $_POST['useMethodQesitm']; 
    $alarm = $_POST['alarm']; 
    $array = getdate();
    $date = $array['year']. '-'.$array['mon'].'-'.$array['mday'].' '.$array['hours'].':'.$array['minutes'].':'.$array['seconds'];

    if ($alarm == True) {
        $alarmResult = '⭕️';
    }
    else {
        $alarmResult = '❌';
    }

    echo "<div class='result' style='padding: 20px; box-shadow: 3px 3px 3px 3px #e7e7e7;  border-radius: 15px;'>";
    echo "<h2>제품명은  ".$itemName."</h2>";
    echo "<h2> 효과는 ".$efcyQesitm."</h2>";
    echo "<h2> 복용법은 ".$useMethodQesitm."</h2>";
    echo "<h2> 알람여부는 ". $alarmResult."</h2>";
    echo "<h2> 등록시간은 ". $date." 입니다.</h2>";
    echo "</div>";

    echo "<button type='button' style='width: 200px; background-color: #b9c8f3; margin: 20px; border-radius: 15px; border:none;' onclick='window.location.href=`index.html`'><h2>메인화면으로 돌아가기</h2></button>";
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
     //$dateString = date("Y-m-d", time());
     //table 존재 확인하고 없으면 생성
    $check = mysqli_query($connect, "SELECT 1 FROM 'record' LIMIT 1");
    if($check == false) {
        $create_table_query = "CREATE TABLE IF NOT EXISTS record (
                    id MEDIUMINT NOT NULL AUTO_INCREMENT,
                    itemName TEXT NOT NULL,
                    efcyQesitm TEXT, #효과
                    useMethodQesitm TEXT, #복용법 
                    alarm boolean NOT NULL, #알람여부 
                    created_at TIMESTAMP NOT NULL, 
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
    
    $insert_query = "INSERT INTO record (itemName, efcyQesitm, useMethodQesitm, alarm, created_at)";
    $insert_query = $insert_query . "VALUES ('" . $itemName . "','" .$efcyQesitm . "','" . $useMethodQesitm ."'," . $alarm .",'". $date."');";
    if ($connect->query($insert_query) === TRUE) {
        // echo "New record created successfully";
    } else {
        echo "Error: " . $insert_query . "<br>" . $connect->error;
    }
    return $insert_query;
?>