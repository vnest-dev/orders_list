<?php

namespace app\modules\orders\controllers;

use app\modules\orders\helpers\CsvHelper;
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
    /**
     * Renders orders table, POST query sends csv file of curtain configuration to user
     *
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionIndex()
    {
        $this->layout = 'main';

        if (Yii::$app->request->post()) {
            $params = Yii::$app->request->post();
        } else {
            $params = Yii::$app->request->get();
        }

        $searchModel = new OrderSearch();
        $searchModel->setFilters($params);
        $dataProvider = $searchModel->search();
        $servicesCounts = $searchModel->getServicesCounts();

        if (Yii::$app->request->post()) {
            CsvHelper::sendCsvFromBuffer($dataProvider);
        }

        return $this->render(
            'orders',
            [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'servicesCounts' => $servicesCounts,
                'modes' => Order::getModes(),
                'statuses' => Order::getStatuses()
            ]
        );
    }
}