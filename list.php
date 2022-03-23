<?php

use App\Services\SaveAndroidStrings;

require __DIR__ . '/vendor/autoload.php';


$stmt = \App\Services\SimplePdo::run("SELECT * FROM app");

while ($row = $stmt->fetch()) {
    echo "{$row['app_name']}_{$row['app_version']}" . PHP_EOL;

}