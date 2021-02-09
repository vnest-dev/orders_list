<?php

namespace orders\widgets;

use orders\helpers\LinkHelper;
use yii\base\Widget;
use yii\db\Query;
use yii\helpers\ArrayHelper;


class ServiceWidget extends Widget
{
    public $services;
    public $filters;


    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $servicesArray = [];


        foreach ($this->services as $alias => $number) {
            $servicesArray[$number] = [
                'name' => ucfirst($alias),
                'count' => $number,
                'isActive' => false,
                'link' => LinkHelper::generateLink('index', ['name'=>'service', 'value' => $alias], $this->filters)
            ];
        }


        return $this->render(
            'serviceWidget',
            [
                'services' => $servicesArray
            ]
        );
    }
}