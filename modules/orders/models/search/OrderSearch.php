<?php

namespace orders\models\search;

use orders\models\Order;
use orders\models\Service;
use orders\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\db\Query;
use yii\db\QueryBuilder;
use yii\helpers\ArrayHelper;

/**
 *
 * @property User $user
 * @property Service $service
 */
class OrderSearch extends Order
{

    public $service;
    public $username;

    /**
     * @return array[]
     */
    public function rules()
    {
        return [
            [['link', 'status','service', 'mode', 'id'], 'safe'],
            ['mode', 'default', 'value'=>'all'],
            ['status', 'default', 'value'=>'all orders'],
            //['service', 'default'],

            [['username'], 'trim']
        ];
    }

    /**
     * @param $params
     */
    public function setFilters($params)
    {
        //@TODO: make with yii
        unset($params['_csrf']);
        unset($params['page']);
        unset($params['per-page']);
        foreach ($params as $key => $param){
           $this->{$key} = $param;
       }
    }

    /**
     * @param $dataProvider ActiveDataProvider
     */
    public function prepareData($dataProvider)
    {
        $services =  $this->getServices();
       $models = $dataProvider->getModels();
       foreach ($models as $key => $data){
           $models[$key]['username'] = $data['first_name'] . ' ' . $data['last_name'];
           $models[$key]['status'] = ucfirst(array_search($data['status'], Order::getStatuses()));
           $models[$key]['mode'] = ucfirst(array_search($data['mode'], Order::getModes()));
           $models[$key]['service'] = '<span class="label-id">' . $services[$data['name']] . '</span> ' . $data['name'];
           $models[$key]['created_at'] = Yii::$app->formatter->asDatetime($data["created_at"], 'YYYY-mm-dd H:m:s');
       }
       $dataProvider->setModels($models);

       return $dataProvider;
    }
    
    /**
     * @param $params
     * @return array
     */
    public function getFilters()
    {
       return [
           'mode' => $this->mode,
           'status' => $this->status,
           'service' => $this->service
       ];
    }

    /**
     * Get array of all services counts
     * @return array
     * @throws \yii\db\Exception
     */
    public function getServices()
    {
        $services = (new Query())
            ->select(['s.name', 'count(s.name) as count'])
            ->from('orders o')
            ->leftJoin('services s', 'o.service_id = s.id')
            ->groupBy('s.name')
            ->createCommand()
            ->queryAll();

        $allServicesCount = (new Query())
            ->select(['count(s.name) as count'])
            ->from('orders o')
            ->leftJoin('services s', 'o.service_id = s.id')
            ->scalar();

        $services = ArrayHelper::map($services, 'name', 'count');
        ArrayHelper::setValue($services, 'All', $allServicesCount);

        arsort($services);

        return $services;
    }


    /**
     * Search function for orders
     *
     * @return ActiveDataProvider
     */
    public function search()
    {
        if(!$this->validate()){
            return null;
        }
        $query = (new Query())
            ->select(['o.id', 'first_name','last_name', 'link','quantity','created_at', 'status', 'mode', 'name' ])
            ->from('orders o')
            ->leftJoin('users u', 'o.user_id = u.id')
            ->leftJoin('services s', 'o.service_id = s.id')
            ->orderBy('o.id DESC');


        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
                'pagination' => [
                    'pagesize' => Yii::$app->params['records_on_page']
                ]
            ]
        );


            $query->andFilterWhere(['=', 'status', Order::getStatuses()[$this->status]]);
            $query->andFilterWhere(['=', 'mode', Order::getModes()[$this->mode]]);
//            $query->andFilterWhere(['=', 'o.id', $this->id]);
//            $query->andFilterWhere(['like', 'link', $this->link]);
            $query->andFilterWhere(['=', 's.name', $this->service]);
//            $query->andFilterWhere(['like', "concat_ws(' ', first_name, last_name)", $this->username]);
        return $this->prepareData($dataProvider);
    }
}