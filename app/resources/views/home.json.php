<?php

$newData = [];

foreach ($data as $item) {
    $newData[] = [
        'ukr' => $item['word_uk_name'],
        'item' => $item['item'],
        'plural_group' => $item['plural_group'],
        'app_id' => $item['app_id'],
        'app_name' => $item['app_name'],
    ];
}
header("Content-type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
echo json_encode($newData);