<?php

use yii\db\Migration;

/**
 * Class m210202_062124_indexes_orders
 */
class m210202_062124_indexes_orders extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'fk-orders-user_id',
            'orders',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-orders-service_id',
            'orders',
            'service_id',
            'services',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'orders_status_index',
            'orders',
            'status'
        );

        $this->createIndex(
            'orders_status_mode_index',
            'orders',
            ['status', 'mode']
        );

        $this->createIndex(
            'orders_status_user_id_index',
            'orders',
            ['status', 'user_id']
        );

        $this->createIndex(
            'orders_status_service_id_index',
            'orders',
            ['status', 'service_id']
        );

        $this->createIndex(
            'orders_mode_index',
            'orders',
            'mode'
        );

        $this->createIndex(
            'orders_mode_user_id_index',
            'orders',
            ['mode', 'user_id']
        );

        $this->createIndex(
            'orders_mode_service_id_index',
            'orders',
            ['mode', 'service_id']
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-orders-user_id',
            'orders',
        );
        $this->dropForeignKey(
            'fk-orders-service_id',
            'orders',
        );

        $this->dropIndex(
            'orders_status_index',
            'orders',
        );

        $this->dropIndex(
            'orders_status_mode_index',
            'orders',
        );

        $this->dropIndex(
            'orders_status_user_id_index',
            'orders',
        );

        $this->dropIndex(
            'orders_status_service_id_index',
            'orders',
        );

        $this->dropIndex(
            'orders_mode_index',
            'orders',
        );

        $this->dropIndex(
            'orders_mode_user_id_index',
            'orders',
        );

        $this->dropIndex(
            'orders_mode_service_id_index',
            'orders',
        );

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210202_062124_indexes_orders cannot be reverted.\n";

        return false;
    }
    */
}
