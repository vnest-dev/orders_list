<?php

use yii\widgets\LinkPager;
use orders\widgets\PageWidget;
use orders\widgets\ServiceWidget;
use orders\widgets\ModeWidget;
use orders\widgets\SearchWidget;
use orders\widgets\StatusWidget;
use orders\widgets\SaveButtonWidget;

/**
 * @var array $statuses
 * @var array $services
 * @var array $modes
 * @var array $filters
 * @var yii\data\ActiveDataProvider $ordersDataProvider
 */
?>

<div class='container-fluid'>
    <ul class='nav nav-tabs p-b'>

        <?= StatusWidget::widget(
            [
                'statuses' => $statuses,
                'filters' => $filters
            ]
        ) ?>

        <li class='pull-right custom-search'>
            <?= SearchWidget::widget(
                    [
                            'filters' => $filters
                    ]
            ) ?>
        </li>
    </ul>
    <table class='table order-table'>
        <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Link</th>
            <th>Quantity</th>
            <th class='dropdown-th'>
                <?= ServiceWidget::widget(
                    [
                        'services' => $services,
                        'filters' => $filters

                    ]
                ) ?>
            </th>
            <th>Status</th>
            <th class='dropdown-th'>
                <?= ModeWidget::widget(
                    [
                        'modes' => $modes,
                        'filters' => $filters

                    ]
                ) ?>
            </th>
            <th>Created</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($ordersDataProvider->getModels() as $order): ?>
            <tr>
                <td><?= $order['id'] ?></td>
                <td><?= $order['username'] ?></td>
                <td class='link'><?= $order['link'] ?></td>
                <td><?= $order['quantity'] ?></td>
                <td class='service'>
                    <?= $order['service'] ?>
                </td>
                <td>
                    <?= $order['status'] ?>
                </td>
                <td><?= $order['mode'] ?></td>
                <td><?= $order['created_at'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class='row'>
        <div class='col-sm-8'>

            <?= LinkPager::widget(
                [
                    'pagination' => $ordersDataProvider->pagination,
                ]
            ) ?>

        </div>

        <?= PageWidget::widget(
            [
                'dataProvider' => $ordersDataProvider
            ]
        ) ?>

        <?= SaveButtonWidget::widget(['dataCountOnPage' => $ordersDataProvider->getCount()]) ?>

    </div>
</div>
