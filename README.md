# medicineHelper
๐ internet programming termProject

---

### Setting
1. ๊ฐ๋ฐํ๊ฒฝ 
(Medicine Helper๋ apache webserver์ mariadb์์์ ์คํ๋ฉ๋๋ค.)
``` bash 
$ cd /Applications/mampstack-8.0.13-0/apache2/htdocs
$ git clone git@github.com:bread4614/medicineHelper.git
$ cd medicineHelper
```
2. manager-osx๋ก webserver์ mariadb๋ฅผ ์คํ

3. db์ ์๋ php ํ์ผ ์คํ
 - hospital.php // ๋ณ์ ๋ชฉ๋ก
 - medicine.php // ์์ฝํ ๋ชฉ๋ก
 - pharamacy.php // ์ฝ๊ตญ ๋ชฉ๋ก
 - record.php // ๋ณต์ฉ์ค์ธ ์ฝ

4. check "http://localhost:8080/termProject/views/"

* ๊ฐ์ํ๊ฒฝ ํค๋ ๋ฒ
```
$ . venv/bin/activate
```

### function
1. ๐ฅ ํ์ฌ ์์น์์ ๊ฐ๊น์ด ๋ณ์ ๊ฒ์
2. ๐ช ํ์ฌ ์์น์์ ๊ฐ๊น์ด ์ฝ๊ตญ ๊ฒ์
3. ๐คฎ ์ฆ์์ ๋ฐ๋ฅธ ์์ฝํ ๊ฒ์
4. ๐ ๋ช์นญ์ ๋ฐ๋ฅธ ์์ฝํ ๊ฒ์
5. โฐ ๋ณต์ฉ์ค์ธ ์ฝ ๊ธฐ๋ก ์์คํ(๊ฐ์ธ ์๋)
6. ๐ ๋ฏธ๋ ๊ฒ์ (์ฃผ์ ๋ง์ถ๊ธฐ)
(1~4์ ๊ฒฐ๊ณผ๋ ์นด์นด์คํก์ผ๋ก ๊ณต์  ๊ฐ๋ฅ)

