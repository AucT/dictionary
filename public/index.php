<?php
require  '../vendor/autoload.php';
$data = [];
$plurals = [];
if (isset($_REQUEST['q'])) {
    $data = \App\Repositories\WordRepository::search($_REQUEST['q']);
} elseif (isset($_REQUEST['plural_group'])) {
    $plurals = \App\Repositories\WordRepository::getPlurals($_REQUEST['plural_group']);
}

if (isset($_REQUEST['format']) && $_REQUEST['format'] == 'json') {
    include_once '../app/resources/views/home.json.php';
    exit;
}
include_once '../app/resources/views/home.php';