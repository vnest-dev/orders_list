<?php

namespace app\modules\orders\models;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Model for table orders
 * @package app\modules\orders\models
 *
 * @property int $id
 * @property int $user_id
 * @property string $link
 * @property int $quantity
 * @property int $service_id
 * @property int $status
 * @property int $created_at
 */
class Order extends ActiveRecord
{

    // Status constants
    const STATUS_PENDING = '0';
    const STATUS_INPROGRESS = '1';
    const STATUS_COMPLETED = '2';
    const STATUS_CANCELED = '3';
    const STATUS_FAILED = '4';

    //Mode constants
    const MODE_MANUAL = '0';
    const MODE_AUTO = '1';


    public static function tableName()
    {
        return 'orders';
    }

    public function rules()
    {
        return [
            [['user_id', 'quantity', 'service_id', 'status', 'created_at'], 'integer'],
            [['users', 'services'], 'safe'],
            [['link'], 'string', 'max' => 300]
        ];
    }

    public function getUsers()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getServices()
    {
        return $this->hasOne(Service::class, ['id' => 'service_id']);
    }
}