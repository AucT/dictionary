<?php

use App\Services\SaveAndroidStrings;

require __DIR__ . '/vendor/autoload.php';

$fileList = glob('storage/*');

//Loop through the array that glob returned.
foreach($fileList as $appFolder){
    //Simply print them out onto the screen.
    echo "$appFolder START!", PHP_EOL;

    $appFolder = str_replace('storage/', '', $appFolder);

    if ($appFolder == 'youtube' || $appFolder == 'app_example' || $appFolder == 'Clock_v6.1.1 (238466778)_apkpure.com-slim') {
        continue;
    }

    if (!file_exists("storage/$appFolder/AndroidManifest.xml")) {
        echo "$appFolder manifest doesn't exist" . PHP_EOL;
        continue;
    }

    $config = [];
    preg_match('/(.*?)_/', $appFolder, $output_array);
    $config['name'] = $output_array[1] ?? 'Unknown_'.time();

    preg_match('/_(.*?)_/', $appFolder, $output_array);
    $config['version'] = $output_array[1] ?? 'Unknown_'.time();


    $a = \App\Services\XmlToArray::xmlToArray(new SimpleXMLElement(file_get_contents("storage/$appFolder/AndroidManifest.xml")));
    $config['package'] = $a['manifest']['attributes']['package'] ?? 'Unknown_'.time();

    SaveAndroidStrings::saveStrings("storage/$appFolder", $config['package'], $config['name'], $config['version'] ?? '');
    if (!file_exists("storage/$appFolder/uk/plurals.xml")) {
        echo "$appFolder plurals doesn't exist" . PHP_EOL;
        continue;
    }
    SaveAndroidStrings::savePlurals("storage/$appFolder", $config['package'], $config['name'], $config['version'] ?? '');
    echo "$appFolder DONE!", PHP_EOL;
}