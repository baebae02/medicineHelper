<?php
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


    // //query 날리기
    // $insert_query = "INSERT INTO record (itemName, efcyQesitm, useMethodQesitm, alarm, created_at)";
    // $insert_query = $insert_query . "VALUES ('" 
    //                         .$info->yadmNm."','".$info->addr."','". $info->emdongNm."','". $info->sgguCd."','".
    //                         $info->sgguCdNm."','". $info->sidoCd."','". $info->sidoCdNm. "','".$info->clCd."','".
    //                         $info->clCdNm."','".$info->telno."','".$info->XPos."','".$info->YPos."')";
    
    //                     // ON DUPLICATE KEY UPDATE word_count=word_count+1";
    // // while(count($words) > 0) {
    // //     $insert_query = $insert_query . ",('" . array_pop($words) . "', 1)";
    // // }
    // // $insert_query = $insert_query . " ON DUPLICATE KEY UPDATE word_count=word_count+1";
    // if ($connect->query($insert_query) === TRUE) {
    //     echo "New record created successfully";
    // } else {
    //     echo "Error: " . $insert_query . "<br>" . $connect->error;
    // }
    // return $insert_query;
?>