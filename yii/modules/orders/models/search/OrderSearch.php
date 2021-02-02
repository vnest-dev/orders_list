<?php

namespace app\modules\orders\models\search;

use app\modules\orders\models\Order;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class OrderSearch extends Order
{

    public function rules()
    {
        return [
            [['status', 'mode', 'id', 'link'], 'safe']
        ];
    }

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

    public function search()
    {
        $query = Order::find()->with(['users', 'services']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pagesize' => 100
            ]
        ]);


        if($this->status !== null){
            $query->andFilterWhere(['=', 'status', $this->status]);
        }

        if($this->mode !== null){
            $query->andFilterWhere(['=', 'mode', $this->mode]);
        }

        if($this->id !== null){
            $query->andFilterWhere(['=', 'id', $this->id]);
        }

        if($this->link !== null){
            $query->andFilterWhere(['like', 'link', $this->link]);
        }

        return $dataProvider;
    }
}