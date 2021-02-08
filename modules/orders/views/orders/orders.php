<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\helpers\ArrayHelper;
use orders\components\PageWidget;

/**
 * @var array $statuses
 * @var array $services
 * @var array $modes
 * @var yii\data\ActiveDataProvider $ordersDataProvider
 */
?>

<div class="container-fluid">
    <ul class="nav nav-tabs p-b">

       <?= \orders\components\StatusWidget::widget(
               [
                   'statuses' => $statuses,
                   'filters'  => $filters
               ]
       ) ?>

        <li class="pull-right custom-search">
            <?= \orders\components\SearchWidget::widget() ?>
        </li>
    </ul>
    <table class="table order-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Link</th>
            <th>Quantity</th>
            <th class="dropdown-th">
               <?= \orders\components\ServiceWidget::widget(
                       [
                               'services'=>$services,
                               //'filters'  => $filters

                       ]
               ) ?>
            </th>
            <th>Status</th>
            <th class="dropdown-th">
                <?= \orders\components\ModeWidget::widget(
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
                <td><?= $order["first_name"] . ' ' . $order["last_name"] ?></td>
                <td class="link"><?= $order["link"] ?></td>
                <td><?= $order["quantity"] ?></td>
               <td class="service">
                    <span class="label-id"><?= $services[$order["name"]] ?></span><?= $order["name"] ?>
                </td>
                <td>
                    <?= $order["status"] ?>
                </td>
                <td><?= $order["mode"] == 0 ? Yii::t('app', 'Manual') : Yii::t('app', 'Auto') ?></td>
<!--                @TODO: make date processing in search model-->
                <td><?= Yii::$app->formatter->asDatetime($order["created_at"], 'YYYY-mm-dd H:m:s') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="row">
        <div class="col-sm-8">

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

<?= \orders\components\SaveButtonWidget::widget(['dataCountOnPage' => $ordersDataProvider->getCount()]) ?>

    </div>
</div>
