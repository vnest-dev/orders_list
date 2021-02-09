<?php

namespace orders\widgets;

use orders\helpers\LinkHelper;
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
        $statusesArray = [];

        foreach ($this->statuses as $alias => $number) {
            $statusesArray[$number] = [
                'name' => ucfirst($alias),
                'isActive' => false,
                'link' => LinkHelper::generateLink('index', ['name'=>'status', 'value' => $alias], $this->filters)
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