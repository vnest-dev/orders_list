<?php

namespace orders\widgets;

use yii\base\Widget;

class SearchWidget extends Widget
{

    public $filters;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render(
            'searchWidget',
            [
                'filters' => $this->filters
            ]
        );
    }

}