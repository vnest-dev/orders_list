<?php

namespace orders\widgets;

use yii\base\Widget;

class SearchWidget extends Widget
{

    public $filter;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        parent::run();

        return $this->render('searchWidget');
    }

}