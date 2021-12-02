<?php 

$result = array();

$url = "https://finance.naver.com/sise/sise_group_detail.naver?type=upjong&no=261";

$html = file_get_contents($url);
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

var_dump($result);

?>