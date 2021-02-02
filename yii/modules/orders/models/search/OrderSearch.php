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
            [['status'], 'safe']
        ];
    }

    public function search($params)
    {
        $query = Order::find()->with('users');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pagesize' => 100
            ]
        ]);

        if(array_key_exists('status', $params) && $params['status'] !== null){
            $this->status = $params['status'];
        }


            $query->andFilterWhere(['like', 'status', $this->status]);



        return $dataProvider;
    }
}