<?php

namespace orders\components;

use yii\base\Widget;
use yii\db\Query;
use yii\helpers\ArrayHelper;


class ServiceWidget extends Widget
{
    public $services;
    public $filter;


    public function init()
    {
        parent::init();
    }

    public function run()
    {
        parent::run();


        return $this->render(
            'serviceWidget',
            [
                'services' => $this->services
            ]
        );
    }
}