<?php


namespace App\Services;


use App\Repositories\AppRepository;
use App\Repositories\PluralGroupRepository;
use App\Repositories\WordRepository;

class SaveAndroidStrings
{


    public static function saveStrings($folder, $androidApkId, $androidAppName, $appVersion)
    {


        $filePathUk = $folder . '/uk/strings.xml';
        $filePathEn = $folder . '/en/strings.xml';


        $appId = AppRepository::getAppId($androidApkId, $androidAppName, $appVersion);



        $dataUk = XmlToArray::androidXmlToArray($filePathUk);
        $dataEn = XmlToArray::androidXmlToArray($filePathEn);

        foreach ($dataUk as $key=>$value) {

            if (!isset($dataEn[$key])) {
                continue;
            }

            WordRepository::connectWords($value, $dataEn[$key], $appId, $key);
        }

    }


    public static function savePlurals($folder, $androidApkId, $androidAppName, $appVersion)
    {


        $filePathUk = $folder . '/uk/plurals.xml';
        $filePathEn = $folder . '/en/plurals.xml';


        $appId = AppRepository::getAppId($androidApkId, $androidAppName, $appVersion);



        $dataUk = XmlToArray::androidPluralsXmlToArray($filePathUk);
        $dataEn = XmlToArray::androidPluralsXmlToArray($filePathEn);



        foreach ($dataUk as $groupItem=>$items) {

            if (!isset($dataEn[$groupItem])) {
                continue;
            }

            $groupId = PluralGroupRepository::getPluralGroupId($groupItem, $appId);
            $singleUk = null;
            $singleEn = null;

            foreach ($items as $item) {
                WordRepository::savePluralWord($groupId, $item['quantity'], 'uk', $item['value']);
                if ($item['quantity'] == 'one') {
                    $singleUk = $item['value'];
                }
            }

            foreach ($dataEn[$groupItem] as $item) {
                WordRepository::savePluralWord($groupId, $item['quantity'], 'en', $item['value']);
                if ($item['quantity'] == 'one') {
                    $singleEn = $item['value'];
                }
            }

            WordRepository::connectWords($singleUk, $singleEn, $appId, $groupItem, $groupId);
        }

    }


}