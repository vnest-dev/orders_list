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

use function Webmozart\Assert\Tests\StaticAnalysis\null;

/**
 *
 * @property User $user
 * @property Service $service
 */
class OrderSearch extends Order
{

    public $service;
    public $username;
    public $search;
    public $searchType;
    public $filters;

    /**
     * @return array[]
     */
    public function rules()
    {
        return [
            [['link', 'status','service', 'mode', 'id', 'search'], 'safe'],
            ['mode', 'default', 'value'=>'all'],
            ['mode', 'in', 'range' => array_keys(Order::getModes())],
            ['status', 'default', 'value'=>'all_orders'],
            ['status', 'in', 'range' => array_keys(Order::getStatuses())],
            ['service', 'in', 'range' => array_keys($this->getServices())],

            ['search', 'default', 'value'=>''],
            [['search'], 'trim'],
            [['search'], 'string'],

            ['searchType', 'default', 'value'=>''],
            [['searchType'], 'in', 'range' => ['username', 'link', 'id']]
        ];
    }

    /**
     * @param $params
     */
    public function setFilters($params)
    {
       $this->filters = [
           'status' => 'all_orders',
           'mode' => 'all',
           'service' => null,
           'search-type' => null,
           'search' => null,
       ];

        foreach ($params as $key => $param){
           $this->filters[$key] = $param;
       }
    }


    /**
     * @param $dataProvider ActiveDataProvider
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     */
    public function prepareData($dataProvider)
    {
        $services =  $this->getServices();
       $models = $dataProvider->getModels();
       foreach ($models as $key => $data){
           $models[$key]['username'] = $data['first_name'] . ' ' . $data['last_name'];
           $models[$key]['status'] = array_search($data['status'], Order::getStatuses());
           $models[$key]['mode'] = array_search($data['mode'], Order::getModes());
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
       return $this->filters;
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
     * Apply filters to query
     *
     * @param $query
     * @return mixed
     */
    public function applyFilters($query)
    {
        $query->andFilterWhere(['=', 'status', Order::getStatuses()[$this->filters['status']]]);
        $query->andFilterWhere(['=', 'mode', Order::getModes()[$this->filters['mode']]]);
        $query->andFilterWhere(['=', 's.name', $this->filters['service']]);

        if($this->filters['search-type'] === 'id'){
            $query->andFilterWhere(['=', 'o.id', $this->filters['search']]);
        }
        else if($this->filters['search-type'] === 'link'){
            $query->andFilterWhere(['like', 'link', $this->filters['search']]);
        }
        else if($this->filters['search-type'] === 'username'){
            $query->andFilterWhere(['like', "concat_ws(' ', first_name, last_name)", $this->filters['search']]);
        }

        return $query;
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
                'query' => $this->applyFilters($query),
                'pagination' => [
                    'pagesize' => Yii::$app->params['records_on_page']
                ]
            ]
        );

        return $this->prepareData($dataProvider);
    }
}