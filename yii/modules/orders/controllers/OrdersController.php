<?php

namespace app\modules\orders\controllers;


use app\modules\orders\models\Order;
use app\modules\orders\models\Service;
use Yii;
use app\modules\orders\models\search\OrderSearch;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\web\Controller;
use yii2tech\csvgrid\CsvFile;
use yii2tech\csvgrid\CsvGrid;

class OrdersController extends Controller
{
    public function actionIndex()
    {
        $this->layout = 'main';

        $searchModel = new OrderSearch();
        $searchModel->setFilters(Yii::$app->request->get());
        $dataProvider = $searchModel->search();

        $servicesCounts = $searchModel->getServicesCounts();

        return $this->render('orders', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'servicesCounts' => $servicesCounts,
            'modes' => Order::getModes(),
            'statuses' => Order::getStatuses()
        ]);
    }

    public function actionGetCsv()
    {
        $this->layout = 'main';
        $searchModel = new OrderSearch();
        $searchModel->setFilters(Yii::$app->request->get());
        $dataProvider = $searchModel->search();
        $csvFile = new CsvFile(['name' => 'csv/file2.csv']);
        $size = $dataProvider->getTotalCount() / Yii::$app->params['records_on_page'];
        for ($page = 0; $page < $size; $page++) {
            $dataProvider->pagination->setPage($page);
            $providerClone = clone $dataProvider;
            foreach ($providerClone->getModels() as $item) {
                $csvFile->writeRow($item->attributes);
            }

        }
        $csvFile->close();
    }
}