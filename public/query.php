<?php
require  '../vendor/autoload.php';
$data = [];
if (isset($_GET['q'])) {
    $data = \App\Repositories\WordRepository::searchFuzzy($_GET['q']);
}

echo json_encode($data);