<?php


namespace App\Services;
use SimpleXMLElement;

class XmlToArray
{


    public static function androidXmlToArray($filepath): array
    {
        $xmlstr = file_get_contents($filepath);

        $array = self::xmlToArray(new \SimpleXMLElement($xmlstr));
        $data = [];
        foreach ($array['resources']['string'] as $item) {
            if (!isset($item['attributes']['name'])) {
                continue;
            }
            if (!isset($item['value'])) {
                continue;
            }
            $data[$item['attributes']['name']] = $item['value'];
        }

        return $data;
    }


    public static function androidPluralsXmlToArray($filepath): array
    {
        $xmlstr = file_get_contents($filepath);

        $array = self::xmlToArray(new \SimpleXMLElement($xmlstr));
        $data = [];
        foreach ($array['resources']['plurals'] as $item) {

            if (!isset($item['attributes']['name'])) {
                continue;
            }

            foreach ($item['item'] as $innerItem) {
                if (!isset($innerItem['value'])) {
                    continue;
                }


                if (!isset($innerItem['attributes']['quantity'])) {
                    continue;
                }

                $data[$item['attributes']['name']][] = [
                    'quantity' => $innerItem['attributes']['quantity'],
                    'value' => $innerItem['value']
                ];
            }
        }

        return $data;
    }



    public static function xmlToArray(SimpleXMLElement $xml): array
    {
        $parser = function (SimpleXMLElement $xml, array $collection = []) use (&$parser) {
            $nodes = $xml->children();
            $attributes = $xml->attributes();

            if (0 !== count($attributes)) {
                foreach ($attributes as $attrName => $attrValue) {
                    $collection['attributes'][$attrName] = strval($attrValue);
                }
            }

            if (0 === $nodes->count()) {
                $collection['value'] = strval($xml);
                return $collection;
            }

            foreach ($nodes as $nodeName => $nodeValue) {
                if (count($nodeValue->xpath('../' . $nodeName)) < 2) {
                    $collection[$nodeName] = $parser($nodeValue);
                    continue;
                }

                $collection[$nodeName][] = $parser($nodeValue);
            }

            return $collection;
        };

        return [
            $xml->getName() => $parser($xml)
        ];
    }
}