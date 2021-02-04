<?php

namespace app\modules\orders\models\search;

use app\modules\orders\models\Order;
use app\modules\orders\models\Service;
use app\modules\orders\models\User;
use Yii;
use yii\data\ActiveDataProvider;
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
            [['status', 'mode', 'id', 'link', 'service', 'username'], 'safe']
        ];
    }

    /**
     * @param $params
     */
    public function setFilters($params)
    {
        $filtersList = ['status', 'mode', 'service'];
        foreach ($filtersList as $filter) {
            if (array_key_exists($filter, $params) && $params[$filter] !== null) {
                $this->$filter = $params[$filter];
            }
        }

        //search set
        if (array_key_exists('search-type', $params) && $params['search-type'] !== null &&
            array_key_exists('search', $params) && $params['search'] !== null) {
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
        $servicesCounts = Order::find()->select(['s.name', 'count(s.name) as count'])
            ->joinWith('services s')
            ->groupBy('s.name')
            ->createCommand()
            ->queryAll();
        $allServicesCount = Order::find()->select(['count(*) as count'])->createCommand()->queryOne()['count'];

        $servicesCounts = ArrayHelper::map($servicesCounts, 'name', 'count');
        ArrayHelper::setValue($servicesCounts, 'All', $allServicesCount);

        arsort($servicesCounts);

        return $servicesCounts;
    }


    /**
     * Search function for orders
     *
     * @return ActiveDataProvider
     */
    public function search()
    {
        $query = Order::find()
            ->with(['users', 'services'])
            ->alias('o');


        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
                'pagination' => [
                    'pagesize' => Yii::$app->params['records_on_page']
                ]
            ]
        );

        $dataProvider->setSort(
            [
                'defaultOrder' => [
                    'id' => 'SORT_DESC'
                ]
            ]
        );

        if ($this->status !== null) {
            $query->andFilterWhere(['=', 'status', $this->status]);
        }

        if ($this->mode !== null) {
            $query->andFilterWhere(['=', 'mode', $this->mode]);
        }

        if ($this->id !== null) {
            $query->andFilterWhere(['=', 'o.id', $this->id]);
        }

        if ($this->link !== null) {
            $query->andFilterWhere(['like', 'link', $this->link]);
        }

        if ($this->service !== null) {
            $query->andFilterWhere(['=', 's.name', $this->service]);
        }

        if ($this->username !== null) {
            if (count(explode(' ', $this->username)) === 2) {
                $query->andFilterWhere(['like', "concat_ws(' ', first_name, last_name)", $this->username]);
            } else {
                $query->andFilterWhere(['like', 'first_name', $this->username]);
                $query->orFilterWhere(['like', 'last_name', $this->username]);
            }
        }

        $query->joinWith('services s');
        $query->joinWith('users u');


        return $dataProvider;
    }
}