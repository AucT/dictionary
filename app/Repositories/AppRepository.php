<?php


namespace App\Repositories;

use App\Services\SimplePdo;

class AppRepository
{

    public static function getAppId($androidApkId, $androidAppName, $androidAppVersion)
    {
        $id = SimplePdo::run("SELECT id FROM app WHERE app_id = ?", [$androidApkId])->fetchColumn();

        if (!$id) {
            SimplePdo::run("INSERT INTO app(app_id, app_name, app_version, created_at) VALUES (?, ?, ?, ?)",
                [$androidApkId, $androidAppName, $androidAppVersion, time()]);
            $id = SimplePdo::lastInsertId();
        }

        return $id;
    }
}