<?php

use app\modules\orders\models\Order;
use yii\helpers\Url;
use yii\widgets\LinkPager;


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link href="../../../../../../../Downloads/html/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../../../../../../Downloads/html/css/custom.css" rel="stylesheet">
    <style>
        .label-default {
            border: 1px solid #ddd;
            background: none;
            color: #333;
            min-width: 30px;
            display: inline-block;
        }
    </style>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<nav class="navbar navbar-fixed-top navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="bs-navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Orders</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container-fluid">
    <ul class="nav nav-tabs p-b">
        <li class="<?= !array_key_exists('status', Yii::$app->request->get()) ? 'active' : '' ?>">
            <a href="<?= Url::toRoute(['index', 'status' => null]) ?>"><?= Yii::t('app', 'All orders') ?></a>
        </li>
        <li class="<?= Yii::$app->request->get('status') === Order::STATUS_PENDING ? 'active' : '' ?>"><a
                    href="<?= Url::toRoute(['index', 'status' => Order::STATUS_PENDING]) ?>"><?= Yii::t('app', 'Pending') ?></a>
        </li>
        <li class="<?= Yii::$app->request->get('status') === Order::STATUS_INPROGRESS ? 'active' : '' ?>"><a
                    href="<?= Url::toRoute(['index', 'status' => Order::STATUS_INPROGRESS]) ?>"><?= Yii::t('app', 'In progress') ?></a>
        </li>
        <li class="<?= Yii::$app->request->get('status') === Order::STATUS_COMPLETED ? 'active' : '' ?>"><a
                    href="<?= Url::toRoute(['index', 'status' => Order::STATUS_COMPLETED]) ?>"><?= Yii::t('app', 'Completed') ?></a>
        </li>
        <li class="<?= Yii::$app->request->get('status') === Order::STATUS_CANCELED ? 'active' : '' ?>"><a
                    href="<?= Url::toRoute(['index', 'status' => Order::STATUS_CANCELED]) ?>"><?= Yii::t('app', 'Canceled') ?></a>
        </li>
        <li class="<?= Yii::$app->request->get('status') === Order::STATUS_FAILED ? 'active' : '' ?>"><a
                    href="<?= Url::toRoute(['index', 'status' => Order::STATUS_FAILED]) ?>"><?= Yii::t('app', 'Error') ?></a>
        </li>

        <li class="pull-right custom-search">
            <form class="form-inline"
                  action="<?= Url::toRoute('index') ?>"
                  method="get">
                <div class="input-group">
                    <?php if(array_key_exists('status', Yii::$app->request->get())): ?>
                        <input type="text" name="status" value="<?= Yii::$app->request->get('status') ?>" hidden>
                    <?php endif; ?>
                        <input type="text" name="search" class="form-control" value="" placeholder="Search orders">
                    <span class="input-group-btn search-select-wrap">

            <select class="form-control search-select" name="search-type">
              <option value="id" selected="">Order ID</option>
              <option value="link">Link</option>
              <option value="username">Username</option>
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
                        <li class="active"><a href="">All (894931)</a></li>
                        <li><a href=""><span class="label-id">214</span> Real Views</a></li>
                        <li><a href=""><span class="label-id">215</span> Page Likes</a></li>
                        <li><a href=""><span class="label-id">10</span> Page Likes</a></li>
                        <li><a href=""><span class="label-id">217</span> Page Likes</a></li>
                        <li><a href=""><span class="label-id">221</span> Followers</a></li>
                        <li><a href=""><span class="label-id">224</span> Groups Join</a></li>
                        <li><a href=""><span class="label-id">230</span> Website Likes</a></li>
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
                        <li class="<?= !array_key_exists('mode', Yii::$app->request->get()) ? 'active' : '' ?>"><a
                                    href="<?= Url::toRoute(['index', 'status' => Yii::$app->request->get('status')]) ?>"><?= Yii::t('app', 'All') ?></a>
                        </li>
                        <li class="<?= Yii::$app->request->get('mode') === Order::MODE_MANUAL ? 'active' : '' ?>"><a
                                    href="<?= Url::toRoute(['index', 'status' => Yii::$app->request->get('status'), 'mode' => Order::MODE_MANUAL]) ?>"><?= Yii::t('app', 'Manual') ?></a>
                        </li>
                        <li class="<?= Yii::$app->request->get('mode') === Order::MODE_AUTO ? 'active' : '' ?>"><a
                                    href="<?= Url::toRoute(['index', 'status' => Yii::$app->request->get('status'), 'mode' => Order::MODE_AUTO]) ?>"><?= Yii::t('app', 'Auto') ?></a>
                        </li>
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
                <td><?= $order->users->first_name ?></td>
                <td class="link"><?= $order->link ?></td>
                <td><?= $order->quantity ?></td>
                <td class="service">
                    <span class="label-id">213</span><?= $order->services->name ?>
                </td>
                <td>
                    <?php switch ($order->status) {
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
                        default:
                            echo "Pending";
                            break;
                    } ?>
                </td>
                <td><?= $order->mode == 0 ? Yii::t('app', 'Manual') : Yii::t('app', 'Auto') ?></td>
                <td><?= Yii::$app->formatter->asDatetime($order->created_at, 'YYYY-mm-dd H:m:s') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="row">
        <div class="col-sm-8">

            <?= LinkPager::widget([
                'pagination' => $dataProvider->pagination,
            ]) ?>

        </div>
        <div class="col-sm-4 pagination-counters">
            <?= $dataProvider->pagination->getOffset() + 1 ?>
            to <?= $dataProvider->pagination->getOffset() + $dataProvider->pagination->getLimit() ?>
            of <?= $dataProvider->getTotalCount() ?>
        </div>

    </div>
</div>
<script src="../../../../../../../Downloads/html/js/jquery.min.js"></script>
<script src="../../../../../../../Downloads/html/js/bootstrap.min.js"></script>
</body>
<html>