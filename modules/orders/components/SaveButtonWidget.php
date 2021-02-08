<?php


namespace orders\components;

use yii\base\Widget;

class SaveButtonWidget extends Widget
{
    public $dataCountOnPage;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        parent::run();
        if($this->dataCountOnPage){
            return $this->render('saveButtonWidget');
        }
        else
        {
            return null;
        }
    }
}