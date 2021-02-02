<?php

namespace app\modules\orders\controllers;


use app\modules\orders\models\Order;
use Yii;
use app\modules\orders\models\search\OrderSearch;
use yii\data\Pagination;
use yii\web\Controller;

class OrdersController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());


        return $this->render('orders', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionTest()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }
}