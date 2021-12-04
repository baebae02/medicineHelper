<?php
//디비 연결
// Initialize Database
$connect = mysqli_connect("localhost", "root", "cscscs", "medicine");
if($connect -> connect_errno) {
    die("Cannot connect! " . $connect -> connect_error);
}

$sql = "SELECT * FROM record WHERE alarm = '1'";
$check = mysqli_query($connect, $sql);
print_r($check);
if (mysqli_num_rows($check) > 0) {
    while($row = mysqli_fetch_assoc($check)) {
        exec('. venv/bin/activate');
        $text=$row['itemName'];
        $link = "http://naver.com";
        exec('cd /Applications/mampstack-8.0.13-0/apache2/htdocs/termproject/api/kakao');
        exec('python3 message_text.py '.$text." ".$link , $output);
        var_dump($output);
    } 
}
print_r(mysqli_fetch_assoc($check));
?>

