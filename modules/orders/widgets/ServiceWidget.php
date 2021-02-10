<?php

namespace orders\widgets;

use orders\helpers\LinkHelper;
use yii\base\Widget;


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
                'name' => $alias === 'All' ? $alias . ' (' . $number . ')' : "<span class='label-id'>" . $number . "</span> " . $alias,
                'isActive' => false,
                'link' => LinkHelper::generateLink('index', ['name' => 'service', 'value' => $alias], $this->filters)
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