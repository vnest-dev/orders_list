<?php


namespace orders\helpers;


use yii\helpers\ArrayHelper;

class LinkHelper
{
    /**
     * Returns array of rules
     * @return array
     */
    public static function getFilterRules()
    {
        return [
            'status'  => [],
            'mode'    => ['status', 'service', 'search', 'search-type'],
            'service' => ['status', 'mode', 'search', 'search-type'],
        ];
    }


    /**
     * Generates link to filter according to rules and another filters
     * @param $action string
     * @param $filter array
     * @param $filters array
     * @return array
     */
    public static function generateLink(string $action, array $filter, array $filters)
    {
        $link = [$action, $filter['name']=>$filter['value']];
        foreach (LinkHelper::getFilterRules()[$filter['name']] as $type) {
            if(ArrayHelper::keyExists($type, $filters)){
                ArrayHelper::setValue($link, $type, $filters[$type]);
            }
        }
        return $link;
    }
}