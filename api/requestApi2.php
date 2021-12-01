<?
// 채용정보 url
$url = "http://openapi.work.go.kr/opi/opi/opia/wantedApi.do";
// 채용정보 각각의 요청변수들 - 광주광역시, 15개불러오기, 고령자
$var = "?authKey=부여받은키값&returnType=xml&startPage=&display=15&callTp=L&region=29000&pref=B&occupation=&education=&empTpGb=&career=&salTp=&minPay=&maxPay=&keyword=";
 
 
$data = file_get_contents($url . $var);
$xml  = simplexml_load_string($data);
 
 
// 전체적인 내용 출력
echo "<pre>";
print_r($xml);
echo "</pre>";
 
 
 
// 총 개수
echo $xml->total . "개 <br><br>";
 
// 반복되는 부분중에 그 특정내용 태그만 뽑아오기
foreach ($xml->wanted as $obj) {
    echo "업체 : " . $obj->company . "<br>";
    echo "월급 : " . $obj->sal . "<br><br>";
}
?>