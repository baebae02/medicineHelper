<?php
    $searchItem = $_GET["searchTerm"];
    $connect = mysqli_connect("localhost", "root", "cscscs", "medicine");
    if($connect -> connect_errno) {
        die("Cannot connect! " . $connect->connect_error);
    }
?>
<!DOCTYPE html>
<html>

<head>
  <title>의약품 검색</title>
  <link rel="stylesheet" type="text/css" href="./searchResult.css">
</head>

<body>
  <div class="container">
    <div class="result">
      <?php
            $sql = "SELECT * FROM info WHERE itemName like '%".$searchItem."%'";
            $sql2 = "SELECT * FROM info WHERE efcyQesitm like '%".$searchItem."%' LIMIT 10";
            $result = mysqli_query($connect, $sql);
            $result2 = mysqli_query($connect, $sql2);
            if (mysqli_num_rows($result) > 0 && mysqli_num_rows($result2) <= 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    // echo "아이디: " . $row["id"]. " 품명:" . $row["itemName"]. "<br>";
                    if ($searchItem == $row["itemName"]){
                        // echo $searchItem . "FIND"; 
                        echo "<h1>".$searchItem . "에 대한 결과는? </h1>";
                        echo "<p>💊 제품명:". $row["itemName"]. "</p>";
                        echo "<p>🏢 업체명:". $row["entpName"]. "</p>";
                        echo "<p>🤮 효능:". $row["efcyQesitm"]. "</p>";
                        echo "<p>🚫 경고:". $row["atpnQesitm"]. "</p>"; 
                        echo "<p>🩺 상호작용:". $row["intrcQesitm"]. "</p>"; 
                        echo "<p>🤮 부작용:". $row["seQesitm"]. "</p>"; 
                        echo "<p>📦 보관법:". $row["depositMethodQesitm"]. "</p>"; 
                    }
                } 
            }
            else if(mysqli_num_rows($result2) > 0){
                echo "<h1>".$searchItem."에 필요한 약은? </h1>";
                while($row = mysqli_fetch_assoc($result2)){
                    // var_dump($row);
                    echo "<p>💊 제품명:". $row["itemName"]. "</p>";
                    echo "<p>🏢 업체명:". $row["entpName"]. "</p>";
                    echo "<p>🤮 효능:". $row["efcyQesitm"]. "</p>";
                    echo "<p>🚫 경고:". $row["atpnQesitm"]. "</p>"; 
                    echo "<h2>-----------------------------------------------------------------------------------------------------------------------------------------------------------------------</h2>";
                    // echo "<p>🩺 상호작용:". $row["intrcQesitm"]. "</p>"; 
                    // echo "<p>🤮 부작용:". $row["seQesitm"]. "</p>"; 
                    // echo "<p>📦 보관법:". $row["depositMethodQesitm"]. "</p>"; 
                }
            }
            else {
                echo "<h1>검색결과가 없어요 ㅠㅠ 😭 </h1>";
                echo "<p>검색어를 확인하고 다시 입력해주세요!</p>";
                echo "<img style='width:100%;'src='../assets/Animated.gif'/>";
            }
            mysqli_close($connect); // 디비 접속 닫기
            ?>
    </div>
  </div>

</body>

</html>