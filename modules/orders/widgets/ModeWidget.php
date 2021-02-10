<?php

namespace orders\widgets;

use orders\helpers\LinkHelper;
use yii\base\Widget;
use yii\helpers\ArrayHelper;


class ModeWidget extends Widget
{
    public $modes;
    public $filters;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $modesArray = [];

        foreach ($this->modes as $alias => $number) {
            $modesArray[$number] = [
                'name' => $alias,
                'isActive' => false,
                'link' => LinkHelper::generateLink('index', ['name'=>'mode', 'value' => $alias], $this->filters)
            ];
        }

        if (ArrayHelper::keyExists('mode', $this->filters)) {
            $elementIndex = $this->filters['mode'] !== 'all' && $this->filters['mode'] !== null ? array_search(
                    $this->filters['mode'],
                    array_column($modesArray, 'name')
                ) - 1 : null;
        } else {
            $elementIndex = null;
        }


        $modesArray[$elementIndex]['isActive'] = true;


        return $this->render(
            'modeWidget',
            [
                'modes' => $modesArray
            ]
        );
    }
}