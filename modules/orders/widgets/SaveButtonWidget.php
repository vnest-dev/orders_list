<?php


namespace orders\widgets;

use yii\base\Widget;

class SaveButtonWidget extends Widget
{
    public int $dataCountOnPage;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        if ($this->dataCountOnPage) {
            return $this->render('saveButtonWidget');
        } else {
            return null;
        }
    }
}