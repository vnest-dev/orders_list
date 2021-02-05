<?php

namespace app\modules\orders\models\search;

use app\modules\orders\models\Order;
use app\modules\orders\models\Service;
use app\modules\orders\models\User;
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

    private $service;
    private $username;

    /**
     * @return array[]
     */
    public function rules()
    {
        return [
            [['link', 'service', 'username'], 'safe'],
            [['status', 'mode', 'id'], 'int']
        ];
    }

    /**
     * @param $params
     */
    public function setFilters($params)
    {
        $filtersList = ['status', 'mode', 'service'];

        foreach ($filtersList as $filter) {
            if (ArrayHelper::keyExists($filter, $params) && $params[$filter] !== null) {// checking if filter is in params string
                $this->$filter = $filter === 'mode' ? Order::getModes(
                )[$params[$filter]] : ($filter === 'status' ? Order::getStatuses()[$params[$filter]] : $params[$filter]);
            }
        }

        //search sets
        if (ArrayHelper::keyExists('search', $params) && $params['search'] !== null &&
            ArrayHelper::keyExists('search-type', $params) && $params['search-type'] !== null ) {// checking if filter is in params string
            $this->{$params['search-type']} = $params['search'];
        }
    }

    /**
     * Get array of all services counts
     * @return array
     * @throws \yii\db\Exception
     */
    public function getServicesCounts()
    {
        $servicesCounts = (new Query())
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
            ->createCommand()
            ->queryOne()['count'];

        $servicesCounts = ArrayHelper::map($servicesCounts, 'name', 'count');
        ArrayHelper::setValue($servicesCounts, 'All', $allServicesCount);

        arsort($servicesCounts);

        return $servicesCounts;
    }

    public static function processStatuses($currentStatus)
    {
        $statusAliases = Order::getStatuses();

        $statusesArray = [];
        foreach ($statusAliases as $alias => $number){
            $statusesArray[$number] = [
                'name' => ucfirst($alias),
                'isActive' => $alias === $currentStatus,
                'link' => ['index', 'status' => $alias]
            ];
        }

        return $statusesArray;
    }

    public static function processFilterElements($name, $elements, $query)
    {
        if(!ArrayHelper::keyExists($name, $query) || $query[$name] === null){ // checking if filter is in query string
            $query[$name] = array_keys($elements)[0];
        }

        $modesArray = [];

        $b = $name === 'search' ? ['status' => $query['status']] : ($name === 'status' ? [] : $query);
        $link = ArrayHelper::merge(['index'], $b);

        foreach ($elements as $alias => $number){
            $link[$name] = $alias;
            $modesArray[$number] = [
                'name' => ucfirst($alias),
                'isActive' => $alias === $query[$name],
                'link' => $link
            ];
        }

        return $modesArray;
    }

    /**
     * Search function for orders
     *
     * @return ActiveDataProvider
     */
    public function search()
    {
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

            $query->andFilterWhere(['=', 'status', $this->status]);
            $query->andFilterWhere(['=', 'mode', $this->mode]);
            $query->andFilterWhere(['=', 'o.id', $this->id]);
            $query->andFilterWhere(['like', 'link', $this->link]);
            $query->andFilterWhere(['=', 's.name', $this->service]);
            $query->andFilterWhere(['like', "concat_ws(' ', first_name, last_name)", trim($this->username)]);

        return $dataProvider;
    }
}