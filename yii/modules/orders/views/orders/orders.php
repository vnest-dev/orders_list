<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\helpers\ArrayHelper;

/**
 * @var array $statuses
 * @var array $servicesCounts
 * @var array $modes
 * @var yii\data\ActiveDataProvider $dataProvider
 */
?>

<div class="container-fluid">
    <ul class="nav nav-tabs p-b">
        <li class="<?= !ArrayHelper::keyExists('status', Yii::$app->request->get()) ? 'active' : '' ?>">
            <a href="<?= Url::toRoute(['index', 'status' => null]) ?>"><?= Yii::t('app', 'All orders') ?></a>
        </li>
        <?php
        foreach ($statuses as $status => $value): ?>
            <li class="<?= Yii::$app->request->get('status') === $value ? 'active' : '' ?>"><a
                        href="<?= Url::toRoute(['index', 'status' => $value]) ?>"><?= Yii::t(
                        'app',
                        ucfirst($status)
                    ) ?></a>
            </li>
        <?php
        endforeach; ?>

        <li class="pull-right custom-search">
            <form class="form-inline"
                  action="<?= Url::toRoute('index') ?>"
                  method="get">
                <div class="input-group">
                    <?php
                    if (ArrayHelper::keyExists('status', Yii::$app->request->get())): ?>
                        <input type="text" name="status" value="<?= Yii::$app->request->get('status') ?>" hidden>
                    <?php
                    endif; ?>
                    <input type="text" name="search" class="form-control"
                           value="<?= ArrayHelper::keyExists('search', Yii::$app->request->get()) &&
                           Yii::$app->request->get('search') !== null ? Yii::$app->request->get('search') : '' ?>"
                           placeholder="Search orders">
                    <span class="input-group-btn search-select-wrap">

            <select class="form-control search-select" name="search-type">
              <option value="id" <?= ArrayHelper::keyExists('search-type', Yii::$app->request->get()) &&
              Yii::$app->request->get('search-type') === 'id' ? 'selected' : '' ?>>Order ID</option>
              <option value="link" <?= ArrayHelper::keyExists('search-type', Yii::$app->request->get()) &&
              Yii::$app->request->get('search-type') === 'link' ? 'selected' : '' ?>>Link</option>
              <option value="username" <?= ArrayHelper::keyExists('search-type', Yii::$app->request->get()) &&
              Yii::$app->request->get('search-type') === 'username' ? 'selected' : '' ?>>Username</option>
            </select>
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"
                                                                aria-hidden="true"></span></button>
            </span>
                </div>
            </form>


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
                <div class="dropdown">
                    <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        Service
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <?php
                        foreach ($servicesCounts as $service => $count): ?>
                            <li>
                                <a href="<?= Url::toRoute(
                                    ArrayHelper::merge(
                                        ['index', 'status' => Yii::$app->request->get('status')],
                                        $service !== 'All' ? ['service' => $service] : [],
                                        ArrayHelper::keyExists(
                                            'search-type',
                                            Yii::$app->request->get()
                                        ) && Yii::$app->request->get('search-type') !== null &&
                                        ArrayHelper::keyExists(
                                            'search',
                                            Yii::$app->request->get()
                                        ) && Yii::$app->request->get('search') !== null ?
                                            [
                                                'search' => Yii::$app->request->get('search'),
                                                'search-type' => Yii::$app->request->get('search-type')
                                            ] : [],
                                        ArrayHelper::keyExists(
                                            'mode',
                                            Yii::$app->request->get()
                                        ) && Yii::$app->request->get('mode') !== null ?
                                            ['mode' => Yii::$app->request->get('mode')] : []
                                    )
                                )
                                ?>">

                                    <?php
                                    if ($service === 'All'): ?>
                                        <?= $service . ' (' . $count . ')' ?>
                                    <?php
                                    else: ?>
                                        <span class="label-id"><?= $count ?></span> <?= $service ?>
                                    <?php
                                    endif; ?>
                                </a>
                            </li>
                        <?php
                        endforeach; ?>
                    </ul>
                </div>
            </th>
            <th>Status</th>
            <th class="dropdown-th">
                <div class="dropdown">
                    <button class="btn btn-th btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        Mode
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li class="<?= !ArrayHelper::keyExists('mode', Yii::$app->request->get()) ? 'active' : '' ?>"><a
                                    href="<?= Url::toRoute(
                                        ArrayHelper::merge(
                                            ['index', 'status' => Yii::$app->request->get('status')],
                                            ArrayHelper::keyExists(
                                                'search-type',
                                                Yii::$app->request->get()
                                            ) && Yii::$app->request->get('search-type') !== null &&
                                            ArrayHelper::keyExists(
                                                'search',
                                                Yii::$app->request->get()
                                            ) && Yii::$app->request->get('search') !== null ?
                                                [
                                                    'search' => Yii::$app->request->get('search'),
                                                    'search-type' => Yii::$app->request->get('search-type')
                                                ] : [],
                                            ArrayHelper::keyExists(
                                                'service',
                                                Yii::$app->request->get()
                                            ) && Yii::$app->request->get('service') !== null ?
                                                ['service' => Yii::$app->request->get('service')] : []
                                        )
                                    )
                                    ?>"><?= Yii::t('app', 'All') ?></a>
                        </li>
                        <?php
                        foreach ($modes as $mode => $value): ?>
                            <li class="<?= Yii::$app->request->get('mode') === $value ? 'active' : '' ?>"><a
                                        href="<?= Url::toRoute(
                                            ArrayHelper::merge(
                                                [
                                                    'index',
                                                    'status' => Yii::$app->request->get('status'),
                                                    'mode' => $value
                                                ],
                                                ArrayHelper::keyExists(
                                                    'search-type',
                                                    Yii::$app->request->get()
                                                ) && Yii::$app->request->get('search-type') !== null &&
                                                ArrayHelper::keyExists(
                                                    'search',
                                                    Yii::$app->request->get()
                                                ) && Yii::$app->request->get('search') !== null ?
                                                    [
                                                        'search' => Yii::$app->request->get('search'),
                                                        'search-type' => Yii::$app->request->get('search-type')
                                                    ] : [],
                                                ArrayHelper::keyExists(
                                                    'service',
                                                    Yii::$app->request->get()
                                                ) && Yii::$app->request->get('service') !== null ?
                                                    ['service' => Yii::$app->request->get('service')] : []
                                            )
                                        )
                                        ?>"><?= Yii::t('app', ucfirst($mode)) ?></a>
                            </li>
                        <?php
                        endforeach; ?>
                    </ul>
                </div>
            </th>
            <th>Created</th>
        </tr>
        </thead>
        <tbody>
        <?php

        foreach ($dataProvider->getModels() as $order): ?>
            <tr>
                <td><?= $order->id ?></td>
                <td><?= $order->users->first_name . ' ' . $order->users->last_name ?></td>
                <td class="link"><?= $order->link ?></td>
                <td><?= $order->quantity ?></td>
                <td class="service">
                    <span class="label-id"><?= $servicesCounts[$order->services->name] ?></span> <?= $order->services->name ?>
                </td>
                <td>
                    <?php
                    switch ($order->status) {
                        case 0:
                            echo "Pending";
                            break;
                        case 1:
                            echo "In progress";
                            break;
                        case 2:
                            echo "Completed";
                            break;
                        case 3:
                            echo "Canceled";
                            break;
                        case 4:
                            echo "Failed";
                            break;
                    } ?>
                </td>
                <td><?= $order->mode == 0 ? Yii::t('app', 'Manual') : Yii::t('app', 'Auto') ?></td>
                <td><?= Yii::$app->formatter->asDatetime($order->created_at, 'YYYY-mm-dd H:m:s') ?></td>
            </tr>
        <?php
        endforeach; ?>
        </tbody>
    </table>
    <div class="row">
        <div class="col-sm-8">

            <?= LinkPager::widget(
                [
                    'pagination' => $dataProvider->pagination,
                ]
            ) ?>

        </div>
        <div class="col-sm-4 pagination-counters">
            <?php
            if ($dataProvider->getTotalCount() >= Yii::$app->params['records_on_page']): ?>
                <?= $dataProvider->pagination->getOffset() + ($dataProvider->getCount() > 1 ? 1 : 0) ?>
                to <?= $dataProvider->pagination->getOffset() + $dataProvider->getCount() ?>
                of <?= $dataProvider->getTotalCount() ?>
            <?php else: ?>
                <?=  $dataProvider->getCount() ?>
            <?php
            endif; ?>
        </div>

        <?php
        if ($dataProvider->getTotalCount() > 0): ?>
            <form action="<?= Url::toRoute('index') ?>" method="post">
                <?php
                foreach (Yii::$app->request->get() as $name => $value): ?>
                    <input type="hidden" name="<?= $name ?>" value="<?= $value ?>">
                <?php
                endforeach; ?>
                <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>"
                       value="<?= Yii::$app->request->getCsrfToken() ?>"/>
                <div class="col-md-10"></div>
                <div class="col-md-2 ml-4">
                    <button type="submit" class="btn btn-primary" >Save result</button>
                </div>

            </form>
        <?php
        endif; ?>

    </div>
</div>
