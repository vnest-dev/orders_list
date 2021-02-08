<?php

namespace app\modules\orders\models;


use yii\db\ActiveRecord;

/**
 * Model for table {{ users }}
 * @package app\modules\orders\models
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 */
class User extends ActiveRecord
{

    public static function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return [
            [['first_name', 'last_name'], 'string', 'max' => 300]
        ];
    }
}