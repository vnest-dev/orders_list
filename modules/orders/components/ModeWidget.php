<?php

namespace orders\components;

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
        parent::run();
        $modesArray = [];

        foreach ($this->modes as $alias => $number) {
            $modesArray[$number] = [
                'name' => ucfirst($alias),
                'isActive' => false,
                'link' => ['index', 'mode' => $alias]
            ];
        }


        if (ArrayHelper::keyExists('mode', $this->filters)) {
            $elementIndex = $this->filters['mode'] !== 'all' && $this->filters['mode'] !== null ? array_search(
                    ucfirst($this->filters['mode']),
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