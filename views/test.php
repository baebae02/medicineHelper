<?php
    $searchItem = $_GET["searchTerm"];
    $connect = mysqli_connect("localhost", "root", "cscscs", "medicine");
    $searchResult;
    if($connect -> connect_errno) {
        die("Cannot connect! " . $connect -> connect_error);
    }
    $sql = "SELECT * FROM info";
    $result = mysqli_query($connect, $sql);
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            // echo "아이디: " . $row["id"]. " 품명:" . $row["itemName"]. "<br>";
            if ($searchItem == $row["itemName"]){
                // echo $searchItem . "FIND"; 
                $searchResult = $row;
            }   
        }
    }else{
    echo "테이블에 데이터가 없습니다.";
    }
    mysqli_close($connect); // 디비 접속 닫기
?>
<!DOCTYPE html>
<html>
<head>
	<title>의약품 검색</title> 
	<link rel="stylesheet" type="text/css" href="searchResult.css">
</head>
<body>
    <div class="container">
        <div class="result">
            <?php
            if(!$searchResult){
                echo "<h1>검색결과가 없어요 ㅠㅠ 😭 </h1>";
                echo "<img style='width:60%;'src='../assets/Animated.gif'/>";
            }
            else{
                echo "<h1>".$searchItem . "에 대한 결과는? </h1>";
                echo "<p>💊 제품명:". $searchResult["entpName"]. "</p>";
                echo "<p>🏢 업체명:". $searchResult["entpName"]. "</p>";
                echo "<p>🤮 효능:". $searchResult["efcyQesitm"]. "</p>";
                echo "<p>🚫 경고:". $searchResult["atpnQesitm"]. "</p>"; 
                echo "<p>🩺 상호작용:". $searchResult["intrcQesitm"]. "</p>"; 
                echo "<p>🤮 부작용:". $searchResult["seQesitm"]. "</p>"; 
                echo "<p>📦 보관법:". $searchResult["depositMethodQesitm"]. "</p>"; 
            }
        ?>
        </div>
    </div>
	
</body>
</html>