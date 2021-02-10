<?php

namespace orders\widgets;

use Yii;
use yii\base\Widget;
use yii\data\ActiveDataProvider;

class PageWidget extends Widget
{

    public ActiveDataProvider $dataProvider;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        if ($this->dataProvider->getTotalCount() >= Yii::$app->params['records_on_page']) {
            $pages = $this->dataProvider->pagination->getOffset() + ($this->dataProvider->getCount() > 1 ? 1 : 0) .
                (' to ' . ($this->dataProvider->pagination->getOffset() + $this->dataProvider->getCount())) . ' of ' .
                $this->dataProvider->getTotalCount();
        } else {
            $pages = $this->dataProvider->getCount();
        }
        return $this->render(
            'pageWidget',
            [
                'pages' => $pages
            ]
        );
    }

}