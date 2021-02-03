<?php

namespace app\modules\orders\controllers;


use app\modules\orders\models\Order;
use app\modules\orders\models\Service;
use Yii;
use app\modules\orders\models\search\OrderSearch;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class OrdersController extends Controller
{
    public function actionIndex()
    {
        $this->layout = 'main';
        $searchModel = new OrderSearch();
        $searchModel->setFilters(Yii::$app->request->get());
        $dataProvider = $searchModel->search();

        $servicesCounts = Order::find()->select(['s.name', 'count(s.name) as count'])->joinWith('services s')->groupBy('s.name')->createCommand()->queryAll();
        $servicesCounts = ArrayHelper::map($servicesCounts, 'name', 'count');



        return $this->render('orders', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'servicesCounts' => $servicesCounts,
            'modes' => Order::getModes(),
            'statuses' => Order::getStatuses()
        ]);
    }
}