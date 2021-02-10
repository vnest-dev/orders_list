<?php

namespace orders\controllers;

use orders\helpers\CsvHelper;
use orders\models\Order;
use orders\models\search\OrderSearch;
use Yii;
use yii\db\Exception;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\base\InvalidConfigException;

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
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['GET'],
                    'download' => ['POST']
                ],
            ],
        ];
    }

    /**
     * Renders orders table
     *
     * @return string
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $searchModel->setFilters(Yii::$app->request->get());

        Url::remember(); //запоминаем урл, чтобы использовать его параметры в методе download

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
        //берем параметры из предыдущего урла
        $params = [];
        parse_str(parse_url(Url::previous(), PHP_URL_QUERY), $params);

        $searchModel = new OrderSearch();
        $searchModel->setFilters($params);
        CsvHelper::sendCsvFromBuffer($searchModel->search());
    }
}