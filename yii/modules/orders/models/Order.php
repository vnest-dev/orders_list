<?php

namespace app\modules\orders\models;

use yii\db\ActiveRecord;

/**
 * Model for table {{ orders }}
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

    public const STATUS_PENDING = '0';
    public const STATUS_INPROGRESS = '1';
    public const STATUS_COMPLETED = '2';
    public const STATUS_CANCELED = '3';
    public const STATUS_FAILED = '4';

    public const MODE_MANUAL = '0';
    public const MODE_AUTO = '1';

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['user_id', 'quantity', 'service_id', 'status', 'created_at'], 'integer'],
            [['users', 'services'], 'safe'],
            [['link'], 'string', 'max' => 300]
        ];
    }

    /**
     * Relation with users
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Relation with services
     *
     * @return \yii\db\ActiveQuery
     */
    public function getServices()
    {
        return $this->hasOne(Service::class, ['id' => 'service_id']);
    }

    /**
     * Get modes constants array
     * @return string[]
     */
    public static function getModes()
    {
        return [
            'manual' => Order::MODE_MANUAL,
            'auto' => Order::MODE_AUTO
        ];
    }

    /**
     * Get statuses constants array
     * @return string[]
     */
    public static function getStatuses()
    {
        return [
            'pending' => Order::STATUS_PENDING,
            'in progress' => Order::STATUS_INPROGRESS,
            'completed' => Order::STATUS_COMPLETED,
            'canceled' => Order::STATUS_CANCELED,
            'error' => Order::STATUS_FAILED
        ];
    }

}