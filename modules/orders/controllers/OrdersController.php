<?php

namespace app\modules\orders\controllers;

use app\modules\orders\helpers\CsvHelper;
use app\modules\orders\helpers\FiltersHelper;
use app\modules\orders\models\Order;
use Yii;
use app\modules\orders\models\search\OrderSearch;
use yii\web\Controller;

/**
 * Class OrdersController
 * Controller for orders
 *
 * @package app\modules\orders\controllers
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
        $dataProvider = $searchModel->search();
        $servicesCounts = $searchModel->getServicesCounts();

        $statuses = OrderSearch::processFilterElements('status', Order::getStatuses(), Yii::$app->request->get());
        $modes = OrderSearch::processFilterElements('mode', Order::getModes(), Yii::$app->request->get());


        return $this->render(
            'orders',
            [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'servicesCounts' => $servicesCounts,
                'modes' => $modes,
                'statuses' => $statuses
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