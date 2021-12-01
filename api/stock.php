<?php
$page = 1;
$returnValue = array(); // [0] => Previous Date, [1] => News Titles
$returnNewsTitles = array();
    $url = "https://finance.naver.com/sise/sise_group_detail.naver?type=upjong&no=261";
    //Load the HTML page
    $context=array(
        "ssl"=>array(
            "verify_peer"=>false,
            "verify_peer_name"=>false,
        ),
    ); 
    
    $html = file_get_contents($url,false, stream_context_create($context));
    //Create a new DOM document
    $dom = new DOMDocument("1.0", "UTF-8");
    @$dom->loadHTML($html);
    $finder = new DomXPath($dom);
    $classname_newsTitle="name_area";

    // // 실제로 파싱되는 부분
    $newsTitles = $finder->query("//*[contains(@class, '$classname_newsTitle')]");
    // $previousDate = $finder->query("//*[contains(@class, '$classname_previousButton')]");
    // $totalNewPages = count(iterator_to_array($newsPages)) / 2;
    $newsTitles_arr = iterator_to_array($newsTitles);
    echo "<pre>";
    var_dump($newsTitles_arr);
    echo "</pre>";
    // echo "<br>";
?>