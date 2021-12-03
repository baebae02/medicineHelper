<?php 

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
  for($i = 0; $i < count($stockList); $i++) { 
      $all_td_tags = $finder->query('td', $stockList[$i]);
      $stockName = (string)str_replace(" *", "", $all_td_tags->item(0)->nodeValue);
      $changeRatio = (float)str_replace($removeChar, "", $all_td_tags->item(3)->nodeValue);
      $compareWithYesterday = (int)str_replace($removeChar, "", $all_td_tags->item(2)->nodeValue);
      $nowPrice = (int)str_replace($removeChar, "", $all_td_tags->item(1)->nodeValue);

      $stockInfo = array($stockName,$changeRatio,$compareWithYesterday,$nowPrice);

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
    array("plus",$plus_arr[$answer][0],$plus_arr[$answer][1],$plus_arr[$answer][2],$plus_arr[$answer][3]), 
    array("minus",$minus_arr[$wrong1][0],$minus_arr[$wrong1][1],$minus_arr[$wrong1][2],$minus_arr[$wrong1][3]), 
    array("minus",$minus_arr[$wrong2][0],$minus_arr[$wrong2][1],$minus_arr[$wrong2][2],$minus_arr[$wrong2][3]), 
    array("minus",$minus_arr[$wrong3][0],$minus_arr[$wrong3][1],$minus_arr[$wrong3][2],$minus_arr[$wrong3][3]),
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
  <link href="stock.css?ver=2" rel="stylesheet" />
  <script type="text/javascript" src="./script.js"></script>
  <script type="text/javascript" src="./stock.js"></script>
  <title>Stock</title>
  <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
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
        <a id="stock" onclick="goStock()">게임</a>
      </nav>
    </div>
    <div id="stock-container">
      <div id="stock-title">
        주식 미니 게임
      </div>
      <div id="stock-question">
        어제에 비해 오늘 오른 주식 종목은 무엇일까요?
      </div>
      <div id="stock-list">
        <div id="stock1">
          <div class="hidden">
            <?php 
            echo ($mix_arr[0][1]);
            ?>
          </div>
          <button class="stockBtn" type="button">
            <?php
              echo ($mix_arr[0][1]);
            ?>
          </button>
        </div>
        <div id="stock2">
          <div class="hidden">
            <?php
            echo ($mix_arr[1][0]);
            ?>
          </div>
          <button class="stockBtn" type="button">
            <?php
              echo ($mix_arr[1][1]);
            ?>
          </button>
        </div>
        <div id="stock3">
          <div class="hidden">
            <?php
            echo ($mix_arr[2][0]);
            ?>
          </div>
          <button class="stockBtn" type="button">
            <?php
              echo ($mix_arr[2][1]);
            ?>
          </button>
        </div>
        <div id="stock4">
          <div class="hidden">
            <?php
            echo ($mix_arr[3][0]);
            ?>
          </div>
          <button class="stockBtn" type="button">
            <?php
              echo ($mix_arr[3][1]);
            ?>
          </button>
        </div>
      </div>
      <div id="buttons">
        <button id="result-button">결과보기</button>
        <button id="again-button" onClick="refreshPage()">다시하기</button>
      </div>
      <div id="result-container">
        <div id="result-message"></div>
        <div id="result-info"></div>
      </div>
    </div>
  </div>
</body>

</html>

<style>
.stockBtn {
  width: 200px;
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
  background-color: #fafbfc;
  border-color: #1b1f2326;
  box-shadow: rgba(27, 31, 35, 0.04) 0px 1px 0px 0px,
    rgba(255, 255, 255, 0.25) 0px 1px 0px 0px inset;
  transition: 0.2s cubic-bezier(0.3, 0, 0.5, 1);
  transition-property: color,
    background-color,
    border-color;
}

.stockBtn:hover {
  background-color: #f3f4f6;
  border-color: #1b1f2326;
  transition-duration: 0.1s;
}

.active {
  background-color: #d3e0ffc7;
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
  let selectStock = document.querySelector(".active").innerText;
  /* 정답 */
  let answerStock = "<?php echo $answer_name?>";
  let resultMessage = document.querySelector("#result-message");
  let resultInfo = document.querySelector("#result-info");

  console.log(answerStock);
  console.log(selectStock);

  if (selectStock == answerStock.trim()) {
    /* 정답 */
    resultMessage.innerText = "정답입니다!";
    resultInfo.innerText =
      "<?php echo ("종목: " . $answer_name . " 등락률: " .$answer_changeRatio. " 현재가: "  . $answer_nowPrice . " 전일비: " . $answer_compareWithYesterday)?>";

  } else {
    /* 오답 */
    resultMessage.innerText = "오답입니다!";
  }
}

resultButton.addEventListener("click", clickResultBtn);
</script>