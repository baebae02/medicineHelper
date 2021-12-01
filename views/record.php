<?php 
    $connect = mysqli_connect("localhost", "root", "cscscs", "medicine");
    if($connect -> connect_errno) {
        die("Cannot connect! " . $connect->connect_error);
    }
    $db_medicine= mysqli_select_db($connect, 'medicine');

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="style.css" rel="stylesheet"/>
        <title>Record</title>
    </head>
    <body>
        <div class="container">
        <div class="topBar">
          <img class="logo" onclick="goIndex()" src="../assets/logo.png" style="width: 60px;"></img>
          <nav class="navBar">
            <a id="hospital" onclick="goHospital()">병원</a>
            <a id="pharmacy" onclick="goPharmacy()">약국</a>
            <a id="medicine" onclick="goMedicine()">약</a>
            <a id="store" onclick="goRecord()">기록</a>
          </nav>
        </div>
        <div class="list">
            <div class="medicine">
                <?php 
                    $sql = "SELECT * FROM record";
                    $result = mysqli_query($connect, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<div class=item>";
                            echo "<p>💊 제품명: ".$row['itemName']."</p>";
                            echo "<p>🤮 효능: ".$row['efcyQesitm']."</p>";
                            echo "<p>🥴 복용법: ".$row['useMethodQesitm']."</p>";
                            echo $row['alarm'] === '1' ? "<p>⏰ 알람여부: ⭕️ </p>" : "<p>⏰ 알람여부: ❌</p>";
                            echo "</div>";
                        }
                    }else {
                        echo "<h1>아직 등록된 약이 없어요! 😭 </h1>";
                        echo "<p>복용중인 약을 기록하고, 알람을 등록해봐요!</p>";
                        echo "<img style='width:100%;'src='../assets/Animated.gif'/>";
                        echo "<button>약 등록하러 가기</button>";
                        echo date("Y-m-d", time());
                    }
                ?>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="./script.js"></script> 
</body>
</html>
<style>
    .container {
        display: flex;
        justify-content: center;
        text-align: center;
        flex-direction: column;
    }
    .list {
        background-color: rgb(241, 241, 229);
        width: 100%;
        border-radius: 15px;
        margin: 0 auto;
    }
    .list .medicine {
        border-radius: 15px; 
        padding: 20px 20px 40px 20px; 
        margin: 10px;  
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(30%, auto));
        margin: 20px;
        background-color: white; 
    }
    .item {
        margin: 10px;
        background-color: white; 
        background-image: linear-gradient(#ffffff, #ffffff), linear-gradient(to top, rgb(214 243 242), #c3d6ed, #3186ed);
        background-origin: border-box;
        background-clip: content-box, border-box;
        border-radius: 30px; 
        padding: 8px;
        text-align: center;
    }
</style>
<script>
function alert() {
   console.log("알람등록");
}
</script>