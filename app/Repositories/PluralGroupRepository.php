<?php


namespace App\Repositories;

use App\Services\SimplePdo;

class PluralGroupRepository
{

    public static function getPluralGroupId($item, $appId)
    {
        $id = SimplePdo::run("SELECT id FROM plural_group WHERE app_id = ? AND item = ?", [$appId, $item])->fetchColumn();

        if (!$id) {
            SimplePdo::run("INSERT INTO plural_group(app_id, item, created_at) VALUES (?, ?, ?)",
                [$appId, $item, time()]);
            $id = SimplePdo::lastInsertId();
        }

        return $id;
    }
}