# medicineHelper
💊 internet programming termProject

---

### Setting
1. 개발환경 
(Medicine Helper는 apache webserver와 mariadb위에서 실행됩니다.)
``` bash 
$ cd /Applications/mampstack-8.0.13-0/apache2/htdocs
$ git clone git@github.com:bread4614/medicineHelper.git
$ cd medicineHelper
```
2. manager-osx로 webserver와 mariadb를 실행

3. db에 있는 php 파일 실행
 - hospital.php // 병원 목록
 - medicine.php // 의약품 목록
 - pharamacy.php // 약국 목록
 - record.php // 복용중인 약

4. check "http://localhost:8080/termProject/views/"

* 가상환경 키는 법
```
$ . venv/bin/activate
```

### function
1. 🏥 현재 위치에서 가까운 병원 검색
2. 🏪 현재 위치에서 가까운 약국 검색
3. 🤮 증상에 따른 의약품 검색
4. 💊 명칭에 따른 의약품 검색
5. ⏰ 복용중인 약 기록 시스템(개인 알람)
6. 🔅 미니 게임 (주식 맞추기)
(1~4의 결과는 카카오톡으로 공유 가능)

