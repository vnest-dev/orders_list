<?php

namespace orders\models;

use yii\db\ActiveRecord;

/**
 * Model for table {{ services }}
 * @package orders\models
 *
 * @property int $id
 * @property string $name
 */
class Service extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'services';
    }

    /**
     * @return array[]
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 300]
        ];
    }
}