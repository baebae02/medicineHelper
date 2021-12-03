<?php 

class Stock {
    public string $name;                // 이름
    public int $nowPrice;               // 현재가
    public int $compareWithYesterday;   // 전일비
    public float $changeRatio;          // 등락률
    public int $bid;                    // 매수호가
    public int $ask;                    // 매도호가
    public int $volume;                 // 거래량
    public int $tradingValue;           // 거래대금
    public int $yesterdayVolume;        // 전일거래량

    function __construct($name, $nowPrice, $compareWithYesterday, $changeRatio, $bid, $ask, $volume, $tradingValue, $yesterdayVolume) {
        $this->name = $name;
        $this->nowPrice = $nowPrice;
        $this->compareWithYesterday = $compareWithYesterday;
        $this->changeRatio = $changeRatio;
        $this->bid = $bid;
        $this->ask = $ask;
        $this->volume = $volume;
        $this->tradingValue = $tradingValue;
        $this->yesterdayVolume = $yesterdayVolume;
    }

    function printStock() {
        echo $this->name . "\t"
        . $this->nowPrice . "\t"
        . $this->compareWithYesterday . "\t"
        . $this->changeRatio . "\t"
        . $this->bid . "\t"
        . $this->ask . "\t"
        . $this->volume . "\t"
        . $this->tradingValue . "\t"
        . $this->yesterdayVolume . "<br>";
    }

    function printStock_asHTML() {
        echo "<td>" . $this->name . "</td>";
    }
}
$allStock = array();
$result = array();
$url = "https://finance.naver.com/sise/sise_group_detail.naver?type=upjong&no=261";

$html = file_get_contents($url);
// 추가된 부분
$html = mb_convert_encoding($html, 'UTF-8', mb_detect_encoding($html, 'EUC-KR', true));

$dom = new DOMDocument("1.0", "UTF-8");
@$dom->loadHTML($html);
$finder = new DomXPath($dom);

$className = "box_type_l";
$query = "//div[@class='$className']/table/tbody/tr";
$stock = $finder->query($query);
$stockList = $finder->query($query);
$counter = 0;
$removeChar = array(",", "%");
for($i = 0; $i < count($stockList) - 2; $i++) {
    $counter++;
    $all_td_tags = $finder->query('td', $stockList[$i]);
    $classStock = new Stock(
        (string)str_replace(" *", "", $all_td_tags->item(0)->nodeValue),        // 종목명
        (int)str_replace($removeChar, "", $all_td_tags->item(1)->nodeValue),    // 현재가
        (int)str_replace($removeChar, "", $all_td_tags->item(2)->nodeValue),    // 전일비
        (float)str_replace($removeChar, "", $all_td_tags->item(3)->nodeValue),  // 등락률
        (int)str_replace($removeChar, "", $all_td_tags->item(4)->nodeValue),    // 매수호가
        (int)str_replace($removeChar, "", $all_td_tags->item(5)->nodeValue),    // 매도호가
        (int)str_replace($removeChar, "", $all_td_tags->item(6)->nodeValue),    // 거래량
        (int)str_replace($removeChar, "", $all_td_tags->item(7)->nodeValue),    // 거래대금
        (int)str_replace($removeChar, "", $all_td_tags->item(8)->nodeValue),    // 전일거래량
    );
    array_push($allStock, $classStock);
}
/*
foreach($allStock as $eachStock) {
    $eachStock->printStock();
}
*/
?>

<table class="tg" border='1' style='border-collapse:collapse; font-size: small;'>
<thead>
  <tr>
    <th>종목명</th>
    <th>현재가</th>
    <th>전일비</th>
    <th>등락률</th>
    <th>매수호가</th>
    <th>매도호가</th>
    <th>거래량</th>
    <th>거래대금</th>
    <th>전일거래량</th>
  </tr>
</thead>
<tbody>
    <?php
        foreach($allStock as $eachStock) {
            echo "<tr>";
            echo "<td>" . $eachStock->name . "</td>";
            echo "<td>" . $eachStock->nowPrice . "</td>";
            echo "<td>" . $eachStock->compareWithYesterday . "</td>";
            echo "<td>" . $eachStock->changeRatio . "</td>";
            echo "<td>" . $eachStock->bid . "</td>";
            echo "<td>" . $eachStock->ask . "</td>";
            echo "<td>" . $eachStock->volume . "</td>";
            echo "<td>" . $eachStock->tradingValue . "</td>";
            echo "<td>" . $eachStock->yesterdayVolume . "</td>";
            echo "</tr>";
        }
    ?>
</tbody>
</table>