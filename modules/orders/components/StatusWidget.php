<?php

namespace orders\components;

use yii\base\Widget;
use yii\helpers\ArrayHelper;

use function Webmozart\Assert\Tests\StaticAnalysis\email;


class StatusWidget extends Widget
{
    public $statuses;
    public $filters;


    public function init()
    {
        parent::init();
    }

    public function run()
    {
        parent::run();
        $statusesArray = [];


        foreach ($this->statuses as $alias => $number) {
            $statusesArray[$number] = [
                'name' => ucfirst($alias),
                'isActive' => false,
                'link' => ['index', 'status' => $alias]
            ];
        }


        if (ArrayHelper::keyExists('status', $this->filters)) {
            $elementIndex = $this->filters['status'] !== 'all orders' && $this->filters['status'] !== null ? array_search(
                    ucfirst($this->filters['status']),
                    array_column($statusesArray, 'name')
                ) - 1 : null;
        } else {
            $elementIndex = null;
        }

        $statusesArray[$elementIndex]['isActive'] = true;


        return $this->render(
            'statusWidget',
            [
                'statuses' => $statusesArray
            ]
        );
    }
}