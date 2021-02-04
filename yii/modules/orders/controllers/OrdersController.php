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

class OrdersController extends Controller
{
    public function actionIndex()
    {
        $this->layout = 'main';

        if(Yii::$app->request->post()){
            $params = Yii::$app->request->post();
        }
        else {
            $params = Yii::$app->request->get();
        }

        $searchModel = new OrderSearch();
        $searchModel->setFilters($params);
        $dataProvider = $searchModel->search();


        $servicesCounts = $searchModel->getServicesCounts();

        if(Yii::$app->request->post()){
            ob_start();
            $fileName = date('YmdHis', time());
            $stream = fopen('php://output', 'a');
            header('Content-Disposition: attachment;filename="' . $fileName . '.csv"');
            $maxRecordsInOutput = intdiv($dataProvider->getTotalCount(), 10);
            $maxIterations = intdiv($dataProvider->getTotalCount(), $maxRecordsInOutput);
            $maxIterations += fmod($maxIterations, $maxRecordsInOutput) > 0 ? 1 : 0;
            for ($i = 0; $i < $maxIterations; $i++) {
                foreach ($dataProvider->query->offset($i * $maxRecordsInOutput)->limit($maxRecordsInOutput)->createCommand()->queryAll() as $key => $order) {
                    fputcsv($stream, $order);
                }
                ob_flush();
                flush();
            }
            ob_end_clean();
            exit;
        }

        return $this->render('orders', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'servicesCounts' => $servicesCounts,
            'modes' => Order::getModes(),
            'statuses' => Order::getStatuses()
        ]);
    }
}