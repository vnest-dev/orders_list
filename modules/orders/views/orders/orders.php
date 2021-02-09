<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\helpers\ArrayHelper;
use orders\widgets\PageWidget;

/**
 * @var array $statuses
 * @var array $services
 * @var array $modes
 * @var yii\data\ActiveDataProvider $ordersDataProvider
 */
?>

<div class='container-fluid'>
    <ul class='nav nav-tabs p-b'>

       <?= \orders\widgets\StatusWidget::widget(
               [
                   'statuses' => $statuses,
                   'filters'  => $filters
               ]
       ) ?>

        <li class='pull-right custom-search'>
            <?= \orders\widgets\SearchWidget::widget() ?>
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
               <?= \orders\widgets\ServiceWidget::widget(
                       [
                               'services'=>$services,
                               'filters'  => $filters

                       ]
               ) ?>
            </th>
            <th>Status</th>
            <th class='dropdown-th'>
                <?= \orders\widgets\ModeWidget::widget(
                        [
                                'modes'=>$modes,
                                'filters'  => $filters

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

<?= \orders\widgets\SaveButtonWidget::widget(['dataCountOnPage' => $ordersDataProvider->getCount()]) ?>

    </div>
</div>
