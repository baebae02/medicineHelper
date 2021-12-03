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

    if($changeRatio > 0) {
        array_push($plus_arr, $stockName);
    } elseif($changeRatio < 0) {
        array_push($minus_arr, $stockName);
    }
}

var_dump($minus_arr);

?>