<?php


namespace App\Repositories;

use App\Services\SimplePdo;

class WordRepository
{

    public static function getWordEnId($word)
    {
        $id = SimplePdo::run("SELECT id FROM word_en WHERE name = ?", [$word])->fetchColumn();

        if (!$id) {

            SimplePdo::run("INSERT INTO word_en(name) VALUES (?)",
                [$word]);
            $id = SimplePdo::lastInsertId();
        }
        return $id;
    }

    public static function getWordUkId($word)
    {
        $id = SimplePdo::run("SELECT id FROM word_uk WHERE name = ?", [$word])->fetchColumn();

        if (!$id) {

            SimplePdo::run("INSERT INTO word_uk(name) VALUES (?)",
                [$word]);
            $id = SimplePdo::lastInsertId();
        }
        return $id;
    }

    public static function connectWords($wordUk, $wordEn, $app, $item, $plural_group = 0)
    {
        $wordUk = str_replace('\"', '"', $wordUk);
        $wordUk = trim($wordUk, ' "\'');

        $wordEn = str_replace('\"', '"', $wordEn);
        $wordEn = trim($wordEn, ' "\'');

        $wordEn = ascii($wordEn);
        if (strlen($wordEn) > 767) {
            SimplePdo::run("INSERT INTO word_en_uk_big(word_en, word_uk, app, item, plural_group, created_at) VALUES (?, ?, ? ,?, ?, ?)",
                [
                    $wordEn,
                    $wordUk,
                    $app,
                    $item,
                    $plural_group,
                    time()
                ]);
            return;
        }

        SimplePdo::run("INSERT INTO word_en_uk(word_en, word_uk, app, item, plural_group, created_at) VALUES (?, ?, ? ,?, ?, ?)",
            [
                self::getWordEnId($wordEn),
                self::getWordUkId($wordUk),
                $app,
                $item,
                $plural_group,
                time()
            ]);
    }

    public static function search($word)
    {
        $word = trim($word);
        if (!$word) {
            return [];
        }


        $id = SimplePdo::run("SELECT id FROM word_en WHERE name = ?", [$word])->fetchColumn();

        if (!$id) {
            return [];
        }

        $all = SimplePdo::run("SELECT word_en_uk.`*`, word_uk.name AS word_uk_name, app.app_id, app.app_name FROM word_en_uk LEFT JOIN word_uk ON word_uk.id = word_en_uk.word_uk LEFT JOIN app ON app.id = word_en_uk.app WHERE word_en = ?", [$id])->fetchAll(\PDO::FETCH_ASSOC);
        return $all;

    }

    public static function searchFuzzy($word)
    {

        $data = [];
        $word = trim($word);
        $word = "%{$word}%";
        if ($word) {
            $data = SimplePdo::run("SELECT name FROM word_en WHERE name LIKE ? LIMIT 30", [$word])->fetchAll(\PDO::FETCH_COLUMN);
        }

        return $data;
    }

    public static function savePluralWord($plural_group, $quantity, $lang, $value)
    {
        SimplePdo::run("INSERT INTO plural(plural_group, quantity, lang, value, created_at) VALUES (?, ?, ? ,?, ?)",
            [
                $plural_group,
                $quantity,
                $lang,
                $value,
                time()
            ]);
    }

    public static function getPlurals($plural_group)
    {
        $all = SimplePdo::run("SELECT * FROM plural WHERE plural_group = ?", [$plural_group])->fetchAll(\PDO::FETCH_ASSOC);

        $data =[];
        foreach ($all as $item) {
            $data[$item['quantity']][$item['lang']] = $item['value'];
        }
        return $data;
    }
}