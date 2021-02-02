<?php

namespace app\modules\orders\models;

use yii\db\ActiveRecord;

/**
 * Model for table orders
 * @package app\modules\orders\models
 *
 * @property int $id
 * @property string $name
 */

class Service extends ActiveRecord
{

    public static function tableName()
    {
        return 'services';
    }

    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 300]
        ];
    }
}