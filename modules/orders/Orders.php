<?php

namespace orders;

use yii\base\Module;

/**
 * Module Orders
 * @package orders
 */
class Orders extends Module
{
    public $controllerNamespace = 'orders\controllers';
    public $layout = 'main';

    public function init()
    {
        parent::init();
        // custom initialization code goes here
    }
}