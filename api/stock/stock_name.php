<?php 

$result = array();

$url = "https://finance.naver.com/sise/sise_group_detail.naver?type=upjong&no=261";

$html = file_get_contents($url);
$html = mb_convert_encoding($html, 'UTF-8', mb_detect_encoding($html, 'EUC-KR', true));
$dom = new DOMDocument("1.0", "UTF-8");
@$dom->loadHTML($html);
$finder = new DomXPath($dom);

$className = "name_area";
$query = "//div[@class='$className']/a";
$stockName = $finder->query($query);

$stockName_arr = iterator_to_array($stockName);

foreach($stockName_arr as $eachItem) {
    array_push($result, $eachItem->nodeValue);
}

echo "<pre>";
var_dump($result);
echo "</pre>";

?>