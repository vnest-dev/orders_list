<?php

namespace orders\controllers;

use orders\helpers\CsvHelper;
use orders\helpers\FiltersHelper;
use orders\models\Order;
use Yii;
use orders\models\search\OrderSearch;
use yii\web\Controller;

/**
 * Class OrdersController
 * Controller for orders
 *
 * @package orders\controllers
 */
class OrdersController extends Controller
{

    public function behaviors()
    {
        return [
        'verbs' => [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'index'  => ['GET'],
                'download' => ['POST']
            ],
        ],
    ];
    }

    /**
     * Renders orders table
     *
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionIndex()
    {

        $this->layout = 'main';
        $searchModel = new OrderSearch();
        $searchModel->setFilters(Yii::$app->request->get());



        return $this->render(
            'orders',
            [
                'ordersDataProvider' => $searchModel->search(),
                'filters' => $searchModel->getFilters(),
                'modes' => $searchModel->getModes(),
                'statuses' => Order::getStatuses(),
                'services' => $searchModel->getServices(),
            ]
        );

    }

    /**
     * Sends csv file to user
     */
    public function actionDownload()
    {
            $searchModel = new OrderSearch();
            $searchModel->setFilters(Yii::$app->request->post());
            $dataProvider = $searchModel->search();
            CsvHelper::sendCsvFromBuffer($dataProvider);
    }
}