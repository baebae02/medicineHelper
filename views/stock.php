<?php 

  if (!is_dir('./stockImage')) {
    // dir doesn't exist, make it
    mkdir('./stockImage');
  }
  $plus_arr = array(); /* 증가한 종목 */
  $minus_arr = array(); /* 감소한 종목 */

  $url = "https://finance.naver.com/sise/sise_group_detail.naver?type=upjong&no=261";
  $html = file_get_contents($url);
  $html = mb_convert_encoding($html, 'UTF-8', mb_detect_encoding($html, 'EUC-KR', true));
  $dom = new DOMDocument("1.0", "UTF-8");
  @$dom->loadHTML($html);
  $finder = new DomXPath($dom);

  $className = "box_type_l";
  $query = "//div[@class='$className']/table/tbody/tr";
  $stock = $finder->query($query);
  $stockList = $finder->query($query); /* stock 항목들*/

  $removeChar = array(",", "%");
  for($i = 0; $i < count($stockList)-2; $i++) { 
    $all_td_tags = $finder->query('td', $stockList[$i]);
      // print_r($all_td_tags->item(0));
      $stockId = (string)preg_split("/[=]+/u", $all_td_tags->item(0)->childNodes->item(0)->childNodes->item(0)->attributes->item(0)->nodeValue)[1];
      $stockName = (string)str_replace(" *", "", $all_td_tags->item(0)->nodeValue);
      $changeRatio = (float)str_replace($removeChar, "", $all_td_tags->item(3)->nodeValue);
      $compareWithYesterday = (int)str_replace($removeChar, "", $all_td_tags->item(2)->textContent);
      $nowPrice = (int)str_replace($removeChar, "", $all_td_tags->item(1)->textContent);

      $stockInfo = array($stockName,$changeRatio,$compareWithYesterday,$nowPrice, $stockId);

      if($changeRatio > 0) {
          array_push($plus_arr, $stockInfo);
      } elseif($changeRatio < 0) {
          array_push($minus_arr, $stockInfo);
      }
  }

  $answer = rand(0,count($plus_arr)-1);

  while(true) {
    $wrong1 = rand(0,count($minus_arr)-1);
    $wrong2 = rand(0,count($minus_arr)-1);
    $wrong3 = rand(0,count($minus_arr)-1);

    // print $wrong1 ." ". $wrong2 . " " .$wrong3;

    if (($wrong1 != $wrong2)&&($wrong2 != $wrong3)) break;
  }


  $mix_arr = array(
    array("plus",$plus_arr[$answer][0],$plus_arr[$answer][1],$plus_arr[$answer][2],$plus_arr[$answer][3], $plus_arr[$answer][4]), 
    array("minus",$minus_arr[$wrong1][0],$minus_arr[$wrong1][1],$minus_arr[$wrong1][2],$minus_arr[$wrong1][3], $minus_arr[$wrong1][4]), 
    array("minus",$minus_arr[$wrong2][0],$minus_arr[$wrong2][1],$minus_arr[$wrong2][2],$minus_arr[$wrong2][3], $minus_arr[$wrong2][4]), 
    array("minus",$minus_arr[$wrong3][0],$minus_arr[$wrong3][1],$minus_arr[$wrong3][2],$minus_arr[$wrong3][3], $minus_arr[$wrong3][4]),
  );

  /* $mix_arr = array(
    array("plus",$plus_arr[$answer]), 
    array("minus",$minus_arr[$wrong1]), 
    array("minus",$minus_arr[$wrong2]), 
    array("minus",$minus_arr[$wrong3]),
  ); */


  $answer_name = $plus_arr[$answer][0];
  $answer_changeRatio = $plus_arr[$answer][1];
  $answer_compareWithYesterday = $plus_arr[$answer][2];
  $answer_nowPrice = $plus_arr[$answer][3];
  $answer_stockId = $plus_arr[$answer][4];
  

  /* 결과 */
  shuffle($mix_arr); 

  echo "<pre>";
  // var_dump($mix_arr);
  // var_dump($plus_arr);
  // var_dump($minus_arr);
  echo "</pre>";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="stock.css?ver=6" rel="stylesheet" />
  <script type="text/javascript" src="./script.js"></script>
  <!-- <script type="text/javascript" src="./stock.js"></script> -->
  <title>Stock</title>
  <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
</head>

<body>
  <div class="container">
    <div class="logo">
      <img onclick="goIndex()" src="../assets/logo.png" style="width: 300px" />
    </div>
    <div class="topBar">
      <nav class="navBar">
        <a id="hospital" onclick="goHospital()">병원</a>
        <a id="pharmacy" onclick="goPharmacy()">약국</a>
        <a id="medicine" onclick="goMedicine()">약</a>
        <a id="store" onclick="goRecord()">기록</a>
        <a id="stock" onclick="goStock()">게임</a>
      </nav>
    </div>
    <div class="text">
      <h1>주식 미니 게임</h1>
      <h3>어제에 비해 오늘 <span style="color: #cf0000;">오른</span> 주식은 무엇일까요?</h3>
    </div>
    <div id="stock-container">
      <div id="stock-list">
        <div id="stock">
          <button class="stockBtn" type="button">
            <div id="stockBtnName">
              <?php
              echo ($mix_arr[0][1]);
              ?>
            </div>
            <?php
              // echo ("<B>".$mix_arr[0][1]) . "<br></B>";
              echo "<img width=180px; height=120px; src='../api/stock/stockImage/".$mix_arr[0][5].".jpg'>";
            ?>
          </button>
        </div>
        <div id="stock">
          <button class="stockBtn" type="button">
            <div id="stockBtnName">
              <?php
              echo ($mix_arr[1][1]);
              ?>
            </div>
            <?php
              // echo ("<B>".$mix_arr[1][1]."<br></B>");
              echo "<img width=180px; height=120px;  src='../api/stock/stockImage/".$mix_arr[1][5].".jpg'>";
            ?>
          </button>
        </div>
        <div id="stock">
          <button class="stockBtn" type="button">
            <div id="stockBtnName">
              <?php
              echo ($mix_arr[2][1]);
              ?>
            </div>
            <?php
              // echo ("<B>".$mix_arr[2][1])."<br></B>";
              echo "<img width=180px; height=120px;  src='../api/stock/stockImage/".$mix_arr[2][5].".jpg'>";
            ?>
          </button>
        </div>
        <div id="stock">
          <button class="stockBtn" type="button">
            <div id="stockBtnName">
              <?php
              echo ($mix_arr[3][1]);
              ?>
            </div>
            <?php
              // echo ("<B>".$mix_arr[3][1])."<br></B>";
              echo "<img width=180px; height=120px;  src='../api/stock/stockImage/".$mix_arr[3][5].".jpg'>";
            ?>
          </button>
        </div>
      </div>
      <div id="buttons">
        <button id="result-button">결과보기</button>
        <button id="again-button" onClick="refreshPage()">다시하기</button>
      </div>
      <div id="result-container">
        <div id="result-message" style="padding: 0; margin: 0px; text-align: center;"></div>
        <div id="result-info" style="font-weight: bold; width: 400px;"></div>
      </div>
    </div>
  </div>
</body>

</html>

<style>
#stock-container {
  padding: 20px;
  background-image: url("../assets/stockImage/stock5.png");
  position: relative;
}

#stock-list {
  display: grid;
  grid-template-columns: 1fr 1fr;
}

.stockBtn {
  width: 200px;
  height: 150px;
  margin: 10px;
  display: inline-block;
  outline: 0;
  cursor: pointer;
  padding: 5px 16px;
  font-size: 14px;
  font-weight: 500;
  line-height: 20px;
  vertical-align: middle;
  border: 1px solid;
  border-radius: 6px;
  color: #24292e;

  background: rgb(255 255 255 / 0%);
  box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
  backdrop-filter: blur(8.5px);
  -webkit-backdrop-filter: blur(8.5px);
  border-radius: 10px;
  border: 1px solid rgba(255, 255, 255, 0.18);
}

/* .stockBtn img {
  width:
} */

.stockBtn:hover {
  background-color: #6172ed66;
  border-color: #0014528c;
}

.active {
  background-color: #435da5c7;
}

#buttons button {
  padding: 10px 55px;
  border-radius: 15px;
  backdrop-filter: blur(8.5px);
  -webkit-backdrop-filter: blur(8.5px);
  border-radius: 10px;
  font-weight: bold;
}

#result-button {
  background: rgb(17 129 11 / 31%);
  border: 2px solid rgb(4 18 2 / 15%);
}

#again-button {
  background: rgb(247 23 20 / 14%);
  border: 2px solid rgb(247 154 154);
}

#result-container {
  position: absolute;
  top: 30%;
  left: 50%;
  transform: translateX(-50%);

}


@keyframes move {
  0% {
    transform: translateY(0px);
  }

  25% {
    transform: translateY(7px);
  }

  50% {
    transform: translateY(-5px);
  }

  75% {
    transform: translateY(3px);
  }

  100% {
    transform: translateY(0px);
  }
}
</style>

<script>
$('.stockBtn').click(function() {
  $('.stockBtn').removeClass("active");
  $(this).addClass("active");
});

const resultButton = document.querySelector("#result-button");
const againButton = document.querySelector("#again-button");

function refreshPage() {
  /* "다시하기" 버튼 누르면 창 새로고침하기 */
  window.location.reload();
}

function clickResultBtn(event) {
  /* 정답인 종목 표시하기 */

  /* 선택한 답 */
  let selectStock = document.querySelector(".active #stockBtnName").innerText;
  /* 정답 */
  let answerStock = "<?php echo $answer_name?>";
  let resultMessage = document.querySelector("#result-message");
  let resultInfo = document.querySelector("#result-info");

  console.log("answer: " + answerStock);
  console.log("select: " + selectStock);

  if (selectStock == answerStock.trim()) {
    /* 정답 */
    resultInfo.innerText =
      "<?php echo ("종목: " . $answer_name . " 등락률: " .$answer_changeRatio. " 현재가: "  . $answer_nowPrice . " 전일비: " . $answer_compareWithYesterday)?>";
    resultText =
      "<p><?php echo ("종목: ".$answer_name." 등락률: " .$answer_changeRatio. " 현재가: "  . $answer_nowPrice . " 전일비: " . $answer_compareWithYesterday)?></p>";
    resultMessage.innerHTML =
      "<div style='padding: 10px 80px; font-size: 30px; text-shadow: 4px 0 #2514ff, 0 4px #d5f5ff, 7px 0 #a6f3ff, 0 3px #5ca6a1;'><h2>SUCESS </h2></div>";
    // resultMessage.innerHTML = 
    //   "<div style='font-size: 15px;>".resultText."</div>";
  } else {
    /* 오답 */
    resultMessage.innerHTML =
    "<div style='padding: 10px 80px; font-size: 30px; text-shadow: 4px 0 #ed3c37, 0 4px #e9e9e9, 7px 0 #eda1a1, 0 3px #dfdcb9;'><h2>FAIL</h2></div>";
  }
}

resultButton.addEventListener("click", clickResultBtn);
</script>