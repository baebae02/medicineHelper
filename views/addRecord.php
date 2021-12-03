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
    <title>addRecord</title>
</head>
<body>
    <div class="container">
        <div class="result">

        </div>
        <div class="result">
            <div id="text">제품명</div>
            <input id="input" placeholder="제품명을 입력해주세요"/>
            <div id="text">효능</div>
            <input id="input" placeholder="효능을 입력해주세요"/>
            <div id="text">복용법</div>
            <input id="input" placeholder="복용법을 입력해주세요"/>
            <div id="text">알람 여부</div>
            <div>
                <input type="radio" id="on" name="rr" />
                <label for="on"><span></span>알람 ⭕️</label>
                <input type="radio" id="off" name="rr" />
                <label for="off"><span></span>알람 ❌</label>
            </div>
        </div>
    </div>
</body>
</html>

<style>
@import url('https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@300&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Black+Han+Sans&family=Noto+Sans+KR:wght@300&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Do+Hyeon&display=swap');
* {font-family:  sans-serif;  background-color: #f5f5ff; }

.container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 20px;
}
.result {
    box-shadow: 3px 3px 3px 3px #e7e7e7;
    margin: 20px auto;
    border-radius: 15px;
    padding: 20px;
    background-color: white;
    display: grid;
    grid-template-columns: 200px 300px;
    row-gap: 10px;
}
.result div {
    background-color: white;
}
.result input {
    border: none;
    background-color: white;
}
.result label {
    background-color: white;
}
</style>