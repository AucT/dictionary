## Англо-український словник іт слів
Англо-український словник іт слів, взятих з перекладів додатків android.  
[Демо](https://dictionary.auct.eu/)

## Вступ

Програма-скрипт є не автономною. Щоб не смітити сервер і через брак часу програма-перекладач не автоматизована.

## Важливо
Команди з інструкцій нижче для windows.  
Потрібно мати apktool на пк.

## Встановлення скрипту
1. git clone https://github.com/AucT/dictionary.git  
2. cd dictionary
3. composer install  
4. COPY app/Configuration.php.example app/Configuration.php
5. змінити конфіг бд
6. створити бд mysql
7. імпортувати database/dictionary.sql

## Наповнення контентом

Скрипт ручний тож вручну потрібно:  
1. створюєм тимчасову папку на пк  
2. вантажим андрої додатки (apk файли) з apkpure  
3. cmd 
``
for %f in (*.*) do call apktool d -s "%f"
``  
4. cmd
``
for /D %f in (*.*) do mkdir "%f-slim\en" && mkdir "%f-slim\uk" && COPY "%f\res\values\strings.xml" "%f-slim\en\strings.xml" && COPY "%f\res\values-uk\strings.xml" "%f-slim\uk\strings.xml" && COPY "%f\AndroidManifest.xml" "%f-slim\AndroidManifest.xml" && COPY "%f\res\values\plurals.xml" "%f-slim\en\plurals.xml" && COPY "%f\res\values-uk\plurals.xml" "%f-slim\uk\plurals.xml"
``
5. Копіюєм всі папки з суфіксом -slim в папку storage  
6. Запускаєм php seed.php

## Щодо наповнення конентом
Інструкція вище для базового швидкого використання.  
Для роботи скрипту потрібно щоб файли вашого додатку були в форматі  
``
%APP_NAME%_%APP_VERSION%_ 
``  
Наприклад
``
Google Keep Notes and Lists_v5.19.271.07.40_apkpure.com-slim
``

Струтура папки:
* AndroidManifest.xml
* en
  * strings.xml
  * plurals.xml
* uk
  * strings.xml
  * plurals.xml
  
  
І такого типу папки закинути потрібно в storage та запустити 
 ``
 php seed.php
 ``